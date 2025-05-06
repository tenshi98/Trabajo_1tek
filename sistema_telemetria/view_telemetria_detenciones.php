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
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
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
/**************************************************************/
// Se traen todos los datos de la detencion
$SIS_query = '
telemetria_listado_error_detenciones.idTelemetria,
telemetria_listado_error_detenciones.Fecha,
telemetria_listado_error_detenciones.Hora,
telemetria_listado_error_detenciones.Tiempo,
telemetria_listado_error_detenciones.GeoLatitud,
telemetria_listado_error_detenciones.GeoLongitud,
telemetria_listado_error_detenciones.idTabla,
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado.cantSensores';
$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_error_detenciones.idTelemetria';
$SIS_where = 'telemetria_listado_error_detenciones.idDetencion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_error_detenciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

//Se crea cadena dependiendo de la cantidad de sensores existentes
$subquery = '';
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	$subquery .= ',telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'].'.Sensor_'.$i;
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
// Se traen todos los datos de las mediciones
$SIS_query = 'telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'].'.idTabla'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado`                  ON telemetria_listado.idTelemetria                  = telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'].'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'].'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'].'.idTelemetria';
$SIS_where = 'telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'].'.idTabla ='.$rowData['idTabla'];
$rowMedicion = db_select_data (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'], $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowMedicion');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

$arrFinalUnimed = array();
foreach ($arrUnimed as $sen) { $arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo <?php echo $rowData['NombreEquipo']; ?></h5>
		</header>
		<div class="tab-content">
			<div class="table-responsive">
				<?php
				$explanation  = '<strong>'.fecha_estandar($rowData['Fecha']).' - '.$rowData['Hora'].'</strong><br/>';
				$explanation .= '<strong>Tiempo de detencion: </strong>'.$rowData['Tiempo'].'<br/>';
				//Reviso si tiene sensores activos
				$ndata = 0;
				for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
					$ndata++;
				}
				//si hay datos se imprime
				if($ndata!=0){
					$explanation .= '<strong>Medicion Sensores: </strong><br/>';
					for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
						if(isset($rowMedicion['Sensor_'.$i])&&$rowMedicion['Sensor_'.$i]<99900){$xdata=Cantidades_decimales_justos($rowMedicion['Sensor_'.$i]);}else{$xdata='Sin Datos';}
						$explanation .= '<strong>'.$rowMedicion['SensoresNombre_'.$i].': </strong>';
						$explanation .= ' '.$arrFinalUnimed[$rowMedicion['SensoresUniMed_'.$i]];
						$explanation .= '<br/>';
					}
				}
				echo mapa_from_gps($rowData['GeoLatitud'], $rowData['GeoLongitud'], 'Equipos', 'Datos', $explanation, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 2); ?>

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
