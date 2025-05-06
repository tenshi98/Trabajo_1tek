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
cotizacion_listado.Creacion_fecha,
cotizacion_listado.Observaciones,
cotizacion_listado.ValorNetoImp,
cotizacion_listado.Impuesto_01,
cotizacion_listado.Impuesto_02,
cotizacion_listado.Impuesto_03,
cotizacion_listado.Impuesto_04,
cotizacion_listado.Impuesto_05,
cotizacion_listado.Impuesto_06,
cotizacion_listado.Impuesto_07,
cotizacion_listado.Impuesto_08,
cotizacion_listado.Impuesto_09,
cotizacion_listado.Impuesto_10,
cotizacion_listado.ValorTotal,

usuarios_listado.Nombre AS NombreUsuario,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono1,
sistema_origen.Contacto_Fono2 AS SistemaOrigenFono2,
sistema_origen.Contacto_Web AS SistemaOrigenWeb,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,
sistema_origen.Config_imgLogo AS SistemaLogo,

clientes_listado.Nombre AS NombreCliente,
clientes_listado.email AS EmailCliente,
clientes_listado.Rut AS RutCliente,
clientciudad.Nombre AS CiudadCliente,
clientcomuna.Nombre AS ComunaCliente,
clientes_listado.Direccion AS DireccionCliente,
clientes_listado.Fono1 AS Fono1Cliente,
clientes_listado.Fono2 AS Fono2Cliente,
clientes_listado.Fax AS FaxCliente,
clientes_listado.PersonaContacto AS PersonaContactoCliente,
clientes_listado.Giro AS GiroCliente,

cotizacion_listado.idSistema';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario       = cotizacion_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema         = cotizacion_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad           = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna           = sistema_origen.idComuna
LEFT JOIN `clientes_listado`                        ON clientes_listado.idCliente       = cotizacion_listado.idCliente
LEFT JOIN `core_ubicacion_ciudad`    clientciudad   ON clientciudad.idCiudad            = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   clientcomuna   ON clientcomuna.idComuna            = clientes_listado.idComuna';
$SIS_where = 'cotizacion_listado.idCotizacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cotizacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se consulta
$SIS_query = '
insumos_listado.Nombre,
cotizacion_listado_existencias_insumos.Cantidad,
cotizacion_listado_existencias_insumos.vUnitario,
cotizacion_listado_existencias_insumos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`          ON insumos_listado.idProducto    = cotizacion_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`    ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'cotizacion_listado_existencias_insumos.idCotizacion ='.$X_Puntero;
$SIS_order = 'insumos_listado.Nombre';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

/*****************************************/
// Se consulta
$SIS_query = '
productos_listado.Nombre,
cotizacion_listado_existencias_productos.Cantidad,
cotizacion_listado_existencias_productos.vUnitario,
cotizacion_listado_existencias_productos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `productos_listado`      ON productos_listado.idProducto  = cotizacion_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml   = productos_listado.idUml';
$SIS_where = 'cotizacion_listado_existencias_productos.idCotizacion ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
// Se consulta
$SIS_query = '
equipos_arriendo_listado.Nombre,
cotizacion_listado_existencias_arriendos.Cantidad,
cotizacion_listado_existencias_arriendos.vUnitario,
cotizacion_listado_existencias_arriendos.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `equipos_arriendo_listado` ON equipos_arriendo_listado.idEquipo     = cotizacion_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_tiempo_frecuencia`   ON core_tiempo_frecuencia.idFrecuencia   = cotizacion_listado_existencias_arriendos.idFrecuencia';
$SIS_where = 'cotizacion_listado_existencias_arriendos.idCotizacion ='.$X_Puntero;
$SIS_order = 'equipos_arriendo_listado.Nombre ASC';
$arrArriendos = array();
$arrArriendos = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_arriendos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArriendos');

/*****************************************/
// Se consulta
$SIS_query = '
servicios_listado.Nombre,
cotizacion_listado_existencias_servicios.Cantidad,
cotizacion_listado_existencias_servicios.vUnitario,
cotizacion_listado_existencias_servicios.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `servicios_listado`       ON servicios_listado.idServicio          = cotizacion_listado_existencias_servicios.idServicio
LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia   = cotizacion_listado_existencias_servicios.idFrecuencia';
$SIS_where = 'cotizacion_listado_existencias_servicios.idCotizacion ='.$X_Puntero;
$SIS_order = 'servicios_listado.Nombre ASC';
$arrServicios = array();
$arrServicios = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrServicios');

/*****************************************/
// Se consulta
$SIS_query = 'Nombre,Porcentaje';
$SIS_join  = '';
$SIS_where = 'Porcentaje!=0';
$SIS_order = 'idImpuesto ASC';
$arrImpuestos = array();
$arrImpuestos = db_select_array (false, $SIS_query, 'sistema_impuestos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrImpuestos');

/*****************************************/
//Recorro y guard el nombre de los impuestos 
$nn = 0;
$impuestos = array();
foreach ($arrImpuestos as $impto) {
	$impuestos[$nn]['nimp'] = $impto['Nombre'].' ('.Cantidades_decimales_justos($impto['Porcentaje']).'%)';
	$nn++;
}

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
							<td width="50%">';
							if(isset($rowData['SistemaLogo'])&&$rowData['SistemaLogo']!=''){
								$html .= '<img src="upload/'.$rowData['SistemaLogo'].'" alt="" style="width:100%">';
							}else{
								$html .= '<img src="../LIB_assets/img/logo_empresa.jpg" alt="" style="width:100%">';
							}
							$html .= '
							</td>
							<td width="50%" style="text-align: left; font-size: 16px;">
								<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
								<strong>Rut : </strong>'.$rowData['SistemaOrigenRut'].'<br/>
								<strong>Teléfonos : </strong>'.formatPhone($rowData['SistemaOrigenFono1']).' - '.formatPhone($rowData['SistemaOrigenFono2']).'<br/>
								<strong>Dirección Comercial : </strong>'.$rowData['SistemaOrigenDireccion'].', '.$rowData['SistemaOrigenComuna'].', '.$rowData['SistemaOrigenCiudad'].'<br/>
								<strong>E-mail : </strong>'.$rowData['SistemaOrigenEmail'].'<br/>
								<strong>Web : </strong>'.$rowData['SistemaOrigenWeb'].'<br/>

							</td>
						</tr>

						<tr>
							<td></td>
							<td style="text-align: right;">Cotizacion Nº '.n_doc($_GET['view'], 5).'</td>
						</tr>
						<tr>
							<td>
								<strong>Fecha : </strong>'.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
								<strong>Empresa : </strong>'.$rowData['NombreCliente'].'<br/>
								<strong>Dirección : </strong>'.$rowData['DireccionCliente'].'<br/>
								<strong>Fono : </strong>'.formatPhone($rowData['Fono1Cliente']).' - '.formatPhone($rowData['Fono2Cliente']).'<br/>
								<strong>Giro : </strong>'.$rowData['GiroCliente'].'<br/>
								<strong>Solicita : </strong>'.$rowData['PersonaContactoCliente'].'<br/>
								
							
							</td>
							<td>
								<strong>Lugar : </strong>'.$rowData['SistemaOrigenComuna'].', '.$rowData['SistemaOrigenCiudad'].'<br/>
								<strong>RUT : </strong>'.$rowData['RutCliente'].'<br/>
								<strong>Ciudad/Comuna : </strong>'.$rowData['ComunaCliente'].'<br/>
								<strong>Región : </strong>'.$rowData['CiudadCliente'].'<br/>
								<strong>Email : </strong>'.$rowData['EmailCliente'].'<br/>
								<strong>Cargo : </strong><br/>
							</td>
						</tr>

						<tr>
							<td colspan="2" style="padding: 10px;">
								Estimado Señor: De acuerdo a lo solicitado,tengo el agrado de hacerle llegar la siguiente cotizacion de nuestros productos.
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
						//se completan las lineas
						for ($i = $nn; $i <= 18; $i++) {
							$html .= '
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>';
						}

					
					if(isset($rowData['ValorNetoImp'])&&$rowData['ValorNetoImp']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>Neto Imponible</strong></td>
							<td align="right">'.Valores($rowData['ValorNetoImp'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_01'])&&$rowData['Impuesto_01']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[0]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_01'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_02'])&&$rowData['Impuesto_02']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[1]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_02'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_03'])&&$rowData['Impuesto_03']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[2]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_03'], 0).'</td>
						</tr>';
					} 
					if(isset($rowData['Impuesto_04'])&&$rowData['Impuesto_04']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[3]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_04'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_05'])&&$rowData['Impuesto_05']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[4]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_05'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_06'])&&$rowData['Impuesto_06']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[5]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_06'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_07'])&&$rowData['Impuesto_07']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[6]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_07'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_08'])&&$rowData['Impuesto_08']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[7]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_08'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_09'])&&$rowData['Impuesto_09']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[8]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_09'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_10'])&&$rowData['Impuesto_10']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>'.$impuestos[9]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_10'], 0).'</td>
						</tr>';
					} 
					if(isset($rowData['ValorTotal'])&&$rowData['ValorTotal']!=0){
						$html .= '
						<tr>
							<td colspan="5" align="right"><strong>Total</strong></td>
							<td align="right">'.Valores($rowData['ValorTotal'], 0).'</td>
						</tr>';
					}
				
					$html .= '
			</table>

					<br/>
					<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
						<tr>
							<td class="title">Condiciones Comerciales</td>
						</tr>
						<tr>
							<td style="padding: 10px;">'.$rowData['Observaciones'].'</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>

	</div>
</div>	
';
echo $html;

/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
