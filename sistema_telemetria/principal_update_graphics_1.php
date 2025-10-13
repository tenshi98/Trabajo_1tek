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
$idTipoUsuario  = $_SESSION['usuario']['zona']['idTipoUsuario'];
$idSistema      = $_SESSION['usuario']['zona']['idSistema'];
$idUsuario      = $_SESSION['usuario']['zona']['idUsuario'];
if(isset($_SESSION['usuario']['zona']['id_Geo'])&&$_SESSION['usuario']['zona']['id_Geo']!=''){
	$id_Geo = $_SESSION['usuario']['zona']['id_Geo'];
}else{
	$id_Geo = 1;//seguimiento activo
}

/***************************************/
//Variables
$timeback      = '01:00:00';

//se obtene los datos
$h_inicio    = restahoras($timeback,hora_actual());
$f_inicio    = fecha_actual();
$h_termino   = hora_actual();
$f_termino   = fecha_actual();

//Se calcula lapso de tiempo condicionando dias
if(hora_actual()<$timeback){
	$f_inicio = restarDias(fecha_actual(),1);
}
/*******************************************************/
// consulto los datos
$SIS_query = 'idTabla,FechaSistema,HoraSistema,GeoVelocidad';
for ($i = 1; $i <= $_GET['idSensoresActual']; $i++) {
	$SIS_query .= ',Sensor_'.$i;
}
$SIS_join  = '';
$SIS_where = '(TimeStamp BETWEEN "'.$f_inicio.' '.$h_inicio .'" AND "'.$f_termino.' '.$h_termino.'")';
$SIS_order = 'FechaSistema ASC, HoraSistema ASC';
$SIS_order = ' LIMIT 10000';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idEquipoActual'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');

?>

<script>

	var DatosRefresco = "<?php echo 'Datos desde <strong>'.fecha_estandar($f_inicio).'-'.$h_inicio .'</strong> a <strong>'.fecha_estandar($f_termino).'-'.$h_termino.'</strong>'; ?>";

	<?php
	/******************************************************/
	//Velocidades
	$data_vel = 'var data_vel_x = [';
	//recorro los resultados
	foreach ($arrMediciones as $med) {
		if(isset($med['GeoVelocidad'])&&$med['GeoVelocidad']>0){
			if(isset($med['Sensor_1'])&&$med['Sensor_1']>0&&isset($med['Sensor_2'])&&$med['Sensor_2']>0){
				$data_vel .= '["'.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['GeoVelocidad']).'],';
			}
		}
	}
	$data_vel .= '];';

	/******************************************************/
	//Vaciado del estanque
	$data_tanque = 'var data_tanque_x = [';
	//recorro los resultados
	foreach ($arrMediciones as $med) {
		if(isset($med['Sensor_3'])&&$med['Sensor_3']>0&&$med['Sensor_3']<99900){
			if(isset($med['Sensor_1'])&&$med['Sensor_1']>0&&isset($med['Sensor_2'])&&$med['Sensor_2']>0){
				$data_tanque .= '["'.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['Sensor_3']).'],';
			}
		}
	}
	$data_tanque .= '];';

	/******************************************************/
	//Flujo de caudales
	$data_caud_flu = 'var data_caud_flu_x = [';
	//recorro los resultados
	foreach ($arrMediciones as $med) {
		if(isset($med['Sensor_1'])&&$med['Sensor_1']>0&&isset($med['Sensor_2'])&&$med['Sensor_2']>0&&$med['Sensor_1']<99900&&$med['Sensor_2']<99900){
			$data_caud_flu .= '["'.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['Sensor_1']).', '.Cantidades_decimales_justos($med['Sensor_2']).'],';
		}
	}
	$data_caud_flu .= '];';

	/******************************************************/
	//Caudales

	//variables
	$total_derecho    = 0;
	$total_izquierdo  = 0;
	$cuenta_derecho   = 0;
	$cuenta_izquierdo = 0;
	//recorro los resultados
	foreach ($arrMediciones as $med) {
		//solo si el ramal esta derecho funcionando
		if(isset($med['Sensor_1'])&&$med['Sensor_1']>=1){
			$total_derecho   = $total_derecho + $med['Sensor_1'];
			$cuenta_derecho++;
		}
		//solo si el ramal esta izquierdo funcionando
		if(isset($med['Sensor_2'])&&$med['Sensor_2']>=1){
			$total_izquierdo   = $total_izquierdo + $med['Sensor_2'];
			$cuenta_izquierdo++;
		}
	}
	//Calculo
	if($cuenta_derecho!=0){    $Prom_derecho   = $total_derecho/$cuenta_derecho;      }else{$Prom_derecho   = 0;}
	if($cuenta_izquierdo!=0){  $Prom_izquierdo = $total_izquierdo/$cuenta_izquierdo;  }else{$Prom_izquierdo = 0;}

	$data_caud  = 'var data_caud_x = [';
	$data_caud .= '["Grupo 1",';
	$data_caud .= Cantidades_decimales_justos($Prom_derecho).',';
	$data_caud .= '"'.Cantidades($Prom_derecho, 2).'",';
	$data_caud .= Cantidades_decimales_justos($Prom_izquierdo).',';
	$data_caud .= '"'.Cantidades($Prom_izquierdo, 2).'",';
	$data_caud .= '],';
	$data_caud .= '];';

	/******************************************************/
	//Correccion
	if($Prom_derecho>$Prom_izquierdo){
		if($Prom_izquierdo!=0){ $correccion = (($Prom_derecho - $Prom_izquierdo)/$Prom_izquierdo)*100;}else{$correccion = 0;}
	}else{
		if($Prom_derecho!=0){   $correccion = (($Prom_izquierdo - $Prom_derecho)/$Prom_derecho)*100;}else{$correccion = 0;}
	}

	$data_gauge = 'var data_correccion_x = '.str_replace(",", ".",Cantidades($correccion, 2)).';';

	/******************************************************/
	//se imprimen los datos
	echo $data_vel;
	echo $data_tanque;
	echo $data_caud_flu;
	echo $data_caud;
	echo $data_gauge;

	?>
</script>

