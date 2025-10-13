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
$original = "informe_telemetria_errores_7.php";
$location = $original;
/********************************************************************/
//Variables para filtro y paginacion
$search  = '';
if(isset($_GET['pagina'])&&$_GET['pagina']!=''){$search .= '&pagina='.$_GET['pagina'];}
$search .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
$search .= '&submit_filter=Filtrar';

$location .= '?bla=bla';
if(isset($_GET['pagina'])&&$_GET['pagina']!=''){$location .= '&pagina='.$_GET['pagina'];}
$location .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$location .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
$location .= '&submit_filter=Filtrar';

if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){    $location .= "&f_inicio=".$_GET['f_inicio'];           $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){  $location .= "&f_termino=".$_GET['f_termino'];         $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){   $location .= "&idTelemetria=".$_GET['idTelemetria'];   $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){        $location .= "&idTipo=".$_GET['idTipo'];               $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idLeido']) && $_GET['idLeido']!=''){      $location .= "&idLeido=".$_GET['idLeido'];             $search .= "&idLeido=".$_GET['idLeido'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
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
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){

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
	$SIS_where .= " AND telemetria_listado.idTab=9";//Power-Energy
}
//verifico si existen los parametros de fecha
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where.=" AND telemetria_listado_errores.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
//verifico si se selecciono un equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.=" AND telemetria_listado_errores.idTelemetria='".$_GET['idTelemetria']."'";
}
//verifico el tipo de error
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
	$SIS_where.=" AND telemetria_listado_errores.idTipo='".$_GET['idTipo']."'";
}
//verifico si esta leido
if(isset($_GET['idLeido'])&&$_GET['idLeido']!=''){
	$SIS_where.=" AND telemetria_listado_errores.idLeido='".$_GET['idLeido']."'";
}
//Verifico el tipo de usuario que esta ingresando
$SIS_join  = "LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_errores.idTelemetria";
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_join .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado_errores.idTelemetria ";
	$SIS_where.=' AND usuarios_equipos_telemetria.idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
}

/**************************************************************/
//Busco la cantidad total de registros
$cuenta_registros = db_select_nrows (false, 'telemetria_listado_errores.idErrores', 'telemetria_listado_errores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);

//numero sensores equipo
$N_Maximo_Sensores = 20;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
//datos a mostrar
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
telemetria_listado.id_Geo'.$subquery;
$SIS_join .= ' LEFT JOIN telemetria_listado_sensores_unimed ON telemetria_listado_sensores_unimed.idTelemetria = telemetria_listado_errores.idTelemetria ';
$SIS_order = 'telemetria_listado_errores.idErrores DESC LIMIT '.$comienzo.', '.$cant_reg;
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrErrores');

$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

$arrUnimedX = array();
foreach ($arrUnimed as $sen) {
	$arrUnimedX[$sen['idUniMed']] = $sen['Nombre'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_telemetria_errores_7_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	<a target="new" href="<?php echo 'informe_telemetria_errores_7_to_pdf.php?bla=bla'.$search ; ?>"   class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resultados</h5>
			<div class="toolbar">
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
									<a href="<?php echo 'informe_telemetria_errores_7_view.php?view='.simpleEncode($error['idErrores'], fecha_actual()); ?>" title="Ver Ubicación" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&idErrores='.$error['idErrores'].'&idTelemetriaMarc='.$error['idTelemetria']; ?>" title="Marcar como leido" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
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

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="<?php echo $original ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
$z .= " AND telemetria_listado.id_Sensores=1";                                           //sensores activos
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
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
				if(isset($f_inicio)){      $x1  = $f_inicio;      }else{$x1  = '';}
				if(isset($f_termino)){     $x2  = $f_termino;     }else{$x2  = '';}
				if(isset($idTelemetria)){  $x3  = $idTelemetria;  }else{$x3  = '';}
				if(isset($idTipo)){        $x4  = $idTipo;        }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x3, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x3, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select('Tipo de error','idTipo', $x4, 1, 'idTipo', 'Nombre', 'telemetria_listado_errores_tipos', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('pagina', 1, 1);

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
