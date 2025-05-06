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
/*                                               Ejecucion del codigo                                                             */
/**********************************************************************************************************************************/

//numero sensores equipo
$N_Maximo_Sensores = 72;
//Traigo todos los valores
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS Tel_Sensor_Nombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i.' AS Tel_Sensor_Valor_'.$i;
	$subquery .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$i.' AS Tel_Sensor_Tipo_'.$i;

	$subquery .= ',telemetria_mantencion_matriz.PuntoNombre_'.$i.' AS Matriz_Punto_'.$i;
	$subquery .= ',telemetria_mantencion_matriz.SensoresTipo_'.$i.' AS Matriz_Sensor_Tipo_'.$i;
	$subquery .= ',telemetria_mantencion_matriz.SensoresValor_'.$i.' AS Matriz_Sensor_Valor_'.$i;
	$subquery .= ',telemetria_mantencion_matriz.SensoresNumero_'.$i.' AS Matriz_Sensor_Numero_'.$i;

}

// consulto los datos
$SIS_query = '
telemetria_listado.Nombre AS Tel_Equipo,
telemetria_listado.Identificador AS Tel_Identificador,
telemetria_listado.FechaMantencionIni AS Tel_Fecha,
telemetria_listado.HoraMantencionIni AS Tel_Hora,

telemetria_mantencion_matriz.Nombre AS Matriz_Nombre,
telemetria_mantencion_matriz.cantPuntos AS Matriz_Puntos'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_mantencion_matriz`            ON telemetria_mantencion_matriz.idMatriz                 = telemetria_listado.idMatriz
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_tipo`        ON telemetria_listado_sensores_tipo.idTelemetria         = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['verify'];
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/*******************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado_sensores.idSensores,
telemetria_listado_sensores.Nombre,
core_sensores_funciones.Nombre AS SensorFuncion';
$SIS_join  = 'LEFT JOIN `core_sensores_funciones` ON core_sensores_funciones.idSensorFuncion = telemetria_listado_sensores.idSensorFuncion';
$SIS_where = '';
$SIS_order = 'idSensores ASC';
$arrTipos = array();
$arrTipos = db_select_array (false, $SIS_query, 'telemetria_listado_sensores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');

/*******************************************************/
//Variable Ubicación
//Cargamos la ubicacion original
$original = "telemetria_mantencion_ejecucion.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
if(isset($_GET['Identificador']) && $_GET['Identificador']!=''){  $location .= "&Identificador=".$_GET['Identificador'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                $location .= "&Nombre=".$_GET['Nombre'];}

?>

	<section class="invoice">

		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header">
					<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['Tel_Equipo'].' ('.$rowData['Tel_Identificador'].')'; ?>.
					<small class="pull-right"> <?php echo $rowData['Matriz_Nombre'] ?></small>
				</h2>
			</div>
		</div>

		<div class="row invoice-info">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
				<strong>Datos Mantencion</strong>
				<address>
					Fecha Inicio: <?php echo fecha_estandar($rowData['Tel_Fecha']); ?><br/>
					Hora Inicio: <?php echo $rowData['Tel_Hora'].' horas'; ?>
					<strong></strong>
				</address>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">

			</div>
		</div>

		<div class="">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Sensor</th>
							<th>Dato a Revisar</th>
							<th>Tipo Sensor <br/>Instalado</th>
							<th>Tipo Sensor <br/>Revisado</th>
							<th>Funcion</th>
							<th style="text-align: center;" width="120">Valor Pruebas</th>
							<th style="text-align: center;" width="120">Valor Actual</th>
							<th style="text-align: center;" width="120">Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$pass_points = 0;
						for ($i = 1; $i <= $rowData['Matriz_Puntos']; $i++) { ?>
							<tr class="odd">
								<td><?php echo $rowData['Tel_Sensor_Nombre_'.$rowData['Matriz_Sensor_Numero_'.$i]]; ?></td>
								<td><?php echo $rowData['Matriz_Punto_'.$i]; ?></td>
								<td><?php foreach ($arrTipos as $tipo) { if($rowData['Matriz_Sensor_Tipo_'.$rowData['Tel_Sensor_Tipo_'.$i]]==$tipo['idSensores']){ echo $tipo['Nombre'];}} ?></td>
								<td><?php foreach ($arrTipos as $tipo) { if($rowData['Matriz_Sensor_Tipo_'.$i]==$tipo['idSensores']){ echo $tipo['Nombre'];}} ?></td>
								<td><?php foreach ($arrTipos as $tipo) { if($rowData['Matriz_Sensor_Tipo_'.$i]==$tipo['idSensores']){ echo $tipo['SensorFuncion'];}} ?></td>
								<td align="center"><?php echo $rowData['Matriz_Sensor_Valor_'.$i]; ?></td>
								<td align="center"><?php echo Cantidades_decimales_justos($rowData['Tel_Sensor_Valor_'.$i]); ?></td>
								<td align="center">
									<?php
									if($rowData['Matriz_Sensor_Valor_'.$i]<$rowData['Tel_Sensor_Valor_'.$i]){
										echo '<span style="color:#55BD55">Pasa</span>';
										$pass_points++;
									}else{
										echo '<span style="color:#FF3A00">No Pasa</span>';
									}
									?>
								</td>
							</tr>
						<?php } ?>

					</tbody>
				</table>

			</div>
		</div>

		<div class="clearfix"></div>

		<div class="row" style="margin-top:15px;">
			<div class="col-xs-12">

				<?php if($pass_points>=$rowData['Matriz_Puntos']){ ?>
					<a href="<?php echo $location.'&verify='.$_GET['verify'].'&end=true'; ?>" class="btn btn-primary pull-right"  style="margin-left: 5px;" >
						<i class="fa fa-check-circle" aria-hidden="true"></i> Finalizar Mantencion
					</a>
				<?php } ?>

				<a href="<?php echo $location.'&verify='.$_GET['verify'].'&reset=true'; ?>" class="btn btn-default pull-right">
					<i class="fa fa-window-close-o" aria-hidden="true"></i> Resetear Valores
				</a>


			</div>
		</div>

	</section>
