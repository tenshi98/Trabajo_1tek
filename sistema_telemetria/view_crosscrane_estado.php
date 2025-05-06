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
/*                                          Modulo de identificacion del documento                                                */
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
//Cargamos la ubicacion original
$original = "view_crosscrane_estado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$X_Puntero;
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/

/**************************************************************/
//variables
$Fecha_inicio  = restarDias(fecha_actual(),1);
$Fecha_fin     = fecha_actual();
$N_sobreUso    = 0;
$margenError   = 30;

//numero sensores equipo
$N_Maximo_Sensores = 50;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery .= ',telemetria_listado_sensores_uso.SensoresUso_'.$i;
	$subquery .= ',telemetria_listado_sensores_accion_c.SensoresAccionC_'.$i;
	$subquery .= ',telemetria_listado_sensores_accion_t.SensoresAccionT_'.$i;
	$subquery .= ',telemetria_listado_sensores_accion_med_c.SensoresAccionMedC_'.$i;
	$subquery .= ',telemetria_listado_sensores_accion_med_t.SensoresAccionMedT_'.$i;
	$subquery .= ',telemetria_listado_sensores_accion_alerta.SensoresAccionAlerta_'.$i;
}
//se hace consulta
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.CrossCrane_tiempo_revision,
telemetria_listado.CrossCrane_grupo_amperaje,
telemetria_listado.CrossCrane_grupo_elevacion,
telemetria_listado.CrossCrane_grupo_giro,
telemetria_listado.CrossCrane_grupo_carro,
telemetria_listado.CrossCrane_grupo_voltaje
'.$subquery.',
(SELECT COUNT(idErrores) FROM `telemetria_listado_errores` WHERE idTelemetria='.$X_Puntero.' AND idLeido=0 AND Fecha BETWEEN "'.$Fecha_inicio.'" AND "'.$Fecha_fin.'" AND idTipo!="999" AND Valor<"99900" AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].') AS Alertas';
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_uso`             ON telemetria_listado_sensores_uso.idTelemetria            = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_c`        ON telemetria_listado_sensores_accion_c.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_t`        ON telemetria_listado_sensores_accion_t.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_med_c`    ON telemetria_listado_sensores_accion_med_c.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_med_t`    ON telemetria_listado_sensores_accion_med_t.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_alerta`   ON telemetria_listado_sensores_accion_alerta.idTelemetria  = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

/********************************************************************************************/
$F_inicio  = fecha_actual();
$F_inicio2 = restarDias(fecha_actual(),1);
$H_inicio  = restahoras($rowData['CrossCrane_tiempo_revision'], hora_actual());
$H_inicio2 = restahoras('03:00:00', hora_actual());
$H_inicio3 = restahoras('00:10:00', hora_actual());
$F_termino = fecha_actual();
$H_termino = hora_actual();

//Variable de busqueda
if($H_inicio>$H_termino){
	$SIS_where = "telemetria_listado_tablarelacionada_".$X_Puntero.".TimeStamp BETWEEN '".$F_inicio2." ".$H_inicio."' AND '".$F_termino." ".$H_termino."'";
}else{
	$SIS_where = "telemetria_listado_tablarelacionada_".$X_Puntero.".TimeStamp BETWEEN '".$F_inicio." ".$H_inicio."' AND '".$F_termino." ".$H_termino."'";
}

//numero sensores equipo
$N_Maximo_Sensores = $rowData['cantSensores'];
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_amperaje']){
		$subquery .= ',AVG(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_amperaje_'.$i.'_Prom';
	}
	if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_elevacion']){
		$subquery .= ',AVG(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_elevacion_'.$i.'_Prom';
	}
	if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_giro']){
		$subquery .= ',AVG(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_giro_'.$i.'_Prom';
	}
	if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_carro']){
		$subquery .= ',AVG(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_carro_'.$i.'_Prom';
	}
	if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_voltaje']){
		$subquery .= ',AVG(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_voltaje_'.$i.'_Prom';
	}
}

/**********************************************************/
//se consulta
$rowResult = db_select_data (false, 'FechaSistema, HoraSistema'.$subquery, 'telemetria_listado_tablarelacionada_'.$X_Puntero, '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

/**********************************************************/
//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

//Obtengo tiempo de refresco
$n_permisos = db_select_data (false, 'idOpcionesGen_6', 'core_sistemas','', 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

//se genera arreglo
$arrUnimedX = array();
foreach ($arrUnimed as $sen) {
	$arrUnimedX[$sen['idUniMed']]= ' '.$sen['Nombre'];	;
}
/********************************************************************************************/
if(isset($rowData['CrossCrane_tiempo_revision'])&&$rowData['CrossCrane_tiempo_revision']=='00:00:00'){
	echo '<div class="col-xs-12" style="margin-top:15px;">';
		$Alert_Text  = 'No se ha configurado el tiempo de revision';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}
if(isset($rowData['CrossCrane_grupo_amperaje'])&&$rowData['CrossCrane_grupo_amperaje']==0){
	echo '<div class="col-xs-12" >';
		$Alert_Text  = 'No se ha configurado el grupo de alimentacion';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}
if(isset($rowData['CrossCrane_grupo_elevacion'])&&$rowData['CrossCrane_grupo_elevacion']==0){
	echo '<div class="col-xs-12" >';
		$Alert_Text  = 'No se ha configurado el grupo de elevacion';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}
if(isset($rowData['CrossCrane_grupo_giro'])&&$rowData['CrossCrane_grupo_giro']==0){
	echo '<div class="col-xs-12" >';
		$Alert_Text  = 'No se ha configurado el grupo de giro';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}
if(isset($rowData['CrossCrane_grupo_carro'])&&$rowData['CrossCrane_grupo_carro']==0){
	echo '<div class="col-xs-12" >';
		$Alert_Text  = 'No se ha configurado el grupo de carro';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}
if(isset($rowData['CrossCrane_grupo_voltaje'])&&$rowData['CrossCrane_grupo_voltaje']==0){
	echo '<div class="col-xs-12" >';
		$Alert_Text  = 'No se ha configurado el grupo de voltaje';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}
if(isset($n_permisos['idOpcionesGen_6'])&&$n_permisos['idOpcionesGen_6']!=0){
	$x_seg = $n_permisos['idOpcionesGen_6'] * 1000;
}else{
	$x_seg = 300000;//5 minutos
} ?>
<script>
	window.setTimeout(function () {
	  window.location.reload();
	}, <?php echo $x_seg; ?>);
</script>
<style>
.float_table table {margin-right: auto !important;margin-left: auto !important;float: none !important;}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table', 'gauge']});</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Estado del Equipo <?php echo $rowData['Nombre'].' (Hora Refresco: '.hora_actual().')'; ?></h5>
		</header>
        <div class="tab-content">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php
				//numero sensores equipo
				$N_Maximo_Sensores = $rowData['cantSensores'];
				//variables
				$alimentacion_total         = 0;
				$alimentacion_min           = 9999;
				$alimentacion_max           = -9999;
				$alimentacion_cuenta        = 0;
				$alimentacion_promedio      = 0;
				$alimentacion_min_promedio  = 0;
				$alimentacion_max_promedio  = 0;

				$elevacion_total            = 0;
				$elevacion_min              = 9999;
				$elevacion_max              = -9999;
				$elevacion_cuenta           = 0;
				$elevacion_promedio         = 0;
				$elevacion_min_promedio     = 0;
				$elevacion_max_promedio     = 0;

				$giro_total                 = 0;
				$giro_min                   = 9999;
				$giro_max                   = -9999;
				$giro_cuenta                = 0;
				$giro_promedio              = 0;
				$giro_min_promedio          = 0;
				$giro_max_promedio          = 0;

				$carro_total                = 0;
				$carro_min                  = 9999;
				$carro_max                  = -9999;
				$carro_cuenta               = 0;
				$carro_promedio             = 0;
				$carro_min_promedio         = 0;
				$carro_max_promedio         = 0;

				$voltaje_prom_total         = 0;
				$voltaje_prom_cuenta        = 0;
				$voltaje_actual_total       = 0;
				$voltaje_actual_cuenta      = 0;
				$voltaje_promedio_min       = 0;
				$voltaje_promedio_max       = 0;
				$voltaje_prom_promedio      = 0;
				$voltaje_actual_promedio    = 0;
				$voltaje_promedio_min_fin   = 0;
				$voltaje_promedio_max_fin   = 0;
				/*****************************************/
				//recorro
				for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {

					if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_amperaje']){
						//suma totales
						$alimentacion_total     = $alimentacion_total + $rowResult['Sensor_amperaje_'.$i.'_Prom'];
						$alimentacion_cuenta++;
						//busco el valor minimo
						if($rowResult['Sensor_amperaje_'.$i.'_Prom']<$alimentacion_min){$alimentacion_min = $rowResult['Sensor_amperaje_'.$i.'_Prom'];}
						//busco el valor maximo
						if($rowResult['Sensor_amperaje_'.$i.'_Prom']>$alimentacion_max){$alimentacion_max = $rowResult['Sensor_amperaje_'.$i.'_Prom'];}
					}

					if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_elevacion']){
						//suma totales
						$elevacion_total     = $elevacion_total + $rowResult['Sensor_elevacion_'.$i.'_Prom'];
						$elevacion_cuenta++;
						//busco el valor minimo
						if($rowResult['Sensor_elevacion_'.$i.'_Prom']<$elevacion_min){$elevacion_min = $rowResult['Sensor_elevacion_'.$i.'_Prom'];}
						//busco el valor maximo
						if($rowResult['Sensor_elevacion_'.$i.'_Prom']>$elevacion_max){$elevacion_max = $rowResult['Sensor_elevacion_'.$i.'_Prom'];}
					}

					if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_giro']){
						//suma totales
						$giro_total     = $giro_total + $rowResult['Sensor_giro_'.$i.'_Prom'];
						$giro_cuenta++;
						//busco el valor minimo
						if($rowResult['Sensor_giro_'.$i.'_Prom']<$giro_min){$giro_min = $rowResult['Sensor_giro_'.$i.'_Prom'];}
						//busco el valor maximo
						if($rowResult['Sensor_giro_'.$i.'_Prom']>$giro_max){$giro_max = $rowResult['Sensor_giro_'.$i.'_Prom'];}
					}

					if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_carro']){
						//suma totales
						$carro_total     = $carro_total + $rowResult['Sensor_carro_'.$i.'_Prom'];
						$carro_cuenta++;
						//busco el valor minimo
						if($rowResult['Sensor_carro_'.$i.'_Prom']<$carro_min){$carro_min = $rowResult['Sensor_carro_'.$i.'_Prom'];}
						//busco el valor maximo
						if($rowResult['Sensor_carro_'.$i.'_Prom']>$carro_max){$carro_max = $rowResult['Sensor_carro_'.$i.'_Prom'];}
					}

					if($rowData['SensoresGrupo_'.$i]==$rowData['CrossCrane_grupo_voltaje']){
						//promedio
						$voltaje_prom_total = $voltaje_prom_total + $rowResult['Sensor_voltaje_'.$i.'_Prom'];
						$voltaje_prom_cuenta++;
						//actual
						$voltaje_actual_total = $voltaje_actual_total + $rowData['SensoresMedActual_'.$i];
						$voltaje_actual_cuenta++;
					}

					//Se verifica si el sensor esta habilitado para la supervision
					if(isset($rowMed['SensoresUso_'.$i])&&$rowMed['SensoresUso_'.$i]==1){
						//si esta configurado el porcentaje de alerta
						if(isset($rowMed['SensoresAccionAlerta_'.$i])&&$rowMed['SensoresAccionAlerta_'.$i]!=0){
							/*****************************************/
							//Ciclos
							//si esta configurado
							if(isset($rowMed['SensoresAccionC_'.$i])&&$rowMed['SensoresAccionC_'.$i]!=0){
								$ciclo = $rowMed['SensoresAccionMedC_'.$i]/$rowMed['SensoresAccionC_'.$i];
								//si ya cumplio ciclos
								if($ciclo>$rowMed['SensoresAccionAlerta_'.$i]){
									$N_sobreUso++;
								}
							}

							/*****************************************/
							//Horas
							//si esta configurado
							if(isset($rowMed['SensoresAccionT_'.$i])&&$rowMed['SensoresAccionT_'.$i]!=0){
								$ciclo = $rowMed['SensoresAccionMedT_'.$i]/$rowMed['SensoresAccionT_'.$i];
								//si ya cumplio ciclos
								if($ciclo>$rowMed['SensoresAccionAlerta_'.$i]){
									$N_sobreUso++;
								}
							}
						}
					}
				}
				/*****************************************/
				//obtengo promedios
				//alimentacion
				if($alimentacion_cuenta!=0){
					$alimentacion_promedio     = cantidades($alimentacion_total/$alimentacion_cuenta, 0);
					$alimentacion_min_promedio  = 0;
					$alimentacion_max_promedio  = 0;
				}else{
					$alimentacion_promedio      = 0;
					$alimentacion_min_promedio  = 0;
					$alimentacion_max_promedio  = 0;
				}
				//elevacion
				if($elevacion_cuenta!=0){
					$elevacion_promedio     = cantidades($elevacion_total/$elevacion_cuenta, 0);
					$elevacion_min_promedio  = 0;
					$elevacion_max_promedio  = 0;
				}else{
					$elevacion_promedio      = 0;
					$elevacion_min_promedio  = 0;
					$elevacion_max_promedio  = 0;
				}
				//giro
				if($giro_cuenta!=0){
					$giro_promedio     = cantidades($giro_total/$giro_cuenta, 0);
					$giro_min_promedio  = 0;
					$giro_max_promedio  = 0;
				}else{
					$giro_promedio      = 0;
					$giro_min_promedio  = 0;
					$giro_max_promedio  = 0;
				}
				//carro
				if($carro_cuenta!=0){
					$carro_promedio     = cantidades($carro_total/$carro_cuenta, 0);
					$carro_min_promedio  = 0;
					$carro_max_promedio  = 0;
				}else{
					$carro_promedio      = 0;
					$carro_min_promedio  = 0;
					$carro_max_promedio  = 0;
				}
				//voltaje
				if($voltaje_prom_cuenta!=0){
					$voltaje_prom_promedio = $voltaje_prom_total/$voltaje_prom_cuenta;
				}else{
					$voltaje_prom_promedio = 0;
				}

				if($voltaje_actual_cuenta!=0){
					$voltaje_actual_promedio  = $voltaje_actual_total/$voltaje_actual_cuenta;
					$voltaje_promedio_min_fin = $voltaje_promedio_min/$voltaje_actual_cuenta;
					$voltaje_promedio_max_fin = $voltaje_promedio_max/$voltaje_actual_cuenta;
				}else{
					$voltaje_actual_promedio  = 0;
					$voltaje_promedio_min_fin = 0;
					$voltaje_promedio_max_fin = 0;
				}
				/*****************************************/
				//obtengo margenes
				$margen_alimentacion  = 0;
				$margen_elevacion     = 0;
				$margen_giro          = 0;
				$margen_carro         = 0;

				if($alimentacion_min > 1&&$alimentacion_max > 1){  $margen_alimentacion  = cantidades(100-(($alimentacion_min*100)/$alimentacion_max), 0);}
				if($elevacion_min > 1&&$elevacion_max > 1){        $margen_elevacion     = cantidades(100-(($elevacion_min*100)/$elevacion_max), 0);}
				if($giro_min > 1&&$giro_max > 1){                  $margen_giro          = cantidades(100-(($giro_min*100)/$giro_max), 0);}
				if($carro_min > 1&&$carro_max > 1){                $margen_carro         = cantidades(100-(($carro_min*100)/$carro_max), 0);}

				/*****************************************/
				//genero los iconos de alertas
				//alimentacion
				/*if(($alimentacion_promedio<$alimentacion_min_promedio) OR ($alimentacion_promedio>$alimentacion_max_promedio)){
					$icon_alimentacion = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_alimentacion = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}*/
				if($margen_alimentacion>$margenError){
					$icon_alimentacion = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_alimentacion = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}
				//elevacion
				/*if(($elevacion_promedio<$elevacion_min_promedio) OR ($elevacion_promedio>$elevacion_max_promedio)){
					$icon_elevacion = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_elevacion = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}*/
				if($margen_elevacion>$margenError){
					$icon_elevacion = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_elevacion = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}
				//giro
				/*if(($giro_promedio<$giro_min_promedio) OR ($giro_promedio>$giro_max_promedio)){
					$icon_giro = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_giro = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}*/
				if($margen_giro>$margenError){
					$icon_giro = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_giro = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}
				//carro
				/*if(($carro_promedio<$carro_min_promedio) OR ($carro_promedio>$carro_max_promedio)){
					$icon_carro = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_carro = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}*/
				if($margen_carro>$margenError){
					$icon_carro = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_carro = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}
				//voltaje
				//si no estan configurados
				if($voltaje_promedio_min_fin==0&&$voltaje_promedio_max_fin==0){
					$icon_voltaje = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}else{
					//si es inferior a 1000
					if($voltaje_prom_promedio<1000){
						if(($voltaje_prom_promedio<$voltaje_promedio_min_fin) OR ($voltaje_prom_promedio>$voltaje_promedio_max_fin)){
							$icon_voltaje = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
						}else{
							$icon_voltaje = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
						}
					}else{
						$icon_voltaje = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
					}
				}

				//Alertas
				if(isset($rowData['Alertas'])&&$rowData['Alertas']!=0){
					$icon_Alertas = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_Alertas = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}
				//sobreuso
				if(isset($N_sobreUso)&&$N_sobreUso!=0){
					$icon_sobreuso = '<span style="color:#da4932"><i class="fa fa-exclamation-triangle faa-bounce animated" aria-hidden="true"></i></span>';
				}else{
					$icon_sobreuso = '<span style="color:#60c060"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
				}
				/*****************************************/
				//genero los enlaces
				//main
				$link  = 'informe_telemetria_registro_sensores_17.php';
				if($H_inicio3>$H_termino){
					$link .= '?f_inicio='.$F_inicio2;
					$link .= '&f_termino='.$F_termino;
					$link .= '&h_inicio='.$H_inicio3;
					$link .= '&h_termino='.$H_termino;
				}else{
					$link .= '?f_inicio='.$F_inicio;
					$link .= '&f_termino='.$F_termino;
					$link .= '&h_inicio='.$H_inicio3;
					$link .= '&h_termino='.$H_termino;
				}
				$link .= '&idTelemetria='.$X_Puntero;
				$link .= '&idGrafico=1&submit_filter=+Filtrar';
				//alimentacion
				$link_alimentacion  = $link;
				$link_alimentacion .= '&idGrupo='.$rowData['CrossCrane_grupo_amperaje'];
				//elevacion
				$link_elevacion  = $link;
				$link_elevacion .= '&idGrupo='.$rowData['CrossCrane_grupo_elevacion'];
				//giro
				$link_giro  = $link;
				$link_giro .= '&idGrupo='.$rowData['CrossCrane_grupo_giro'];
				//carro
				$link_carro  = $link;
				$link_carro .= '&idGrupo='.$rowData['CrossCrane_grupo_carro'];
				//voltaje
				$link_voltaje  = 'informe_telemetria_registro_sensores_17.php';
				if($H_inicio2>$H_termino){
					$link_voltaje .= '?f_inicio='.$F_inicio2;
					$link_voltaje .= '&f_termino='.$F_termino;
					$link_voltaje .= '&h_inicio='.$H_inicio2;
					$link_voltaje .= '&h_termino='.$H_termino;
				}else{
					$link_voltaje .= '?f_inicio='.$F_inicio;
					$link_voltaje .= '&f_termino='.$F_termino;
					$link_voltaje .= '&h_inicio='.$H_inicio2;
					$link_voltaje .= '&h_termino='.$H_termino;
				}
				$link_voltaje .= '&idTelemetria='.$X_Puntero;
				$link_voltaje .= '&idGrafico=1&submit_filter=+Filtrar';
				$link_voltaje .= '&idGrupo='.$rowData['CrossCrane_grupo_voltaje'];
				//Alertas
				$link_Alertas  = 'informe_telemetria_errores_6.php';
				$link_Alertas .= '?f_inicio='.$Fecha_inicio;
				$link_Alertas .= '&f_termino='.$Fecha_fin;
				$link_Alertas .= '&idTelemetria='.$X_Puntero;
				$link_Alertas .= '&idLeido=0';
				$link_Alertas .= '&submit_filter=+Filtrar';
				//Sobre uso
				$link_sobreuso  = 'informe_telemetria_uso_03.php';
				$link_sobreuso .= '?idTelemetria='.$X_Puntero;
				$link_sobreuso .= '&submit_filter=+Filtrar';
				?>

				<div class="row">

					<?php /*
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<h3 style="text-align: center;"><?php echo $icon_alimentacion.' Alimentacion'; ?></h3>
						<div class="float_table" id="chart_gauge_alimentacion" ></div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo $link_alimentacion; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>
					*/ ?>

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 style="text-align: center;"><?php echo $icon_elevacion.' Elevacion'; ?></h3>
						<div class="float_table" id="chart_gauge_elevacion" ></div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo $link_elevacion; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 style="text-align: center;"><?php echo $icon_giro.' Giro'; ?></h3>
						<div class="float_table" id="chart_gauge_giro" ></div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo $link_giro; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 style="text-align: center;"><?php echo $icon_carro.' Carro'; ?></h3>
						<div class="float_table" id="chart_gauge_carro" ></div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo $link_carro; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<script>
						/* ************************************************************************** */
						//Variables globales
						//var chart_gauge_1    = "";
						var chart_gauge_2    = "";
						var chart_gauge_3    = "";
						var chart_gauge_4    = "";

						//var data_gauge_1     = "";
						var data_gauge_2     = "";
						var data_gauge_3     = "";
						var data_gauge_4     = "";

						//var options_gauge_1  = "";
						var options_gauge_2  = "";
						var options_gauge_3  = "";
						var options_gauge_4  = "";

						//carga de los graficos
						//google.charts.setOnLoadCallback(Chart_correccion_1);
						google.charts.setOnLoadCallback(Chart_correccion_2);
						google.charts.setOnLoadCallback(Chart_correccion_3);
						google.charts.setOnLoadCallback(Chart_correccion_4);

						/* ************************************************************************** */
						/*function Chart_correccion_1() {
							var data_correccion_rows_1 = <?php echo $margen_alimentacion; ?>;
							//se llama funcion de dibujo
							draw_correccion_1(data_correccion_rows_1);
						}*/
						function Chart_correccion_2() {
							var data_correccion_rows_2 = <?php echo $margen_elevacion; ?>;
							//se llama funcion de dibujo
							draw_correccion_2(data_correccion_rows_2);
						}
						function Chart_correccion_3() {
							var data_correccion_rows_3 = <?php echo $margen_giro; ?>;
							//se llama funcion de dibujo
							draw_correccion_3(data_correccion_rows_3);
						}
						function Chart_correccion_4() {
							var data_correccion_rows_4 = <?php echo $margen_carro; ?>;
							//se llama funcion de dibujo
							draw_correccion_4(data_correccion_rows_4);
						}
						/********************************************************************/
						/*function draw_correccion_1(data) {
							//datos
							chart_gauge_1 = new google.visualization.Gauge(document.getElementById("chart_gauge_alimentacion"));
							data_gauge_1 = google.visualization.arrayToDataTable([
								["Label", "Valor"],
								["<?php echo $alimentacion_promedio; ?> A", data]
							]);
							//opciones
							options_gauge_1 = {
								min:0,
								max:100,
								width: 350,
								height: 200,
								redFrom: <?php echo $margenError; ?>, redTo: 100,redColor:'#DC3912',
								majorTicks: ["0","10","20","30","40", "50", "60", "70", "80", "90", "100"],
								minorTicks: 5
							};
							//Formateo
							var format1 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							format1.format(data_gauge_1, 1);
							//dibujo
							chart_gauge_1.draw(data_gauge_1, options_gauge_1);
						}*/
						function draw_correccion_2(data) {
							//datos
							chart_gauge_2 = new google.visualization.Gauge(document.getElementById("chart_gauge_elevacion"));
							data_gauge_2 = google.visualization.arrayToDataTable([
								["Label", "Valor"],
								["<?php echo $elevacion_promedio; ?> A", data]
							]);
							//opciones
							options_gauge_2 = {
								min:0,
								max:100,
								width: 350,
								height: 200,
								redFrom: <?php echo $margenError; ?>, redTo: 100,redColor:'#DC3912',
								majorTicks: ["0","10","20","30","40", "50", "60", "70", "80", "90", "100"],
								minorTicks: 5
							};
							//Formateo
							var format2 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							format2.format(data_gauge_2, 1);
							//dibujo
							chart_gauge_2.draw(data_gauge_2, options_gauge_2);
						}
						function draw_correccion_3(data) {
							//datos
							chart_gauge_3 = new google.visualization.Gauge(document.getElementById("chart_gauge_giro"));
							data_gauge_3 = google.visualization.arrayToDataTable([
								["Label", "Valor"],
								["<?php echo $giro_promedio; ?> A", data]
							]);
							//opciones
							options_gauge_3 = {
								min:0,
								max:100,
								width: 350,
								height: 200,
								redFrom: <?php echo $margenError; ?>, redTo: 100,redColor:'#DC3912',
								majorTicks: ["0","10","20","30","40", "50", "60", "70", "80", "90", "100"],
								minorTicks: 5
							};
							//Formateo
							var format3 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							format3.format(data_gauge_3, 1);
							//dibujo
							chart_gauge_3.draw(data_gauge_3, options_gauge_3);
						}
						function draw_correccion_4(data) {
							//datos
							chart_gauge_4 = new google.visualization.Gauge(document.getElementById("chart_gauge_carro"));
							data_gauge_4 = google.visualization.arrayToDataTable([
								["Label", "Valor"],
								["<?php echo $carro_promedio; ?> A", data]
							]);
							//opciones
							options_gauge_4 = {
								min:0,
								max:100,
								width: 350,
								height: 200,
								redFrom: <?php echo $margenError; ?>, redTo: 100,redColor:'#DC3912',
								majorTicks: ["0","10","20","30","40", "50", "60", "70", "80", "90", "100"],
								minorTicks: 5
							};
							//Formateo
							var format4 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							format4.format(data_gauge_4, 1);
							//dibujo
							chart_gauge_4.draw(data_gauge_4, options_gauge_4);
						}
						/********************************************************************/
						/*function update_correccion_1(data) {
							//Formateo
							var format1 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							data_gauge_1.setValue(0, 1, data);
							format1.format(data_gauge_1, 1);
							chart_gauge_1.draw(data_gauge_1, options_gauge_1);
						}*/
						function update_correccion_2(data) {
							//Formateo
							var format2 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							data_gauge_2.setValue(0, 1, data);
							format2.format(data_gauge_2, 1);
							chart_gauge_2.draw(data_gauge_2, options_gauge_2);
						}
						function update_correccion_3(data) {
							//Formateo
							var format3 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							data_gauge_3.setValue(0, 1, data);
							format3.format(data_gauge_3, 1);
							chart_gauge_3.draw(data_gauge_3, options_gauge_3);
						}
						function update_correccion_4(data) {
							//Formateo
							var format4 = new google.visualization.NumberFormat({
								suffix: '%',
								fractionDigits: 0
							});
							data_gauge_4.setValue(0, 1, data);
							format4.format(data_gauge_4, 1);
							chart_gauge_4.draw(data_gauge_4, options_gauge_4);
						}

					</script>
				</div>

				<div class="row">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 style="text-align: center;"><?php echo $icon_voltaje.' Voltaje'; ?></h3>

						<div  class="box box-blue box-solid tooltip">
							<div class="box-header with-border">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
									<h3 class="box-title">Actual</h3>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
									<h3 class="box-title">Promedio</h3>
								</div>
								<div class="clearfix"></div>
							</div>
							<?php
							if($voltaje_actual_promedio<1000){
								$ndata_x1 = $voltaje_actual_promedio;
							}else{
								$ndata_x1 = 0;
							}
							if($voltaje_prom_promedio<1000){
								$ndata_x2 = $voltaje_prom_promedio;
							}else{
								$ndata_x2 = 0;
							}

							?>
							<div class="box-body">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 value tipnoabs">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo cantidades($ndata_x1, 0); ?></span>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 value tipnoabs">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo cantidades($ndata_x2, 0); ?></span>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo $link_voltaje; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 style="text-align: center;"><?php echo $icon_Alertas.' Operacion'; ?></h3>
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Alertas (Ultimas 24 Horas)</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
									<span><?php echo $rowData['Alertas']; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo $link_Alertas; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 style="text-align: center;"><?php echo $icon_sobreuso.' Mantencion'; ?></h3>
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Mantención Requerida</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
									<span><?php echo $N_sobreUso; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo $link_sobreuso; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>
				</div>

				<?php
					//Si no existe una ID se utiliza una por defecto
					if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
						$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
						alert_post_data(4,2,2,0, $Alert_Text);
					}else{
						if(isset($_GET['ShowMap'])&&$_GET['ShowMap']=='True'){
							$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>

							<style>
								.my_marker {color: white;background-color: black;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
								.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
							</style>

							<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
							</div>
							<script>
								let map;
								var marker;

								async function initMap() {
									const { Map } = await google.maps.importLibrary("maps");

									var myLatlng = new google.maps.LatLng(<?php echo $rowData['GeoLatitud']; ?>, <?php echo $rowData['GeoLongitud']; ?>);

									var myOptions = {
										zoom: 15,
										center: myLatlng,
										mapTypeId: google.maps.MapTypeId.SATELLITE
									};

									map = new Map(document.getElementById("map_canvas"), myOptions);
									map.setTilt(0);

									// InfoWindow content
									var content_1 = '<div id="iw-container">' +
													'<div class="iw-title">Equipo</div>' +
													'<div class="iw-content">' +
													'<p>'+
													'<strong>Nombre: </strong><?php echo $rowData['Nombre']; ?><br/>' +
													'<strong>Fecha: </strong><?php echo fecha_estandar($rowData['LastUpdateFecha']); ?><br/>' +
													'<strong>Hora: </strong><?php echo $rowData['LastUpdateHora']; ?><br/>' +
													'</p>' +
													'</div>' +
													'<div class="iw-bottom-gradient"></div>' +
													'</div>';

									// A new Info Window is created and set content
									var infowindow = new google.maps.InfoWindow({
										content: content_1,
										maxWidth: 350
									});

									marker = new google.maps.Marker({
										position	: myLatlng,
										map			: map,
										title		: "Tu Ubicación",
										icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
									});

									// This event expects a click on a marker
									// When this event is fired the Info Window is opened.
									google.maps.event.addListener(marker, 'click', function() {
										infowindow.open(map,marker);
									});

									// Event that closes the Info Window with a click on the map
									google.maps.event.addListener(map, 'click', function() {
										infowindow.close();
									});

									// *
									// START INFOWINDOW CUSTOMIZE.
									// The google.maps.event.addListener() event expects
									// the creation of the infowindow HTML structure 'domready'
									// and before the opening of the infowindow, defined styles are applied.
									// *
									google.maps.event.addListener(infowindow, 'domready', function() {

										// Reference to the DIV that wraps the bottom of infowindow
										var iwOuter = $('.gm-style-iw');

										/* Since this div is in a position prior to .gm-div style-iw.
										* We use jQuery and create a iwBackground variable,
										* and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
										*/
										var iwBackground = iwOuter.prev();

										// Removes background shadow DIV
										iwBackground.children(':nth-child(2)').css({'display' : 'none'});

										// Removes white background DIV
										iwBackground.children(':nth-child(4)').css({'display' : 'none'});

										// Moves the infowindow 25px to the right.
										//iwOuter.parent().parent().css({left: '5px'});

										// Moves the shadow of the arrow 76px to the left margin.
										iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 6px !important;'});

										// Moves the arrow 76px to the left margin.
										iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 6px !important;'});

										// Changes the desired tail shadow color.
										iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

										// Reference to the div that groups the close button elements.
										var iwCloseBtn = iwOuter.next();

										// Apply the desired effect to the close button
										iwCloseBtn.css({width: '28px',height: '28px', opacity: '1', right: '38px', top: '3px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

										// If the content of infowindow not exceed the set maximum height, then the gradient is removed.
										if($('.iw-content').height() < 140){
											$('.iw-bottom-gradient').css({display: 'none'});
										}

										// The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
										iwCloseBtn.mouseout(function(){
											$(this).css({opacity: '1'});
										});
									});

									//muestro la infowindow al inicio
									infowindow.open(map,marker);

								}

							</script>

							<?php
						}

					} ?>

			</div>

		</div>
	</div>
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
