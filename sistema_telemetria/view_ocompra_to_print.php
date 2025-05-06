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
ocompra_listado.Creacion_fecha,
ocompra_listado.Observaciones,

usuarios_listado.Nombre AS NombreUsuario,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,
sistema_origen.Rubro AS SistemaOrigenRubro,
sistema_origen.Config_imgLogo AS SistemaLogo,

proveedor_listado.Nombre AS NombreProveedor,
proveedor_listado.email AS EmailProveedor,
proveedor_listado.Rut AS RutProveedor,
provciudad.Nombre AS CiudadProveedor,
provcomuna.Nombre AS ComunaProveedor,
proveedor_listado.Direccion AS DireccionProveedor,
proveedor_listado.Fono1 AS Fono1Proveedor,
proveedor_listado.Fono2 AS Fono2Proveedor,
proveedor_listado.Fax AS FaxProveedor,
proveedor_listado.PersonaContacto AS PersonaContactoProveedor,
proveedor_listado.Giro AS GiroProveedor,
proveedor_listado.FormaPago AS FormaPagoProveedor ,

core_oc_estado.Nombre AS Estado,
ocompra_listado.idEstado,
ocompra_listado.idSistema';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario       = ocompra_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema         = ocompra_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad           = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna           = sistema_origen.idComuna
LEFT JOIN `proveedor_listado`                       ON proveedor_listado.idProveedor    = ocompra_listado.idProveedor
LEFT JOIN `core_ubicacion_ciudad`    provciudad     ON provciudad.idCiudad              = proveedor_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   provcomuna     ON provcomuna.idComuna              = proveedor_listado.idComuna
LEFT JOIN `core_oc_estado`                          ON core_oc_estado.idEstado          = ocompra_listado.idEstado';
$SIS_where = 'ocompra_listado.idOcompra ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');
 
/*****************************************/
//Insumos
$SIS_query = '
insumos_listado.Nombre,
ocompra_listado_existencias_insumos.Cantidad,
ocompra_listado_existencias_insumos.vUnitario,
ocompra_listado_existencias_insumos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`          ON insumos_listado.idProducto    = ocompra_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`    ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'ocompra_listado_existencias_insumos.idOcompra ='.$X_Puntero;
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

/*****************************************/
//Productos
$SIS_query = '
productos_listado.Nombre,
ocompra_listado_existencias_productos.Cantidad,
ocompra_listado_existencias_productos.vUnitario,
ocompra_listado_existencias_productos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `productos_listado`          ON productos_listado.idProducto    = ocompra_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml`      ON sistema_productos_uml.idUml     = productos_listado.idUml';
$SIS_where = 'ocompra_listado_existencias_productos.idOcompra ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
//Arriendos
$SIS_query = '
equipos_arriendo_listado.Nombre,
ocompra_listado_existencias_arriendos.Cantidad,
ocompra_listado_existencias_arriendos.vUnitario,
ocompra_listado_existencias_arriendos.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `equipos_arriendo_listado`    ON equipos_arriendo_listado.idEquipo     = ocompra_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_tiempo_frecuencia`      ON core_tiempo_frecuencia.idFrecuencia   = ocompra_listado_existencias_arriendos.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_arriendos.idOcompra ='.$X_Puntero;
$SIS_order = 'equipos_arriendo_listado.Nombre ASC';
$arrArriendos = array();
$arrArriendos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_arriendos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArriendos');

/*****************************************/
//Servicios
$SIS_query = '
servicios_listado.Nombre,
ocompra_listado_existencias_servicios.Cantidad,
ocompra_listado_existencias_servicios.vUnitario,
ocompra_listado_existencias_servicios.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `servicios_listado`       ON servicios_listado.idServicio          = ocompra_listado_existencias_servicios.idServicio
LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia   = ocompra_listado_existencias_servicios.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_servicios.idOcompra ='.$X_Puntero;
$SIS_order = 'servicios_listado.Nombre ASC';
$arrServicios = array();
$arrServicios = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrServicios');

/*****************************************/
//Otros
$SIS_query = '
ocompra_listado_existencias_otros.Nombre,
ocompra_listado_existencias_otros.Cantidad,
ocompra_listado_existencias_otros.vUnitario,
ocompra_listado_existencias_otros.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = 'LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_otros.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_otros.idOcompra ='.$X_Puntero;
$SIS_order = 'ocompra_listado_existencias_otros.Nombre ASC';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOtros');

/*****************************************/
//Boletas Trabajadores
$SIS_query = '
ocompra_listado_existencias_boletas.N_Doc,
ocompra_listado_existencias_boletas.Descripcion,
ocompra_listado_existencias_boletas.Valor,
trabajadores_listado.Rut AS TrabRut,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat';
$SIS_join  = 'LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador = ocompra_listado_existencias_boletas.idTrabajador';
$SIS_where = 'ocompra_listado_existencias_boletas.idOcompra ='.$X_Puntero;
$SIS_order = 'ocompra_listado_existencias_boletas.N_Doc ASC';
$arrBoletas = array();
$arrBoletas = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_boletas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBoletas');

/*****************************************/
//Boletas Empresas
$SIS_query = 'idExistencia, Descripcion, Valor';
$SIS_join  = '';
$SIS_where = 'idOcompra ='.$X_Puntero;
$SIS_order = 'idExistencia ASC';
$arrBoletasEmp = array();
$arrBoletasEmp = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_boletas_empresas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBoletasEmp');

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Print.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
$html = '
<style>
body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;}
table {border-collapse: collapse;border-spacing: 0;}
table > tbody > tr > td{border: 1px solid #bbb;padding-left:5px;padding-rigth:5px;}
tr.oddrow td{display: line;border-bottom: 1px solid #EEE;}
.tableline td, .tableline th{border-bottom: 1px solid #EEE;line-height: 1.42857143;}
table .title{background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-transform: uppercase; padding: 8px 0px;}
</style>

<div class="row">
	<div class="col-xs-12">
			
		
		<table style="margin: 1%; width: 98%;"   cellpadding="10" cellspacing="0">
			<tr>
				<td style="padding: 10px;" valign="top">

					<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
						<tr>
							<td width="33%">';
							if(isset($rowData['SistemaLogo'])&&$rowData['SistemaLogo']!=''){
								$html .= '<img src="upload/'.$rowData['SistemaLogo'].'" alt="" style="width:100%">';
							}else{
								$html .= '<img src="../LIB_assets/img/logo_empresa.jpg" alt="" style="width:100%">';
							}
							$html .= '
							</td>
							<td width="33%" style="text-align: center; background-color:#ccc;font-size: 22px;">
								Orden de Compra';

								//se verifica si la orden de comora esta rechazada
								if($rowData['idEstado']==3){
									$html .= '<br/>Rechazada';
								}
								
							$html .= '</td>
							<td width="33%">&nbsp;</td>
						</tr>
						<tr>
							<td>Fecha : '.Fecha_estandar($rowData['Creacion_fecha']).'</td>
							<td>&nbsp;</td>
							<td>Nº '.n_doc($_GET['view'], 5).'</td>
						</tr>
						<tr>
							<td colspan="3" class="title">Antecedentes Proveedor</td>
						</tr>
						<tr>
							<td colspan="3" style="padding: 10px;">
								<strong>Razón Social : </strong>'.$rowData['NombreProveedor'].'<br/>
								<strong>RUT : </strong>'.$rowData['RutProveedor'].'<br/>
								<strong>Dirección : </strong>'.$rowData['DireccionProveedor'].', '.$rowData['ComunaProveedor'].' - '.$rowData['CiudadProveedor'].'<br/>
								<strong>Email : </strong>'.$rowData['EmailProveedor'].'<br/>
								<strong>Teléfono : </strong>'.formatPhone($rowData['Fono1Proveedor']).' - '.formatPhone($rowData['Fono2Proveedor']).'<br/>
								<strong>Giro : </strong>'.$rowData['GiroProveedor'].'<br/>
								<strong>Contacto : </strong>'.$rowData['PersonaContactoProveedor'].'<br/>
								<strong>Forma de Pago : </strong>'.$rowData['FormaPagoProveedor'].'<br/>
								<strong>Despacho a : </strong> '.$rowData['SistemaOrigenDireccion'].', '.$rowData['SistemaOrigenComuna'].', '.$rowData['SistemaOrigenCiudad'].'<br/>
							</td>
						</tr>
					</table>
					<br/>
			 
					<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="6" class="title">Antecedentes producto/servicio</td>
						</tr>
						<tr>
							<td>Item</td>
							<td>Cantidad</td>
							<td>Unidad</td>
							<td>Descripcion</td>
							<td>Valor Unitario</td>
							<td>Subtotal</td>
						</tr>';

						$nn = 1;
						$total = 0;
						//Listado de productos solicitados
						foreach ($arrProductos as $prod) {
							$html .= '<tr>
									<td>'.$nn.'</td>
									<td>'.Cantidades_decimales_justos($prod['Cantidad']).'</td>
									<td>'.$prod['Unidad'].'</td>
									<td>'.$prod['Nombre'].'</td>
									<td align="right">'.Valores($prod['vUnitario'], 0).'</td>
									<td align="right">'.Valores($prod['vTotal'], 0).'</td>
								</tr>';
							$total = $total + $prod['vTotal'];
							$nn++;
						}
						//listado de insumos solicitados
						foreach ($arrInsumos as $prod) {
							$html .= '<tr>
									<td>'.$nn.'</td>
									<td>'.Cantidades_decimales_justos($prod['Cantidad']).'</td>
									<td>'.$prod['Unidad'].'</td>
									<td>'.$prod['Nombre'].'</td>
									<td align="right">'.Valores($prod['vUnitario'], 0).'</td>
									<td align="right">'.Valores($prod['vTotal'], 0).'</td>
								</tr>';
							$total = $total + $prod['vTotal'];
							$nn++;
						}
						//listado de arriendos solicitados
						foreach ($arrArriendos as $prod) {
							$html .= '<tr>
									<td>'.$nn.'</td>
									<td>'.Cantidades_decimales_justos($prod['Cantidad']).'</td>
									<td>'.$prod['Frecuencia'].'</td>
									<td>'.$prod['Nombre'].'</td>
									<td align="right">'.Valores($prod['vUnitario'], 0).'</td>
									<td align="right">'.Valores($prod['vTotal'], 0).'</td>
								</tr>';
							$total = $total + $prod['vTotal'];
							$nn++;
						}
						//listado de servicios solicitados
						foreach ($arrServicios as $prod) {
							$html .= '<tr>
									<td>'.$nn.'</td>
									<td>'.Cantidades_decimales_justos($prod['Cantidad']).'</td>
									<td>'.$prod['Frecuencia'].'</td>
									<td>'.$prod['Nombre'].'</td>
									<td align="right">'.Valores($prod['vUnitario'], 0).'</td>
									<td align="right">'.Valores($prod['vTotal'], 0).'</td>
								</tr>';
							$total = $total + $prod['vTotal'];
							$nn++;
						}
						//listado de otros solicitados
						foreach ($arrOtros as $prod) {
							$html .= '<tr>
									<td>'.$nn.'</td>
									<td>'.Cantidades_decimales_justos($prod['Cantidad']).'</td>
									<td>'.$prod['Frecuencia'].'</td>
									<td>'.$prod['Nombre'].'</td>
									<td align="right">'.Valores($prod['vUnitario'], 0).'</td>
									<td align="right">'.Valores($prod['vTotal'], 0).'</td>
								</tr>';
							$total = $total + $prod['vTotal'];
							$nn++;
						}
						//listado de boletas trabajadores
						$nbol = 0;
						foreach ($arrBoletas as $prod) {
							$html .= '<tr>
									<td>'.$nn.'</td>
									<td>'.$prod['TrabRut'].' - '.$prod['TrabNombre'].' '.$prod['TrabApellidoPat'].'</td>
									<td>'.$prod['Descripcion'].'</td>
									<td>Boleta N° '.$prod['N_Doc'].'</td>
									<td align="right">'.Valores($prod['Valor'], 0).'</td>
								</tr>';
							$total = $total + $prod['Valor'];
							$nn++;
							$nbol++;
						}
						//listado de boletas empresas
						$nbol = 0;
						foreach ($arrBoletasEmp as $prod) {
							$html .= '<tr>
									<td>'.$nn.'</td>
									<td colspan="3">'.$prod['Descripcion'].'</td>
									<td align="right">'.Valores($prod['Valor'], 0).'</td>
								</tr>';
							$total = $total + $prod['Valor'];
							$nn++;
							$nbol++;
						}
					$html .= '
						<tr>
							<td colspan="5" align="right"><strong>Subtotal  </strong></td>
							<td align="right">'.Valores($total, 0).'</td>
						</tr>';
					if($nbol==0){
						$html .= '
							<tr>
								<td colspan="5" align="right"><strong>IVA 19%  </strong></td>
								<td align="right">'.Valores(($total*19)/100, 0).'</td>
							</tr>';
						$html .= '
							<tr>
								<td colspan="5" align="right"><strong>Total  </strong></td>
								<td align="right">'.Valores($total+(($total*19)/100), 0).'</td>
							</tr>';
					}elseif($nbol!=0){
						$html .= '
							<tr>
								<td colspan="5" align="right"><strong>IVA 19%  </strong></td>
								<td align="right">'.Valores(($total*10)/100, 0).'</td>
							</tr>';
						$html .= '
							<tr>
								<td colspan="5" align="right"><strong>Total  </strong></td>
								<td align="right">'.Valores($total-(($total*10)/100), 0).'</td>
							</tr>';
					}
					
						
					$html .= '</table>

					<br/>
			  
					<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
						<tr>
							<td class="title">ANTECEDENTES FACTURACIÓN</td>
						</tr>
						<tr>
							<td style="padding: 10px;">
								<strong>Razón Social : </strong>'.$rowData['SistemaOrigen'].'<br/>
								<strong>Rut : </strong>'.$rowData['SistemaOrigenRut'].'<br/>
								<strong>Giro : </strong>'.$rowData['SistemaOrigenRubro'].'<br/>
								<strong>Dirección Comercial : </strong>'.$rowData['SistemaOrigenDireccion'].', '.$rowData['SistemaOrigenComuna'].', '.$rowData['SistemaOrigenCiudad'].'<br/>
								<strong>Teléfono : </strong>'.formatPhone($rowData['SistemaOrigenFono']).'<br/>
								<strong>E-mail : </strong>'.$rowData['SistemaOrigenEmail'].'<br/>
							</td>
						</tr>
					</table>

					<br/>
					<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
						<tr>
							<td class="title">OBSERVACIONES</td>
						</tr>
						<tr>
							<td style="padding: 10px;">'.$rowData['Observaciones'].'</td>
						</tr>
					</table>';

					$html .= '
					
					<br/>
					<table style="text-align: right; width: 100%; padding: 10px;"  cellspacing="0">
						<tr>
							<td style="padding: 10px;">
								Autorizado por '.$rowData['SistemaOrigen'].'<br/>
								Nombre: '.$rowData['NombreUsuario'].'<br/>
								<br/>
								<br/>
								<br/>
								Firma
								<br/>
							</td>
						</tr>
					</table>
			
			
				</td>
			</tr>
		</table>
		
		
			
	</div>
</div>';
	
echo $html;
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
