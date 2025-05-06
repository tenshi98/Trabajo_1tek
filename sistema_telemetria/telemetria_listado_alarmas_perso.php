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
$new_location = "telemetria_listado_alarmas_perso.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//se agregan ubicaciones
	$location =$new_location;
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location =$new_location;
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso.php';
}
//se borra un dato
if (!empty($_GET['delAlarma'])){
	//se agregan ubicaciones
	$location =$new_location;
	//Llamamos al formulario
	$form_trabajo= 'delAlarma';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_item'])){
	//se agregan ubicaciones
	$location =$new_location;
	$location.='&id='.$_GET['id'];
	$location.='&nombre_equipo='.$_GET['nombre_equipo'];
	$location.='&listItems='.$_GET['listItems'];
	$location.='&idTipo='.$_GET['idTipo'];
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso_items.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_item'])){
	//se agregan ubicaciones
	$location =$new_location;
	$location.='&id='.$_GET['id'];
	$location.='&nombre_equipo='.$_GET['nombre_equipo'];
	$location.='&listItems='.$_GET['listItems'];
	$location.='&idTipo='.$_GET['idTipo'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso_items.php';
}
//se borra un dato
if (!empty($_GET['delAlarma_item'])){
	//se agregan ubicaciones
	$location =$new_location;
	$location.='&id='.$_GET['id'];
	$location.='&nombre_equipo='.$_GET['nombre_equipo'];
	$location.='&listItems='.$_GET['listItems'];
	$location.='&idTipo='.$_GET['idTipo'];
	//Llamamos al formulario
	$form_trabajo= 'delAlarma_item';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso_items.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Alerta Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Alerta Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Alerta Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['editItem'])){
	// consulto los datos
	$rowData = db_select_data (false, 'Sensor_N, Rango_ini, Rango_fin, valor_especifico', 'telemetria_listado_alarmas_perso_items', '', 'idItem ='.$_GET['editItem'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	//Se traen todos los datos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.cantSensores'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowSensores = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowSensores');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	$arrFinalGrupos    = array();
	foreach ($arrGrupos as $sen) {    $arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Item</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					$Form_Inputs = new Form_Inputs();

					echo '<div class="form-group" id="div_sensorn" >
							<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">Sensor</label>
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
								<select name="Sensor_N" id="Sensor_N" class="form-control" required="">
									<option value="" selected>Seleccione una Opción</option>';

									for ($i = 1; $i <= $rowSensores['cantSensores']; $i++) {
										//Se marca como seleccionado
										$selected = '';
										if($rowData['Sensor_N']==$i){$selected = 'selected';}
										//solo sensores activos
										if(isset($rowSensores['SensoresActivo_'.$i])&&$rowSensores['SensoresActivo_'.$i]==1){
											//se verifica que el grupo exista
											if(isset($arrFinalGrupos[$rowSensores['SensoresGrupo_'.$i]])&&$arrFinalGrupos[$rowSensores['SensoresGrupo_'.$i]]!=''){
												//Se trae el grupo
												$Grupos = $arrFinalGrupos[$rowSensores['SensoresGrupo_'.$i]];
												//se imprime
												echo '<option value="'.$i.'" '.$selected.'>'.TituloMenu($Grupos.' - '.$rowSensores['SensoresNombre_'.$i].' (s'.$i.')').'</option>';
											//si no existe grupo se imprime sin este
											}else{
												//se imprime
												echo '<option value="'.$i.'" '.$selected.'>'.TituloMenu($rowSensores['SensoresNombre_'.$i].' (s'.$i.')').'</option>';
											}
										}
									}

								echo '
								</select>
							</div>
						</div>';

					if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
						switch ($_GET['idTipo']) {
							case 3:
							case 4:
								//Se verifican si existen los datos
								if(isset($Rango_ini)){  $x1  = $Rango_ini;  }else{$x1  = Cantidades_decimales_justos($rowData['Rango_ini']);}
								if(isset($Rango_fin)){  $x2  = $Rango_fin;  }else{$x2  = Cantidades_decimales_justos($rowData['Rango_fin']);}

								//opcionales
								$Form_Inputs->form_post_data(1,1,1, 'Rango de valores donde normalmente trabaja el sensor, en caso de que un valor sea distinto de este rango (inferior al minimo, superior al maximo) marcara una alerta personalizada');
								$Form_Inputs->form_input_number('Rango Inicio','Rango_ini', $x1, 2);
								$Form_Inputs->form_input_number('Rango Termino','Rango_fin', $x2, 2);
								break;
							case 6:
								if(isset($valor_especifico)){  $x3  = $valor_especifico;  }else{$x3  = Cantidades_decimales_justos($rowData['valor_especifico']);}

								//opcionales
								$Form_Inputs->form_post_data(1,1,1, 'El valor especifico que es considerado como error (por ejemplo 0 o 1)');
								$Form_Inputs->form_input_number('Valor Especifico','valor_especifico', $x3, 2);
								break;
							case 7:
								if(isset($valor_especifico)){  $x3  = $valor_especifico;  }else{$x3  = Cantidades_decimales_justos($rowData['valor_especifico']);}

								//opcionales
								$Form_Inputs->form_post_data(1,1,1, 'Valor con el cual se considera que el sensor esta activo');
								$Form_Inputs->form_input_number('Valor Encendido','valor_especifico', $x3, 2);
								break;
						}
					}

					$Form_Inputs->form_input_hidden('idItem', $_GET['editItem'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_item">
						<a href="<?php echo $new_location.'&nombre_equipo='.$_GET['nombre_equipo'].'&listItems='.$_GET['listItems'].'&idTipo='.$_GET['idTipo']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addItem'])){
	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	//Se traen todos los datos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.cantSensores'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`   ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`    ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`   ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowSensores = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowSensores');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	$arrFinalGrupos    = array();
	foreach ($arrGrupos as $sen) {    $arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Item</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					$Form_Inputs = new Form_Inputs();

					echo '<div class="form-group" id="div_sensorn" >
							<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">Sensor</label>
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
								<select name="Sensor_N" id="Sensor_N" class="form-control" required="">
									<option value="" selected>Seleccione una Opción</option>';

									for ($i = 1; $i <= $rowSensores['cantSensores']; $i++) {
										//solo sensores activos
										if(isset($rowSensores['SensoresActivo_'.$i])&&$rowSensores['SensoresActivo_'.$i]==1){
											//se verifica que el grupo exista
											if(isset($arrFinalGrupos[$rowSensores['SensoresGrupo_'.$i]])&&$arrFinalGrupos[$rowSensores['SensoresGrupo_'.$i]]!=''){
												//Se trae el grupo
												$Grupos = $arrFinalGrupos[$rowSensores['SensoresGrupo_'.$i]];
												//se imprime
												echo '<option value="'.$i.'">'.TituloMenu($Grupos.' - '.$rowSensores['SensoresNombre_'.$i].' (s'.$i.')').'</option>';
											//si no existe grupo se imprime sin este
											}else{
												//se imprime
												echo '<option value="'.$i.'">'.$rowSensores['SensoresNombre_'.$i].' (s'.$i.')</option>';
											}
										}
									}

								echo '
								</select>
							</div>
						</div>';

					if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
						switch ($_GET['idTipo']) {
							case 3:
							case 4:
								//Se verifican si existen los datos
								if(isset($Rango_ini)){  $x1  = $Rango_ini;  }else{$x1  = '';}
								if(isset($Rango_fin)){  $x2  = $Rango_fin;  }else{$x2  = '';}

								//opcionales
								$Form_Inputs->form_post_data(1,1,1, 'Rango de valores donde normalmente trabaja el sensor, en caso de que un valor sea distinto de este rango (inferior al minimo, superior al maximo) marcara una alerta personalizada');
								$Form_Inputs->form_input_number('Rango Inicio','Rango_ini', $x1, 2);
								$Form_Inputs->form_input_number('Rango Termino','Rango_fin', $x2, 2);
								break;
							case 6:
								if(isset($valor_especifico)){  $x3  = $valor_especifico;  }else{$x3  = '';}

								//opcionales
								$Form_Inputs->form_post_data(1,1,1, 'El valor especifico que es considerado como error (por ejemplo 0 o 1)');
								$Form_Inputs->form_input_number('Valor Especifico','valor_especifico', $x3, 2);
								break;
							case 7:
								if(isset($valor_especifico)){  $x3  = $valor_especifico;  }else{$x3  = '';}

								//opcionales
								$Form_Inputs->form_post_data(1,1,1, 'Valor con el cual se considera que el sensor esta activo');
								$Form_Inputs->form_input_number('Valor Encendido','valor_especifico', $x3, 2);
								break;
						}
					}

					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idAlarma', $_GET['listItems'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_item">
						<a href="<?php echo $new_location.'&nombre_equipo='.$_GET['nombre_equipo'].'&listItems='.$_GET['listItems'].'&idTipo='.$_GET['idTipo']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['listItems'])){
	// Se trae un listado con todas las alarmas
	$arrAlarmas = array();
	$arrAlarmas = db_select_array (false, 'idItem, Sensor_N, Rango_ini, Rango_fin, valor_especifico', 'telemetria_listado_alarmas_perso_items', '', 'idAlarma ='.$_GET['listItems'], 'idItem ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAlarmas');

	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	}
	//Se traen todos los datos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.cantSensores'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowSensores = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowSensores');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	$arrFinalGrupos    = array();
	foreach ($arrGrupos as $sen) {    $arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&nombre_equipo='.$_GET['nombre_equipo'].'&listItems='.$_GET['listItems'].'&idTipo='.$_GET['idTipo']; ?>&addItem=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Item</a><?php } ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Items de <?php echo $_GET['nombre_equipo']; ?></h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Sensor</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrAlarmas as $alarmas) { ?>
							<tr class="odd">
								<td>
									<?php
									$grupo = $arrFinalGrupos[$rowSensores['SensoresGrupo_'.$alarmas['Sensor_N']]];
									echo TituloMenu('<strong>'.$grupo.'</strong> - '.$rowSensores['SensoresNombre_'.$alarmas['Sensor_N']].' (s'.$alarmas['Sensor_N'].')');
									if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
										switch ($_GET['idTipo']) {
											case 3:
											case 4:
												echo ' (Rango: '.Cantidades_decimales_justos($alarmas['Rango_ini']).' / '.Cantidades_decimales_justos($alarmas['Rango_fin']).')';
												break;
											case 6:
												echo ' (Valor Especifico: '.Cantidades_decimales_justos($alarmas['valor_especifico']).')';
												break;
											case 7:
												echo ' (Valor Encendido: '.Cantidades_decimales_justos($alarmas['valor_especifico']).')';
												break;
										}
									}
									?>
								</td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&nombre_equipo='.$_GET['nombre_equipo'].'&listItems='.$_GET['listItems'].'&idTipo='.$_GET['idTipo'].'&editItem='.$alarmas['idItem']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											//se verifica que el usuario no sea uno mismo
											$ubicacion = $new_location.'&delAlarma_item='.simpleEncode($alarmas['idItem'], fecha_actual());
											$ubicacion.='&nombre_equipo='.$_GET['nombre_equipo'];
											$ubicacion.='&listItems='.$_GET['listItems'];
											$ubicacion.='&idTipo='.$_GET['idTipo'];
											$dialogo   = '¿Realmente deseas eliminar el item '.$grupo.$rowSensores['SensoresNombre_'.$alarmas['Sensor_N']].'?'; ?>
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
	<a href="<?php echo $new_location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editAlarma'])){
	// consulto los datos
	$SIS_query = 'Nombre,idTipoAlerta, idUniMed, idTipo, valor_error, valor_diferencia, Rango_ini, Rango_fin,
	NErroresMax, NErroresActual, idEstado, HoraInicio, HoraTermino';
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_alarmas_perso', '', 'idAlarma ='.$_GET['editAlarma'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Alarma Personalizada</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){            $x1  = $Nombre;            }else{$x1  = $rowData['Nombre'];}
					if(isset($idTipoAlerta)){      $x2  = $idTipoAlerta;      }else{$x2  = $rowData['idTipoAlerta'];}
					if(isset($idUniMed)){          $x3  = $idUniMed;          }else{$x3  = $rowData['idUniMed'];}
					if(isset($idTipo)){            $x4  = $idTipo;            }else{$x4  = $rowData['idTipo'];}
					if(isset($NErroresMax)){       $x5  = $NErroresMax;       }else{$x5  = Cantidades_decimales_justos($rowData['NErroresMax']);}
					if(isset($NErroresActual)){    $x6  = $NErroresActual;    }else{$x6  = Cantidades_decimales_justos($rowData['NErroresActual']);}
					if(isset($valor_error)){       $x7  = $valor_error;       }else{$x7  = Cantidades_decimales_justos($rowData['valor_error']);}
					if(isset($valor_diferencia)){  $x8  = $valor_diferencia;  }else{$x8  = Cantidades_decimales_justos($rowData['valor_diferencia']);}
					if(isset($Rango_ini)){         $x9  = $Rango_ini;         }else{$x9  = Cantidades_decimales_justos($rowData['Rango_ini']);}
					if(isset($Rango_fin)){         $x10 = $Rango_fin;         }else{$x10 = Cantidades_decimales_justos($rowData['Rango_fin']);}
					if(isset($HoraInicio)){        $x11 = $HoraInicio;        }else{$x11 = $rowData['HoraInicio'];}
					if(isset($HoraTermino)){       $x12 = $HoraTermino;       }else{$x12 = $rowData['HoraTermino'];}
					if(isset($idEstado)){          $x13 = $idEstado;          }else{$x13 = $rowData['idEstado'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_post_data(1,1,1, 'Seleccione un Tipo Alarma');
					$Form_Inputs->form_select('Tipo Alarma','idTipo', $x4, 2, 'idTipo', 'Nombre', 'telemetria_listado_alarmas_perso_tipos', 0, '', $dbConn);
					$Form_Inputs->form_input_number('N° Maximo Errores','NErroresMax', $x5, 2);
					$Form_Inputs->form_input_number('N° Actual Errores','NErroresActual', $x6, 1);
					//notificacion
					$sd_data = 'Tener presente lo siguiente:';
					$sd_data.= '<br/><strong> - Valor de error:</strong> se guarda el error al momento de que el o los sensores marquen todos un mismo valor, por ejemplo 99';
					$sd_data.= '<br/><strong> - Porcentaje de diferencia:</strong> se guarda el error al momento de que dos sensores tengan una diferencia de mas de un X% especificado aqui, por ejemplo dos sensores de niveles de presion, si tiene una diferencia mas alla del 25%';
					$sd_data.= '<br/><strong> - Valores Mínimo y Máximo:</strong> corresponde  a los valores de trabajo normal esperados por el o los sensores, por ejemplo en los sensores de temperatura, si se marca una mínima de 5 y una masxima de 10 grados, al momento de llegar un valor 4 se guardara el error ya que es inferior al minimo, mientras que si llega un valor de 11 pasara lo mismo ya que es superior al máximo';
					$Form_Inputs->form_post_data(2,1,1, $sd_data);
					//opcionales ocultos
					$Form_Inputs->form_input_number('Valor de error','valor_error', $x7, 1);
					$Form_Inputs->form_input_number('Porcentaje de diferencia','valor_diferencia', $x8, 1);
					$Form_Inputs->form_input_number('Valor Mínimo','Rango_ini', $x9, 1);
					$Form_Inputs->form_input_number('Valor Máximo','Rango_fin', $x10, 1);
					$Form_Inputs->form_time('Hora Inicio','HoraInicio', $x11, 1, 2);
					$Form_Inputs->form_time('Hora Termino','HoraTermino', $x12, 1, 2);

					$Form_Inputs->form_post_data(1,1,1, 'Tiene relacion a como se notificaran:<br/>- <strong>Normales</strong> = cada 60 minutos.<br/>- <strong>Catastrofica</strong> = cada 15 minutos.');
					$Form_Inputs->form_select('Prioridad Alarma','idTipoAlerta', $x2, 2, 'idTipoAlerta', 'Nombre', 'core_telemetria_tipo_alertas', 0, '', $dbConn);

					$Form_Inputs->form_post_data(1,1,1, 'Se utiliza unicamente en <strong>Informes Power-Crane - Alertas por Grua</strong> para poder agrupar los errores de voltaje.');
					$Form_Inputs->form_select('Unidad de Medida','idUniMed', $x3, 1, 'idUniMed', 'Nombre', 'telemetria_listado_unidad_medida', 0, '', $dbConn);

					$Form_Inputs->form_post_data(1,1,1, 'Al desactivarla, se elimina la opción de que la plataforma registre esta alarma');
					$Form_Inputs->form_select('Estado','idEstado', $x13, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idAlarma', $_GET['editAlarma'], 2);

					?>

					<script>

						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById("div_valor_error").style.display = "none";
							document.getElementById("div_valor_diferencia").style.display = "none";
							document.getElementById("div_Rango_ini").style.display = "none";
							document.getElementById("div_Rango_fin").style.display = "none";
							document.getElementById("div_HoraInicio").style.display = "none";
							document.getElementById("div_HoraTermino").style.display = "none";
							LoadTipo(0);
						});

						/**********************************************************************/
						document.getElementById("idTipo").onchange = function() {LoadTipo(1)};

						/**********************************************************************/
						function LoadTipo(caseLoad){
							//obtengo los valores
							let Sensores_val= $("#idTipo").val();
							//selecciono
							switch(Sensores_val) {
								//Errores Conjuntos
								case '1':
									document.getElementById("div_valor_error").style.display = "block";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Todos los sensores tienen el mismo valor de error";
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Rango Porcentaje Grupo
								case '2':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "block";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Un sensor tiene un valor que es x porcentaje inferior o superior a otro sensor dentro del grupo de sensores";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Alertas Personalizadas (al menos 1 error)
								case '3':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Al menos un sensor se encuentra fuera del rango de trabajo normal";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Alertas Personalizadas (todos con error)
								case '4':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Todos los sensores se encuentra fuera del rango de trabajo normal";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Promedios fuera de Rangos
								case '5':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "block";
									document.getElementById("div_Rango_fin").style.display = "block";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "El promedio de los sensores esta fuera del rango establecido";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Alertas Personalizadas (todos con valor especifico)
								case '6':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Todos los sensores estan con un valor predefinido, el cual indica error";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Sensor funcionando fuera de horario
								case '7':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "block";
									document.getElementById("div_HoraTermino").style.display = "block";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Los sensores seleccionados estan funcionando fuera de los horarios establecidos";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
									}
								break;
								//Promedios dentro de Rangos
								case '8':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "block";
									document.getElementById("div_Rango_fin").style.display = "block";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "El promedio de los sensores esta dentro del rango establecido";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;

							}

						}
					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['newAlarma'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Alarma Personalizada</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){            $x1  = $Nombre;            }else{$x1  = '';}
					if(isset($idTipoAlerta)){      $x2  = $idTipoAlerta;      }else{$x2  = '';}
					if(isset($idUniMed)){          $x3  = $idUniMed;          }else{$x3  = '';}
					if(isset($idTipo)){            $x4  = $idTipo;            }else{$x4  = '';}
					if(isset($NErroresMax)){       $x5  = $NErroresMax;       }else{$x5  = '';}
					if(isset($NErroresActual)){    $x6  = $NErroresActual;    }else{$x6  = '';}
					if(isset($valor_error)){       $x7  = $valor_error;       }else{$x7  = '';}
					if(isset($valor_diferencia)){  $x8  = $valor_diferencia;  }else{$x8  = '';}
					if(isset($Rango_ini)){         $x9  = $Rango_ini;         }else{$x9  = '';}
					if(isset($Rango_fin)){         $x10 = $Rango_fin;         }else{$x10 = '';}
					if(isset($HoraInicio)){        $x11 = $HoraInicio;        }else{$x11 = '';}
					if(isset($HoraTermino)){       $x12 = $HoraTermino;       }else{$x12 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_post_data(1,1,1, 'Seleccione un Tipo Alarma');
					$Form_Inputs->form_select('Tipo Alarma','idTipo', $x4, 2, 'idTipo', 'Nombre', 'telemetria_listado_alarmas_perso_tipos', 0, '', $dbConn);
					$Form_Inputs->form_input_number('N° Maximo Errores','NErroresMax', $x5, 2);
					$Form_Inputs->form_input_number('N° Actual Errores','NErroresActual', $x6, 1);
					//notificacion
					$sd_data = 'Tener presente lo siguiente:';
					$sd_data.= '<br/><strong> - Valor de error:</strong> se guarda el error al momento de que el o los sensores marquen todos un mismo valor, por ejemplo 99';
					$sd_data.= '<br/><strong> - Porcentaje de diferencia:</strong> se guarda el error al momento de que dos sensores tengan una diferencia de mas de un X% especificado aqui, por ejemplo dos sensores de niveles de presion, si tiene una diferencia mas alla del 25%';
					$sd_data.= '<br/><strong> - Valores Mínimo y Máximo:</strong> corresponde  a los valores de trabajo normal esperados por el o los sensores, por ejemplo en los sensores de temperatura, si se marca una mínima de 5 y una masxima de 10 grados, al momento de llegar un valor 4 se guardara el error ya que es inferior al minimo, mientras que si llega un valor de 11 pasara lo mismo ya que es superior al máximo';
					$Form_Inputs->form_post_data(2,1,1, $sd_data);
					//opcionales ocultos
					$Form_Inputs->form_input_number('Valor de error','valor_error', $x7, 1);
					$Form_Inputs->form_input_number('Porcentaje de diferencia','valor_diferencia', $x8, 1);
					$Form_Inputs->form_input_number('Valor Mínimo','Rango_ini', $x9, 1);
					$Form_Inputs->form_input_number('Valor Máximo','Rango_fin', $x10, 1);
					$Form_Inputs->form_time('Hora Inicio','HoraInicio', $x11, 1, 2);
					$Form_Inputs->form_time('Hora Termino','HoraTermino', $x12, 1, 2);

					$Form_Inputs->form_post_data(1,1,1, 'Tiene relacion a como se notificaran:<br/>- <strong>Normales</strong> = cada 60 minutos.<br/>- <strong>Catastrofica</strong> = cada 15 minutos.');
					$Form_Inputs->form_select('Prioridad Alarma','idTipoAlerta', $x2, 2, 'idTipoAlerta', 'Nombre', 'core_telemetria_tipo_alertas', 0, '', $dbConn);

					$Form_Inputs->form_post_data(1,1,1, 'Se utiliza unicamente en <strong>Informes Power-Crane - Alertas por Grua</strong> para poder agrupar los errores de voltaje.');
					$Form_Inputs->form_select('Unidad de Medida','idUniMed', $x3, 1, 'idUniMed', 'Nombre', 'telemetria_listado_unidad_medida', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);

					?>
					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById("div_valor_error").style.display = "none";
							document.getElementById("div_valor_diferencia").style.display = "none";
							document.getElementById("div_Rango_ini").style.display = "none";
							document.getElementById("div_Rango_fin").style.display = "none";
							document.getElementById("div_HoraInicio").style.display = "none";
							document.getElementById("div_HoraTermino").style.display = "none";
						});

						/**********************************************************************/
						document.getElementById("idTipo").onchange = function() {LoadTipo(1)};

						/**********************************************************************/
						function LoadTipo(caseLoad){
							//obtengo los valores
							let Sensores_val= $("#idTipo").val();
							//selecciono
							switch(Sensores_val) {
								//Errores Conjuntos
								case '1':
									document.getElementById("div_valor_error").style.display = "block";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Todos los sensores tienen el mismo valor de error";
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Rango Porcentaje Grupo
								case '2':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "block";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Un sensor tiene un valor que es x porcentaje inferior o superior a otro sensor dentro del grupo de sensores";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Alertas Personalizadas (al menos 1 error)
								case '3':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Al menos un sensor se encuentra fuera del rango de trabajo normal";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Alertas Personalizadas (todos con error)
								case '4':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Todos los sensores se encuentra fuera del rango de trabajo normal";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Promedios fuera de Rangos
								case '5':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "block";
									document.getElementById("div_Rango_fin").style.display = "block";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "El promedio de los sensores esta fuera del rango establecido";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Alertas Personalizadas (todos con valor especifico)
								case '6':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Todos los sensores estan con un valor predefinido, el cual indica error";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;
								//Sensor funcionando fuera de horario
								case '7':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "none";
									document.getElementById("div_Rango_fin").style.display = "none";
									document.getElementById("div_HoraInicio").style.display = "block";
									document.getElementById("div_HoraTermino").style.display = "block";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "Los sensores seleccionados estan funcionando fuera de los horarios establecidos";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="Rango_ini"]').value = '';
										document.querySelector('input[name="Rango_fin"]').value = '';
									}
								break;
								//Promedios dentro de Rangos
								case '8':
									document.getElementById("div_valor_error").style.display = "none";
									document.getElementById("div_valor_diferencia").style.display = "none";
									document.getElementById("div_Rango_ini").style.display = "block";
									document.getElementById("div_Rango_fin").style.display = "block";
									document.getElementById("div_HoraInicio").style.display = "none";
									document.getElementById("div_HoraTermino").style.display = "none";
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.getElementById("alert_post_data").innerHTML = "El promedio de los sensores esta dentro del rango establecido";
										document.querySelector('input[name="valor_error"]').value = '';
										document.querySelector('input[name="valor_diferencia"]').value = '';
										document.querySelector('input[name="HoraInicio"]').value = '';
										document.querySelector('input[name="HoraTermino"]').value = '';
									}
								break;

							}

						}
					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	// tomo los datos del equipo
	$rowData = db_select_data (false, 'Nombre,id_Geo, id_Sensores, cantSensores', 'telemetria_listado', '', 'idTelemetria ='.$_GET['id'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//defino los nombres de los sensores
	$subsql = '';
	for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
		$subsql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subsql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	}

	$SIS_query = '
	telemetria_listado_alarmas_perso.idAlarma,
	telemetria_listado_alarmas_perso.Nombre,
	telemetria_listado_alarmas_perso.idTipo,
	telemetria_listado_alarmas_perso.NErroresMax,
	telemetria_listado_alarmas_perso.NErroresActual,
	telemetria_listado_alarmas_perso.Rango_ini AS AlarmIni,
	telemetria_listado_alarmas_perso.Rango_fin AS AlarmFin,
	telemetria_listado_alarmas_perso.HoraInicio AS HoraIni,
	telemetria_listado_alarmas_perso.HoraTermino AS HoraFin,
	telemetria_listado_alarmas_perso_tipos.Nombre AS Tipo,
	telemetria_listado_alarmas_perso_items.Sensor_N,
	telemetria_listado_alarmas_perso_items.Rango_ini,
	telemetria_listado_alarmas_perso_items.Rango_fin,
	telemetria_listado_alarmas_perso_items.valor_especifico,
	core_telemetria_tipo_alertas.Nombre AS Prioridad,
	telemetria_listado_unidad_medida.Nombre AS Unimed,
	telemetria_listado_alarmas_perso.idTipoAlerta,
	core_estados.Nombre AS Estado,
	telemetria_listado_alarmas_perso.idEstado'.$subsql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_alarmas_perso_tipos` ON telemetria_listado_alarmas_perso_tipos.idTipo    = telemetria_listado_alarmas_perso.idTipo
	LEFT JOIN `telemetria_listado_alarmas_perso_items` ON telemetria_listado_alarmas_perso_items.idAlarma  = telemetria_listado_alarmas_perso.idAlarma
	LEFT JOIN `telemetria_listado`                     ON telemetria_listado.idTelemetria                  = telemetria_listado_alarmas_perso.idTelemetria
	LEFT JOIN `core_telemetria_tipo_alertas`           ON core_telemetria_tipo_alertas.idTipoAlerta        = telemetria_listado_alarmas_perso.idTipoAlerta
	LEFT JOIN `telemetria_listado_unidad_medida`       ON telemetria_listado_unidad_medida.idUniMed        = telemetria_listado_alarmas_perso.idUniMed
	LEFT JOIN `core_estados`                           ON core_estados.idEstado                            = telemetria_listado_alarmas_perso.idEstado
	LEFT JOIN `telemetria_listado_sensores_nombre`     ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado_alarmas_perso.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`      ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado_alarmas_perso.idTelemetria';
	$SIS_where = 'telemetria_listado_alarmas_perso.idTelemetria ='.$_GET['id'];
	$SIS_order = 'telemetria_listado_alarmas_perso.idEstado ASC, telemetria_listado_alarmas_perso.Nombre ASC';
	$arrAlarmas = array();
	$arrAlarmas = db_select_array (false, $SIS_query, 'telemetria_listado_alarmas_perso', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAlarmas');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	$arrGruposEx    = array();
	foreach ($arrGrupos as $sen) {    $arrGruposEx[$sen['idGrupo']] = $sen['Nombre'];}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Nombre'], 'Editar Alertas Personalizadas'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location; ?>&newAlarma=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Alarma</a><?php } ?>
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
								<li class="active"><a href="<?php echo 'telemetria_listado_alarmas_perso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bullhorn" aria-hidden="true"></i> Alarmas Personalizadas</a></li>
							<?php } ?>
							<?php if($rowData['id_Geo']==1){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_gps.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Datos GPS</a></li>
							<?php }elseif($rowData['id_Geo']==2){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_direccion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-signs" aria-hidden="true"></i> Dirección</a></li>
							<?php } ?>
							<?php if($rowData['id_Sensores']==1){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_parametros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Sensores</a></li>
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
					<thead>
						<tr role="row">
							<th>Tipo</th>
							<th>Nombre</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						filtrar($arrAlarmas, 'idAlarma');
						foreach($arrAlarmas as $tipo=>$alarmas){ ?>
							<tr class="odd">
								<td>
									<?php
									//Si esta activada
									if(isset($alarmas[0]['idEstado'])&&$alarmas[0]['idEstado']==1){
										$label_color_1 = 'label-success';
									//si esta desactivada
									}else{
										$label_color_1 = 'label-danger';
									}
									//Si es normal
									if(isset($alarmas[0]['idTipoAlerta'])&&$alarmas[0]['idTipoAlerta']==1){
										$label_color_2 = 'label-success';
									//si es catastrofica
									}else{
										$label_color_2 = 'label-danger';
									}
									//imprimo
									echo '<strong>Estado: </strong><label class="label '.$label_color_1.'">'.$alarmas[0]['Estado'].'</label><br/>';
									echo '<strong>Tipo: </strong>'.$alarmas[0]['Tipo'].'<br/>';
									echo '<strong>Prioridad Alarma: </strong><label class="label '.$label_color_2.'">'.$alarmas[0]['Prioridad'].'</label><br/>';
									if(isset($alarmas[0]['Unimed'])&&$alarmas[0]['Unimed']!=''){echo '<strong>Unidad Medida: </strong>'.$alarmas[0]['Unimed'].'<br/>';}
									echo '<strong>N° Maximo Errores: </strong>'.$alarmas[0]['NErroresMax'].'<br/>';
									echo '<strong>N° Actual Errores: </strong>'.$alarmas[0]['NErroresActual'].'<br/>';
									?>
								</td>
								<td>
									<?php
									echo '<strong>Nombre: </strong>'.$alarmas[0]['Nombre'];
									if(isset($alarmas[0]['AlarmIni'],$alarmas[0]['AlarmFin'])&&$alarmas[0]['AlarmIni']!=0&&$alarmas[0]['AlarmFin']!=0){
										echo '<br/>('.Cantidades_decimales_justos($alarmas[0]['AlarmIni']).' / '.Cantidades_decimales_justos($alarmas[0]['AlarmFin']).')';
									}
									if(isset($alarmas[0]['HoraIni'],$alarmas[0]['HoraFin'])&&$alarmas[0]['HoraIni']!='00:00:00'&&$alarmas[0]['HoraFin']!='00:00:00'){
										echo '<br/>(Activo desde '.$alarmas[0]['HoraIni'].' hasta las '.$alarmas[0]['HoraFin'].')';
									}
									echo '<br/><strong>Sensores: </strong>';
									echo '<ul>';
									foreach ($alarmas as $alarm) {
										//grupo si es que existe
										$sub_nom = '';
										if(isset($alarm['SensoresGrupo_'.$alarm['Sensor_N']],$arrGruposEx[$alarm['SensoresGrupo_'.$alarm['Sensor_N']]])&&$arrGruposEx[$alarm['SensoresGrupo_'.$alarm['Sensor_N']]]!=''){
											$sub_nom .= $arrGruposEx[$alarm['SensoresGrupo_'.$alarm['Sensor_N']]].' - ';
										}
										//nombre del sensor
										if(isset($alarm['SensoresNombre_'.$alarm['Sensor_N']])&&$alarm['SensoresNombre_'.$alarm['Sensor_N']]!=''){
											$sub_nom .= $alarm['SensoresNombre_'.$alarm['Sensor_N']];
										}
										//valores
										if(isset($alarmas[0]['idTipo'])&&$alarmas[0]['idTipo']!=''){
											switch ($alarmas[0]['idTipo']) {
												case 3:
												case 4:
													$sub_nom .= ' (Rango: '.Cantidades_decimales_justos($alarm['Rango_ini']).' / '.Cantidades_decimales_justos($alarm['Rango_fin']).')';
													break;
												case 6:
													$sub_nom .= ' (Valor Especifico: '.Cantidades_decimales_justos($alarm['valor_especifico']).')';
													break;
												case 7:
													$sub_nom .= ' (Valor Encendido: '.Cantidades_decimales_justos($alarm['valor_especifico']).')';
													break;
											}
										}
										echo '<li>-> '.TituloMenu($sub_nom).'</li>';
									}
									echo '</ul>';
									?>
								</td>
								<td>
									<div class="btn-group" style="width: 105px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&editAlarma='.$tipo; ?>" title="Editar Datos Básicos" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&nombre_equipo='.$alarmas[0]['Nombre'].'&listItems='.$tipo.'&idTipo='.$alarmas[0]['idTipo']; ?>" title="Editar Sensores" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											//se verifica que el usuario no sea uno mismo
											$ubicacion = $new_location.'&delAlarma='.simpleEncode($tipo, fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la alarma personalizada '.$alarmas[0]['Nombre'].'?'; ?>
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
