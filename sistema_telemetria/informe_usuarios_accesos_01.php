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
$original = "informe_usuarios_accesos_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search ='&submit_filter=Filtrar';
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){          $location .= "&idUsuario=".$_GET['idUsuario'];          $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['Rango_Inicio']) && $_GET['Rango_Inicio']!=''){    $location .= "&Rango_Inicio=".$_GET['Rango_Inicio'];    $search .= "&Rango_Inicio=".$_GET['Rango_Inicio'];}
if(isset($_GET['Rango_Termino']) && $_GET['Rango_Termino']!=''){  $location .= "&Rango_Termino=".$_GET['Rango_Termino'];  $search .= "&Rango_Termino=".$_GET['Rango_Termino'];}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	usuarios_accesos.Fecha,
	usuarios_accesos.Hora,
	usuarios_accesos.IP_Client,
	usuarios_accesos.Agent_Transp,
	usuarios_listado.Nombre AS Usuario,
	core_sistemas.Nombre AS Sistema';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`   ON usuarios_listado.idUsuario   = usuarios_accesos.idUsuario
	LEFT JOIN `core_sistemas`      ON core_sistemas.idSistema      = usuarios_accesos.idSistema';
	$SIS_where = 'usuarios_accesos.idAcceso>0';
	if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){         $SIS_where .= " AND usuarios_accesos.idUsuario=".$_GET['idUsuario'];}
	if(isset($_GET['idSistemaFil']) && $_GET['idSistemaFil']!=''){   $SIS_where .= " AND usuarios_accesos.idSistema=".$_GET['idSistemaFil'];}
	if(isset($_GET['Rango_Inicio']) && $_GET['Rango_Inicio'] != ''&&isset($_GET['Rango_Termino']) && $_GET['Rango_Termino']!=''){
		$SIS_where .= " AND usuarios_accesos.Fecha BETWEEN '".$_GET['Rango_Inicio']."' AND '".$_GET['Rango_Termino']."'";
	}
	$SIS_order = 'usuarios_accesos.Fecha DESC';
	$arrAccesos = array();
	$arrAccesos = db_select_array (false, $SIS_query, 'usuarios_accesos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAccesos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
		<?php
		$search .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
		$search .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		?>
		<a target="new" href="<?php echo 'informe_usuarios_accesos_01_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Accesos</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Sistema</th>
							<th>Usuario</th>
							<th width="120">Fecha</th>
							<th width="120">Hora</th>
							<th width="120">IP Cliente</th>
							<th>Agent Transp</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						//recorro los datos
						foreach ($arrAccesos as $sol) { ?>
							<tr class="odd">
								<td><?php echo $sol['Sistema']; ?></td>
								<td><?php echo $sol['Usuario']; ?></td>
								<td><?php echo Fecha_estandar($sol['Fecha']); ?></td>
								<td><?php echo $sol['Hora']; ?></td>
								<td><?php echo $sol['IP_Client']; ?></td>
								<td><?php echo $sol['Agent_Transp']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

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
					if(isset($idSistemaFil)){   $x1 = $idSistemaFil;   }else{$x1 = '';}
					if(isset($idUsuario)){      $x2 = $idUsuario;      }else{$x2 = '';}
					if(isset($Rango_Inicio)){   $x3 = $Rango_Inicio;   }else{$x3 = '';}
					if(isset($Rango_Termino)){  $x4 = $Rango_Termino;  }else{$x4 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Sistema','idSistemaFil', $x1, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);
					$Form_Inputs->form_select_filter('Usuario','idUsuario', $x2, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 0, '', $dbConn);
					$Form_Inputs->form_date('Rango de Inicio','Rango_Inicio', $x3, 1);
					$Form_Inputs->form_date('Rango de Termino','Rango_Termino', $x4, 1);

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
