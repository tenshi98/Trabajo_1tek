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
$original = "telemetria_listado.php";
$location = $original;
$new_location = "telemetria_listado_sensor_operaciones.php";
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
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_definicion_operacional.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_definicion_operacional.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_definicion_operacional.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Definicion Operacional Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Definicion Operacional Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Definicion Operacional Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	//Consultas
	$SIS_query = 'telemetria_listado.cantSensores'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Se consultan datos
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

	$arrFinalGrupos = array();
	foreach ($arrGrupos as $sen) { $arrFinalGrupos[$sen['idGrupo']]['Nombre'] = $sen['Nombre']; $arrFinalGrupos[$sen['idGrupo']]['nColumnas'] = $sen['nColumnas']; $arrFinalGrupos[$sen['idGrupo']]['idGrupo'] = $sen['idGrupo'];}

	//los datos guardados
	$rowData_i = db_select_data (false, 'N_Sensor, ValorActivo, RangoMinimo, RangoMaximo, idFuncion', 'telemetria_listado_definicion_operacional', '', 'idDefinicion ='.$_GET['edit'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData_i');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Definicion Operacional</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idFuncion)){       $x1  = $idFuncion;      }else{$x1  = $rowData_i['idFuncion'];}
					if(isset($ValorActivo)){     $x2  = $ValorActivo;    }else{$x2  = Cantidades_decimales_justos($rowData_i['ValorActivo']);}
					if(isset($RangoMinimo)){     $x3  = $RangoMinimo;    }else{$x3  = Cantidades_decimales_justos($rowData_i['RangoMinimo']);}
					if(isset($RangoMaximo)){     $x4  = $RangoMaximo;    }else{$x4  = Cantidades_decimales_justos($rowData_i['RangoMaximo']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();

					$input = '<div class="form-group" id="div_sensorn" >
									<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">Sensor Activo</label>
									<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
										<select name="N_Sensor" id="N_Sensor" class="form-control" required="">';
											$input .= '<option value="" selected>Seleccione una Opción</option>';

											for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
												//solo sensores activos
												if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
													if(isset($rowData_i['N_Sensor'])&&$rowData_i['N_Sensor']==$i){$selected='selected';}else{$selected='';}
													if(isset($arrFinalGrupos[$rowData['SensoresGrupo_'.$i]]['Nombre'])){$grupo = $arrFinalGrupos[$rowData['SensoresGrupo_'.$i]]['Nombre'].' - ';}else{$grupo = '';}
													$input .= '<option value="'.$i.'" '.$selected.'>'.$grupo.$rowData['SensoresNombre_'.$i].'</option>';
												}
											}

										$input .= '
										</select>
									</div>
								</div>';

					echo $input;

					$Form_Inputs->form_select('Funcion','idFuncion', $x1, 2, 'idFuncion', 'Nombre', 'core_telemetria_funciones', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Valor Supervisado','ValorActivo', $x2, 1);
					$Form_Inputs->form_input_number('Rango Valor Minimo','RangoMinimo', $x3, 1);
					$Form_Inputs->form_input_number('Rango Valor Maximo','RangoMaximo', $x4, 1);

					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idDefinicion', $_GET['edit'], 2);
					?>

					<script>
						//oculto los div
						document.getElementById('div_ValorActivo').style.display = 'none';
						document.getElementById('div_RangoMinimo').style.display = 'none';
						document.getElementById('div_RangoMaximo').style.display = 'none';

						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

							let idFuncion= $("#idFuncion").val();

							//Voltaje
							if(idFuncion == 15){
								document.getElementById('div_ValorActivo').style.display = 'none';
								document.getElementById('div_RangoMinimo').style.display = 'block';
								document.getElementById('div_RangoMaximo').style.display = 'block';

							//el resto
							}else{
								document.getElementById('div_ValorActivo').style.display = 'block';
								document.getElementById('div_RangoMinimo').style.display = 'none';
								document.getElementById('div_RangoMaximo').style.display = 'none';

							}
						});

						$("#idFuncion").on("change", function(){ //se ejecuta al cambiar valor del select
							let idFuncion_sel = $(this).val(); //Asignamos el valor seleccionado

							//Voltaje
							if(idFuncion_sel == 15){
								document.getElementById('div_ValorActivo').style.display = 'none';
								document.getElementById('div_RangoMinimo').style.display = 'block';
								document.getElementById('div_RangoMaximo').style.display = 'block';
								//Reseteo los valores a 0
								document.querySelector('input[name="ValorActivo"]').value = '0';

							//el resto
							}else{
								document.getElementById('div_ValorActivo').style.display = 'block';
								document.getElementById('div_RangoMinimo').style.display = 'none';
								document.getElementById('div_RangoMaximo').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="RangoMinimo"]').value = '0';
								document.querySelector('input[name="RangoMaximo"]').value = '0';

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
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);

	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	//Consultas
	$SIS_query = 'telemetria_listado.cantSensores'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Se consultan datos
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

	$arrFinalGrupos = array();
	foreach ($arrGrupos as $sen) { $arrFinalGrupos[$sen['idGrupo']]['Nombre'] = $sen['Nombre']; $arrFinalGrupos[$sen['idGrupo']]['nColumnas'] = $sen['nColumnas']; $arrFinalGrupos[$sen['idGrupo']]['idGrupo'] = $sen['idGrupo'];}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Definicion Operacional</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idFuncion)){       $x1 = $idFuncion;      }else{$x1 = '';}
					if(isset($ValorActivo)){     $x2 = $ValorActivo;    }else{$x2 = '';}
					if(isset($RangoMinimo)){     $x3 = $RangoMinimo;    }else{$x3 = '';}
					if(isset($RangoMaximo)){     $x4 = $RangoMaximo;    }else{$x4 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();

					$input = '<div class="form-group" id="div_sensorn" >
									<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">Sensor Activo</label>
									<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
										<select name="N_Sensor" id="N_Sensor" class="form-control" required="">';
											$input .= '<option value="" selected>Seleccione una Opción</option>';

											for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
												//solo sensores activos
												if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
													if(isset($arrFinalGrupos[$rowData['SensoresGrupo_'.$i]]['Nombre'])){$grupo = $arrFinalGrupos[$rowData['SensoresGrupo_'.$i]]['Nombre'].' - ';}else{$grupo = '';}
													$input .= '<option value="'.$i.'">'.$grupo.$rowData['SensoresNombre_'.$i].'</option>';
												}
											}

										$input .= '
										</select>
									</div>
								</div>';

					echo $input;

					$Form_Inputs->form_select('Funcion','idFuncion', $x1, 2, 'idFuncion', 'Nombre', 'core_telemetria_funciones', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Valor Supervisado','ValorActivo', $x2, 1);
					$Form_Inputs->form_input_number('Rango Valor Minimo','RangoMinimo', $x3, 1);
					$Form_Inputs->form_input_number('Rango Valor Maximo','RangoMaximo', $x4, 1);

					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
					?>

					<script>
						//oculto los div
						document.getElementById('div_ValorActivo').style.display = 'none';
						document.getElementById('div_RangoMinimo').style.display = 'none';
						document.getElementById('div_RangoMaximo').style.display = 'none';

						$("#idFuncion").on("change", function(){ //se ejecuta al cambiar valor del select
							let idFuncion_sel = $(this).val(); //Asignamos el valor seleccionado

							//Voltaje
							if(idFuncion_sel == 15){
								document.getElementById('div_ValorActivo').style.display = 'none';
								document.getElementById('div_RangoMinimo').style.display = 'block';
								document.getElementById('div_RangoMaximo').style.display = 'block';
								//Reseteo los valores a 0
								document.querySelector('input[name="ValorActivo"]').value = '0';

							//el resto
							}else{
								document.getElementById('div_ValorActivo').style.display = 'block';
								document.getElementById('div_RangoMinimo').style.display = 'none';
								document.getElementById('div_RangoMaximo').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="RangoMinimo"]').value = '0';
								document.querySelector('input[name="RangoMaximo"]').value = '0';

							}
						});

					</script>

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
	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	}
	//Consultas
	$SIS_query = '
	telemetria_listado.Nombre,
	telemetria_listado.id_Geo,
	telemetria_listado.id_Sensores'.$subquery;
	$SIS_join  = 'LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	// consulto los datos
	$SIS_query = '
	telemetria_listado_definicion_operacional.idDefinicion,
	telemetria_listado_definicion_operacional.N_Sensor,
	telemetria_listado_definicion_operacional.ValorActivo,
	telemetria_listado_definicion_operacional.RangoMinimo,
	telemetria_listado_definicion_operacional.RangoMaximo,
	telemetria_listado_definicion_operacional.idFuncion,
	core_telemetria_funciones.Nombre AS Funcion';
	$SIS_join  = 'LEFT JOIN `core_telemetria_funciones`   ON core_telemetria_funciones.idFuncion  = telemetria_listado_definicion_operacional.idFuncion';
	$SIS_where = 'telemetria_listado_definicion_operacional.idTelemetria ='.$_GET['id'];
	$SIS_order = 'telemetria_listado_definicion_operacional.N_Sensor ASC';
	$arrOperaciones = array();
	$arrOperaciones = db_select_array (false, $SIS_query, 'telemetria_listado_definicion_operacional', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOperaciones');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Nombre'], 'Editar Definicion Operacional'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Definicion Operacional</a><?php } ?>
		</div>
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
								<li class=""><a href="<?php echo 'telemetria_listado_parametros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Sensores</a></li>
								<li class="active"><a href="<?php echo 'telemetria_listado_sensor_operaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Definicion Operacional</a></li>
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
					<thead>
						<tr role="row">
							<th>Sensor</th>
							<th width="200">Valor Activo o Rango</th>
							<th>Funcion</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOperaciones as $oper) { ?>
						<tr class="odd">
							<td><?php echo $rowData['SensoresNombre_'.$oper['N_Sensor']]; ?></td>
							<td>
								<?php
								if(isset($oper['idFuncion'])&&$oper['idFuncion']!=15){
									echo Cantidades_decimales_justos($oper['ValorActivo']);
								}else{
									echo Cantidades_decimales_justos($oper['RangoMinimo']).' - '.Cantidades_decimales_justos($oper['RangoMaximo']);
								} ?>
							</td>
							<td><?php echo $oper['Funcion']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$oper['idDefinicion']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($oper['idDefinicion'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la definicion de '.$rowData['SensoresNombre_'.$oper['N_Sensor']].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
