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
$original = "informe_crossenergy_04.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){

//numero sensores equipo
$N_Maximo_Sensores = 20;
$subquery_1 = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores';
$subquery_2 = 'idTabla';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery_1 .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$subquery_2 .= ',SUM(Sensor_'.$i.') AS Med_'.$i;
}
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_grupo`       ON telemetria_listado_sensores_grupo.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';
//Obtengo los datos
$rowData = db_select_data (false, $subquery_1, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria ='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Temporales
$Subquery    = '';
$Subquery_2  = '';
//recorro los sensores
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	//Si el sensor esta activo
	if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
		//para la subconsulta
		if($rowData['SensoresGrupo_'.$i]==$_GET['idGrupo']){
			$Subquery .= ',Sensor_'.$i;
			//si viene vacio
			if(isset($Subquery_2)&&$Subquery_2!=''){
				$Subquery_2 .= ' + Sensor_'.$i;
			}else{
				$Subquery_2 .= ', SUM(Sensor_'.$i;
			}
		}
	}
}
//cierro subquery
$Subquery_2 .= ') AS Total';

//valido fechas
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''){  $f_inicio  = $_GET['f_inicio'];   }else{$f_inicio  = fecha_actual();}
if(isset($_GET['f_termino'])&&$_GET['f_termino']!=''){$f_termino = $_GET['f_termino'];  }else{$f_termino = fecha_actual();}

$Mes_01 = fecha2NMes($f_inicio) - 1;
$Mes_02 = fecha2NMes($f_inicio) - 2;
$Mes_03 = fecha2NMes($f_inicio) - 3;
$Mes_04 = fecha2NMes($f_inicio) - 4;
$Mes_05 = fecha2NMes($f_inicio) - 5;
$Mes_06 = fecha2NMes($f_inicio) - 6;
$Mes_07 = fecha2NMes($f_inicio) - 7;
$Mes_08 = fecha2NMes($f_inicio) - 8;
$Mes_09 = fecha2NMes($f_inicio) - 9;
$Mes_10 = fecha2NMes($f_inicio) - 10;
$Mes_11 = fecha2NMes($f_inicio) - 11;
$Mes_12 = fecha2NMes($f_inicio) - 11;

$Ano_01 = fecha2Ano($f_inicio);
$Ano_02 = fecha2Ano($f_inicio);
$Ano_03 = fecha2Ano($f_inicio);
$Ano_04 = fecha2Ano($f_inicio);
$Ano_05 = fecha2Ano($f_inicio);
$Ano_06 = fecha2Ano($f_inicio);
$Ano_07 = fecha2Ano($f_inicio);
$Ano_08 = fecha2Ano($f_inicio);
$Ano_09 = fecha2Ano($f_inicio);
$Ano_10 = fecha2Ano($f_inicio);
$Ano_11 = fecha2Ano($f_inicio);
$Ano_12 = fecha2Ano($f_inicio);

if($Mes_01 < 1){ $Mes_01 = (12 + fecha2NMes($f_inicio)) - 1;  $Ano_01 = $Ano_01 - 1; }
if($Mes_02 < 1){ $Mes_02 = (12 + fecha2NMes($f_inicio)) - 2;  $Ano_02 = $Ano_02 - 1; }
if($Mes_03 < 1){ $Mes_03 = (12 + fecha2NMes($f_inicio)) - 3;  $Ano_03 = $Ano_03 - 1; }
if($Mes_04 < 1){ $Mes_04 = (12 + fecha2NMes($f_inicio)) - 4;  $Ano_04 = $Ano_04 - 1; }
if($Mes_05 < 1){ $Mes_05 = (12 + fecha2NMes($f_inicio)) - 5;  $Ano_05 = $Ano_05 - 1; }
if($Mes_06 < 1){ $Mes_06 = (12 + fecha2NMes($f_inicio)) - 6;  $Ano_06 = $Ano_06 - 1; }
if($Mes_07 < 1){ $Mes_07 = (12 + fecha2NMes($f_inicio)) - 7;  $Ano_07 = $Ano_07 - 1; }
if($Mes_08 < 1){ $Mes_08 = (12 + fecha2NMes($f_inicio)) - 8;  $Ano_08 = $Ano_08 - 1; }
if($Mes_09 < 1){ $Mes_09 = (12 + fecha2NMes($f_inicio)) - 9;  $Ano_09 = $Ano_09 - 1; }
if($Mes_10 < 1){ $Mes_10 = (12 + fecha2NMes($f_inicio)) - 10; $Ano_10 = $Ano_10 - 1; }
if($Mes_11 < 1){ $Mes_11 = (12 + fecha2NMes($f_inicio)) - 11; $Ano_11 = $Ano_11 - 1; }
if($Mes_12 < 1){ $Mes_12 = (12 + fecha2NMes($f_inicio)) - 12; $Ano_12 = $Ano_12 - 1; }


$Mesx_01 = numero_mes($Mes_01);
$Mesx_02 = numero_mes($Mes_02);
$Mesx_03 = numero_mes($Mes_03);
$Mesx_04 = numero_mes($Mes_04);
$Mesx_05 = numero_mes($Mes_05);
$Mesx_06 = numero_mes($Mes_06);
$Mesx_07 = numero_mes($Mes_07);
$Mesx_08 = numero_mes($Mes_08);
$Mesx_09 = numero_mes($Mes_09);
$Mesx_10 = numero_mes($Mes_10);
$Mesx_11 = numero_mes($Mes_11);
$Mesx_12 = numero_mes($Mes_12);

$Fecha_Ini_01 = $Ano_01.'-'.$Mesx_01.'-01';
$Fecha_Ini_02 = $Ano_02.'-'.$Mesx_02.'-01';
$Fecha_Ini_03 = $Ano_03.'-'.$Mesx_03.'-01';
$Fecha_Ini_04 = $Ano_04.'-'.$Mesx_04.'-01';
$Fecha_Ini_05 = $Ano_05.'-'.$Mesx_05.'-01';
$Fecha_Ini_06 = $Ano_06.'-'.$Mesx_06.'-01';
$Fecha_Ini_07 = $Ano_07.'-'.$Mesx_07.'-01';
$Fecha_Ini_08 = $Ano_08.'-'.$Mesx_08.'-01';
$Fecha_Ini_09 = $Ano_09.'-'.$Mesx_09.'-01';
$Fecha_Ini_10 = $Ano_10.'-'.$Mesx_10.'-01';
$Fecha_Ini_11 = $Ano_11.'-'.$Mesx_11.'-01';
$Fecha_Ini_12 = $Ano_12.'-'.$Mesx_12.'-01';

$Fecha_Term_01 = Fecha_ultimo_dia_mes($Fecha_Ini_01);
$Fecha_Term_02 = Fecha_ultimo_dia_mes($Fecha_Ini_02);
$Fecha_Term_03 = Fecha_ultimo_dia_mes($Fecha_Ini_03);
$Fecha_Term_04 = Fecha_ultimo_dia_mes($Fecha_Ini_04);
$Fecha_Term_05 = Fecha_ultimo_dia_mes($Fecha_Ini_05);
$Fecha_Term_06 = Fecha_ultimo_dia_mes($Fecha_Ini_06);
$Fecha_Term_07 = Fecha_ultimo_dia_mes($Fecha_Ini_07);
$Fecha_Term_08 = Fecha_ultimo_dia_mes($Fecha_Ini_08);
$Fecha_Term_09 = Fecha_ultimo_dia_mes($Fecha_Ini_09);
$Fecha_Term_10 = Fecha_ultimo_dia_mes($Fecha_Ini_10);
$Fecha_Term_11 = Fecha_ultimo_dia_mes($Fecha_Ini_11);
$Fecha_Term_12 = Fecha_ultimo_dia_mes($Fecha_Ini_12);

/*****************************************/
$SIS_query = 'FechaSistema, HoraSistema'.$Subquery.$Subquery_2;
$SIS_join  = '';
$SIS_where = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$f_inicio.' '.$_GET['h_inicio'] .'" AND "'.$f_termino.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_order = 'Total DESC LIMIT 2';
$arrDemanda_0 = array();
$arrDemanda_0 = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda');

$SIS_where_1  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_01.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_01.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_2  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_02.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_02.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_3  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_03.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_03.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_4  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_04.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_04.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_5  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_05.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_05.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_6  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_06.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_06.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_7  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_07.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_07.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_8  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_08.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_08.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_9  = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_09.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_09.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_10 = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_10.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_10.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_11 = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_11.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_11.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';
$SIS_where_12 = 'idTelemetria = '.$_GET['idTelemetria'].' AND (TimeStamp BETWEEN "'.$Fecha_Ini_12.' '.$_GET['h_inicio'] .'" AND "'.$Fecha_Term_12.' '.$_GET['h_termino'].'")  GROUP BY TimeStamp';

$arrDemanda_1  = array();
$arrDemanda_2  = array();
$arrDemanda_3  = array();
$arrDemanda_4  = array();
$arrDemanda_5  = array();
$arrDemanda_6  = array();
$arrDemanda_7  = array();
$arrDemanda_8  = array();
$arrDemanda_9  = array();
$arrDemanda_10 = array();
$arrDemanda_11 = array();
$arrDemanda_12 = array();

$arrDemanda_1  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_1');
$arrDemanda_2  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_2');
$arrDemanda_3  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_3, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_3');
$arrDemanda_4  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_4, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_4');
$arrDemanda_5  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_5, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_5');
$arrDemanda_6  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_6, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_6');
$arrDemanda_7  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_7, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_7');
$arrDemanda_8  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_8, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_8');
$arrDemanda_9  = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_9, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_9');
$arrDemanda_10 = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_10, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_10');
$arrDemanda_11 = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_11, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_11');
$arrDemanda_12 = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where_12, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDemanda_12');



/****************************************************************/
//Variables
$Temp_0      = '';
$Temp_1      = '';
$Temp_2      = '';
$arrData_0   = array();
$Data_1   = '';
$Data_2   = '';
/******************************************************/
//recorro
foreach ($arrDemanda_0 as $data) {
	//Variables
	$Temp_0 .= "'".$data['FechaSistema']." ".$data['HoraSistema']."',";
	//verifico si existe
	if(isset($arrData_0['Value'])&&$arrData_0['Value']!=''){
		$arrData_0['Value'] .= ", ".floatval(number_format($data['Total'], 2, '.', ''));
	//si no lo crea
	}else{
		$arrData_0['Value'] = floatval(number_format($data['Total'], 2, '.', ''));
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_12 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_12." - ".$Mes_12."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_12." - ".$Mes_12."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_11 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_11." - ".$Mes_11."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_11." - ".$Mes_11."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_10 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_10." - ".$Mes_10."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_10." - ".$Mes_10."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_9 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_09." - ".$Mes_09."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_09." - ".$Mes_09."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_8 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_08." - ".$Mes_08."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_08." - ".$Mes_08."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_7 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_07." - ".$Mes_07."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_07." - ".$Mes_07."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_6 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_06." - ".$Mes_06."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_06." - ".$Mes_06."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_5 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_05." - ".$Mes_05."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_05." - ".$Mes_05."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_4 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_04." - ".$Mes_04."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_04." - ".$Mes_04."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_3 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_03." - ".$Mes_03."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_03." - ".$Mes_03."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_2 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_02." - ".$Mes_02."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_02." - ".$Mes_02."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}
//recorro
$xx = 0;
foreach ($arrDemanda_1 as $data) {
	if($xx==0){
		$Temp_1 .= "'".$Ano_01." - ".$Mes_01."',";
		$Data_1 .= floatval(number_format($data['Total'], 2, '.', '')).',';
		$xx++;
	}else{
		$Temp_2 .= "'".$Ano_01." - ".$Mes_01."',";
		$Data_2 .= floatval(number_format($data['Total'], 2, '.', '')).',';
	}
}

//nombres
$arrData_0['Name']  = "'Demanda de suministro'";
$DataName_1           = "'1° Demanda'";
$DataName_2           = "'2° Demanda'";

//variables
$Graphics_xData_0       = 'var xData = [['.$Temp_0.'],];';
$Graphics_yData_0       = 'var yData = [['.$arrData_0['Value'].'],];';
$Graphics_names_0       = 'var names = ['.$arrData_0['Name'].',];';
$Graphics_info_0        = "var grf_info = [''];";
$Graphics_markerColor_0 = "var markerColor = [''];";
$Graphics_markerLine_0  = "var markerLine = [''];";

//variables
$Graphics_xData_1       = 'var xData = [['.$Temp_1.'],['.$Temp_2.']];';
$Graphics_yData_1       = 'var yData = [['.$Data_1.'],['.$Data_2.']];';
$Graphics_names_1       = 'var names = ['.$DataName_1.','.$DataName_2.'];';
$Graphics_info_1        = "var grf_info = [''];";
$Graphics_markerColor_1 = "var markerColor = [''];";
$Graphics_markerLine_1  = "var markerLine = [''];";

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Estado del Equipo <?php echo $rowData['Nombre']; ?></h5>
		</header>
		<div class="table-responsive" id="grf">
			<?php
				$Titulo = 'Demanda de suministro (Periodo: '.$_GET['h_inicio'].'-'.$f_inicio.' al '.$_GET['h_termino'].'-'.$f_termino.')';
				echo GraphBarr_1('graphBarra_1', $Titulo, 'Fecha', 'kW', $Graphics_xData_0, $Graphics_yData_0, $Graphics_names_0, $Graphics_info_0, $Graphics_markerColor_0, $Graphics_markerLine_0,1, 0); 
			?>
			<?php
				$Titulo = 'Demanda de suministro (del '.$Ano_12.'-'.$Mesx_12.' al  '.$Ano_01.'-'.$Mesx_01.')';
				echo GraphBarr_1('graphBarra_2', $Titulo, 'Año - mes', 'kW', $Graphics_xData_1, $Graphics_yData_1, $Graphics_names_1, $Graphics_info_1, $Graphics_markerColor_1, $Graphics_markerLine_1,1, 1); 
			?>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=9";//Power-Energy
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

               <?php
				//Se verifican si existen los datos
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}
				if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = '';}
				if(isset($idGrafico)){     $x8  = $idGrafico;    }else{$x8  = '';}
				//Si es redireccionado desde otra pagina con datos precargados
				if(isset($_GET['view'])&&$_GET['view']!='') { $x5  = $_GET['view'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 2, $dbConn);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
