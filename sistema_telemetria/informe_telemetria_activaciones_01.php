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
$original = "informe_telemetria_activaciones_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $location .= "&idTelemetria=".$_GET['idTelemetria'];  $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['F_inicio']) && $_GET['F_inicio']!=''){   $location .= "&F_inicio=".$_GET['F_inicio'];          $search .= "&F_inicio=".$_GET['F_inicio'];}
if(isset($_GET['F_termino']) && $_GET['F_termino']!=''){ $location .= "&F_termino=".$_GET['F_termino'];        $search .= "&F_termino=".$_GET['F_termino'];}
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
	$SIS_where = 'idTabla!=0';
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){$idTelemetria = $_GET['idTelemetria'];}
	if(isset($_GET['F_inicio'], $_GET['F_termino']) && $_GET['F_inicio'] != '' && $_GET['F_termino']!=''){
		$SIS_where.=" AND FechaSistema BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
	}

	//verifico el numero de datos antes de hacer la consulta
	$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$idTelemetria, '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

	//si el dato es superior a 10.000
	if(isset($ndata_1)&&$ndata_1>=10001){
		alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
	}else{

		/**********************************************************/
		//se consulta
		$SIS_query = '
		telemetria_listado.Nombre AS Equipo,
		FechaSistema AS Fecha_it,
		(SELECT HoraSistema FROM `telemetria_listado_tablarelacionada_'.$idTelemetria.'` WHERE FechaSistema=Fecha_it AND HoraSistema!="00:00:00" ORDER BY HoraSistema ASC LIMIT 1) AS HoraMin,
		(SELECT HoraSistema FROM `telemetria_listado_tablarelacionada_'.$idTelemetria.'` WHERE FechaSistema=Fecha_it AND HoraSistema!="00:00:00" ORDER BY HoraSistema DESC LIMIT 1) AS HoraMax';
		$SIS_join  = 'LEFT JOIN `telemetria_listado`   ON telemetria_listado.idTelemetria  = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria';
		$SIS_where.= ' GROUP BY FechaSistema';
		$SIS_order = 'FechaSistema ASC LIMIT 10000';
		$arrConsulta = array();
		$arrConsulta = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrConsulta');

		?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Cargas</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Equipo</th>
								<th>Fecha</th>
								<th>Hora Inicio</th>
								<th>Hora Termino</th>

							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrConsulta as $con) { ?>

							<tr class="odd">
								<td><?php echo $con['Equipo']; ?></td>
								<td><?php echo fecha_estandar($con['Fecha_it']); ?></td>
								<td><?php echo $con['HoraMin']; ?></td>
								<td><?php echo $con['HoraMax']; ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>

	<?php } ?>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//filtros
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
					if(isset($idTelemetria)){  $x1  = $idTelemetria;  }else{$x1  = '';}
					if(isset($F_inicio)){      $x2  = $F_inicio;      }else{$x2  = '';}
					if(isset($F_termino)){     $x3  = $F_termino;     }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_date('Fecha Inicio','F_inicio', $x2, 2);
					$Form_Inputs->form_date('Fecha Termino','F_termino', $x3, 2);

					$Form_Inputs->form_input_hidden('pagina', 1, 2);
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
