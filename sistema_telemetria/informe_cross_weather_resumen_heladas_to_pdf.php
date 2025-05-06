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
//Se revisan los datos
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){   $idSistema   = $_GET['idSistema'];  }elseif(isset($_POST['idSistema'])&&$_POST['idSistema']!=''){  $idSistema   = $_POST['idSistema'];}
if(isset($_GET['fecha'])&&$_GET['fecha']!=''){    $fecha       = $_GET['fecha'];      }elseif(isset($_POST['fecha'])&&$_POST['fecha']!=''){   $fecha       = $_POST['fecha'];}
//Seleccionar la tabla
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$x_table = 'telemetria_listado_aux_equipo';
	$idTelemetria   = $_GET['idTelemetria'];
}else{
	if(isset($_POST['idTelemetria'])&&$_POST['idTelemetria']!=''){
		$x_table = 'telemetria_listado_aux_equipo';
		$idTelemetria   = $_POST['idTelemetria'];
	}else{
		$x_table = 'telemetria_listado_aux';
		$idTelemetria   = '';
	}
}

//Se buscan la imagen i el tipo de PDF
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = $x_table.".idSistema=".$idSistema;
//Se aplican los filtros
if(isset($fecha)&&$fecha!=''){

	//Se organizan los datos
	$FechaActual  = $fecha;
	$HoraActual   = '20:00:00';
	$FechaSig     = sumarDias($fecha, 1);
	$HoraSig      = '09:00:00';

	//se crea query
	$SIS_where.= " AND (".$x_table.".TimeStamp BETWEEN '".$FechaActual." ".$HoraActual ."' AND '".$FechaSig." ".$HoraSig."')";

}
if(isset($idTelemetria)&&$idTelemetria!=''){
	$SIS_where.= " AND ".$x_table.".idTelemetria='".$idTelemetria."'";
}
/**********************************************************/
// Se trae un listado con todos los datos
$SIS_query = 'Fecha, Hora, HeladaDia, HeladaHora, Temperatura, Helada, CrossTech_TempMin ,
Fecha_Anterior, Hora_Anterior, Tiempo_Helada';
$SIS_join  = '';
$SIS_order = 'idAuxiliar ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, $x_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/****************************************************************************/
$arrEvento = array();
$nevento   = 0;
//Se busca la temperatura real
foreach($arrHistorial as $hist2) {
	//verifico que exista fecha
	if(isset($hist2['Fecha'])&&$hist2['Fecha']!='0000-00-00'){
		//se obtiene la hora
		if(isset($hist2['Temperatura'])&&$hist2['Temperatura']<=$hist2['CrossTech_TempMin']){

			//se crean variables en caso de no existir
			if(!isset($arrEvento[$nevento]['TempMinima'])){  $arrEvento[$nevento]['TempMinima']  = 1000;}
			if(!isset($arrEvento[$nevento]['TempMaxima'])){  $arrEvento[$nevento]['TempMaxima']  = -1000;}
			if(!isset($arrEvento[$nevento]['TempSum'])){     $arrEvento[$nevento]['TempSum']  = 0;}
			if(!isset($arrEvento[$nevento]['TempCuenta'])){  $arrEvento[$nevento]['TempCuenta']  = 0;}
			if(!isset($arrEvento[$nevento]['Minutos'])){     $arrEvento[$nevento]['Minutos']  = 0;}
			if(!isset($arrEvento[$nevento]['FechaInicio'])){ $arrEvento[$nevento]['FechaInicio'] = $hist2['Fecha'];}
			if(!isset($arrEvento[$nevento]['HoraInicio'])){  $arrEvento[$nevento]['HoraInicio']  = $hist2['Hora'];}

			$arrEvento[$nevento]['FechaTermino'] = $hist2['Fecha'];
			$arrEvento[$nevento]['HoraTermino']  = $hist2['Hora'];
			$arrEvento[$nevento]['TempSum']      = $arrEvento[$nevento]['TempSum'] + $hist2['Temperatura'];
			$arrEvento[$nevento]['TempCuenta']   = $arrEvento[$nevento]['TempCuenta'] + 1;
			$arrEvento[$nevento]['TempProm']     = $arrEvento[$nevento]['TempSum']/$arrEvento[$nevento]['TempCuenta'];
			$arrEvento[$nevento]['Minutos']      = $arrEvento[$nevento]['Minutos'] + $hist2['Tiempo_Helada'];

			//Guardo la temperatura Minima
			if(isset($hist2['Temperatura'])&&$hist2['Temperatura']<$arrEvento[$nevento]['TempMinima']){
				$arrEvento[$nevento]['TempMinima'] = $hist2['Temperatura'];
			}
			//Guardo la temperatura Maxima
			if(isset($hist2['Temperatura'])&&$hist2['Temperatura']>$arrEvento[$nevento]['TempMaxima']){
				$arrEvento[$nevento]['TempMaxima'] = $hist2['Temperatura'];
			}

		}else{
			$nevento++;
		}
	}
}
/***********************************************************/
$arrResumen               = array();
$arrResumen['Tiempo']     = 0;
$arrResumen['TempMinima'] = 0;
foreach ($arrEvento as $key => $eve){
	//comparo temperaturas
	if($arrResumen['TempMinima']>$eve['TempMinima']){
		$arrResumen['TempMinima']      = $eve['TempMinima'];
		//guardo los otros datos
		if(!isset($arrResumen['Duracion'])OR $arrResumen['Duracion']==''){              $arrResumen['Duracion']        = $eve['Minutos'];}
		if(!isset($arrResumen['HoraTempMinima'])OR $arrResumen['HoraTempMinima']==''){  $arrResumen['HoraTempMinima']  = $eve['HoraInicio'];}

	}
	//tiempo total de la helada
	$arrResumen['Tiempo'] = $arrResumen['Tiempo'] + $eve['Minutos'];
}
/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
	tbody tr:nth-child(odd) {background-color: #dfdfdf;}
</style>';

//se imprime la imagen
if(isset($_POST["img_adj"]) && $_POST["img_adj"]!=''){
	$html .= '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
}
$html .= '
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border: 1px solid black;background-color: #ffffff;">
	<thead>';
		$html .='
		<tr>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura Minima</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Duracion Temp Min</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Hora Temp Minima</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Tiempo bajo '.$arrHistorial[0]['CrossTech_TempMin'].'°C</th>
		</tr>
	</thead>
	<tbody>';


	$html .='
		<tr>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$arrResumen['TempMinima'].'°C</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$arrResumen['Duracion'].' Horas</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$arrResumen['HoraTempMinima'].'</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($arrResumen['Tiempo'], 0).' Horas</td>
		</tr>';


$html .='</tbody>
</table>
<br/><br/>';

/***************************************************************************/
$html .= '
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border: 1px solid black;background-color: #ffffff;">
	<thead>';
		$html .='
		<tr>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Inicio</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Termino</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura Minima</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura Maxima</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura Promedio</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Duracion</th>
		</tr>
	</thead>
	<tbody>';

foreach ($arrEvento as $key => $eve){
	$html .='
		<tr>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$eve['HoraInicio'].' - '.fecha_estandar($eve['FechaInicio']).'</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$eve['HoraTermino'].' - '.fecha_estandar($eve['FechaTermino']).'</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($eve['TempMinima'], 2).'°C</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($eve['TempMaxima'], 2).'°C</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($eve['TempProm'], 2).'°C</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$eve['Minutos'].' horas</td>
		</tr>';

}

$html .='</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Resumen Heladas';
$pdf_subtitulo  = DeSanitizar($_SESSION['usuario']['basic_data']['RazonSocial']);
$pdf_subtitulo .= '
Del dia '.Fecha_completa($fecha).'
';
$pdf_file       = 'Resumen Heladas.pdf';
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
			if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
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

			//se imprime la imagen
			if(isset($_POST["img_adj"]) && $_POST["img_adj"]!=''){
				$imgdata = base64_decode(str_replace('data:image/png;base64,', '',$_POST["img_adj"]));
				// The '@' character is used to indicate that follows an image data stream and not an image file name
				$pdf->Image('@'.$imgdata, 15, 30, 180, 120, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
			}

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
