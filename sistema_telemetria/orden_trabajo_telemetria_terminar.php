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
$original = "orden_trabajo_telemetria_terminar.php";
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
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where = "orden_trabajo_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_where.= " AND orden_trabajo_listado.idEstado = 1";
	//Verifico si la variable de busqueda existe
	if (isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){ $SIS_where .= " AND orden_trabajo_listado.idTelemetria = '".$_GET['idTelemetria']."'";}
	if (isset($_GET['idMaquina']) && $_GET['idMaquina']!=''){       $SIS_where .= " AND orden_trabajo_listado.idMaquina = '".$_GET['idMaquina']."'";}
	if (isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){   $SIS_where .= " AND orden_trabajo_listado.idPrioridad = '".$_GET['idPrioridad']."'";}
	if (isset($_GET['idTipo']) && $_GET['idTipo']!=''){             $SIS_where .= " AND orden_trabajo_listado.idTipo = '".$_GET['idTipo']."'";}
	if(isset($_GET['f_programacion_inicio'])&&$_GET['f_programacion_inicio']!=''&&isset($_GET['f_programacion_termino'])&&$_GET['f_programacion_termino']!=''){
		$SIS_where .=" AND orden_trabajo_listado.f_programacion BETWEEN '".$_GET['f_programacion_inicio']."' AND '".$_GET['f_programacion_termino']."'";
	}

	// Se trae un listado con todos los elementos
	$SIS_query = '
	orden_trabajo_listado.idOT,
	orden_trabajo_listado.f_programacion,
	orden_trabajo_listado.Observaciones,
	maquinas_listado.Nombre AS NombreMaquina,
	core_ot_prioridad.Nombre AS NombrePrioridad,
	core_ot_tipos.Nombre AS NombreTipo,
	telemetria_listado.Nombre AS NombreTelemetria';
	$SIS_join  = '
	LEFT JOIN `maquinas_listado`     ON maquinas_listado.idMaquina      = orden_trabajo_listado.idMaquina
	LEFT JOIN `core_ot_prioridad`    ON core_ot_prioridad.idPrioridad   = orden_trabajo_listado.idPrioridad
	LEFT JOIN `core_ot_tipos`        ON core_ot_tipos.idTipo            = orden_trabajo_listado.idTipo
	LEFT JOIN `telemetria_listado`   ON telemetria_listado.idTelemetria = orden_trabajo_listado.idTelemetria';
	$SIS_order = 'orden_trabajo_listado.idOT DESC';
	$arrOTS = array();
	$arrOTS = db_select_array (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ordenes de Trabajo</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>F Prog</th>
							<th>Equipo Telemetria</th>
							<th>Maquina</th>
							<th>Prioridad</th>
							<th>Tipo Trabajo</th>
							<th>Observaciones</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrOTS as $ot) { ?>
							<tr class="odd">
								<td><?php echo $ot['idOT']; ?></td>
								<td><?php echo Fecha_estandar($ot['f_programacion']); ?></td>
								<td><?php echo $ot['NombreTelemetria']; ?></td>
								<td><?php echo $ot['NombreMaquina']; ?></td>
								<td><?php echo $ot['NombrePrioridad']; ?></td>
								<td><?php echo $ot['NombreTipo']; ?></td>
								<td><?php echo $ot['Observaciones']; ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_orden_trabajo_telemetria.php?view='.simpleEncode($ot['idOT'], fecha_actual()); ?>" title="Ver Orden de Trabajo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'orden_trabajo_telemetria_editar.php?view='.simpleEncode($ot['idOT'], fecha_actual()).'&ter=true'; ?>" title="Editar Orden de Trabajo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									</div>
								</td>
							</tr>
						<?php } ?>
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
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idConfig_1=1 AND idEstado=1";

	//filtros
	$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
					if(isset($idTelemetria)){             $x0  = $idTelemetria;            }else{$x0  = '';}
					if(isset($idMaquina)){                $x1  = $idMaquina;               }else{$x1  = '';}
					if(isset($idPrioridad)){              $x2  = $idPrioridad;             }else{$x2  = '';}
					if(isset($idTipo)){                   $x3  = $idTipo;                  }else{$x3  = '';}
					if(isset($f_programacion_inicio)){    $x4  = $f_programacion_inicio;   }else{$x4  = '';}
					if(isset($f_programacion_termino)){   $x5  = $f_programacion_termino;  }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo de Telemetria','idTelemetria', $x0, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo de Telemetria','idTelemetria', $x0, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
					}
					$Form_Inputs->form_select_filter('Maquina','idMaquina', $x1, 1, 'idMaquina', 'Nombre', 'maquinas_listado', $w, '', $dbConn);
					$Form_Inputs->form_select('Prioridad','idPrioridad', $x2, 1, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo','idTipo', $x3, 1, 'idTipo', 'Nombre', 'core_ot_tipos', 0, '', $dbConn);
					$Form_Inputs->form_date('Fecha Programacion Desde','f_programacion_inicio', $x4, 1);
					$Form_Inputs->form_date('Fecha Programacion Hasta','f_programacion_termino', $x5, 1);
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
