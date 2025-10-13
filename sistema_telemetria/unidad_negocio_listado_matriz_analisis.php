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
$original = "unidad_negocio_listado.php";
$location = $original;
$new_location = "unidad_negocio_listado_matriz_analisis.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	$location.='&idMatriz='.$_GET['idMatriz'];
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se clona la maquina
if (!empty($_POST['clone_Matriz'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
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
if (isset($_GET['created'])){ $error['created'] = 'sucess/Matriz Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Matriz Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Matriz Borrada correctamente';}
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
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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

// consulto los datos
$SIS_join  = '';
$SIS_where = 'idMatriz ='.$_GET['idMatriz'];
$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
				$Form_Inputs->form_input_hidden('mod', $_GET['mod'], 2);
				?>

				<script>
					document.getElementById('div_PuntoMedAceptable').style.display = 'none';
					document.getElementById('div_PuntoMedAlerta').style.display = 'none';
					document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
					document.getElementById('div_PuntoUniMed').style.display = 'none';

					$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

						let Sensores_val= $("#PuntoidTipo").val();

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
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz='.$_GET['idMatriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/************************************************/
//consulto
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUml,Nombre', 'sistema_analisis_uml', '', 'idUml!=0', 'idUml ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');
$arrTipos = array();
$arrTipos = db_select_array (false, 'idTipo,Nombre', 'core_analisis_tipos', '', 'idTipo!=0', 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');
$arrGrupos = array();
$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'maquinas_listado_matriz_grupos', '', 'idGrupo!=0', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

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
						//compruebo
						if(isset($arrFinalUnimed[$rowData['SensoresUniMed_'.$i]])){ $unimed = $arrFinalUnimed[$rowData['SensoresUniMed_'.$i]];}else{ $unimed = '';}
						if(isset($arrFinalTipos[$rowData['PuntoidTipo_'.$i]])){     $tipo   = $arrFinalTipos[$rowData['PuntoidTipo_'.$i]];     }else{ $tipo   = '';}
						if(isset($arrFinalGrupos[$rowData['PuntoidGrupo_'.$i]])){   $grupo  = $arrFinalGrupos[$rowData['PuntoidGrupo_'.$i]];   }else{ $grupo  = '';}
						?>
						<tr class="odd">
							<td><?php echo 'p'.$i ?></td>
							<td><?php echo $tipo; ?></td>
							<td><?php echo $rowData['PuntoNombre_'.$i]; ?></td>
							<td><?php echo $grupo; ?></td>
							<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAceptable_'.$i]).' '.$unimed;    }else{echo 'No Aplica';} ?></td>
							<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAlerta_'.$i]).' '.$unimed;       }else{echo 'No Aplica';} ?></td>
							<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedCondenatorio_'.$i]).' '.$unimed; }else{echo 'No Aplica';} ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz='.$_GET['idMatriz'].'&mod='.$i; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
}elseif(!empty($_GET['idMatriz_2'])){
// consulto los datos
$SIS_query = 'Nombre,cantPuntos, idEstado';
$SIS_join  = '';
$SIS_where = 'idMatriz ='.$_GET['idMatriz_2'];
$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
				if(isset($idEstado)){    $x3  = $idEstado;     }else{$x3  = $rowData['idEstado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 2, 1, 50);
				$Form_Inputs->form_select('Estado','idEstado', $x3, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz_2'], 2);
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

				$Form_Inputs->form_input_hidden('idMaquina', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
			<?php widget_validator(); ?>

		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
// consulto los datos
$SIS_query = 'Nombre,idConfig_1, idConfig_2';
$SIS_join  = '';
$SIS_where = 'idMaquina ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

// Se trae un listado de la matriz
$SIS_query = '
maquinas_listado_matriz.idMatriz, 
maquinas_listado_matriz.Nombre,
maquinas_listado_matriz.cantPuntos,
core_estados.Nombre AS Estado,
maquinas_listado_matriz.idEstado';
$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = maquinas_listado_matriz.idEstado';
$SIS_where = 'maquinas_listado_matriz.idMaquina ='.$_GET['id'];
$SIS_order = 'maquinas_listado_matriz.Nombre ASC';
$arrMatriz = array();
$arrMatriz = db_select_array (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatriz');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Unidades de Negocio', $rowData['Nombre'], 'Matriz Analisis'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Matriz</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'unidad_negocio_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'unidad_negocio_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'unidad_negocio_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'unidad_negocio_listado_ubicacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicación</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha Tecnica</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
						<?php
						//Uso de componentes
						if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){ ?>
							<li class=""><a href="<?php echo 'unidad_negocio_listado_componentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Componentes</a></li>
						<?php } ?>
						<?php
						//uso de matriz de analisis
						if(isset($rowData['idConfig_2'])&&$rowData['idConfig_2']==1){ ?>
							<li class="active"><a href="<?php echo 'unidad_negocio_listado_matriz_analisis.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-microchip" aria-hidden="true"></i> Matriz Analisis</a></li>
						<?php } ?>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th width="120">Estado</th>
						<th width="10">N° Puntos</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrMatriz as $maq) { ?>
					<tr class="odd">
						<td><?php echo $maq['Nombre']; ?></td>
						<td><label class="label <?php if(isset($maq['idEstado'])&&$maq['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $maq['Estado']; ?></label></td>
						<td><?php echo $maq['cantPuntos']; ?></td>
						<td>
							<div class="btn-group" style="width: 140px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz_2='.$maq['idMatriz']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&nombre_matriz='.$maq['Nombre'].'&clone_idMatriz='.$maq['idMatriz']; ?>" title="Clonar Matriz" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz='.$maq['idMatriz']; ?>" title="Editar Matriz" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($maq['idMatriz'], fecha_actual());
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
