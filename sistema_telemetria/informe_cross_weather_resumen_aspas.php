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
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "informe_cross_weather_resumen_aspas.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
//Se aplican los filtros
$idTelemetria = $_GET['idTelemetria'];
/**********************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado.Nombre AS EquipoNombre,
telemetria_listado.cantSensores AS EquipoN_Sensores,
telemetria_listado.SensorActivacionID AS EquipoSensorActivacionID,
telemetria_listado.SensorActivacionValor AS EquipoSensorActivacionValor,
core_sistemas.CrossTech_HeladaTemp AS TempMinima';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = telemetria_listado.idSistema';
$SIS_where = 'telemetria_listado.idTelemetria='.$idTelemetria;
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_listado_tablarelacionada_".$idTelemetria.".idTabla!=0";
if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
	$SIS_where.=" AND telemetria_listado_tablarelacionada_".$idTelemetria.".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}

//numero sensores equipo
$N_Maximo_Sensores = $rowData['EquipoN_Sensores'];
$consql = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
    $consql .= ',telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.' AS SensorValue_'.$i;
}

/**********************************************************/
//se consulta
$SIS_query = '
telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTabla,
telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema,
telemetria_listado_tablarelacionada_'.$idTelemetria.'.HoraSistema'.$consql;
$SIS_join  = '';
$SIS_order = 'telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTabla ASC';
$arrConsulta = array();
$arrConsulta = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrConsulta');

/****************************************************************************/
$arrEvento       = array();
$nevento         = 0;
$s_act           = 0;
$DuracionHelada  = 0;
$Cubrimiento     = 0;
$Funcionamiento  = 0;
$horaRef_1       = '';
$horaRef_2       = '';
$horaRef_3       = '';
//Se busca la temperatura real
foreach($arrConsulta as $temp) {

	//variables
	$Temperatura          = $temp['SensorValue_1'];
	$Temperatura_min      = $rowData['TempMinima'];
	$Temperatura_actMaq   = $temp['SensorValue_'.$rowData['EquipoSensorActivacionID']];
	$Temperatura_actConf  = $rowData['EquipoSensorActivacionValor'];

	/*---------------------Funcionamiento---------------------*/
	//si la hora de referencia esta vacia
	//si esta activo
	if($Temperatura_actMaq>=$Temperatura_actConf){
		if($horaRef_3==''){
			$Funcionamiento  = 0;
			$horaRef_3       = $temp['HoraSistema'];
		//si no esta vacia
		}else{
			$Minutos         = restahoras($horaRef_3,$temp['HoraSistema']);
			$Minutos         = horas2minutos($Minutos);
			$Funcionamiento  = $Funcionamiento + $Minutos;
			$horaRef_3       = $temp['HoraSistema'];
		}
	}

	//si la temperatura es inferior a la temperatura actual
	if(isset($Temperatura)&&$Temperatura<=$Temperatura_min){

		//si esta activo
		if($Temperatura_actMaq>=$Temperatura_actConf){
			//si hay cambio
			if($s_act!=1){$s_act=1;$nevento++;}
			//se guarda estado sensor
			$arrEvento[$nevento]['estadoSensor'] = 1;
			/*---------------------Cubrimiento---------------------*/
			//si la hora de referencia esta vacia
			if($horaRef_2==''){
				$Cubrimiento  = 0;
				$horaRef_2    = $temp['HoraSistema'];
			//si no esta vacia
			}else{
				$Minutos      = restahoras($horaRef_2,$temp['HoraSistema']);
				$Minutos      = horas2minutos($Minutos);
				$Cubrimiento  = $Cubrimiento + $Minutos;
				$horaRef_2    = $temp['HoraSistema'];
			}
		//si esta inactivo
		}else{
			//si hay cambio
			if($s_act!=2){$s_act=2;$nevento++;}
			//se guarda estado sensor
			$arrEvento[$nevento]['estadoSensor'] = 0;
		}
		/*---------------------DuracionHelada---------------------*/
		//si la hora de referencia esta vacia
		if($horaRef_1==''){
			$DuracionHelada  = 0;
			$horaRef_1         = $temp['HoraSistema'];
		//si no esta vacia
		}else{
			$Minutos         = restahoras($horaRef_1,$temp['HoraSistema']);
			$Minutos         = horas2minutos($Minutos);
			$DuracionHelada  = $DuracionHelada + $Minutos;
			$horaRef_1       = $temp['HoraSistema'];
		}

		//se crean variables en caso de no existir
		if(!isset($arrEvento[$nevento]['TempMinima'])){  $arrEvento[$nevento]['TempMinima']  = 1000;}
		if(!isset($arrEvento[$nevento]['TempMaxima'])){  $arrEvento[$nevento]['TempMaxima']  = -1000;}

		if(!isset($arrEvento[$nevento]['FechaInicio'])){ $arrEvento[$nevento]['FechaInicio'] = $temp['FechaSistema'];}
		if(!isset($arrEvento[$nevento]['HoraInicio'])){  $arrEvento[$nevento]['HoraInicio']  = $temp['HoraSistema'];}

		$arrEvento[$nevento]['FechaTermino'] = $temp['FechaSistema'];
		$arrEvento[$nevento]['HoraTermino']  = $temp['HoraSistema'];

		//Guardo la temperatura Minima
		if(isset($Temperatura)&&$Temperatura<$arrEvento[$nevento]['TempMinima']){
			$arrEvento[$nevento]['TempMinima'] = $Temperatura;
		}
		//Guardo la temperatura Maxima
		if(isset($Temperatura)&&$Temperatura>$arrEvento[$nevento]['TempMaxima']){
			$arrEvento[$nevento]['TempMaxima'] = $Temperatura;
		}

	}else{
		$nevento++;
	}

}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Tiempo Temperatura Bajo <?php echo $rowData['TempMinima']; ?> C°</h3>
				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<span><?php echo cantidades($DuracionHelada/60, 2); ?></span>
						Horas
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Cubrimiento Aspa/Helada</h3>
				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<span><?php echo cantidades($Cubrimiento/60, 2); ?></span>
						Horas
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Funcionamiento Total Aspa</h3>
				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<span><?php echo cantidades($Funcionamiento/60, 2); ?></span>
						Horas
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5> Graficos</h5>

		</header>
		<div class="table-responsive">
			<?php
			$Temp_1     = '';
			$arrData    = array();
			foreach ($arrConsulta as $temp) {
				//Que el valor medido sea distinto de 99900
				if(isset($temp['SensorValue_1'])&&$temp['SensorValue_1']<99900){
					//se arma cadena
					$Temp_1 .= "'".Fecha_estandar($temp['FechaSistema'])." - ".$temp['HoraSistema']."',";
					if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){$arrData[1]['Value'] .= ", ".$temp['SensorValue_1'];    }else{ $arrData[1]['Value'] = $temp['SensorValue_1'];}
					if(isset($arrData[2]['Value'])&&$arrData[2]['Value']!=''){$arrData[2]['Value'] .= ", ".$temp['SensorValue_11'];   }else{ $arrData[2]['Value'] = $temp['SensorValue_11'];}

				}
			}
			$arrData[1]['Name'] = "'Temperatura (Celsius)'";
			$arrData[2]['Name'] = "'Funcionamiento (On-Off)'";

			$gr_tittle = 'Informe Sensores';
			echo GraphLinear_3('graphLinear_1', $gr_tittle, 'Fecha', 'Temperatura', 'Funcionamiento', $Temp_1, $arrData[1]['Value'], $arrData[1]['Name'], $Temp_1, $arrData[2]['Value'], $arrData[2]['Name'], 0);

			?>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p><span class="label label-default" style="background-color:#4285F4;">+</span> Temperatura (Grados Celsius)</p>
				<p><span class="label label-default" style="background-color:#DB4437;">+</span> Funcionamiento (1:On - 0:Off)</p>

			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo 'Detalle Helada (Bajo '.$rowData['TempMinima'].'°C)'; ?></h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Inicio</th>
						<th>Termino</th>
						<th>Temperatura Minima</th>
						<th>Temperatura Maxima</th>
						<th>Funcionamiento</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrEvento as $key => $eve){ ?>
						<tr class="odd">
							<td><?php echo $eve['HoraInicio'].' - '.fecha_estandar($eve['FechaInicio']); ?></td>
							<td><?php echo $eve['HoraTermino'].' - '.fecha_estandar($eve['FechaTermino']); ?></td>
							<td><?php echo Cantidades($eve['TempMinima'], 2).'°C'; ?></td>
							<td><?php echo Cantidades($eve['TempMaxima'], 2).'°C'; ?></td>
							<td><?php if($eve['estadoSensor']==1){echo 'On';}elseif($eve['estadoSensor']==0){echo 'Off';}$eve['estadoSensor']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=4";//Agro-Weather
} ?>
<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($f_termino)){     $x2  = $f_termino;    }else{$x2  = '';}
				if(isset($idTelemetria)){  $x3  = $idTelemetria; }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x3, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x3, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				} ?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
