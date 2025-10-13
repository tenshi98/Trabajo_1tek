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
$original = "clientes_contrato_listado.php";
$location = $original;
$new_location = "clientes_contrato_listado_maquinas.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'createBasicDataMaquina';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'delBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se clona la maquina
if (!empty($_POST['clone_Maquina'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'clone_Maquina';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se edita la maquina
if (!empty($_POST['submit_edit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'updateBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//Si el estado esta distinto de vacio
if (!empty($_GET['estado'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&status='.$_GET['status'];
	//Llamamos al formulario
	$form_trabajo= 'estadoMaquina';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//formulario para editar
if (!empty($_POST['submit_config'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'updateBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//formulario para crear
if (!empty($_POST['submit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&componente='.$_GET['componente'];
	//Llamamos al formulario
	$form_trabajo= 'insert_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&componente='.$_GET['componente'];
	//Llamamos al formulario
	$form_trabajo= 'update_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_addTrabajo'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&componente='.$_GET['componente'];
	//Llamamos al formulario
	$form_trabajo= 'add_trabajo';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['del_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&componente='.$_GET['componente'];
	//Llamamos al formulario
	$form_trabajo= 'del_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['clone_compo'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&componente='.$_GET['componente'];
	//Llamamos al formulario
	$form_trabajo= 'clone_component';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//formulario para editar
if (!empty($_POST['submitMatriz'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&matriz='.$_GET['matriz'];
	//Llamamos al formulario
	$form_trabajo= 'insert_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_editMatriz'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&matriz='.$_GET['matriz'];
	$location.= '&idMatriz='.$_GET['idMatriz'];
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['delMatriz'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&matriz='.$_GET['matriz'];
	//Llamamos al formulario
	$form_trabajo= 'del_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se clona la maquina
if (!empty($_POST['clone_Matriz'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&matriz='.$_GET['matriz'];
	//Llamamos al formulario
	$form_trabajo= 'clone_Matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Dato Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Dato Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Dato Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone_idMaquina'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Clonar <?php echo 'Maquina '.$_GET['nombre_maquina']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_hidden('idMaquina', $_GET['clone_idMaquina'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c5; Clonar" name="clone_Maquina">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['clone_idMatriz'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Clonar Matriz <?php echo $_GET['nombre_matriz']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_hidden('idMatriz', $_GET['clone_idMatriz'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c5; Clonar" name="clone_Matriz">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modMatriz'])){
	//Armo cadena
	$SIS_query  = 'PuntoNombre_'.$_GET['modMatriz'].' AS Nombre';
	$SIS_query .= ',PuntoMedAceptable_'.$_GET['modMatriz'].' AS Aceptable';
	$SIS_query .= ',PuntoMedAlerta_'.$_GET['modMatriz'].' AS Alerta';
	$SIS_query .= ',PuntoMedCondenatorio_'.$_GET['modMatriz'].' AS Condenatorio';
	$SIS_query .= ',PuntoUniMed_'.$_GET['modMatriz'].' AS UniMed';
	$SIS_query .= ',PuntoidTipo_'.$_GET['modMatriz'].' AS Tipo';
	$SIS_query .= ',PuntoidGrupo_'.$_GET['modMatriz'].' AS Grupo';
	$SIS_join  = '';
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, 'idMatriz = '.$_GET['idMatriz'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Parametros</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'PuntoNombre', $rowData['Nombre'], 1);
					$Form_Inputs->form_select_depend1('Tipo', 'PuntoidTipo',  $rowData['Tipo'],  1, 'idTipo', 'Nombre', 'core_analisis_tipos', 0,  0,
											'Grupo', 'PuntoidGrupo',  $rowData['Grupo'],  1,  'idGrupo', 'Nombre', 'maquinas_listado_matriz_grupos', 0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_input_number('Aceptable','PuntoMedAceptable', Cantidades_decimales_justos($rowData['Aceptable']), 1);
					$Form_Inputs->form_input_number('Alerta','PuntoMedAlerta', Cantidades_decimales_justos($rowData['Alerta']), 1);
					$Form_Inputs->form_input_number('Condenatorio','PuntoMedCondenatorio', Cantidades_decimales_justos($rowData['Condenatorio']), 1);
					$Form_Inputs->form_select('Unidad de Medida','PuntoUniMed', $rowData['UniMed'], 1, 'idUml', 'Nombre', 'sistema_analisis_uml', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz'], 2);
					$Form_Inputs->form_input_hidden('mod', $_GET['modMatriz'], 2);
					?>

					<script>
						document.getElementById('div_PuntoMedAceptable').style.display = 'none';
						document.getElementById('div_PuntoMedAlerta').style.display = 'none';
						document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
						document.getElementById('div_PuntoUniMed').style.display = 'none';

						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)
							let Sensores_val = $("#PuntoidTipo").val();
							//si es medicion
							if(Sensores_val == 1){
								document.getElementById('div_PuntoMedAceptable').style.display = '';
								document.getElementById('div_PuntoMedAlerta').style.display = '';
								document.getElementById('div_PuntoMedCondenatorio').style.display = '';
								document.getElementById('div_PuntoUniMed').style.display = '';
							//para el resto
							} else {
								document.getElementById('div_PuntoMedAceptable').style.display = 'none';
								document.getElementById('div_PuntoMedAlerta').style.display = 'none';
								document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
								document.getElementById('div_PuntoUniMed').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="PuntoMedAceptable"]').value = '0';
								document.querySelector('input[name="PuntoMedAlerta"]').value = '0';
								document.querySelector('input[name="PuntoMedCondenatorio"]').value = '0';
								document.querySelector('input[name="PuntoUniMed"]').value = '0';

							}
						});

						$("#PuntoidTipo").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected1 = $(this).val(); //Asignamos el valor seleccionado
							//si es medicion
							if(modelSelected1 == 1){
								document.getElementById('div_PuntoMedAceptable').style.display = '';
								document.getElementById('div_PuntoMedAlerta').style.display = '';
								document.getElementById('div_PuntoMedCondenatorio').style.display = '';
								document.getElementById('div_PuntoUniMed').style.display = '';
							//para el resto
							} else {
								document.getElementById('div_PuntoMedAceptable').style.display = 'none';
								document.getElementById('div_PuntoMedAlerta').style.display = 'none';
								document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
								document.getElementById('div_PuntoUniMed').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="PuntoMedAceptable"]').value = '0';
								document.querySelector('input[name="PuntoMedAlerta"]').value = '0';
								document.querySelector('input[name="PuntoMedCondenatorio"]').value = '0';
								document.querySelector('input[name="PuntoUniMed"]').value = '0';
							}
						});

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_editMatriz">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'].'&idMatriz='.$_GET['idMatriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query  = 'Nombre,cantPuntos,
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
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, 'idMatriz = '.$_GET['idMatriz'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	//Se traen todas las unidades de medida
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUml,Nombre', 'sistema_analisis_uml', '', 'idUml!=0', 'idUml ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

	/*******************************************************/
	//Se traen todos los tipos
	$arrTipos = array();
	$arrTipos = db_select_array (false, 'idTipo,Nombre', 'core_analisis_tipos', '', 'idTipo!=0', 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');

	/*******************************************************/
	//Se consultan datos
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'maquinas_listado_matriz_grupos', '', 'idGrupo!=0', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	/*******************************************************/
	$arrFinalUnimed = array();
	$arrFinalTipos  = array();
	$arrFinalGrupos = array();
	foreach ($arrUnimed as $sen) {	$arrFinalUnimed[$sen['idUml']]   = $sen['Nombre'];}
	foreach ($arrTipos as $sen) {	$arrFinalTipos[$sen['idTipo']]   = $sen['Nombre'];}
	foreach ($arrGrupos as $sen) {	$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Puntos de Analisis</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Tipo</th>
							<th>Nombre</th>
							<th>Grupo</th>
							<th>Aceptable</th>
							<th>Alerta</th>
							<th>Condenatorio</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
							//Unidad medida
							$unimed = $arrFinalGrupos[$rowData['PuntoUniMed_'.$i]];
							$tipo   = $arrFinalTipos[$rowData['PuntoidTipo_'.$i]];
							$grupo  = $arrFinalGrupos[$rowData['PuntoidGrupo_'.$i]];
							?>
							<tr class="odd">
								<td><?php echo 'p'.$i ?></td>
								<td><?php echo $tipo; ?></td>
								<td><?php echo $rowData['PuntoNombre_'.$i]; ?></td>
								<td><?php echo $grupo; ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAceptable_'.$i]).$unimed;}else{echo 'No Aplica';} ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAlerta_'.$i]).$unimed;}else{echo 'No Aplica';} ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedCondenatorio_'.$i]).$unimed;}else{echo 'No Aplica';} ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'].'&idMatriz='.$_GET['idMatriz'].'&modMatriz='.$i; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
		<a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz_2'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query  = 'Nombre,cantPuntos';
	$SIS_join  = '';
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, 'idMatriz = '.$_GET['idMatriz_2'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación Matriz de Analisis</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;       }else{$x1  = $rowData['Nombre'];}
					if(isset($cantPuntos)){  $x2  = $cantPuntos;   }else{$x2  = $rowData['cantPuntos'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 2, 1, 50);

					$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz_2'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_editMatriz">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new_matriz'])){
	//verifico que sea un administrador
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Matriz de Analisis</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;       }else{$x1  = '';}
					if(isset($cantPuntos)){  $x2  = $cantPuntos;   }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 2, 1, 50);

					$Form_Inputs->form_input_hidden('idMaquina', $_GET['matriz'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submitMatriz">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>

			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['matriz'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query  = 'Nombre,idConfig_1, idConfig_2';
	$SIS_join  = '';
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, 'idMaquina = '.$_GET['matriz'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = 'idMatriz, Nombre,cantPuntos';
	$SIS_join  = '';
	$SIS_where = 'idMaquina = '.$_GET['matriz'];
	$SIS_order = 'Nombre ASC';
	$arrMatriz = array();
	$arrMatriz = db_select_array (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatriz');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Maquina', $rowData['Nombre'], 'Matriz Analisis'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'].'&new_matriz=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Matriz</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Matrices</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre</th>
							<th width="10">N° Puntos</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrMatriz as $maq) { ?>
						<tr class="odd">
							<td><?php echo $maq['Nombre']; ?></td>
							<td><?php echo $maq['cantPuntos']; ?></td>
							<td>
								<div class="btn-group" style="width: 140px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'].'&idMatriz_2='.$maq['idMatriz']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'].'&nombre_matriz='.$maq['Nombre'].'&clone_idMatriz='.$maq['idMatriz']; ?>" title="Clonar Matriz" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'].'&idMatriz='.$maq['idMatriz']; ?>" title="Editar Matriz" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $new_location.'&id='.$_GET['id'].'&matriz='.$_GET['matriz'].'&del='.simpleEncode($maq['idMatriz'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la matriz '.$maq['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
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
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addTrabajo'])){
	/*******************************************************/
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
		$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idAprobado=2";
	}else{
		//filtro
		$z = "idLicitacion=0";
		//Se revisan los permisos a los contratos
		$SIS_query = 'idLicitacion';
		$SIS_join  = '';
		$SIS_where = 'idUsuario = '.$_SESSION['usuario']['basic_data']['idUsuario'];
		$SIS_order = 'idLicitacion ASC';
		$arrPermisos = array();
		$arrPermisos = db_select_array (false, $SIS_query, 'usuarios_contratos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

		foreach ($arrPermisos as $prod) {
			$z .= " OR (idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idAprobado=2 AND idLicitacion=".$prod['idLicitacion'].")";
		}

	}

	//Se filtran solo las ramas de la licitacion, no las subramas con los datos
	$w = 'idUtilizable=1';

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Trabajo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idLicitacion)){     $x0  = $idLicitacion;     }else{$x0  = '';}
					if(isset($idLevel_1)){        $x1  = $idLevel_1;        }else{$x1  = '';}
					if(isset($idLevel_2)){        $x2  = $idLevel_2;        }else{$x2  = '';}
					if(isset($idLevel_3)){        $x3  = $idLevel_3;        }else{$x3  = '';}
					if(isset($idLevel_4)){        $x4  = $idLevel_4;        }else{$x4  = '';}
					if(isset($idLevel_5)){        $x5  = $idLevel_5;        }else{$x5  = '';}
					if(isset($idLevel_6)){        $x6  = $idLevel_6;        }else{$x6  = '';}
					if(isset($idLevel_7)){        $x7  = $idLevel_7;        }else{$x7  = '';}
					if(isset($idLevel_8)){        $x8  = $idLevel_8;        }else{$x8  = '';}
					if(isset($idLevel_9)){        $x9  = $idLevel_9;        }else{$x9  = '';}
					if(isset($idLevel_10)){       $x10  = $idLevel_10;      }else{$x10  = '';}
					if(isset($idLevel_11)){       $x11  = $idLevel_11;      }else{$x11  = '';}
					if(isset($idLevel_12)){       $x12  = $idLevel_12;      }else{$x12  = '';}
					if(isset($idLevel_13)){       $x13  = $idLevel_13;      }else{$x13  = '';}
					if(isset($idLevel_14)){       $x14  = $idLevel_14;      }else{$x14  = '';}
					if(isset($idLevel_15)){       $x15  = $idLevel_15;      }else{$x15  = '';}
					if(isset($idLevel_16)){       $x16  = $idLevel_16;      }else{$x16  = '';}
					if(isset($idLevel_17)){       $x17  = $idLevel_17;      }else{$x17  = '';}
					if(isset($idLevel_18)){       $x18  = $idLevel_18;      }else{$x18  = '';}
					if(isset($idLevel_19)){       $x19  = $idLevel_19;      }else{$x19  = '';}
					if(isset($idLevel_20)){       $x20  = $idLevel_20;      }else{$x20  = '';}
					if(isset($idLevel_21)){       $x21  = $idLevel_21;      }else{$x21  = '';}
					if(isset($idLevel_22)){       $x22  = $idLevel_22;      }else{$x22  = '';}
					if(isset($idLevel_23)){       $x23  = $idLevel_23;      }else{$x23  = '';}
					if(isset($idLevel_24)){       $x24  = $idLevel_24;      }else{$x24  = '';}
					if(isset($idLevel_25)){       $x25  = $idLevel_25;      }else{$x25  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_depend25('Contrato','idLicitacion',$x0 ,1,'idLicitacion','Nombre','licitacion_listado',$z,0,
											'Nivel 1','idLevel_1',$x1 ,1,'idLevel_1','Nombre','licitacion_listado_level_1',$w,0,
											'Nivel 2','idLevel_2',$x2 ,1,'idLevel_2','Nombre','licitacion_listado_level_2',$w,0,
											'Nivel 3','idLevel_3',$x3 ,1,'idLevel_3','Nombre','licitacion_listado_level_3',$w,0,
											'Nivel 4','idLevel_4',$x4 ,1,'idLevel_4','Nombre','licitacion_listado_level_4',$w,0,
											'Nivel 5','idLevel_5',$x5 ,1,'idLevel_5','Nombre','licitacion_listado_level_5',$w,0,
											'Nivel 6','idLevel_6',$x6 ,1,'idLevel_6','Nombre','licitacion_listado_level_6',$w,0,
											'Nivel 7','idLevel_7',$x7 ,1,'idLevel_7','Nombre','licitacion_listado_level_7',$w,0,
											'Nivel 8','idLevel_8',$x8 ,1,'idLevel_8','Nombre','licitacion_listado_level_8',$w,0,
											'Nivel 9','idLevel_9',$x9 ,1,'idLevel_9','Nombre','licitacion_listado_level_9',$w,0,
											'Nivel 10','idLevel_10',$x10 ,1,'idLevel_10','Nombre','licitacion_listado_level_10',$w,0,
											'Nivel 11','idLevel_11',$x11 ,1,'idLevel_11','Nombre','licitacion_listado_level_11',$w,0,
											'Nivel 12','idLevel_12',$x12 ,1,'idLevel_12','Nombre','licitacion_listado_level_12',$w,0,
											'Nivel 13','idLevel_13',$x13 ,1,'idLevel_13','Nombre','licitacion_listado_level_13',$w,0,
											'Nivel 14','idLevel_14',$x14 ,1,'idLevel_14','Nombre','licitacion_listado_level_14',$w,0,
											'Nivel 15','idLevel_15',$x15 ,1,'idLevel_15','Nombre','licitacion_listado_level_15',$w,0,
											'Nivel 16','idLevel_16',$x16 ,1,'idLevel_16','Nombre','licitacion_listado_level_16',$w,0,
											'Nivel 17','idLevel_17',$x17 ,1,'idLevel_17','Nombre','licitacion_listado_level_17',$w,0,
											'Nivel 18','idLevel_18',$x18 ,1,'idLevel_18','Nombre','licitacion_listado_level_18',$w,0,
											'Nivel 19','idLevel_19',$x19 ,1,'idLevel_19','Nombre','licitacion_listado_level_19',$w,0,
											'Nivel 20','idLevel_20',$x20 ,1,'idLevel_20','Nombre','licitacion_listado_level_20',$w,0,
											'Nivel 21','idLevel_21',$x21 ,1,'idLevel_21','Nombre','licitacion_listado_level_21',$w,0,
											'Nivel 22','idLevel_22',$x22 ,1,'idLevel_22','Nombre','licitacion_listado_level_22',$w,0,
											'Nivel 23','idLevel_23',$x23 ,1,'idLevel_23','Nombre','licitacion_listado_level_23',$w,0,
											'Nivel 24','idLevel_24',$x24 ,1,'idLevel_24','Nombre','licitacion_listado_level_24',$w,0,
											$dbConn, 'form1');

					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);
					$Form_Inputs->form_input_hidden('addTrabajo', $_GET['addTrabajo'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_addTrabajo">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&componente='.$_GET['componente']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_componente'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query  = '
	maquinas_listado_level_'.$_GET['lvl'].'.Nombre,
	maquinas_listado_level_'.$_GET['lvl'].'.Codigo,
	maquinas_listado_level_'.$_GET['lvl'].'.Marca,
	maquinas_listado_level_'.$_GET['lvl'].'.idUtilizable,
	maquinas_listado_level_'.$_GET['lvl'].'.Modelo,
	maquinas_listado_level_'.$_GET['lvl'].'.AnoFab,
	maquinas_listado_level_'.$_GET['lvl'].'.Serie,
	maquinas_listado_level_'.$_GET['lvl'].'.idSubTipo,
	maquinas_listado_level_'.$_GET['lvl'].'.Saf,
	maquinas_listado_level_'.$_GET['lvl'].'.Numero,
	maquinas_listado_level_'.$_GET['lvl'].'.idProducto,
	maquinas_listado_level_'.$_GET['lvl'].'.Grasa_inicial,
	maquinas_listado_level_'.$_GET['lvl'].'.Grasa_relubricacion,
	maquinas_listado_level_'.$_GET['lvl'].'.Aceite,
	maquinas_listado_level_'.$_GET['lvl'].'.Cantidad,
	maquinas_listado_level_'.$_GET['lvl'].'.idUml,
	maquinas_listado_level_'.$_GET['lvl'].'.Frecuencia,
	maquinas_listado_level_'.$_GET['lvl'].'.idFrecuencia,
	sistema_productos_uml.Nombre AS UnidadMedida';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = maquinas_listado_level_'.$_GET['lvl'].'.idUml';
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_level_'.$_GET['lvl'], $SIS_join, 'maquinas_listado_level_'.$_GET['lvl'].'.idLevel_'.$_GET['lvl'].' = '.$_GET['edit_componente'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	//Se revisan los permisos a los productos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	$SIS_query = '
	productos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed,
	productos_listado.idUml';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	/*******************************************************/
	//filtro
	$zx1 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar Componente</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = $rowData['Nombre'];}
					if(isset($Codigo)){               $x2  = $Codigo;                 }else{$x2  = $rowData['Codigo'];}
					if(isset($Marca)){                $x3  = $Marca;                  }else{$x3  = $rowData['Marca'];}
					if(isset($idUtilizable)){         $x4  = $idUtilizable;           }else{$x4  = $rowData['idUtilizable'];}
					//Si es componente
					if(isset($Modelo)){               $x6  = $Modelo;                 }else{$x6  = $rowData['Modelo'];}
					if(isset($AnoFab)){               $x7  = $AnoFab;                 }else{$x7  = $rowData['AnoFab'];}
					if(isset($Serie)){                $x8  = $Serie;                  }else{$x8  = $rowData['Serie'];}
					//Si es subcomponente
					if(isset($Saf)){                  $x9  = $Saf;                    }else{$x9  = $rowData['Saf'];}
					if(isset($Numero)){               $x10 = $Numero;                 }else{$x10 = $rowData['Numero'];}
					if(isset($idSubTipo)){            $x11 = $idSubTipo;              }else{$x11 = $rowData['idSubTipo'];}
					if(isset($idProducto)){           $x12 = $idProducto;             }else{$x12 = $rowData['idProducto'];}
					if(isset($Grasa_inicial)){        $x13 = $Grasa_inicial;          }else{$x13 = Cantidades_decimales_justos($rowData['Grasa_inicial']);}
					if(isset($Grasa_relubricacion)){  $x14 = $Grasa_relubricacion;    }else{$x14 = Cantidades_decimales_justos($rowData['Grasa_relubricacion']);}
					if(isset($Aceite)){               $x15 = $Aceite;                 }else{$x15 = Cantidades_decimales_justos($rowData['Aceite']);}
					if(isset($Cantidad)){             $x16 = $Cantidad;               }else{$x16 = Cantidades_decimales_justos($rowData['Cantidad']);}
					if(isset($idUml_fake)){           $x17 = $idUml_fake;             }else{$x17 = $rowData['UnidadMedida'];}
					if(isset($idUml)){                $x18 = $idUml;                  }else{$x18 = $rowData['idUml'];}
					if(isset($Frecuencia)){           $x19 = $Frecuencia;             }else{$x19 = $rowData['Frecuencia'];}
					if(isset($idFrecuencia)){         $x20 = $idFrecuencia;           }else{$x20 = $rowData['idFrecuencia'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 2);
					$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 1);
					$Form_Inputs->form_select('Componente','idUtilizable', $x4, 2, 'idUtilizable', 'Nombre', 'core_maquinas_tipo_componente', 0, '', $dbConn);
					//si es componente
					$Form_Inputs->form_input_text('Modelo', 'Modelo', $x6, 1);
					$Form_Inputs->form_select_n_auto('Año de Fabricacion','AnoFab', $x7, 1, 1975, ano_actual());
					$Form_Inputs->form_input_text('Serie', 'Serie', $x8, 1);
					//Si es subcomponente
					$Form_Inputs->form_input_text('Saf', 'Saf', $x9, 1);
					$Form_Inputs->form_input_text('Numero', 'Numero', $x10, 1);
					$Form_Inputs->form_select_depend1('Tareas Relacionadas','idSubTipo', $x11, 1, 'idSubTipo', 'Nombre', 'core_maquinas_tipo', 0, 0,
											'Producto utilizado','idProducto', $x12, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_number('Grasa inicial','Grasa_inicial', $x13, 1);
					$Form_Inputs->form_input_number('Grasa relubricacion','Grasa_relubricacion', $x14, 1);
					$Form_Inputs->form_input_number('Cantidad de Aceite','Aceite', $x15, 1);
					$Form_Inputs->form_input_number('Cantidad a consumir','Cantidad', $x16, 1);
					$Form_Inputs->form_input_disabled('Unidad de Medida','idUml_fake',  $x17);
					$Form_Inputs->form_input_text('Unidad de Medida','idUml', $x18, 1);
					$Form_Inputs->form_input_text('Frecuencia', 'Frecuencia', $x19, 1);
					$Form_Inputs->form_select('Medida Frecuencia','idFrecuencia', $x20, 1, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $_GET['componente'], 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

					?>
					<script>
						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo '
							let id_data1_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";
							let id_data2_'.$tipo['idProducto'].'= "'.$tipo['idUml'].'";
							';
						}
						?>

						/**********************************************************************/
						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

							//Se ocultan todos los input
							document.getElementById('div_Modelo').style.display = 'none';
							document.getElementById('div_AnoFab').style.display = 'none';
							document.getElementById('div_Serie').style.display = 'none';
							document.getElementById('div_idSubTipo').style.display = 'none';
							document.getElementById('div_Saf').style.display = 'none';
							document.getElementById('div_Numero').style.display = 'none';
							document.getElementById('div_idProducto').style.display = 'none';
							document.getElementById('div_Grasa_inicial').style.display = 'none';
							document.getElementById('div_Grasa_relubricacion').style.display = 'none';
							document.getElementById('div_Aceite').style.display = 'none';
							document.getElementById('div_Cantidad').style.display = 'none';
							document.getElementById('div_idUml_fake').style.display = 'none';
							document.getElementById('div_idUml').style.display = 'none';
							document.getElementById('div_Frecuencia').style.display = 'none';
							document.getElementById('div_idFrecuencia').style.display = 'none';
							//ejecuto la seleccion
							LoadUtilizable(0);
							LoadSubTipo(0);

						});

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};
						document.getElementById("idUtilizable").onchange = function() {LoadUtilizable(1)};
						document.getElementById("idSubTipo").onchange = function() {LoadSubTipo(1)};

						/**********************************************************************/
						function LoadProducto() {
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("idUml_fake").value = eval("id_data1_" + Componente);
								document.getElementById("idUml").value      = eval("id_data2_" + Componente);
							}
						}

						/**********************************************************************/
						function LoadUtilizable(caseLoad){
							//ubico select
							let Sensores_val_1 = $("#idUtilizable").val();
							//selecciono
							switch(Sensores_val_1) {
								//si es No Usable
								case '1':
									document.getElementById('div_Modelo').style.display = 'none';
									document.getElementById('div_AnoFab').style.display = 'none';
									document.getElementById('div_Serie').style.display = 'none';
									document.getElementById('div_idSubTipo').style.display = 'none';
									document.getElementById('div_Saf').style.display = 'none';
									document.getElementById('div_Numero').style.display = 'none';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = 'none';
									document.getElementById('div_idFrecuencia').style.display = 'none';
								break;
								//si es Componente
								case '2':
									document.getElementById('div_Modelo').style.display = '';
									document.getElementById('div_AnoFab').style.display = '';
									document.getElementById('div_Serie').style.display = '';
									document.getElementById('div_idSubTipo').style.display = 'none';
									document.getElementById('div_Saf').style.display = 'none';
									document.getElementById('div_Numero').style.display = 'none';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = 'none';
									document.getElementById('div_idFrecuencia').style.display = 'none';
								break;
								//si es Subcomponente
								case '3':
									document.getElementById('div_Modelo').style.display = 'none';
									document.getElementById('div_AnoFab').style.display = 'none';
									document.getElementById('div_Serie').style.display = 'none';
									document.getElementById('div_idSubTipo').style.display = '';
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = 'none';
									document.getElementById('div_idFrecuencia').style.display = 'none';
								break;
							}
						}

						/**********************************************************************/
						function LoadSubTipo(caseLoad){
							//ubico select
							let Sensores_val_2 = $("#idSubTipo").val();
							//selecciono
							switch(Sensores_val_2) {
								//si es grasa
								case '1':
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = '';
									document.getElementById('div_Grasa_inicial').style.display = '';
									document.getElementById('div_Grasa_relubricacion').style.display = '';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = '';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Aceite"]').value = '0';
										document.querySelector('input[name="Cantidad"]').value = '0';
									}
								break;
								//si es aceite
								case '2':
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = '';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = '';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = '';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Grasa_inicial"]').value = '0';
										document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
										document.querySelector('input[name="Cantidad"]').value = '0';
									}
								break;
								//Errores Conjuntos
								case '3':
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = '';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = '';
									document.getElementById('div_idUml_fake').style.display = '';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Grasa_inicial"]').value = '0';
										document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
										document.querySelector('input[name="Aceite"]').value = '0';
									}
								break;
								//Errores Conjuntos
								case '4':
									document.getElementById('div_Saf').style.display = 'none';
									document.getElementById('div_Numero').style.display = 'none';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Grasa_inicial"]').value = '0';
										document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
										document.querySelector('input[name="Aceite"]').value = '0';
										document.querySelector('input[name="Cantidad"]').value = '0';
									}
								break;
							}
						}

					</script>

					<div class="form-group">

						<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){$Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);} ?>
						<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){$Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);} ?>
						<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){$Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);} ?>
						<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){$Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);} ?>
						<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){$Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);} ?>
						<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){$Form_Inputs->form_input_hidden('idLevel_6', $_GET['lv_6'], 2);} ?>
						<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){$Form_Inputs->form_input_hidden('idLevel_7', $_GET['lv_7'], 2);} ?>
						<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){$Form_Inputs->form_input_hidden('idLevel_8', $_GET['lv_8'], 2);} ?>
						<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){$Form_Inputs->form_input_hidden('idLevel_9', $_GET['lv_9'], 2);} ?>
						<?php if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){$Form_Inputs->form_input_hidden('idLevel_10', $_GET['lv_10'], 2);} ?>
						<?php if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){$Form_Inputs->form_input_hidden('idLevel_11', $_GET['lv_11'], 2);} ?>
						<?php if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){$Form_Inputs->form_input_hidden('idLevel_12', $_GET['lv_12'], 2);} ?>
						<?php if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){$Form_Inputs->form_input_hidden('idLevel_13', $_GET['lv_13'], 2);} ?>
						<?php if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){$Form_Inputs->form_input_hidden('idLevel_14', $_GET['lv_14'], 2);} ?>
						<?php if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){$Form_Inputs->form_input_hidden('idLevel_15', $_GET['lv_15'], 2);} ?>
						<?php if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){$Form_Inputs->form_input_hidden('idLevel_16', $_GET['lv_16'], 2);} ?>
						<?php if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){$Form_Inputs->form_input_hidden('idLevel_17', $_GET['lv_17'], 2);} ?>
						<?php if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){$Form_Inputs->form_input_hidden('idLevel_18', $_GET['lv_18'], 2);} ?>
						<?php if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){$Form_Inputs->form_input_hidden('idLevel_19', $_GET['lv_19'], 2);} ?>
						<?php if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){$Form_Inputs->form_input_hidden('idLevel_20', $_GET['lv_20'], 2);} ?>
						<?php if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){$Form_Inputs->form_input_hidden('idLevel_21', $_GET['lv_21'], 2);} ?>
						<?php if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){$Form_Inputs->form_input_hidden('idLevel_22', $_GET['lv_22'], 2);} ?>
						<?php if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){$Form_Inputs->form_input_hidden('idLevel_23', $_GET['lv_23'], 2);} ?>
						<?php if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){$Form_Inputs->form_input_hidden('idLevel_24', $_GET['lv_24'], 2);} ?>
						<?php if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){$Form_Inputs->form_input_hidden('idLevel_25', $_GET['lv_25'], 2);} ?>

						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&componente='.$_GET['componente']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new_componente'])){
	/*******************************************************/
	//Se revisan los permisos a los productos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	//Se revisan los permisos a los productos
	$SIS_query = '
	productos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed,
	productos_listado.idUml';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	/*******************************************************/
	//filtro
	$zx1 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Componente</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = '';}
					if(isset($Codigo)){               $x2  = $Codigo;                 }else{$x2  = '';}
					if(isset($Marca)){                $x3  = $Marca;                  }else{$x3  = '';}
					if(isset($idUtilizable)){         $x4  = $idUtilizable;           }else{$x4  = '';}
					//Si es componente
					if(isset($Modelo)){               $x6  = $Modelo;                 }else{$x6  = '';}
					if(isset($AnoFab)){               $x7  = $AnoFab;                 }else{$x7  = '';}
					if(isset($Serie)){                $x8  = $Serie;                  }else{$x8  = '';}
					//Si es subcomponente
					if(isset($Saf)){                  $x9  = $Saf;                    }else{$x9  = '';}
					if(isset($Numero)){               $x10 = $Numero;                 }else{$x10 = '';}
					if(isset($idSubTipo)){            $x11 = $idSubTipo;              }else{$x11 = '';}
					if(isset($idProducto)){           $x12 = $idProducto;             }else{$x12 = '';}
					if(isset($Grasa_inicial)){        $x13 = $Grasa_inicial;          }else{$x13 = '';}
					if(isset($Grasa_relubricacion)){  $x14 = $Grasa_relubricacion;    }else{$x14 = '';}
					if(isset($Aceite)){               $x15 = $Aceite;                 }else{$x15 = '';}
					if(isset($Cantidad)){             $x16 = $Cantidad;               }else{$x16 = '';}
					if(isset($idUml_fake)){           $x17 = $idUml_fake;             }else{$x17 = '';}
					if(isset($idUml)){                $x18 = $idUml;                  }else{$x18 = '';}
					if(isset($Frecuencia)){           $x19 = $Frecuencia;             }else{$x19 = '';}
					if(isset($idFrecuencia)){         $x20 = $idFrecuencia;           }else{$x20 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 2);
					$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 1);
					$Form_Inputs->form_select('Componente','idUtilizable', $x4, 2, 'idUtilizable', 'Nombre', 'core_maquinas_tipo_componente', 0, '', $dbConn);
					//si es componente
					$Form_Inputs->form_input_text('Modelo', 'Modelo', $x6, 1);
					$Form_Inputs->form_select_n_auto('Año de Fabricacion','AnoFab', $x7, 1, 1975, ano_actual());
					$Form_Inputs->form_input_text('Serie', 'Serie', $x8, 1);
					//Si es subcomponente
					$Form_Inputs->form_input_text('Saf', 'Saf', $x9, 1);
					$Form_Inputs->form_input_text('Numero', 'Numero', $x10, 1);
					$Form_Inputs->form_select_depend1('Tareas Relacionadas','idSubTipo', $x11, 1, 'idSubTipo', 'Nombre', 'core_maquinas_tipo', 0, 0,
											'Producto utilizado','idProducto', $x12, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_number('Grasa inicial','Grasa_inicial', $x13, 1);
					$Form_Inputs->form_input_number('Grasa relubricacion','Grasa_relubricacion', $x14, 1);
					$Form_Inputs->form_input_number('Cantidad de Aceite','Aceite', $x15, 1);
					$Form_Inputs->form_input_number('Cantidad a consumir','Cantidad', $x16, 1);
					$Form_Inputs->form_input_disabled('Unidad de Medida','idUml_fake',  $x17);
					$Form_Inputs->form_input_text('Unidad de Medida','idUml', $x18, 1);
					$Form_Inputs->form_input_text('Frecuencia', 'Frecuencia', $x19, 1);
					$Form_Inputs->form_select('Medida Frecuencia','idFrecuencia', $x20, 1, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $_GET['componente'], 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo '
							let id_data1_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";
							let id_data2_'.$tipo['idProducto'].'= "'.$tipo['idUml'].'";
							';
						}
						?>

						/**********************************************************************/
						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

							//Se ocultan todos los input
							document.getElementById('div_Modelo').style.display = 'none';
							document.getElementById('div_AnoFab').style.display = 'none';
							document.getElementById('div_Serie').style.display = 'none';
							document.getElementById('div_idSubTipo').style.display = 'none';
							document.getElementById('div_Saf').style.display = 'none';
							document.getElementById('div_Numero').style.display = 'none';
							document.getElementById('div_idProducto').style.display = 'none';
							document.getElementById('div_Grasa_inicial').style.display = 'none';
							document.getElementById('div_Grasa_relubricacion').style.display = 'none';
							document.getElementById('div_Aceite').style.display = 'none';
							document.getElementById('div_Cantidad').style.display = 'none';
							document.getElementById('div_idUml_fake').style.display = 'none';
							document.getElementById('div_idUml').style.display = 'none';
							document.getElementById('div_Frecuencia').style.display = 'none';
							document.getElementById('div_idFrecuencia').style.display = 'none';

						});

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};
						document.getElementById("idUtilizable").onchange = function() {LoadUtilizable(1)};
						document.getElementById("idSubTipo").onchange = function() {LoadSubTipo(1)};

						/**********************************************************************/
						function LoadProducto() {
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("idUml_fake").value = eval("id_data1_" + Componente);
								document.getElementById("idUml").value      = eval("id_data2_" + Componente);
							}
						}

						/**********************************************************************/
						function LoadUtilizable(caseLoad){
							//ubico select
							let Sensores_val_1 = $("#idUtilizable").val();
							//selecciono
							switch(Sensores_val_1) {
								//si es No Usable
								case '1':
									document.getElementById('div_Modelo').style.display = 'none';
									document.getElementById('div_AnoFab').style.display = 'none';
									document.getElementById('div_Serie').style.display = 'none';
									document.getElementById('div_idSubTipo').style.display = 'none';
									document.getElementById('div_Saf').style.display = 'none';
									document.getElementById('div_Numero').style.display = 'none';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = 'none';
									document.getElementById('div_idFrecuencia').style.display = 'none';
								break;
								//si es Componente
								case '2':
									document.getElementById('div_Modelo').style.display = '';
									document.getElementById('div_AnoFab').style.display = '';
									document.getElementById('div_Serie').style.display = '';
									document.getElementById('div_idSubTipo').style.display = 'none';
									document.getElementById('div_Saf').style.display = 'none';
									document.getElementById('div_Numero').style.display = 'none';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = 'none';
									document.getElementById('div_idFrecuencia').style.display = 'none';
								break;
								//si es Subcomponente
								case '3':
									document.getElementById('div_Modelo').style.display = 'none';
									document.getElementById('div_AnoFab').style.display = 'none';
									document.getElementById('div_Serie').style.display = 'none';
									document.getElementById('div_idSubTipo').style.display = '';
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = 'none';
									document.getElementById('div_idFrecuencia').style.display = 'none';
								break;
							}
						}

						/**********************************************************************/
						function LoadSubTipo(caseLoad){
							//ubico select
							let Sensores_val_2 = $("#idSubTipo").val();
							//selecciono
							switch(Sensores_val_2) {
								//si es grasa
								case '1':
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = '';
									document.getElementById('div_Grasa_inicial').style.display = '';
									document.getElementById('div_Grasa_relubricacion').style.display = '';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = '';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Aceite"]').value = '0';
										document.querySelector('input[name="Cantidad"]').value = '0';
									}
								break;
								//si es aceite
								case '2':
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = '';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = '';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = '';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Grasa_inicial"]').value = '0';
										document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
										document.querySelector('input[name="Cantidad"]').value = '0';
									}
								break;
								//si es normal
								case '3':
									document.getElementById('div_Saf').style.display = '';
									document.getElementById('div_Numero').style.display = '';
									document.getElementById('div_idProducto').style.display = '';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = '';
									document.getElementById('div_idUml_fake').style.display = '';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Grasa_inicial"]').value = '0';
										document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
										document.querySelector('input[name="Aceite"]').value = '0';
									}
								break;
								//si es otro
								case '4':
									document.getElementById('div_Saf').style.display = 'none';
									document.getElementById('div_Numero').style.display = 'none';
									document.getElementById('div_idProducto').style.display = 'none';
									document.getElementById('div_Grasa_inicial').style.display = 'none';
									document.getElementById('div_Grasa_relubricacion').style.display = 'none';
									document.getElementById('div_Aceite').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_idUml_fake').style.display = 'none';
									document.getElementById('div_idUml').style.display = 'none';
									document.getElementById('div_Frecuencia').style.display = '';
									document.getElementById('div_idFrecuencia').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Grasa_inicial"]').value = '0';
										document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
										document.querySelector('input[name="Aceite"]').value = '0';
										document.querySelector('input[name="Cantidad"]').value = '0';
									}
								break;
							}
						}

					</script>

					<div class="form-group">

						<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){  $Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);} ?>
						<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){  $Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);} ?>
						<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){  $Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);} ?>
						<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){  $Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);} ?>
						<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){  $Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);} ?>
						<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){  $Form_Inputs->form_input_hidden('idLevel_6', $_GET['lv_6'], 2);} ?>
						<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){  $Form_Inputs->form_input_hidden('idLevel_7', $_GET['lv_7'], 2);} ?>
						<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){  $Form_Inputs->form_input_hidden('idLevel_8', $_GET['lv_8'], 2);} ?>
						<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){  $Form_Inputs->form_input_hidden('idLevel_9', $_GET['lv_9'], 2);} ?>
						<?php if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){$Form_Inputs->form_input_hidden('idLevel_10', $_GET['lv_10'], 2);} ?>
						<?php if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){$Form_Inputs->form_input_hidden('idLevel_11', $_GET['lv_11'], 2);} ?>
						<?php if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){$Form_Inputs->form_input_hidden('idLevel_12', $_GET['lv_12'], 2);} ?>
						<?php if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){$Form_Inputs->form_input_hidden('idLevel_13', $_GET['lv_13'], 2);} ?>
						<?php if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){$Form_Inputs->form_input_hidden('idLevel_14', $_GET['lv_14'], 2);} ?>
						<?php if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){$Form_Inputs->form_input_hidden('idLevel_15', $_GET['lv_15'], 2);} ?>
						<?php if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){$Form_Inputs->form_input_hidden('idLevel_16', $_GET['lv_16'], 2);} ?>
						<?php if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){$Form_Inputs->form_input_hidden('idLevel_17', $_GET['lv_17'], 2);} ?>
						<?php if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){$Form_Inputs->form_input_hidden('idLevel_18', $_GET['lv_18'], 2);} ?>
						<?php if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){$Form_Inputs->form_input_hidden('idLevel_19', $_GET['lv_19'], 2);} ?>
						<?php if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){$Form_Inputs->form_input_hidden('idLevel_20', $_GET['lv_20'], 2);} ?>
						<?php if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){$Form_Inputs->form_input_hidden('idLevel_21', $_GET['lv_21'], 2);} ?>
						<?php if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){$Form_Inputs->form_input_hidden('idLevel_22', $_GET['lv_22'], 2);} ?>
						<?php if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){$Form_Inputs->form_input_hidden('idLevel_23', $_GET['lv_23'], 2);} ?>
						<?php if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){$Form_Inputs->form_input_hidden('idLevel_24', $_GET['lv_24'], 2);} ?>
						<?php if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){$Form_Inputs->form_input_hidden('idLevel_25', $_GET['lv_25'], 2);} ?>

						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&componente='.$_GET['componente']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['componente'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query  = 'Nombre,idSistema, idConfig_1, idConfig_2';
	$SIS_join  = '';
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, 'idMaquina = '.$_GET['componente'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	//Se crean las variables
	$nmax     = 15;
	$subquery = '';
	$leftjoin = '';
	$orderby  = '';
	for ($i = 1; $i <= $nmax; $i++) {
		//consulta
		$subquery .= ',maquinas_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
		$subquery .= ',maquinas_listado_level_'.$i.'.Codigo AS LVL_'.$i.'_Codigo';
		$subquery .= ',maquinas_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
		$subquery .= ',maquinas_listado_level_'.$i.'.idUtilizable AS LVL_'.$i.'_idUtilizable';
		$subquery .= ',maquinas_listado_level_'.$i.'.idLicitacion AS LVL_'.$i.'_idLicitacion';
		$subquery .= ',maquinas_listado_level_'.$i.'.tabla AS LVL_'.$i.'_table';
		$subquery .= ',maquinas_listado_level_'.$i.'.table_value AS LVL_'.$i.'_table_value';
		$subquery .= ',maquinas_listado_level_'.$i.'.Direccion_img AS LVL_'.$i.'_imagen ';

		//Joins
		$xx = $i + 1;
		if($xx<=$nmax){
			$leftjoin .= ' LEFT JOIN `maquinas_listado_level_'.$xx.'`   ON maquinas_listado_level_'.$xx.'.idLevel_'.$i.'    = maquinas_listado_level_'.$i.'.idLevel_'.$i;
		}
		//ORDER BY
		$orderby .= ', maquinas_listado_level_'.$i.'.Codigo ASC';
	}

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'maquinas_listado_level_1.idLevel_1 AS bla';
	$SIS_query.= $subquery;
	$SIS_join  = $leftjoin;
	$SIS_where = 'maquinas_listado_level_1.idMaquina='.$_GET['componente'];
	$SIS_order = 'maquinas_listado_level_1.Codigo ASC';
	$SIS_order.= $orderby;
	$arrItemizado = array();
	$arrItemizado = db_select_array (false, $SIS_query, 'maquinas_listado_level_1', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrItemizado');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUtilizable, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idUtilizable ASC';
	$arrTipos = array();
	$arrTipos = db_select_array (false, $SIS_query, 'core_maquinas_tipo_componente', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');
	/*******************************************************/
	//Se crea el arreglo
	$TipoMaq = array();
	foreach($arrTipos as $tipo) {
		$TipoMaq[$tipo['idUtilizable']]['idUtilizable']  = $tipo['idUtilizable'];
		$TipoMaq[$tipo['idUtilizable']]['Nombre']        = $tipo['Nombre'];
	}

	/*********************************************************************/
	//Se crea el arreglo
	$Trabajo = array();
	//Creo el arreglo para saber los datos de las licitaciones
	for ($i = 1; $i <= $nmax; $i++) {
		/*******************************************************/
		// consulto los datos
		$SIS_query = 'idLevel_'.$i.' AS lvl, idLicitacion, Nombre,Codigo';
		$SIS_join  = '';
		$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		$SIS_order = 'Codigo ASC, Nombre ASC';
		$arrTrabajo = array();
		$arrTrabajo = db_select_array (false, $SIS_query, 'licitacion_listado_level_'.$i, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTrabajo');
		/*******************************************************/
		//se guardan los datos
		foreach($arrTrabajo as $trab) {
			$Trabajo[$trab['idLicitacion']][$i][$trab['lvl']]['Nombre']  = $trab['Nombre'];
			$Trabajo[$trab['idLicitacion']][$i][$trab['lvl']]['Codigo']  = $trab['Codigo'];
		}
	}


	/*********************************************************************/
	$array3d = array();
	foreach($arrItemizado as $key) {

		//Creo Variables para la rejilla
		for ($i = 1; $i <= $nmax; $i++) {

			//creo la variable vacia
			$d[$i]  = '';
			$n[$i]  = '';
			$c[$i]  = '';
			$u[$i]  = '';
			$x[$i]  = '';
			$y[$i]  = '';
			$m[$i]  = '';
			$t[$i]  = '';

			//si el dato solicitado tiene valores sobreescribe la variable
			if(isset($key['LVL_'.$i.'_id'])&&$key['LVL_'.$i.'_id']!=''){                     $d[$i] = $key['LVL_'.$i.'_id'];}
			if(isset($key['LVL_'.$i.'_Nombre'])&&$key['LVL_'.$i.'_Nombre']!=''){             $n[$i] = $key['LVL_'.$i.'_Nombre'];}
			if(isset($key['LVL_'.$i.'_Codigo'])&&$key['LVL_'.$i.'_Codigo']!=''){             $c[$i] = $key['LVL_'.$i.'_Codigo'];}
			if(isset($key['LVL_'.$i.'_idUtilizable'])&&$key['LVL_'.$i.'_idUtilizable']!=''){ $u[$i] = $key['LVL_'.$i.'_idUtilizable'];}
			if(isset($key['LVL_'.$i.'_idLicitacion'])&&$key['LVL_'.$i.'_idLicitacion']!=''){ $x[$i] = $key['LVL_'.$i.'_idLicitacion'];}
			if(isset($key['LVL_'.$i.'_table'])&&$key['LVL_'.$i.'_table']!=''){               $y[$i] = $key['LVL_'.$i.'_table'];}
			if(isset($key['LVL_'.$i.'_table_value'])&&$key['LVL_'.$i.'_table_value']!=''){   $m[$i] = $key['LVL_'.$i.'_table_value'];}
			if(isset($key['LVL_'.$i.'_imagen'])&&$key['LVL_'.$i.'_imagen']!=''){             $t[$i] = $key['LVL_'.$i.'_imagen'];}

		}

		if( $d['1']!=''){
			$array3d[$d['1']]['id']         = $d['1'];
			$array3d[$d['1']]['Nombre']     = $n['1'];
			$array3d[$d['1']]['Codigo']     = $c['1'];
			$array3d[$d['1']]['Tipo']       = $u['1'];
			$array3d[$d['1']]['Licitacion'] = $x['1'];
			$array3d[$d['1']]['Tabla']      = $y['1'];
			$array3d[$d['1']]['Valor']      = $m['1'];
			$array3d[$d['1']]['Imagen']     = $t['1'];
		}
		if( $d['2']!=''){
			$array3d[$d['1']][$d['2']]['id']         = $d['2'];
			$array3d[$d['1']][$d['2']]['Nombre']     = $n['2'];
			$array3d[$d['1']][$d['2']]['Codigo']     = $c['2'];
			$array3d[$d['1']][$d['2']]['Tipo']       = $u['2'];
			$array3d[$d['1']][$d['2']]['Licitacion'] = $x['2'];
			$array3d[$d['1']][$d['2']]['Tabla']      = $y['2'];
			$array3d[$d['1']][$d['2']]['Valor']      = $m['2'];
			$array3d[$d['1']][$d['2']]['Imagen']     = $t['2'];
		}
		if( $d['3']!=''){
			$array3d[$d['1']][$d['2']][$d['3']]['id']         = $d['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Nombre']     = $n['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Codigo']     = $c['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Tipo']       = $u['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Licitacion'] = $x['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Tabla']      = $y['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Valor']      = $m['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Imagen']     = $t['3'];
		}
		if( $d['4']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']         = $d['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre']     = $n['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Codigo']     = $c['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tipo']       = $u['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Licitacion'] = $x['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tabla']      = $y['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Valor']      = $m['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Imagen']     = $t['4'];
		}
		if( $d['5']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']         = $d['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre']     = $n['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Codigo']     = $c['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tipo']       = $u['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Licitacion'] = $x['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tabla']      = $y['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Valor']      = $m['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Imagen']     = $t['5'];
		}
		if( $d['6']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['id']         = $d['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Nombre']     = $n['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Codigo']     = $c['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tipo']       = $u['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Licitacion'] = $x['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tabla']      = $y['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Valor']      = $m['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Imagen']     = $t['6'];
		}
		if( $d['7']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['id']         = $d['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Nombre']     = $n['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Codigo']     = $c['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tipo']       = $u['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Licitacion'] = $x['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tabla']      = $y['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Valor']      = $m['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Imagen']     = $t['7'];
		}
		if( $d['8']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['id']         = $d['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Nombre']     = $n['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Codigo']     = $c['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tipo']       = $u['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Licitacion'] = $x['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tabla']      = $y['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Valor']      = $m['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Imagen']     = $t['8'];
		}
		if( $d['9']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['id']         = $d['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Nombre']     = $n['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Codigo']     = $c['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tipo']       = $u['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Licitacion'] = $x['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tabla']      = $y['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Valor']      = $m['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Imagen']     = $t['9'];
		}
		if( $d['10']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['id']         = $d['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Nombre']     = $n['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Codigo']     = $c['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tipo']       = $u['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Licitacion'] = $x['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tabla']      = $y['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Valor']      = $m['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Imagen']     = $t['10'];
		}
		if( $d['11']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['id']         = $d['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Nombre']     = $n['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Codigo']     = $c['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Tipo']       = $u['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Licitacion'] = $x['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Tabla']      = $y['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Valor']      = $m['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Imagen']     = $t['11'];
		}
		if( $d['12']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['id']         = $d['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Nombre']     = $n['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Codigo']     = $c['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Tipo']       = $u['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Licitacion'] = $x['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Tabla']      = $y['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Valor']      = $m['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Imagen']     = $t['12'];
		}
		if( $d['13']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['id']         = $d['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Nombre']     = $n['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Codigo']     = $c['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Tipo']       = $u['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Licitacion'] = $x['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Tabla']      = $y['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Valor']      = $m['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Imagen']     = $t['13'];
		}
		if( $d['14']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['id']         = $d['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Nombre']     = $n['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Codigo']     = $c['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Tipo']       = $u['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Licitacion'] = $x['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Tabla']      = $y['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Valor']      = $m['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Imagen']     = $t['14'];
		}
		if( $d['15']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['id']         = $d['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Nombre']     = $n['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Codigo']     = $c['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Tipo']       = $u['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Licitacion'] = $x['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Tabla']      = $y['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Valor']      = $m['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Imagen']     = $t['15'];
		}

	}

	function arrayToUL(array $array, array $TipoMaq, array $Trabajo, $lv, $rowlevel,$location, $nmax){
		$lv++;
		if($lv==1){
			echo '<ul class="tree">';
		}else{
			echo '<ul style="padding-left: 20px;">';
		}

		foreach ($array as $key => $value){
			//Rearmo la ubicacion de acuerdo a la profundidad
			if (isset($value['id'])){
				$loc = $location.'&lv_'.$lv.'='.$value['id'];
			}else{
				$loc = $location;
			}

			if (isset($value['Nombre'])){
				echo '<li><div class="blum">';
					echo '<div class="pull-left">';
						if(isset($value['Imagen'])&&$value['Imagen']!=''){echo '<div class="btn-group" style="width: 35px;" ><a href="#" title="Click Preview Imagen" class="btn btn-primary btn-sm tooltip pop" src="upload/'.$value['Imagen'].'"><i class="fa fa-picture-o" aria-hidden="true"></i></a></div>';}
						echo '<strong>'.$TipoMaq[$value['Tipo']]['Nombre'].':</strong> ';
						if(isset($value['Codigo'])&&$value['Codigo']!=''){echo ' '.$value['Codigo'].' - ';}
						echo $value['Nombre'];
						if ($value['Tipo']==2&&isset($Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Nombre'])){
							echo '<strong> (F. Trabajo: ';
							if(isset($Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Codigo'])&&$Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Codigo']!=''){
								echo $Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Codigo'].' - ';
							}
							echo $Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Nombre'];
							echo ')</strong>';
						}
					echo '</div>';

					echo '<div class="btn-group pull-right" >';
						//Boton para agregar familia tarea componente
						if ($rowlevel>=2&&$value['Tipo']==2){
							echo '<a href="'.$loc.'&addTrabajo='.$value['id'].'&lvl='.$lv.'" title="Agregar Familia Trabajo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-cogs" aria-hidden="true"></i></a>';
						}
						//Boton para editar
						if ($rowlevel>=2){
							echo '<a href="'.$loc.'&edit_componente='.$value['id'].'&lvl='.$lv.'" title="Editar este Componente" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
						}
						//Boton para clonar
						if ($rowlevel>=2){
							echo '<a href="'.$loc.'&clone_compo='.$value['id'].'&lvl='.$lv.'" title="Clonar este Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a>';
						}
						//boton para eliminar
						if ($rowlevel>=3){
							$ubicacion = $loc.'&del_idLevel='.simpleEncode($value['id'], fecha_actual()).'&lvl='.$lv.'&nmax='.$nmax;
							$dialogo   = '¿Realmente deseas eliminar todos los datos relacionados a esta Rama?';
							echo '<a onClick="dialogBox(\''.$ubicacion.'\', \''.$dialogo.'\')" title="Borrar este Componente" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						}
					echo '</div>';

					//Boton para crear nueva subrama condicionado solo a componentes
					if ($value['Tipo']==2){
						echo '<div class="btn-group pull-right" style="margin-right:5px;" >';
							if ($rowlevel>=1){
								$xc = $lv + 1;
								echo '<a href="'.$loc.'&new_componente=true&lvl='.$xc.'" title="Crear Sub-Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-file-o" aria-hidden="true"></i></a>';
							}
						echo '</div>';
					}
					echo '<div class="clearfix"></div>';
				echo '</div>';
			}
			if (!empty($value) && is_array($value)){

				echo arrayToUL($value, $TipoMaq, $Trabajo, $lv, $rowlevel,$loc, $nmax);
			}
			echo '</li>';
		}
		echo '</ul>';
	}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Maquina', $rowData['Nombre'], 'Componentes'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'].'&componente='.$_GET['componente'].'&new_componente=true&lvl=1'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Componente</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Componentes</h5>
			</header>
			<div class="table-responsive">

				<?php //Se imprime el arbol
				echo arrayToUL($array3d, $TipoMaq, $Trabajo, 0, $rowlevel['level'],$new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'].'&componente='.$_GET['componente'], $nmax);
				?>
				<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<img src="" class="imagepreview" style="width: 100%;padding: 15px;" >
							</div>
						</div>
					</div>
				</div>
				<script>
					$(function() {
						$('.pop').on('click', function() {
							$('.imagepreview').attr('src',$(this).attr('src'));
							$('#imagemodal').modal('show');
						});
					});
				</script>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['status'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	maquinas_listado.idMaquina,
	maquinas_listado.Nombre,
	core_estados.Nombre AS estado,
	maquinas_listado.idConfig_1,
	maquinas_listado.idConfig_2';
	$SIS_join  = 'LEFT JOIN `core_estados`   ON core_estados.idEstado = maquinas_listado.idEstado';
	$SIS_where = 'idMaquina = '.$_GET['status'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Estado Maquina</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
							<td><?php echo 'Maquina '.$rowData['Nombre'].' '.$rowData['estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php if ($rowlevel['level']>=2){ ?>
									<?php if ( $rowData['estado']=='Activo' ){ ?>
											<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$_GET['status'].'&estado='.simpleEncode(2, fecha_actual()) ; ?>">OFF</a>
											<a class="btn btn-sm btn-info locked_active" href="#">ON</a>
									<?php } else { ?>
											<a class="btn btn-sm btn-info locked_active" href="#">OFF</a>
											<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$_GET['status'].'&estado='.simpleEncode(1, fecha_actual()) ; ?>" >ON</a>
										<?php } ?>
									<?php } ?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['config'])){
	//verifico que sea un administrador
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idConfig_1, idConfig_2';
	$SIS_join  = '';
	$SIS_where = 'idMaquina = '.$_GET['config'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Configuracion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idConfig_1)){  $x1  = $idConfig_1;  }else{$x1  = $rowData['idConfig_1'];}
					if(isset($idConfig_2)){  $x2  = $idConfig_2;  }else{$x2  = $rowData['idConfig_2'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Componentes','idConfig_1', $x1, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Matriz de Analisis','idConfig_2', $x2, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idMaquina', $_GET['config'], 2);
					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_config">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit'])){
	//verifico que sea un administrador
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Codigo, Nombre,Modelo, Serie, Fabricante, fincorporacion, idSistema, idConfig_1, idConfig_2, idCliente';
	$SIS_join  = '';
	$SIS_where = 'idMaquina = '.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Maquina</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Codigo)){           $x2  = $Codigo;          }else{$x2  = $rowData['Codigo'];}
					if(isset($Nombre)){           $x3  = $Nombre;          }else{$x3  = $rowData['Nombre'];}
					if(isset($Modelo)){           $x4  = $Modelo;          }else{$x4  = $rowData['Modelo'];}
					if(isset($Serie)){            $x5  = $Serie;           }else{$x5  = $rowData['Serie'];}
					if(isset($Fabricante)){       $x6  = $Fabricante;      }else{$x6  = $rowData['Fabricante'];}
					if(isset($fincorporacion)){   $x7  = $fincorporacion;  }else{$x7  = $rowData['fincorporacion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x3, 2);
					$Form_Inputs->form_input_text('Modelo', 'Modelo', $x4, 1);
					$Form_Inputs->form_input_text('Serie', 'Serie', $x5, 1);
					$Form_Inputs->form_input_text('Fabricante', 'Fabricante', $x6, 1);
					$Form_Inputs->form_date('Fecha de Incorporacion','fincorporacion', $x7, 1); 

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $_GET['edit'], 2);
					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Nueva Maquina</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Codigo)){     $x1  = $Codigo;      }else{$x1  = '';}
					if(isset($Nombre)){     $x2  = $Nombre;      }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x1, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idConfig_1', 2, 2);
					$Form_Inputs->form_input_hidden('idConfig_2', 2, 2);
					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idTipo';
	$SIS_join  = '';
	$SIS_where = 'idCliente = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	maquinas_listado.idMaquina,
	maquinas_listado.Codigo,
	maquinas_listado.Nombre,
	core_sistemas.Nombre AS sistema,
	maquinas_listado.idSistema,
	core_estados.Nombre AS Estado,
	clientes_listado.Nombre AS Cliente,
	maquinas_listado.idConfig_1,
	maquinas_listado.idConfig_2,
	maquinas_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`      ON core_sistemas.idSistema      = maquinas_listado.idSistema
	LEFT JOIN `core_estados`       ON core_estados.idEstado        = maquinas_listado.idEstado
	LEFT JOIN `clientes_listado`   ON clientes_listado.idCliente   = maquinas_listado.idCliente';
	$SIS_where = 'maquinas_listado.idCliente = '.$_GET['id'];
	$SIS_order = 'maquinas_listado.Nombre ASC';
	$arrMaquina = array();
	$arrMaquina = db_select_array (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMaquina');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Cliente', $rowData['Nombre'], 'Maquinas'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Maquina</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'clientes_contrato_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'clientes_contrato_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'clientes_contrato_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'clientes_contrato_listado_datos_persona_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
							<?php if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
								<li class=""><a href="<?php echo 'clientes_contrato_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_contratos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Contratos</a></li>
							<li class="active"><a href="<?php echo 'clientes_contrato_listado_maquinas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-industry" aria-hidden="true"></i> Maquinas</a></li>
						</ul>
					</li>
				</ul>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th width="160">Codigo</th>
							<th>Nombre</th>
							<th>Estado</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrMaquina as $maq) { ?>
						<tr class="odd">
							<td><?php echo $maq['Codigo']; ?></td>
							<td><?php echo $maq['Nombre']; ?></td>
							<td><label class="label <?php if(isset($maq['idEstado'])&&$maq['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $maq['Estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $maq['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 280px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_maquinas.php?view='.simpleEncode($maq['idMaquina'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&nombre_maquina='.$maq['Nombre'].'&clone_idMaquina='.$maq['idMaquina']; ?>" title="Clonar Maquina" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$maq['idMaquina']; ?>" title="Editar Maquina" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$maq['idMaquina']; ?>" title="Editar Estado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-power-off" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&config='.$maq['idMaquina']; ?>" title="Editar Configuracion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-cogs" aria-hidden="true"></i></a><?php } ?>

									<?php if(isset($maq['idConfig_1'])&&$maq['idConfig_1']==1){ ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&componente='.$maq['idMaquina']; ?>" title="Editar Componentes" class="btn btn-primary btn-sm tooltip"><i class="fa fa-server" aria-hidden="true"></i></a><?php } ?>
									<?php } ?>
									<?php if(isset($maq['idConfig_2'])&&$maq['idConfig_2']==1){ ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&matriz='.$maq['idMaquina']; ?>" title="Editar Matriz" class="btn btn-primary btn-sm tooltip"><i class="fa fa-server" aria-hidden="true"></i></a><?php } ?>
									<?php } ?>

									<?php if ($rowlevel['level']>=4){
										$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($maq['idMaquina'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el registro '.$maq['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>

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

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
