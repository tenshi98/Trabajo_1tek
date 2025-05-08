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
require_once 'core/Load.Utils.PDF.php';
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
//Se buscan la imagen i el tipo de PDF
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
	//Consulta
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema ='.simpleDecode($_GET['idSistema'], fecha_actual()), $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
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

/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
	body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;}
	table {border-collapse: collapse;border-spacing: 0;}
	tr.oddrow td{display: line;border-bottom: 1px solid #EEE;}
	.tableline td, .tableline th{border-bottom: 1px solid #EEE;line-height: 1.42857143;}
</style>';

$html .= '
<table style="border: 1px solid #f4f4f4;margin: 1%; width: 98%;"   cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="2" rowspan="1" style="vertical-align: top;">'.$rowData['BoletaTipo'].'</td>
							<td style="vertical-align: top;">Boleta N°: '.n_doc($rowData['N_Doc'], 8).'</td>
						</tr>
						<tr>';

							//se verifica el tipo de movimiento
							switch ($rowData['idTipo']) {
								//Boleta Trabajadores
								case 1:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Emisor<br/>
											<strong>'.$rowData['Trab_Nombre'].' '.$rowData['Trab_ApellidoPat'].' '.$rowData['Trab_ApellidoMat'].'</strong><br/>
											Rut: '.$rowData['Trab_Rut'].'<br/>
											Fono: '.formatPhone($rowData['Trab_Fono']).'<br/>
											Cargo: '.$rowData['Trab_Cargo'].'<br/>
											Tipo Cargo: '.$rowData['Trab_Tipo'].'<br/>
											Centro de Costo: '.$rowData['CentroCosto'].'
									</td>

									<td style="vertical-align: top;width:33%;">
										Receptor<br/>
											<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
											'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
											'.$rowData['SistemaOrigenDireccion'].'<br/>
											Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
											Rut: '.$rowData['SistemaOrigenRut'].'<br/>
											Email: '.$rowData['SistemaOrigenEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
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
										$html .= '</td>';
									break;
								//Boleta Clientes
								case 2:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Emisor<br/>
											<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
											'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
											'.$rowData['SistemaOrigenDireccion'].'<br/>
											Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
											Rut: '.$rowData['SistemaOrigenRut'].'<br/>
											Email: '.$rowData['SistemaOrigenEmail'].'
									</td>

									<td style="vertical-align: top;width:33%;">
										Receptor<br/>
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
									</td>

									<td style="vertical-align: top;width:33%;">
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
									</td>';
									break;
								//Boleta Empresas
								case 3:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Emisor<br/>
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
									</td>

									<td style="vertical-align: top;width:33%;">
										Receptor<br/>
											<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
											'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
											'.$rowData['SistemaOrigenDireccion'].'<br/>
											Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
											Rut: '.$rowData['SistemaOrigenRut'].'<br/>
											Email: '.$rowData['SistemaOrigenEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
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
										$html .= '</td>';

									break;
								//Boleta Clientes
							}
						$html .= '</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:88%;"><strong>Detalle</strong></th>
							<th style="vertical-align: top; width:12%;"><strong>Valor Total</strong></th>
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
					if(isset($rowData['ValorNeto'])&&$rowData['ValorNeto']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right"><strong>Total Honorarios</strong></td>
							<td align="right">'.Valores($rowData['ValorNeto'], 0).'</td>
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
				$html .= '
					</tbody>
				</table>

				<br/>
				<br/>

				<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
					<tbody><tr><td style="vertical-align: top;">Observaciones:</td></tr></tbody>
				</table>
				<table style="text-align: left; width: 100%;margin-top:20px;" cellpadding="5" cellspacing="0">
					<tbody>
						<tr>
							<td style="vertical-align: top;text-align: left;background-color: #f9f9f9;border: 1px solid #EEE;">'.$rowData['Observaciones'].'</td>
						</tr>
					</tbody>
				</table>';

			$html .= '</td>
		</tr>
	</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = $rowData['TipoDoc'];
$pdf_subtitulo  = '';
$pdf_file       = $rowData['TipoDoc'].'.pdf';
$OpcDom         = "'A4', 'landscape'";
$OpcTcpOrt      = "P";  //P->PORTRAIT - L->LANDSCAPE
$OpcTcpPg       = "A4"; //Tipo de Hoja
/********************************************************************************/
//Se verifica que este configurado el motor de pdf
if(isset($rowEmpresa['idOpcionesGen_5'])&&$rowEmpresa['idOpcionesGen_5']!=0){
	switch ($rowEmpresa['idOpcionesGen_5']) {
		/************************************************************************/
		//TCPDF
		case 1:

			require_once('../LIBS_php/tcpdf/tcpdf.php');

			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Victor Reyes');
			$pdf->SetTitle('');
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
				if(isset($rowEmpresa['Config_imgLogo'])&&$rowEmpresa['Config_imgLogo']!=''){
					$logo = '../../../../'.DB_SITE_MAIN_PATH.'/upload/'.$rowEmpresa['Config_imgLogo'];
				}else{
					$logo = '../../../../Legacy/1tek_public/img/logo_empresa.jpg';
				}
			}else{
				$logo = '../../../../Legacy/1tek_public/img/logo_empresa.jpg';
			}
			$pdf->SetHeaderData($logo, 40, $pdf_titulo, $pdf_subtitulo);

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')){
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			//Se crea el archivo
			$pdf->SetFont('helvetica', '', 10);
			$pdf->AddPage($OpcTcpOrt, $OpcTcpPg);
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->lastPage();
			$pdf->Output(DeSanitizar($pdf_file), 'I');

			break;
		/************************************************************************/
		//DomPDF (Solo compatible con PHP 5.x)
		case 2:
			require_once '../LIBS_php/dompdf/autoload.inc.php';
			// reference the Dompdf namespace
			//use Dompdf\Dompdf;
			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->setPaper($OpcDom);
			$dompdf->render();
			$dompdf->stream(DeSanitizar($pdf_file));
			break;

	}
}

?>
