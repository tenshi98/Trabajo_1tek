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
//Cargamos la ubicacion
$original = "telemetria_listado.php";
$location = $original;
$new_location = "telemetria_listado_parametros.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
//formulario para editar
if (!empty($_GET['modDelAct'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update_Sensor_Act';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Sensor Activacion Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Sensor Activacion Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Sensor Activacion Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['modAct'])){
	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	}
	$SIS_query = '
	telemetria_listado.Nombre AS Equipo,
	telemetria_listado.SensorActivacionID,
	telemetria_listado.SensorActivacionValor,
	telemetria_listado.cantSensores'.$subquery;
	$SIS_join  = 'LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Sensor Activacion de <?php echo $rowData['Equipo']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//se dibujan los inputs
					$input = '
					<div class="form-group" id="div_SensorActivacionID">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_SensorActivacionID">Sensor de Activacion</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="SensorActivacionID" id="SensorActivacionID" class="form-control" required >
								<option value="" selected>Seleccione una Opción</option>';
								for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
									$selected = '';
									if($i==$rowData['SensorActivacionID']){
										$selected = 'selected="selected"';
									}
									$input .= '<option value="'.$i.'" '.$selected.' >Sensor : '.$rowData['SensoresNombre_'.$i].'</option>';
								}
								$input .= '
							</select>
						</div>
					</div>';
					echo $input;

					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Valor Activacion', 'SensorActivacionValor', $rowData['SensorActivacionValor'], 1);

					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
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
}elseif(!empty($_GET['mod'])){
	//Armo cadena
	$cadena  = ',telemetria_listado_sensores_nombre.SensoresNombre_'.$_GET['mod'].' AS Nombre';
	$cadena .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$_GET['mod'].' AS Sensor';
	$cadena .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$_GET['mod'].' AS Grupo';
	$cadena .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$_GET['mod'].' AS UniMed';
	$cadena .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$_GET['mod'].' AS Activo';
	$cadena .= ',telemetria_listado_sensores_uso.SensoresUso_'.$_GET['mod'].' AS Uso';
	$cadena .= ',telemetria_listado_sensores_uso_fecha.SensoresFechaUso_'.$_GET['mod'].' AS FechaUso';
	$cadena .= ',telemetria_listado_sensores_accion_c.SensoresAccionC_'.$_GET['mod'].' AS AccionC';
	$cadena .= ',telemetria_listado_sensores_accion_t.SensoresAccionT_'.$_GET['mod'].' AS AccionT';
	$cadena .= ',telemetria_listado_sensores_accion_alerta.SensoresAccionAlerta_'.$_GET['mod'].' AS AccionAlerta';
	$cadena .= ',telemetria_listado_sensores_revision.SensoresRevision_'.$_GET['mod'].' AS Revision';
	$cadena .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$_GET['mod'].' AS RevisionGrupo';

	// consulto los datos
	$SIS_query = 'telemetria_listado.Nombre AS Equipo'.$cadena;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_tipo`            ON telemetria_listado_sensores_tipo.idTelemetria           = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_uso`             ON telemetria_listado_sensores_uso.idTelemetria            = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_uso_fecha`       ON telemetria_listado_sensores_uso_fecha.idTelemetria      = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_accion_c`        ON telemetria_listado_sensores_accion_c.idTelemetria       = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_accion_t`        ON telemetria_listado_sensores_accion_t.idTelemetria       = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_accion_alerta`   ON telemetria_listado_sensores_accion_alerta.idTelemetria  = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_revision`        ON telemetria_listado_sensores_revision.idTelemetria       = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="margin-bottom:350px;">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Parametros de <?php echo $rowData['Equipo']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Basicos');
					$Form_Inputs->form_input_text('Nombre', 'SensoresNombre_'.$_GET['mod'], $rowData['Nombre'], 1);

					$Form_Inputs->form_tittle(3, 'Configuracion');
					$Form_Inputs->form_select_filter('Tipo de Sensor','SensoresTipo_'.$_GET['mod'], $rowData['Sensor'], 1, 'idSensores', 'Nombre', 'telemetria_listado_sensores', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Grupo','SensoresGrupo_'.$_GET['mod'], $rowData['Grupo'], 1, 'idGrupo', 'Nombre', 'telemetria_listado_grupos', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Unidad de Medida','SensoresUniMed_'.$_GET['mod'], $rowData['UniMed'], 1, 'idUniMed', 'Nombre', 'telemetria_listado_unidad_medida', 0, '', $dbConn);
					$Form_Inputs->form_select('Estado Sensor','SensoresActivo_'.$_GET['mod'], $rowData['Activo'], 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Uso Sensor(Ciclos, Tiempo, Cumplimiento)');
					$Form_Inputs->form_post_data(2,1,1, '<strong>Opcional:</strong> Se mide el uso del sensor y alerta bajo criterios ingresados si llega a fecha limite o a un numero de usos.' );
					$Form_Inputs->form_select('Utilizacion','SensoresUso_'.$_GET['mod'], $rowData['Uso'], 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_date('Fecha Cambio','SensoresFechaUso_'.$_GET['mod'], $rowData['FechaUso'], 1);
					$Form_Inputs->form_input_number('Ciclos Limite(Cantidad)','SensoresAccionC_'.$_GET['mod'], Cantidades_decimales_justos($rowData['AccionC']), 1);
					$Form_Inputs->form_input_number('Tiempo Limite (Horas)','SensoresAccionT_'.$_GET['mod'], Cantidades_decimales_justos($rowData['AccionT']/3600), 1);
					$Form_Inputs->form_select_n_auto('% Cumplimiento (1 a 100)','SensoresAccionAlerta_'.$_GET['mod'], Cantidades_decimales_justos($rowData['AccionAlerta']), 1, 1, 100);

					$Form_Inputs->form_tittle(3, 'Revision Trabajo');
					$Form_Inputs->form_post_data(2,1,1, '<strong>Opcional:</strong> Utilizacion en los mantenimientos.' );
					$Form_Inputs->form_select('Utilizar','SensoresRevision_'.$_GET['mod'], $rowData['Revision'], 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Grupo','SensoresRevisionGrupo_'.$_GET['mod'], $rowData['RevisionGrupo'], 1, 'idGrupo', 'Nombre', 'telemetria_listado_grupos_uso', 'idSupervisado=1', '', $dbConn);

					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
					if(isset($rowData['FechaUso'])&&$rowData['FechaUso']!=''){$Form_Inputs->form_input_hidden('SensoresFechaUso_Fake', $rowData['FechaUso'], 2);}
					?>

					<script>
						//oculto los div
						document.getElementById('div_SensoresFechaUso_<?php echo $_GET['mod']; ?>').style.display = 'none';
						document.getElementById('div_SensoresAccionC_<?php echo $_GET['mod']; ?>').style.display = 'none';
						document.getElementById('div_SensoresAccionT_<?php echo $_GET['mod']; ?>').style.display = 'none';
						document.getElementById('div_SensoresAccionAlerta_<?php echo $_GET['mod']; ?>').style.display = 'none';
						document.getElementById('div_SensoresRevisionGrupo_<?php echo $_GET['mod']; ?>').style.display = 'none';

						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

							let SensoresUso_<?php echo $_GET['mod']; ?>= $("#SensoresUso_<?php echo $_GET['mod']; ?>").val();
							let SensoresRevision_<?php echo $_GET['mod']; ?>= $("#SensoresRevision_<?php echo $_GET['mod']; ?>").val();

							//Si es si
							if(SensoresUso_<?php echo $_GET['mod']; ?> == 1){
								document.getElementById('div_SensoresFechaUso_<?php echo $_GET['mod']; ?>').style.display = 'block';
								document.getElementById('div_SensoresAccionC_<?php echo $_GET['mod']; ?>').style.display = 'block';
								document.getElementById('div_SensoresAccionT_<?php echo $_GET['mod']; ?>').style.display = 'block';
								document.getElementById('div_SensoresAccionAlerta_<?php echo $_GET['mod']; ?>').style.display = 'block';

							//Si es no
							}else if(SensoresUso_<?php echo $_GET['mod']; ?> == 2){
								document.getElementById('div_SensoresFechaUso_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionC_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionT_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionAlerta_<?php echo $_GET['mod']; ?>').style.display = 'none';

							//si no en ninguno
							}else{
								document.getElementById('div_SensoresFechaUso_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionC_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionT_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionAlerta_<?php echo $_GET['mod']; ?>').style.display = 'none';

							}

							//Si es si
							if(SensoresRevision_<?php echo $_GET['mod']; ?> == 1){
								document.getElementById('div_SensoresRevisionGrupo_<?php echo $_GET['mod']; ?>').style.display = 'block';

							//Si es no
							}else if(SensoresRevision_<?php echo $_GET['mod']; ?> == 2){
								document.getElementById('div_SensoresRevisionGrupo_<?php echo $_GET['mod']; ?>').style.display = 'none';

							//si no en ninguno
							}else{
								document.getElementById('div_SensoresRevisionGrupo_<?php echo $_GET['mod']; ?>').style.display = 'none';

							}
						});

						//se ejecuta al cambiar valor del select
						$("#SensoresUso_<?php echo $_GET['mod']; ?>").on("change", function(){
							//Asignamos el valor seleccionado
							let <?php echo 'SensoresUso_'.$_GET['mod'].'_sel'; ?> = $(this).val();

							//Si es si
							if(SensoresUso_<?php echo $_GET['mod']; ?>_sel == 1){
								document.getElementById('div_SensoresFechaUso_<?php echo $_GET['mod']; ?>').style.display = 'block';
								document.getElementById('div_SensoresAccionC_<?php echo $_GET['mod']; ?>').style.display = 'block';
								document.getElementById('div_SensoresAccionT_<?php echo $_GET['mod']; ?>').style.display = 'block';
								document.getElementById('div_SensoresAccionAlerta_<?php echo $_GET['mod']; ?>').style.display = 'block';

							//Si es no
							}else if(SensoresUso_<?php echo $_GET['mod']; ?>_sel == 2){
								document.getElementById('div_SensoresFechaUso_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionC_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionT_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionAlerta_<?php echo $_GET['mod']; ?>').style.display = 'none';

							//si no en ninguno
							}else{
								document.getElementById('div_SensoresFechaUso_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionC_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionT_<?php echo $_GET['mod']; ?>').style.display = 'none';
								document.getElementById('div_SensoresAccionAlerta_<?php echo $_GET['mod']; ?>').style.display = 'none';

							}
						});

						$("#SensoresRevision_<?php echo $_GET['mod']; ?>").on("change", function(){ //se ejecuta al cambiar valor del select
							let SensoresRevision_<?php echo $_GET['mod']; ?>_sel = $(this).val(); //Asignamos el valor seleccionado

							//Si es si
							if(SensoresRevision_<?php echo $_GET['mod']; ?>_sel == 1){
								document.getElementById('div_SensoresRevisionGrupo_<?php echo $_GET['mod']; ?>').style.display = 'block';
							//Si es no
							}else if(SensoresRevision_<?php echo $_GET['mod']; ?>_sel == 2){
								document.getElementById('div_SensoresRevisionGrupo_<?php echo $_GET['mod']; ?>').style.display = 'none';
							//si no en ninguno
							}else{
								document.getElementById('div_SensoresRevisionGrupo_<?php echo $_GET['mod']; ?>').style.display = 'none';
							}
						});

					</script>

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
}else{

	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		$subquery .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
	}
	//Consultas
	$SIS_query = '
	telemetria_listado.Nombre,
	telemetria_listado.id_Geo,
	telemetria_listado.id_Sensores,
	telemetria_listado.cantSensores,
	telemetria_listado.SensorActivacionID,
	telemetria_listado.SensorActivacionValor'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_tipo`            ON telemetria_listado_sensores_tipo.idTelemetria           = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	$arrSensores = array();
	$arrSensores = db_select_array (false, 'idSensores,Nombre', 'telemetria_listado_sensores', '', '', 'idSensores ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	$arrEstado = array();
	$arrEstado = db_select_array (false, 'idEstado,Nombre', 'core_estados', '', '', 'idEstado ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEstado');

	$arrGruposRev = array();
	$arrGruposRev = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos_uso', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGruposRev');

	//Recorro
	$arrFinalSensores  = array();
	$arrFinalGrupos    = array();
	$arrFinalEstado    = array();
	$arrFinalGruposRev = array();

	foreach ($arrSensores as $sen) {  $arrFinalSensores[$sen['idSensores']] = $sen['Nombre'];}
	foreach ($arrGrupos as $sen) {    $arrFinalGrupos[$sen['idGrupo']]      = $sen['Nombre'];}
	foreach ($arrEstado as $sen) {    $arrFinalEstado[$sen['idEstado']]     = $sen['Nombre'];}
	foreach ($arrGruposRev as $sen) { $arrFinalGruposRev[$sen['idGrupo']]   = $sen['Nombre'];}

	//no configurado
	$arrFinalSensores[0]  = 'S/C';
	$arrFinalGrupos[0]    = 'S/C';
	$arrFinalEstado[0]    = 'S/C';
	$arrFinalGruposRev[0] = 'S/C';

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Nombre'], 'Editar Datos Sensores'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'telemetria_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'telemetria_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'telemetria_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'telemetria_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<?php if($rowData['id_Sensores']==1){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_alarmas_perso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bullhorn" aria-hidden="true"></i> Alarmas Personalizadas</a></li>
							<?php } ?>
							<?php if($rowData['id_Geo']==1){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_gps.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Datos GPS</a></li>
							<?php }elseif($rowData['id_Geo']==2){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_direccion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-signs" aria-hidden="true"></i> Dirección</a></li>
							<?php } ?>
							<?php if($rowData['id_Sensores']==1){ ?>
								<li class="active"><a href="<?php echo 'telemetria_listado_parametros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Sensores</a></li>
								<li class=""><a href="<?php echo 'telemetria_listado_sensor_operaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Definicion Operacional</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'telemetria_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_trabajo.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-clock-o" aria-hidden="true"></i> Jornada Trabajo</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_otros_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-archive" aria-hidden="true"></i> Otros Datos</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>

						</ul>
					</li>
				</ul>
			</header>

			<div class="table-responsive">

				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tr class="odd">
						<td width="210"><strong>Sensor de Activacion</strong></td>
						<td>
							<?php
							if(isset($rowData['SensoresNombre_'.$rowData['SensorActivacionID']])&&$rowData['SensoresNombre_'.$rowData['SensorActivacionID']]!=''){
								echo $rowData['SensoresNombre_'.$rowData['SensorActivacionID']];
							}else{
								echo 'No configurado';
							} ?>
						</td>
						<td width="10">
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&modAct=true'; ?>" title="Editar Sensor Activacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){
									//se verifica que el usuario no sea uno mismo
									$ubicacion = $new_location.'&id='.$_GET['id'].'&modDelAct=true';
									$dialogo   = '¿Realmente deseas eliminar el sensor de activacion?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Sensor Activacion" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
					<tr class="odd">
						<td width="210"><strong>Valor Sensor Activo</strong></td>
						<td colspan="2">
							<?php if(isset($rowData['SensorActivacionValor'])&&$rowData['SensorActivacionValor']!=''){
								echo $rowData['SensorActivacionValor'];
							} ?>
						</td>
					</tr>
					<tr class="odd"><td colspan="3"></td></tr>
				</table>

				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Nombre</th>
							<th>Tipo Sensor</th>
							<th>Grupo</th>
							<th style="text-align: center;">Grupo<br/>Revision</th>
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						//bucle con la cantidad de sensores
						for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
							//Datos
							if(isset($arrFinalSensores[$rowData['SensoresTipo_'.$i]])){           $Sensores  = $arrFinalSensores[$rowData['SensoresTipo_'.$i]];           }else{$Sensores   = '';}
							if(isset($arrFinalGrupos[$rowData['SensoresGrupo_'.$i]])){            $Grupos    = $arrFinalGrupos[$rowData['SensoresGrupo_'.$i]];            }else{$Grupos     = '';}
							if(isset($arrFinalEstado[$rowData['SensoresActivo_'.$i]])){           $Estado    = $arrFinalEstado[$rowData['SensoresActivo_'.$i]];           }else{$Estado     = '';}
							if(isset($arrFinalGruposRev[$rowData['SensoresRevisionGrupo_'.$i]])){ $GruposRev = $arrFinalGruposRev[$rowData['SensoresRevisionGrupo_'.$i]]; }else{$GruposRev  = '';}
							if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==2){
								$Color = 'FF3A00';
							}else{
								$Color = '55BD55';
							}

							?>
							<tr class="odd">
								<td><?php echo 's'.$i ?></td>
								<td><?php echo $rowData['SensoresNombre_'.$i]; ?></td>
								<td><?php echo $Sensores; ?></td>
								<td><?php echo $Grupos; ?></td>
								<td><?php echo $GruposRev; ?></td>
								<td><?php echo '<span style="color:#'.$Color.'">'.$Estado.'</span>'; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&mod='.$i; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
