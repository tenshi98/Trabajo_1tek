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
core_sistemas.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
core_sistemas.Direccion AS SistemaOrigenDireccion,
core_sistemas.Contacto_Fono1 AS SistemaOrigenFono,
core_sistemas.email_principal AS SistemaOrigenEmail,
core_sistemas.Rut AS SistemaOrigenRut,
core_sistemas.Contacto_Nombre AS SistemaContacto,
usuarios_listado.Nombre AS NombreEncargado,
telemetria_historial_mantencion.Fecha,
telemetria_historial_mantencion.h_Inicio,
telemetria_historial_mantencion.h_Termino,
telemetria_historial_mantencion.Duracion,
telemetria_historial_mantencion.Resumen,
telemetria_historial_mantencion.Resolucion,
telemetria_historial_mantencion.idOpciones_1,
telemetria_historial_mantencion.idOpciones_2,
telemetria_historial_mantencion.idOpciones_3,
telemetria_historial_mantencion.Recepcion_Nombre,
telemetria_historial_mantencion.Recepcion_Rut,
telemetria_historial_mantencion.Recepcion_Email,
telemetria_historial_mantencion.Path_Firma,
core_telemetria_servicio_tecnico.Nombre AS Servicio';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                   = telemetria_historial_mantencion.idUsuario
LEFT JOIN `core_telemetria_servicio_tecnico`        ON core_telemetria_servicio_tecnico.idServicio  = telemetria_historial_mantencion.idServicio
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                      = telemetria_historial_mantencion.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                       = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                       = core_sistemas.idComuna';
$SIS_where = 'telemetria_historial_mantencion.idMantencion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'telemetria_historial_mantencion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************/
$arrOpciones = array();
$arrOpciones = db_select_array (false, 'idOpciones, Nombre', 'core_telemetria_servicio_tecnico_opciones', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOpciones');

/**********************************/
$arrOpcionesDisplay = array();
foreach ($arrOpciones as $mant) {
	$arrOpcionesDisplay[$mant['idOpciones']]['Nombre'] = $mant['Nombre'];
}

/*************************************************************************/
//Se buscan todos los archivos relacionados
$SIS_query = '
telemetria_listado.Identificador AS Identificador,
telemetria_listado.Nombre AS Equipo';
$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_historial_mantencion_equipos.idTelemetria';
$SIS_where = 'telemetria_historial_mantencion_equipos.idMantencion ='.$X_Puntero;
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrEquipos = array();
$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_historial_mantencion_equipos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

/*************************************************************************/
//Se buscan todos los archivos relacionados
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idMantencion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'telemetria_historial_mantencion_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

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
				<table style="text-align: left; width: 100%;border: 1px solid #f4f4f4;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="4" rowspan="1" style="text-align: center;background-color:#DDD;padding:5px;"><br/><strong>Empresa Visitada.</strong></td>
						</tr>

						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Nombre</td>
							<td style="vertical-align: top; width:80%;" colspan="3">'.$rowData['SistemaOrigen'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Ubicación</td>
							<td style="vertical-align: top; width:80%;" colspan="3">'.$rowData['SistemaOrigenDireccion'].', '.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Fono Fijo</td>
							<td style="vertical-align: top; width:30%;">'.formatPhone($rowData['SistemaOrigenFono']).'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Rut</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['SistemaOrigenRut'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Email</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['SistemaOrigenEmail'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Persona contacto</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['SistemaContacto'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Aprobador Nombre</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['Recepcion_Nombre'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Aprobador Rut</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['Recepcion_Rut'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Aprobador Email</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['Recepcion_Email'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;"></td>
							<td style="vertical-align: top; width:30%;"></td>
						</tr>
					</tbody>
				</table>

				<table style="text-align: left; width: 100%;border: 1px solid #f4f4f4;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="4" rowspan="1" style="text-align: center;background-color:#DDD;padding:5px;"><br/><strong>Tecnico a Cargo</strong></td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Nombre</td>
							<td style="vertical-align: top; width:80%;" colspan="3">'.$rowData['NombreEncargado'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Fecha</td>
							<td style="vertical-align: top; width:30%;">'.Fecha_estandar($rowData['Fecha']).'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Hora Inicio</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['h_Inicio'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Hora Termino</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['h_Termino'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Duracion</td>
							<td style="vertical-align: top; width:30%;">'.$rowData['Duracion'].'</td>
						</tr>
					</tbody>
				</table>

				<table style="text-align: left; width: 100%;border: 1px solid #f4f4f4;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="2" rowspan="1" style="text-align: center;background-color:#DDD;padding:5px;"><br/><strong>Trabajo</strong></td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Servicio</td>
							<td style="vertical-align: top; width:80%;">'.$rowData['Servicio'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Opciones</td>
							<td style="vertical-align: top; width:80%;">';
								$ntot = 0;
								if(isset($rowData['idOpciones_1'])&&$rowData['idOpciones_1']==2){if($ntot!=0){$html .= ' - '.$arrOpcionesDisplay[1]['Nombre'];$ntot++;}else{$html .= $arrOpcionesDisplay[1]['Nombre'];$ntot++;}}
								if(isset($rowData['idOpciones_2'])&&$rowData['idOpciones_2']==2){if($ntot!=0){$html .= ' - '.$arrOpcionesDisplay[2]['Nombre'];$ntot++;}else{$html .= $arrOpcionesDisplay[2]['Nombre'];$ntot++;}}
								if(isset($rowData['idOpciones_3'])&&$rowData['idOpciones_3']==2){if($ntot!=0){$html .= ' - '.$arrOpcionesDisplay[3]['Nombre'];$ntot++;}else{$html .= $arrOpcionesDisplay[3]['Nombre'];$ntot++;}}
								$html .= '
							</td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>
				<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
					<tbody><tr><td style="vertical-align: top;">Equipos:</td></tr></tbody>
				</table>
				<table style="text-align: left; width: 100%;margin-top:20px;" cellpadding="5" cellspacing="0">
					<tbody>
						<tr>
							<td style="vertical-align: top;text-align: left;background-color: #f9f9f9;border: 1px solid #EEE;">';
							foreach ($arrEquipos as $archivos) {
								$html .= $archivos['Identificador'].' - '.$archivos['Equipo'].'<br/>';
							}
							$html .= '
							</td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>
				<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
					<tbody><tr><td style="vertical-align: top;">Diagnostico tecnico y acciones realizadas:</td></tr></tbody>
				</table>
				<table style="text-align: left; width: 100%;margin-top:20px;" cellpadding="5" cellspacing="0">
					<tbody>
						<tr>
							<td style="vertical-align: top;text-align: left;background-color: #f9f9f9;border: 1px solid #EEE;">'.$rowData['Resumen'].'</td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>
				<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
					<tbody><tr><td style="vertical-align: top;">Resumen de Visita:</td></tr></tbody>
				</table>
				<table style="text-align: left; width: 100%;margin-top:20px;" cellpadding="5" cellspacing="0">
					<tbody>
						<tr>
							<td style="vertical-align: top;text-align: left;background-color: #f9f9f9;border: 1px solid #EEE;">'.$rowData['Resolucion'].'</td>
						</tr>
					</tbody>
				</table>
				<br/>
				<br/>
				<table style="text-align: left; width: 100%; margin-top:20px;" cellpadding="0" cellspacing="0">
					<tbody>

						<tr style="background-color: #f1f1f1;">
							<td colspan="8">Archivos Adjuntos</td>
						</tr>
						<tr>';
						$xn_col = 1;
						foreach ($arrArchivos as $arch) {
							$html .= '<td style="vertical-align: top; width:20%;"><img src="upload/'.$arch['Nombre'].'"></td>';
							$xn_col++;
							if($xn_col>5){
								$html .= '</tr><tr>';
								$xn_col=1;
							}
						}

						$html .= '</tr>';

					$html .= '
					</tbody>
				</table>';

				$html .= '
					<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="vertical-align: top;text-align:center;width:50%;">';
								if(isset($rowData['Path_Firma'])&&$rowData['Path_Firma']!=''){
									$html .= '<img style="" alt="Imagen Referencia" src="upload/'.$rowData['Path_Firma'].'">';
								}
								$html .= '
								</td>
								<td style="vertical-align: top;text-align:center;width:50%;">

								</td>
							</tr>
							<tr>
								<td style="vertical-align: top;text-align:center;">Firma Aprobador</td>
								<td style="vertical-align: top;text-align:center;">Firma Trabajador</td>
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
$pdf_titulo     = 'Visita Tecnica N° '.n_doc($X_Puntero, 7).'.';
$pdf_subtitulo  = 'Mantencion '.$rowData['Servicio'];
$pdf_file       = 'Mantencion N° '.n_doc($X_Puntero, 7).'.pdf';
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


