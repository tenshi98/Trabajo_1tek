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
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){      $idSistema     = $_GET['idSistema'];     }elseif(isset($_POST['idSistema'])&&$_POST['idSistema']!=''){$idSistema     = $_POST['idSistema'];}
if(isset($_GET['fecha_desde'])&&$_GET['fecha_desde']!=''){  $fecha_desde   = $_GET['fecha_desde'];   }elseif(isset($_POST['fecha_desde'])&&$_POST['fecha_desde']!=''){   $fecha_desde   = $_POST['fecha_desde'];}
if(isset($_GET['fecha_hasta'])&&$_GET['fecha_hasta']!=''){  $fecha_hasta   = $_GET['fecha_hasta'];   }elseif(isset($_POST['fecha_hasta'])&&$_POST['fecha_hasta']!=''){   $fecha_hasta   = $_POST['fecha_hasta'];}
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
if(isset($fecha_desde)&&$fecha_desde!=''&&isset($fecha_hasta)&&$fecha_hasta!=''){
	$SIS_where.= " AND ".$x_table.".Fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."'";
}
if(isset($idTelemetria)&&$idTelemetria!=''){
	$SIS_where.= " AND ".$x_table.".idTelemetria='".$idTelemetria."'";
}
/**********************************************************/
// Se trae un listado con todos los datos
$SIS_query = 
$x_table.'.Fecha,
'.$x_table.'.Hora,
'.$x_table.'.TimeStamp,
'.$x_table.'.Temperatura,
'.$x_table.'.PuntoRocio,
'.$x_table.'.PresionAtmos,
'.$x_table.'.HorasBajoGrados,
'.$x_table.'.Tiempo_Helada,
'.$x_table.'.Dias_acumulado,
'.$x_table.'.UnidadesFrio';
$SIS_join  = '';
$SIS_order = $x_table.'.Fecha ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, $x_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

//Variables
$arrMed  = array();
$counter = 0;
//recorro los datos
foreach ($arrMediciones as $med) {
	//verifico que exista fecha
	if(isset($med['Fecha'])&&$med['Fecha']!='0000-00-00'){
		//verifico cambio de dia
		if((isset($arrMed[$counter]['Fecha'])&&$arrMed[$counter]['Fecha']!=$med['Fecha']) OR $counter==0){
			$counter++;
		}

		//creo las variables si estas no existen
		if(!isset($arrMed[$counter]['Tiempo_Helada'])){  $arrMed[$counter]['Tiempo_Helada']  = 0;}
		if(!isset($arrMed[$counter]['Temp_Min'])){       $arrMed[$counter]['Temp_Min']       = 1000;}
		if(!isset($arrMed[$counter]['Temp_Max'])){       $arrMed[$counter]['Temp_Max']       = -1000;}

		//Guardo los datos
		$arrMed[$counter]['Fecha']        = $med['Fecha'];
		$arrMed[$counter]['UnidadesFrio'] = $med['UnidadesFrio'];
		$arrMed[$counter]['DiasAcum']     = $med['Dias_acumulado'];

		//verifico si hubo helada
		if(isset($med['Tiempo_Helada'])&&$med['Tiempo_Helada']!=''&&$med['Tiempo_Helada']!=0){
			//guardo el tiempo de helada
			$arrMed[$counter]['Tiempo_Helada'] = $arrMed[$counter]['Tiempo_Helada'] + $med['Tiempo_Helada']; 
		}
		//Guardo la temperatura Minima
		if(isset($med['Temperatura'])&&$med['Temperatura']<$arrMed[$counter]['Temp_Min']){
			$arrMed[$counter]['Temp_Min'] = $med['Temperatura'];
		}
		//Guardo la temperatura Maxima
		if(isset($med['Temperatura'])&&$med['Temperatura']>$arrMed[$counter]['Temp_Max']){
			$arrMed[$counter]['Temp_Max'] = $med['Temperatura'];
		}
	}
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
	$html .= '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';

}

$html .= '
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border: 1px solid black;background-color: #ffffff;">
	<thead>';
		$html .='	
		<tr>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Mes</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Dia</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Helada</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura<br/>Minima</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura<br/>Maxima</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Duracion<br/>Helada</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Unidades<br/>Frio</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Unidades Frio<br/>Acumuladas</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Dias<br/>Grado</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Dias Grado<br/>Acumuladas</th>
		</tr>
	</thead>
	<tbody>';
		
	 
	$unifrio  = 0;
	$diasAcum = 0;
	foreach ($arrMed as $key => $med){
		//verifico helada	
		if(isset($med['Tiempo_Helada'])&&$med['Tiempo_Helada']!=0){$helada = 'Si';}else{$helada = 'No';}
		if($unifrio==0){
			$unfrio=$med['UnidadesFrio'];
			$unifrio=$med['UnidadesFrio'];
		}else{
			$unfrio=$med['UnidadesFrio']-$unifrio;
			$unifrio=$med['UnidadesFrio'];
		}
		if($diasAcum==0){
			$diaAcum=$med['DiasAcum'];
			$diasAcum=$med['DiasAcum'];
		}else{
			$diaAcum=$med['DiasAcum']-$diasAcum;
			$diasAcum=$med['DiasAcum'];
		}	
		$html .='
			<tr>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.numero_a_mes(fecha2NMes($med['Fecha'])).'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.fecha2NdiaMes($med['Fecha']).'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$helada.'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$med['Temp_Min'].'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$med['Temp_Max'].'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.minutos2horas($med['Tiempo_Helada']*60).'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.cantidades($unfrio, 0).'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.cantidades($med['UnidadesFrio'], 0).'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.cantidades($diaAcum, 0).'</td>
				<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.cantidades($med['DiasAcum'], 0).'</td>
			</tr>';
				
			
			
	}
		
							
$html .='</tbody>
</table>';
 


/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Informe Ejecutivo';
$pdf_subtitulo  = DeSanitizar($_SESSION['usuario']['basic_data']['RazonSocial']);
$pdf_subtitulo .= '
De '.Fecha_completa($fecha_desde).' a '.Fecha_completa($fecha_hasta).'
';
$pdf_file       = 'Informe Ejecutivo.pdf';
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

			//se imprime la imagen
			if(isset($_POST["img_adj"]) && $_POST["img_adj"]!=''){
				$imgdata = base64_decode(str_replace('data:image/png;base64,', '',$_POST["img_adj"]));
				// The '@' character is used to indicate that follows an image data stream and not an image file name
				$pdf->Image('@'.$imgdata, 15, 30, 180, 220, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
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
