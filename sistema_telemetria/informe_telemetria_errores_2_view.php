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
/*                                                Carga del documento HTML                                                        */
/**********************************************************************************************************************************/
/**********************************************************************************************************************************/
/***********************************/
//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
$SIS_query = '
telemetria_listado_errores.idErrores,
telemetria_listado_errores.Descripcion,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Hora,
telemetria_listado_errores.Sensor,
telemetria_listado_errores.Valor,
telemetria_listado_errores.GeoLatitud,
telemetria_listado_errores.GeoLongitud,
telemetria_listado.Nombre AS NombreEquipo'.$subquery;
$SIS_join  = ' LEFT JOIN `telemetria_listado`                  ON telemetria_listado.idTelemetria                 = telemetria_listado_errores.idTelemetria';
$SIS_join .= ' LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria = telemetria_listado_errores.idTelemetria';
$SIS_where = 'telemetria_listado_errores.idErrores = '.simpleDecode($_GET['view'], fecha_actual()).' AND telemetria_listado_errores.idTipo!=999 AND telemetria_listado_errores.Valor<99900';
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), $form_trabajo);
/***********************************/
//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');
/***********************************/
$arrFinalUnimed = array();
foreach ($arrUnimed as $sen) {
	$arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo <?php echo $rowData['NombreEquipo']; ?></h5>

		</header>
			<div class="table-responsive">

			<?php
			$unimed = ' '.$arrFinalUnimed[$rowData['SensoresUniMed_'.$rowData['Sensor']]];
			$explanation  = '<strong>'.fecha_estandar($rowData['Fecha']).' - '.$rowData['Hora'].'</strong><br/>';
			$explanation .= $rowData['Descripcion'].'<br/>';
			$explanation .= '<strong>Valor: </strong>'.Cantidades_decimales_justos($rowData['Valor']).$unimed.'<br/>';

			echo mapa_from_gps($rowData['GeoLatitud'], $rowData['GeoLongitud'], 'Equipos', 'Datos', $explanation, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1); ?>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
