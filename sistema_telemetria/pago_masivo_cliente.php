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
$original = "pago_masivo_cliente.php";
$location = $original;   
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
/************************************************************/
//formulario para borrar
if (!empty($_GET['del_insumo_ex'])){
	//Se agregan ubicaciones
	$location .= '?submit_filter=true';
	if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){$location .= '&idDocumentos='.$_GET['idDocumentos'];}
	if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       $location .= '&N_Doc='.$_GET['N_Doc'];}
	if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){  $location .= '&idCliente='.$_GET['idCliente'];}
	//Llamamos al formulario
	$form_trabajo= 'del_insumo_ex';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_clientes.php';
}
//formulario para borrar
if (!empty($_GET['del_producto_ex'])){
	//Se agregan ubicaciones
	$location .= '?submit_filter=true';
	if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){$location .= '&idDocumentos='.$_GET['idDocumentos'];}
	if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       $location .= '&N_Doc='.$_GET['N_Doc'];}
	if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $location .= '&idCliente='.$_GET['idCliente'];}
	//Llamamos al formulario
	$form_trabajo= 'del_producto_ex';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_clientes.php';
}
//formulario para borrar
if (!empty($_GET['del_arriendo_ex'])){
	//Se agregan ubicaciones
	$location .= '?submit_filter=true';
	if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){$location .= '&idDocumentos='.$_GET['idDocumentos'];}
	if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       $location .= '&N_Doc='.$_GET['N_Doc'];}
	if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $location .= '&idCliente='.$_GET['idCliente'];}
	//Llamamos al formulario
	$form_trabajo= 'del_arriendo_ex';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_clientes.php';
}
//formulario para borrar
if (!empty($_GET['del_servicio_ex'])){
	//Se agregan ubicaciones
	$location .= '?submit_filter=true';
	if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){$location .= '&idDocumentos='.$_GET['idDocumentos'];}
	if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       $location .= '&N_Doc='.$_GET['N_Doc'];}
	if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $location .= '&idCliente='.$_GET['idCliente'];}
	//Llamamos al formulario
	$form_trabajo= 'del_servicio_ex';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_clientes.php';
}
/************************************************************/
//formulario para crear
if (!empty($_POST['submit_form'])){
	//Llamamos al formulario
	$form_trabajo= 'pago_general';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_clientes.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['pay'])){ $error['pay'] = 'sucess/Pago Realizado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['next'])){  

$location .= '?submit_filter=true';
if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){$location .= '&idDocumentos='.$_GET['idDocumentos'];}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       $location .= '&N_Doc='.$_GET['N_Doc'];}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){  $location .= '&idCliente='.$_GET['idCliente'];}

/******************************************************************/
//Se verifica el saldo de los pagos anticipados
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$query = "SELECT
	clientes_listado.Nombre AS Cliente
	FROM `clientes_listado`
	WHERE clientes_listado.idCliente='".$_GET['idCliente']."'
	";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	$rowData = mysqli_fetch_assoc ($resultado);
}
/******************************************************************/
//Se crea el select con todas las facturas que se estan pagando
$NC_Pendientes   = 0;
$Data_Pendientes = 0;
$inputSelect_1 = '<option value="" selected>Seleccione Factura</option>';
$inputSelect_2 = '<option value="" selected>Seleccione Factura</option>';
$inputSelect_3 = '<option value="" selected>Seleccione Factura</option>';
$inputSelect_4 = '<option value="" selected>Seleccione Factura</option>';
		
if(isset($_SESSION['pago_clientes_insumos'])){
	foreach ($_SESSION['pago_clientes_insumos'] as $key => $tipo){
		//Solo Facturas
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==2&&isset($tipo['MontoNC'])&&$tipo['MontoNC']==''){	
			$inputSelect_1 .= '<option value="'.$tipo['idFacturacion'].'" >Factura Insumos'.$tipo['N_Doc'].'</option>';
		}
		//Reviso las notas de credito pendientes
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){
			if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']==''){
				$NC_Pendientes++;
			}
		}else{	
			//Reviso si no se han agregado los valores
			if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==''){
				$Data_Pendientes++;
			}
		}
	}
}

if(isset($_SESSION['pago_clientes_productos'])){
	foreach ($_SESSION['pago_clientes_productos'] as $key => $tipo){
		//Solo Facturas
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==2&&isset($tipo['MontoNC'])&&$tipo['MontoNC']==''){
			$inputSelect_2 .= '<option value="'.$tipo['idFacturacion'].'" >Factura Productos '.$tipo['N_Doc'].'</option>';
		}
		//Reviso las notas de credito pendientes
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){
			if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']==''){
				$NC_Pendientes++;
			}
		}else{	
			//Reviso si no se han agregado los valores
			if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==''){
				$Data_Pendientes++;
			}
		}
	}
}

if(isset($_SESSION['pago_clientes_arriendo'])){
	foreach ($_SESSION['pago_clientes_arriendo'] as $key => $tipo){
		//Solo Facturas
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==2&&isset($tipo['MontoNC'])&&$tipo['MontoNC']==''){
			$inputSelect_3 .= '<option value="'.$tipo['idFacturacion'].'" >Factura Arriendos '.$tipo['N_Doc'].'</option>';
		}
		//Reviso las notas de credito pendientes
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){
			if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']==''){
				$NC_Pendientes++;
			}
		}else{	
			//Reviso si no se han agregado los valores
			if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==''){
				$Data_Pendientes++;
			}
		}
	}
}

if(isset($_SESSION['pago_clientes_servicio'])){
	foreach ($_SESSION['pago_clientes_servicio'] as $key => $tipo){
		//Solo Facturas
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==2&&isset($tipo['MontoNC'])&&$tipo['MontoNC']==''){
			$inputSelect_4 .= '<option value="'.$tipo['idFacturacion'].'" >Factura Servicios '.$tipo['N_Doc'].'</option>';
		}
		//Reviso las notas de credito pendientes
		if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){
			if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']==''){
				$NC_Pendientes++;
			}
		}else{	
			//Reviso si no se han agregado los valores
			if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==''){
				$Data_Pendientes++;
			}
		}
	}
}

$Form_Inputs = new Inputs();							
?>

<?php if(isset($rowData['Cliente'])&&$rowData['Cliente']!=''){ ?>
	<div class="row inbox"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h3>
				<strong>Cliente : </strong><?php echo $rowData['Cliente']; ?><br/>
			</h3>
			<hr>
		</div>
	</div>
<?php } ?>

										
										
<div class="row inbox">
								
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Facturaciones Pendientes de Pago</h5>
					<div class="toolbar">
						<?php if(isset($NC_Pendientes)&&$NC_Pendientes==0&&isset($Data_Pendientes)&&$Data_Pendientes!=0){ ?>
							<a onclick="addpagoTodos()" class="btn btn-xs btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Asignar Todos</a>
						<?php } ?>
					</div>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th width="10">Acciones</th>
								<th>Documento</th>
								<th>Cliente</th>
								<th>Facturado</th>
								<th>Pagado</th>
								<th>NC Utilizado</th>
								<th>Total Deuda</th>
								<th>NC</th>
								<th>Total a Pagar</th>
								<th>Fac Asoc</th>
								<th>Opc</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$Total = 0;
						$MontoCancelado = 0;
						$NCCancelado = 0;
						$TotalGeneral = 0;
						$TotalNCUtilizado = 0;
						$TotalDeuda = 0;
						$Registro_ok = 0;
						$Registro_total = 0;
						//insumos
						if(isset($_SESSION['pago_clientes_insumos'])){ ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="11"><strong>FACTURAS DE INSUMOS</strong></td>
							</tr>
							<?php foreach ($_SESSION['pago_clientes_insumos'] as $key => $tipo){
								$Registro_total++; ?>
								<tr class="odd">
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											<?php if ($rowlevel['level']>=2){
												$ubicacion = $location.'&del_insumo_ex='.$tipo['idFacturacion'];
												$dialogo   = '¿Realmente deseas eliminar la '.$tipo['Documento'].' '.$tipo['N_Doc'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Eliminar" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
										</div>
									</td>
									<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){
												echo 'Fact: '.$tipo['FacRelacionada'];
												$Registro_ok++;
											}else{
												echo '<select id="facturas_1_'.$tipo['idFacturacion'].'" class="form-control" >'.$inputSelect_1.'</select>';
											}
											?>
										</td>
										<td align="right">
											<?php if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){ ?>
												<a onclick="delDoc(1, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['idFacRelacionada']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php }else{ ?>
												<a onclick="addDoc(1, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
											<?php } ?>
										</td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoNC'], 0);$TotalNCUtilizado = $TotalNCUtilizado + $tipo['MontoNC']; ?></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']), 0);$TotalDeuda = $TotalDeuda + $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']); ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);
											if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){
												echo valores($tipo['ValorPagado'], 0);
												$TotalGeneral = $TotalGeneral + $tipo['ValorPagado'];
												$Registro_ok++;
											}else{
												$Form_Inputs->input_values_val('text','Total a Pagar','ingpago_1_'.$tipo['idFacturacion'],2,'','',$total);
											}
											?>
										</td>
										<td align="right"></td>
										<td align="right">
											<?php if(isset($NC_Pendientes)&&$NC_Pendientes==0){ ?>
												<?php if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){ ?>
													<a onclick="delpago(1, <?php echo $tipo['idFacturacion']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php }else{ ?>
													<a onclick="addpago(1, <?php echo $tipo['idFacturacion']; ?>, <?php echo $total; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
												<?php } ?>
											<?php } ?>
										</td>
									<?php } ?>
								</tr>
						<?php 
							}
						} 
						//productos
						if(isset($_SESSION['pago_clientes_productos'])){ ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="11"><strong>FACTURAS DE PRODUCTOS</strong></td>
							</tr>
							<?php
							foreach ($_SESSION['pago_clientes_productos'] as $key => $tipo){
								$Registro_total++; ?>
								<tr class="odd">
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											<?php if ($rowlevel['level']>=2){
												$ubicacion = $location.'&del_producto_ex='.$tipo['idFacturacion'];
												$dialogo   = '¿Realmente deseas eliminar la '.$tipo['Documento'].' '.$tipo['N_Doc'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Eliminar" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
										</div>
									</td>
									<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){
												echo 'Fact: '.$tipo['FacRelacionada'];
												$Registro_ok++;
											}else{
												echo '<select id="facturas_2_'.$tipo['idFacturacion'].'" class="form-control" >'.$inputSelect_2.'</select>';
											}
											?>
										</td>
										<td align="right">
											<?php if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){ ?>
												<a onclick="delDoc(2, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['idFacRelacionada']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php }else{ ?>
												<a onclick="addDoc(2, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
											<?php } ?>
										</td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoNC'], 0);$TotalNCUtilizado = $TotalNCUtilizado + $tipo['MontoNC']; ?></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']), 0);$TotalDeuda = $TotalDeuda + $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']); ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);
											if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){
												echo valores($tipo['ValorPagado'], 0);
												$TotalGeneral = $TotalGeneral + $tipo['ValorPagado'];
												$Registro_ok++;
											}else{
												$Form_Inputs->input_values_val('text','Total a Pagar','ingpago_2_'.$tipo['idFacturacion'],2,'','',$total);
											}
											?>
										</td>
										<td align="right"></td>
										<td align="right">
											<?php if(isset($NC_Pendientes)&&$NC_Pendientes==0){ ?>
												<?php if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){ ?>
													<a onclick="delpago(2, <?php echo $tipo['idFacturacion']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php }else{ ?>
													<a onclick="addpago(2, <?php echo $tipo['idFacturacion']; ?>, <?php echo $total; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
												<?php } ?>
											<?php } ?>
										</td>
									<?php } ?>
								</tr>
						<?php 
							}
						} 
						//arriendo
						if(isset($_SESSION['pago_clientes_arriendo'])){ ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="11"><strong>FACTURAS DE ARRIENDOS</strong></td>
							</tr>
							<?php
							foreach ($_SESSION['pago_clientes_arriendo'] as $key => $tipo){
								$Registro_total++; ?>
								<tr class="odd">
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											<?php if ($rowlevel['level']>=2){
												$ubicacion = $location.'&del_arriendo_ex='.$tipo['idFacturacion'];
												$dialogo   = '¿Realmente deseas eliminar la '.$tipo['Documento'].' '.$tipo['N_Doc'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Eliminar" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
										</div>
									</td>
									<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){
												echo 'Fact: '.$tipo['FacRelacionada'];
												$Registro_ok++;
											}else{
												echo '<select id="facturas_3_'.$tipo['idFacturacion'].'" class="form-control" >'.$inputSelect_3.'</select>';
											}
											?>
										</td>
										<td align="right">
											<?php if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){ ?>
												<a onclick="delDoc(3, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['idFacRelacionada']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php }else{ ?>
												<a onclick="addDoc(3, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
											<?php } ?>
										</td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoNC'], 0);$TotalNCUtilizado = $TotalNCUtilizado + $tipo['MontoNC']; ?></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']), 0);$TotalDeuda = $TotalDeuda + $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']); ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);
											if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){
												echo valores($tipo['ValorPagado'], 0);
												$TotalGeneral = $TotalGeneral + $tipo['ValorPagado'];
												$Registro_ok++;
											}else{
												$Form_Inputs->input_values_val('text','Total a Pagar','ingpago_3_'.$tipo['idFacturacion'],2,'','',$total);
											}
											?>
										</td>
										<td align="right"></td>
										<td align="right">
											<?php if(isset($NC_Pendientes)&&$NC_Pendientes==0){ ?>
												<?php if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){ ?>
													<a onclick="delpago(3, <?php echo $tipo['idFacturacion']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php }else{ ?>
													<a onclick="addpago(3, <?php echo $tipo['idFacturacion']; ?>, <?php echo $total; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
												<?php } ?>
											<?php } ?>
										</td>
									<?php } ?>
								</tr>
						<?php 
							}
						} 
						//servicio
						if(isset($_SESSION['pago_clientes_servicio'])){ ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="11"><strong>FACTURAS DE SERVICIOS</strong></td>
							</tr>
							<?php
							foreach ($_SESSION['pago_clientes_servicio'] as $key => $tipo){
								$Registro_total++; ?>
								<tr class="odd">
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											<?php if ($rowlevel['level']>=2){
												$ubicacion = $location.'&del_servicio_ex='.$tipo['idFacturacion'];
												$dialogo   = '¿Realmente deseas eliminar la '.$tipo['Documento'].' '.$tipo['N_Doc'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Eliminar" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
										</div>
									</td>
									<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){
												echo 'Fact: '.$tipo['FacRelacionada'];
												$Registro_ok++;
											}else{
												echo '<select id="facturas_4_'.$tipo['idFacturacion'].'" class="form-control" >'.$inputSelect_4.'</select>';
											}
											?>
										</td>
										<td align="right">
											<?php if(isset($tipo['FacRelacionada'])&&$tipo['FacRelacionada']!=''){ ?>
												<a onclick="delDoc(4, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['idFacRelacionada']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php }else{ ?>
												<a onclick="addDoc(4, <?php echo $tipo['idFacturacion']; ?>, <?php echo $tipo['ValorTotal']; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
											<?php } ?>
										</td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoNC'], 0);$TotalNCUtilizado = $TotalNCUtilizado + $tipo['MontoNC']; ?></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']), 0);$TotalDeuda = $TotalDeuda + $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']); ?></td>
										<td align="right"></td>
										<td align="right">
											<?php
											$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);
											if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){
												echo valores($tipo['ValorPagado'], 0);
												$TotalGeneral = $TotalGeneral + $tipo['ValorPagado'];
												$Registro_ok++;
											}else{
												$Form_Inputs->input_values_val('text','Total a Pagar','ingpago_4_'.$tipo['idFacturacion'],2,'','',$total);
											}
											?>
										</td>
										<td align="right"></td>
										<td align="right">
											<?php if(isset($NC_Pendientes)&&$NC_Pendientes==0){ ?>
												<?php if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){ ?>
													<a onclick="delpago(4, <?php echo $tipo['idFacturacion']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php }else{ ?>
													<a onclick="addpago(4, <?php echo $tipo['idFacturacion']; ?>, <?php echo $total; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
												<?php } ?>
											<?php } ?>
										</td>
									<?php } ?>
								</tr>
						<?php 
							}
						} 
						
						
						?>
						
						
						
							<tr class="odd">
								<td style="background-color: #E5E5E5;" align="right" colspan="3"><strong>Totales</strong></td>
								<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($Total, 0); ?></strong></td>
								<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($MontoCancelado, 0); ?></strong></td>
								<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($TotalNCUtilizado, 0); ?></strong></td>
								<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($TotalDeuda, 0); ?></strong></td>
								<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($NCCancelado, 0); ?></strong></td>
								<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($TotalGeneral, 0); ?></strong></td>
								<td style="background-color: #E5E5E5;"></td>
								<td style="background-color: #E5E5E5;"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

<script>
	//////////////////////////////////////////////////////////
	function saveData(level, number, pago) {
		$.get("pago_masivo_cliente_ok_save.php?type="+level+"&idFacturacion="+number+"&pago="+pago);
		return false;
	}
	//////////////////////////////////////////////////////////
	function delData(level, number) {
		$.get("pago_masivo_cliente_ok_delete.php?type="+level+"&idFacturacion="+number);
		return false;
	}
	//////////////////////////////////////////////////////////
	function saveFact(level, number, value, text, valor) {
		$.get("pago_masivo_cliente_fact_save.php?type="+level+"&idFacturacion="+number+"&value="+value+"&text="+text+"&valor="+valor);
		return false;
	}
	//////////////////////////////////////////////////////////
	function delFact(level, number, value, valor) {
		$.get("pago_masivo_cliente_fac_delete.php?type="+level+"&idFacturacion="+number+"&value="+value+"&valor="+valor);
		return false;
	}
	//////////////////////////////////////////////////////////
	function addpago(level, number, maximo) {

		let pago        = parseInt(document.getElementById("ingpago_"+level+"_"+number).value);
		let maxs        = parseInt(maximo);
		let pago_x      = document.getElementById("ingpago_"+level+"_"+number).value;
		let ok          = 0;

		//Verificaciones
		if (pago_x != "") { ok++; }else{ alert("No ha ingresado un valor de pago");}
		if (pago>maxs){ok--;alert("El valor que intenta cancelar es superior al maximo permitido");}

		//Guardo el dato y refresco la pagina
		if(ok==1){
			saveData(level, number, pago);
			setTimeout ("window.location.reload(false);", 1000); 
			 
		}
	}
	//////////////////////////////////////////////////////////
	function addpago_2(level, number, maximo) {
		
		let pago        = parseInt(document.getElementById("ingpago_"+level+"_"+number).value);
		let maxs        = parseInt(maximo);
		let pago_x      = document.getElementById("ingpago_"+level+"_"+number).value;
		let ok          = 0;

		//Verificaciones
		if (pago_x != "") { ok++; }else{ alert("No ha ingresado un valor de pago");}
		if (pago>maxs){ok--;alert("El valor que intenta cancelar es superior al maximo permitido");}

		//Guardo el dato y refresco la pagina
		if(ok==1){
			saveData(level, number, pago);
		}
	}
	//////////////////////////////////////////////////////////
	function addpagoTodos() {
		
		<?php
		//////////////////////////////////////////////////////
		if(isset($_SESSION['pago_clientes_insumos'])){
			foreach ($_SESSION['pago_clientes_insumos'] as $key => $tipo){
				//verifico que sean facturas o boletas
				if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']!=3){
					if(isset($NC_Pendientes)&&$NC_Pendientes==0){
						if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==0){
							$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);								
							//llamo al script
							echo "addpago_2(1, ".$tipo['idFacturacion'].", ".$total.");";
						}
					}
				}
			}
		}
		//////////////////////////////////////////////////////
		if(isset($_SESSION['pago_clientes_productos'])){
			foreach ($_SESSION['pago_clientes_productos'] as $key => $tipo){
				//verifico que sean facturas o boletas
				if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']!=3){
					if(isset($NC_Pendientes)&&$NC_Pendientes==0){
						if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==0){
							$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);								
							//llamo al script
							echo "addpago_2(2, ".$tipo['idFacturacion'].", ".$total.");";
						}
					}
				}
			}
		}
		//////////////////////////////////////////////////////
		if(isset($_SESSION['pago_clientes_arriendo'])){
			foreach ($_SESSION['pago_clientes_arriendo'] as $key => $tipo){
				//verifico que sean facturas o boletas
				if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']!=3){
					if(isset($NC_Pendientes)&&$NC_Pendientes==0){
						if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==0){
							$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);								
							//llamo al script
							echo "addpago_2(3, ".$tipo['idFacturacion'].", ".$total.");";
						}
					}
				}
			}
		}
		//////////////////////////////////////////////////////
		if(isset($_SESSION['pago_clientes_servicio'])){
			foreach ($_SESSION['pago_clientes_servicio'] as $key => $tipo){
				//verifico que sean facturas o boletas
				if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']!=3){
					if(isset($NC_Pendientes)&&$NC_Pendientes==0){
						if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==0){
							$total = $tipo['ValorTotal']-($tipo['MontoPagado']+$tipo['MontoNC']);								
							//llamo al script
							echo "addpago_2(4, ".$tipo['idFacturacion'].", ".$total.");";
						}
					}
				}
			}
		}
		?>
		
		setTimeout ("window.location.reload(false);", 1000);
	}
	//////////////////////////////////////////////////////////
	function delpago(level, number) {

		//Guardo el dato y refresco la pagina
		delData(level, number);
		setTimeout ("window.location.reload(false);", 1000); 	 
		
	}
	//////////////////////////////////////////////////////////
	function addDoc(level, number, valor) {
		
	
		let selector = document.getElementById("facturas_"+level+"_"+number);
		let value    = selector[selector.selectedIndex].value;
		let text     = selector[selector.selectedIndex].text;
    
		//Verifico 
		if(value!=0 &&value!=''&&text!=''){
			//Guardo el dato y refresco la pagina
			saveFact(level, number, value, text, valor);
			setTimeout ("window.location.reload(false);", 1000);
		}else{
			Swal.fire({icon: 'error',title: 'Oops...',text: 'Selecciona una opción.'});
		}
		
		
	}
	//////////////////////////////////////////////////////////
	function delDoc(level, number, value, valor) {

		//Guardo el dato y refresco la pagina
		delFact(level, number, value, valor);
		setTimeout ("window.location.reload(false);", 1000); 	
		
	}
	
	

</script>

								
<?php if(isset($NC_Pendientes)&&$NC_Pendientes==0&&isset($Data_Pendientes)&&$Data_Pendientes==0&&$TotalDeuda==0&&$TotalGeneral==0&&$TotalNCUtilizado==$NCCancelado&&$TotalNCUtilizado!=0){ ?>							
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Anulacion Documento</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" name="form1" id="form1">

					<?php
					//Se verifican si existen los datos
					if(isset($F_Pago)){     $x3  = $F_Pago;   }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha de Pago','F_Pago', $x3, 2);

					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf283; Cerrar Factura" name="submit_form">
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php }else{ ?>

	<?php if(isset($NC_Pendientes)&&$NC_Pendientes==0&&isset($Data_Pendientes)&&$Data_Pendientes==0&&$TotalDeuda!=0&&$TotalGeneral!=0){ ?>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">

			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
					<h5>Ingresar Pago Facturas</h5>
				</header>
				<div class="body">
					<form class="form-horizontal" method="post" name="form1" id="form1">

						<?php
						//Se verifican si existen los datos
						if(isset($idDocPago)){         $x1  = $idDocPago;          }else{$x1  = '';}
						if(isset($N_DocPago)){         $x2  = $N_DocPago;          }else{$x2  = '';}
						if(isset($F_Pago)){            $x3  = $F_Pago;             }else{$x3  = '';}

						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_select('Documento de Pago','idDocPago', $x1, 2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
						$Form_Inputs->form_input_number('N° Documento de Pago', 'N_DocPago', $x2, 1);
						$Form_Inputs->form_date('F Vencimiento','F_Pago', $x3, 2);

						echo '<div class="form-group" id="div_">
							<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Valor a Pagar</label>
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
								<input type="text" placeholder="Valor de la Factura" class="form-control"  name="escribeme" id="escribeme" disabled value="'.Valores($TotalGeneral, 0).'">
							</div>
						</div>';
						
						
						
						$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);

						?>

						<div class="form-group">
							<input type="submit" id="submitCadastroHidden" style="display: none;" name="submit_form">
							<input type="button" id="submitBtn" data-toggle="modal" data-target="#confirm-submit"  class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf283; Ingresar Pago" name="submit2">
						</div>

					</form>

				</div>
			</div>

			<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Confirmar Pago
						</div>
						<div class="modal-body">
							<p id="confirmacion"></p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<a href="#" id="submitmodal" class="btn btn-success success">Confirmar</a>
						</div>
					</div>
				</div>
			</div>

			<script>
				
				
				$('#submitBtn').click(function() {
					//Se verifica que todos los input tengan valores asignados
					let ninput = <?php echo ($Registro_total-$Registro_ok); ?>;

					//verifica el valor
					let monto = <?php echo $TotalGeneral; ?>;
					if(monto!=0&&ninput==0){
						$('#submitmodal').show();
						$('#confirmacion').text('Los montos estan correctos, ¿confirmas el pago?');
					}else{
						$('#submitmodal').hide();
						$('#confirmacion').text('Uno o mas valores no han sido ingresados');
					}
				});

				$('#submitmodal').click(function(){
					$("#submitCadastroHidden").click();
				});

			</script>

		</div>
	<?php }elseif(isset($NC_Pendientes)&&$NC_Pendientes==0&&isset($Data_Pendientes)&&$Data_Pendientes==0&&$TotalDeuda==0&&$TotalGeneral==0){ ?>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
					<h5>Ingresar Pago Facturas</h5>
				</header>
				<div class="body">
					<form class="form-horizontal" method="post" name="form1" id="form1">

						<?php
						//Se verifican si existen los datos
						if(isset($F_Pago)){     $x3  = $F_Pago;   }else{$x3  = '';}

						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_date('Fecha de Pago','F_Pago', $x3, 2);

						$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
							
						?>

						<div class="form-group">
							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf283; Cerrar Factura" name="submit_form">
						</div>
					</form>
				</div>
			</div>
		</div>			
	<?php } ?>
<?php } ?>

	</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="<?php echo $original; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Cancelar</a>
<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['submit_filter'])){
//Titulo con el cliente		
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){				
	$query = "SELECT Nombre
	FROM `clientes_listado`
	WHERE idCliente=".$_GET['idCliente'];
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	$rowCliente = mysqli_fetch_assoc ($resultado);
}

//Borro todos los datos al cargar
unset($_SESSION['pago_clientes_insumos']);
unset($_SESSION['pago_clientes_productos']);
unset($_SESSION['pago_clientes_arriendo']);
unset($_SESSION['pago_clientes_servicio']);
/*************************************************************/
//Verifico el tipo de usuario que esta ingresando
$z1=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];		

/**********************************************************************************************/
//datos de la obra
$NDocsubmit_filter1   = '';
$NDocsubmit_filter2   = '';
$NDocsubmit_filter3   = '';
$NDocsubmit_filter4   = '';
$location .= '?submit_filter=true';
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$NDocsubmit_filter1 .= ' AND bodegas_insumos_facturacion.idCliente='.$_GET['idCliente'];
	$NDocsubmit_filter2 .= ' AND bodegas_productos_facturacion.idCliente='.$_GET['idCliente'];
	$NDocsubmit_filter3 .= ' AND bodegas_arriendos_facturacion.idCliente='.$_GET['idCliente'];
	$NDocsubmit_filter4 .= ' AND bodegas_servicios_facturacion.idCliente='.$_GET['idCliente'];
	$location .= '&idCliente='.$_GET['idCliente'];
}
if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){
	$NDocsubmit_filter1 .= ' AND bodegas_insumos_facturacion.idDocumentos='.$_GET['idDocumentos'];
	$NDocsubmit_filter2 .= ' AND bodegas_productos_facturacion.idDocumentos='.$_GET['idDocumentos'];
	$NDocsubmit_filter3 .= ' AND bodegas_arriendos_facturacion.idDocumentos='.$_GET['idDocumentos'];
	$NDocsubmit_filter4 .= ' AND bodegas_servicios_facturacion.idDocumentos='.$_GET['idDocumentos'];
	$location .= '&idDocumentos='.$_GET['idDocumentos'];
}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){
	$NDocsubmit_filter1 .= ' AND bodegas_insumos_facturacion.N_Doc='.$_GET['N_Doc'];
	$NDocsubmit_filter2 .= ' AND bodegas_productos_facturacion.N_Doc='.$_GET['N_Doc'];
	$NDocsubmit_filter3 .= ' AND bodegas_arriendos_facturacion.N_Doc='.$_GET['N_Doc'];
	$NDocsubmit_filter4 .= ' AND bodegas_servicios_facturacion.N_Doc='.$_GET['N_Doc'];
	$location .= '&N_Doc='.$_GET['N_Doc'];
}

		
//consulto todos los documentos relacionados al cliente
$arrTipo1 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idFacturacion,
bodegas_insumos_facturacion.Creacion_fecha,
bodegas_insumos_facturacion.fecha_auto,
bodegas_insumos_facturacion.Pago_fecha,
bodegas_insumos_facturacion.N_Doc,
bodegas_insumos_facturacion.ValorTotal,
bodegas_insumos_facturacion.idSistema,
bodegas_insumos_facturacion.idCliente,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_insumos_facturacion.idDocumentos,
core_documentos_mercantiles.Nombre AS Documento,
(SELECT SUM(MontoPagado) FROM `pagos_facturas_clientes` WHERE idFacturacion= bodegas_insumos_facturacion.idFacturacion AND idTipo=1 LIMIT 1) AS MontoPagado

FROM `bodegas_insumos_facturacion`
LEFT JOIN `core_sistemas`                   ON core_sistemas.idSistema                      = bodegas_insumos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`     ON core_documentos_mercantiles.idDocumentos     = bodegas_insumos_facturacion.idDocumentos
LEFT JOIN `clientes_listado`                ON clientes_listado.idCliente                   = bodegas_insumos_facturacion.idCliente
				
WHERE (bodegas_insumos_facturacion.idFacturacion>0
".$NDocsubmit_filter1."
AND bodegas_insumos_facturacion.idTipo=2
AND bodegas_insumos_facturacion.idDocumentos=2
AND bodegas_insumos_facturacion.idEstado=1
".$z1.")

OR (bodegas_insumos_facturacion.idFacturacion>0
".$NDocsubmit_filter1."
AND bodegas_insumos_facturacion.idTipo=2
AND bodegas_insumos_facturacion.idDocumentos=5
AND bodegas_insumos_facturacion.idEstado=1
".$z1.")
				
OR (bodegas_insumos_facturacion.idFacturacion>0
".$NDocsubmit_filter1."
AND bodegas_insumos_facturacion.idTipo=12
AND bodegas_insumos_facturacion.idDocumentos=4
AND bodegas_insumos_facturacion.idEstado=1
AND bodegas_insumos_facturacion.idFacturacionRelacionado=0
".$z1.")

OR (bodegas_insumos_facturacion.idFacturacion>0
".$NDocsubmit_filter1."
AND bodegas_insumos_facturacion.idTipo=13
AND bodegas_insumos_facturacion.idDocumentos=3
AND bodegas_insumos_facturacion.idEstado=1
AND bodegas_insumos_facturacion.idFacturacionRelacionado=0
".$z1.")
				
ORDER BY bodegas_insumos_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo1,$row );
}
/*************************************************************/
//consulto todos los documentos relacionados al cliente
$arrTipo2 = array();
$query = "SELECT 
bodegas_productos_facturacion.idFacturacion,
bodegas_productos_facturacion.Creacion_fecha,
bodegas_productos_facturacion.fecha_auto,
bodegas_productos_facturacion.Pago_fecha,
bodegas_productos_facturacion.N_Doc,
bodegas_productos_facturacion.ValorTotal,
bodegas_productos_facturacion.idSistema,
bodegas_productos_facturacion.idCliente,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_productos_facturacion.idDocumentos,
core_documentos_mercantiles.Nombre AS Documento,
(SELECT SUM(MontoPagado) FROM `pagos_facturas_clientes` WHERE idFacturacion= bodegas_productos_facturacion.idFacturacion AND idTipo=2 LIMIT 1) AS MontoPagado
				
FROM `bodegas_productos_facturacion`
LEFT JOIN `core_sistemas`                   ON core_sistemas.idSistema                      = bodegas_productos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`     ON core_documentos_mercantiles.idDocumentos     = bodegas_productos_facturacion.idDocumentos
LEFT JOIN `clientes_listado`                ON clientes_listado.idCliente                   = bodegas_productos_facturacion.idCliente
				
WHERE (bodegas_productos_facturacion.idFacturacion>0
".$NDocsubmit_filter2."
AND bodegas_productos_facturacion.idTipo=2
AND bodegas_productos_facturacion.idDocumentos=2
AND bodegas_productos_facturacion.idEstado=1
".$z2.")

OR (bodegas_productos_facturacion.idFacturacion>0
".$NDocsubmit_filter2."
AND bodegas_productos_facturacion.idTipo=2
AND bodegas_productos_facturacion.idDocumentos=5
AND bodegas_productos_facturacion.idEstado=1
".$z2.")
				
OR (bodegas_productos_facturacion.idFacturacion>0
".$NDocsubmit_filter2."
AND bodegas_productos_facturacion.idTipo=12
AND bodegas_productos_facturacion.idDocumentos=4
AND bodegas_productos_facturacion.idEstado=1
AND bodegas_productos_facturacion.idFacturacionRelacionado=0
".$z2.")

OR (bodegas_productos_facturacion.idFacturacion>0
".$NDocsubmit_filter2."
AND bodegas_productos_facturacion.idTipo=13
AND bodegas_productos_facturacion.idDocumentos=3
AND bodegas_productos_facturacion.idEstado=1
AND bodegas_productos_facturacion.idFacturacionRelacionado=0
".$z2.")
				
ORDER BY bodegas_productos_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo2,$row );
}
/*************************************************************/
//consulto todos los documentos relacionados al cliente
$arrTipo3 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idFacturacion,
bodegas_arriendos_facturacion.Creacion_fecha,
bodegas_arriendos_facturacion.fecha_auto,
bodegas_arriendos_facturacion.Pago_fecha,
bodegas_arriendos_facturacion.N_Doc,
bodegas_arriendos_facturacion.ValorTotal,
bodegas_arriendos_facturacion.idSistema,
bodegas_arriendos_facturacion.idCliente,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_arriendos_facturacion.idDocumentos,
core_documentos_mercantiles.Nombre AS Documento,
(SELECT SUM(MontoPagado) FROM `pagos_facturas_clientes` WHERE idFacturacion= bodegas_arriendos_facturacion.idFacturacion AND idTipo=4 LIMIT 1) AS MontoPagado
				
FROM `bodegas_arriendos_facturacion`
LEFT JOIN `core_sistemas`                   ON core_sistemas.idSistema                      = bodegas_arriendos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`     ON core_documentos_mercantiles.idDocumentos     = bodegas_arriendos_facturacion.idDocumentos
LEFT JOIN `clientes_listado`                ON clientes_listado.idCliente                   = bodegas_arriendos_facturacion.idCliente
				
WHERE (bodegas_arriendos_facturacion.idFacturacion>0
".$NDocsubmit_filter3."
AND bodegas_arriendos_facturacion.idTipo=2
AND bodegas_arriendos_facturacion.idDocumentos=2
AND bodegas_arriendos_facturacion.idEstado=1
".$z3.")

OR (bodegas_arriendos_facturacion.idFacturacion>0
".$NDocsubmit_filter3."
AND bodegas_arriendos_facturacion.idTipo=2
AND bodegas_arriendos_facturacion.idDocumentos=5
AND bodegas_arriendos_facturacion.idEstado=1
".$z3.")
				
OR (bodegas_arriendos_facturacion.idFacturacion>0
".$NDocsubmit_filter3."
AND bodegas_arriendos_facturacion.idTipo=12
AND bodegas_arriendos_facturacion.idDocumentos=4
AND bodegas_arriendos_facturacion.idEstado=1
AND bodegas_arriendos_facturacion.idFacturacionRelacionado=0
".$z3.")

OR (bodegas_arriendos_facturacion.idFacturacion>0
".$NDocsubmit_filter3."
AND bodegas_arriendos_facturacion.idTipo=13
AND bodegas_arriendos_facturacion.idDocumentos=3
AND bodegas_arriendos_facturacion.idEstado=1
AND bodegas_arriendos_facturacion.idFacturacionRelacionado=0
".$z3.")
				
ORDER BY bodegas_arriendos_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo3,$row );
}
/*************************************************************/
//consulto todos los documentos relacionados al cliente
$arrTipo4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idFacturacion,
bodegas_servicios_facturacion.Creacion_fecha,
bodegas_servicios_facturacion.fecha_auto,
bodegas_servicios_facturacion.Pago_fecha,
bodegas_servicios_facturacion.N_Doc,
bodegas_servicios_facturacion.ValorTotal,
bodegas_servicios_facturacion.idSistema,
bodegas_servicios_facturacion.idCliente,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_servicios_facturacion.idDocumentos,
core_documentos_mercantiles.Nombre AS Documento,
(SELECT SUM(MontoPagado) FROM `pagos_facturas_clientes` WHERE idFacturacion= bodegas_servicios_facturacion.idFacturacion AND idTipo=3 LIMIT 1) AS MontoPagado
				
FROM `bodegas_servicios_facturacion`
LEFT JOIN `core_sistemas`                   ON core_sistemas.idSistema                      = bodegas_servicios_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`     ON core_documentos_mercantiles.idDocumentos     = bodegas_servicios_facturacion.idDocumentos				
LEFT JOIN `clientes_listado`                ON clientes_listado.idCliente                   = bodegas_servicios_facturacion.idCliente

WHERE (bodegas_servicios_facturacion.idFacturacion>0
".$NDocsubmit_filter4."
AND bodegas_servicios_facturacion.idTipo=2
AND bodegas_servicios_facturacion.idDocumentos=2
AND bodegas_servicios_facturacion.idEstado=1
".$z4.")

OR (bodegas_servicios_facturacion.idFacturacion>0
".$NDocsubmit_filter4."
AND bodegas_servicios_facturacion.idTipo=2
AND bodegas_servicios_facturacion.idDocumentos=5
AND bodegas_servicios_facturacion.idEstado=1
".$z4.")
				
OR (bodegas_servicios_facturacion.idFacturacion>0
".$NDocsubmit_filter4."
AND bodegas_servicios_facturacion.idTipo=12
AND bodegas_servicios_facturacion.idDocumentos=4
AND bodegas_servicios_facturacion.idEstado=1
AND bodegas_servicios_facturacion.idFacturacionRelacionado=0
".$z4.")

OR (bodegas_servicios_facturacion.idFacturacion>0
".$NDocsubmit_filter4."
AND bodegas_servicios_facturacion.idTipo=13
AND bodegas_servicios_facturacion.idDocumentos=3
AND bodegas_servicios_facturacion.idEstado=1
AND bodegas_servicios_facturacion.idFacturacionRelacionado=0
".$z4.")
				
ORDER BY bodegas_servicios_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo4,$row );
}	

?>

<?php if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){ ?>
	<div class="row inbox"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2><strong>cliente : </strong><?php echo $rowCliente['Nombre']; ?></h2>
			<hr>
		</div>
	</div>
<?php } ?>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a style="display: none;" id="acep_1" href="<?php echo $location.'&next=true'; ?>" class="btn btn-primary pull-right margin_form_btn" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Aceptar</a>
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right margin_form_btn" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
	<div class="clearfix"></div>
</div>

							
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Facturaciones Pendientes de Pago</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Documento</th>
								<th>Cliente</th>
								<th>F Emision</th>
								<th>F Vencimiento</th>
								<th>Facturado</th>
								<th>Pagado</th>
								<th>NC</th>
								<th>Total a Pagar</th>
								<th width="10">Acciones</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$Total = 0;
						$MontoCancelado = 0;
						$NCCancelado = 0;
						//insumos
						if ($arrTipo1!=false && !empty($arrTipo1) && $arrTipo1!='') {  ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="9"><strong>FACTURAS DE INSUMOS</strong></td>
							</tr>
							<?php foreach ($arrTipo1 as $tipo){ ?>
								<tr class="odd">
									<td>
										<div class="checkbox checkbox-primary">
											<input id="checkbox_1_<?php echo $tipo['idFacturacion']; ?>" type="checkbox" onclick="onToggle(1, <?php echo $tipo['idFacturacion']; ?>)">
											<label for="checkbox_1_<?php echo $tipo['idFacturacion']; ?>">
												<?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?>
											</label>
										</div>
									</td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
									<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']), 0); ?></td>
									<?php } ?>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										</div>
									</td>
								</tr>
						<?php 
							}
						} 
						//productos
						if ($arrTipo2!=false && !empty($arrTipo2) && $arrTipo2!='') {  ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="9"><strong>FACTURAS DE PRODUCTOS</strong></td>
							</tr>
							<?php foreach ($arrTipo2 as $tipo){ ?>
								<tr class="odd">
									<td>
										<div class="checkbox checkbox-primary">
											<input id="checkbox_2_<?php echo $tipo['idFacturacion']; ?>" type="checkbox" onclick="onToggle(2, <?php echo $tipo['idFacturacion']; ?>)">
											<label for="checkbox_2_<?php echo $tipo['idFacturacion']; ?>">
												<?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?>
											</label>
										</div>
									</td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
									<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']), 0); ?></td>
									<?php } ?>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										</div>
									</td>
								</tr>
						<?php 
							}
						} 
						//arriendo
						if ($arrTipo3!=false && !empty($arrTipo3) && $arrTipo3!='') {  ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="9"><strong>FACTURAS DE ARRIENDOS</strong></td>
							</tr>
							<?php foreach ($arrTipo3 as $tipo){ ?>
								<tr class="odd">
									<td>
										<div class="checkbox checkbox-primary">
											<input id="checkbox_3_<?php echo $tipo['idFacturacion']; ?>" type="checkbox" onclick="onToggle(3, <?php echo $tipo['idFacturacion']; ?>)">
											<label for="checkbox_3_<?php echo $tipo['idFacturacion']; ?>">
												<?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?>
											</label>
										</div>
									</td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
									<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']), 0); ?></td>
									<?php } ?>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										</div>
									</td>
								</tr>
						<?php 
							}
						} 
						//servicio
						if ($arrTipo4!=false && !empty($arrTipo4) && $arrTipo4!='') {  ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" colspan="9"><strong>FACTURAS DE SERVICIOS</strong></td>
							</tr>
							<?php foreach ($arrTipo4 as $tipo){ ?>
								<tr class="odd">
									<td>
										<div class="checkbox checkbox-primary">
											<input id="checkbox_4_<?php echo $tipo['idFacturacion']; ?>" type="checkbox" onclick="onToggle(4, <?php echo $tipo['idFacturacion']; ?>)">
											<label for="checkbox_4_<?php echo $tipo['idFacturacion']; ?>">
												<?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?>
											</label>
										</div>
									</td>
									<td><?php echo $tipo['Cliente']; ?></td>
									<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
									<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
									<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
										<td align="right"></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$NCCancelado = $NCCancelado + $tipo['ValorTotal']; ?></td>
										<td align="right"></td>
									<?php }else{ ?>
										<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$Total = $Total + $tipo['ValorTotal']; ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
										<td align="right"></td>
										<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']), 0); ?></td>
									<?php } ?>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										</div>
									</td>
								</tr>
						<?php 
							}
						} 
						
						
						?>
						
						
						
							<tr class="odd">
								<td align="right" colspan="4"><strong>Totales</strong></td>
								<td align="right"><strong id="final_val_1"></strong></td>
								<td align="right"><strong id="final_val_2"></strong></td>
								<td align="right"><strong id="final_val_3"></strong></td>
								<td align="right"><strong id="final_val_4"></strong></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div> 
		
		
<script>

	
	
	function number_format (number, decimals, dec_point, thousands_sep) {
		var n = number, prec = decimals;

		var toFixedFix = function (n,prec) {
			var k = Math.pow(10,prec);
			return (Math.round(n*k)/k).toString();
		};

		n = !isFinite(+n) ? 0 : +n;
		prec = !isFinite(+prec) ? 0 : Math.abs(prec);
		var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
		var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

		var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); 
		//fix for IE parseFloat(0.55).toFixed(0) = 0;

		var abs = toFixedFix(Math.abs(n), prec);
		var _, i;

		if (abs >= 1000) {
			_ = abs.split(/\D/);
			i = _[0].length % 3 || 3;

			_[0] = s.slice(0,i + (n < 0)) +
				   _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
			s = _.join(dec);
		} else {
			s = s.replace('.', dec);
		}

		var decPos = s.indexOf(dec);
		if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
			s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
		}
		else if (prec >= 1 && decPos === -1) {
			s += dec+new Array(prec).join(0)+'0';
		}
		return '$ '+s;
	}

	//////////////////////////////////////////////////////////
	function doSomething(level, number) {
		$.get("pago_masivo_cliente_execute.php?type="+level+"&idFacturacion="+number);
		return false;
	}

	//////////////////////////////////////////////////////////
	function onToggle(level, number) {
		
		doSomething(level, number)
		
		
		//Variable con los totales
		let Total = 0;
		let MontoCancelado = 0;
		let NCCancelado = 0;
		let Totalgen = 0;
	
		// check if checkbox is checked
		<?php foreach ($arrTipo1 as $tipo){ ?>
						
			if (document.querySelector('#checkbox_1_<?php echo $tipo['idFacturacion']; ?>').checked) {
				
				<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
					NCCancelado  = NCCancelado + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					Totalgen     = Totalgen - <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
				<?php }else{ ?>
					Total           = Total + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					MontoCancelado  = MontoCancelado + <?php echo Cantidades_decimales_justos($tipo['MontoPagado']); ?>;
					Totalgen        = Totalgen + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']-($tipo['MontoPagado'])); ?>;
				<?php } ?>
				
			}
		<?php }
		/********************************************************/
		foreach ($arrTipo2 as $tipo){ ?>
						
			if (document.querySelector('#checkbox_2_<?php echo $tipo['idFacturacion']; ?>').checked) {
				
				<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
					NCCancelado  = NCCancelado + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					Totalgen     = Totalgen - <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
				<?php }else{ ?>
					Total           = Total + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					MontoCancelado  = MontoCancelado + <?php echo Cantidades_decimales_justos($tipo['MontoPagado']); ?>;
					Totalgen        = Totalgen + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']-($tipo['MontoPagado'])); ?>;
				<?php } ?>
				
			}
		<?php }
		/********************************************************/
		foreach ($arrTipo3 as $tipo){ ?>
						
			if (document.querySelector('#checkbox_3_<?php echo $tipo['idFacturacion']; ?>').checked) {
				
				<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
					NCCancelado  = NCCancelado + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					Totalgen     = Totalgen - <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
				<?php }else{ ?>
					Total           = Total + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					MontoCancelado  = MontoCancelado + <?php echo Cantidades_decimales_justos($tipo['MontoPagado']); ?>;
					Totalgen        = Totalgen + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']-($tipo['MontoPagado'])); ?>;
				<?php } ?>
				
			}
		<?php }
		/********************************************************/
		foreach ($arrTipo4 as $tipo){ ?>
						
			if (document.querySelector('#checkbox_4_<?php echo $tipo['idFacturacion']; ?>').checked) {
				
				<?php if(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){ ?>
					NCCancelado  = NCCancelado + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					Totalgen     = Totalgen - <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
				<?php }else{ ?>
					Total           = Total + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
					MontoCancelado  = MontoCancelado + <?php echo Cantidades_decimales_justos($tipo['MontoPagado']); ?>;
					Totalgen        = Totalgen + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']-($tipo['MontoPagado'])); ?>;
				<?php } ?>
				
			}
		<?php } ?>
		
		//Se escriben en los cuadros
		document.getElementById("final_val_1").innerHTML = number_format(Total, 0, ',', '.');
		document.getElementById("final_val_2").innerHTML = number_format(MontoCancelado, 0, ',', '.');
		document.getElementById("final_val_3").innerHTML = number_format(NCCancelado, 0, ',', '.');
		document.getElementById("final_val_4").innerHTML = number_format(Totalgen, 0, ',', '.');

		//Verifico que el total general sea distinto de 0 y habilito el boton siguiente
		if(Totalgen>0){
			document.getElementById("acep_1").style.display = "block";
			document.getElementById("acep_2").style.display = "block";
		//Si se esta anulando una factura
		}else if(Totalgen==0&&Total==NCCancelado&&Total>0&&NCCancelado>0){
			document.getElementById("acep_1").style.display = "block";
			document.getElementById("acep_2").style.display = "block";
		}else{
			document.getElementById("acep_1").style.display = "none";
			document.getElementById("acep_2").style.display = "none";
		}
	}


</script>
	

  
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a style="display: none;" id="acep_2" href="<?php echo $location.'&next=true'; ?>" class="btn btn-primary pull-right margin_form_btn"><i class="fa fa-check-square-o" aria-hidden="true"></i> Aceptar</a>
<a href="<?php echo $original; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
				if(isset($idCliente)){     $x1  = $idCliente;    }else{$x1  = '';}
				if(isset($idDocumentos)){  $x2  = $idDocumentos; }else{$x2  = '';}
				if(isset($N_Doc)){         $x3  = $N_Doc;        }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 2, 'idCliente', 'Rut,Nombre', 'clientes_listado', $z, '', $dbConn);
				$Form_Inputs->form_select('Documento de Pago','idDocumentos', $x2, 1, 'idDocumentos', 'Nombre', 'core_documentos_mercantiles', 'idDocumentos!=1 AND idDocumentos!=3 AND idDocumentos!=4', '', $dbConn);
				$Form_Inputs->form_input_number('N° Documento de Pago', 'N_Doc', $x3, 1);

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
