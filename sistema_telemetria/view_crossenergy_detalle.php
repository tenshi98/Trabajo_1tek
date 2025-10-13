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
/*                                          Modulo de identificacion del documento                                                */
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
//Cargamos la ubicacion original
$original = "view_crossenergy_estado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$X_Puntero;
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

/**************************************************************/
//variables
//Grupo Sensores
$idGrupoVmonofasico      = 87;
$idGrupoVTrifasico       = 106;
$idGrupoPotencia         = 99;
$idGrupoConsumoMesHabil  = 99;
$idGrupoConsumoMesCurso  = 99;

//Para Demanda
$Demanda_FechaInicio    = restarDias(fecha_actual(),30);
$Demanda_HoraInicio     = hora_actual();
$Demanda_FechaTermino   = fecha_actual();
$Demanda_HoraTermino    = hora_actual();

//numero sensores equipo
$N_Maximo_Sensores = 20;
$subquery_1 = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores';
$subquery_2 = 'idTabla';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery_1 .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$subquery_2 .= ',SUM(Sensor_'.$i.') AS Med_'.$i;
}
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_grupo`       ON telemetria_listado_sensores_grupo.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';

//Obtengo los datos
$rowData            = db_select_data (false, $subquery_1, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria ='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');
$n_permisos         = db_select_data (false, 'idOpcionesGen_6', 'core_sistemas','', 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

$SIS_query = 'Nombre,CrossEnergy_PeriodoInicio, CrossEnergy_PeriodoTermino, CrossEnergy_HorarioInicio, CrossEnergy_HorarioTermino';
$SIS_join  = '';
$SIS_where = 'idSistema ='.$_SESSION['usuario']['basic_data']['idSistema'];
$rowSistema = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

//Temporales

$Subquery    = '';
$Subquery_2  = '';
//recorro los sensores
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	//Si el sensor esta activo
	if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
		//para la subconsulta
		if($rowData['SensoresGrupo_'.$i]==$idGrupoPotencia){
			$Subquery .= ',Sensor_'.$i;
			//si viene vacio
			if(isset($Subquery_2)&&$Subquery_2!=''){
				$Subquery_2 .= ' + Sensor_'.$i;
			}else{
				$Subquery_2 .= ', SUM(Sensor_'.$i;
			}
		}
	}
}
//cierro subquery
$Subquery_2 .= ') AS Total';
//Se hace consulta de los graficos
$arrGraficos = array();
$arrGraficos = db_select_array (false, 'FechaSistema, HoraSistema'.$Subquery.$Subquery_2, 'telemetria_listado_crossenergy_hora', '', 'idTelemetria = '.$X_Puntero.' AND (FechaSistema BETWEEN "'.$rowSistema['CrossEnergy_PeriodoInicio'].'" AND "'.$rowSistema['CrossEnergy_PeriodoTermino'].'") AND HoraSistema > "'.$rowSistema['CrossEnergy_HorarioInicio'].'" AND HoraSistema < "'.$rowSistema['CrossEnergy_HorarioTermino'].'" GROUP BY TimeStamp', 'Total DESC LIMIT 52', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGraficos');

$arrDemanda = array();
$arrDemanda = db_select_array (false, 'FechaSistema, HoraSistema'.$Subquery.$Subquery_2, 'telemetria_listado_crossenergy_hora', '', 'idTelemetria = '.$X_Puntero.' AND (TimeStamp BETWEEN "'.$Demanda_FechaInicio.' '.$Demanda_HoraInicio .'" AND "'.$Demanda_FechaTermino.' '.$Demanda_HoraTermino.'")  GROUP BY TimeStamp', 'Total DESC LIMIT 2', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDemanda');

//Ordenamiento de grafico
asort($arrGraficos);

if(isset($n_permisos['idOpcionesGen_6'])&&$n_permisos['idOpcionesGen_6']!=0){
	$x_seg = $n_permisos['idOpcionesGen_6'] * 1000;
}else{
	$x_seg = 300000;//5 minutos
}
$x_seg = 300000;//5 minutos


/****************************************************************/
//Variables
$Temp_1      = '';
$Temp_1b     = '';
$arrData_1   = array();
$Temp_2      = '';
$arrData_2   = array();

//se arman datos
//Si existen
if(isset($arrGraficos)&&$arrGraficos!=false && !empty($arrGraficos) && $arrGraficos!=''){

	/******************************************************/
	//recorro
	$counterz = 1;
	foreach ($arrGraficos as $data) {

		//Variables
		$Temp_1 .= "'".$data['FechaSistema']." ".$data['HoraSistema']."',";
		$Temp_1b .= "'".$counterz."',";
		//verifico si existe
		if(isset($arrData_1['Value'])&&$arrData_1['Value']!=''){
			$arrData_1['Value'] .= ", ".floatval(number_format($data['Total'], 2, '.', ''));
		//si no lo crea
		}else{
			$arrData_1['Value'] = floatval(number_format($data['Total'], 2, '.', ''));
		}
		$counterz++;
	}

	//nombres
	$arrData_1['Name'] = "'Potencia hora punta'";

	//variables
	$Graphics_xData       = 'var xData = [['.$Temp_1b.'],];';
	$Graphics_yData       = 'var yData = [['.$arrData_1['Value'].'],];';
	$Graphics_names       = 'var names = ['.$arrData_1['Name'].',];';
	$Graphics_info        = "var grf_info = [[".$Temp_1."],];";
	$Graphics_markerColor = "var markerColor = [''];";
	$Graphics_markerLine  = "var markerLine = [''];";

	/******************************************************/
	//recorro
	foreach ($arrDemanda as $data) {

		//Variables
		$Temp_2 .= "'".$data['FechaSistema']." ".$data['HoraSistema']."',";
		//verifico si existe
		if(isset($arrData_2['Value'])&&$arrData_2['Value']!=''){
			$arrData_2['Value'] .= ", ".floatval(number_format($data['Total'], 2, '.', ''));
		//si no lo crea
		}else{
			$arrData_2['Value'] = floatval(number_format($data['Total'], 2, '.', ''));
		}

	}

	//nombres
	$arrData_2['Name'] = "'Demanda de suministro'";

	//variables
	$Graphics_xData_2       = 'var xData = [['.$Temp_2.'],];';
	$Graphics_yData_2       = 'var yData = [['.$arrData_2['Value'].'],];';
	$Graphics_names_2       = 'var names = ['.$arrData_2['Name'].',];';
	$Graphics_info_2        = "var grf_info = [''];";
	$Graphics_markerColor_2 = "var markerColor = [''];";
	$Graphics_markerLine_2  = "var markerLine = [''];";
			
				
	
?>
<script>
	window.setTimeout(function () {
	  window.location.reload();
	}, <?php echo $x_seg; ?>);
</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Estado del Equipo <?php echo $rowData['Nombre'].' (Hora Refresco: '.hora_actual().')'; ?></h5>
		</header>
        <div class="tab-content">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php
							$Titulo = 'Potencia hora punta (Periodo: '.$rowSistema['CrossEnergy_PeriodoInicio'].' al '.$rowSistema['CrossEnergy_PeriodoTermino'].' / Horario: '.$rowSistema['CrossEnergy_HorarioInicio'].'-'.$rowSistema['CrossEnergy_HorarioTermino'].')';
							echo GraphBarr_1('graphBarra_1', $Titulo, 'Fecha', 'Amperaje', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,1, 0); 
	
						?>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php
							$Titulo = 'Demanda de suministro (Periodo: '.$Demanda_FechaInicio.' al '.$Demanda_FechaTermino.' / Horario: '.$Demanda_HoraInicio.'-'.$Demanda_HoraTermino.')';
							echo GraphBarr_1('graphBarra_2', $Titulo, 'Fecha', 'Amperaje', $Graphics_xData_2, $Graphics_yData_2, $Graphics_names_2, $Graphics_info_2, $Graphics_markerColor_2, $Graphics_markerLine_2,1, 0); 
						?>
					</div>
				</div>

			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php
//Si no hay datos
}else{
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
		alert_post_data(4,2,2,0, 'No existen datos');
	echo '</div>';
}

?>

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
