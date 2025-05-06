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
require_once 'core/Load.Utils.Print.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
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

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Print.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
$html ='<section class="invoice">';
$html .= '<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> '.$rowData['BoletaTipo'].'
				<small class="pull-right">Boleta N°: '.n_doc($rowData['N_Doc'], 8).'</small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">';

		//se verifica el tipo de movimiento
		switch ($rowData['idTipo']) {
			//Boleta Trabajadores
			case 1:
				$html .= '
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
						$html .= '<strong>Estado: </strong>'.$rowData['BoletaEstado'].'<br/>';
					}
					if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						$html .= '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						$html .= '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}
					
				$html .= '</div>';

				break;
			//Boleta Clientes
			case 2:
				$html .= '
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
						$html .= '<strong>Estado: </strong>'.$rowData['BoletaEstado'].'<br/>';
					}
					if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						$html .= '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						$html .= '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}
					
				$html .= '
				</div>';
				
				break;
			//Boleta Empresas
			case 3:
				$html .= '
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
						$html .= '<strong>Estado: </strong>'.$rowData['BoletaEstado'].'<br/>';
					}
					if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						$html .= '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						$html .= '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}
					
				$html .= '</div>';

				break;
		}
		
    
	$html .= '</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Detalle</th>
						<th width="120" align="right">Valor Total</th>
					</tr>
				</thead>
				<tbody>';
					//si existen guias
					if ($arrOtros!=false && !empty($arrOtros) && $arrOtros!='') {
						foreach ($arrOtros as $otro) {
							$html .= '<tr>
								<td style="vertical-align: top;">'.$otro['Nombre'].'</td>
								<td align="right">'.Valores($otro['vTotal'], 0).'</td>
							</tr>';
						}
					}
				$html .= '</tbody>
			</table>

			<table class="table">
				<tbody>';	
					if(isset($rowData['ValorNeto'])&&$rowData['ValorNeto']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right"><strong>Total Honorarios</strong></td>
							<td width="160" align="right">'.Valores($rowData['ValorNeto'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto'])&&$rowData['Impuesto']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right"><strong>'.$rowData['Porcentaje_Ret_Boletas'].'% Impuesto Retenido</strong></td>
							<td align="right">'.Valores($rowData['Impuesto'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['ValorTotal'])&&$rowData['ValorTotal']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right"><strong>Total</strong></td>
							<td align="right">'.Valores($rowData['ValorTotal'], 0).'</td>
						</tr>';
					}

				$html .= '</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" >'.$rowData['Observaciones'].'</p>
		</div>
	</div>';

$html .= '</section>';
echo $html;
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
