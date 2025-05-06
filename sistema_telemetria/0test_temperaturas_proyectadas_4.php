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
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';      //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
set_time_limit(2400);
//Memora RAM Maxima del servidor, 4GB por defecto
ini_set('memory_limit', '4096M');

//Libreria
require_once '../LIBS_php/PHP_ML/vendor/autoload.php';

/****************************************************************/
//includes con las ejecuciones
/*************************************************************/
//Calculo de helada
$idEquipo      = 252;
$n_Prediccion  = 50;
$table         = '';

for ($i_dia = 8; $i_dia <= 9; $i_dia++) {
	for ($j_hora = 1; $j_hora <= 24; $j_hora++) {
		//filtros
		$SIS_where ="idTabla!=0";
		$SIS_where.=" AND MONTH(FechaSistema)=9";
		$SIS_where.=" AND DAY(FechaSistema)=".$i_dia;
		$SIS_where.=" AND HOUR(HoraSistema)=".$j_hora;

		//consulta
		$arrPrevision = array();
		$arrPrevision = db_select_array (false, 'Sensor_4', 'telemetria_listado_tablarelacionada_'.$idEquipo, '', $SIS_where, 'idTabla ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

		$arrContador     = array();
		$arrTemperatura  = array();
		$counterEquip    = 0;
		$Prom    = 0;

		if($arrPrevision!=false){
			foreach ($arrPrevision as $prev) {
				$arrContador[$counterEquip][0]   = $counterEquip;
				$arrTemperatura[$counterEquip]   = cantidades_google(cantidades($prev['Sensor_4'], 2));
				$Prom                            = $Prom + $prev['Sensor_4'];
				$counterEquip++;
			}
			if(isset($arrTemperatura)&&isset($arrContador)&&$counterEquip>1){
				$regression = new Phpml\Regression\LeastSquares();
				$regression->train($arrContador, $arrTemperatura);
				$HeladaEquip = $regression->predict([$n_Prediccion]);
			}

			if($counterEquip!=0){
				$Med = $Prom/$counterEquip;
			}else{
				$Med = 0;
			}

			$table .= '
			<tr>
				<td>'.$i_dia.'</td>
				<td>'.$j_hora.'</td>
				<td>'.cantidades(($Med), 2).'</td>
				<td>'.cantidades($HeladaEquip, 2).'</td>
			</tr>';
		}


	}
}

?>

<table>
	<tr>
		<th>Dia</th>
		<th>Hora</th>
		<th>Temperatura actual</th>
		<th>Temperatura proyectada</th>
	</tr>
	<?php echo $table; ?>
</table>