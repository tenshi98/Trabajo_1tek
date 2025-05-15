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
$new_location = "telemetria_listado_script.php";
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
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_script.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_script.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_script.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_file';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_script.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Script Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Script Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Script Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado_script.Observacion,
telemetria_listado_script.cantSensores,
telemetria_listado_script.idAPNListado,
telemetria_listado_script.idPuertoSerial,
telemetria_listado_script.pinMode,
telemetria_listado_script.idModificado,
telemetria_listado_script.ScriptFile,
telemetria_listado_dispositivos.Nombre AS Dispositivo,
telemetria_listado_shield.Nombre AS Shield,
telemetria_listado_forma_envio.Nombre AS FormaEnvio,
core_telemetria_tabs.Nombre AS Tab,
opc2.Nombre AS Geo,
opc3.Nombre AS Sensores';
$SIS_join  = '
LEFT JOIN `telemetria_listado`                   ON telemetria_listado.idTelemetria                    = telemetria_listado_script.idTelemetria
LEFT JOIN `telemetria_listado_dispositivos`      ON telemetria_listado_dispositivos.idDispositivo      = telemetria_listado_script.idDispositivo
LEFT JOIN `telemetria_listado_shield`            ON telemetria_listado_shield.idShield                 = telemetria_listado_script.idShield
LEFT JOIN `telemetria_listado_forma_envio`       ON telemetria_listado_forma_envio.idFormaEnvio        = telemetria_listado_script.idFormaEnvio
LEFT JOIN `core_telemetria_tabs`                 ON core_telemetria_tabs.idTab                         = telemetria_listado_script.idTab
LEFT JOIN `core_sistemas_opciones`        opc2   ON opc2.idOpciones                                    = telemetria_listado_script.id_Geo
LEFT JOIN `core_sistemas_opciones`        opc3   ON opc3.idOpciones                                    = telemetria_listado_script.id_Sensores';
$SIS_where = 'telemetria_listado_script.idScript ='.$_GET['edit'];
// consulto los datos
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_script', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Script Equipo <?php echo $rowData['Nombre']; ?></h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idAPNListado)){      $x1 = $idAPNListado;     }else{$x1 = $rowData['idAPNListado'];}
				if(isset($idPuertoSerial)){    $x2 = $idPuertoSerial;   }else{$x2 = $rowData['idPuertoSerial'];}
				if(isset($pinMode)){           $x3 = $pinMode;          }else{$x3 = $rowData['pinMode'];}
				if(isset($Observacion)){       $x4 = $Observacion;      }else{$x4 = $rowData['Observacion'];}
				if(isset($idModificado)){      $x5 = $idModificado;     }else{$x5 = $rowData['idModificado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_disabled('Hardware','fake_emp', $rowData['Dispositivo']);
				$Form_Inputs->form_input_disabled('SHIELD','fake_emp', $rowData['Shield']);
				$Form_Inputs->form_input_disabled('Tab','fake_emp', $rowData['Tab']);
				$Form_Inputs->form_input_disabled('Geolocalizacion','fake_emp', $rowData['Geo']);
				$Form_Inputs->form_input_disabled('Sensores','fake_emp', $rowData['Sensores']);
				$Form_Inputs->form_input_disabled('Cantidad Sensores','fake_emp', $rowData['cantSensores']);
				//INPUTS
				$Form_Inputs->form_select('Dirección APN','idAPNListado', $x1, 2, 'idAPNListado', 'Nombre', 'telemetria_listado_script_apn_listado', 0, '', $dbConn);
				$Form_Inputs->form_select('Puerto Serial','idPuertoSerial', $x2, 2, 'idPuertoSerial', 'Nombre', 'telemetria_listado_script_puerto_serial', 0, '', $dbConn);
				$Form_Inputs->form_input_number_spinner('pinMode','pinMode', $x3, 0, 70, '1', 0, 2);
				$Form_Inputs->form_textarea('Observaciones', 'Observacion', $x4, 2);
				$Form_Inputs->form_select('Modificado','idModificado', $x5, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				if(isset($rowData['ScriptFile'])&&$rowData['ScriptFile']!=''){ ?>

					<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
						<h3>Archivo</h3>
						<?php echo preview_docs(DB_SITE_REPO.DB_SITE_MAIN_PATH, 'upload/'.$rowData['ScriptFile'], ''); ?>
						<br/>
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&del_file='.$_GET['edit']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Archivo</a>
					</div>
					<div class="clearfix"></div>

				<?php }else{
						$Form_Inputs->form_multiple_upload('Seleccionar archivo','ScriptFile', 1, '"ino"');
				}

				$Form_Inputs->form_input_hidden('idScript', $_GET['edit'], 2);
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
//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$i;
}
// consulto los datos
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.idDispositivo,
telemetria_listado.idShield,
telemetria_listado.idFormaEnvio,
telemetria_listado.idTab,
telemetria_listado.id_Geo,
telemetria_listado.id_Sensores,
telemetria_listado.cantSensores,

telemetria_listado_dispositivos.Nombre AS Dispositivo,
telemetria_listado_shield.Nombre AS Shield,
telemetria_listado_forma_envio.Nombre AS FormaEnvio,
core_telemetria_tabs.Nombre AS Tab,
opc2.Nombre AS Geo,
opc3.Nombre AS Sensores

'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_dispositivos`      ON telemetria_listado_dispositivos.idDispositivo      = telemetria_listado.idDispositivo
LEFT JOIN `telemetria_listado_shield`            ON telemetria_listado_shield.idShield                 = telemetria_listado.idShield
LEFT JOIN `telemetria_listado_forma_envio`       ON telemetria_listado_forma_envio.idFormaEnvio        = telemetria_listado.idFormaEnvio
LEFT JOIN `core_telemetria_tabs`                 ON core_telemetria_tabs.idTab                         = telemetria_listado.idTab
LEFT JOIN `core_sistemas_opciones`        opc2   ON opc2.idOpciones                                    = telemetria_listado.id_Geo
LEFT JOIN `core_sistemas_opciones`        opc3   ON opc3.idOpciones                                    = telemetria_listado.id_Sensores
LEFT JOIN `telemetria_listado_sensores_tipo`     ON telemetria_listado_sensores_tipo.idTelemetria      = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query , 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Script Equipo <?php echo $rowData['Nombre']; ?></h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idAPNListado)){      $x1  = $idAPNListado;     }else{$x1  = '';}
				if(isset($Observacion)){       $x2  = $Observacion;      }else{$x2  = '';}
				if(isset($pinMode)){           $x3  = $pinMode;          }else{$x3  = '53';}
				if(isset($Observacion)){       $x4  = $Observacion;      }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_disabled('Hardware','fake_emp', $rowData['Dispositivo']);
				$Form_Inputs->form_input_disabled('SHIELD','fake_emp', $rowData['Shield']);
				$Form_Inputs->form_input_disabled('Forma de Envio','fake_emp', $rowData['FormaEnvio']);
				$Form_Inputs->form_input_disabled('Tab','fake_emp', $rowData['Tab']);
				$Form_Inputs->form_input_disabled('Geolocalizacion','fake_emp', $rowData['Geo']);
				$Form_Inputs->form_input_disabled('Sensores','fake_emp', $rowData['Sensores']);
				$Form_Inputs->form_input_disabled('Cantidad Sensores','fake_emp', $rowData['cantSensores']);
				//INPUTS
				$Form_Inputs->form_select('Dirección APN','idAPNListado', $x1, 2, 'idAPNListado', 'Nombre', 'telemetria_listado_script_apn_listado', 0, '', $dbConn);
				$Form_Inputs->form_select('Puerto Serial','idPuertoSerial', $x2, 2, 'idPuertoSerial', 'Nombre', 'telemetria_listado_script_puerto_serial', 0, '', $dbConn);
				$Form_Inputs->form_input_number_spinner('pinMode','pinMode', $x3, 0, 70, '1', 0, 2);
				$Form_Inputs->form_textarea('Observaciones', 'Observacion', $x4, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);

				$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('Fecha', fecha_actual(), 2);

				$Form_Inputs->form_input_hidden('idDispositivo', $rowData['idDispositivo'], 2);
				$Form_Inputs->form_input_hidden('idShield', $rowData['idShield'], 2);
				$Form_Inputs->form_input_hidden('idFormaEnvio', $rowData['idFormaEnvio'], 2);
				$Form_Inputs->form_input_hidden('idTab', $rowData['idTab'], 2);
				$Form_Inputs->form_input_hidden('id_Geo', $rowData['id_Geo'], 2);
				$Form_Inputs->form_input_hidden('id_Sensores', $rowData['id_Sensores'], 2);
				$Form_Inputs->form_input_hidden('cantSensores', $rowData['cantSensores'], 2);
				for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
					$Form_Inputs->form_input_hidden('SensoresTipo_'.$i, $rowData['SensoresTipo_'.$i], 2);
				}
				$Form_Inputs->form_input_hidden('idModificado', 1, 2);

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
// consulto los datos
$rowData = db_select_data (false, 'Nombre,id_Geo, id_Sensores', 'telemetria_listado', '', 'idTelemetria ='.$_GET['id'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

// consulto los datos
$SIS_query = '
telemetria_listado_script.idScript,
usuarios_listado.Nombre AS nombre_usuario,
telemetria_listado_script.Fecha,
telemetria_listado_script.Version,
telemetria_listado_script.idModificado,
core_sistemas_opciones.Nombre AS Modificado';
$SIS_join  = '
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario          = telemetria_listado_script.idUsuario
LEFT JOIN `core_sistemas_opciones`   ON core_sistemas_opciones.idOpciones   = telemetria_listado_script.idModificado';
$SIS_where = 'telemetria_listado_script.idTelemetria ='.$_GET['id'];
$SIS_order = 'telemetria_listado_script.idScript ASC';
$arrScripts = array();
$arrScripts = db_select_array (false, $SIS_query, 'telemetria_listado_script', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrScripts');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Nombre'], 'Editar Scripts'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Script</a><?php } ?>
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
							<li class=""><a href="<?php echo 'telemetria_listado_sensor_operaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Definicion Operacional</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'telemetria_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_trabajo.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-clock-o" aria-hidden="true"></i> Jornada Trabajo</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_otros_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-archive" aria-hidden="true"></i> Otros Datos</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class="active"><a href="<?php echo 'telemetria_listado_script.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-code" aria-hidden="true"></i> Scripts</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="120">Version</th>
						<th>Fecha</th>
						<th>Autor</th>
						<th></th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrScripts as $script) { ?>
						<tr class="odd">
							<td><?php echo $script['Version']; ?></td>
							<td><?php echo fecha_estandar($script['Fecha']); ?></td>
							<td><?php echo $script['nombre_usuario']; ?></td>
							<td>
								<?php
								if(isset($script['idModificado'])&&$script['idModificado']==1){
									echo '<span class="label label-danger">'.$script['Modificado'].'</span>';
								}else{
									echo $script['Modificado'];
								} ?>
							</td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria_script.php?view='.simpleEncode($script['idScript'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$script['idScript']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($script['idScript'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la observacion del usuario '.$script['nombre_usuario'].'?'; ?>
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
