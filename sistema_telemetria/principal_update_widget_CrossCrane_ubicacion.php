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
/*                                                      Consulta                                                                  */
/**********************************************************************************************************************************/
//defino variables
$idTipoUsuario  = $_SESSION['usuario']['zona']['idTipoUsuario'];
$idSistema      = $_SESSION['usuario']['zona']['idSistema'];
$idUsuario      = $_SESSION['usuario']['zona']['idUsuario'];
if(isset($_SESSION['usuario']['zona']['id_Geo'])&&$_SESSION['usuario']['zona']['id_Geo']!=''){
	$id_Geo = $_SESSION['usuario']['zona']['id_Geo'];
}else{
	$id_Geo = 1;//seguimiento activo
}
//variables
$FechaSistema   = fecha_actual();
$Fecha_inicio   = restarDias(fecha_actual(),1);
$Fecha_fin      = fecha_actual();
$principioMes   = fecha2Ano($FechaSistema).'-'.fecha2NMes($FechaSistema).'-01';
$HoraSistema    = hora_actual();
$arrGruas       = array();
$nicon          = 0;

//condicionales
if(isset($_GET['idZona'])&&$_GET['idZona']!=''){
	//Variables
	$idZona  = $_GET['idZona'];
	//redefino la variable temporal de la zona
	$_SESSION['usuario']['zona']['idZona'] = $idZona;
}else{
	$idZona  = $_SESSION['usuario']['zona']['idZona'];
}

/************************************************/
//se traen todas las zonas
$arrZonas = array();
$arrZonas = db_select_array (false, 'idZona, Nombre', 'telemetria_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

/************************************************/
//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}
//Listar los equipos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
telemetria_listado.Identificador,
telemetria_listado.NumSerie,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.NErrores,
telemetria_listado.NAlertas,
telemetria_listado.idGenerador,
telemetria_listado.idTelGenerador,
telemetria_listado.SensorActivacionID,
telemetria_listado.SensorActivacionValor,
telemetria_listado.idUsoFTP,
telemetria_listado.FTP_Carpeta,
telemetria_listado.idUbicacion,
telemetria_listado.cantSensores,
telemetria_listado.id_Sensores
'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria       = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idEstado = 1';            //solo equipos activos
$SIS_where.= ' AND telemetria_listado.id_Geo = '.$id_Geo;  //solo los equipos que tengan el seguimiento activado
$SIS_where.= ' AND telemetria_listado.idTab = 6';          //Power-Crane
//Filtro el sistema al cual pertenece
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){ $SIS_where.= ' AND telemetria_listado.idSistema = '.$idSistema;}
//Filtro la zona si existe
if(isset($idZona)&&$idZona!=''&&$idZona!=9999){
	//Selecciono el tipo
	switch ($idZona) {
		case 1: $SIS_where .= " AND telemetria_listado.NumSerie LIKE 'gr%'"; break;
		case 2: $SIS_where .= " AND telemetria_listado.NumSerie LIKE 'elv%'"; break;
		case 3: $SIS_where .= " AND telemetria_listado.NumSerie LIKE 'gen%'"; break;
	}
}
//Filtro por el tipo de usuario
if(isset($idTipoUsuario)&&$idTipoUsuario!=1&&isset($idUsuario)&&$idUsuario!=0){
	$SIS_join .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where.= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
}
$SIS_order = 'telemetria_listado.Nombre ASC';
//Realizo la consulta
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

/*************************************************************/
//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

//Ordeno las unidades de medida
$arrFinalUnimed = array();
foreach ($arrUnimed as $data) {
	$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
}

/**************************************************************************/
//variables

/**************************************************************************/
//transaccion a verificar
$transx = "admin_telemetria_encendido_apagado.php";   //Transaccion de encendido-apagado

//Seteo la variable a 0
$prm_xa = 0;
//recorro los permisos
if(isset($_SESSION['usuario']['menu'])){
	foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
		foreach($productos as $producto) {
			//elimino los datos extras
			$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
			//le asigno el valor 1 en caso de que exista
			if($transx==$str){
				$prm_xa = 1;
			}
		}
	}
}
/**************************************************************************/
foreach ($arrEquipo as $data) {

	/**********************************************/
	//Se resetean
	$in_eq_alertas     = 0;
	$in_eq_fueralinea  = 0;
	$in_eq_ok          = 1;
	$in_sens_activ     = 0;

	/**********************************************/
	//veo si tiene configurado el sensor de activacion y si esta encendido
	if(isset($data['SensorActivacionID'])&&$data['SensorActivacionID']!=0){
		if(isset($data['SensoresMedActual_'.$data['SensorActivacionID']])&&$data['SensoresMedActual_'.$data['SensorActivacionID']]==$data['SensorActivacionValor']){
			$in_sens_activ = 1; //activo encendido
		}else{
			$in_sens_activ = 2; //activo apagado
		}
	}else{
		$in_sens_activ = 0; //inactivo
	}

	/**********************************************/
	//Fuera de linea
	$diaInicio   = $data['LastUpdateFecha'];
	$diaTermino  = $FechaSistema;
	$tiempo1     = $data['LastUpdateHora'];
	$tiempo2     = $HoraSistema;
	$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

	//Comparaciones de tiempo
	$Time_Tiempo     = horas2segundos($Tiempo);
	$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
	$Time_Tiempo_Max = horas2segundos('48:00:00');
	$Time_Fake_Ini   = horas2segundos('23:59:50');
	$Time_Fake_Fin   = horas2segundos('24:00:00');
	//comparacion
	if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
		$in_eq_fueralinea++;
	}

	/**********************************************/
	//Equipos Errores
	if($data['NErrores']>0){ $in_eq_alertas++; }

	/*******************************************************/
	//rearmo
	if($in_eq_alertas>0){    $in_eq_ok = 0;  $in_eq_alertas    = 1;    }
	if($in_eq_fueralinea>0){ $in_eq_ok = 0;  $in_eq_fueralinea = 1; $in_eq_alertas = 0;  }

	/*******************************************************/
	//se guardan estados
	$danger = '';
	$xdanger = 1;
	if($in_eq_alertas>0){    $danger = 'warning';  $xdanger = 2; $dataex = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
	if($in_eq_fueralinea>0){ $danger = 'danger';   $xdanger = 3; $dataex = '<a href="#" title="Fuera de Linea" class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

	/*******************************************************/
	//traspasan los estados
	if($in_eq_ok==1){
		$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
	}else{
		$eq_ok_icon = $dataex;
	}
	/*******************************************************/
	//El icono de estado de encendido apagado
	$idSensorResp = 38; //sensor que guarda la respuesta del equipo
	//si tiene los permisos
	if(isset($data['SensoresMedActual_'.$idSensorResp])&&$data['SensoresMedActual_'.$idSensorResp]!=''){
		switch ($data['SensoresMedActual_'.$idSensorResp]) {
			//inactivo
			case 0:
				$status_icon = '';
				$wid_status = 35;
				break;
			//activo encendido
			case 1:
				//$status_icon = '<a href="" title="Encendido Remoto" class="btn btn-success btn-sm tooltip"><i class="fa fa-unlock" aria-hidden="true"></i></a>';
				//$wid_status = 70;
				$status_icon = '';
				$wid_status = 35;
				break;
			//activo apagado
			case 2:
				$status_icon = '<a href="" title="Apagado Remoto" class="btn btn-warning btn-sm tooltip"><i class="fa fa-lock" aria-hidden="true"></i></a>';
				$wid_status = 70;
				break;
		}
	}else{
		$status_icon = '';
		$wid_status = 35;
	}

	/*************************************************************************/
	//Unidad de medida
	if(isset($arrFinalUnimed[$data['SensoresUniMed_37']])){
		$UniMed_37 = $arrFinalUnimed[$data['SensoresUniMed_37']];
	}else{
		$UniMed_37 = '';
	}
	//Unidad de medida
	if(isset($arrFinalUnimed[$data['SensoresUniMed_39']])){
		$UniMed_39 = $arrFinalUnimed[$data['SensoresUniMed_39']];
	}else{
		$UniMed_39 = '';
	}
	//Guardo todos los datos
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['tr_color']     = $danger;
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['wid_status']   = $wid_status;
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['eq_ok_icon']   = $eq_ok_icon;
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['status_icon']  = $status_icon;
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Nombre']       = $data['Nombre'];
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['LastUpdate']   = fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'];
	if(isset($data['SensoresMedActual_37'])&&$data['SensoresMedActual_37']!=''&&$data['SensoresMedActual_37']!=0&&$data['SensoresMedActual_37']<99900){
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Voltaje'] = cantidades($data['SensoresMedActual_37'], 1).' '.$UniMed_37;
	}else{
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Voltaje'] = '0 '.$UniMed_37;
	}
	if(isset($data['SensoresMedActual_39'])&&$data['SensoresMedActual_39']!=''&&$data['SensoresMedActual_39']!=0&&$data['SensoresMedActual_39']<99900){
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Viento'] = cantidades($data['SensoresMedActual_39'], 1).' '.$UniMed_39;
	}else{
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Viento'] = 'N/A';
	}
	//si tiene los permisos
	if(isset($prm_xa)&&$prm_xa==1){
		switch ($in_sens_activ) {
			//inactivo
			case 0:
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '';
				break;
			//activo encendido
			case 1:
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="view_crosscrane_apagado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Cambiar Estado" class="iframe btn btn-success btn-sm tooltip"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
				break;
			//activo apagado
			case 2:
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="view_crosscrane_apagado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Cambiar Estado" class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
				break;
		}
	}else{
		switch ($in_sens_activ) {
			//inactivo
			case 0:
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '';
				break;
			//activo encendido
			case 1:
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="" title="Equipo Encendido" class="btn btn-success btn-sm tooltip"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
				break;
			//activo apagado
			case 2:
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="" title="Equipo Apagado" class="btn btn-danger btn-sm tooltip"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
				break;
		}
	}

	/****************************************************/
	//busco el tipo de equipo
	$Nombre_equipo = $data['Identificador'];
	$NumSerie      = $data['NumSerie'];
	$buscado_1     = 'elv';
	$buscado_2     = 'gen';
	$s_pos_1       = strpos($NumSerie, $buscado_1);
	$s_pos_2       = strpos($NumSerie, $buscado_2);

	/****************************************************/
	//Si esta en Planta
	if(isset($data['idUbicacion'])&&$data['idUbicacion']==1){
		$show_map = '&ShowMap=True';
	}else{
		$show_map = '';
	}

	/****************************************************/
	// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
	// porque la posición de 'elv-' está en el 1° (primer) caracter.
	if ($s_pos_1 === false) {
		if ($s_pos_2 === false) {
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['crosscrane_estado'] = '<a href="view_crosscrane_estado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).$show_map.'" title="Estado Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-tasks" aria-hidden="true"></i></a>';
		}else{
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['crosscrane_estado'] = '<a href="view_generador_data.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).$show_map.'" title="Datos Generador" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-battery-full" aria-hidden="true"></i></a>';
		}
	}else{
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['crosscrane_estado'] = '<a href="view_crosscrane_estado_elev.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).$show_map.'" title="Estado Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-tasks" aria-hidden="true"></i></a>';
	}

	/****************************************************/
	//el resto de los botones
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['CenterMap']             = '<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>';
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['informe_activaciones']  = '<li><a href="view_telemetria_uso.php?idTelemetria='.$data['idTelemetria'].'&F_inicio='.$principioMes.'&F_termino='.$FechaSistema.'&Amp=&pagina=1&submit_filter=Filtrar" class="iframe" style="white-space: normal;" ><i class="fa fa-clock-o" aria-hidden="true"></i> Uso Grua</a></li>';
	$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['AlarmasPersonalizadas'] = '<li><a href="view_alertas_personalizadas.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas Personalizadas</a></li>';
	//si tiene un generador
	/*if(isset($data['idGenerador'])&&$data['idGenerador']==1&&isset($data['idTelGenerador'])&&$data['idTelGenerador']!=''&&$data['idTelGenerador']!=0){
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Generador'] = '<li><a href="view_generador_data.php?view='.simpleEncode($data['idTelGenerador'], fecha_actual()).'"  class="iframe" style="white-space: normal;"><i class="fa fa-battery-full" aria-hidden="true"></i> Datos Generador</a></li>';
	}else{
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Generador'] = '';
	}*/
	//si utiliza carpeta ftp
	if(isset($data['idUsoFTP'])&&$data['idUsoFTP']==1&&isset($data['FTP_Carpeta'])&&$data['FTP_Carpeta']!=''){
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['CarpetaFTP'] = '<li><a href="view_telemetria_data_files.php?view='.simpleEncode($data['FTP_Carpeta'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-video-camera" aria-hidden="true"></i> Camara</a></li>';
	}else{
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['CarpetaFTP'] = '';
	}

	//boton de alertas pendientes de ver
	if(isset($data['NAlertas'])&&$data['NAlertas']!=''&&$data['NAlertas']!=0){
		//Alertas
		$link_Alertas  = 'view_telemetria_alertas.php';
		$link_Alertas .= '?pagina=1';
		//$link_Alertas .= '&f_inicio='.$Fecha_inicio;
		//$link_Alertas .= '&f_termino='.$Fecha_fin;
		$link_Alertas .= '&idTelemetria='.$data['idTelemetria'];
		$link_Alertas .= '&idLeido=0';
		$link_Alertas .= '&submit_filter=+Filtrar';
		//boton
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['NAlertas']         = '<a href="'.$link_Alertas.'" title="'.$data['NAlertas'].' Alertas Pendientes de ver" class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-exclamation-triangle faa-horizontal animated" aria-hidden="true"></i></a>';
	}else{
		$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['NAlertas']         = '';
	}

	$nicon++;
}

//Cuento los totales
$Count_Alerta      = 0;
$Count_Ok          = 0;
$Count_FueraLinea  = 0;
$Count_Total       = 0;
$Count_Planta      = 0;

//obra
if(isset($arrGruas[2][2])){foreach ( $arrGruas[2][2] as $categoria=>$grua ) {/*$Count_Alerta++;*/$Count_Ok++;$Count_Total++;}}
if(isset($arrGruas[2][1])){foreach ( $arrGruas[2][1] as $categoria=>$grua ) {$Count_Ok++;$Count_Total++;}}
if(isset($arrGruas[2][3])){foreach ( $arrGruas[2][3] as $categoria=>$grua ) {$Count_FueraLinea++;$Count_Total++;}}

//planta
if(isset($arrGruas[1][1])){foreach ( $arrGruas[1][1] as $categoria=>$grua ) {$Count_Planta++;$Count_Total++;}}
if(isset($arrGruas[1][2])){foreach ( $arrGruas[1][2] as $categoria=>$grua ) {$Count_Planta++;$Count_Total++;}}
if(isset($arrGruas[1][3])){foreach ( $arrGruas[1][3] as $categoria=>$grua ) {$Count_Planta++;$Count_Total++;}}

?>

<script>
	//se actualizan los widgets superiores
	//document.getElementById('updt_Count_Alerta').innerHTML=<?php echo $Count_Alerta; ?>;
	document.getElementById('updt_Count_FueraLinea').innerHTML=<?php echo $Count_FueraLinea; ?>;
	document.getElementById('updt_Count_Ok').innerHTML=<?php echo $Count_Ok; ?>;
	document.getElementById('updt_Count_Planta').innerHTML=<?php echo $Count_Planta; ?>;
	document.getElementById('updt_Count_Total').innerHTML=<?php echo $Count_Total; ?>;
</script>

<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
	<thead>
		<tr role="row">
			<th colspan="5">
				<div class="field">
					<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >
						<option value="9999" <?php if($idZona==9999){ echo 'selected="selected"';} ?>>Todas las Zonas</option>
						<?php foreach ( $arrZonas as $select ) {
							$selected = '';
							if($idZona==$select['idZona']){
								$selected = 'selected="selected"';
							}
							echo '<option value="'.$select['idZona'].'" '.$selected.' >'.$select['Nombre'].'</option>';
						} ?>
					</select>
				</div>
			</th>
		</tr>
		<?php echo widget_sherlock(1, 5, 'TableFiltered_1'); ?>
		<tr role="row">
			<th></th>
			<th>Equipo</th>
			<th>Voltaje (V)</th>
			<th>Viento (km/h)</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered_1">

		<?php
		/*************************************************************/
		//Alertas
		if(isset($arrGruas[2][2])){
			foreach ( $arrGruas[2][2] as $categoria=>$grua ) { ?>
			<tr class="odd <?php echo $grua['tr_color']; ?>">
				<td width="10">
					<div class="btn-group" style="width: <?php echo $grua['wid_status']; ?>px;" >
						<?php echo $grua['eq_ok_icon'].$grua['status_icon']; ?>
					</div>
				</td>
				<td><?php echo $grua['Nombre']; ?><br/><?php echo $grua['LastUpdate']; ?></td>
				<td><?php echo $grua['Voltaje']; ?></td>
				<td><?php echo $grua['Viento']; ?></td>
				<td width="10">
					<div class="btn-group" style="width: 175px;" >
						<?php
						echo $grua['in_sens_activ'];
						echo $grua['NAlertas'];
						echo $grua['crosscrane_estado'];
						echo $grua['CenterMap'];
						?>
						<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" style="right: 0;float: right;">
							<?php echo $grua['informe_activaciones']; ?>
							<?php echo $grua['AlarmasPersonalizadas']; ?>
							<?php echo $grua['CarpetaFTP']; ?>
						</ul>
					</div>
				</td>
			</tr>
		<?php }
		}
		/*************************************************************/
		//Ok
		if(isset($arrGruas[2][1])){
			foreach ( $arrGruas[2][1] as $categoria=>$grua ) { ?>
			<tr class="odd <?php echo $grua['tr_color']; ?>">
				<td width="10">
					<div class="btn-group" style="width: <?php echo $grua['wid_status']; ?>px;" >
						<?php echo $grua['eq_ok_icon'].$grua['status_icon']; ?>
					</div>
				</td>
				<td><?php echo $grua['Nombre']; ?><br/><?php echo $grua['LastUpdate']; ?></td>
				<td><?php echo $grua['Voltaje']; ?></td>
				<td><?php echo $grua['Viento']; ?></td>
				<td width="10">
					<div class="btn-group" style="width: 175px;" >
						<?php
						echo $grua['in_sens_activ'];
						echo $grua['NAlertas'];
						echo $grua['crosscrane_estado'];
						echo $grua['CenterMap'];
						?>
						<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" style="right: 0;float: right;">
							<?php echo $grua['informe_activaciones']; ?>
							<?php echo $grua['AlarmasPersonalizadas']; ?>
							<?php echo $grua['CarpetaFTP']; ?>
						</ul>
					</div>
				</td>
			</tr>
		<?php }
		}
		/*************************************************************/
		//Fuera de linea
		if(isset($arrGruas[2][3])){
			foreach ( $arrGruas[2][3] as $categoria=>$grua ) { ?>
			<tr class="odd <?php echo $grua['tr_color']; ?>">
				<td width="10">
					<div class="btn-group" style="width: <?php echo $grua['wid_status']; ?>px;" >
						<?php echo $grua['eq_ok_icon'].$grua['status_icon']; ?>
					</div>
				</td>
				<td><?php echo $grua['Nombre']; ?><br/><?php echo $grua['LastUpdate']; ?></td>
				<td><?php echo $grua['Voltaje']; ?></td>
				<td><?php echo $grua['Viento']; ?></td>
				<td width="10">
					<div class="btn-group" style="width: 175px;" >
						<?php
						echo $grua['in_sens_activ'];
						echo $grua['NAlertas'];
						echo $grua['crosscrane_estado'];
						echo $grua['CenterMap'];
						?>
						<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" style="right: 0;float: right;">
							<?php echo $grua['informe_activaciones']; ?>
							<?php echo $grua['AlarmasPersonalizadas']; ?>
							<?php echo $grua['CarpetaFTP']; ?>
						</ul>
					</div>
				</td>
			</tr>
		<?php }
		} ?>

	</tbody>
</table>

<script>
	var HoraRefresco = '<?php echo hora_actual(); ?>';

	<?php
	$GPS = 'var new_locations = [ ';
			foreach ( $arrEquipo as $data ) {
				//Solo los que estan en obras
				if(isset($data['idUbicacion'])&&$data['idUbicacion']==2){
					//burbuja
					$explanation  = '<div class="iw-subTitle">Equipo: '.$data['Nombre'].'</div>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}else{
									$unimed = '';
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			}
		$GPS .= '];';

		echo $GPS;
	?>
</script>

<?php widget_tooltipster(); ?>
