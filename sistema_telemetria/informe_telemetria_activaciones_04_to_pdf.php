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
//Se buscan la imagen i el tipo de PDF
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&$_GET['idSistema']!=0){
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema='.$_GET['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
//Se consultan datos
$arrGruposRev = array();
$arrGruposRev = db_select_array (false, 'idGrupo, Valor, idSupervisado', 'telemetria_listado_grupos_uso', '', 'idSupervisado=1', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposRev');

/*******************************************************/
//Se arma la query con los datos justos recibidos
//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
$arrNombres = array();
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision.SensoresRevision_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
}

//Se traen todos los datos de la maquina
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision`        ON telemetria_listado_sensores_revision.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['idTelemetria'];
$rowMaquina = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), $form_trabajo);

//Armo la consulta
$subquery = '';
for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
	//recorro los grupos de los sensores que estan siendo supervisados
	foreach ($arrGruposRev as $sen) {
		//verifico que esten activos
		if(isset($rowMaquina['SensoresActivo_'.$i])&&$rowMaquina['SensoresActivo_'.$i]==1){
			//Reviso si el sensor esta siendo supervisado
			if(isset($rowMaquina['SensoresRevision_'.$i])&&$rowMaquina['SensoresRevision_'.$i]==1){
				//verifico que pertenezca al grupo actual
				if($rowMaquina['SensoresRevisionGrupo_'.$i]==$sen['idGrupo']){
					//guardo el nombre
					$arrNombres[$i]['SensorNombre'] = $rowMaquina['SensoresNombre_'.$i];

					//verifico que el valor sea igual o superior al establecido
					if(isset($_GET['Amp'])&&$_GET['Amp']!=''&&$_GET['Amp']!=0){$valor_amp=$_GET['Amp'];}else{$valor_amp=$sen['Valor'];}
					//Consulto el nombre del sensor

					//Consulto el valor minimo
					$subquery .= ',(SELECT Sensor_'.$i.'
					FROM `telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema ASC
					LIMIT 1) AS ValorMinimo_'.$i.'';
					$subquery .= ',(SELECT HoraSistema
					FROM `telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema ASC
					LIMIT 1) AS HoraMinimo_'.$i.'';

					//Consulto el valor maximo
					$subquery .= ',(SELECT Sensor_'.$i.'
					FROM `telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema DESC
					LIMIT 1) AS ValorMaximo_'.$i.'';
					$subquery .= ',(SELECT HoraSistema
					FROM `telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema DESC
					LIMIT 1) AS HoraMaximo_'.$i.'';

				}
			}
		}
	}
}
/**********************************************************/
//Se traen todos los registros entre las fechas
$arrMediciones = array();
$arrMediciones = db_select_array (false, 'Fecha AS FechaConsultada'.$subquery, 'telemetria_listado_historial_activaciones', '', 'idTelemetria='.$_GET['idTelemetria'].' AND Fecha BETWEEN "'.$_GET['F_inicio'].'" AND "'.$_GET['F_termino'].'" GROUP BY Fecha',  'Fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
	tbody tr:nth-child(odd) {background-color: #dfdfdf;}
</style>';


$html .= '
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border: 1px solid black;background-color: #ffffff;">
	<thead>
		<tr>
			<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Fecha</th>';
			//Titulos de los sensores
			for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
				if(isset($arrNombres[$i]['SensorNombre'])&&$arrNombres[$i]['SensorNombre']!=''){
					$html .= '<th></th>';
				}
			}
		$html .= '</tr>
	</thead>
	<tbody>';
		foreach ($arrMediciones as $med) {
			//verifico si existen datos
			$exd = 0;
			for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
				if(isset($med['ValorMinimo_'.$i])){
					$exd++;
				}
			}
			if($exd>0){

				$html .='
					<tr>
						<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.fecha_estandar($med['FechaConsultada']).'</td>';
						for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
							if(isset($med['ValorMinimo_'.$i])){
								$html .='<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">';
									$html .='<strong>'.DeSanitizar($arrNombres[$i]['SensorNombre']).'</strong><br/>';
									$html .='Inicio: '.Cantidades_decimales_justos($med['ValorMinimo_'.$i]).' a las '.$med['HoraMinimo_'.$i].'<br/>';
									$html .='Termino: '.Cantidades_decimales_justos($med['ValorMaximo_'.$i]).' a las '.$med['HoraMaximo_'.$i].'<br/>';
								$html .='</td>';
							}
						}
				$html .='</tr>';
			}
		}
$html .='</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Amperaje del equipo '.DeSanitizar($rowMaquina['Nombre']);
$pdf_subtitulo  = '';
$pdf_file       = 'Informe Amperaje.pdf';
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
			if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&$_GET['idSistema']!=0){
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
