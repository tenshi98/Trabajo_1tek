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
$original = "informe_telemetria_activaciones_02.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $location .= "&idTelemetria=".$_GET['idTelemetria'];  $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['F_inicio']) && $_GET['F_inicio']!=''){   $location .= "&F_inicio=".$_GET['F_inicio'];          $search .= "&F_inicio=".$_GET['F_inicio'];}
if(isset($_GET['H_inicio']) && $_GET['H_inicio']!=''){   $location .= "&H_inicio=".$_GET['H_inicio'];          $search .= "&H_inicio=".$_GET['H_inicio'];}
if(isset($_GET['F_termino']) && $_GET['F_termino']!=''){ $location .= "&F_termino=".$_GET['F_termino'];        $search .= "&F_termino=".$_GET['F_termino'];}
if(isset($_GET['H_termino']) && $_GET['H_termino']!=''){ $location .= "&H_termino=".$_GET['H_termino'];        $search .= "&H_termino=".$_GET['H_termino'];}
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
	$SIS_where = 'telemetria_listado_historial_activaciones.idTelemetria!=0';
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){$z.=" AND telemetria_listado_historial_activaciones.idTelemetria =".$_GET['idTelemetria'];}

	if(isset($_GET['F_inicio'], $_GET['F_termino'], $_GET['h_inicio'], $_GET['h_termino']) && $_GET['F_inicio'] != '' && $_GET['F_termino'] != '' && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
		$SIS_where.=" AND telemetria_listado_historial_activaciones.TimeStamp BETWEEN '".$_GET['F_inicio']." ".$_GET['H_inicio']."' AND '".$_GET['F_termino']." ".$_GET['H_termino']."'";
	}elseif(isset($_GET['F_inicio'], $_GET['F_termino']) && $_GET['F_inicio'] != '' && $_GET['F_termino']!=''){
		$SIS_where.=" AND telemetria_listado_historial_activaciones.Fecha BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
	}

	//verifico el numero de datos antes de hacer la consulta
	$ndata_1 = db_select_nrows (false, 'idTelemetria', 'telemetria_listado_historial_activaciones', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

	//si el dato es superior a 10.000
	if(isset($ndata_1)&&$ndata_1>=10001){
		alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
	}else{

		/**********************************************************/
		//se consulta
		$SIS_query = '
		telemetria_listado.Nombre AS EquipoNombre,
		telemetria_listado_historial_activaciones.Fecha AS EquipoFecha,
		telemetria_listado_historial_activaciones.Hora AS EquipoHora,
		telemetria_listado_historial_activaciones.SensorActivacionValor AS EquipoActivacionValor,
		telemetria_listado_historial_activaciones.Valor AS EquipoValor';
		$SIS_join  = 'LEFT JOIN `telemetria_listado`   ON telemetria_listado.idTelemetria  = telemetria_listado_historial_activaciones.idTelemetria';
		$SIS_order = 'telemetria_listado_historial_activaciones.Fecha ASC, telemetria_listado_historial_activaciones.Hora ASC';
		$arrConsulta = array();
		$arrConsulta = db_select_array (false, $SIS_query, 'telemetria_listado_historial_activaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrConsulta');

		?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Actividad del equipo</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Equipo</th>
								<th>Hora</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						filtrar($arrConsulta, 'EquipoFecha');
						foreach($arrConsulta as $categoria=>$permisos){ ?>
							<tr class="odd">
								<td colspan="3"><?php echo fecha_estandar($categoria); ?></td>
							</tr>
							<?php foreach ($permisos as $con) { ?>
								<tr class="odd">
									<td><?php echo $con['EquipoNombre']; ?></td>
									<td><?php echo $con['EquipoHora']; ?></td>
									<td><?php if($con['EquipoValor']==$con['EquipoActivacionValor']){echo 'Encendido';}else{echo 'Apagado';} ; ?></td>
								</tr>
							<?php }
						} ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	<?php } ?>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
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
					if(isset($H_inicio)){      $x3  = $H_inicio;      }else{$x3  = '';}
					if(isset($F_termino)){     $x4  = $F_termino;     }else{$x4  = '';}
					if(isset($H_termino)){     $x5  = $H_termino;     }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_date('Fecha Inicio','F_inicio', $x2, 2);
					$Form_Inputs->form_time('Hora Inicio','H_inicio', $x3, 1, 2);
					$Form_Inputs->form_date('Fecha Termino','F_termino', $x4, 2);
					$Form_Inputs->form_time('Hora Termino','H_termino', $x5, 1, 1);

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
