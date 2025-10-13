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
$TelemetriaID = $_GET['idTelemetria'];
$Fecha        = $_GET['Fecha'];
/**************************************************************/
// consulto los datos
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = 'FechaSistema = "'.$Fecha.'"';

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$TelemetriaID, '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowCantSensores = db_select_data (false, 'cantSensores', 'telemetria_listado', '', 'idTelemetria='.$TelemetriaID, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	/****************************************************************/
	//obtengo la cantidad real de sensores
	$SIS_query = 'telemetria_listado.Nombre AS NombreEquipo';
	for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
	}
	$SIS_join  = 'LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria';
	$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$TelemetriaID, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = 'FechaSistema, HoraSistema';
	for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
		$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
	}
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
	$arrDatos = array();
	$arrDatos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$TelemetriaID, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDatos');

	/*************************************************************************/
	//Variable de busqueda
	$SIS_where = 'idGrupo = 0 ';
	for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
		//verifico si existe
		if(isset($rowEquipo['SensoresGrupo_'.$i])&&$rowEquipo['SensoresGrupo_'.$i]!=0){
			$SIS_where .= ' OR idGrupo='.$rowEquipo['SensoresGrupo_'.$i];
		}
	}
	//consulto grupos
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_where, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	/*************************************************************************/
	//Variables
	$m_table        = '';
	$m_table_title  = '';
	$Temp_1         = '';
	$count          = 0;
	$arrData        = array();

	//se arman datos
	foreach ($arrDatos as $fac) {

		//variables
		$arrDato       = array();
		$SubTotal      = 0;
		$CountSubTotal = 0;

		//recorro los sensores
		for ($x = 1; $x <= $rowCantSensores['cantSensores']; $x++) {
			//Que el valor medido sea distinto de 999
			if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
				//verifico si existe
				if(isset($arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor'])&&$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor']!=''){
					$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor'] = $arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor'] + $fac['SensorValue_'.$x];
					$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Cuenta']++;
				//si no lo crea
				}else{
					$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor']  = $fac['SensorValue_'.$x];
					$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Cuenta'] = 1;
				}
			}
		}

		//Guardo la fecha
		$Temp_1 .= "'".Fecha_estandar($fac['FechaSistema'])." - ".$fac['HoraSistema']."',";

		/***********************************************/
		//imprimo tabla
		$m_table .= '
		<tr class="odd">
			<td>'.fecha_estandar($fac['FechaSistema']).'</td>
			<td>'.$fac['HoraSistema'].'</td>';
			//recorro los grupos
			foreach ($arrGrupos as $gru) {

				/***********************************************/
				//verifico si hay datos
				if($arrDato[$gru['idGrupo']]['Cuenta']!=0){
					$New_Dato = $arrDato[$gru['idGrupo']]['Valor']/$arrDato[$gru['idGrupo']]['Cuenta'];
				}else{
					$New_Dato = 0;
				}

				/***********************************************/
				//guardo dentro del grupo
				//verifico si existe
				if(isset($arrData[$gru['idGrupo']]['Value'])&&$arrData[$gru['idGrupo']]['Value']!=''){
					$arrData[$gru['idGrupo']]['Value'] .= ", ".$New_Dato;
				//si no lo crea
				}else{
					$arrData[$gru['idGrupo']]['Value'] = $New_Dato;
				}

				/***********************************************/
				//imprimo tabla
				$m_table .= '<td>'.cantidades($New_Dato, 2).'</td>';
				//guardo subtotal de la fila
				$SubTotal = $SubTotal + $New_Dato;
				$CountSubTotal++;
			}
		/***********************************************/
		//verifico si existe
		if(isset($CountSubTotal)&&$CountSubTotal!=0){
			if(isset($arrData[9999]['Value'])&&$arrData[9999]['Value']!=''){
				$arrData[9999]['Value'] .= ", ".($SubTotal/$CountSubTotal);
			//si no lo crea
			}else{
				$arrData[9999]['Value'] = ($SubTotal/$CountSubTotal);
			}
			//imprimo SubTotal
			$m_table .= '<td>'.cantidades($SubTotal/$CountSubTotal, 2).'</td>';
		}
		//imprimo tabla
		$m_table .= '</tr>';
		//contador
		$count++;
	}
	//variables
	$Graphics_xData       = 'var xData = [';
	$Graphics_yData       = 'var yData = [';
	$Graphics_names       = 'var names = [';
	$Graphics_types       = 'var types = [';
	$Graphics_texts       = 'var texts = [';
	$Graphics_lineColors  = 'var lineColors = [';
	$Graphics_lineDash    = 'var lineDash = [';
	$Graphics_lineWidth   = 'var lineWidth = [';
	//se agrega nuevo item
	$stack = [ "idGrupo" => 9999, "Nombre" => "Promedio"];
	array_push($arrGrupos, $stack);
	//Se crean los datos
	foreach ($arrGrupos as $gru) {
		if(isset($arrData[$gru['idGrupo']]['Value'])&&$arrData[$gru['idGrupo']]['Value']!=''){
			//las fechas
			$Graphics_xData      .='['.$Temp_1.'],';
			//los valores
			$Graphics_yData      .='['.$arrData[$gru['idGrupo']]['Value'].'],';
			//los nombres
			$Graphics_names      .= '"'.$gru['Nombre'].'",';
			//los tipos
			$Graphics_types      .= "'',";
			//si lleva texto en las burbujas
			$Graphics_texts      .= "[],";
			//los colores de linea
			$Graphics_lineColors .= "'',";
			//si es subtotal
			if(isset($gru['idGrupo'])&&$gru['idGrupo']==9999){
				//los tipos de linea
				$Graphics_lineDash   .= "'dot',";
				//los anchos de la linea
				$Graphics_lineWidth  .= "'3',";
			}else{
				//los tipos de linea
				$Graphics_lineDash   .= "'',";
				//los anchos de la linea
				$Graphics_lineWidth  .= "'',";
			}
		}
	}
	$Graphics_xData      .= '];';
	$Graphics_yData      .= '];';
	$Graphics_names      .= '];';
	$Graphics_types      .= '];';
	$Graphics_texts      .= '];';
	$Graphics_lineColors .= '];';
	$Graphics_lineDash   .= '];';
	$Graphics_lineWidth  .= '];';

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5> Graficos del equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
			</header>
			<div class="table-responsive" id="grf">

				<?php
				$gr_tittle = 'Grafico';
				$gr_unimed = 'Consumo';

				echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); ?>

			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Tabla de Datos del equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
							<th>Fecha</th>
							<th>Hora</th>
							<?php foreach ($arrGrupos as $gru) { echo '<th>'.$gru['Nombre'].'</th>'; } ?>
						</tr>
						<?php echo $m_table; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<?php } ?>

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
