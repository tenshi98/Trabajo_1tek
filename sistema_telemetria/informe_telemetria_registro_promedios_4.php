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
$original = "informe_telemetria_registro_promedios_4.php";
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
$search .='&idDetalle='.$_GET['idDetalle'];
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
//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

//guardo las unidades de medida
$Unimed = array();
foreach ($arrUnimed as $sen) {
	$Unimed[$sen['idUniMed']] = ' '.$sen['Nombre'];
}
/**********************************************************************/
//Se traen todos los grupos
$arrGrupo = array();
$arrGrupo = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

//guardo los grupos
$Grupo = array();
foreach ($arrGrupo as $sen) {
	$Grupo[$sen['idGrupo']] = ' '.$sen['Nombre'];
}

/**********************************************************************/
//Funcion para escribir datos
function crear_data($cantsens, $filtro, $idTelemetria, $f_inicio, $f_termino, $desde, $hasta, $dbConn ) {

	$consql = '';
	$subfiltro = '';
	for ($i = 1; $i <= $cantsens; $i++) {
		//$subfiltro .= ' AND telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.' != 999';
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;

		//desde y hasta activo
		if(isset($desde)&&$desde!=''&&isset($hasta)&&$hasta!=''){
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedDesStan_'.$i;
		//solo desde
		}elseif(isset($desde)&&$desde!=''&&(!isset($hasta) OR $hasta=='')){
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//solo hasta
		}elseif(isset($hasta)&&$hasta!=''&&(!isset($desde) OR $desde=='')){
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//ninguno
		}else{
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedDesStan_'.$i;
		}
	}

	/*******************************************************/
	//Se traen todos los registros
	$SIS_query = 'telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria';
	$SIS_where = 'idTabla!=0 '.$filtro.$subfiltro.' GROUP BY telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema';
	$SIS_order = 'telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema ASC';
	$arrTemp = array();
	$arrTemp = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemp');

	return $arrTemp;

}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_telemetria_registro_promedios_4_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<?php
/*******************************************************/
//Inicia variable
$SIS_where  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$SIS_where .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
$SIS_where .= " AND telemetria_listado.id_Sensores=1";                                           //sensores activos
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$SIS_where .= " AND telemetria_listado.idTab=2";//1Tek C
}
//Verifico si se selecciono el equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];
}
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$SIS_join = "";
}else{
	$SIS_join   = " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
	$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
}

/*******************************************************/
//se trae un listado con los equipos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado.cantSensores';
$SIS_order = 'telemetria_listado.idTelemetria ASC';
$arrEquipos = array();
$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<ul class="nav nav-tabs pull-right">
				<?php
					$stemp = 'active';
					$xcounter = 1;
					foreach ($arrEquipos as $equipo) {
						if($xcounter==4){echo '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';}
						echo '<li class="'.$stemp.'"><a href="#tab_'.$equipo['idTelemetria'].'" data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> '.cortar($equipo['NombreEquipo'], 15).'</a></li>';
						$stemp = '';
						$xcounter++;
					}
					if($xcounter>3){echo '</ul></li>';}
				?>
			</ul>
		</header>
		<div class="tab-content">
			<?php
			$stemp = 'active in';
			foreach ($arrEquipos as $equipo) {
				//Llamo a la funcion
				$arrTemporal = crear_data($equipo['cantSensores'], $subf, $equipo['idTelemetria'], $_GET['f_inicio'], $_GET['f_termino'], $_GET['desde'], $_GET['hasta'] , $dbConn); ?>

				<div class="tab-pane fade <?php echo $stemp; ?>" id="tab_<?php echo $equipo['idTelemetria']; $stemp = ''; ?>">
					<div class="wmd-panel">
						<div class="table-responsive">

							<?php
							//Verifico si se imprimen los graficos
							if(isset($_GET['idGraficos'])&&$_GET['idGraficos']==1){
								//variable vacia
								$arrData  = array();
								//recorro los datos del equipo
								foreach ($arrTemporal as $rutas) {
									//por cada sensor hay un grafico
									for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
										//si se pidieron detalles
										if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
											$arrData[$i][1]['Name'] = "'Promedio'";
											$arrData[$i][2]['Name'] = "'Minimo'";
											$arrData[$i][3]['Name'] = "'Maximo'";
										//si no se pidieron detalles
										}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
											$arrData[$i][1]['Name'] = "'Promedio'";
										}

										//si el grupo seleccionado es el mismo de la base
										if($rutas['SensoresGrupo_'.$i]==$_GET['idGrupo']){
											/**************************************/
											//Obtengo Nombre del grupo
											$arrData[$i]['Grupo']        = $Grupo[$rutas['SensoresGrupo_'.$i]];
											//Obtengo la unidad de medida
											$arrData[$i]['Unimed']       = $Unimed[$rutas['SensoresUniMed_'.$i]];
											//Obtengo el nombre del sensor
											$arrData[$i]['SensorNombre'] = $rutas['SensorNombre_'.$i];

											//Verifico la existencia de datos
											if(isset($rutas['MedMin_'.$i])&&$rutas['MedMin_'.$i]!=0&&$rutas['MedMin_'.$i]!=''&&isset($rutas['MedMax_'.$i])&&$rutas['MedMax_'.$i]!=0&&$rutas['MedMax_'.$i]!=''){
												//si se pidieron detalles
												if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
													//Grafico
													if(isset($arrData[$i]['Fecha'])&&$arrData[$i]['Fecha']!=''){$arrData[$i]['Fecha'] .= ",'".Fecha_estandar($rutas['FechaSistema'])."'"; }else{ $arrData[$i]['Fecha'] = "'".Fecha_estandar($rutas['FechaSistema'])."'"; }

													if(isset($arrData[$i][1]['Value'])&&$arrData[$i][1]['Value']!=''){$arrData[$i][1]['Value'] .= ", ".$rutas['MedProm_'.$i];}else{ $arrData[$i][1]['Value'] = $rutas['MedProm_'.$i];}
													if(isset($arrData[$i][2]['Value'])&&$arrData[$i][2]['Value']!=''){$arrData[$i][2]['Value'] .= ", ".$rutas['MedMin_'.$i];  }else{ $arrData[$i][2]['Value'] = $rutas['MedMin_'.$i];}
													if(isset($arrData[$i][3]['Value'])&&$arrData[$i][3]['Value']!=''){$arrData[$i][3]['Value'] .= ", ".$rutas['MedMax_'.$i];  }else{ $arrData[$i][3]['Value'] = $rutas['MedMax_'.$i];}

												//si no se pidieron detalles
												}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
													//Grafico
													if(isset($arrData[$i]['Fecha'])&&$arrData[$i]['Fecha']!=''){$arrData[$i]['Fecha'] .= ",'".Fecha_estandar($rutas['FechaSistema'])."'"; }else{ $arrData[$i]['Fecha'] = "'".Fecha_estandar($rutas['FechaSistema'])."'"; }

													if(isset($arrData[$i][1]['Value'])&&$arrData[$i][1]['Value']!=''){$arrData[$i][1]['Value'] .= ", ".$rutas['MedProm_'.$i];}else{ $arrData[$i][1]['Value'] = $rutas['MedProm_'.$i];}

												}
											}
										}
									}
								}
								/******************************************/
								//Si se ven detalles
								if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
									$xmax = 3;
								//Si no se ven detalles
								}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
									$xmax = 1;
								}
								//por cada sensor hay un grafico
								for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
									//si existen datos
									if(isset($arrData[$i]['Fecha'])&&$arrData[$i]['Fecha']!=''){
										/**************************************/
										//Armo los datos
										$gr_tittle = $arrData[$i]['SensorNombre'].' ('.$arrData[$i]['Grupo'].')';
										$gr_unimed = $arrData[$i]['Unimed'];

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
											$Graphics_xData      .='['.$arrData[$i]['Fecha'].'],';
											//los valores
											$Graphics_yData      .='['.$arrData[$i][$x]['Value'].'],';
											//los nombres
											$Graphics_names      .= $arrData[$i][$x]['Name'].',';
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

										echo GraphLinear_1('graphLinear_'.$i, $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
									}
								}
							}
							?>

							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<tbody role="alert" aria-live="polite" aria-relevant="all">

									<tr class="odd">
										<td></td>
										<?php
										//se recorren los sensores
										for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
											//si el grupo seleccionado es el mismo de la base
											if($arrTemporal[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
												/**************************************/
												//Obtengo Nombre del grupo
												$SensorGrupo  = $Grupo[$arrTemporal[0]['SensoresGrupo_'.$i]];
												//Obtengo el nombre del sensor
												$SensorNombre = $arrTemporal[0]['SensorNombre_'.$i];

												//si se pidieron detalles
												if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
													echo '<th colspan="4"  style="text-align:center">'.$SensorNombre.' ('.$SensorGrupo.')</th>';
												//si no se pidieron detalles
												}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
													echo '<th style="text-align:center">'.$SensorNombre.' ('.$SensorGrupo.')</th>';	
												}
											}
										} ?>
									</tr>
									<tr class="odd">
										<th>Fecha</th>
										<?php
										//se recorren los sensores
										for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
											//si el grupo seleccionado es el mismo de la base
											if($arrTemporal[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
												//si se pidieron detalles
												if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
													echo '<th>Promedio</th><th>Minimo</th><th>Maximo</th><th>Dev. Std.</th>';
												//si no se pidieron detalles
												}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
													echo '<th>Promedio</th>';
												}
											}
										} ?>
									</tr>
									<?php
									//recorro los datos del equipo
									foreach ($arrTemporal as $rutas) {
										echo '<tr class="odd">';
										//imprimo fecha
										echo '<td>'.$rutas['FechaSistema'].'</td>';
										//por cada sensor hay un grafico
										for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
											//si el grupo seleccionado es el mismo de la base
											if($rutas['SensoresGrupo_'.$i]==$_GET['idGrupo']){
												/**************************************/
												//Obtengo la unidad de medida
												$SensorUnimed = $Unimed[$rutas['SensoresUniMed_'.$i]];

												//si se pidieron detalles
												if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
													if(isset($rutas['MedProm_'.$i])&&$rutas['MedProm_'.$i]<99900){        echo '<td>'.Cantidades($rutas['MedProm_'.$i], 2).$SensorUnimed.'</td>';    }else{echo '<td>Sin Datos</td>';}
													if(isset($rutas['MedMin_'.$i])&&$rutas['MedMin_'.$i]<99900){          echo '<td>'.Cantidades($rutas['MedMin_'.$i], 2).$SensorUnimed.'</td>';     }else{echo '<td>Sin Datos</td>';}
													if(isset($rutas['MedMax_'.$i])&&$rutas['MedMax_'.$i]<99900){          echo '<td>'.Cantidades($rutas['MedMax_'.$i], 2).$SensorUnimed.'</td>';     }else{echo '<td>Sin Datos</td>';}
													if(isset($rutas['MedDesStan_'.$i])&&$rutas['MedDesStan_'.$i]<99900){  echo '<td>'.Cantidades($rutas['MedDesStan_'.$i], 2).$SensorUnimed.'</td>';}else{echo '<td>Sin Datos</td>';}
												//si no se pidieron detalles
												}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
													if(isset($rutas['MedProm_'.$i])&&$rutas['MedProm_'.$i]<99900){        echo '<td>'.Cantidades($rutas['MedProm_'.$i], 2).$SensorUnimed.'</td>';    }else{echo '<td>Sin Datos</td>';}
												}
											}
										}
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>
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
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
$z .= " AND telemetria_listado.id_Sensores=1";                                           //sensores activos
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=2";//1Tek C
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
				if(isset($idDetalle)){     $x6  = $idDetalle;    }else{$x6  = '';}
				if(isset($idGraficos)){    $x7  = $idGraficos;   }else{$x7  = '';}
				if(isset($desde)){         $x8  = $desde;        }else{$x8  = '';}
				if(isset($hasta)){         $x9  = $hasta;        }else{$x9  = '';}

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
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 2, $dbConn);
				$Form_Inputs->form_select('Ver Otros Datos','idDetalle', $x6, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_select('Ver Graficos','idGraficos', $x7, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_input_number('Valores Desde','desde', $x8, 1);
				$Form_Inputs->form_input_number('Valores Hasta','hasta', $x9, 1);
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
