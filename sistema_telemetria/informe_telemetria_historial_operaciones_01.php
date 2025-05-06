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
$original = "informe_telemetria_historial_operaciones_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
$location .= "?submit_filter=Filtrar";
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){      $location .= "&idTelemetria=".$_GET['idTelemetria'];      $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$search .="&fecha_desde=".$_GET['fecha_desde'];
	$search .="&fecha_hasta=".$_GET['fecha_hasta'];
}
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
/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idTabla!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['fecha_desde'])&&$_GET['fecha_desde']!=''&&isset($_GET['fecha_hasta'])&&$_GET['fecha_hasta']!=''&&isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''&&isset($_GET['h_termino'])&&$_GET['h_termino']!=''){
	$SIS_where.=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['fecha_desde']." ".$_GET['h_inicio']."' AND '".$_GET['fecha_hasta']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$SIS_where.=" AND telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['fecha_desde']."' AND '".$_GET['fecha_hasta']."'";
}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{

	/**********************************************************/
	//Obtengo los sensores a utilizar
	$arrOperaciones = array();
	$arrOperaciones = db_select_array (false, 'telemetria_listado_definicion_operacional.N_Sensor, telemetria_listado_definicion_operacional.ValorActivo, telemetria_listado_definicion_operacional.RangoMinimo, telemetria_listado_definicion_operacional.RangoMaximo, core_telemetria_funciones.Nombre AS Funcion, telemetria_listado_definicion_operacional.idFuncion', 'telemetria_listado_definicion_operacional', 'LEFT JOIN `core_telemetria_funciones` ON core_telemetria_funciones.idFuncion = telemetria_listado_definicion_operacional.idFuncion', 'telemetria_listado_definicion_operacional.idTelemetria ='.$_GET['idTelemetria'], 'telemetria_listado_definicion_operacional.N_Sensor ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSensores');

	/**********************************************************/
	//obtengo el nombre de los sensores
	$subquery = '';
	foreach ($arrOperaciones as $oper) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$oper['N_Sensor'];
	}
	//Consultas
	$SIS_query = '
	telemetria_listado.Nombre,
	telemetria_listado.SensorActivacionID,
	telemetria_listado.SensorActivacionValor'.$subquery;
	$SIS_join  = 'LEFT JOIN `telemetria_listado_sensores_nombre` ON telemetria_listado_sensores_nombre.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['idTelemetria'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//verifico el sensor de activacion este configurado
	if(isset($rowData['SensorActivacionID'])&&$rowData['SensorActivacionID']!=''&&$rowData['SensorActivacionID']!=0){
		$SIS_where.=" AND Sensor_".$rowData['SensorActivacionID']." = '".$rowData['SensorActivacionValor']."'";
	}else{
		//Se escribe el dato
		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$Alert_Text  = 'El sensor de activacion no esta configurado, por lo tanto se estan mostrando todas las mediciones.';
			alert_post_data(2,1,1,0, $Alert_Text);
		echo '</div>';
	}
	/**********************************************************/
	// Se trae un listado con todos los datos separados por tractores
	$SIS_query = 'FechaSistema,HoraSistema';
	foreach ($arrOperaciones as $oper) {
		$SIS_query .= ',Sensor_'.$oper['N_Sensor'];
	}
	$SIS_where = 'idTabla != 0';
	$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
	$arrMediciones = array();
	$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');

	?>

	<style>

		.my-custom-scrollbar {position: relative;height: 550px;overflow: auto;}
		.table-wrapper-scroll-y {display: block;}

		#crane{height:220px;left:50%;margin-left:-75px;margin-top:110px;position:absolute;top:0%;transform:scale(1);width:150px}
		#peak {height: 0px;}
		#peak #first{border:3px solid #33936c;display:block;height:18px;left:7px;position:absolute;top:-16px;width:18px}
		#peak #first::before{background:linear-gradient(to right,#268760 0,#227F59 50%,#227251 100%);content:"";display:block;height:20px;left:5px;position:relative;top:-4px;transform:rotate(45deg);width:3px;z-index:-1}
		#peak #first::after{background:linear-gradient(to right,#268760 0,#227F59 50%,#227251 100%);content:"";display:block;height:20px;left:4px;position:relative;top:-24px;transform:rotate(135deg);width:3px;z-index:-1}
		#peak #second{background-color:#33936c;height:26px;left:13px;position:absolute;top:-42px;width:6px}
		#peak #second::before{background-color:#33936c;content:"";display:block;height:16px;left:-4px;position:absolute;top:10px;width:14px;border-left:2px solid #33936c;border-right:2px solid #327C5E;border-style:none solid;border-width:medium 2px}
		#peak #light{background-color:red;border-radius:50% 50% 0 0;height:4px;left:14px;position:absolute;top:-46px;width:4px;animation:lightFlash 2s linear infinite}
		#peak span{background-color:#666;display:block;height:2px;left:15px;position:relative;top:-39px;width:2px;margin-bottom:3px}
		#peak #line1{background-color:#000;height:1px;left:19px;position:absolute;top:-42px;transform:rotate(6deg);transform-origin:left center 0;width:185px}
		#peak #line2{background-color:#000;height:1px;left:12px;position:absolute;top:-42px;transform:rotate(155deg);transform-origin:left center 0;width:93px;z-index:-1}
		#arm {width: 260px;}
		#arm #connector1{background-color:#33936c;display:block;height:6px;left:35px;position:absolute;top:-11px;transform:skewX(-45deg);width:10px;border-left:2px solid #327C5E}
		#arm #connector2{border-color:transparent transparent #33936c;border-style:solid;border-width:0 0 17px 17px;display:block;height:0;left:38px;position:absolute;top:-24px;width:0}
		#arm section{border:3px solid #33936c;float:left;height:16px;left:58px;margin-left:-3px;position:relative;top:-23px;width:16px}
		#arm section::after{background:linear-gradient(to right,#268760 0,#227F59 50%,#227251 100%) repeat scroll 0 0 transparent;content:"";display:block;height:16px;left:4px;position:relative;top:-3px;transform:rotate(135deg);width:3px;z-index:-1}
		#arm #nose{border-color:transparent #666 transparent transparent;border-style:solid;border-width:0 20px 20px 0;display:block;height:0;left:250px;position:absolute;top:-25px;width:0}
		#arm #shine{background-color:#262524;display:block;height:2px;left:54px;position:absolute;top:-23px;width:199px;z-index:1}
		#arm #shadow{background-color:#327C5E;display:block;height:2px;left:43px;position:absolute;top:-8px;width:223px;z-index:1}
		#tail{border-color:#33936c transparent #327C5E;border-image:none;border-style:solid;border-width:3px 0 2px;height:12px;left:-75px;position:absolute;top:-3px;width:85px;z-index:-1}
		#tail section{background:linear-gradient(to right,#327C5E 0,#327C5E 33%,#33936c 33%,#33936c 100%) repeat scroll 0 0 rgba(0,0,0,0);float:left;height:7px;margin-right:3px;width:6px}
		#tail #end{border-color:transparent #33936c transparent transparent;border-style:solid;border-width:0 13px 12px 0;display:block;height:0;left:-13px;position:absolute;top:-3px;width:0}
		#tail #end::after{border-color:transparent #666 transparent transparent;border-style:solid;border-width:0 7px 6px 0;content:"";display:block;height:0;left:5px;position:absolute;top:3px;width:0}
		#tail #weight{background:none repeat scroll 0 0 #33936c;border-radius:25%;border-top:2px solid #33936c;display:block;height:16px;left:-17px;position:absolute;top:-17px;width:18px}
		#tail #weight::after{background-color:#1e1b35;border-radius:0 0 25% 25%;content:"";display:block;height:5px;position:relative;top:9px;width:18px}
		#cable #line{background:none repeat scroll 0 0 #000;height:140px;left:200px;position:absolute;top:-7px;width:1px}
		#cable #hook{font-family:Rokkitt,sans-serif;font-size:1.25em;left:197px;position:absolute;top:125px;transform:rotate(182deg) rotateY(180deg)}
		#control-center #body{border-top:2px solid #327C5E;background-color:#33936c;height:25px;left:-10px;position:relative;transform:skewX(-10deg);width:50px}
		#control-center #body b{color:#af5800;font-family:verdana;font-size:.75em;font-weight:700;opacity:.5;padding-left:4px}
		#control-center #cabin{background-color:#33936c;border-left:2px solid #327C5E;height:25px;left:25px;position:absolute;top:-5px;width:17px}
		#control-center #cabin::before{border-bottom:10px solid #33936c;border-left:10px solid transparent;border-right:10px solid transparent;content:"";display:block;height:0;left:7px;position:relative;top:7.5px;transform:rotate(90deg) scale(1.01) translateZ(1px);width:25px}
		#control-center #cabin #window1{background:none repeat scroll 0 0 #000;display:block;height:18px;left:5px;position:relative;top:-6px;width:6px}
		#control-center #cabin #window2{border-color:transparent transparent transparent #000;border-style:solid;border-width:9px 0 0 9px;display:block;height:0;left:13px;position:absolute;top:3px;width:0}
		#control-center #cabin #window3{border-color:#000 transparent transparent;border-style:solid;border-width:9px 9px 0 0;display:block;height:0;left:13px;position:absolute;top:14px;width:0}
		#control-center #cabin #window1,#control-center #cabin #window2,#control-center #cabin #window3{opacity:.85}
		#control-center #barrier{background-color:#404040;display:block;height:2px;left:-14px;position:absolute;top:19px;width:45px}
		#control-center #barrier::before{background-color:#e27100;content:"";display:block;height:2px;left:-2px;position:absolute;top:4px;width:48px}
		#control-center #barrier::after{background-color:#5a5a5a;content:"";display:block;height:2px;left:0;position:absolute;top:-4px;width:45px}
		#control-center #barrier span{background-color:#404040;display:inline-block;height:7px;left:0;margin:0 1.3px;position:relative;top:-10px;width:2px;z-index:1}
		#neck{height:20px;width:16px;margin:0 7px;display:block;background-color:#33936c}
		#neck #one{border-bottom:6px solid #33936c;border-left:5px solid transparent;border-right:5px solid transparent;height:0;left:3px;position:absolute;top:39px;width:24px}
		#neck #two{border-bottom:5px solid #1e1b35;border-left:5px solid transparent;border-right:5px solid transparent;height:0;left:3px;position:absolute;top:38px;width:24px}
		#neck .shine{background-color:#33936c;display:block;float:left;height:15px;left:7px;position:absolute;width:2px}
		#neck .shadow{background-color:#327C5E;display:block;float:left;height:15px;left:21px;position:absolute;width:2px}
		#tower section{border:4px solid #33936c;height:30px;margin-bottom:-8px;position:relative;top:-3px;transform:scale(.8);width:30px}
		#tower section::before{background:linear-gradient(to right,#268760 0,#227F59 50%,#227251 100%);content:"";display:block;height:38px;left:9px;position:relative;top:-8px;transform:rotate(45deg);width:4px;z-index:-1}
		#tower section::after{background:linear-gradient(to right,#268760 0,#227F59 50%,#227251 100%);content:"";display:block;height:38px;left:9px;position:relative;top:-46px;transform:rotate(135deg);width:4px;z-index:-1}
		#tower section span{background-color:#af5800;display:block;float:left;height:1px;left:4px;position:relative;top:-38px;width:14px}
		#tower .shine {background-color: #33936c;display: block;float: left;height: 224px;left: 3px;position: absolute;width: 2px;z-index: 5;top: 43px;}
		#tower .shadow {background-color: #327C5E;display: block;float: left;height: 224px;left: 25px;position: absolute;width: 2px;z-index: 5;top: 43px;}
		#base {border-bottom: 10px solid #1e1b35;border-left: 5px solid transparent;border-right: 5px solid transparent;position: relative;left: -2px;top: 4px;height: 0;width: 34px;}
		@keyframes lightFlash{0%{opacity:1}50%{opacity:.25}100%{opacity:1}}

		.giro{left:50%;margin-left:-95px;margin-top:30px;position:absolute;top:0%;z-index: 100;}
		.carro{left:50%;margin-left:92px;margin-top:110px;position:absolute;top:0%;z-index: 100;}
		.elevacion{left:50%;margin-left:115px;margin-top:170px;position:absolute;top:0%;z-index: 100;}
		.carga{left:50%;margin-left:115px;margin-top:270px;position:absolute;top:0%;z-index: 100;}
		.carga_maxima{left:50%;margin-left:205px;margin-top:60px;position:absolute;top:0%;z-index: 100;}
		.partida{left:50%;margin-left:-105px;margin-top:140px;position:absolute;top:0%;z-index: 100;}
		.parada{left:50%;margin-left:-105px;margin-top:170px;position:absolute;top:0%;z-index: 100;}
		.voltaje{left:50%;margin-left:-105px;margin-top:360px;position:absolute;top:0%;z-index: 100;}

	</style>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Historial Operaciones de <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div style="height: 550px;">
						<div class="giro btn-group btn-group-xs" role="group" aria-label="...">
							<button type="button" id="giro_left"  class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
							<button type="button" id="giro_stop"  class="btn btn-default"><i class="fa fa-stop-circle" aria-hidden="true"></i></button>
							<button type="button" id="giro_right" class="btn btn-default"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
						</div>

						<div class="carro btn-group btn-group-xs" role="group" aria-label="...">
							<button type="button" id="carro_left"  class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
							<button type="button" id="carro_stop"  class="btn btn-default"><i class="fa fa-stop-circle" aria-hidden="true"></i></button>
							<button type="button" id="carro_right" class="btn btn-default"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
						</div>

						<div class="elevacion btn-group-vertical btn-group-xs" role="group" aria-label="...">
							<button type="button" id="elevacion_up"   class="btn btn-default"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
							<button type="button" id="elevacion_down" class="btn btn-default"><i class="fa fa-arrow-down" aria-hidden="true"></i></button>
						</div>

						<div class="carga btn-group-vertical btn-group-xs" role="group" aria-label="...">
							<button type="button" id="carga"   class="btn btn-default"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>
						</div>

						<div class="carga_maxima btn-group-vertical btn-group-xs" role="group" aria-label="...">
							<button type="button" id="carga_maxima"   class="btn btn-default"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>
						</div>

						<div class="partida btn-group-vertical btn-group-xs" role="group" aria-label="...">
							<button type="button" id="partida"   class="btn btn-default"><i class="fa fa-toggle-on" aria-hidden="true"></i></button>
							<button type="button" id="parada"   class="btn btn-default"><i class="fa fa-hand-paper-o" aria-hidden="true"></i></button>
						</div>

						<div class="voltaje btn-group-vertical btn-group-xs" role="group" aria-label="...">
							<button type="button" id="voltaje"   class="btn btn-default"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>
						</div>

						<div id="crane">
							<div id="peak">
								<section id="light"></section>
								<section id="first"></section>
								<section id="second"></section>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<section id="line1"></section>
								<section id="line2"></section>
							</div>
							<div id="arm">
								<span id="connector1"></span>
								<span id="connector2"></span>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<span id="nose"></span>
								<span id="shine"></span>
								<span id="shadow"></span>
							</div>
							<div id="tail">
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<section></section>
								<span id="end"></span>
								<span id="weight"></span>
							</div>
							<div id="cable">
								<section id="line"></section>
								<section id="hook">?</section>
							</div>

							<div id="control-center">
								<section id="body"></section>
								<section id="cabin">
									<span id="window1"></span>
									<span id="window2"></span>
									<span id="window3"></span>
								</section>
								<section id="barrier">
									<span style="margin-left: -0.1px;"></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span style="margin-right: 0px;"></span>
								</section>
							</div>
							<div id="neck">
								<span class="shine"></span>
								<span class="shadow"></span>
								<section id="one"></section>
								<section id="two"></section>
							</div>
							<div id="tower">
								<span class="shine"></span>
								<span class="shadow"></span>
								<section><span></span></section>
								<section><span></span></section>
								<section><span></span></section>
								<section><span></span></section>
								<section><span></span></section>
								<section><span></span></section>
								<section><span></span></section>
								<section><span></span></section>
								<section><span></span></section>
								<section style="margin-bottom: -10px;"><span></span></section>
							</div>
							<div id="base">
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="table-wrapper-scroll-y my-custom-scrollbar">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Fecha</th>
										<th>Hora</th>
										<th>Accion</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrMediciones as $med) {
										$data_s = '';
										$data_x = '';
										foreach ($arrOperaciones as $oper) {
											//Verifico si es igual al valor
											if($med['Sensor_'.$oper['N_Sensor']]==$oper['ValorActivo']&&$oper['idFuncion']!=15){
												$data_s .= ' data-sensor_'.$oper['idFuncion'].'="1"';
											}elseif($oper['idFuncion']==15&&($med['Sensor_'.$oper['N_Sensor']]<$oper['RangoMinimo'] OR $med['Sensor_'.$oper['N_Sensor']]>$oper['RangoMaximo'])){
												$data_s .= ' data-sensor_'.$oper['idFuncion'].'="1"';
											}
										}
										if(isset($_GET['fecha_actual'])&&$_GET['fecha_actual']!=''&&isset($_GET['hora_actual'])&&$_GET['hora_actual']!=''){
											if($med['FechaSistema']==$_GET['fecha_actual'] && $med['HoraSistema']==$_GET['hora_actual']){
												$data_x = 'success';
											}
										}
										 ?>
										<tr class="odd <?php echo $data_x; ?>"  <?php echo $data_s; ?> >
											<td><?php echo $med['FechaSistema']; ?></td>
											<td><?php echo $med['HoraSistema']; ?></td>
											<td>
												<?php
												foreach ($arrOperaciones as $oper) {
													//Verifico si es igual al valor
													if($med['Sensor_'.$oper['N_Sensor']]==$oper['ValorActivo']&&$oper['idFuncion']!=15){
														echo $rowData['SensoresNombre_'.$oper['N_Sensor']].' - '.$oper['Funcion'].'<br/>';
													}elseif($oper['idFuncion']==15&&($med['Sensor_'.$oper['N_Sensor']]<$oper['RangoMinimo'] OR $med['Sensor_'.$oper['N_Sensor']]>$oper['RangoMaximo'])){
														echo $rowData['SensoresNombre_'.$oper['N_Sensor']].' - '.$oper['Funcion'].'<br/>';
													}
												}
												?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>
			</div>
		</div>
	</div>


	<script>
	$('#dataTable tr').hover(function(){
		//Partida
		if (typeof $(this).data('sensor_1') !== 'undefined') {
			document.getElementById('partida').style.backgroundColor  = '#5cb85c';
		}else{
			document.getElementById('partida').style.backgroundColor  = '#ee465a';
		}
		//Parada
		if (typeof $(this).data('sensor_2') !== 'undefined') {
			document.getElementById('parada').style.backgroundColor  = '#ee465a';
		}else{
			document.getElementById('parada').style.backgroundColor  = '#ffffff';
		}
		/************************************************/
		//Freno giro
		if (typeof $(this).data('sensor_3') !== 'undefined') {
			document.getElementById('giro_stop').style.backgroundColor  = '#FFA500';
		}else{
			document.getElementById('giro_stop').style.backgroundColor  = '#ffffff';
		}
		//Giro izquierda
		if (typeof $(this).data('sensor_4') !== 'undefined') {
			document.getElementById('giro_left').style.backgroundColor  = '#5cb85c';
		}else{
			document.getElementById('giro_left').style.backgroundColor  = '#ffffff';
		}
		//Giro derecha
		if (typeof $(this).data('sensor_5') !== 'undefined') {
			document.getElementById('giro_right').style.backgroundColor  = '#5cb85c';
		}else{
			document.getElementById('giro_right').style.backgroundColor  = '#ffffff';
		}
		/************************************************/
		//Freno de carro
		if (typeof $(this).data('sensor_6') !== 'undefined') {
			document.getElementById('carro_stop').style.backgroundColor  = '#FFA500';
		}else{
			document.getElementById('carro_stop').style.backgroundColor  = '#ffffff';
		}
		//Carro adelante
		if (typeof $(this).data('sensor_7') !== 'undefined') {
			document.getElementById('carro_right').style.backgroundColor  = '#5cb85c';
		}else{
			document.getElementById('carro_right').style.backgroundColor  = '#ffffff';
		}
		//Carro atras
		if (typeof $(this).data('sensor_8') !== 'undefined') {
			document.getElementById('carro_left').style.backgroundColor  = '#5cb85c';
		}else{
			document.getElementById('carro_left').style.backgroundColor  = '#ffffff';
		}
		/************************************************/
		//Elevacion arriba
		if (typeof $(this).data('sensor_9') !== 'undefined') {
			document.getElementById('elevacion_up').style.backgroundColor  = '#5cb85c';
		}else{
			document.getElementById('elevacion_up').style.backgroundColor  = '#ffffff';
		}

		//Elevacion abajo
		if (typeof $(this).data('sensor_10') !== 'undefined') {
			document.getElementById('elevacion_down').style.backgroundColor  = '#5cb85c';
		}else{
			document.getElementById('elevacion_down').style.backgroundColor  = '#ffffff';
		}

		/************************************************/
		//Maxima velocidad elevacion
		if (typeof $(this).data('sensor_11') !== 'undefined') {
			// your code here
		}
		//Carga maxima
		if (typeof $(this).data('sensor_12') !== 'undefined') {
			document.getElementById('carga').style.backgroundColor  = '#ee465a';
		}else{
			document.getElementById('carga').style.backgroundColor  = '#ffffff';
		}
		//Carga maxima en punta
		if (typeof $(this).data('sensor_13') !== 'undefined') {
			document.getElementById('carga_maxima').style.backgroundColor  = '#ee465a';
		}else{
			document.getElementById('carga_maxima').style.backgroundColor  = '#ffffff';
		}

		//Limitador carga maxima 3ra velocidad elevacion
		if (typeof $(this).data('sensor_14') !== 'undefined') {
			// your code here
		}

		/************************************************/
		//Voltaje
		if (typeof $(this).data('sensor_15') !== 'undefined') {
			document.getElementById('voltaje').style.backgroundColor  = '#ee465a';
		}else{
			document.getElementById('voltaje').style.backgroundColor  = '#ffffff';
		}
	});
	</script>

<?php } ?>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//filtros
$w  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$w .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$w .= " AND telemetria_listado.idTab=6";//Power-Crane
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
				if(isset($idTelemetria)){    $x1  = $idTelemetria;  }else{$x1  = '';}
				if(isset($fecha_desde)){     $x2  = $fecha_desde;   }else{$x2  = '';}
				if(isset($h_inicio)){        $x3  = $h_inicio;      }else{$x3  = '';}
				if(isset($fecha_hasta)){     $x4  = $fecha_hasta;   }else{$x4  = '';}
				if(isset($h_termino)){       $x5  = $h_termino;     }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo Medicion','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo Medicion','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
				}

				$Form_Inputs->form_date('Fecha Desde','fecha_desde', $x2, 2);
				$Form_Inputs->form_time('Hora Desde','h_inicio', $x3, 1, 1);
				$Form_Inputs->form_date('Fecha Hasta','fecha_hasta', $x4, 2);
				$Form_Inputs->form_time('Hora Hasta','h_termino', $x5, 1, 1);

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
