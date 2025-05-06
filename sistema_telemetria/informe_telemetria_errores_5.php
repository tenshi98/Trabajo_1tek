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
$original = "informe_telemetria_errores_5.php";
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
$SIS_where.= " AND telemetria_listado.id_Geo='1'";
$SIS_where.= " AND telemetria_listado_errores.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$SIS_where .= " AND telemetria_listado.idTab=4";//Agro-Weather
}
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search .='&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
$search .='&submit_filter=Filtrar';
$search .='&idOpciones=1';
//verifico si existen los parametros de fecha
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where.= " AND telemetria_listado_errores.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$search   .= '&f_inicio='.$_GET['f_inicio'].'&f_termino='.$_GET['f_termino'];
}
//verifico si se selecciono un equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND telemetria_listado_errores.idTelemetria='".$_GET['idTelemetria']."'";
	$search   .= '&idTelemetria='.$_GET['idTelemetria'];
}
//verifico el tipo de error
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
	$SIS_where.= " AND telemetria_listado_errores.idTipo='".$_GET['idTipo']."'";
	$search   .= '&idTipo='.$_GET['idTipo'];
}
//Verifico el tipo de usuario que esta ingresando
$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_errores.idTelemetria';
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
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_listado_errores.idErrores,
telemetria_listado_errores.Descripcion,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Hora,
telemetria_listado_errores.Sensor,
telemetria_listado_errores.Valor,
telemetria_listado_errores.Valor_min,
telemetria_listado_errores.Valor_max,
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado.id_Geo'.$subquery;
$SIS_join .= ' LEFT JOIN telemetria_listado_sensores_unimed ON telemetria_listado_sensores_unimed.idTelemetria = telemetria_listado_errores.idTelemetria ';
$SIS_order = 'telemetria_listado_errores.idErrores DESC LIMIT '.$comienzo.', '.$cant_reg;
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrErrores');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

$arrFinalUnimed = array();
foreach ($arrUnimed as $sen) {
	$arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];
}
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_telemetria_errores_5_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	<a target="new" href="<?php echo 'informe_telemetria_errores_5_to_pdf.php?bla=bla'.$search ; ?>"   class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resultados</h5>
			<div class="toolbar">
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
                        <th>Ubicación</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrErrores as $error) {
						//Guardo la unidad de medida
						$unimed = ' '.$arrFinalUnimed[$error['SensoresUniMed_'.$error['Sensor']]];
						?>
						<tr>
							<td><?php echo $error['NombreEquipo']; ?></td>
							<td><?php echo $error['Descripcion']; ?></td>
							<td><?php echo fecha_estandar($error['Fecha']); ?></td>
							<td><?php echo $error['Hora']; ?></td>
							<td><?php echo Cantidades_decimales_justos($error['Valor']).$unimed; ?></td>
							<td><?php echo Cantidades_decimales_justos($error['Valor_min']).$unimed; ?></td>
							<td><?php echo Cantidades_decimales_justos($error['Valor_max']).$unimed; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'informe_telemetria_errores_5_view.php?view='.simpleEncode($error['idErrores'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=4";//Agro-Weather
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
