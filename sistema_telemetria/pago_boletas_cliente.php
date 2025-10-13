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
$original = "pago_boletas_cliente.php";
$location = $original;   
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
/************************************************************/
//formulario para borrar
if (!empty($_GET['del_boleta'])){
	//Se agregan ubicaciones
	$location .= '?submit_filter=true';
	if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){         $location .= '&N_Doc='.$_GET['N_Doc'];}
	if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){  $location .= '&idCliente='.$_GET['idCliente'];}
	//Llamamos al formulario
	$form_trabajo= 'del_boleta';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_boletas_clientes.php';
}
/************************************************************/
//formulario para crear
if (!empty($_POST['submit_form'])){
	//Llamamos al formulario
	$form_trabajo= 'pago_general';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_boletas_clientes.php';
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
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $location .= '&idCliente='.$_GET['idCliente'];}

/******************************************************************/
//Se verifica el saldo de los pagos anticipados
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$query = "SELECT Nombre
	FROM `clientes_listado`
	WHERE clientes_listado.idCliente='".$_GET['idCliente']."'";
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
//Se crea el select con todas las Boletas que se estan pagando
$Data_Pendientes = 0;
	
if(isset($_SESSION['pagos_boletas_clientes'])){
	foreach ($_SESSION['pagos_boletas_clientes'] as $key => $tipo){
		//Reviso si no se han agregado los valores
		if(isset($tipo['ValorReal'])&&$tipo['ValorReal']==''){
			$Data_Pendientes++;
		}
	}
}

?>

<div class="row inbox">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>
			<strong>Cliente : </strong><?php echo $rowData['Nombre']; ?><br/>
		</h3>
		<hr>
	</div>
</div>
									
<div class="row inbox">
								
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Boletas Pendientes de Pago</h5>
				<div class="toolbar">
					<?php if(isset($Data_Pendientes)&&$Data_Pendientes!=0){ ?>
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
							<th>Facturado</th>
							<th>Pagado</th>
							<th>Total Deuda</th>
							<th>Total a Pagar</th>
								<th>Opc</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$TotalFact = 0;
						$MontoCancelado = 0;
						$TotalGeneral = 0;
						$TotalDeuda = 0;
						$Registro_ok = 0;
						$Registro_total = 0;
						//insumos
						if(isset($_SESSION['pagos_boletas_clientes'])){
							foreach ($_SESSION['pagos_boletas_clientes'] as $key => $tipo){
								$Registro_total++; ?>
								<tr class="odd">
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_boleta_honorarios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											<?php if ($rowlevel['level']>=2){
												$ubicacion = $location.'&del_boleta='.$tipo['idFacturacion'];
												$dialogo   = '¿Realmente deseas eliminar la Boleta N° '.$tipo['N_Doc'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Eliminar" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
										</div>
									</td>
									<td><?php echo 'Boleta N° '.$tipo['N_Doc']; ?></td>
									<td align="right"><?php echo valores($tipo['ValorTotal'], 0);$TotalFact = $TotalFact + $tipo['ValorTotal']; ?></td>
									<td align="right"><?php echo valores($tipo['MontoPagado'], 0);$MontoCancelado = $MontoCancelado + $tipo['MontoPagado']; ?></td>
									<td align="right"><?php echo valores($tipo['ValorTotal']-$tipo['MontoPagado'], 0);$TotalDeuda = $TotalDeuda + $tipo['ValorTotal']-$tipo['MontoPagado']; ?></td>
									<td align="right">
										<?php
										$total = $tipo['ValorTotal']-$tipo['MontoPagado'];
										if(isset($tipo['ValorReal'])&&$tipo['ValorReal']!=''){
											echo valores($tipo['ValorReal'], 0);
											$TotalGeneral = $TotalGeneral + $tipo['ValorReal'];
											$Registro_ok++;
										}else{
											$Form_Inputs = new Inputs();
											$Form_Inputs->input_values_val('text','Total a Pagar','ingpago_'.$tipo['idFacturacion'],2,'','',$total);
										}
										?>
									</td>
									<td align="right">
										<?php if(isset($tipo['ValorReal'])&&$tipo['ValorReal']!=''){ ?>
											<a onclick="delpago(<?php echo $tipo['idFacturacion']; ?>)"  title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										<?php }else{ ?>
											<a onclick="addpago(<?php echo $tipo['idFacturacion']; ?>, <?php echo $total; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
										<?php } ?>
									</td>
								</tr>
						<?php 
							}
						} ?> 

					<tr class="odd">
						<td style="background-color: #E5E5E5;" align="right" colspan="2"><strong>Totales</strong></td>
						<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($TotalFact, 0); ?></strong></td>
						<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($MontoCancelado, 0); ?></strong></td>
						<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($TotalDeuda, 0); ?></strong></td>
						<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($TotalGeneral, 0); ?></strong></td>
						<td style="background-color: #E5E5E5;" align="right"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div> 
		
	
		 


<script>
	//////////////////////////////////////////////////////////
	function saveData(idFacturacion, pago) {
		$.get("pago_boletas_cliente_ok_save.php?idFacturacion="+idFacturacion+"&pago="+pago);
		return false;
	}
	//////////////////////////////////////////////////////////
	function addpago_2(idFacturacion, maximo) {
		
		let pago        = parseInt(document.getElementById("ingpago_"+idFacturacion).value);
		let maxs        = parseInt(maximo);
		let pago_x      = document.getElementById("ingpago_"+idFacturacion).value;
		let ok          = 0;

		//Verificaciones
		if (pago_x != "") { ok++; }else{ alert("No ha ingresado un valor de pago");}
		if (pago>maxs){ok--;alert("El valor que intenta cancelar es superior al maximo permitido");}

		//Guardo el dato y refresco la pagina
		if(ok==1){
			saveData(idFacturacion, pago);
		}
	}
	//////////////////////////////////////////////////////////
	function addpagoTodos() {
		
		<?php
		//////////////////////////////////////////////////////
		if(isset($_SESSION['pagos_boletas_clientes'])){
			foreach ($_SESSION['pagos_boletas_clientes'] as $key => $tipo){
				if(isset($tipo['ValorReal'])&&$tipo['ValorReal']==0){
					$total = $tipo['ValorTotal']-$tipo['MontoPagado'];								
					//llamo al script
					echo "addpago_2(".$tipo['idFacturacion'].", ".$total.");";
				}
			}
		}
		
		?>
		
		setTimeout ("window.location.reload(false);", 1000);
	}
	//////////////////////////////////////////////////////////
	function delData(idFacturacion) {
		$.get("pago_boletas_cliente_ok_delete.php?idFacturacion="+idFacturacion);
		return false;
	}
	//////////////////////////////////////////////////////////
	function delpago(idFacturacion) {

		//Guardo el dato y refresco la pagina
		delData(idFacturacion);
		setTimeout ("window.location.reload(false);", 1000); 	 
		
	}
	//////////////////////////////////////////////////////////
	function addpago( idFacturacion, maximo) {

		let pago        = parseInt(document.getElementById("ingpago_"+idFacturacion).value);
		let maxs        = parseInt(maximo);
		let pago_x      = document.getElementById("ingpago_"+idFacturacion).value;
		let ok          = 0;

		//Verificaciones
		if (pago_x != "") { ok++; }else{ alert("No ha ingresado un valor de pago");}
		if (pago>maxs){ok--;alert("El valor que intenta cancelar es superior al maximo permitido");}

		//Guardo el dato y refresco la pagina
		if(ok==1){
			saveData(idFacturacion, pago);
			setTimeout ("window.location.reload(false);", 1000); 
			 
		}
	}

</script>


	
	<?php if(isset($Data_Pendientes)&&$Data_Pendientes==0&&$TotalGeneral!=0){ ?>
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
	<?php } ?>

	
	
	</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="<?php echo $original; ?>" class="btn btn-danger pull-right margin_form_btn" ><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Cancelar</a>
<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['submit_filter'])){
//Titulo con el Cliente		
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
unset($_SESSION['pagos_boletas_clientes']);
/*************************************************************/
//Verifico el tipo de usuario que esta ingresando
$z=" AND boleta_honorarios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************************************************/
//datos de la obra
$Docsubmit_filter   = '';
$location .= '?submit_filter=true';
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$Docsubmit_filter .= ' AND boleta_honorarios_facturacion.idCliente='.$_GET['idCliente'];
	$location .= '&idCliente='.$_GET['idCliente'];
}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){
	$Docsubmit_filter .= ' AND boleta_honorarios_facturacion.N_Doc='.$_GET['N_Doc'];
	$location .= '&N_Doc='.$_GET['N_Doc'];
}

		
//consulto todos los documentos relacionados al Cliente
$arrBoletas = array();
$query = "SELECT 
boleta_honorarios_facturacion.idFacturacion,
boleta_honorarios_facturacion.Creacion_fecha,
boleta_honorarios_facturacion.fecha_auto,
boleta_honorarios_facturacion.N_Doc,
boleta_honorarios_facturacion.ValorTotal,
boleta_honorarios_facturacion.idSistema,
boleta_honorarios_facturacion.idCliente,
core_sistemas.Nombre AS Sistema,
(SELECT SUM(MontoPagado) FROM `pagos_boletas_clientes` WHERE idFacturacion= boleta_honorarios_facturacion.idFacturacion LIMIT 1) AS MontoPagado

FROM `boleta_honorarios_facturacion`
LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema  = boleta_honorarios_facturacion.idSistema
				
WHERE (boleta_honorarios_facturacion.idFacturacion>0
".$Docsubmit_filter."
AND boleta_honorarios_facturacion.idTipo=2
AND boleta_honorarios_facturacion.idEstado=1
".$z.")
			
ORDER BY boleta_honorarios_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrBoletas,$row );
}
	

?> 

	
<div class="row inbox">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2><strong>Cliente : </strong><?php echo $rowCliente['Nombre']; ?></h2>
		<hr>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a style="display: none;" id="acep_1" href="<?php echo $location.'&next=true'; ?>" class="btn btn-primary pull-right margin_form_btn"><i class="fa fa-check-square-o" aria-hidden="true"></i> Aceptar</a>
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right margin_form_btn" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
	<div class="clearfix"></div>
</div>

							
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Boletas Pendientes de Pago</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Boleta</th>
						<th>F Emision</th>
						<th>Facturado</th>
						<th>Pagado</th>
						<th>Total a Pagar</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php
					if ($arrBoletas!=false && !empty($arrBoletas) && $arrBoletas!='') {
						foreach ($arrBoletas as $tipo){ ?>
							<tr class="odd">
								<td>
									<div class="checkbox checkbox-primary">
										<input id="checkbox_1_<?php echo $tipo['idFacturacion']; ?>" type="checkbox" onclick="onToggle(<?php echo $tipo['idFacturacion']; ?>)">
										<label for="checkbox_1_<?php echo $tipo['idFacturacion']; ?>">
											<?php echo 'Boleta N°'.$tipo['N_Doc']; ?>
										</label>
									</div>
								</td>
								<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
								<td align="right"><?php echo valores($tipo['ValorTotal'], 0); ?></td>
								<td align="right"><?php echo valores($tipo['MontoPagado'], 0); ?></td>
								<td align="right"><?php echo valores($tipo['ValorTotal']-($tipo['MontoPagado']), 0); ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_boleta_honorarios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									</div>
								</td>
							</tr>
						<?php 
							}
						} ?>
						

					<tr class="odd">
						<td align="right" colspan="2"><strong>Totales</strong></td>
						<td align="right"><strong id="final_val_1"></strong></td>
						<td align="right"><strong id="final_val_2"></strong></td>
						<td align="right"><strong id="final_val_3"></strong></td>
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
	function doSomething(number) {
		$.get("pago_boletas_cliente_execute.php?idFacturacion="+number);
		return false;
	}

	//////////////////////////////////////////////////////////
	function onToggle(number) {
		
		doSomething(number)
		
		
		//Variable con los totales
		let Total          = 0;
		let MontoCancelado = 0;
		let Totalgen       = 0;
	
		// check if checkbox is checked
		<?php foreach ($arrBoletas as $tipo){ ?>
						
			if (document.querySelector('#checkbox_1_<?php echo $tipo['idFacturacion']; ?>').checked) {
				
				Total = Total + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']); ?>;
				MontoCancelado = MontoCancelado + <?php echo Cantidades_decimales_justos($tipo['MontoPagado']); ?>;
				Totalgen = Totalgen + <?php echo Cantidades_decimales_justos($tipo['ValorTotal']-($tipo['MontoPagado'])); ?>;

			}
		<?php } ?>
		
		//Se escriben en los cuadros
		document.getElementById("final_val_1").innerHTML = number_format(Total, 0, ',', '.');
		document.getElementById("final_val_2").innerHTML = number_format(MontoCancelado, 0, ',', '.');
		document.getElementById("final_val_3").innerHTML = number_format(Totalgen, 0, ',', '.');

		//Verifico que el total general sea distinto de 0 y habilito el boton siguiente
		if(Totalgen!=0){
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
				if(isset($idCliente)){  $x1  = $idCliente; }else{$x1  = '';}
				if(isset($N_Doc)){         $x2  = $N_Doc;        }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 2, 'idCliente', 'Nombre', 'clientes_listado', $z, '', $dbConn);
				$Form_Inputs->form_input_number('N° Documento de Pago', 'N_Doc', $x2, 1);

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
