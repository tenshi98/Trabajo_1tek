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
$X_cantSensores = simpleDecode($_GET['cantSensores'], fecha_actual());
/**************************************************************/
//Se consultan datos
$SIS_query = 'idGrupo, Valor, idSupervisado';
$SIS_join  = '';
$SIS_where = 'idSupervisado=1';
$SIS_order = 'idGrupo ASC';
$arrGruposRev = array();
$arrGruposRev = db_select_array (false, $SIS_query, 'telemetria_listado_grupos_uso', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposRev');

/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_listado_tablarelacionada_".$X_Puntero.".idTabla!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['dia']) && $_GET['dia']!=''){    $SIS_where.=" AND telemetria_listado_tablarelacionada_".$X_Puntero.".FechaSistema ='".simpleDecode($_GET['dia'], fecha_actual())."'";}

//Se arma la queri con los datos justos recibidos
$subquery = '';
for ($i = 1; $i <= $X_cantSensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision.SensoresRevision_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_tablarelacionada_'.$X_Puntero.'.Sensor_'.$i;
}

//Se consulta en la bd y se traen sus datos
$SIS_query = '
telemetria_listado.Nombre AS EquipoNombre,
telemetria_listado_tablarelacionada_'.$X_Puntero.'.FechaSistema AS EquipoFecha,
telemetria_listado_tablarelacionada_'.$X_Puntero.'.HoraSistema AS EquipoHora'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado`                          ON telemetria_listado.idTelemetria                           = telemetria_listado_tablarelacionada_'.$X_Puntero.'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria           = telemetria_listado_tablarelacionada_'.$X_Puntero.'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision`        ON telemetria_listado_sensores_revision.idTelemetria         = telemetria_listado_tablarelacionada_'.$X_Puntero.'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria   = telemetria_listado_tablarelacionada_'.$X_Puntero.'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria           = telemetria_listado_tablarelacionada_'.$X_Puntero.'.idTelemetria';
$SIS_order = 'telemetria_listado_tablarelacionada_'.$X_Puntero.'.HoraSistema ASC';
$arrConsulta = array();
$arrConsulta = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$X_Puntero, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrConsulta');

//Arreglo temporal
$arrTable = array();
$arrTable['inicio']['EquipoFecha']   = '';
$arrTable['termino']['EquipoFecha']  = '';

//recorro los datos
foreach ($arrConsulta as $con) {

	//Reseteo Variable
	$rev_count = 0;
	$rev_sup   = 0;

	foreach ($arrGruposRev as $sen) {
		//Solo busco en los sensores que supervisan
		if(isset($sen['idSupervisado'])&&$sen['idSupervisado']==1){
			//recorro los sensores
			for ($i = 1; $i <= $X_cantSensores; $i++) {
				//verifico que esten activos
				if(isset($con['SensoresActivo_'.$i])&&$con['SensoresActivo_'.$i]==1){
					//Reviso si el sensor esta siendo supervisado
					if(isset($con['SensoresRevision_'.$i])&&$con['SensoresRevision_'.$i]==1){
						//verifico que pertenezca al grupo actual
						if($con['SensoresRevisionGrupo_'.$i]==$sen['idGrupo']){

							//verifico que el valor sea igual o superior al establecido
							if(isset($_GET['Amp'])&&$_GET['Amp']!=''&&simpleDecode($_GET['Amp'], fecha_actual())!=0){
								$valor_amp = simpleDecode($_GET['Amp'], fecha_actual());
							}else{
								$valor_amp = $sen['Valor'];
							}
							if($con['Sensor_'.$i]>=$valor_amp){

								//cuento los sensores dentro del grupo
								$rev_count++;
								//Valor Inicio
								if(isset($arrTable['inicio']['EquipoFecha'])&&$arrTable['inicio']['EquipoFecha']==''){
									$arrTable['inicio'][$i]['SensorNombre'] = $con['SensoresNombre_'.$i];
									$arrTable['inicio'][$i]['SensorValor']  = $con['Sensor_'.$i];
								}

								//Vacio las variables
								unset($arrTable['termino']);

								//Valor termino
								$arrTable['termino'][$i]['SensorNombre'] = $con['SensoresNombre_'.$i];
								$arrTable['termino'][$i]['SensorValor']  = $con['Sensor_'.$i];
								$arrTable['termino']['EquipoFecha']      = $con['EquipoFecha'];
								$arrTable['termino']['EquipoHora']       = $con['EquipoHora'];
								$arrTable['termino']['EquipoNombre']     = $con['EquipoNombre'];

							}
						}
					}
				}
			}
			//cuento los sensores supervisados dentro del grupo
			$rev_sup++;
		}
	}
	//Si alguno de los sensores era superior al minimo establecido, se indica que estaba activo el grupo
	if($rev_count!=0&&$rev_sup!=0){
		//Valor Inicio
		if(isset($arrTable['inicio']['EquipoFecha'])&&$arrTable['inicio']['EquipoFecha']==''){
			$arrTable['inicio']['EquipoFecha']  = $con['EquipoFecha'];
			$arrTable['inicio']['EquipoHora']   = $con['EquipoHora'];
			$arrTable['inicio']['EquipoNombre'] = $con['EquipoNombre'];
		}
	}
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Amperaje del equipo <?php echo $arrTable['termino']['EquipoNombre'].' el '.fecha_estandar($arrTable['termino']['EquipoFecha']); ?></h5>
		</header>
		<div class="tab-content">
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Inicio</th>
							<th>Termino</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
							<td><?php echo $arrTable['inicio']['EquipoHora']; ?></td>
							<td><?php echo $arrTable['termino']['EquipoHora']; ?></td>
						</tr>
						<tr class="odd">
							<td>
								<?php
								for ($i = 1; $i <= $X_cantSensores; $i++) {
									if(isset($arrTable['inicio'][$i]['SensorValor'])){
										echo $arrTable['inicio'][$i]['SensorNombre'].': '.Cantidades_decimales_justos($arrTable['inicio'][$i]['SensorValor']).'<br/>';
									}
								}
								?>
							</td>
							<td>
								<?php
								for ($i = 1; $i <= $X_cantSensores; $i++) {
									if(isset($arrTable['termino'][$i]['SensorValor'])&&$arrTable['termino'][$i]['SensorValor']!=0){
										echo $arrTable['termino'][$i]['SensorNombre'].': '.Cantidades_decimales_justos($arrTable['termino'][$i]['SensorValor']).'<br/>';
									}
								}
								?>
							</td>
						</tr>

					</tbody>
				</table>
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
