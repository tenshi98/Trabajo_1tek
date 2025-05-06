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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "view_alertas_personalizadas.php";
$location = $original;
$location .='?view='.$_GET['view'];
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Si el estado esta distinto de vacio
if (!empty($_GET['estado'])){
	//Llamamos al formulario
	$form_trabajo= 'estado';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso.php';
}
//Si el estado esta distinto de vacio
if (!empty($_GET['estadoAll'])){
	//Llamamos al formulario
	$form_trabajo= 'estadoAll';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_alarmas_perso.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
// tomo los datos del equipo
$rowData = db_select_data (false, 'Nombre, cantSensores', 'telemetria_listado', '', 'idTelemetria ='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//defino los nombres de los sensores
$SIS_query = '
telemetria_listado_alarmas_perso.idAlarma,
telemetria_listado_alarmas_perso.Nombre,
telemetria_listado_alarmas_perso.idTipo,
telemetria_listado_alarmas_perso.NErroresMax,
telemetria_listado_alarmas_perso.NErroresActual,
telemetria_listado_alarmas_perso.Rango_ini AS AlarmIni,
telemetria_listado_alarmas_perso.Rango_fin AS AlarmFin,
telemetria_listado_alarmas_perso_tipos.Nombre AS Tipo,
telemetria_listado_alarmas_perso_items.Sensor_N,
telemetria_listado_alarmas_perso_items.Rango_ini,
telemetria_listado_alarmas_perso_items.Rango_fin,
telemetria_listado_alarmas_perso_items.valor_especifico,
core_telemetria_tipo_alertas.Nombre AS Prioridad,
telemetria_listado_unidad_medida.Nombre AS Unimed,
telemetria_listado_alarmas_perso.idTipoAlerta,
core_estados.Nombre AS Estado,
telemetria_listado_alarmas_perso.idEstado';
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
    $SIS_query .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
    $SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
}
$SIS_join  = '
LEFT JOIN `telemetria_listado_alarmas_perso_tipos` ON telemetria_listado_alarmas_perso_tipos.idTipo    = telemetria_listado_alarmas_perso.idTipo
LEFT JOIN `telemetria_listado_alarmas_perso_items` ON telemetria_listado_alarmas_perso_items.idAlarma  = telemetria_listado_alarmas_perso.idAlarma
LEFT JOIN `core_telemetria_tipo_alertas`           ON core_telemetria_tipo_alertas.idTipoAlerta        = telemetria_listado_alarmas_perso.idTipoAlerta
LEFT JOIN `telemetria_listado_unidad_medida`       ON telemetria_listado_unidad_medida.idUniMed        = telemetria_listado_alarmas_perso.idUniMed
LEFT JOIN `core_estados`                           ON core_estados.idEstado                            = telemetria_listado_alarmas_perso.idEstado
LEFT JOIN `telemetria_listado_sensores_nombre`     ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado_alarmas_perso.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`      ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado_alarmas_perso.idTelemetria';
$SIS_where = 'telemetria_listado_alarmas_perso.idTelemetria ='.$X_Puntero;
$SIS_order = 'telemetria_listado_alarmas_perso.idEstado ASC, telemetria_listado_alarmas_perso.Nombre ASC';
$arrAlarmas = array();
$arrAlarmas = db_select_array (false, $SIS_query, 'telemetria_listado_alarmas_perso', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAlarmas');

$arrGrupos = array();
$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

$arrGruposEx    = array();
foreach ($arrGrupos as $sen) {    $arrGruposEx[$sen['idGrupo']] = $sen['Nombre'];}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Alertas Personalizadas del equipo <?php echo $rowData['Nombre']; ?></h5>
		</header>
        <div class="tab-content">
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
						<tr class="odd">
							<td colspan="2"><strong>Activar-Desactivar Todos</strong></td>
							<td>
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php
									$ubicacion_1 = $location.'&estadoAll='.simpleEncode(2, fecha_actual());
									$dialogo_1   = 'Al desactivar todas las alertas , el sistema dejará de detectar mediciones fuera de rango. ¿Estás seguro que deseas continuar?';
									$ubicacion_2 = $location.'&estadoAll='.simpleEncode(1, fecha_actual());
									$dialogo_2   = '¿Realmente deseas activar todas las alertas?';
									?>
									<a class="btn btn-sm btn-default unlocked_inactive" onClick="dialogBox('<?php echo $ubicacion_1 ?>', '<?php echo $dialogo_1 ?>')">OFF</a>
									<a class="btn btn-sm btn-default unlocked_inactive" onClick="dialogBox('<?php echo $ubicacion_2 ?>', '<?php echo $dialogo_2 ?>')">ON</a>
								</div>
							</td>
						</tr>
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
									if(isset($alarmas[0]['AlarmIni'])&&$alarmas[0]['AlarmIni']!=0&&isset($alarmas[0]['AlarmFin'])&&$alarmas[0]['AlarmFin']!=0){
										echo '('.Cantidades_decimales_justos($alarmas[0]['AlarmIni']).' / '.Cantidades_decimales_justos($alarmas[0]['AlarmFin']).')<br/>';
									}else{
										echo '<br/>';
									}

									echo '<strong>Sensores: </strong>';
									echo '<ul>';
									foreach ($alarmas as $alarm) {
										//grupo si es que existe
										$sub_nom = '';
										if(isset($alarm['SensoresGrupo_'.$alarm['Sensor_N']])&&isset($arrGruposEx[$alarm['SensoresGrupo_'.$alarm['Sensor_N']]])&&$arrGruposEx[$alarm['SensoresGrupo_'.$alarm['Sensor_N']]]!=''){
											$sub_nom .= $arrGruposEx[$alarm['SensoresGrupo_'.$alarm['Sensor_N']]].' - ';
										}
										//nombre del sensor
										if(isset($alarm['SensoresNombre_'.$alarm['Sensor_N']])&&$alarm['SensoresNombre_'.$alarm['Sensor_N']]!=''){
											$sub_nom .= $alarm['SensoresNombre_'.$alarm['Sensor_N']];
										}
										//valores
										if(isset($alarmas[0]['idTipo'])&&$alarmas[0]['idTipo']!=''&&($alarmas[0]['idTipo']==3 OR $alarmas[0]['idTipo']==4)){
											$sub_nom .= ' (Rango: '.Cantidades_decimales_justos($alarm['Rango_ini']).' / '.Cantidades_decimales_justos($alarm['Rango_fin']).')';
										}elseif(isset($alarmas[0]['idTipo'])&&$alarmas[0]['idTipo']!=''&&$alarmas[0]['idTipo']==6){
											$sub_nom .= ' (Valor especifico: '.Cantidades_decimales_justos($alarm['valor_especifico']).')';
										}

										/*if(isset($alarm['Rango_ini'])&&$alarm['Rango_ini']!=0&&isset($alarm['Rango_fin'])&&$alarm['Rango_fin']!=0){
											$sub_nom .= '('.Cantidades_decimales_justos($alarm['Rango_ini']).' / '.Cantidades_decimales_justos($alarm['Rango_fin']).')';
										}*/
										echo '<li>'.$sub_nom.'</li>';
									}
									echo '</ul>';

									?>
								</td>
								<td>
									<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
										<?php if ( $alarmas[0]['idEstado']==1 ) {
											$ubicacion = $location.'&idAlarma='.simpleEncode($tipo, fecha_actual()).'&estado='.simpleEncode(2, fecha_actual());
											$dialogo   = 'Al desactivar las alertas '.$alarmas[0]['Nombre'].', el sistema dejará de detectar mediciones fuera de rango. ¿Estás seguro que deseas continuar?';
											?>
											<a class="btn btn-sm btn-default unlocked_inactive" onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')">OFF</a>
											<a class="btn btn-sm btn-info locked_active" href="#">ON</a>
										<?php } else {
											$ubicacion = $location.'&idAlarma='.simpleEncode($tipo, fecha_actual()).'&estado='.simpleEncode(1, fecha_actual());
											$dialogo   = '¿Realmente deseas activar las alertas '.$alarmas[0]['Nombre'].'?';
											?>
											<a class="btn btn-sm btn-info locked_active" href="#">OFF</a>
											<a class="btn btn-sm btn-default unlocked_inactive" onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')">ON</a>
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
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';
//cuadro mensajes
widget_avgrund();

?>
