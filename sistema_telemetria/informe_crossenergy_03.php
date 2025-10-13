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
$original = "informe_crossenergy_03.php";
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

//filtro
$SIS_where = 'idTelemetria = '.$_GET['idTelemetria'].' AND (FechaSistema BETWEEN "'.$_GET['f_inicio'].'" AND "'.$_GET['f_termino'].'") AND HoraSistema > "'.$_GET['h_inicio'].'" AND HoraSistema < "'.$_GET['h_termino'].'" GROUP BY TimeStamp';

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_crossenergy_hora', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{

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
	$rowData = db_select_data (false, $subquery_1, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria ='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Temporales
	$Subquery    = '';
	$Subquery_2  = '';
	//recorro los sensores
	for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
		//Si el sensor esta activo
		if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
			//para la subconsulta
			if($rowData['SensoresGrupo_'.$i]==$_GET['idGrupo']){
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

	/*****************************************/
	$SIS_query = 'FechaSistema, HoraSistema'.$Subquery.$Subquery_2;
	$SIS_join  = '';
	$SIS_where = 'idTelemetria = '.$_GET['idTelemetria'].' AND (FechaSistema BETWEEN "'.$_GET['f_inicio'].'" AND "'.$_GET['f_termino'].'") AND HoraSistema > "'.$_GET['h_inicio'].'" AND HoraSistema < "'.$_GET['h_termino'].'" GROUP BY TimeStamp';
	$SIS_order = 'Total DESC LIMIT 52';
	$arrGraficos = array();
	$arrGraficos = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGraficos');

	//Ordenamiento de grafico
	asort($arrGraficos);

	/****************************************************************/
	//Variables
	$Temp_1      = '';
	$Temp_1b     = '';
	$arrData_1   = array();

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

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Estado del Equipo <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="table-responsive" id="grf">
				<?php
					$Titulo = 'Potencia hora punta (Periodo: '.$_GET['f_inicio'].' al '.$_GET['f_termino'].' / Horario: '.$_GET['h_inicio'].'-'.$_GET['h_termino'].')';
					echo GraphBarr_1('graphBarra_1', $Titulo, 'Fecha', 'kW', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,1, 0);
				?>			
			</div>
		</div>
	</div>

	<?php
}

?>

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
	$z .= " AND telemetria_listado.idTab=9";//Power-Energy
}

?>

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
				if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}
				if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = '';}
				if(isset($idGrafico)){     $x8  = $idGrafico;    }else{$x8  = '';}
				//Si es redireccionado desde otra pagina con datos precargados
				if(isset($_GET['view'])&&$_GET['view']!='') { $x5  = $_GET['view'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 2, $dbConn);
				?>

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
