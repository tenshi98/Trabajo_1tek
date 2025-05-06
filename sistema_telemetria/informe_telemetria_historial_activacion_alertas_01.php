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
$original = "informe_telemetria_historial_activacion_alertas_01.php";
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
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = 'telemetria_listado_alarmas_perso_historial.idHistorial!=0';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_alarmas_perso_historial.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_alarmas_perso_historial.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){
	$SIS_where .= " AND telemetria_listado_alarmas_perso_historial.idEstado=".$_GET['idEstado'];
}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where .= " AND telemetria_listado_alarmas_perso_historial.idTelemetria=".$_GET['idTelemetria'];
}
if(isset($_GET['idUsuario'])&&$_GET['idUsuario']!=''){
	$SIS_where .= " AND telemetria_listado_alarmas_perso_historial.idUsuario=".$_GET['idUsuario'];
}

	
				
//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idHistorial', 'telemetria_listado_alarmas_perso_historial', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//se traen lo datos del equipo
	$SIS_query = '
	telemetria_listado.Nombre AS EquipoTel,
	telemetria_listado_alarmas_perso.Nombre AS Alerta,
	telemetria_listado_alarmas_perso_tipos.Nombre AS Tipo,
	core_estados.Nombre AS Estado,
	usuarios_listado.Nombre AS Usuario,
	telemetria_listado_alarmas_perso_historial.Fecha,
	telemetria_listado_alarmas_perso_historial.Hora';
	$SIS_join  = '
	LEFT JOIN `telemetria_listado`                      ON telemetria_listado.idTelemetria                 = telemetria_listado_alarmas_perso_historial.idTelemetria
	LEFT JOIN `telemetria_listado_alarmas_perso`        ON telemetria_listado_alarmas_perso.idAlarma       = telemetria_listado_alarmas_perso_historial.idAlarma
	LEFT JOIN `telemetria_listado_alarmas_perso_tipos`  ON telemetria_listado_alarmas_perso_tipos.idTipo   = telemetria_listado_alarmas_perso.idTipo
	LEFT JOIN `core_estados`                            ON core_estados.idEstado                           = telemetria_listado_alarmas_perso_historial.idEstado
	LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                      = telemetria_listado_alarmas_perso_historial.idUsuario';
	$SIS_order  = 'telemetria_listado_alarmas_perso_historial.Fecha ASC, telemetria_listado_alarmas_perso_historial.Hora ASC, telemetria_listado.Nombre ASC LIMIT 10000';
	$arrAlertas = array();
	$arrAlertas = db_select_array (false, $SIS_query, 'telemetria_listado_alarmas_perso_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAlertas');

	
?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Activacion-Desactivacion</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Fecha</th>
							<th>Hora</th>
							<th>Equipo</th>
							<th>Alerta</th>
							<th>Tipo Alerta</th>
							<th>Usuario</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrAlertas as $con) { ?>
							<tr class="odd">
								<td><?php echo fecha_estandar($con['Fecha']); ?></td>
								<td><?php echo $con['Hora']; ?></td>
								<td><?php echo $con['EquipoTel']; ?></td>
								<td><?php echo $con['Alerta']; ?></td>
								<td><?php echo $con['Tipo']; ?></td>
								<td><?php echo $con['Usuario']; ?></td>
								<td><?php echo $con['Estado']; ?></td>
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
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//filtros
$maqfil = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$maqfil .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
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
				if(isset($f_inicio)){      $x1  = $f_inicio;        }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;        }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;       }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;       }else{$x4  = '';}
				if(isset($idEstado)){      $x5  = $idEstado;        }else{$x5  = '';}
				if(isset($idTelemetria)){  $x6  = $idTelemetria;    }else{$x6  = '';}
				if(isset($idUsuario)){     $x7  = $idUsuario;       }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				$Form_Inputs->form_select('Estado','idEstado', $x5, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo Telemetria','idTelemetria', $x6, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $maqfil, '', $dbConn);
					$Form_Inputs->form_select_filter('Usuario','idUsuario', $x7, 1, 'idUsuario', 'Nombre', 'usuarios_listado', $usrfil, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo Telemetria','idTelemetria', $x6, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $maqfil, $dbConn);
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x7, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				}
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
