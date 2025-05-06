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
$HoraSistema    = hora_actual();
$arrGruas       = array();
$nicon          = 0;
//Grupo Sensores
$idGrupoVmonofasico      = 87;
$idGrupoVTrifasico       = 106;
$idGrupoPotencia         = 99;

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
$arrZonas = db_select_array (false, 'idZona, Nombre', 'vehiculos_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

/************************************************/
//numero sensores equipo
$N_Maximo_Sensores = 20;
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.cantSensores,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.NErrores,
telemetria_listado.NAlertas';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
}
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`       ON telemetria_listado_sensores_grupo.idTelemetria        = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idEstado = 1';            //solo equipos activos
$SIS_where.= ' AND telemetria_listado.id_Geo = '.$id_Geo;  //solo los equipos que tengan el seguimiento activado
$SIS_where.= ' AND telemetria_listado.idTab = 9';          //Power-Energy
//Filtro el sistema al cual pertenece
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){ $SIS_where.= ' AND telemetria_listado.idSistema = '.$idSistema;}
//Filtro la zona si existe
if(isset($idZona)&&$idZona!=''&&$idZona!=9999){       $SIS_where.= ' AND telemetria_listado.idZona = '.$idZona;}
//Filtro por el tipo de usuario
if(isset($idTipoUsuario)&&$idTipoUsuario!=1&&isset($idUsuario)&&$idUsuario!=0){
	$SIS_join .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where.= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
}
$SIS_order = 'telemetria_listado.Nombre ASC';
//Realizo la consulta
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

/**************************************************************************/
foreach ($arrEquipo as $data) {

	/**********************************************/
	//Se resetean
	$in_eq_alertas     = 0;
	$in_eq_fueralinea  = 0;
	$in_eq_ok          = 1;

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
	$danger  = '';
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

	/*************************************************************************/
	//Guardo todos los datos
	$arrGruas[$xdanger][$data['idTelemetria']]['tr_color']           = $danger;
	$arrGruas[$xdanger][$data['idTelemetria']]['eq_ok_icon']         = $eq_ok_icon;
	$arrGruas[$xdanger][$data['idTelemetria']]['Nombre']             = $data['Nombre'];
	$arrGruas[$xdanger][$data['idTelemetria']]['LastUpdate']         = fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'];
	$arrGruas[$xdanger][$data['idTelemetria']]['crosscrane_estado']  = '<a href="view_crossenergy_estado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Estado Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-bolt" aria-hidden="true"></i></a>';
	//$arrGruas[$xdanger][$data['idTelemetria']]['crosscrane_detalle'] = '<a href="view_crossenergy_detalle.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Detalle Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>';

	//Temporales
	$TempValue_1 = 0;
	$TempValue_2 = 0;
	$TempValue_3 = 0;
	$TempCount_1 = 0;
	$TempCount_2 = 0;
	$TempCount_3 = 0;

	//se recorre
	for ($i = 1; $i <= $data['cantSensores']; $i++) {
		//Si el sensor esta activo
		if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
			//Si pertenece al grupo
			if($data['SensoresGrupo_'.$i]==$idGrupoVmonofasico){
				$TempValue_1 = $TempValue_1 + $data['SensoresMedActual_'.$i];
				$TempCount_1++;
			}
			if($data['SensoresGrupo_'.$i]==$idGrupoVTrifasico){
				$TempValue_2 = $TempValue_2 + $data['SensoresMedActual_'.$i];
				$TempCount_2++;
			}
			if($data['SensoresGrupo_'.$i]==$idGrupoPotencia){
				$TempValue_3 = $TempValue_3 + $data['SensoresMedActual_'.$i];
				$TempCount_3++;
			}
		}
	}

	//Saco promedios
	if($TempCount_1!=0){$arrGruas[$xdanger][$data['idTelemetria']]['Vmonofasico']     = $TempValue_1/$TempCount_1;}else{$arrGruas[$xdanger][$data['idTelemetria']]['Vmonofasico']     = 0;}
	if($TempCount_2!=0){$arrGruas[$xdanger][$data['idTelemetria']]['VTrifasico']      = $TempValue_2/$TempCount_2;}else{$arrGruas[$xdanger][$data['idTelemetria']]['VTrifasico']      = 0;}
	if($TempCount_3!=0){$arrGruas[$xdanger][$data['idTelemetria']]['Potencia']        = $TempValue_3/$TempCount_3;}else{$arrGruas[$xdanger][$data['idTelemetria']]['Potencia']        = 0;}

	/****************************************************/
	//el resto de los botones
	$arrGruas[$xdanger][$data['idTelemetria']]['CenterMap']            = '<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>';
	//boton de alertas pendientes de ver
	if(isset($data['NAlertas'])&&$data['NAlertas']!=''&&$data['NAlertas']!=0){
		//Alertas
		$link_Alertas  = 'informe_telemetria_errores_6.php';
		$link_Alertas .= '?f_inicio='.$Fecha_inicio;
		$link_Alertas .= '&f_termino='.$Fecha_fin;
		$link_Alertas .= '&idTelemetria='.$data['idTelemetria'];
		$link_Alertas .= '&idLeido=0';
		$link_Alertas .= '&submit_filter=+Filtrar';
		//boton
		$arrGruas[$xdanger][$data['idTelemetria']]['NAlertas']         = '<a target="_blank" rel="noopener noreferrer" href="'.$link_Alertas.'" title="Alertas Pendientes de ver" class="btn btn-danger btn-sm tooltip"><i class="fa fa-exclamation-triangle faa-horizontal animated" aria-hidden="true"></i></a>';
	}else{
		$arrGruas[$xdanger][$data['idTelemetria']]['NAlertas']         = '';
	}

	$nicon++;
}

//Cuento los totales
$Count_Alerta      = 0;
$Count_Ok          = 0;
$Count_FueraLinea  = 0;
$Count_Total       = 0;

if(isset($arrGruas[2])){foreach ( $arrGruas[2] as $categoria=>$grua ) {$Count_Alerta++;$Count_Total++;}}
if(isset($arrGruas[1])){foreach ( $arrGruas[1] as $categoria=>$grua ) {$Count_Ok++;$Count_Total++;}}
if(isset($arrGruas[3])){foreach ( $arrGruas[3] as $categoria=>$grua ) {$Count_FueraLinea++;$Count_Total++;}}

?>

<script>
	//se actualizan los widgets superiores
	document.getElementById('updt_Count_Alerta').innerHTML=<?php echo $Count_Alerta; ?>;
	document.getElementById('updt_Count_FueraLinea').innerHTML=<?php echo $Count_FueraLinea; ?>;
	document.getElementById('updt_Count_Ok').innerHTML=<?php echo $Count_Ok; ?>;
	document.getElementById('updt_Count_Total').innerHTML=<?php echo $Count_Total; ?>;
</script>

<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
	<thead>
		<tr role="row">
			<th colspan="6">
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
		<?php echo widget_sherlock(1, 6, 'TableFiltered'); ?>
		<tr role="row">
			<th></th>
			<th>Equipo</th>
			<th>V. Trifasico</th>
			<th>V. Monofasico</th>
			<th>Potencia</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">

		<?php
		/*************************************************************/
		//Alertas
		if(isset($arrGruas[2])){
			foreach ( $arrGruas[2] as $categoria=>$grua ) { ?>
			<tr class="odd <?php echo $grua['tr_color']; ?>">
				<td width="10">
					<div class="btn-group" style="width: 35px;" >
						<?php echo $grua['eq_ok_icon']; ?>
					</div>
				</td>
				<td><?php echo $grua['Nombre']; ?><br/><?php echo $grua['LastUpdate']; ?></td>
				<td><?php echo cantidades($grua['VTrifasico'], 1).' V'; ?></td>
				<td><?php echo cantidades($grua['Vmonofasico'], 1).' V'; ?></td>
				<td><?php echo cantidades($grua['Potencia'], 1).' kW'; ?></td>
				<td width="10">
					<div class="btn-group" style="width: 105px;" >
						<?php
						echo $grua['NAlertas'];
						echo $grua['crosscrane_estado'];
						//echo $grua['crosscrane_detalle'];
						echo $grua['CenterMap'];
						?>
					</div>
				</td>
			</tr>
		<?php }
		}
		/*************************************************************/
		//OK
		if(isset($arrGruas[1])){
			foreach ( $arrGruas[1] as $categoria=>$grua ) { ?>
			<tr class="odd <?php echo $grua['tr_color']; ?>">
				<td width="10">
					<div class="btn-group" style="width: 35px;" >
						<?php echo $grua['eq_ok_icon']; ?>
					</div>
				</td>
				<td><?php echo $grua['Nombre']; ?><br/><?php echo $grua['LastUpdate']; ?></td>
				<td><?php echo cantidades($grua['VTrifasico'], 1).' V'; ?></td>
				<td><?php echo cantidades($grua['Vmonofasico'], 1).' V'; ?></td>
				<td><?php echo cantidades($grua['Potencia'], 1).' kW'; ?></td>
				<td width="10">
					<div class="btn-group" style="width: 105px;" >
						<?php
						echo $grua['NAlertas'];
						echo $grua['crosscrane_estado'];
						//echo $grua['crosscrane_detalle'];
						echo $grua['CenterMap'];
						?>
					</div>
				</td>
			</tr>
		<?php }
		}
		/*************************************************************/
		//Fuera de linea
		if(isset($arrGruas[3])){
			foreach ( $arrGruas[3] as $categoria=>$grua ) { ?>
			<tr class="odd <?php echo $grua['tr_color']; ?>">
				<td width="10">
					<div class="btn-group" style="width: 35px;" >
						<?php echo $grua['eq_ok_icon']; ?>
					</div>
				</td>
				<td><?php echo $grua['Nombre']; ?><br/><?php echo $grua['LastUpdate']; ?></td>
				<td><?php echo cantidades($grua['VTrifasico'], 1).' V'; ?></td>
				<td><?php echo cantidades($grua['Vmonofasico'], 1).' V'; ?></td>
				<td><?php echo cantidades($grua['Potencia'], 1).' kW'; ?></td>
				<td width="10">
					<div class="btn-group" style="width: 105px;" >
						<?php
						echo $grua['NAlertas'];
						echo $grua['crosscrane_estado'];
						//echo $grua['crosscrane_detalle'];
						echo $grua['CenterMap'];
						?>
					</div>
				</td>
			</tr>
		<?php }
		} ?>

	</tbody>
</table>

<?php widget_tooltipster(); ?>
