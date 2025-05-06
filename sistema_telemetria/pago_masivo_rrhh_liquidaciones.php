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
$original = "pago_masivo_rrhh_liquidaciones.php";
$location = $original;   
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
/************************************************************/
//formulario para borrar
if (!empty($_GET['del_liquidacion'])){
	//Se agregan ubicaciones
	$location .= '?submit_filter=true';
	$location .= '&idFacturacion='.$_GET['idFacturacion'];
	//Llamamos al formulario
	$form_trabajo= 'del_liquidacion';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_rrhh_liquidaciones.php';
}
/************************************************************/
//formulario para crear
if (!empty($_POST['submit_form'])){
	//Llamamos al formulario
	$form_trabajo= 'pago_general';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_rrhh_liquidaciones.php';
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

/******************************************************************/
//Se verifica el saldo de los pagos anticipados
$SIS_query = 'Creacion_fecha, Creacion_mes, Creacion_ano, Fecha_desde, Fecha_hasta';
$SIS_join  = '';
$SIS_where = 'idFacturacion='.$_GET['idFacturacion'];
$rowFacturacion = db_select_data (false, $SIS_query, 'rrhh_sueldos_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'next');

/******************************************************************/
//Se crea el select con todas las facturas que se estan pagando
$Form_Inputs = new Inputs();	

					
?>

<div class="row inbox">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2>
			<strong>Facturacion : </strong><?php echo numero_a_mes($rowFacturacion['Creacion_mes']).' '.$rowFacturacion['Creacion_ano'].' ('.Fecha_estandar($rowFacturacion['Creacion_fecha']).')' ?><br/>
			<?php echo 'Desde el '.Fecha_estandar($rowFacturacion['Fecha_desde']).' hasta el '.Fecha_estandar($rowFacturacion['Fecha_hasta']); ?>
		</h2>
		<hr>
	</div>
</div>
										
<div class="row inbox">
								
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Liquidaciones Pendientes de Pago</h5>
				<div class="toolbar">
					<a onclick="addpagoTodos()" class="btn btn-xs btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Asignar Todos</a>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th width="10">Acciones</th>
							<th>Nombre</th>
							<th width="120">Rut</th>
							<th width="120">Alcance Liquido</th>
							<th width="120">Total Deberes</th>
							<th width="120">Renta a Pagar</th>
							<th width="120">Pagado</th>
							<th width="120">Total a Pagar</th>
							<th width="10">Opc</th>
						</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							//registros aceptados
							$Registro_total = 0;
							$Registro_ok    = 0;
							//total del monto a pagar
							$TotalGeneral = 0;
							//se recorre
							if(isset($_SESSION['pago_rrhh_liquidaciones'])){
								foreach ($_SESSION['pago_rrhh_liquidaciones'] as $key => $tipo){
									$TotalPagar = valores_enteros($tipo['TotalAPagar'] - $tipo['MontoPagado']);

									$Registro_total++; ?>
									<tr class="odd">
										<td>
											<div class="btn-group" style="width: 70px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_rrhh_sueldos.php?view='.simpleEncode($tipo['idFactTrab'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=2){
													$ubicacion = $location.'&del_liquidacion='.$tipo['idFactTrab'].'&idFacturacion='.$_GET['idFacturacion'];
													$dialogo   = '¿Realmente deseas eliminar la liquidacion de '.$tipo['TrabajadorNombre'].'?'; ?>
													<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Eliminar" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php } ?>
											</div>
										</td>
										<td><?php echo $tipo['TrabajadorNombre']; ?></td>
										<td><?php echo $tipo['TrabajadorRut']; ?></td>
										<td align="right"><?php echo valores($tipo['TotalHaberes'], 0); ?></td>
										<td align="right"><?php echo valores($tipo['TotalDescuentos'], 0); ?></td>
										<td align="right"><?php echo valores($tipo['TotalAPagar'], 0); ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0); ?></td>
										<td align="right">
											<?php 
												if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=''){
													echo valores($tipo['ValorPagado'], 0);
													$TotalGeneral = $TotalGeneral + $tipo['ValorPagado'];
													$Registro_ok++;
												}else{
													$Form_Inputs->input_values_val('text','Total a Pagar','ingpago_'.$tipo['idFactTrab'],2,'','',$TotalPagar);
												}
												?>
										</td>
										<td align="right">
											<?php if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']!=0){ ?>
												<a onclick="delpago(<?php echo $tipo['idFactTrab']; ?>)"  title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php }else{ ?>
												<a onclick="addpago(<?php echo $tipo['idFactTrab']; ?>, <?php echo $TotalPagar; ?>)"  title="Asignar datos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
											<?php } ?>
										</td>

									</tr>
							<?php 
								}
							} ?>
							<tr class="odd">
								<td style="background-color: #E5E5E5;" align="right" colspan="7"><strong>Totales</strong></td>
								<td style="background-color: #E5E5E5;" align="right"><strong><?php echo valores($TotalGeneral, 0); ?></strong></td>
								<td style="background-color: #E5E5E5;"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	
		 


<script>
	//////////////////////////////////////////////////////////
	function saveData(number, pago) {
		$.get("pago_masivo_rrhh_liquidaciones_ok_save.php?idFactTrab="+number+"&pago="+pago);
		return false;
	}
	//////////////////////////////////////////////////////////
	function delData(number) {
		$.get("pago_masivo_rrhh_liquidaciones_ok_delete.php?idFactTrab="+number);
		return false;
	}
	//////////////////////////////////////////////////////////
	function addpago(number, maximo) {

		let pago        = parseInt(document.getElementById("ingpago_"+number).value);
		let maxs        = parseInt(maximo);
		let pago_x      = document.getElementById("ingpago_"+number).value;
		let ok          = 0;

		//Verificaciones
		if (pago_x != "") { ok++; }else{ alert("No ha ingresado un valor de pago");}
		if (pago>maxs){ok--;alert("El valor que intenta cancelar es superior al maximo permitido");}

		//Guardo el dato y refresco la pagina
		if(ok==1){
			saveData(number, pago);
			setTimeout ("window.location.reload(false);", 1000); 
			 
		}
	}
	//////////////////////////////////////////////////////////
	function addpago_2(number, maximo) {
		
		let pago        = parseInt(document.getElementById("ingpago_"+number).value);
		let maxs        = parseInt(maximo);
		let pago_x      = document.getElementById("ingpago_"+number).value;
		let ok          = 0;

		//Verificaciones
		if (pago_x != "") { ok++; }else{ alert("No ha ingresado un valor de pago");}
		if (pago>maxs){ok--;alert("El valor que intenta cancelar es superior al maximo permitido");}

		//Guardo el dato y refresco la pagina
		if(ok==1){
			saveData(number, pago);
		}
	}
	//////////////////////////////////////////////////////////
	function addpagoTodos() {
		
		<?php
		//////////////////////////////////////////////////////
		if(isset($_SESSION['pago_rrhh_liquidaciones'])){
			foreach ($_SESSION['pago_rrhh_liquidaciones'] as $key => $tipo){
				//verifico que sean facturas o boletas
				if(isset($tipo['ValorPagado'])&&$tipo['ValorPagado']==0){
					$TotalPagar = valores_enteros($tipo['TotalAPagar'] - $tipo['MontoPagado']);							
					//llamo al script
					echo "addpago_2(".$tipo['idFactTrab'].", ".$TotalPagar.");";
				}
			}
		}
		?>
		
		setTimeout ("window.location.reload(false);", 1000);
	}
	//////////////////////////////////////////////////////////
	function delpago(number) {

		//Guardo el dato y refresco la pagina
		delData(number);
		setTimeout ("window.location.reload(false);", 1000); 	 
		
	}
	

</script>

							
<?php if($Registro_total==$Registro_ok){ ?>
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">

		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Ingresar Pago Documentos</h5>
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
					$Form_Inputs->form_post_data(1,1,1, 'Poner la fecha futura en el caso de cheques, depositos a plazo o situaciones especificas, para el resto, como por ejemplo efectivo, utilizar el mismo dia' );
					$Form_Inputs->form_date('Fecha Vencimiento','F_Pago', $x3, 2);

					echo '<div class="form-group" id="div_">
							<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Valor a Pagar</label>
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
								<input type="text" placeholder="Valor de la Factura" class="form-control"  name="escribeme" id="escribeme" disabled value="'.Valores($TotalGeneral, 0).'">
							</div>
						</div>';
						
						
						
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);

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
					<div class="modal-header">Confirmar Pago</div>
					<div class="modal-body"><p id="confirmacion"></p></div>
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
//Titulo con el proveedor		
$SIS_query = 'Creacion_fecha, Creacion_mes, Creacion_ano, Fecha_desde, Fecha_hasta';
$SIS_join  = '';
$SIS_where = 'idFacturacion='.$_GET['idFacturacion'];
$rowFacturacion = db_select_data (false, $SIS_query, 'rrhh_sueldos_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'submit_filter');

//Borro todos los datos al cargar
unset($_SESSION['pago_rrhh_liquidaciones']);

/**********************************************************************************************/
//datos de la obra
$location .= '?submit_filter=true';
$location .= '&idFacturacion='.$_GET['idFacturacion'];

// Se trae un listado con todos los trabajadores
$arrTrabajador = array();
$arrTrabajador = db_select_array (false, 'idFactTrab,TrabajadorNombre,TrabajadorRut,TotalHaberes,TotalDescuentos,TotalAPagar,MontoPagado', 'rrhh_sueldos_facturacion_trabajadores', '', 'idFacturacion ='.$_GET['idFacturacion'].' AND TotalAPagar>MontoPagado', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTrabajador');

?>

<div class="row inbox">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2>
			<strong>Facturacion : </strong><?php echo numero_a_mes($rowFacturacion['Creacion_mes']).' '.$rowFacturacion['Creacion_ano'].' ('.Fecha_estandar($rowFacturacion['Creacion_fecha']).')' ?><br/>
			<?php echo 'Desde el '.Fecha_estandar($rowFacturacion['Fecha_desde']).' hasta el '.Fecha_estandar($rowFacturacion['Fecha_hasta']); ?>
		</h2>
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Liquidaciones Pendientes de Pago</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Nombre</th>
								<th width="120">Rut</th>
								<th width="120">Alcance Liquido</th>
								<th width="120">Total Deberes</th>
								<th width="120">Renta a Pagar</th>
								<th width="120">Pagado</th>
								<th width="120">Total a Pagar</th>
								<th width="10">Acciones</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							if ($arrTrabajador!=false && !empty($arrTrabajador) && $arrTrabajador!='') {
								foreach ($arrTrabajador as $tipo){
									$TotalPagar = $tipo['TotalAPagar'] - $tipo['MontoPagado'];
									?>
									<tr class="odd">
										<td>
											<div class="checkbox checkbox-primary">
												<input id="checkbox_1_<?php echo $tipo['idFactTrab']; ?>" type="checkbox" onclick="onToggle(<?php echo $tipo['idFactTrab']; ?>)">
												<label for="checkbox_1_<?php echo $tipo['idFactTrab']; ?>">
													<?php echo $tipo['TrabajadorNombre']; ?>
												</label>
											</div>
										</td>
										<td><?php echo $tipo['TrabajadorRut']; ?></td>
										<td align="right"><?php echo valores($tipo['TotalHaberes'], 0); ?></td>
										<td align="right"><?php echo valores($tipo['TotalDescuentos'], 0); ?></td>
										<td align="right"><?php echo valores($tipo['TotalAPagar'], 0); ?></td>
										<td align="right"><?php echo valores($tipo['MontoPagado'], 0); ?></td>
										<td align="right"><?php echo valores($TotalPagar, 0); ?></td>

										<td>
											<div class="btn-group" style="width: 35px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_rrhh_sueldos.php?view='.simpleEncode($tipo['idFactTrab'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
		$.get("pago_masivo_rrhh_liquidaciones_execute.php?idFactTrab="+number);
		return false;
	}

	//////////////////////////////////////////////////////////
	function onToggle(number) {

		//guardar los datos marcados
		doSomething(number);
							
		//Variable con los totales
		let TotalAPagar = 0;
		let MontoPagado = 0;
		let MontoAPagar = 0;
	
		// check if checkbox is checked
		<?php foreach ($arrTrabajador as $tipo){ ?>
						
			if (document.querySelector('#checkbox_1_<?php echo $tipo['idFactTrab']; ?>').checked) {
				
				TotalAPagar = TotalAPagar + <?php echo Cantidades_decimales_justos($tipo['TotalAPagar']); ?>;
				MontoPagado = MontoPagado + <?php echo Cantidades_decimales_justos($tipo['MontoPagado']); ?>;
				MontoAPagar = MontoAPagar + <?php echo Cantidades_decimales_justos($tipo['TotalAPagar']-($tipo['MontoPagado'])); ?>;
			}
		<?php } ?>
		
		
		//Se escriben en los cuadros
		document.getElementById("final_val_1").innerHTML = number_format(TotalAPagar, 0, ',', '.');
		document.getElementById("final_val_2").innerHTML = number_format(MontoPagado, 0, ',', '.');
		document.getElementById("final_val_3").innerHTML = number_format(MontoAPagar, 0, ',', '.');

		//Verifico que el total general sea distinto de 0 y habilito el boton siguiente
		if(MontoAPagar>0){
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
$arrSelect = array();
$arrSelect = db_select_array (false, 'idFacturacion,Creacion_ano,Creacion_mes', 'rrhh_sueldos_facturacion', '', 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'], 'Creacion_fecha DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSelect');

$_SESSION['form_require'].=',idFacturacion';
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
				$input  = '<link rel="stylesheet" href="'.DB_SITE_REPO.'/LIBS_js/chosen/chosen.css">';
				$input .= '<div class="form-group" id="div_idFacturacion">
								<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_idFacturacion">Facturacion Fecha</label>
								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
									<select name="idFacturacion" id="idFacturacion" required data-placeholder="Seleccione una Opción" class="form-control chosen-select chosendiv_idFacturacion " tabindex="2" >
										<option value=""></option>';
											
											foreach ( $arrSelect as $select ) {
												$input .= '<option value="'.$select['idFacturacion'].'"  >Facturacion de '.numero_a_mes($select['Creacion_mes']).' '.$select['Creacion_ano'].'</option>';
											}
						$input .= '</select>
								</div>
							</div>

							<script type="text/javascript">
										
								$.fn.oldChosen = $.fn.chosen
								$.fn.chosen = function(options) {
									 var selectcz_idFacturacion = $(".chosendiv_idFacturacion")
										, is_creating_chosen = !!options

									if (is_creating_chosen && selectcz_idFacturacion.css(\'position\') === \'absolute\') {
										selectcz_idFacturacion.removeAttr(\'style\')
									}

									var ret = selectcz_idFacturacion.oldChosen(options)

									if (is_creating_chosen) {
										selectcz_idFacturacion.attr(\'style\',\'display:visible; position:absolute; clip:rect(0,0,0,0)\');
										selectcz_idFacturacion.attr(\'tabindex\', -1);
									}
									 return ret
								}
								$(\'selectcz_idFacturacion\').chosen({allow_single_deselect: true});

							</script>
						<style>
							#div_idFacturacion .chosen-single {background:url('.DB_SITE_REPO.'/LIB_assets/img/required.png) no-repeat 5px center !important;background-color: #fff !important;}
						</style>';
					

					echo $input;

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
