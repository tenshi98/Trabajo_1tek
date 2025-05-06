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
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "view_telemetria_alertas.php";
$location = $original;
$location .='?pagina=1';
//verifico si existen los parametros de fecha
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$location .='&f_inicio='.$_GET['f_inicio'];
	$location .='&f_termino='.$_GET['f_termino'];
}
//verifico si se selecciono un equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$location .='&idTelemetria='.$_GET['idTelemetria'];
}
//verifico el tipo de error
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
	$location .='&idTipo='.$_GET['idTipo'];
}
//verifico si esta leido
if(isset($_GET['idLeido'])&&$_GET['idLeido']!=''){
	$location .='&idLeido='.$_GET['idLeido'];
}
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se borra un dato
if (!empty($_GET['idErrores'])){
	//Llamamos al formulario
	$form_trabajo= 'silenciar_uno';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_errores.php';
}
//se borra un dato
if (!empty($_GET['all'])){
	//Llamamos al formulario
	$form_trabajo= 'silenciar_todos';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_listado_errores.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
//Inicia variable
$SIS_where = "telemetria_listado_errores.idErrores>0";
$SIS_where.= " AND telemetria_listado_errores.idTipo!='999'";
$SIS_where.= " AND telemetria_listado_errores.Valor<'99900'";
$SIS_where.= " AND telemetria_listado.id_Geo='2'";
$SIS_where.= " AND telemetria_listado_errores.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$SIS_where .= " AND telemetria_listado.idTab=6";//Power-Crane
}
//verifico si existen los parametros de fecha
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where.= " AND telemetria_listado_errores.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
//verifico si se selecciono un equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND telemetria_listado_errores.idTelemetria='".$_GET['idTelemetria']."'";
	$search .= '&idTelemetria='.$_GET['idTelemetria'];
}
//verifico el tipo de error
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
	$SIS_where.= " AND telemetria_listado_errores.idTipo='".$_GET['idTipo']."'";
}
//verifico si esta leido
if(isset($_GET['idLeido'])&&$_GET['idLeido']!=''){
	$SIS_where.= " AND telemetria_listado_errores.idLeido='".$_GET['idLeido']."'";
	$search .= '&idLeido='.$_GET['idLeido'];
}

//verifico si esta leido
if(isset($_GET['submit_filter'])&&$_GET['submit_filter']!=''){
	$search .= '&submit_filter='.$_GET['submit_filter'];
}
//Verifico el tipo de usuario que esta ingresando
$SIS_join  = ' LEFT JOIN `telemetria_listado`                 ON telemetria_listado.idTelemetria                 = telemetria_listado_errores.idTelemetria';
$SIS_join .= ' LEFT JOIN `telemetria_listado_sensores_unimed` ON telemetria_listado_sensores_unimed.idTelemetria = telemetria_listado.idTelemetria';
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_join .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado_errores.idTelemetria ";
	$SIS_where.= ' AND usuarios_equipos_telemetria.idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'telemetria_listado_errores.idErrores', 'telemetria_listado_errores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);

//numero sensores equipo
$N_Maximo_Sensores = 72;
$SIS_query = '
telemetria_listado_errores.idErrores,
telemetria_listado_errores.Descripcion,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Hora,
telemetria_listado_errores.Sensor,
telemetria_listado_errores.Valor,
telemetria_listado_errores.Valor_min,
telemetria_listado_errores.Valor_max,
telemetria_listado_errores.idTelemetria,
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado.id_Geo';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
$SIS_order = 'telemetria_listado_errores.idErrores DESC LIMIT '.$comienzo.', '.$cant_reg;
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrErrores');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

$arrUnimedX = array();
foreach ($arrUnimed as $sen) {
	$arrUnimedX[$sen['idUniMed']] = $sen['Nombre'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resultados</h5>
			<div class="toolbar">
				<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_cross_crane_01.php';if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){echo '?idTel='.$_GET['idTelemetria'];} ?>" class="btn btn-xs btn-primary"><i class="fa fa-history" aria-hidden="true"></i> Alertas históricas</a>
				<a href="<?php echo $location.'&all='.$_GET['idTelemetria']; ?>" class="btn btn-xs btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Marcar Todos Leidos</a>
				<?php echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre Equipo</th>
						<th>Descripcion</th>
						<th>Fecha</th>
						<th>Hora</th>
                        <th>Medicion Actual</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrErrores as $error) {  ?>
						<tr>
							<td><?php echo $error['NombreEquipo']; ?></td>
							<td><?php echo $error['Descripcion']; ?></td>
							<td><?php echo fecha_estandar($error['Fecha']); ?></td>
							<td><?php echo $error['Hora']; ?></td>
							<td><?php echo Cantidades_decimales_justos($error['Valor']).$arrUnimedX[$error['SensoresUniMed_'.$error['Sensor']]]; ?></td>
							<td><?php echo Cantidades_decimales_justos($error['Valor_min']).$arrUnimedX[$error['SensoresUniMed_'.$error['Sensor']]]; ?></td>
							<td><?php echo Cantidades_decimales_justos($error['Valor_max']).$arrUnimedX[$error['SensoresUniMed_'.$error['Sensor']]]; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&idErrores='.$error['idErrores'].'&idTelemetriaMarc='.$error['idTelemetria']; ?>" title="Marcar como leido" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>

									<?php
									$fecha_desde  = $error['Fecha'];
									$fecha_hasta  = $error['Fecha'];
									$h_inicio     = restahoras('00:05:00',$error['Hora']);
									$h_termino    = sumahoras('00:05:00',$error['Hora']);

									//Se calcula lapso de tiempo condicionando dias
									if($error['Hora']<'00:05:00'){
										$fecha_desde = restarDias($error['Fecha'],1);
									}

									//dirección
									$subloc  = 'informe_telemetria_historial_operaciones_01.php';
									$subloc .= '?idTelemetria='.$error['idTelemetria'];
									$subloc .= '&fecha_desde='.$fecha_desde;
									$subloc .= '&fecha_hasta='.$fecha_hasta;
									$subloc .= '&h_inicio='.$h_inicio;
									$subloc .= '&h_termino='.$h_termino;
									$subloc .= '&fecha_actual='.$error['Fecha'];
									$subloc .= '&hora_actual='.$error['Hora'];
									$subloc .= '&submit_filter=Filtrar';

									?>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo $subloc; ?>" title="Ver historial operacional" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
                    <?php }  ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';
//cuadro mensajes
widget_avgrund();

?>
