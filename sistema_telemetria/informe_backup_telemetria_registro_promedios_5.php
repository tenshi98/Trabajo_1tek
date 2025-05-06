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
$original = "informe_backup_telemetria_registro_promedios_5.php";
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

/**********************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$subf='';
$search  ='&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search .='&f_inicio='.$_GET['f_inicio'];
$search .='&f_termino='.$_GET['f_termino'];
$search .='&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
$search .='&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
$search .='&desde='.$_GET['desde'];
$search .='&hasta='.$_GET['hasta'];
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){$search .='&idTelemetria='.$_GET['idTelemetria'];}
if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){   $search .='&idGrupo='.$_GET['idGrupo'];}

//Datos opcionales
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$subf.=" AND (TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
	$search.="&h_inicio=".$_GET['h_inicio']."&h_termino=".$_GET['h_termino'];
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$subf.=" AND (FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}

/**********************************************************************/
//Funcion para escribir datos
function crear_data($cantsens, $filtro, $idTelemetria, $f_inicio, $f_termino, $desde, $hasta, $dbConn ) {

	$consql    = '';
	$subfiltro = '';
	for ($i = 1; $i <= $cantsens; $i++) {
		//$subfiltro .= ' AND backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.' != 999';
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		//$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;

		//desde y hasta activo
		if(isset($desde)&&$desde!=''&&isset($hasta)&&$hasta!=''){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedDesStan_'.$i;
		//solo desde
		}elseif(isset($desde)&&$desde!=''&&(!isset($hasta) OR $hasta=='')){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//solo hasta
		}elseif(isset($hasta)&&$hasta!=''&&(!isset($desde) OR $desde=='')){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//ninguno
		}else{
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedDesStan_'.$i;
		}
	}

	/*******************************************************/
	//se consulta
	$SIS_query = 'backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria';
	$SIS_where = 'idTabla!=0 '.$filtro.$subfiltro.' GROUP BY backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema';
	$SIS_order = 'backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema ASC LIMIT 10000';
	$arrRutas = array();
	$arrRutas = db_select_array (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRutas');

	return $arrRutas;

}

/*******************************************************/
//Consulta por la cantidad de sensores
$SIS_query = 'cantSensores, Nombre AS NombreEquipo';
$SIS_where = 'idTelemetria='.$_GET['idTelemetria'];
$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

/*******************************************************/
//se consulta
//Variable temporal
$arrTemporal = array();
//Llamo a la funcion
$arrTemporal = crear_data($rowEquipo['cantSensores'], $subf, $_GET['idTelemetria'], $_GET['f_inicio'], $_GET['f_termino'], $_GET['desde'], $_GET['hasta'] , $dbConn);

/*******************************************************/
//Se trae el dato del grupo
$rowGrupo = db_select_data (false, 'Nombre', 'telemetria_listado_grupos', '', 'idGrupo='.$_GET['idGrupo'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowGrupo');

/****************************************************************/
//Variables
$m_table        = '';
$m_table_title  = '';
$Temp_1         = '';
$arrData        = array();
$count          = 0;

/****************************************************************/
//titulo de la tabla
$m_table_title  .= '<th>Temperatura</th>';
$m_table_title  .= '<th>Humedad</th>';
$arrData[1]['Name'] = "'Temperatura'";
$arrData[2]['Name'] = "'Humedad'";

//se arman datos
foreach ($arrTemporal as $fac) {

	$Temperatura       = 0;
	$Temperatura_N     = 0;
	$Humedad           = 0;
	$Humedad_N         = 0;

	for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
		if($fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
			//Que el valor medido sea distinto de 999
			if(isset($fac['MedProm_'.$x])&&$fac['MedProm_'.$x]<99900){
				//Si es humedad
				if($fac['SensoresUniMed_'.$x]==2){$Humedad     = $Humedad + $fac['MedProm_'.$x];$Humedad_N++;}
				//Si es temperatura
				if($fac['SensoresUniMed_'.$x]==3){$Temperatura = $Temperatura + $fac['MedProm_'.$x];$Temperatura_N++;}
			}
		}
	}

	if($Temperatura_N!=0){  $New_Temperatura = $Temperatura/$Temperatura_N; }else{$New_Temperatura = 0;}
	if($Humedad_N!=0){      $New_Humedad     = $Humedad/$Humedad_N;         }else{$New_Humedad     = 0;}

	//omite la linea mientras alguna de las variables contenga datos
	if($Temperatura_N!=0 OR $Humedad_N!=0){
		$Temp_1  .= "'".Fecha_estandar($fac['FechaSistema'])."',";
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
		$m_table .= '<tr class="odd"><td>'.fecha_estandar($fac['FechaSistema']).'</td>';
		$m_table .= '<td>'.cantidades($New_Temperatura, 2).' °C</td>';
		$m_table .= '<td>'.cantidades($New_Humedad, 2).' %</td>';
		$m_table .= '</tr>';
	}

	//contador
	$count++;
}

//si hay mas de 9000 registros
if(isset($count)&&$count>9000){
	//Se escribe el dato
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
		alert_post_data(3,1,1,0, $Alert_Text);
	echo '</div>';
}

?>

<style>
#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
</style>
<div id="loading"></div>
<script>
//oculto el loader
document.getElementById("loading").style.display = "none";
</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Informe Promedio Camara', $_SESSION['usuario']['basic_data']['RazonSocial'], 'Informe grupo '.$rowGrupo['Nombre'].' del equipo '.$rowEquipo['NombreEquipo']); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
		<a target="new" href="<?php echo 'informe_backup_telemetria_registro_promedios_5_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>

		<?php if(isset($_GET['idGraficos'])&&$_GET['idGraficos']==1){ ?>
			<input class="btn btn-sm btn-metis-3 pull-right margin_width fa-input" type="button" onclick="Export()" value="&#xf1c1; Exportar a PDF"/>
		<?php }else{ ?>
			<a target="new" href="<?php echo 'informe_backup_telemetria_registro_promedios_5_to_pdf.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
		<?php } ?>

	</div>
</div>
<div class="clearfix"></div>

<?php
//Verifico si se imprimen los graficos
if(isset($_GET['idGraficos'])&&$_GET['idGraficos']==1){ ?>
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

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: none;">

		<form method="post" id="make_pdf" action="informe_backup_telemetria_registro_promedios_5_to_pdf.php">
			<input type="hidden" name="img_adj" id="img_adj" />

			<input type="hidden" name="idSistema"     id="idSistema"    value="<?php echo $_SESSION['usuario']['basic_data']['idSistema']; ?>" />
			<input type="hidden" name="f_inicio"      id="f_inicio"     value="<?php echo $_GET['f_inicio']; ?>" />
			<input type="hidden" name="f_termino"     id="f_termino"    value="<?php echo $_GET['f_termino']; ?>" />
			<input type="hidden" name="idTelemetria"  id="idTelemetria" value="<?php echo $_GET['idTelemetria']; ?>" />
			<input type="hidden" name="idGrupo"       id="idGrupo"      value="<?php echo $_GET['idGrupo']; ?>" />

			<?php if(isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''){ ?>       <input type="hidden" name="h_inicio"     id="h_inicio"    value="<?php echo $_GET['h_inicio']; ?>" /><?php } ?>
			<?php if(isset($_GET['h_termino'])&&$_GET['h_termino']!=''){ ?>     <input type="hidden" name="h_termino"    id="h_termino"   value="<?php echo $_GET['h_termino']; ?>" /><?php } ?>
			<?php if(isset($_GET['desde'])&&$_GET['desde']!=''){ ?>             <input type="hidden" name="desde"        id="desde"       value="<?php echo $_GET['desde']; ?>" /><?php } ?>
			<?php if(isset($_GET['hasta'])&&$_GET['hasta']!=''){ ?>             <input type="hidden" name="hasta"        id="hasta"       value="<?php echo $_GET['hasta']; ?>" /><?php } ?>

			<button type="button" name="create_pdf" id="create_pdf" class="btn btn-danger btn-xs">Hacer PDF</button>

		</form>

		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/dom-to-image.min.js"></script>
		<script>
			var node = document.getElementById('graphLinear_1');

			function sendDatatoSRV(img) {
				$('#img_adj').val(img);
				//$('#img_adj').val($('#img-out').html());
				$('#make_pdf').submit();
				//oculto el loader
				document.getElementById("loading").style.display = "none";
			}
			function Export() {
				//muestro el loader
				document.getElementById("loading").style.display = "block";
				//Exporto
				setTimeout(
					function(){
						domtoimage.toPng(node)
						.then(function (dataUrl) {
							var img = new Image();
							img.src = dataUrl;
							//document.getElementById('img-out').appendChild(img);
							//alert(img.src);
							sendDatatoSRV(img.src);
						})
						.catch(function (error) {
							console.error('oops, something went wrong!', error);
							Swal.fire({icon: 'error',title: 'Oops...',text: 'No se puede exportar!'});
							document.getElementById("loading").style.display = "none";
						});
					}
				, 3000);
			}

		</script>
	</div>
<?php } ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Informe equipo <?php echo $rowEquipo['NombreEquipo']; if(isset($rowGrupo['Nombre'])&&$rowGrupo['Nombre']!=''){echo ' del grupo '.$rowGrupo['Nombre'];} ?></h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd">
						<th>Fecha</th>
						<?php echo $m_table_title; ?>
					</tr>
					<?php echo $m_table; ?>
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
//filtros
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=1";                                                //Geolocalizacion activa
$z .= " AND telemetria_listado.id_Sensores=1";                                           //sensores activos
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=3";//CrossTrack
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
				if(isset($idGraficos)){    $x6  = $idGraficos;   }else{$x6  = '';}
				if(isset($desde)){         $x7  = $desde;        }else{$x7  = '';}
				if(isset($hasta)){         $x8  = $hasta;        }else{$x8  = '';}

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
				$Form_Inputs->form_select('Ver Graficos','idGraficos', $x6, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_input_number('Valores Desde','desde', $x7, 1);
				$Form_Inputs->form_input_number('Valores Hasta','hasta', $x8, 1);
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
