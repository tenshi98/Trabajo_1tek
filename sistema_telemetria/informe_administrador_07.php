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
$original = "informe_administrador_07.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
$location .= "?submit_filter=Filtrar";
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){          $location .= "&f_inicio=".$_GET['f_inicio'];          $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){          $location .= "&h_inicio=".$_GET['h_inicio'];          $search .= "&h_inicio=".$_GET['h_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){        $location .= "&f_termino=".$_GET['f_termino'];        $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){        $location .= "&h_termino=".$_GET['h_termino'];        $search .= "&h_termino=".$_GET['h_termino'];}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $location .= "&idTelemetria=".$_GET['idTelemetria'];  $search .= "&idTelemetria=".$_GET['idTelemetria'];}

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
$SIS_where_1 = "telemetria_listado_errores_999.idErrores!=0";           //siempre pasa
$SIS_where_2 = "telemetria_listado_error_fuera_linea.idFueraLinea!=0";  //siempre pasa
$SIS_where_3 = "telemetria_listado.idEstado = 1";                       //solo activos
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino'] != '' && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores_999.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."'";
	$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."'";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores_999.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.Fecha_inicio BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores_999.idTelemetria=".$_GET['idTelemetria'];
	$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.idTelemetria=".$_GET['idTelemetria'];
	$SIS_where_3.=" AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];
}


$N_Maximo_Sensores = 72;
$consql = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
}

/*********************************************************/
//consulto
$SIS_query = '
core_sistemas.Nombre AS Sistema,
telemetria_listado.Nombre AS EquipoNombre,
telemetria_listado_errores_999.idTelemetria AS EquipoId,
core_telemetria_tabs.Nombre AS EquipoTab,
telemetria_listado_errores_999.Sensor AS EquipoNSensor,
COUNT(telemetria_listado_errores_999.idErrores) AS Cuenta,
telemetria_listado_errores_999.Descripcion,
telemetria_listado_errores_999.Valor'.$consql;
$SIS_join  = '
LEFT JOIN telemetria_listado                    ON telemetria_listado.idTelemetria                  = telemetria_listado_errores_999.idTelemetria
LEFT JOIN core_sistemas                         ON core_sistemas.idSistema                          = telemetria_listado_errores_999.idSistema
LEFT JOIN core_telemetria_tabs                  ON core_telemetria_tabs.idTab                       = telemetria_listado.idTab
LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado_errores_999.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado_errores_999.idTelemetria';
$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_errores_999.Sensor ASC, telemetria_listado_errores_999.Descripcion ASC, telemetria_listado_errores_999.Valor ASC';
$SIS_where_1.= ' GROUP BY core_sistemas.Nombre,telemetria_listado.Nombre,core_telemetria_tabs.Nombre,telemetria_listado_errores_999.Sensor, telemetria_listado_errores_999.Descripcion, telemetria_listado_errores_999.Valor';
$arrEquipos1 = array();
$arrEquipos1 = db_select_array (false, $SIS_query, 'telemetria_listado_errores_999', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos1');

/*********************************************************/
//Consulto
$SIS_query = '
core_sistemas.Nombre AS Sistema,
telemetria_listado.Nombre AS EquipoNombre,
core_telemetria_tabs.Nombre AS EquipoTab,
telemetria_listado_error_fuera_linea.Fecha_inicio,
telemetria_listado_error_fuera_linea.Hora_inicio,
telemetria_listado_error_fuera_linea.Fecha_termino,
telemetria_listado_error_fuera_linea.Hora_termino,
telemetria_listado_error_fuera_linea.Tiempo';
$SIS_join  = '
LEFT JOIN telemetria_listado     ON telemetria_listado.idTelemetria  = telemetria_listado_error_fuera_linea.idTelemetria
LEFT JOIN core_sistemas          ON core_sistemas.idSistema          = telemetria_listado_error_fuera_linea.idSistema
LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab       = telemetria_listado.idTab';
$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_error_fuera_linea.Fecha_inicio ASC';
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrErrores');

/*********************************************************/
//Consulto
$SIS_query = '
core_sistemas.Nombre AS Sistema,
telemetria_listado.Nombre AS EquipoNombre,
core_telemetria_tabs.Nombre AS EquipoTab,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.TiempoFueraLinea';
$SIS_join  = '
LEFT JOIN `core_sistemas`        ON core_sistemas.idSistema      = telemetria_listado.idSistema
LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab   = telemetria_listado.idTab';
$SIS_order = 'telemetria_listado.idSistema ASC';
$arrTelemetria = array();
$arrTelemetria = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where_3, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrErrores');

/*********************************************************/
//Se consultan datos
$arrGrupos = array();
$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

$arrFinalGrupos = array();
foreach ($arrGrupos as $sen) {
	$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<?php
	$search .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$search .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
	?>
	<a target="new" href="<?php echo 'informe_administrador_07_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Recuento Total de Alertas</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#99900" data-toggle="tab"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 99900</a></li>
				<li class=""><a href="#99901" data-toggle="tab"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 99901</a></li>
				<li class=""><a href="#fuera" data-toggle="tab"><i class="fa fa-bolt" aria-hidden="true"></i> Fuera Linea</a></li>
				<li class=""><a href="#fuera_actual" data-toggle="tab"><i class="fa fa-bolt" aria-hidden="true"></i> Fuera Linea Actual</a></li>
			</ul>
		</header>
		 <div class="tab-content">

			<div class="tab-pane fade active in" id="99900">
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Sistema</th>
								<th>Equipo</th>
								<th>Id Telemetria</th>
								<th>Tab</th>
								<th>Grupo</th>
								<th>Numero Sensor</th>
								<th>Nombre Sensor</th>
								<th>Numero Alertas</th>
								<th>Descripcion</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrEquipos1 as $equip) { ?>
								<?php if(isset($equip['Valor'])&&$equip['Valor']==99900){ ?>
									<tr class="odd">
										<td><?php echo $equip['Sistema']; ?></td>
										<td><?php echo $equip['EquipoNombre']; ?></td>
										<td><?php echo $equip['EquipoId']; ?></td>
										<td><?php echo $equip['EquipoTab']; ?></td>
										<td><?php echo $arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]]; ?></td>
										<td><?php echo $equip['EquipoNSensor']; ?></td>
										<td><?php echo $equip['SensoresNombre_'.$equip['EquipoNSensor']]; ?></td>
										<td><?php echo $equip['Cuenta']; ?></td>
										<td><?php echo $equip['Descripcion']; ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="99901">
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Sistema</th>
								<th>Equipo</th>
								<th>Id Telemetria</th>
								<th>Tab</th>
								<th>Grupo</th>
								<th>Numero Sensor</th>
								<th>Nombre Sensor</th>
								<th>Numero Alertas</th>
								<th>Descripcion</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrEquipos1 as $equip) { ?>
								<?php if(isset($equip['Valor'])&&$equip['Valor']==99901){ ?>
									<tr class="odd">
										<td><?php echo $equip['Sistema']; ?></td>
										<td><?php echo $equip['EquipoNombre']; ?></td>
										<td><?php echo $equip['EquipoId']; ?></td>
										<td><?php echo $equip['EquipoTab']; ?></td>
										<td><?php echo $arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]]; ?></td>
										<td><?php echo $equip['EquipoNSensor']; ?></td>
										<td><?php echo $equip['SensoresNombre_'.$equip['EquipoNSensor']]; ?></td>
										<td><?php echo $equip['Cuenta']; ?></td>
										<td><?php echo $equip['Descripcion']; ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="fuera">
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Sistema</th>
								<th>Equipo</th>
								<th>Tab</th>
								<th>Fecha Inicio</th>
								<th>Hora Inicio</th>
								<th>Fecha Termino</th>
								<th>Hora Termino</th>
								<th>Tiempo</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrErrores as $error) { ?>
								<tr class="odd">
									<td><?php echo $error['Sistema']; ?></td>
									<td><?php echo $error['EquipoNombre']; ?></td>
									<td><?php echo $error['EquipoTab']; ?></td>
									<td><?php echo fecha_estandar($error['Fecha_inicio']); ?></td>
									<td><?php echo $error['Hora_inicio']; ?></td>
									<td><?php echo fecha_estandar($error['Fecha_termino']); ?></td>
									<td><?php echo $error['Hora_termino']; ?></td>
									<td><?php echo $error['Tiempo']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

			</div>

			<div class="tab-pane fade" id="fuera_actual">
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Sistema</th>
								<th>Equipo</th>
								<th>Tab</th>
								<th>Fecha Inicio</th>
								<th>Hora Inicio</th>
								<th>Tiempo Actual</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							/*************************************************************/
							//Listado de fuera de linea actuales
							foreach ($arrTelemetria as $tel) {

								$diaInicio   = $tel['LastUpdateFecha'];
								$diaTermino  = fecha_actual();
								$tiempo1     = $tel['LastUpdateHora'];
								$tiempo2     = hora_actual();
								$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

								//Comparaciones de tiempo
								$Time_Tiempo     = horas2segundos($Tiempo);
								$Time_Tiempo_FL  = horas2segundos($tel['TiempoFueraLinea']);
								$Time_Tiempo_Max = horas2segundos('48:00:00');
								$Time_Fake_Ini   = horas2segundos('23:59:50');
								$Time_Fake_Fin   = horas2segundos('24:00:00');
								//comparacion
								if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
									echo '
									<tr class="odd">
										<td>'.$tel['Sistema'].'</td>
										<td>'.$tel['EquipoNombre'].'</td>
										<td>'.$tel['EquipoTab'].'</td>
										<td>'.fecha_estandar($tel['LastUpdateFecha']).'</td>
										<td>'.$tel['LastUpdateHora'].' hrs</td>
										<td>'.$Tiempo.' hrs</td>
									</tr>';
								}
							} ?>
						</tbody>
					</table>
				</div>

			</div>

		</div>

	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z  = "telemetria_listado.idTelemetria!=0";   //Siempre pasa

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
				if(isset($f_inicio)){      $x1  = $f_inicio;      }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;      }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;     }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;     }else{$x4  = '';}
				if(isset($idTelemetria)){  $x5  = $idTelemetria;  }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 2);
				$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);

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
