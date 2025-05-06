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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
// consulto los datos
$SIS_query = '
boleta_honorarios_facturacion.idTipo,
boleta_honorarios_facturacion.Creacion_fecha,
boleta_honorarios_facturacion.N_Doc,
boleta_honorarios_facturacion_tipo.Nombre AS BoletaTipo,
usuarios_listado.Nombre AS BoletaUsuario,
core_estado_facturacion.Nombre AS BoletaEstado,
boleta_honorarios_facturacion.MontoPagado,
sistema_documentos_pago.Nombre AS DocPago,
boleta_honorarios_facturacion.N_DocPago, 
boleta_honorarios_facturacion.F_Pago,
boleta_honorarios_facturacion.ValorNeto,
boleta_honorarios_facturacion.Impuesto,
boleta_honorarios_facturacion.ValorTotal,
boleta_honorarios_facturacion.Observaciones,
boleta_honorarios_facturacion.CentroCosto,
boleta_honorarios_facturacion.Porcentaje_Ret_Boletas,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

trabajadores_listado.Nombre AS Trab_Nombre,
trabajadores_listado.ApellidoPat AS Trab_ApellidoPat,
trabajadores_listado.ApellidoMat AS Trab_ApellidoMat,
trabajadores_listado.Cargo AS Trab_Cargo,
trabajadores_listado.Fono AS Trab_Fono,
trabajadores_listado.Rut AS Trab_Rut,
trabajadores_listado_tipos.Nombre AS Trab_Tipo,

clientes_listado.Nombre AS Cliente_Nombre,
clientes_listado.email AS Cliente_Email,
clientes_listado.Rut AS Cliente_Rut,
clienciudad.Nombre AS Cliente_Ciudad,
cliencomuna.Nombre AS Cliente_Comuna,
clientes_listado.Direccion AS Cliente_Direccion,
clientes_listado.Fono1 AS Cliente_Fono1,
clientes_listado.Fono2 AS Cliente_Fono2,
clientes_listado.Fax AS Cliente_Fax,
clientes_listado.PersonaContacto AS Cliente_PersonaContacto,
clientes_listado.Giro AS Cliente_Giro,

proveedor_listado.Nombre AS Proveedor_Nombre,
proveedor_listado.email AS Proveedor_Email,
proveedor_listado.Rut AS Proveedor_Rut,
provciudad.Nombre AS Proveedor_Ciudad,
provcomuna.Nombre AS Proveedor_Comuna,
proveedor_listado.Direccion AS Proveedor_Direccion,
proveedor_listado.Fono1 AS Proveedor_Fono1,
proveedor_listado.Fono2 AS Proveedor_Fono2,
proveedor_listado.Fax AS Proveedor_Fax,
proveedor_listado.PersonaContacto AS Proveedor_PersonaContacto,
proveedor_listado.Giro AS Proveedor_Giro';
$SIS_join  = '
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador            = boleta_honorarios_facturacion.idTrabajador
LEFT JOIN `trabajadores_listado_tipos`              ON trabajadores_listado_tipos.idTipo            = trabajadores_listado.idTipo
LEFT JOIN `clientes_listado`                        ON clientes_listado.idCliente                   = boleta_honorarios_facturacion.idCliente
LEFT JOIN `core_ubicacion_ciudad`    clienciudad    ON clienciudad.idCiudad                         = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   cliencomuna    ON cliencomuna.idComuna                         = clientes_listado.idComuna
LEFT JOIN `boleta_honorarios_facturacion_tipo`      ON boleta_honorarios_facturacion_tipo.idTipo    = boleta_honorarios_facturacion.idTipo
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                   = boleta_honorarios_facturacion.idUsuario
LEFT JOIN `core_estado_facturacion`                 ON core_estado_facturacion.idEstado             = boleta_honorarios_facturacion.idEstado
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema                     = boleta_honorarios_facturacion.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                       = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                       = sistema_origen.idComuna
LEFT JOIN `sistema_documentos_pago`                 ON sistema_documentos_pago.idDocPago            = boleta_honorarios_facturacion.idDocPago
LEFT JOIN `proveedor_listado`                       ON proveedor_listado.idProveedor                = boleta_honorarios_facturacion.idProveedor
LEFT JOIN `core_ubicacion_ciudad`    provciudad     ON provciudad.idCiudad                          = proveedor_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   provcomuna     ON provcomuna.idComuna                          = proveedor_listado.idComuna';
$SIS_where = 'boleta_honorarios_facturacion.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'boleta_honorarios_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se consulta
$SIS_query = 'Nombre,vTotal';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'boleta_honorarios_facturacion_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOtros');

/*****************************************/
// Se consulta
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 0;
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'boleta_honorarios_facturacion_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

/*****************************************/
// Se consulta
$SIS_query = '
boleta_honorarios_facturacion_historial.Creacion_fecha, 
boleta_honorarios_facturacion_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = boleta_honorarios_facturacion_historial.idTipo
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = boleta_honorarios_facturacion_historial.idUsuario';
$SIS_where = 'boleta_honorarios_facturacion_historial.idFacturacion ='.$X_Puntero;
$SIS_order = 'boleta_honorarios_facturacion_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'boleta_honorarios_facturacion_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/*****************************************/
// Se consulta
$SIS_query = '
sistema_documentos_pago.Nombre,
pagos_boletas_trabajadores.N_DocPago,
pagos_boletas_trabajadores.F_Pago,
pagos_boletas_trabajadores.MontoPagado,
usuarios_listado.Nombre AS UsuarioPago';
$SIS_join  = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_boletas_trabajadores.idDocPago
LEFT JOIN `usuarios_listado`           ON usuarios_listado.idUsuario           = pagos_boletas_trabajadores.idUsuario';
$SIS_where = 'pagos_boletas_trabajadores.idFacturacion ='.$X_Puntero;
$SIS_order = 'pagos_boletas_trabajadores.F_Pago ASC';
$arrPagosTrab = array();
$arrPagosTrab = db_select_array (false, $SIS_query, 'pagos_boletas_trabajadores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagosTrab');

/*****************************************/
// Se consulta
$SIS_query = '
sistema_documentos_pago.Nombre,
pagos_boletas_clientes.N_DocPago,
pagos_boletas_clientes.F_Pago,
pagos_boletas_clientes.MontoPagado,
usuarios_listado.Nombre AS UsuarioPago';
$SIS_join  = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_boletas_clientes.idDocPago
LEFT JOIN `usuarios_listado`           ON usuarios_listado.idUsuario           = pagos_boletas_clientes.idUsuario';
$SIS_where = 'pagos_boletas_clientes.idFacturacion ='.$X_Puntero;
$SIS_order = 'pagos_boletas_clientes.F_Pago ASC';
$arrPagosClien = array();
$arrPagosClien = db_select_array (false, $SIS_query, 'pagos_boletas_clientes', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagosClien');

/*****************************************/
// Se consulta
$SIS_query = '
sistema_documentos_pago.Nombre,
pagos_boletas_empresas.N_DocPago,
pagos_boletas_empresas.F_Pago,
pagos_boletas_empresas.MontoPagado,
usuarios_listado.Nombre AS UsuarioPago';
$SIS_join  = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_boletas_empresas.idDocPago
LEFT JOIN `usuarios_listado`           ON usuarios_listado.idUsuario           = pagos_boletas_empresas.idUsuario';
$SIS_where = 'pagos_boletas_empresas.idFacturacion ='.$X_Puntero;
$SIS_order = 'pagos_boletas_empresas.F_Pago ASC';
$arrPagosProv = array();
$arrPagosProv = db_select_array (false, $SIS_query, 'pagos_boletas_empresas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagosProv');

//Si el documento esta pagado se muestran los datos relacionados al pago
if($rowData['MontoPagado']!=0){ ?>
	<div class="" style="margin-top:10px;">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h6 class="panel-title"><i class="fa fa-usd" aria-hidden="true"></i> Pagos Relacionados</h6>
				</div>
				<div class="panel-body">
					<div class="row invoice-payment">
						<table class="table">
							<thead>
								<tr role="row">
									<th>Encargado</th>
									<th>Documento</th>
									<th>Fecha</th>
									<th>Monto</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrPagosTrab as $pagos) { ?>
									<tr class="odd">
										<td><?php echo $pagos['UsuarioPago']; ?></td>
										<td><?php echo $pagos['Nombre'];if(isset($pagos['N_DocPago'])&&$pagos['N_DocPago']!=''){echo ' Doc N° '.$pagos['N_DocPago'];} ?></td>
										<td><?php echo fecha_estandar($pagos['F_Pago']); ?></td>
										<td align="right" style="padding-right: 22px !important;"><?php echo Valores($pagos['MontoPagado'], 0); ?></td>
									</tr>
								<?php } ?>
								<?php foreach ($arrPagosClien as $pagos) { ?>
									<tr class="odd">
										<td><?php echo $pagos['UsuarioPago']; ?></td>
										<td><?php echo $pagos['Nombre'];if(isset($pagos['N_DocPago'])&&$pagos['N_DocPago']!=''){echo ' Doc N° '.$pagos['N_DocPago'];} ?></td>
										<td><?php echo fecha_estandar($pagos['F_Pago']); ?></td>
										<td align="right" style="padding-right: 22px !important;"><?php echo Valores($pagos['MontoPagado'], 0); ?></td>
									</tr>
								<?php } ?>
								<?php foreach ($arrPagosProv as $pagos) { ?>
									<tr class="odd">
										<td><?php echo $pagos['UsuarioPago']; ?></td>
										<td><?php echo $pagos['Nombre'];if(isset($pagos['N_DocPago'])&&$pagos['N_DocPago']!=''){echo ' Doc N° '.$pagos['N_DocPago'];} ?></td>
										<td><?php echo fecha_estandar($pagos['F_Pago']); ?></td>
										<td align="right" style="padding-right: 22px !important;"><?php echo Valores($pagos['MontoPagado'], 0); ?></td>
									</tr>
								<?php } ?>
								                 
							</tbody>
						</table>
					</div>

					<div class="row invoice-payment">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"></div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tbody>
									<tr>
										<th>Monto Pagado:</th>
										<td align="right"><?php echo Valores($rowData['MontoPagado'], 0) ?></td>
									</tr>
									<tr>
										<th>Monto Facturado:</th>
										<td align="right"><?php echo Valores($rowData['ValorTotal'], 0) ?></td>
									</tr>
									<tr>
										<th>Diferencia:</th>
										<?php
										$diferencia = $rowData['MontoPagado'] - $rowData['ValorTotal'];
										if($diferencia<0){
											echo '<td align="right" class="text-danger"><h6><i class="fa fa-arrow-down" aria-hidden="true"></i> '.Valores($diferencia, 0).'</h6></td>';
										}elseif($diferencia>0){
											echo '<td align="right" class="text-info"><h6><i class="fa fa-arrow-up" aria-hidden="true"></i> '.Valores($diferencia, 0).'</h6></td>';
										}else{
											echo '<td align="right"><h6>Pago OK</h6></td>';
										}
										?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="clearfix"></div>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['BoletaTipo']?>.
				<small class="pull-right">Boleta N°: <?php echo n_doc($rowData['N_Doc'], 8) ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php
		//se verifica el tipo de movimiento
		switch ($rowData['idTipo']) {
			//Boleta Trabajadores
			case 1:
				echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Emisor
					<address>
						<strong>'.$rowData['Trab_Nombre'].' '.$rowData['Trab_ApellidoPat'].' '.$rowData['Trab_ApellidoMat'].'</strong><br/>
						Rut: '.$rowData['Trab_Rut'].'<br/>
						Fono: '.formatPhone($rowData['Trab_Fono']).'<br/>
						Cargo: '.$rowData['Trab_Cargo'].'<br/>
						Tipo Cargo: '.$rowData['Trab_Tipo'].'<br/>
						Centro de Costo: '.$rowData['CentroCosto'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Receptor
					<address>
						<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
						'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						'.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Fecha Creacion : </strong>'.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
					<strong>Usuario Ingreso : </strong>'.$rowData['BoletaUsuario'].'<br/>';

					if(isset($rowData['BoletaEstado'])&&$rowData['BoletaEstado']!=''){
						echo '<strong>Estado: </strong>'.$rowData['BoletaEstado'].'<br/>';
					}
					if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						echo '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						echo '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}

				echo '</div>';

				break;
			//Boleta Clientes
			case 2:
				echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Emisor
					<address>
						<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
						'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						'.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Receptor
					<address>
						<strong>'.$rowData['Cliente_Nombre'].'</strong><br/>
						'.$rowData['Cliente_Ciudad'].', '.$rowData['Cliente_Comuna'].'<br/>
						'.$rowData['Cliente_Direccion'].'<br/>
						Fono Fijo: '.formatPhone($rowData['Cliente_Fono1']).'<br/>
						Celular: '.formatPhone($rowData['Cliente_Fono2']).'<br/>
						Fax: '.$rowData['Cliente_Fax'].'<br/>
						Rut: '.$rowData['Cliente_Rut'].'<br/>
						Email: '.$rowData['Cliente_Email'].'<br/>
						Contacto: '.$rowData['Cliente_PersonaContacto'].'<br/>
						Giro de la Empresa: '.$rowData['Cliente_Giro'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Fecha Creacion : </strong>'.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
					<strong>Usuario Ingreso : </strong>'.$rowData['BoletaUsuario'].'<br/>';

					if(isset($rowData['BoletaEstado'])&&$rowData['BoletaEstado']!=''){
						echo '<strong>Estado: </strong>'.$rowData['BoletaEstado'].'<br/>';
					}
					if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						echo '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						echo '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}
					
				echo '</div>';
				
				break;
			//Boleta Empresas
			case 3:
				echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Emisor
					<address>
						<strong>'.$rowData['Proveedor_Nombre'].'</strong><br/>
						'.$rowData['Proveedor_Ciudad'].', '.$rowData['Proveedor_Comuna'].'<br/>
						'.$rowData['Proveedor_Direccion'].'<br/>
						Fono Fijo: '.formatPhone($rowData['Proveedor_Fono1']).'<br/>
						Celular: '.formatPhone($rowData['Proveedor_Fono2']).'<br/>
						Fax: '.$rowData['Proveedor_Fax'].'<br/>
						Rut: '.$rowData['Proveedor_Rut'].'<br/>
						Email: '.$rowData['Proveedor_Email'].'<br/>
						Contacto: '.$rowData['Proveedor_PersonaContacto'].'<br/>
						Giro de la Empresa: '.$rowData['Proveedor_Giro'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Receptor
					<address>
						<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
						'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						'.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Fecha Creacion : </strong>'.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
					<strong>Usuario Ingreso : </strong>'.$rowData['BoletaUsuario'].'<br/>';

					if(isset($rowData['BoletaEstado'])&&$rowData['BoletaEstado']!=''){
						echo '<strong>Estado: </strong>'.$rowData['BoletaEstado'].'<br/>';
					}
					if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						echo '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						echo '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}

				echo '</div>';

				break;
		} ?>

	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Detalle</th>
						<th width="120" align="right">Valor Total</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrOtros!=false && !empty($arrOtros) && $arrOtros!='') { ?>
						<?php foreach ($arrOtros as $otro) { ?>
							<tr>
								<td><?php echo $otro['Nombre']; ?></td>
								<td align="right"><?php echo Valores($otro['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
			<table class="table">
				<tbody>
					<?php if(isset($rowData['ValorNeto'])&&$rowData['ValorNeto']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Total Honorarios</strong></td>
							<td width="160" align="right"><?php echo Valores($rowData['ValorNeto'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto'])&&$rowData['Impuesto']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $rowData['Porcentaje_Ret_Boletas'].'%'; ?> Impuesto Retenido</strong></td>
							<td width="160" align="right"><?php echo Valores($rowData['Impuesto'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['ValorTotal'])&&$rowData['ValorTotal']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Total</strong></td>
							<td align="right"><?php echo Valores($rowData['ValorTotal'], 0); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
		</div>
	</div>

	<?php
	//Gasto de Productos
	if($rowData['idTipo']==3){ ?>
		<div class="row firma">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont"><p>Firma Emisor</p></div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont" style="left:50%;"><p>Firma Trabajador</p></div>
		</div>
	<?php } ?>

	<?php
	//Traspaso de Productos a otra Empresa
	if($rowData['idTipo']==6){ ?>
		<div class="row firma">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont"><p>Firma Transportista</p></div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont" style="left:50%;"><p>Firma Receptor</p></div>
		</div>
	<?php } ?>

	<?php
	$zz  = '?idSistema='.simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual());
	$zz .= '&view='.$_GET['view'];
	?>
	<div class="row no-print">
		<div class="col-xs-12">
			<a target="new" href="view_boleta_honorarios_to_print.php<?php echo $zz ?>" class="btn btn-default">
				<i class="fa fa-print" aria-hidden="true"></i> Imprimir
			</a>

			<a target="new" href="view_boleta_honorarios_to_pdf.php<?php echo $zz ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
				<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF
			</a>
		</div>
	</div>
      
</section>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">

	<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="3">Historial</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th>Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>

	<?php if ($arrArchivo!=false && !empty($arrArchivo) && $arrArchivo!=''){ ?>
		<table id="items" style="margin-bottom: 20px;">
			<tbody>
				<tr>
					<th colspan="6">Archivos Adjuntos</th>
				</tr>
				<?php foreach ($arrArchivo as $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $producto['Nombre']; ?></td>
						<td width="160">
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="1download.php?dir=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip" ><i class="fa fa-download" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
    
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
