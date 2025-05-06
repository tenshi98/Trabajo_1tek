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
$original = "informe_backup_telemetria_registro_promedios_7.php";
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){

//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = '';
$search    = '?idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search   .= '&sensorn='.$_GET['sensorn'].'&idTelemetria='.$_GET['idTelemetria'].'&f_inicio='.$_GET['f_inicio'].'&f_termino='.$_GET['f_termino'];
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .= "(TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
	$search    .= "&h_inicio=".$_GET['h_inicio']."&h_termino=".$_GET['h_termino'];
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .= "(FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	/****************************************/
	//consulto
	$SIS_query = '
	telemetria_listado.Nombre AS NombreEquipo,
	telemetria_listado_sensores_nombre.SensoresNombre_'.$_GET['sensorn'].' AS SensorNombre,

	backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTabla,
	backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema,
	backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema,
	backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$_GET['sensorn'].' AS SensorValue,
	telemetria_listado_unidad_medida.Nombre AS Unimed';
	$SIS_join  = '
	LEFT JOIN `telemetria_listado`                   ON telemetria_listado.idTelemetria                   = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_nombre`   ON telemetria_listado_sensores_nombre.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`   ON telemetria_listado_sensores_unimed.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_unidad_medida`     ON telemetria_listado_unidad_medida.idUniMed         = telemetria_listado_sensores_unimed.SensoresUniMed_'.$_GET['sensorn'];
	$SIS_order = 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema ASC, backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

	/****************************************************************/
	//Variables
	$m_table        = '';
	$m_table_title  = '';
	$Temp_1         = '';
	$arrData        = array();
	$count          = 0;

	/****************************************************************/
	//titulo de la tabla
	$m_table_title  .= '<th>Medicion</th>';
	$arrData[1]['Name'] = "'Medicion'";

	//se arman datos
	foreach ($arrEquipos as $fac) {
		//que valor sea distinto de error
		if(isset($fac['SensorValue'])&&$fac['SensorValue']<99900){

				//Grafico
			$Temp_1  .= "'".Fecha_estandar($fac['FechaSistema'])." ".$fac['HoraSistema']."',";
			if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){$arrData[1]['Value'] .= ", ".$fac['SensorValue'];}else{ $arrData[1]['Value'] = $fac['SensorValue'];}

			//Tabla
			$m_table .= '<tr class="odd">';
			$m_table .= '<td>'.Fecha_estandar($fac['FechaSistema']).'</td>';
			$m_table .= '<td>'.$fac['HoraSistema'].'</td>';
			$m_table .= '<td>'.Cantidades($fac['SensorValue'], 2).' '.$fac['Unimed'].'</td>';
			$m_table .= '</tr>';

			//contador
			$count++;
		}
	}

	/******************************************/
	$xmax = 1;

	//variables
	$Graphics_xData       = 'var xData = [';
	$Graphics_yData       = 'var yData = [';
	$Graphics_names       = 'var names = [';
	$Graphics_types       = 'var types = [';
	$Graphics_texts       = 'var texts = [';
	$Graphics_lineColors  = 'var lineColors = [';
	$Graphics_lineDash    = 'var lineDash = [';
	$Graphics_lineWidth   = 'var lineWidth = [';
	//Se crean los datos
	for ($x = 1; $x <= $xmax; $x++) {
		//las fechas
		$Graphics_xData      .='['.$Temp_1.'],';
		//los valores
		$Graphics_yData      .='['.$arrData[$x]['Value'].'],';
		//los nombres
		$Graphics_names      .= $arrData[$x]['Name'].',';
		//los tipos
		$Graphics_types      .= "'',";
		//si lleva texto en las burbujas
		$Graphics_texts      .= "[],";
		//los colores de linea
		$Graphics_lineColors .= "'',";
		//los tipos de linea
		$Graphics_lineDash   .= "'',";
		//los anchos de la linea
		$Graphics_lineWidth  .= "'',";
	}
	$Graphics_xData      .= '];';
	$Graphics_yData      .= '];';
	$Graphics_names      .= '];';
	$Graphics_types      .= '];';
	$Graphics_texts      .= '];';
	$Graphics_lineColors .= '];';
	$Graphics_lineDash   .= '];';
	$Graphics_lineWidth  .= '];';


	//si hay mas de 9000 registros
	if(isset($count)&&$count>9000){
		//Se escribe el dato
		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
			alert_post_data(3,1,1,0, $Alert_Text);
		echo '</div>';
	} ?>

	<style>
	#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
	</style>
	<div id="loading"></div>
	<script>
	//oculto el loader
	document.getElementById("loading").style.display = "none";
	</script>

	<?php if(isset($_GET['idGrafico'])&&$_GET['idGrafico']==1){  ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Graficos del Sensor N° <?php echo $_GET['sensorn'].' '.$arrEquipos[0]['SensorNombre'].' de '.$rowEquipo['NombreEquipo']; ?></h5>
				</header>
				<div class="table-responsive">
					<?php
					$gr_tittle = 'Informe Sensor N° '.$_GET['sensorn'].' '.$arrEquipos[0]['SensorNombre'];
					$gr_unimed = $arrEquipos[0]['Unimed'];
					echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
					?>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Informe Sensor N° <?php echo $_GET['sensorn'].' '.$arrEquipos[0]['SensorNombre'].' de '.$rowEquipo['NombreEquipo']; ?></h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Fecha</th>
							<th>Hora</th>
							<?php echo $m_table_title; ?>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php echo $m_table; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<?php } ?>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//filtros
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
$z .= " AND telemetria_listado.id_Sensores=1";                                           //sensores activos
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=6";//Power-Crane
}
//Se escribe el dato
$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
alert_post_data(2,1,1,0, $Alert_Text);

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
				if(isset($sensorn)){       $x6  = $sensorn;      }else{$x6  = '';}
				if(isset($idGrafico)){     $x8  = $idGrafico;    }else{$x8  = '';}
				if(isset($desde)){         $x9  = $desde;        }else{$x9  = '';}
				if(isset($hasta)){         $x10 = $hasta;        }else{$x10 = '';}

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
				$Form_Inputs->form_select_tel_group_sens('Sensor','sensorn', 'idTelemetria', 'form1', 2, $dbConn);
				$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x8, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_input_number('Valores Desde','desde', $x9, 1);
				$Form_Inputs->form_input_number('Valores Hasta','hasta', $x10, 1);

				//Si es redireccionado desde otra pagina con datos precargados
				if(isset($_GET['view'])&&$_GET['view']!='') { echo '<script>$(document).ready(function(){cambia_idTelemetria();});</script>';}
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
