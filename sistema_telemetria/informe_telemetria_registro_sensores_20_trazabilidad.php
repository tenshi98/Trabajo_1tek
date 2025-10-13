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

/****************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema!="0000-00-00"';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}

//obtengo la cantidad real de sensores
$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo,cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

//numero sensores equipo
$consql = '';
for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
	$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
	$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
	$consql .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
	$consql .= ',telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$i.' AS SensorValue_'.$i;
}
/****************************************************************/
//se traen lo datos del equipo
$SIS_query = '
telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema,
telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema'.$consql;
$SIS_join  = '
LEFT JOIN `telemetria_listado`                  ON telemetria_listado.idTelemetria                  = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
$SIS_order = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema ASC LIMIT 10000';
$arrEquipos = array();
$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

//Se trae el dato del grupo
$rowGrupo = db_select_data (false, 'Nombre', 'telemetria_listado_grupos', '', 'idGrupo='.$_GET['idGrupo'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowGrupo');

/****************************************************************/
//Variables
//$m_table        = '';
//$m_table_title  = '';
$Temp_1         = '';
$arrData        = array();
$count          = 0;
/****************************************************************/
//titulo de la tabla
/*$m_table_title  .= '<th>Temperatura</th>';
$m_table_title  .= '<th>Humedad</th>';*/
$arrData[1]['Name'] = "'Temperatura'";
$arrData[2]['Name'] = "'Humedad'";

//se arman datos
foreach ($arrEquipos as $fac) {

	//numero sensores equipo
	$Temperatura       = 0;
	$Temperatura_N     = 0;
	$Humedad           = 0;
	$Humedad_N         = 0;

	for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
		if($fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($fac['SensoresActivo_'.$x])&&$fac['SensoresActivo_'.$x]==1){
				//Que el valor medido sea distinto de 999
				if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
					//Si es humedad
					if($fac['SensoresUniMed_'.$x]==2){$Humedad     = $Humedad + $fac['SensorValue_'.$x];    $Humedad_N++;}
					//Si es temperatura
					if($fac['SensoresUniMed_'.$x]==3){$Temperatura = $Temperatura + $fac['SensorValue_'.$x];$Temperatura_N++;}
				}
			}
		}
	}

	if($Temperatura_N!=0){  $New_Temperatura = $Temperatura/$Temperatura_N; }else{$New_Temperatura = 0;}
	if($Humedad_N!=0){      $New_Humedad     = $Humedad/$Humedad_N;         }else{$New_Humedad = 0;}

	//omite la linea mientras alguna de las variables contenga datos
	if($Temperatura_N!=0 OR $Humedad_N!=0){
		$Temp_1  .= "'".Fecha_estandar($fac['FechaSistema'])." - ".Hora_estandar($fac['HoraSistema'])."',";
		//verifico si existe
		if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){
			$arrData[1]['Value'] .= ", ".$New_Temperatura;
		//si no lo crea
		}else{
			$arrData[1]['Value'] = $New_Temperatura;
		}
		//verifico si existe
		if(isset($arrData[2]['Value'])&&$arrData[2]['Value']!=''){
			$arrData[2]['Value'] .= ", ".$New_Humedad;
		//si no lo crea
		}else{
			$arrData[2]['Value'] = $New_Humedad;
		}
		//Tabla
		/*$m_table .= '<tr class="odd">';
		$m_table .= '<td>'.fecha_estandar($fac['FechaSistema']).'</td>';
		$m_table .= '<td>'.$fac['HoraSistema'].'</td>';
		$m_table .= '<td>'.cantidades($New_Temperatura, 2).' °C</td>';
		$m_table .= '<td>'.cantidades($New_Humedad, 2).' %</td>';
		$m_table .= '</tr>';*/
	}
	//contador
	//$count++;
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Graficos del equipo <?php echo $rowEquipo['NombreEquipo']; if(isset($rowGrupo['Nombre'])&&$rowGrupo['Nombre']!=''){echo ' del grupo '.$rowGrupo['Nombre'];} ?></h5>
		</header>
		<div class="table-responsive">
			<?php
			$gr_tittle = 'Grafico Temperatura/Humedad';
			echo GraphLinear_3('graphLinear_1', $gr_tittle, 'Fecha', 'Temperatura', 'Humedad', $Temp_1, $arrData[1]['Value'], $arrData[1]['Name'], $Temp_1, $arrData[2]['Value'], $arrData[2]['Name'], 0);
			?>
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
