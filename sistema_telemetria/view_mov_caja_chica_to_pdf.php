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
caja_chica_facturacion.idTipo,
caja_chica_listado.Nombre AS CajaNombre,
core_sistemas.Nombre AS CajaSistema,
usuarios_listado.Nombre AS Usuario,
caja_chica_facturacion_tipo.Nombre AS CajaTipo,
core_estado_caja.Nombre AS CajaEstado,
caja_chica_facturacion.fecha_auto,
caja_chica_facturacion.Creacion_fecha,
caja_chica_facturacion.Observaciones,
caja_chica_facturacion.Valor,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Cargo AS TrabajadorCargo,
trabajadores_listado.Fono AS TrabajadorFono,
trabajadores_listado.Rut AS TrabajadorRut,
caja_chica_facturacion.idFacturacionRelacionada,
trab_rel.Nombre AS TrabRelNombre,
trab_rel.ApellidoPat AS TrabRelApellidoPat,
trab_rel.ApellidoMat AS TrabRelApellidoMat,
trab_rel.Cargo AS TrabRelCargo,
trab_rel.Fono AS TrabRelFono,
trab_rel.Rut AS TrabRelRut,
fact_rel.Valor AS RelValor';
$SIS_join  = '
LEFT JOIN `caja_chica_listado`                  ON caja_chica_listado.idCajaChica       = caja_chica_facturacion.idCajaChica
LEFT JOIN `core_sistemas`                       ON core_sistemas.idSistema              = caja_chica_facturacion.idSistema
LEFT JOIN `usuarios_listado`                    ON usuarios_listado.idUsuario           = caja_chica_facturacion.idUsuario
LEFT JOIN `caja_chica_facturacion_tipo`         ON caja_chica_facturacion_tipo.idTipo   = caja_chica_facturacion.idTipo
LEFT JOIN `core_estado_caja`                    ON core_estado_caja.idEstado            = caja_chica_facturacion.idEstado
LEFT JOIN `trabajadores_listado`                ON trabajadores_listado.idTrabajador    = caja_chica_facturacion.idTrabajador
LEFT JOIN `caja_chica_facturacion`   fact_rel   ON fact_rel.idFacturacion               = caja_chica_facturacion.idFacturacionRelacionada
LEFT JOIN `trabajadores_listado`     trab_rel   ON trab_rel.idTrabajador                = fact_rel.idTrabajador';
$SIS_where = 'caja_chica_facturacion.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'caja_chica_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***********************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
sistema_documentos_pago.Nombre,
caja_chica_facturacion_existencias.N_Doc,
caja_chica_facturacion_existencias.Valor';
$SIS_join  = 'LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago = caja_chica_facturacion_existencias.idDocPago';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'sistema_documentos_pago.Nombre ASC';
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, $SIS_query, 'caja_chica_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDocumentos');

/***********************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = 'Item, Valor';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Item ASC';
$arrRendiciones = array();
$arrRendiciones = db_select_array (false, $SIS_query, 'caja_chica_facturacion_rendiciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRendiciones');
 
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
							<td colspan="2" rowspan="1" style="vertical-align: top;">'.$rowData['CajaTipo'].'</td>
							<td style="vertical-align: top;">Numero Documento: '.n_doc($_GET['view'], 8).'</td>
						</tr>
						<tr>';

							//se verifica el tipo de movimiento
							switch ($rowData['idTipo']) {
								//Ingreso
								case 1:
									$html .= '
									<td style="vertical-align: top; width:50%;">
										Datos del Movimiento
										<strong>'.$rowData['CajaNombre'].'</strong><br/>
										Sistema: '.$rowData['CajaSistema'].'<br/>
										Usuario: '.$rowData['Usuario'].'<br/>
										Estado: '.$rowData['CajaEstado'].'<br/>
										Fecha Real: '.Fecha_estandar($rowData['fecha_auto']).'<br/>
										Fecha Ingresada: '.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
									</td>

									<td style="vertical-align: top;width:50%;">
									</td>';

									break;
								//Egreso
								case 2:
									$html .= '
									<td style="vertical-align: top; width:50%;">
										Datos del Movimiento
										<strong>'.$rowData['CajaNombre'].'</strong><br/>
										Sistema: '.$rowData['CajaSistema'].'<br/>
										Usuario: '.$rowData['Usuario'].'<br/>
										Estado: '.$rowData['CajaEstado'].'<br/>
										Fecha Real: '.Fecha_estandar($rowData['fecha_auto']).'<br/>
										Fecha Ingresada: '.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
									</td>

									<td style="vertical-align: top;width:50%;">
										Trabajador
										<strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat'].'</strong><br/>
										Rut: '.$rowData['TrabajadorRut'].'<br/>
										Cargo: '.$rowData['TrabajadorCargo'].'<br/>
										Fono: '.formatPhone($rowData['TrabajadorFono']).'<br/>
									</td>';
									break;
								//Rendicion
								case 3:
									break;

							}
						$html .= '</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:78%;"><strong>Detalle</strong></th>
							<th style="vertical-align: top; width:11%;"><strong>Valor Ingreso</strong></th>
							<th style="vertical-align: top; width:11%;"><strong>Valor Egreso</strong></th>
						</tr>
					</thead>
					<tbody>';
					//si existen productos
					if ($arrRendiciones!=false && !empty($arrRendiciones) && $arrRendiciones!='') {
						$html .= '<tr style="background-color: #f9f9f9;"><td colspan="3"><strong>Rendiciones</strong></td></tr>';
						foreach ($arrRendiciones as $prod) {
							$html .= '<tr>
								<td style="vertical-align: top;"><strong>'.$prod['Item'].'</td>';
								if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){
									$html .= '<td align="right" style="vertical-align: top;">'.Valores($prod['Valor'], 0).'</td>';
									$html .= '<td align="right" style="vertical-align: top;"></td>';
								}else{
									$html .= '<td align="right" style="vertical-align: top;"></td>';
									$html .= '<td align="right" style="vertical-align: top;">'.Valores($prod['Valor'], 0).'</td>';
								}
							$html .= '</tr>';
						}
					}

					//si existen productos
					if ($arrDocumentos!=false && !empty($arrDocumentos) && $arrDocumentos!='') {
						$html .= '<tr style="background-color: #f9f9f9;"><td colspan="3"><strong>Montos</strong></td></tr>';
						foreach ($arrDocumentos as $prod) {
							$html .= '<tr>
								<td style="vertical-align: top;"><strong>';
									$html .= $prod['Nombre'];
									if(isset($prod['N_Doc'])&&$prod['N_Doc']!=''){
										$html .= ' N°'.$prod['N_Doc'];
									}
								$html .= '</td>';
								if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){
									$html .= '<td align="right" style="vertical-align: top;">'.Valores($prod['Valor'], 0).'</td>';
									$html .= '<td align="right" style="vertical-align: top;"></td>';
								}else{
									$html .= '<td align="right" style="vertical-align: top;"></td>';
									$html .= '<td align="right" style="vertical-align: top;">'.Valores($prod['Valor'], 0).'</td>';
								}
							$html .= '</tr>';
						}
					}

					if(isset($rowData['Valor'])&&$rowData['Valor']!=0){
						$html .= '
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right"><strong>Total</strong></td>';
							if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){
								$html .= '<td align="right" style="vertical-align: top;">'.Valores($rowData['Valor'], 0).'</td>';
								$html .= '<td align="right" style="vertical-align: top;"></td>';
							}else{
								$html .= '<td align="right" style="vertical-align: top;"></td>';
								$html .= '<td align="right" style="vertical-align: top;">'.Valores($rowData['Valor'], 0).'</td>';
							}
						$html .= '</tr>';
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

				if($rowData['idTipo']==2){
					$html .= '
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>

					<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="vertical-align: top;text-align:center;">Firma Transportista</td>
								<td style="vertical-align: top;text-align:center;">Firma Receptor</td>
							</tr>
						</tbody>
					</table>';
				}
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
					$logo = '../../../../Legacy/gestion_modular/img/logo_empresa.jpg';
				}
			}else{
				$logo = '../../../../Legacy/gestion_modular/img/logo_empresa.jpg';
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
