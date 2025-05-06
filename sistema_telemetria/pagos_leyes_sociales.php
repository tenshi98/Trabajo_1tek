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
$original = "pagos_leyes_sociales.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Periodo_Ano']) && $_GET['Periodo_Ano']!=''){    $location .= "&Periodo_Ano=".$_GET['Periodo_Ano'];    $search .= "&Periodo_Ano=".$_GET['Periodo_Ano'];}
if(isset($_GET['Periodo_Mes']) && $_GET['Periodo_Mes']!=''){    $location .= "&Periodo_Mes=".$_GET['Periodo_Mes'];    $search .= "&Periodo_Mes=".$_GET['Periodo_Mes'];}
if(isset($_GET['Pago_fecha']) && $_GET['Pago_fecha']!=''){      $location .= "&Pago_fecha=".$_GET['Pago_fecha'];      $search .= "&Pago_fecha=".$_GET['Pago_fecha'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){ $location .= "&idUsuario=".$_GET['idUsuario'];        $search .= "&idUsuario=".$_GET['idUsuario'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_pago';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_pago';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';
}
//formulario para editar
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_pago';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file_pago';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file_pago';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_pagos'])){
	//Llamamos al formulario
	$form_trabajo= 'pagos_listado';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';
}
/**********************************************/
if (!empty($_GET['PagoSocial'])){
	//Llamamos al formulario
	$form_trabajo= 'PagoSocial';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_new_pago'])){
	//Llamamos al formulario
	$form_trabajo= 'add_new_pago';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_leyes_sociales.php';

}


/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Pago Realizado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Pago Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Pago Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['newPago'])){
//se dibujan los inputs
$Form_Inputs = new Inputs();

// consulto los datos
$rowData = db_select_data (false, 'AFP_MontoPago,SALUD_MontoPago,SEGURIDAD_MontoPago,TotalGeneral,TotalPagoGeneral', 'pagos_leyes_sociales', '', 'idFactSocial ='.$_GET['newPago'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
				
$arrFormaPago = array();
$arrFormaPago = db_select_array (false, 'sistema_documentos_pago.Nombre AS DocPago,pagos_leyes_sociales_formas_pago.Creacion_fecha,pagos_leyes_sociales_formas_pago.idTipo,pagos_leyes_sociales_formas_pago.N_DocPago,pagos_leyes_sociales_formas_pago.F_Pago,pagos_leyes_sociales_formas_pago.Monto,usuarios_listado.Nombre AS Usuario','pagos_leyes_sociales_formas_pago', 'LEFT JOIN `sistema_documentos_pago`     ON sistema_documentos_pago.idDocPago   = pagos_leyes_sociales_formas_pago.idDocPago LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = pagos_leyes_sociales_formas_pago.idUsuario', 'pagos_leyes_sociales_formas_pago.idFactSocial ='.$_GET['newPago'], 'pagos_leyes_sociales_formas_pago.idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrFormaPago');

//Total pagado hasta ahora
$AFP_Pagado        = 0;
$SALUD_Pagado      = 0;
$SEGURIDAD_Pagado  = 0;

//recorro los pagos
if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
	foreach ($arrFormaPago as $pago) {
		if(isset($pago['idTipo'])&&$pago['idTipo']!=''){
			switch ($pago['idTipo']) {
				case 1: $AFP_Pagado       = $AFP_Pagado + $pago['Monto']; break;
				case 2: $SALUD_Pagado     = $SALUD_Pagado + $pago['Monto']; break;
				case 3: $SEGURIDAD_Pagado = $SEGURIDAD_Pagado + $pago['Monto']; break;

			}
		}
	}
}

//obtengo los saldos
$AFP_Total_deuda        = valores_comparables($rowData['AFP_MontoPago'] - $AFP_Pagado);
$SALUD_Total_deuda      = valores_comparables($rowData['SALUD_MontoPago'] - $SALUD_Pagado);
$SEGURIDAD_Total_deuda  = valores_comparables($rowData['SEGURIDAD_MontoPago'] - $SEGURIDAD_Pagado);

?>

<style>
input[type="date"].form-control{
    line-height: 12px;
}
</style>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Pagos</h5>
			</header>
			<div class="body">

				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
					<?php if($AFP_Total_deuda>0){ ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<p class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">AFP a Pagar <strong><?php echo valores($AFP_Total_deuda, 0); ?></strong></p>
							<a onclick="pago_afp_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Pago</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_pago_afp"></div>
					<?php } ?>

					<?php if($SALUD_Total_deuda>0){ ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<p class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Salud a Pagar <strong><?php echo valores($SALUD_Total_deuda, 0); ?></strong></p>
							<a onclick="pago_salud_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Pago</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_pago_salud"></div>
					<?php } ?>

					<?php if($SEGURIDAD_Total_deuda>0){ ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<p class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Seguridad a Pagar <strong><?php echo valores($SEGURIDAD_Total_deuda, 0); ?></strong></p>
							<a onclick="pago_seguridad_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Pago</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_pago_seguridad"></div>
					<?php } ?>
				
				
					<?php
					//Envio los saldos de cada tipo para validacion
					if(isset($AFP_Total_deuda)&&$AFP_Total_deuda>0){$Form_Inputs->input_hidden('AFP_Total_deuda', $AFP_Total_deuda, 2);}
					if(isset($SALUD_Total_deuda)&&$SALUD_Total_deuda>0){$Form_Inputs->input_hidden('SALUD_Total_deuda', $SALUD_Total_deuda, 2);}
					if(isset($SEGURIDAD_Total_deuda)&&$SEGURIDAD_Total_deuda>0){$Form_Inputs->input_hidden('SEGURIDAD_Total_deuda', $SEGURIDAD_Total_deuda, 2);}
					$Form_Inputs->input_hidden('idFactSocial', $_GET['newPago'], 2);
					$Form_Inputs->input_hidden('Creacion_fecha', fecha_actual(), 2);
					$Form_Inputs->input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
	
					
					?>

					<div class="form-group" style="margin-top:10px;">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_new_pago">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Pagos Realizados</h5>
			</header>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th colspan="8">Resumen</th>
						</tr>
					</thead>
					<tbody>
						<tr class="active">
							<td></td>
							<td><strong>Total a Pagar</strong></td>
							<td><strong>Forma de Pago</strong></td>
							<td><strong>Fecha ingreso</strong></td>
							<td><strong>Fecha de Vencimiento</strong></td>
							<td><strong>Usuario</strong></td>
							<td><strong>Monto Pagado</strong></td>
						</tr>
						<tr>
							<td class="meta-head">Administradora Fondos de Pensiones</td>
							<td align="right"><?php echo valores($rowData['AFP_MontoPago'], 0); ?></td>
							<td align="left">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==1){
											echo $pago['DocPago'];
											if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
											echo '<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==1){
											echo fecha_estandar($pago['Creacion_fecha']).'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==1){
											echo fecha_estandar($pago['F_Pago']).'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==1){
											echo $pago['Usuario'].'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==1){
											echo valores($pago['Monto'], 0).'<br/>';
										}
									}
								} ?>
							</td>
						</tr>
						<tr>
							<td class="meta-head">Salud</td>
							<td align="right"><?php echo valores($rowData['SALUD_MontoPago'], 0); ?></td>
							<td align="left">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==2){
											echo $pago['DocPago'];
											if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
											echo '<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==2){
											echo fecha_estandar($pago['Creacion_fecha']).'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==2){
											echo fecha_estandar($pago['F_Pago']).'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==2){
											echo $pago['Usuario'].'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==2){
											echo valores($pago['Monto'], 0).'<br/>';
										}
									}
								} ?>
							</td>
						</tr>
						<tr>
							<td class="meta-head">Seguridad</td>
							<td align="right"><?php echo valores($rowData['SEGURIDAD_MontoPago'], 0); ?></td>
							<td align="left">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==3){
											echo $pago['DocPago'];
											if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
											echo '<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==3){
											echo fecha_estandar($pago['Creacion_fecha']).'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==3){
											echo fecha_estandar($pago['F_Pago']).'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==3){
											echo $pago['Usuario'].'<br/>';
										}
									}
								} ?>
							</td>
							<td align="right">
								<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
									foreach ($arrFormaPago as $pago) {
										if(isset($pago['idTipo'])&&$pago['idTipo']==3){
											echo valores($pago['Monto'], 0).'<br/>';
										}
									}
								} ?>
							</td>
						</tr>
						<tr>
							<td class="meta-head"><strong>Totales</strong></td>
							<td align="right"><strong><?php echo valores($rowData['TotalGeneral'], 0); ?></strong></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td align="right"><strong><?php echo valores($rowData['TotalPagoGeneral'], 0); ?></strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div style="display: none;">

	<div id="clone_pago_afp" class="pago_afp_container">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->select('Documento de Pago','AFP_idDocPago[]', '',2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0,'',$dbConn); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('N° Documento de Pago','AFP_N_DocPago[]', '', 1); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_icon('date','F Vencimiento','AFP_F_Pago[]', '', 2, 'fa fa-calendar'); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('Monto','AFP_Monto[]', '', 2); ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 nopadding">
			<div class="form-group">
				<button class="btn btn-metis-1 tooltip remove_pago_afp" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div id="clone_pago_salud" class="pago_salud_container">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->select('Documento de Pago','SALUD_idDocPago[]', '',2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0,'',$dbConn); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('N° Documento de Pago','SALUD_N_DocPago[]', '', 1); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_icon('date','F Vencimiento','SALUD_F_Pago[]', '', 2, 'fa fa-calendar'); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('Monto','SALUD_Monto[]', '', 2); ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 nopadding">
			<div class="form-group">
				<button class="btn btn-metis-1 tooltip remove_pago_salud" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div id="clone_pago_seguridad" class="pago_seguridad_container">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->select('Documento de Pago','SEGURIDAD_idDocPago[]', '',2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0,'',$dbConn); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('N° Documento de Pago','SEGURIDAD_N_DocPago[]', '', 1); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_icon('date','F Vencimiento','SEGURIDAD_F_Pago[]', '', 2, 'fa fa-calendar'); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('Monto','SEGURIDAD_Monto[]', '', 2); ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 nopadding">
			<div class="form-group">
				<button class="btn btn-metis-1 tooltip remove_pago_seguridad" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

</div>

<script>
	let nPagoAFP       = 0;
	let nPagoSalud     = 0;
	let nPagoSeguridad = 0;

	/**********************************************************/
	//Se agrega cuartel
	function pago_afp_add() {
		//se incrementa en 1
		nPagoAFP++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_pago_afp');
		let objclone = document.getElementById('clone_pago_afp'),
		//se clonan los div
		clone_pago_afp = objclone.cloneNode(true);
		clone_pago_afp.id = 'new_pago_afp_'+nPagoAFP;
		//inserto dentro del div deseado
		objTo.appendChild(clone_pago_afp);
    } 
    /**********************************************************/
	//Se agrega cuartel
	function pago_salud_add() {
		//se incrementa en 1
		nPagoSalud++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_pago_salud');
		let objclone = document.getElementById('clone_pago_salud'),
		//se clonan los div
		clone_pago_salud = objclone.cloneNode(true);
		clone_pago_salud.id = 'new_pago_salud_'+nPagoSalud;
		//inserto dentro del div deseado
		objTo.appendChild(clone_pago_salud);
    }
	/**********************************************************/
	//Se agrega cuartel
	function pago_seguridad_add() {
		//se incrementa en 1
		nPagoSeguridad++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_pago_seguridad');
		let objclone = document.getElementById('clone_pago_seguridad'),
		//se clonan los div
		clone_pago_seguridad = objclone.cloneNode(true);
		clone_pago_seguridad.id = 'new_pago_seguridad_'+nPagoSeguridad;
		//inserto dentro del div deseado
		objTo.appendChild(clone_pago_seguridad);
    }

    /**********************************************************/
	//se eliminan filas
	$(document).on('click', '.remove_pago_afp', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().remove();
	});
	//se eliminan filas
	$(document).on('click', '.remove_pago_salud', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().remove();
	});
	//se eliminan filas
	$(document).on('click', '.remove_pago_seguridad', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().remove();
	});

</script>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addPago'])){
//se dibujan los inputs
$Form_Inputs = new Inputs();

?>

<style>
input[type="date"].form-control{
    line-height: 12px;
}
</style>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Pagos</h5>
			</header>
			<div class="body">

				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
					<?php if($_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago']!=0){ ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<p class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">AFP a Pagar <strong><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago'], 0); ?></strong></p>
							<a onclick="pago_afp_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Pago</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_pago_afp"></div>
					<?php } ?>

					<?php if($_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago']!=0){ ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<p class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Salud a Pagar <strong><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago'], 0); ?></strong></p>
							<a onclick="pago_salud_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Pago</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_pago_salud"></div>
					<?php } ?>

					<?php if($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago']!=0){ ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<p class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Seguridad a Pagar <strong><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago'], 0); ?></strong></p>
							<a onclick="pago_seguridad_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Pago</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_pago_seguridad"></div>
					<?php } ?>

					<div class="form-group" style="margin-top:10px;">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_pagos">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<div style="display: none;">

	<div id="clone_pago_afp" class="pago_afp_container">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->select('Documento de Pago','AFP_idDocPago[]', '',2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0,'',$dbConn); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('N° Documento de Pago','AFP_N_DocPago[]', '', 1); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_icon('date','F Vencimiento','AFP_F_Pago[]', '', 2, 'fa fa-calendar'); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('Monto','AFP_Monto[]', '', 2); ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 nopadding">
			<div class="form-group">
				<button class="btn btn-metis-1 tooltip remove_pago_afp" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div id="clone_pago_salud" class="pago_salud_container">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->select('Documento de Pago','SALUD_idDocPago[]', '',2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0,'',$dbConn); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('N° Documento de Pago','SALUD_N_DocPago[]', '', 1); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_icon('date','F Vencimiento','SALUD_F_Pago[]', '', 2, 'fa fa-calendar'); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('Monto','SALUD_Monto[]', '', 2); ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 nopadding">
			<div class="form-group">
				<button class="btn btn-metis-1 tooltip remove_pago_salud" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div id="clone_pago_seguridad" class="pago_seguridad_container">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->select('Documento de Pago','SEGURIDAD_idDocPago[]', '',2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0,'',$dbConn); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('N° Documento de Pago','SEGURIDAD_N_DocPago[]', '', 1); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_icon('date','F Vencimiento','SEGURIDAD_F_Pago[]', '', 2, 'fa fa-calendar'); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input_number('Monto','SEGURIDAD_Monto[]', '', 2); ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 nopadding">
			<div class="form-group">
				<button class="btn btn-metis-1 tooltip remove_pago_seguridad" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

</div>

<script>
	let nPagoAFP       = 0;
	let nPagoSalud     = 0;
	let nPagoSeguridad = 0;

	/**********************************************************/
	//Se agrega cuartel
	function pago_afp_add() {
		//se incrementa en 1
		nPagoAFP++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_pago_afp');
		let objclone = document.getElementById('clone_pago_afp'),
		//se clonan los div
		clone_pago_afp = objclone.cloneNode(true);
		clone_pago_afp.id = 'new_pago_afp_'+nPagoAFP;
		//inserto dentro del div deseado
		objTo.appendChild(clone_pago_afp);
    } 
    /**********************************************************/
	//Se agrega cuartel
	function pago_salud_add() {
		//se incrementa en 1
		nPagoSalud++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_pago_salud');
		let objclone = document.getElementById('clone_pago_salud'),
		//se clonan los div
		clone_pago_salud = objclone.cloneNode(true);
		clone_pago_salud.id = 'new_pago_salud_'+nPagoSalud;
		//inserto dentro del div deseado
		objTo.appendChild(clone_pago_salud);
    }
	/**********************************************************/
	//Se agrega cuartel
	function pago_seguridad_add() {
		//se incrementa en 1
		nPagoSeguridad++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_pago_seguridad');
		let objclone = document.getElementById('clone_pago_seguridad'),
		//se clonan los div
		clone_pago_seguridad = objclone.cloneNode(true);
		clone_pago_seguridad.id = 'new_pago_seguridad_'+nPagoSeguridad;
		//inserto dentro del div deseado
		objTo.appendChild(clone_pago_seguridad);
    }

    /**********************************************************/
	//se eliminan filas
	$(document).on('click', '.remove_pago_afp', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().remove();
	});
	//se eliminan filas
	$(document).on('click', '.remove_pago_salud', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().remove();
	});
	//se eliminan filas
	$(document).on('click', '.remove_pago_seguridad', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().remove();
	});

</script>

<div class="clearfix"></div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addFile'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Subir Archivo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php
				//Se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 1, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar datos basicos del egreso</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Periodo_Ano)){      $x1  = $Periodo_Ano;    }else{$x1  = $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano'];}
				if(isset($Periodo_Mes)){      $x2  = $Periodo_Mes;    }else{$x2  = $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes'];}
				if(isset($Pago_fecha)){       $x3  = $Pago_fecha;     }else{$x3  = $_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha'];}
				if(isset($Observaciones)){    $x4  = $Observaciones;  }else{$x4  = $_SESSION['pagos_leyes_fiscales_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('Periodo Año','Periodo_Ano', $x1, 2, 2016, ano_actual());
				$Form_Inputs->form_select_filter('Periodo Mes','Periodo_Mes', $x2, 2, 'idMes', 'Nombre', 'core_tiempo_meses', 0, 'idMes ASC', $dbConn);
				$Form_Inputs->form_date('Fecha Pago','Pago_fecha', $x3, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x4, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
$Form_Inputs = new Inputs();

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger dialogBox"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&PagoSocial=true';
		$dialogo   = '¿Realmente desea ingresar el documento, una vez realizada no podra realizar cambios?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Formulario de Pago</div>
	   
		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Usuario</td>
						<td><?php echo $_SESSION['pagos_leyes_sociales_basicos']['Usuario']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo</td>
						<td colspan="2"><?php echo  numero_a_mes($_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']).' de '.$_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Pago</td>
						<td colspan="2"><?php echo Fecha_estandar($_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Centro de Costo Penciones</td>
						<td><?php echo $_SESSION['pagos_leyes_sociales_basicos']['AFP_CC']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Centro de Costo Salud</td>
						<td><?php echo $_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Centro de Costo Seguridad</td>
						<td><?php echo $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td colspan="2"><?php echo Fecha_estandar($_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']); ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="table-responsive">
			<table id="items">
				<tbody>
					<tr>
						<th colspan="12">Administradora Fondos de Pensiones</th>
					</tr>
					<tr class="item-row fact_tittle">
						<td>Trabajador</td>
						<td width="10">RUT</td>
						<td width="10">Ingreso Imponible</td>
						<td width="10">Nombre AFP</td>
						<td width="10">Cotizacion Obligatoria</td>
						<td width="10">Seguro Invalidez</td>
						<td width="10">APV</td>
						<td width="10">Cuenta 2</td>
						<td width="10">Cotizacion Trabajo Pesado</td>
						<td width="10">AFC Trabajador</td>
						<td width="10">AFC Empleador</td>
						<td width="10">Total</td>
					</tr>
					<?php
					//Variables Totales columnas
					$Total_Col_1 = 0;
					$Total_Col_2 = 0;
					$Total_Col_3 = 0;
					$Total_Col_4 = 0;
					$Total_Col_5 = 0;
					$Total_Col_6 = 0;
					$Total_Col_7 = 0;
					$Total_Col_8 = 0;

					//recorro
					foreach ($_SESSION['pagos_leyes_sociales_trabajadores'] as $trab){
						//Totales Filas
						$Total = 0;
						$Total = $Total + $trab['AFP_Cotizacion'];
						$Total = $Total + $trab['AFP_SeguroInvalidez'];
						$Total = $Total + $trab['AFP_APV'];
						$Total = $Total + $trab['AFP_Cuenta2'];
						$Total = $Total + $trab['AFP_TrabajoPesado'];
						$Total = $Total + $trab['AFC_Empleador'];
						$Total = $Total + $trab['AFC_Trabajador'];
						//Totales Columnas
						$Total_Col_1 = $Total_Col_1 + $trab['AFP_Cotizacion'];
						$Total_Col_2 = $Total_Col_2 + $trab['AFP_SeguroInvalidez'];
						$Total_Col_3 = $Total_Col_3 + $trab['AFP_APV'];
						$Total_Col_4 = $Total_Col_4 + $trab['AFP_Cuenta2'];
						$Total_Col_5 = $Total_Col_5 + $trab['AFP_TrabajoPesado'];
						$Total_Col_6 = $Total_Col_6 + $trab['AFC_Empleador'];
						$Total_Col_7 = $Total_Col_7 + $trab['AFC_Trabajador'];
						$Total_Col_8 = $Total_Col_8 + $Total;
						?>
						<tr class="item-row linea_punteada">
							<td><?php echo $trab['TrabajadorNombre']; ?></td>
							<td><?php echo $trab['TrabajadorRut']; ?></td>
							<td align="right"><?php echo valores($trab['Sueldo'], 0); ?></td>
							<td><?php echo $trab['AFP_Nombre'].' ('.$trab['AFP_Porcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($trab['AFP_Cotizacion'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_SeguroInvalidez'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_APV'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_Cuenta2'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_TrabajoPesado'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFC_Empleador'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFC_Trabajador'], 0); ?></td>
							<td align="right"><?php echo valores($Total, 0); ?></td>
						</tr>
					<?php } ?>
					<?php
					//Se guarda el total a pagar
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotizacionOblig']  = $Total_Col_1;
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_SeguroInvalidez']  = $Total_Col_2;
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_APV']              = $Total_Col_3;
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_Cuenta_2']         = $Total_Col_4;
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotTrabajoPesado'] = $Total_Col_5;
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCTrabajador']    = $Total_Col_6;
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCEmpleador']     = $Total_Col_7;
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago']              = valores_comparables($Total_Col_8);
					?>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="4" align="right"><strong>Total</strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_5, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_6, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_7, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_8, 0); ?></strong></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="table-responsive">
			<table id="items">
				<tbody>
					<tr>
						<th colspan="7">Salud</th>
					</tr>
					<tr class="item-row fact_tittle">
						<td>Trabajador</td>
						<td width="10">RUT</td>
						<td width="10">Ingreso Imponible</td>
						<td width="10">Nombre Isapre/Fonasa</td>
						<td width="10">Cotizacion Legal</td>
						<td width="10">Cotizacion Adicional Voluntaria</td>
						<td width="10">Total</td>
					</tr>
					<?php
					//Variables Totales columnas
					$Total_Col_1 = 0;
					$Total_Col_2 = 0;
					$Total_Col_3 = 0;

					//recorro
					foreach ($_SESSION['pagos_leyes_sociales_trabajadores'] as $trab){
						//Totales Filas
						$Total = 0;
						$Total = $Total + $trab['Salud_Cotizacion'];
						$Total = $Total + $trab['Salud_Extra_Valor'];
						//Totales Columnas
						$Total_Col_1 = $Total_Col_1 + $trab['Salud_Cotizacion'];
						$Total_Col_2 = $Total_Col_2 + $trab['Salud_Extra_Valor'];
						$Total_Col_3 = $Total_Col_3 + $Total;
						?>
						<tr class="item-row linea_punteada">
							<td><?php echo $trab['TrabajadorNombre']; ?></td>
							<td><?php echo $trab['TrabajadorRut']; ?></td>
							<td align="right"><?php echo valores($trab['Sueldo'], 0); ?></td>
							<td><?php echo $trab['Salud_Nombre'].' ('.$trab['Salud_Porcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($trab['Salud_Cotizacion'], 0); ?></td>
							<td align="right"><?php echo valores($trab['Salud_Extra_Valor'], 0).' ('.$trab['Salud_Extra_Porcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($Total, 0); ?></td>
						</tr>
					<?php } ?>
					<?php
					//Se guarda el total a pagar
					$_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionLegal']     = $Total_Col_1;
					$_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionAdicional'] = $Total_Col_2;
					$_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago']                 = valores_comparables($Total_Col_3);
					?>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="4" align="right"><strong>Total</strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_3, 0); ?></strong></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="table-responsive">
			<table id="items">
				<tbody>
					<tr>
						<th colspan="7">Seguridad</th>
					</tr>
					<tr class="item-row fact_tittle">
						<td>Trabajador</td>
						<td width="10">RUT</td>
						<td width="10">Ingreso Imponible</td>
						<td width="10">Nombre Mutual</td>
						<td width="10">Cotizacion Legal</td>
						<td width="10">Total</td>
					</tr>
					<?php
					//Variables Totales columnas
					$Total_Col_1 = 0;
					$Total_Col_2 = 0;

					//recorro
					foreach ($_SESSION['pagos_leyes_sociales_trabajadores'] as $trab){
						//Totales Filas
						$Total = 0;
						$Total = $Total + $trab['MutualValor'];
						//Totales Columnas
						$Total_Col_1 = $Total_Col_1 + $trab['MutualValor'];
						$Total_Col_2 = $Total_Col_2 + $Total;
						?>
						<tr class="item-row linea_punteada">
							<td><?php echo $trab['TrabajadorNombre']; ?></td>
							<td><?php echo $trab['TrabajadorRut']; ?></td>
							<td align="right"><?php echo valores($trab['Sueldo'], 0); ?></td>
							<td><?php echo $trab['MutualNombre'].' ('.$trab['MutualPorcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($trab['MutualValor'], 0); ?></td>
							<td align="right"><?php echo valores($Total, 0); ?></td>
						</tr>
					<?php } ?>
					<?php
					//Se guarda el total a pagar
					$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_Total_CotizacionLegal'] = $Total_Col_1;
					$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago']             = valores_comparables($Total_Col_2);
					?>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="4" align="right"><strong>Total</strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($Total_Col_2, 0); ?></strong></td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<table id="items">
			<tbody>
				<tr class="item-row fact_tittle">
					<td class="meta-head" colspan="4"><strong>Resumen</strong></td>
					<td class="meta-head">
						<a href="<?php echo $location.'&addPago=true' ?>" title="Agregar Pago" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Pago</a>
					</td>
				</tr>
				<tr class="item-row fact_tittle">
					<td><strong></strong></td>
					<td><strong>Total a Pagar</strong></td>
					<td><strong>Forma de Pago</strong></td>
					<td><strong>Fecha de Vencimiento</strong></td>
					<td><strong>Monto Pagado</strong></td>
				</tr>
				<tr>
					<td class="fact_tittle">Administradora Fondos de Pensiones</td>
					<td align="right"><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago'], 0); ?></td>
					<td align="left">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][1])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][1] as $key => $pago){
									echo $pago['DocPago'];
									if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
									echo '<br/>';
								}
							}
						}
						?>
					</td>
					<td align="right">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][1])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][1] as $key => $pago){
									echo fecha_estandar($pago['F_Pago']).'<br/>';
								}
							}
						}
						?>
					</td>
					<td align="right">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][1])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][1] as $key => $pago){
									echo valores($pago['Monto'], 0).'<br/>';
								}
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td class="fact_tittle">Salud</td>
					<td align="right"><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago'], 0); ?></td>
					<td align="left">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][2])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][2] as $key => $pago){
									echo $pago['DocPago'];
									if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
									echo '<br/>';
								}
							}
						}
						?>
					</td>
					<td align="right">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][2])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][2] as $key => $pago){
									echo fecha_estandar($pago['F_Pago']).'<br/>';
								}
							}
						}
						?>
					</td>
					<td align="right">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][2])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][2] as $key => $pago){
									echo valores($pago['Monto'], 0).'<br/>';
								}
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td class="fact_tittle">Seguridad</td>
					<td align="right"><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago'], 0); ?></td>
					<td align="left">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][3])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][3] as $key => $pago){
									echo $pago['DocPago'];
									if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
									echo '<br/>';
								}
							}
						}
						?>
					</td>
					<td align="right">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][3])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][3] as $key => $pago){
									echo fecha_estandar($pago['F_Pago']).'<br/>';
								}
							}
						}
						?>
					</td>
					<td align="right">
						<?php
						if($_SESSION['pagos_leyes_sociales_formas_pago']){
							if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][3])){
								foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][3] as $key => $pago){
									echo valores($pago['Monto'], 0).'<br/>';
								}
							}
						}
						?>
					</td>
				</tr>
				<?php
				$TotalGeneral = 0;
				$TotalGeneral = $TotalGeneral + $_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago'];
				$TotalGeneral = $TotalGeneral + $_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago'];
				$TotalGeneral = $TotalGeneral + $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago'];
				$_SESSION['pagos_leyes_sociales_basicos']['TotalGeneral'] = $TotalGeneral;

				?>
				<tr class="item-row fact_tittle">
					<td><strong>Totales</strong></td>
					<td align="right"><strong><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['TotalGeneral'], 0); ?></strong></td>
					<td align="right"></td>
					<td align="right"></td>
					<td align="right"><strong><?php echo valores($_SESSION['pagos_leyes_sociales_basicos']['TotalPagoGeneral'], 0); ?></strong></td>
				</tr>
			</tbody>
		</table>
		
    </div>

    <div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['pagos_leyes_sociales_basicos']['Observaciones']; ?></p>
		</div>
	</div>

	<table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td colspan="5">Archivos Adjuntos</td>
                <td width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
            </tr>

			<?php
			if (isset($_SESSION['pagos_leyes_sociales_archivos'])){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($_SESSION['pagos_leyes_sociales_archivos'] as $key => $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del_file='.$producto['idFile'];
								$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$producto['Nombre']).'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>

				 <?php
				$numeral++;
				}
			} ?>

		</tbody>
    </table>

</div>

<div class="clearfix"></div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//se crea filtro
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
 ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Pago</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Periodo_Ano)){      $x1  = $Periodo_Ano;    }else{$x1  = '';}
				if(isset($Periodo_Mes)){      $x2  = $Periodo_Mes;    }else{$x2  = '';}
				if(isset($Pago_fecha)){       $x3  = $Pago_fecha;     }else{$x3  = '';}
				if(isset($Observaciones)){    $x4  = $Observaciones;  }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('Periodo Año','Periodo_Ano', $x1, 2, 2016, ano_actual());
				$Form_Inputs->form_select_filter('Periodo Mes','Periodo_Mes', $x2, 2, 'idMes', 'Nombre', 'core_tiempo_meses', 0, 'idMes ASC', $dbConn);
				$Form_Inputs->form_date('Fecha Pago','Pago_fecha', $x3, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x4, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Crear Documento" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'periodo_ano_asc':    $order_by = 'pagos_leyes_sociales.Periodo_Ano ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Año Ascendente';break;
		case 'periodo_ano_desc':   $order_by = 'pagos_leyes_sociales.Periodo_Ano DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Año Descendente';break;
		case 'periodo_mes_asc':    $order_by = 'pagos_leyes_sociales.Periodo_Mes ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Mes Ascendente';break;
		case 'periodo_mes_desc':   $order_by = 'pagos_leyes_sociales.Periodo_Mes DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Mes Descendente';break;
		case 'fecha_pago_asc':     $order_by = 'pagos_leyes_sociales.Pago_fecha ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha de Pago Ascendente';break;
		case 'fecha_pago_desc':    $order_by = 'pagos_leyes_sociales.Pago_fecha DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha de Pago Descendente';break;
		case 'usuario_asc':        $order_by = 'usuarios_listado.Nombre ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente';break;
		case 'usuario_desc':       $order_by = 'usuarios_listado.Nombre ASC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
		case 'estado_asc':         $order_by = 'core_estado_facturacion.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado de Pago Ascendente';break;
		case 'estado_desc':        $order_by = 'core_estado_facturacion.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado de Pago Descendente';break;

		default: $order_by = 'pagos_leyes_sociales.idEstadoPago ASC, pagos_leyes_sociales.Pago_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado de Pago Ascendente, Fecha de Pago Descendente';
	}
}else{
	$order_by = 'pagos_leyes_sociales.idEstadoPago ASC, pagos_leyes_sociales.Pago_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado de Pago Ascendente, Fecha de Pago Descendente';
}
/**********************************************************/
//Variable con la ubicacion
$SIS_where = "pagos_leyes_sociales.idFactSocial!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND pagos_leyes_sociales.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Periodo_Ano']) && $_GET['Periodo_Ano']!=''){  $SIS_where .= " AND pagos_leyes_sociales.Periodo_Ano='".$_GET['Periodo_Ano']."'";}
if(isset($_GET['Pago_fecha']) && $_GET['Periodo_Mes']!=''){   $SIS_where .= " AND pagos_leyes_sociales.Periodo_Mes='".$_GET['Periodo_Mes']."'";}
if(isset($_GET['Pago_fecha']) && $_GET['Pago_fecha']!=''){    $SIS_where .= " AND pagos_leyes_sociales.Pago_fecha='".$_GET['Pago_fecha']."'";}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){      $SIS_where .= " AND pagos_leyes_sociales.idUsuario=".$_GET['idUsuario'];}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idFactSocial', 'pagos_leyes_sociales', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
pagos_leyes_sociales.idFactSocial,
pagos_leyes_sociales.Periodo_Ano,
pagos_leyes_sociales.Periodo_Mes,
pagos_leyes_sociales.Pago_fecha,
pagos_leyes_sociales.idEstadoPago,
core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS UsuarioNombre,
core_estado_facturacion.Nombre AS EstadoPago';
$SIS_join  = '
LEFT JOIN `core_sistemas`            ON core_sistemas.idSistema           = pagos_leyes_sociales.idSistema
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario        = pagos_leyes_sociales.idUsuario
LEFT JOIN `core_estado_facturacion`  ON core_estado_facturacion.idEstado  = pagos_leyes_sociales.idEstadoPago';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'pagos_leyes_sociales', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Pago</a><?php } ?>
</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Periodo_Ano)){   $x1 = $Periodo_Ano;  }else{$x1 = '';}
				if(isset($Periodo_Mes)){   $x2 = $Periodo_Mes;  }else{$x2 = '';}
				if(isset($Pago_fecha)){    $x3 = $Pago_fecha;   }else{$x3 = '';}
				if(isset($idUsuario)){     $x4 = $idUsuario;    }else{$x4 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('Periodo Año','Periodo_Ano', $x1, 2, 2016, ano_actual());
				$Form_Inputs->form_select_filter('Periodo Mes','Periodo_Mes', $x2, 2, 'idMes', 'Nombre', 'core_tiempo_meses', 0, 'idMes ASC', $dbConn);
				$Form_Inputs->form_date('Fecha Pago','Pago_fecha', $x3, 2);
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Usuario','idUsuario', $x4, 1, 'idUsuario', 'Nombre', 'usuarios_listado', $usrfil, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x4, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				}
				$Form_Inputs->form_input_hidden('pagina', 1, 1);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>

			</form>
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Pagos</h5>
			<div class="toolbar">
				<?php
				//Se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="120">
							<div class="pull-left">Año</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=periodo_ano_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=periodo_ano_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Mes</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=periodo_mes_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=periodo_mes_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Fecha</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_pago_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_pago_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Usuario Encargado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Estado de Pago</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
					<tr class="odd">
						<td><?php echo $tipo['Periodo_Ano']; ?></td>
						<td><?php echo numero_a_mes($tipo['Periodo_Mes']); ?></td>
						<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
						<td><?php echo $tipo['UsuarioNombre']; ?></td>
						<td><label class="label <?php if(isset($tipo['idEstadoPago'])&&$tipo['idEstadoPago']==2){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $tipo['EstadoPago']; ?></label></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_pagos_leyes_sociales.php?view='.simpleEncode($tipo['idFactSocial'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2&&isset($tipo['idEstadoPago'])&&$tipo['idEstadoPago']==1){ ?><a href="<?php echo $location.'&newPago='.$tipo['idFactSocial']; ?>" title="Ingresar Pagos" class="btn btn-success btn-sm tooltip"><i class="fa fa-usd" aria-hidden="true"></i></a><?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php
			//se llama al paginador
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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
