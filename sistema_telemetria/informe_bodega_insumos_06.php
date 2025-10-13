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
$original = "informe_bodega_insumos_06.php";
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
	/*******************************************************/
	//variables
	$ano_pasado = ano_actual()-1;
	$concepto   = ' por concepto de egreso';
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	bodegas_insumos_facturacion_existencias.Creacion_ano,
	bodegas_insumos_facturacion_existencias.Creacion_mes,
	SUM(bodegas_insumos_facturacion_existencias.ValorTotal) AS Valor,
	insumos_listado.idCategoria';
	$SIS_join  = 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = bodegas_insumos_facturacion_existencias.idProducto';
	$SIS_where = 'bodegas_insumos_facturacion_existencias.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Creacion_ano >= '.$ano_pasado;
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.idTipo = 6';
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.idBodega = '.$_GET['idBodegaOrigen'];
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_ing=0';
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_eg!=0';
	$SIS_where.= ' GROUP BY bodegas_insumos_facturacion_existencias.Creacion_ano,bodegas_insumos_facturacion_existencias.Creacion_mes,insumos_listado.idCategoria';
	$SIS_order = 'bodegas_insumos_facturacion_existencias.Creacion_ano ASC';
	$SIS_order.= ', bodegas_insumos_facturacion_existencias.Creacion_mes ASC';
	$SIS_order.= ', insumos_listado.idCategoria ASC';
	$arrExistencias = array();
	$arrExistencias = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrExistencias');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idCategoria, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'Nombre ASC';
	$arrCategoria = array();
	$arrCategoria = db_select_array (false, $SIS_query, 'sistema_productos_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategoria');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	$SIS_join  = '';
	$SIS_where = 'idBodega='.$_GET['idBodegaOrigen'];
	$rowBodega = db_select_data (false, $SIS_query, 'bodegas_insumos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowBodega');

	/****************************************************/
	$mes = array();
	foreach ($arrExistencias as $existencias) {
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = 0;}
		$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] + $existencias['Valor'];									
	}

	/****************************************************/
	$xmes = mes_actual();
	$xaño = ano_actual();
	$grafico = array();
	for ($xcontador = 12; $xcontador > 0; $xcontador--) {

		if($xmes>0){
			$grafico[$xcontador]['mes'] = $xmes;
			$grafico[$xcontador]['año'] = $xaño;
			//recorro
			foreach ($arrCategoria as $cat) {
				if(isset($mes[$xaño][$xmes][$cat['idCategoria']])){ $grafico[$xcontador][$cat['idCategoria']] = $mes[$xaño][$xmes][$cat['idCategoria']];}else{$grafico[$xcontador][$cat['idCategoria']] = 0;};
			}

		}else{
			$xmes = 12;
			$xaño = $xaño-1;
			$grafico[$xcontador]['mes'] = $xmes;
			$grafico[$xcontador]['año'] = $xaño;
			//recorro
			foreach ($arrCategoria as $cat) {
				if(isset($mes[$xaño][$xmes][$cat['idCategoria']])){ $grafico[$xcontador][$cat['idCategoria']] = $mes[$xaño][$xmes][$cat['idCategoria']];}else{$grafico[$xcontador][$cat['idCategoria']] = 0;};
			}
		}
		$xmes = $xmes-1;
	}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Traspasos <?php echo $concepto.' de la bodega '.$rowBodega['Nombre']; ?></h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Categoria</th>
							<th><?php echo numero_a_mes_corto($grafico[1]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[2]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[3]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[4]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[5]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[6]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[7]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[8]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[9]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[10]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[11]['mes']); ?></th>
							<th><?php echo numero_a_mes_corto($grafico[12]['mes']); ?></th>
							<th>SubTotal</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						//Variables
						$Total = 0;
						foreach ($arrCategoria as $cat) {
							$SubTotal = 0;
							?>
							<tr class="odd">
								<td><?php echo $cat['Nombre'];  ?></td>
								<td align="right"><?php echo valores($grafico[1][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[1][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[2][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[2][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[3][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[3][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[4][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[4][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[5][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[5][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[6][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[6][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[7][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[7][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[8][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[8][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[9][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[9][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[10][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[10][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[11][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[11][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($grafico[12][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[12][$cat['idCategoria']]; ?></td>
								<td align="right"><?php echo valores($SubTotal, 0); $Total = $Total + $SubTotal; ?></td>
							</tr>
						<?php } ?>
						<tr class="odd">
							<td align="right" colspan="13"><strong>Total General</strong></td>
							<td align="right"><?php echo valores($Total, 0); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<?php
	/*******************************************************/
	//Variables
	$concepto = ' por concepto de ingreso';
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	bodegas_insumos_facturacion.idBodegaDestino,
	bodegas_insumos_facturacion_existencias.Creacion_ano,
	bodegas_insumos_facturacion_existencias.Creacion_mes,
	SUM(bodegas_insumos_facturacion_existencias.ValorTotal) AS Valor,
	insumos_listado.idCategoria';
	$SIS_join  = '
	LEFT JOIN `insumos_listado`                ON insumos_listado.idProducto                   = bodegas_insumos_facturacion_existencias.idProducto
	LEFT JOIN `bodegas_insumos_facturacion`    ON bodegas_insumos_facturacion.idFacturacion    = bodegas_insumos_facturacion_existencias.idFacturacion';
	$SIS_where = 'bodegas_insumos_facturacion_existencias.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Creacion_ano >='.$ano_pasado;
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.idTipo = 6';
	$SIS_where.= ' AND bodegas_insumos_facturacion.idBodegaOrigen = '.$_GET['idBodegaOrigen'];
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_ing!=0';
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_eg=0';
	$SIS_where.= ' GROUP BY bodegas_insumos_facturacion.idBodegaDestino,bodegas_insumos_facturacion_existencias.Creacion_ano,bodegas_insumos_facturacion_existencias.Creacion_mes,insumos_listado.idCategoria';
	$SIS_order = 'bodegas_insumos_facturacion.idBodegaDestino ASC';
	$SIS_order.= ', bodegas_insumos_facturacion_existencias.Creacion_ano ASC';
	$SIS_order.= ', bodegas_insumos_facturacion_existencias.Creacion_mes ASC';
	$SIS_order.= ', insumos_listado.idCategoria ASC';
	$arrExistencias = array();
	$arrExistencias = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrExistencias');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idBodega, Nombre';
	$SIS_join  = '';
	$SIS_where = 'idBodega!='.$_GET['idBodegaOrigen'];
	$SIS_order = 'Nombre ASC';
	$arrBodegas = array();
	$arrBodegas = db_select_array (false, $SIS_query, 'bodegas_insumos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBodegas');

	/********************************************************/
	//recorro los meses y los guardo temporalmente
	$mes = array();
	foreach ($arrExistencias as $existencias) {
		if(!isset($mes[$existencias['idBodegaDestino']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']])){ $mes[$existencias['idBodegaDestino']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = 0;}
		$mes[$existencias['idBodegaDestino']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = $mes[$existencias['idBodegaDestino']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] + $existencias['Valor'];									
	}

	/********************************************************/
	//Variables

	$grafico = array();
	//recorro las bodegas
	foreach ($arrBodegas as $bod) {
		$xmes = mes_actual();
		$xaño = ano_actual();
		$xbodegas = $bod['idBodega'];
		//recorro los datos
		for ($xcontador = 12; $xcontador > 0; $xcontador--) {
			if($xmes>0){
				$grafico[$xbodegas][$xcontador]['mes'] = $xmes;
				$grafico[$xbodegas][$xcontador]['año'] = $xaño;
				//recorro
				foreach ($arrCategoria as $cat) {
					if(isset($mes[$xbodegas][$xaño][$xmes][$cat['idCategoria']])){ $grafico[$xbodegas][$xcontador][$cat['idCategoria']] = $mes[$xbodegas][$xaño][$xmes][$cat['idCategoria']];}else{$grafico[$xbodegas][$xcontador][$cat['idCategoria']] = 0;};
				}
			}else{
				$xmes = 12;
				$xaño = $xaño-1;
				$grafico[$xbodegas][$xcontador]['mes'] = $xmes;
				$grafico[$xbodegas][$xcontador]['año'] = $xaño;
				//recorro
				foreach ($arrCategoria as $cat) {
					if(isset($mes[$xbodegas][$xaño][$xmes][$cat['idCategoria']])){ $grafico[$xbodegas][$xcontador][$cat['idCategoria']] = $mes[$xbodegas][$xaño][$xmes][$cat['idCategoria']];}else{$grafico[$xbodegas][$xcontador][$cat['idCategoria']] = 0;};
				}
			}
			$xmes = $xmes-1;
		}
	}

	/*********************************/
	foreach ($arrBodegas as $bod) {

		//Sumo
		$Total = 0;
		foreach ($arrCategoria as $cat) {
			$SubTotal = 0;
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][1][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][2][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][3][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][4][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][5][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][6][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][7][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][8][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][9][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][10][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][11][$cat['idCategoria']];
			$SubTotal = $SubTotal+$grafico[$bod['idBodega']][12][$cat['idCategoria']];
			$Total = $Total + $SubTotal;
		}
		//Verifico que tenga un total
		if($Total!=0){ ?>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Traspasos <?php echo $concepto.' a la Bodega '.$bod['Nombre']; ?></h5>
					</header>
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Categoria</th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][1]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][2]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][3]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][4]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][5]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][6]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][7]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][8]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][9]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][10]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][11]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$bod['idBodega']][12]['mes']); ?></th>
									<th>SubTotal</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php
								//Variables
								$Total = 0;
								foreach ($arrCategoria as $cat) {
									$SubTotal = 0;
									?>
									<tr class="odd">
										<td><?php echo $cat['Nombre'];  ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][1][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][1][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][2][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][2][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][3][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][3][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][4][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][4][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][5][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][5][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][6][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][6][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][7][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][7][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][8][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][8][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][9][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][9][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][10][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][10][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][11][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][11][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($grafico[$bod['idBodega']][12][$cat['idCategoria']], 0);$SubTotal = $SubTotal+$grafico[$bod['idBodega']][12][$cat['idCategoria']]; ?></td>
										<td align="right"><?php echo valores($SubTotal, 0); $Total = $Total + $SubTotal; ?></td>
									</tr>
								<?php } ?>
								<tr class="odd">
									<td align="right" colspan="13"><strong>Total General</strong></td>
									<td align="right"><?php echo valores($Total, 0); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php
		}
	} ?>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	$z1 = "bodegas_insumos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z1 .= " AND usuarios_bodegas_insumos.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
					if(isset($idBodegaOrigen)){       $x1  = $idBodegaOrigen;        }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Bodega Origen','idBodegaOrigen', $x1, 2, 'idBodega', 'Nombre', 'bodegas_insumos_listado', 'usuarios_bodegas_insumos', $z1, $dbConn);

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
