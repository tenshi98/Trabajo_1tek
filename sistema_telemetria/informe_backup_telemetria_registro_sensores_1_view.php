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
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado_sensores_nombre.SensoresNombre_'.simpleDecode($_GET['sensorn'], fecha_actual()).' AS SensorNombre,

backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTabla,
backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.FechaSistema,
backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.HoraSistema,
backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.GeoLatitud,
backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.GeoLongitud,
backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.Sensor_'.simpleDecode($_GET['sensorn'], fecha_actual()).' AS SensorValue,
telemetria_listado_unidad_medida.Nombre AS Unimed';
$SIS_join  = '
LEFT JOIN `telemetria_listado`                   ON telemetria_listado.idTelemetria                   = backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_nombre`   ON telemetria_listado_sensores_nombre.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`   ON telemetria_listado_sensores_unimed.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTelemetria
LEFT JOIN `telemetria_listado_unidad_medida`     ON telemetria_listado_unidad_medida.idUniMed         = telemetria_listado_sensores_unimed.SensoresUniMed_'.simpleDecode($_GET['sensorn'], fecha_actual());
$SIS_where = 'backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTabla = '.simpleDecode($_GET['view'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()), $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo <?php echo $rowData['NombreEquipo']; ?></h5>
		</header>
        <div class="table-responsive">
			<?php
			$explanation  = '<strong>'.fecha_estandar($rowData['FechaSistema']).' - '.$rowData['HoraSistema'].'</strong><br/>';
			$explanation .= '<strong>Equipo: </strong>'.$rowData['NombreEquipo'].'<br/>';
			$explanation .= '<strong>Sensor: </strong>'.$rowData['SensorNombre'].'<br/>';
			$explanation .= '<strong>Medicion: </strong>'.Cantidades_decimales_justos($rowData['SensorValue']).' '.$rowData['Unimed'].'<br/>';

			echo mapa_from_gps($rowData['GeoLatitud'], $rowData['GeoLongitud'], 'Equipos', 'Datos', $explanation, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1);

			?>

        </div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
