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
/**********************************************************************************************************************************/
/*                                   Se filtran las entradas para evitar ataques                                                  */
/**********************************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_seguridad/AntiXSS.php';
require_once '../A2XRXS_gears/xrxs_seguridad/Bootup.php';
require_once '../A2XRXS_gears/xrxs_seguridad/UTF8.php';
//Inicializo funcion
$security = new AntiXSS();
//Se limpian datos recibidos
$_POST = $security->xss_clean($_POST);
$_GET  = $security->xss_clean($_GET);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                               //Configuracion de la plataforma
require_once '../Legacy/1tek_public/funciones/Helpers.Functions.Propias.php';      //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(12400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}

//Variables
$Ndias         = 5;
$FechaInicial  = '2024-06-05';
$HoraInicial   = '00:00:01';
$Minutos       = '00:15:00';
$RevisionesDia = 96;
$idTelemetria  = 199;
//guardo datos
if(isset($idTelemetria)&&$idTelemetria!=''&&$idTelemetria!=0){

	//Obtengo todos los equipos de telemetria activos
	$z = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$z .= " AND telemetria_listado.idTab = 9"; //Power-Energy
	//Filtro el sistema al cual pertenece
	$z .= " AND telemetria_listado.idTelemetria = ".$idTelemetria;

	//Listar los equipos
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, 'idTelemetria, cantSensores ', 'telemetria_listado', '', $z, 'telemetria_listado.idTelemetria ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	//recorro doas
	for ($x_i = 0; $x_i <= $Ndias; $x_i++) {
		$Fecha         = sumarDias($FechaInicial,$x_i);
		$FechaInicio   = $Fecha;
		$FechaTermino  = $Fecha;
		//recorro horas
		for ($x_x = 1; $x_x <= $RevisionesDia; $x_x++) {
			$horasuma     = multHoras($Minutos,$x_x);
			$Hora         = sumahoras($HoraInicial,$horasuma);
			$HoraInicio   = restahoras('00:15:00', $Hora);
			$HoraTermino  = $Hora;
			if($HoraTermino>'23:59:59'){$HoraTermino = '23:59:59';}

			//recorro los equipos
			foreach ($arrEquipo as $data) {

				/*********************************************************/
				//genero filtros
				$SIS_query = 'Segundos';
				for ($i = 1; $i <= $data['cantSensores']; $i++) {
					$SIS_query .= ',Sensor_'.$i;
				}
				$SIS_where = " (TimeStamp BETWEEN '".$FechaInicio." ".$HoraInicio ."' AND '".$FechaTermino." ".$HoraTermino."')";

				//consulto
				$arrPromedio = array();
				$arrPromedio = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$data['idTelemetria'], '', $SIS_where, 'TimeStamp ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrPromedio');

				/*********************************************************/
				//Variables
				$SumaSensor = array();
				//recorro
				foreach ($arrPromedio as $prom) {
					//verifico que existan segundos
					if(isset($prom['Segundos'])&&$prom['Segundos']!=0){
						//recorro sensores
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//Operacion
							$Total = ($prom['Sensor_'.$i]*$prom['Segundos'])/3600;
							//verifico si existe variable
							if(isset($SumaSensor[$i])&&$SumaSensor[$i]!=''){
								$SumaSensor[$i] = $SumaSensor[$i] + $Total;
							}else{
								$SumaSensor[$i] = $Total;
							}
						}
					}
				}
				/*********************************************************/
				//Genero la cadena
				$chain_in = '';
				//cadena
				$SIS_data  = "'".$data['idTelemetria']."'";
				$SIS_data .= ",'".$FechaTermino."'";
				$SIS_data .= ",'".fecha2NdiaMes($FechaTermino)."'";
				$SIS_data .= ",'".fecha2NMes($FechaTermino)."'";
				$SIS_data .= ",'".fecha2Ano($FechaTermino)."'";
				$SIS_data .= ",'".$HoraTermino."'";
				$SIS_data .= ",'".$FechaTermino." ".$HoraTermino."'";
				//recorro sensores
				for ($i = 1; $i <= $data['cantSensores']; $i++) {
					//verifico que exista
					if(isset($SumaSensor[$i])&&$SumaSensor[$i]!=''){
						$SIS_data .= ",'".$SumaSensor[$i]."'";
						$chain_in .= ',Sensor_'.$i;
					}
				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria, FechaSistema, FechaSistema_dia, FechaSistema_mes,
				FechaSistema_ano, HoraSistema, TimeStamp'.$chain_in;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_crossenergy_hora', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

			}

			echo 'ejecutado:('.$FechaInicio.' - '.$HoraInicio.') a ('.$FechaTermino.' - '.$HoraTermino.')<br>';
		}
	}
}

?>
