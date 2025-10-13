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
$original = "informe_bodega_arriendos_02.php";
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
if(!empty($_GET['idBodega'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	bodegas_arriendos_facturacion_existencias.idFacturacion,
	bodegas_arriendos_facturacion_existencias.Cantidad_ing,
	bodegas_arriendos_facturacion_existencias.Cantidad_eg,
	bodegas_arriendos_facturacion_existencias.ValorTotal,
	equipos_arriendo_listado.Nombre AS NombreProd,
	bodegas_arriendos_listado.Nombre AS Bodega,
	core_tiempo_frecuencia.Nombre AS UnidadMedida,
	bodegas_arriendos_facturacion.Creacion_fecha,
	bodegas_arriendos_facturacion.Devolucion_Semana,
	bodegas_arriendos_facturacion.Devolucion_ano,
	bodegas_arriendos_facturacion.Devolucion_fecha,
	bodegas_arriendos_facturacion_tipo.Nombre AS Tipo';
	$SIS_join  = '
	LEFT JOIN `bodegas_arriendos_facturacion`        ON bodegas_arriendos_facturacion.idFacturacion  = bodegas_arriendos_facturacion_existencias.idFacturacion
	LEFT JOIN `core_tiempo_frecuencia`               ON core_tiempo_frecuencia.idFrecuencia          = bodegas_arriendos_facturacion_existencias.idFrecuencia
	LEFT JOIN `equipos_arriendo_listado`             ON equipos_arriendo_listado.idEquipo            = bodegas_arriendos_facturacion_existencias.idEquipo
	LEFT JOIN `bodegas_arriendos_listado`            ON bodegas_arriendos_listado.idBodega           = bodegas_arriendos_facturacion_existencias.idBodega
	LEFT JOIN `bodegas_arriendos_facturacion_tipo`   ON bodegas_arriendos_facturacion_tipo.idTipo    = bodegas_arriendos_facturacion_existencias.idTipo';
	$SIS_where = 'bodegas_arriendos_facturacion_existencias.idBodega='.$_GET['idBodega'];
	$SIS_where.= ' AND bodegas_arriendos_facturacion_existencias.idTipo='.$_GET['idTipo'];
	$SIS_where.= ' AND bodegas_arriendos_facturacion.Devolucion_Semana<'.semana_actual();
	$SIS_where.= ' AND bodegas_arriendos_facturacion.Devolucion_ano='.ano_actual();
	$SIS_order = 'bodegas_arriendos_facturacion.Devolucion_fecha DESC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'bodegas_arriendos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo 'Listado de Arriendos de la bodega '.$arrProductos[0]['Bodega'].' ('.$arrProductos[0]['Tipo'].')'; ?></h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Equipo Arrendado</th>
							<th>Tiempo</th>
							<th width="10">Valor</th>
							<th width="10">Fecha Solicitud</th>
							<th width="10">Fecha Devolucion</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrProductos as $productos) { ?>
							<tr class="odd">
								<td><?php echo $productos['NombreProd']; ?></td>
								<?php if(isset($_GET['idTipo'])&&$_GET['idTipo']==1){ ?>
									<td><?php echo Cantidades_decimales_justos($productos['Cantidad_ing']).' '.$productos['UnidadMedida']; ?></td>
								<?php }elseif(isset($_GET['idTipo'])&&$_GET['idTipo']==2){ ?>
									<td><?php echo Cantidades_decimales_justos($productos['Cantidad_eg']).' '.$productos['UnidadMedida']; ?></td>
								<?php } ?>
								<td align="right"><?php echo Valores($productos['ValorTotal'], 0); ?></td>
								<td><?php echo fecha_estandar($productos['Creacion_fecha']); ?></td>
								<td><?php echo fecha_estandar($productos['Devolucion_fecha']); ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_arriendos.php?view='.simpleEncode($productos['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	$z = "bodegas_arriendos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']; 
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z .= " AND usuarios_bodegas_arriendos.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
					if(isset($idBodega)){    $x1  = $idBodega;  }else{$x1  = '';}
					if(isset($idTipo)){      $x2  = $idTipo;    }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Bodega','idBodega', $x1, 2, 'idBodega', 'Nombre', 'bodegas_arriendos_listado', 'usuarios_bodegas_arriendos', $z, $dbConn);
					$Form_Inputs->form_select('Tipo Movimiento','idTipo', $x2, 2, 'idTipo', 'Nombre', 'bodegas_arriendos_facturacion_tipo', 0, '', $dbConn);
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
