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
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = '';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .= "(TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .= "(FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	//desde y hasta activo
	if(isset($_GET['desde'], $_GET['hasta'])&&$_GET['desde']!=''&&$_GET['hasta']!=''){
		$subquery = "
		MIN(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0),0)) AS MedMin,
		MAX(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0),0)) AS MedMax,
		AVG(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0),0)) AS MedProm,
		STDDEV(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0),0)) AS MedDesStan,
		";
	//solo desde
	}elseif(isset($_GET['desde'])&&$_GET['desde']!=''&&(!isset($_GET['hasta']) OR $_GET['hasta']=='')){
		$subquery = "
		MIN(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedMin,
		MAX(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedMax,
		AVG(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedProm,
		STDDEV(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].">=".$_GET['desde'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedDesStan,
		";
	//solo hasta
	}elseif(isset($_GET['hasta'])&&$_GET['hasta']!=''&&(!isset($_GET['desde']) OR $_GET['desde']=='')){
		$subquery = "
		MIN(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedMin,
		MAX(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedMax,
		AVG(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedProm,
		STDDEV(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<=".$_GET['hasta'].",IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0),0)) AS MedDesStan,
		";
	//ninguno
	}else{
		$subquery = "
		MIN(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0)) AS MedMin,
		MAX(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0)) AS MedMax,
		AVG(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0)) AS MedProm,
		STDDEV(NULLIF(IF(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn']."<99900,backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".Sensor_".$_GET['sensorn'].",0),0)) AS MedDesStan,
		";
	}

	//se traen lo datos del equipo
	$SIS_query = '
	telemetria_listado_sensores_nombre.SensoresNombre_'.$_GET['sensorn'].' AS SensorNombre,
	backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema,
	'.$subquery.'
	telemetria_listado_unidad_medida.Nombre AS Unimed';
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria  = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_unidad_medida`    ON telemetria_listado_unidad_medida.idUniMed        = telemetria_listado_sensores_unimed.SensoresUniMed_'.$_GET['sensorn'];
	$SIS_where .= ' GROUP BY backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema';
	$SIS_order  = 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

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
				//Si se ven detalles
				if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
					$html .= '
					<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Promedio</th>
					<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Minimo</th>
					<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Maximo</th>
					<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Dev. Std.</th>';
				//Si no se ven detalles
				}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
					$html .= '<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Promedio</th>';
				}
				$html .= '
			</tr>
		</thead>
		<tbody>';

			foreach ($arrEquipos as $rutas) {
				//Verifico si existen datos
				if(isset($rutas['MedMin'], $rutas['MedMax'])&&$rutas['MedMin']!=0&&$rutas['MedMin']!=''&&$rutas['MedMax']!=0&&$rutas['MedMax']!=''){

					$html .='<tr><td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$rutas['FechaSistema'].'</td>';
					//Si se ven detalles
					if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
						$html .= '
							<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($rutas['MedProm'], 2).' '.DeSanitizar($rutas['Unimed']).'</td>
							<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($rutas['MedMin'], 2).' '.DeSanitizar($rutas['Unimed']).'</td>
							<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($rutas['MedMax'], 2).' '.DeSanitizar($rutas['Unimed']).'</td>
							<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($rutas['MedDesStan'], 2).' '.DeSanitizar($rutas['Unimed']).'</td>
						';
					//Si no se ven detalles
					}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
						$html .= '
							<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($rutas['MedProm'], 2).' '.DeSanitizar($rutas['Unimed']).'</td>
						';
					}
					$html .= '</tr>';
				}
			}

	$html .='</tbody>
	</table>';

	/**********************************************************************************************************************************/
	/*                                                          Impresion PDF                                                         */
	/**********************************************************************************************************************************/
	//Config
	$pdf_titulo     = 'Max – Min Sensor';
	$pdf_subtitulo  = 'Max – Min Sensor N° '.$_GET['sensorn'].' '.DeSanitizar($arrEquipos[0]['SensorNombre']).' '.DeSanitizar($rowEquipo['NombreEquipo']);
	$pdf_file       = 'Max – Min Sensor N° '.$_GET['sensorn'].' '.DeSanitizar($arrEquipos[0]['SensorNombre']).' '.DeSanitizar($rowEquipo['NombreEquipo']).'.pdf';
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
}

?>
