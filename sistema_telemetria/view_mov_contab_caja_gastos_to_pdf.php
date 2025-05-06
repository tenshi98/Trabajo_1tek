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
core_sistemas.Nombre AS CajaSistema,
usuarios_listado.Nombre AS Usuario,
contab_caja_gastos.fecha_auto,
contab_caja_gastos.Creacion_fecha,
contab_caja_gastos.Observaciones,
contab_caja_gastos.Valor,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Cargo AS TrabajadorCargo,
trabajadores_listado.Fono AS TrabajadorFono,
trabajadores_listado.Rut AS TrabajadorRut';
$SIS_join  = '
LEFT JOIN `core_sistemas`         ON core_sistemas.idSistema              = contab_caja_gastos.idSistema
LEFT JOIN `usuarios_listado`      ON usuarios_listado.idUsuario           = contab_caja_gastos.idUsuario
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador    = contab_caja_gastos.idTrabajador';
$SIS_where = 'contab_caja_gastos.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'contab_caja_gastos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
sistema_documentos_pago.Nombre,
contab_caja_gastos_existencias.Descripcion,
contab_caja_gastos_existencias.N_Doc,
contab_caja_gastos_existencias.Valor,
contab_caja_gastos_existencias.CentroCosto';
$SIS_join  = 'LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago = contab_caja_gastos_existencias.idDocPago';
$SIS_where = 'contab_caja_gastos_existencias.idFacturacion ='.$X_Puntero;
$SIS_order = 'sistema_documentos_pago.Nombre ASC';
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, $SIS_query, 'contab_caja_gastos_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDocumentos');

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
							<td colspan="2" rowspan="1" style="vertical-align: top;">Rendiciones</td>
							<td style="vertical-align: top;"></td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:50%;">
								Datos basicos
								<strong>Trabajador: </strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat'].'<br/>
								<strong>Rut: </strong>'.$rowData['TrabajadorRut'].'<br/>
								<strong>Cargo: </strong>'.$rowData['TrabajadorCargo'].'<br/>
								<strong>Fono: </strong>'.formatPhone($rowData['TrabajadorFono']).'<br/>
							</td>
							<td style="vertical-align: top;width:50%;">
								Detalle
								<strong>Fecha Creacion: </strong>'.fecha_estandar($rowData['Creacion_fecha']).'<br/>
								<strong>Fecha Ingreso: </strong>'.fecha_estandar($rowData['fecha_auto']).'<br/>
								<strong>Usuario: </strong>'.$rowData['Usuario'].'<br/>
								<strong>Sistema: </strong>'.$rowData['CajaSistema'].'<br/>
							</td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th colspan="4" style="vertical-align: top; width:100%;"><strong>Detalle</strong></th>
						</tr>
					</thead>
					<tbody>';
					//si existen productos
					if ($arrDocumentos!=false && !empty($arrDocumentos) && $arrDocumentos!='') {
						foreach ($arrDocumentos as $prod) {
							$html .= '<tr>';
								$html .= '<td style="vertical-align: top;">'.$prod['Descripcion'].'</td>';
								$html .= '
								<td style="vertical-align: top;">';
									$html .= $prod['Nombre'];
									if(isset($prod['N_Doc'])&&$prod['N_Doc']!=''){
										$html .= ' N°'.$prod['N_Doc'];
									}
								$html .= '</td>';
								$html .= '<td style="vertical-align: top;">'.$prod['CentroCosto'].'</td>';
								$html .= '<td align="right" style="vertical-align: top;">'.Valores($prod['Valor'], 0).'</td>';
							$html .= '</tr>';
						}
					}

					if(isset($rowData['Valor'])&&$rowData['Valor']!=0){
						$html .= '
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right" colspan="3"><strong>Total</strong></td>
							<td align="right" style="vertical-align: top;">'.Valores($rowData['Valor'], 0).'</td>
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
$pdf_titulo     = 'Rendiciones N°'.N_doc($X_Puntero, 5);
$pdf_subtitulo  = '';
$pdf_file       = 'Rendiciones N°'.N_doc($X_Puntero, 5).'.pdf';
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
