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
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/

$cadena = '';
for ($i = 1; $i <= $_GET['cantSensores']; $i++) {
	$cadena .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$cadena .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
	$cadena .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$cadena .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}

// consulto los datos
$SIS_query = '
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.GeoVelocidad,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.Nombre,
telemetria_listado.id_Geo'.$cadena;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`       ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`       ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`   ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`       ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

$arrFinalUnimed = array();
foreach ($arrUnimed as $sen) {
	$arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo <?php echo $rowData['Nombre']; ?></h5>
		</header>
        <div class="table-responsive">
			<?php
			$explanation  = '<strong>'.fecha_estandar($rowData['LastUpdateFecha']).' - '.$rowData['LastUpdateHora'].'</strong><br/>';
			if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
				$explanation .= '<strong>Velocidad: </strong>'.Cantidades($rowData['GeoVelocidad'], 0).' KM/h<br/>';
			}
			for ($i = 1; $i <= $_GET['cantSensores']; $i++) {
				//solo sensores activos
				if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
					if(isset($rowData['SensoresMedActual_'.$i])&&$rowData['SensoresMedActual_'.$i]<99900){$xdata=Cantidades_decimales_justos($rowData['SensoresMedActual_'.$i]);}else{$xdata='Sin Datos';}
					$explanation .= '<strong>'.$rowData['SensoresNombre_'.$i].': </strong>'.$xdata;
					$explanation .= ' '.$arrFinalUnimed[$rowData['SensoresUniMed_'.$i]];
					$explanation .= '<br/>';
				}
			}

			echo mapa_from_gps($rowData['GeoLatitud'], $rowData['GeoLongitud'], 'Equipos', 'Datos', $explanation, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1); ?>

        </div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
