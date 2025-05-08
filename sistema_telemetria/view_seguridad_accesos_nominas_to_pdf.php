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
seguridad_accesos_nominas.FechaProgramada,
seguridad_accesos_nominas.HoraInicioProgramada,
seguridad_accesos_nominas.HoraTerminoProgramada,
core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,
seguridad_accesos_nominas.PersonaReunion,
core_estado_caja.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `usuarios_listado`            ON usuarios_listado.idUsuario            = seguridad_accesos_nominas.idUsuario
LEFT JOIN `core_sistemas`               ON core_sistemas.idSistema               = seguridad_accesos_nominas.idSistema
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = seguridad_accesos_nominas.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = seguridad_accesos_nominas.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = seguridad_accesos_nominas.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = seguridad_accesos_nominas.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = seguridad_accesos_nominas.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = seguridad_accesos_nominas.idUbicacion_lvl_5
LEFT JOIN `core_estado_caja`            ON core_estado_caja.idEstado             = seguridad_accesos_nominas.idEstado';
$SIS_where = 'seguridad_accesos_nominas.idAcceso ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'seguridad_accesos_nominas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
seguridad_accesos_nominas_listado.Fecha,
seguridad_accesos_nominas_listado.HoraEntrada,
seguridad_accesos_nominas_listado.HoraSalida,
seguridad_accesos_nominas_listado.Nombre,
seguridad_accesos_nominas_listado.Rut,
seguridad_accesos_nominas_listado.NDocCedula,
core_estado_nomina_asistencia.Nombre AS Estado';
$SIS_join  = 'LEFT JOIN `core_estado_nomina_asistencia` ON core_estado_nomina_asistencia.idEstado = seguridad_accesos_nominas_listado.idEstado';
$SIS_where = 'seguridad_accesos_nominas_listado.idAcceso ='.$X_Puntero;
$SIS_order = 'seguridad_accesos_nominas_listado.Fecha ASC';
$arrPersonas = array();
$arrPersonas = db_select_array (false, $SIS_query, 'seguridad_accesos_nominas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPersonas');

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
							<td colspan="2" rowspan="1" style="vertical-align: top;">Nomina de Control de Accesos</td>
							<td style="vertical-align: top;">Nomina N°: '.n_doc($_GET['view'], 8).'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:50%;">
								Datos Básicos<br/>
								<strong>Usuario:</strong> '.$rowData['Usuario'].'<br/>
								<strong>Sistema:</strong> '.$rowData['Sistema'].'<br/>
								<strong>Ubicación:</strong> ';
								$html .= $rowData['Ubicacion'];
								if(isset($rowData['UbicacionLVL_1'])&&$rowData['UbicacionLVL_1']!=''){$html .= ' - '.$rowData['UbicacionLVL_1'];}
								if(isset($rowData['UbicacionLVL_2'])&&$rowData['UbicacionLVL_2']!=''){$html .= ' - '.$rowData['UbicacionLVL_2'];}
								if(isset($rowData['UbicacionLVL_3'])&&$rowData['UbicacionLVL_3']!=''){$html .= ' - '.$rowData['UbicacionLVL_3'];}
								if(isset($rowData['UbicacionLVL_4'])&&$rowData['UbicacionLVL_4']!=''){$html .= ' - '.$rowData['UbicacionLVL_4'];}
								if(isset($rowData['UbicacionLVL_5'])&&$rowData['UbicacionLVL_5']!=''){$html .= ' - '.$rowData['UbicacionLVL_5'];}
								$html .= '<br/>
								<strong>Persona Reunion:</strong> '.$rowData['PersonaReunion'].'<br/>
								<strong>Estado:</strong> '.$rowData['Estado'].'<br/>
							</td>

							<td style="vertical-align: top;width:50%;">
								Programacion<br/>
								<strong>Fecha:</strong> '.Fecha_estandar($rowData['FechaProgramada']).'<br/>
								<strong>Hora Inicio:</strong> '.$rowData['HoraInicioProgramada'].'<br/>
								<strong>Hora Termino:</strong> '.$rowData['HoraTerminoProgramada'].'<br/>
							</td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:100%;" colspan="6"><strong>Detalle</strong></th>
						</tr>
					</thead>
					<tbody>';

					//si existen guias
					if ($arrPersonas!=false && !empty($arrPersonas) && $arrPersonas!='') {
						foreach ($arrPersonas as $otro) {
							$html .= '<tr>
								<td style="vertical-align: top;">'.$otro['Nombre'].'</td>
								<td style="vertical-align: top;">'.$otro['Rut'].'</td>
								<td style="vertical-align: top;">'.$otro['NDocCedula'].'</td>
								<td style="vertical-align: top;">'.Fecha_estandar($otro['Fecha']).'</td>
								<td style="vertical-align: top;">'.$otro['HoraEntrada'].' - '.$otro['HoraSalida'].'</td>
								<td style="vertical-align: top;">'.$otro['Estado'].'</td>
							</tr>';
						}
					}
				$html .= '
					</tbody>
				</table>

				<br/>
				<br/>
				';

			$html .= '</td>
		</tr>
	</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Nomina N '.n_doc($X_Puntero, 8);
$pdf_subtitulo  = '';
$pdf_file       = 'Nomina N '.n_doc($X_Puntero, 8).'.pdf';
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
