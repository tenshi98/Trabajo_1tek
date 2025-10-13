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
$original = "pago_boletas_proveedor_reversa.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
/************************************************************/
//formulario para borrar
if (!empty($_GET['del_idPago'])){
	//Llamamos al formulario
	$form_trabajo= 'del_pagos';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_boletas_proveedores_reversa.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['reversa'])){ $error['reversa'] = 'sucess/Pago Reversado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	pagos_boletas_empresas.idPago,
	proveedor_listado.Nombre AS Proveedor,
	sistema_documentos_pago.Nombre AS DocumentoPago,
	pagos_boletas_empresas.N_DocPago AS DocumentoPagoNumero,
	pagos_boletas_empresas.montoPactado AS DocumentoMontoPactado,
	pagos_boletas_empresas.MontoPagado AS DocumentoMontoPagado,
	pagos_boletas_empresas.idFacturacion';
	$SIS_join  = '
	LEFT JOIN `proveedor_listado`         ON proveedor_listado.idProveedor       = pagos_boletas_empresas.idProveedor
	LEFT JOIN `sistema_documentos_pago`   ON sistema_documentos_pago.idDocPago   = pagos_boletas_empresas.idDocPago';
	$SIS_where = 'pagos_boletas_empresas.idPago!=0';
	if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){	    $SIS_where .= ' AND pagos_boletas_empresas.idDocPago='.$_GET['idDocPago'];}
	if(isset($_GET['N_DocPago'])&&$_GET['N_DocPago']!=''){	    $SIS_where .= ' AND pagos_boletas_empresas.N_DocPago='.$_GET['N_DocPago'];}
	if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){	$SIS_where .= ' AND pagos_boletas_empresas.idProveedor='.$_GET['idProveedor'];}
	$SIS_order = 0;
	$arrBoletas = array();
	$arrBoletas = db_select_array (false, $SIS_query, 'pagos_boletas_empresas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBoletas');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Boletas Pagadas</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Proveedor</th>
							<th>Facturado</th>
							<th>Pagado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						if ($arrBoletas!=false && !empty($arrBoletas) && $arrBoletas!='') {
							//llamamos a la función para filtrar los datos
							filtrar($arrBoletas, 'DocumentoPagoNumero');
							//recorremos el array para imprimirlo con formato HTML
							foreach($arrBoletas as $menu=>$productos) { ?>
								<tr class="odd">
									<td colspan="3" style="background-color: #BFBFBF;"><?php echo $productos[0]['DocumentoPago'].' '.$menu; ?></td>
									<td style="background-color: #BFBFBF;">
										<div class="btn-group" style="width: 35px;" >
											<?php if ($rowlevel['level']>=4){
												$ubicacion = $location.'&submit_filter=Filtrar&del_idPago='.simpleEncode($productos[0]['idPago'], fecha_actual()).'&idFacturacion='.simpleEncode($productos[0]['idFacturacion'], fecha_actual());
												$dialogo   = '¿Realmente deseas eliminar el pago '.$productos[0]['DocumentoPago'].' '.$menu.'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-exchange" aria-hidden="true"></i></a>
											<?php } ?>
										</div>
									</td>
								</tr>
								<?php foreach ($productos as $tipo){ ?>
									<tr class="odd">
										<td><?php echo $tipo['Proveedor']; ?></td>
										<td align="right"><?php echo valores($tipo['DocumentoMontoPactado'], 0); ?></td>
										<td align="right"><?php echo valores($tipo['DocumentoMontoPagado'], 0); ?></td>
										<td>
											<div class="btn-group" style="width: 35px;" >
												<a href="view_boleta_honorarios.php?view=<?php echo simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $original; ?>" class="btn btn-danger pull-right margin_form_btn" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
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
					if(isset($idDocPago)){     $x1  = $idDocPago;     }else{$x1  = '';}
					if(isset($N_DocPago)){     $x2  = $N_DocPago;     }else{$x2  = '';}
					if(isset($idProveedor)){   $x3  = $idProveedor;   }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Documento de Pago','idDocPago', $x1, 1, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
					$Form_Inputs->form_input_number('N° Documento de Pago', 'N_DocPago', $x2, 1);
					$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x3, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);

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
