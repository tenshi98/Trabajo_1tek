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
//Se aplican los filtros
$search = '';
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){   $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){       $search .= "&idZona=".$_GET['idZona'];}
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$search .="&fecha_desde=".$_GET['fecha_desde'];
	$search .="&fecha_hasta=".$_GET['fecha_hasta'];
}
//Variable de busqueda
$SIS_where = "telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idTabla!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){   $SIS_where .= " AND cross_predios_listado_zonas.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){$SIS_where .= " AND telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idZona=".$_GET['idZona'];}
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$SIS_where.=" AND telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['fecha_desde']."' AND '".$_GET['fecha_hasta']."'";
}
$SIS_where .=" GROUP BY cross_predios_listado_zonas.idPredio, telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idZona, telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idTelemetria";

/****************************************/
//Numero del sensor
$NSensor = 1;
//consulto
$SIS_query = '
telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTabla,
telemetria_listado.Nombre AS EquipoNombre,
cross_predios_listado.Nombre AS PredioNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.' AS CantidadMuestra';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona     = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idZona
LEFT JOIN `cross_predios_listado`         ON cross_predios_listado.idPredio         = cross_predios_listado_zonas.idPredio
LEFT JOIN `telemetria_listado`            ON telemetria_listado.idTelemetria        = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
$SIS_order = 'cross_predios_listado_zonas.idPredio ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idZona ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria ASC LIMIT 10000';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen Mediciones</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Predio</th>
						<th>Cuartel</th>
						<th>Equipo</th>
						<th>Cantidad Muestras</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrMediciones as $med) { ?>
						<tr class="odd">
							<td><?php echo $med['PredioNombre']; ?></td>
							<td><?php echo $med['CuartelNombre']; ?></td>
							<td><?php echo $med['EquipoNombre']; ?></td>
							<td><?php echo $med['CantidadMuestra']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'informe_cross_telemetria_01_view_map.php?idTabla='.$med['idTabla'].$search.'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Mapa" class="btn btn-primary btn-sm tooltip"><i class="fa fa-map" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php if(isset($_GET['return'])&&$_GET['return']!=''){ ?>
	<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
		<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php } ?>
 

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
