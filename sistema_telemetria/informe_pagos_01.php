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
$original = "informe_pagos_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){    $search .="&idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){         $search .="&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$search .="&f_creacion_inicio=".$_GET['f_creacion_inicio'];
	$search .="&f_creacion_termino=".$_GET['f_creacion_termino'];
}
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
/**********************************************************/

//Variable de busqueda
$z1 = "bodegas_arriendos_facturacion.idEstado=1";
$z2 = "bodegas_insumos_facturacion.idEstado=1";
$z3 = "bodegas_productos_facturacion.idEstado=1";
$z4 = "bodegas_servicios_facturacion.idEstado=1";
//Verifico el tipo de usuario que esta ingresando
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico que sean solo compras
$z1.=" AND (bodegas_arriendos_facturacion.idTipo=1 OR bodegas_arriendos_facturacion.idTipo=10)";
$z2.=" AND (bodegas_insumos_facturacion.idTipo=1 OR bodegas_insumos_facturacion.idTipo=10)";
$z3.=" AND (bodegas_productos_facturacion.idTipo=1 OR bodegas_productos_facturacion.idTipo=10)";
$z4.=" AND (bodegas_servicios_facturacion.idTipo=1 OR bodegas_servicios_facturacion.idTipo=10)";	

if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  
	$z1.=" AND bodegas_arriendos_facturacion.idProveedor=".$_GET['idProveedor'];
	$z2.=" AND bodegas_insumos_facturacion.idProveedor=".$_GET['idProveedor'];
	$z3.=" AND bodegas_productos_facturacion.idProveedor=".$_GET['idProveedor'];
	$z4.=" AND bodegas_servicios_facturacion.idProveedor=".$_GET['idProveedor'];
}
if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$z2.=" AND bodegas_insumos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$z3.=" AND bodegas_productos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$z4.=" AND bodegas_servicios_facturacion.idDocumentos=".$_GET['idDocumentos'];
}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       
	$z1.=" AND bodegas_arriendos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z2.=" AND bodegas_insumos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z3.=" AND bodegas_productos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z4.=" AND bodegas_servicios_facturacion.N_Doc=".$_GET['N_Doc'];
}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
}


$table_1 = 'bodegas_arriendos_facturacion';
$table_2 = 'bodegas_insumos_facturacion';
$table_3 = 'bodegas_productos_facturacion';
$table_4 = 'bodegas_servicios_facturacion';

$arrTipo1 = array();
$arrTipo2 = array();
$arrTipo3 = array();
$arrTipo4 = array();

$arrTipo1 = db_select_array (false, $table_1.'.idFacturacion,'.$table_1.'.Creacion_fecha,'.$table_1.'.Pago_fecha,'.$table_1.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,proveedor_listado.Nombre AS Proveedor,'.$table_1.'.MontoPagado,'.$table_1.'.ValorTotal', $table_1, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_1.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_1.'.idDocumentos LEFT JOIN `proveedor_listado` ON proveedor_listado.idProveedor = '.$table_1.'.idProveedor', $z1, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo1');
$arrTipo2 = db_select_array (false, $table_2.'.idFacturacion,'.$table_2.'.Creacion_fecha,'.$table_2.'.Pago_fecha,'.$table_2.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,proveedor_listado.Nombre AS Proveedor,'.$table_2.'.MontoPagado,'.$table_2.'.ValorTotal', $table_2, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_2.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_2.'.idDocumentos LEFT JOIN `proveedor_listado` ON proveedor_listado.idProveedor = '.$table_2.'.idProveedor', $z2, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo2');
$arrTipo3 = db_select_array (false, $table_3.'.idFacturacion,'.$table_3.'.Creacion_fecha,'.$table_3.'.Pago_fecha,'.$table_3.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,proveedor_listado.Nombre AS Proveedor,'.$table_3.'.MontoPagado,'.$table_3.'.ValorTotal', $table_3, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_3.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_3.'.idDocumentos LEFT JOIN `proveedor_listado` ON proveedor_listado.idProveedor = '.$table_3.'.idProveedor', $z3, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo3');
$arrTipo4 = db_select_array (false, $table_4.'.idFacturacion,'.$table_4.'.Creacion_fecha,'.$table_4.'.Pago_fecha,'.$table_4.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,proveedor_listado.Nombre AS Proveedor,'.$table_4.'.MontoPagado,'.$table_4.'.ValorTotal', $table_4, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_4.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_4.'.idDocumentos LEFT JOIN `proveedor_listado` ON proveedor_listado.idProveedor = '.$table_4.'.idProveedor', $z4, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo4');






?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Proveedor</th>
						<th>Documento</th>
						<th>Fecha de Ingreso</th>
						<th>Fecha de Pago</th>
						<th>Valor Total</th>
						<th>Monto Pagado</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd"><td style="background-color:#7F7F7F" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>"><strong>Arriendos</strong></td></tr>
					<?php
						//variables
						$Total_ValorTotal  = 0;
						$Total_MontoPagado = 0;
						$Sub_ValorTotal    = 0;
						$Sub_MontoPagado   = 0;
						//se recorre
						foreach ($arrTipo1 as $tipo) {
						//Sumo
						$Total_ValorTotal  = $Total_ValorTotal + $tipo['ValorTotal'];
						$Total_MontoPagado = $Total_MontoPagado + $tipo['MontoPagado'];
						$Sub_ValorTotal    = $Sub_ValorTotal + $tipo['ValorTotal'];
						$Sub_MontoPagado   = $Sub_MontoPagado + $tipo['MontoPagado'];	
						?>
						<tr class="odd">
							<td><?php echo $tipo['Proveedor']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<td align="right"><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr style="background-color:#DDD">
						<td colspan="4">Subtotal</td>
						<td align="right"><?php echo Valores($Sub_ValorTotal, 0); ?></td>
						<td align="right"><?php echo Valores($Sub_MontoPagado, 0); ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td></td><?php } ?>
						<td></td>
					</tr>

					<tr class="odd"><td style="background-color:#7F7F7F" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>"><strong>Insumos</strong></td></tr>
					<?php
						//variables
						$Sub_ValorTotal    = 0;
						$Sub_MontoPagado   = 0;
						//se recorre
						foreach ($arrTipo2 as $tipo) {
						//Sumo
						$Total_ValorTotal  = $Total_ValorTotal + $tipo['ValorTotal'];
						$Total_MontoPagado = $Total_MontoPagado + $tipo['MontoPagado'];
						$Sub_ValorTotal    = $Sub_ValorTotal + $tipo['ValorTotal'];
						$Sub_MontoPagado   = $Sub_MontoPagado + $tipo['MontoPagado'];	
						?>
						<tr class="odd">
							<td><?php echo $tipo['Proveedor']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<td align="right"><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr style="background-color:#DDD">
						<td colspan="4">Subtotal</td>
						<td align="right"><?php echo Valores($Sub_ValorTotal, 0); ?></td>
						<td align="right"><?php echo Valores($Sub_MontoPagado, 0); ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td></td><?php } ?>
						<td></td>
					</tr>

					<tr class="odd"><td style="background-color:#7F7F7F" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>"><strong>Productos</strong></td></tr>
					<?php
						//variables
						$Sub_ValorTotal    = 0;
						$Sub_MontoPagado   = 0;
						//se recorre
						foreach ($arrTipo3 as $tipo) {
						//Sumo
						$Total_ValorTotal  = $Total_ValorTotal + $tipo['ValorTotal'];
						$Total_MontoPagado = $Total_MontoPagado + $tipo['MontoPagado'];
						$Sub_ValorTotal    = $Sub_ValorTotal + $tipo['ValorTotal'];
						$Sub_MontoPagado   = $Sub_MontoPagado + $tipo['MontoPagado'];	
						?>
						<tr class="odd">
							<td><?php echo $tipo['Proveedor']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<td align="right"><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr style="background-color:#DDD">
						<td colspan="4">Subtotal</td>
						<td align="right"><?php echo Valores($Sub_ValorTotal, 0); ?></td>
						<td align="right"><?php echo Valores($Sub_MontoPagado, 0); ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td></td><?php } ?>
						<td></td>
					</tr>

					<tr class="odd"><td style="background-color:#7F7F7F" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>"><strong>Servicios</strong></td></tr>
					<?php
						//variables
						$Sub_ValorTotal    = 0;
						$Sub_MontoPagado   = 0;
						//se recorre
						foreach ($arrTipo4 as $tipo) {
						//Sumo
						$Total_ValorTotal  = $Total_ValorTotal + $tipo['ValorTotal'];
						$Total_MontoPagado = $Total_MontoPagado + $tipo['MontoPagado'];
						$Sub_ValorTotal    = $Sub_ValorTotal + $tipo['ValorTotal'];
						$Sub_MontoPagado   = $Sub_MontoPagado + $tipo['MontoPagado'];	
						?>
						<tr class="odd">
							<td><?php echo $tipo['Proveedor']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<td align="right"><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr style="background-color:#DDD">
						<td colspan="4">Subtotal</td>
						<td align="right"><?php echo Valores($Sub_ValorTotal, 0); ?></td>
						<td align="right"><?php echo Valores($Sub_MontoPagado, 0); ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td></td><?php } ?>
						<td></td>
					</tr>
					<tr style="background-color:#DDD">
						<td colspan="4">Total</td>
						<td align="right"><?php echo Valores($Total_ValorTotal, 0); ?></td>
						<td align="right"><?php echo Valores($Total_MontoPagado, 0); ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td></td><?php } ?>
						<td></td>
					</tr>
	
					                 
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

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
				if(isset($idProveedor)){          $x1  = $idProveedor;         }else{$x1  = '';}
				if(isset($idDocumentos)){         $x2  = $idDocumentos;        }else{$x2  = '';}
				if(isset($N_Doc)){                $x3  = $N_Doc;               }else{$x3  = '';}
				if(isset($f_creacion_inicio)){    $x4  = $f_creacion_inicio;   }else{$x4  = '';}
				if(isset($f_creacion_termino)){   $x5  = $f_creacion_termino;  }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Emision');
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $z, '', $dbConn);
				$Form_Inputs->form_select('Tipo Documento','idDocumentos', $x2, 2, 'idDocumentos', 'Nombre', 'core_documentos_mercantiles', 'idDocumentos=2 OR idDocumentos=4 OR idDocumentos=5', '', $dbConn);
				$Form_Inputs->form_input_number('N° Documento', 'N_Doc', $x3, 1);
				$Form_Inputs->form_date('Fecha Creacion Desde','f_creacion_inicio', $x4, 1);
				$Form_Inputs->form_date('Fecha Creacion Hasta','f_creacion_termino', $x5, 1);

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
