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
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){  $idSistema   = $_GET['idSistema'];   }elseif(isset($_POST['idSistema'])&&$_POST['idSistema']!=''){  $idSistema   = $_POST['idSistema'];}
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''){    $f_inicio    = $_GET['f_inicio'];    }elseif(isset($_POST['f_inicio'])&&$_POST['f_inicio']!=''){    $f_inicio    = $_POST['f_inicio'];}
if(isset($_GET['f_termino'])&&$_GET['f_termino']!=''){  $f_termino   = $_GET['f_termino'];   }elseif(isset($_POST['f_termino'])&&$_POST['f_termino']!=''){  $f_termino   = $_POST['f_termino'];}
if(isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''){    $h_inicio    = $_GET['h_inicio'];    }elseif(isset($_POST['h_inicio'])&&$_POST['h_inicio']!=''){    $h_inicio    = $_POST['h_inicio'];}
if(isset($_GET['h_termino'])&&$_GET['h_termino']!=''){  $h_termino   = $_GET['h_termino'];   }elseif(isset($_POST['h_termino'])&&$_POST['h_termino']!=''){  $h_termino   = $_POST['h_termino'];}
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
//Variable de busqueda
$SIS_where = $x_table.".idSistema=".$idSistema;
if(isset($f_inicio, $f_termino, $h_inicio, $h_termino)&&$f_inicio!=''&&$f_termino!=''&&$h_inicio!=''&&$h_termino!=''){
	$SIS_where.= " AND (".$x_table.".TimeStamp BETWEEN '".$f_inicio." ".$h_inicio."' AND '".$f_termino." ".$h_termino."')";
}elseif(isset($f_inicio, $f_termino)&&$f_inicio!=''&&$f_termino!=''){
	$SIS_where.= " AND (".$x_table.".Fecha BETWEEN '".$f_inicio."' AND '".$f_termino."')";
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
$arrTemp   = array();
foreach($arrHistorial as $hist2) {
	//verifico que exista fecha
	if(isset($hist2['Fecha'])&&$hist2['Fecha']!='0000-00-00'){
		//Se obtiene la fecha
		$y_dia = fecha2NdiaMes($hist2['Fecha']);
		$y_mes = fecha2NMes($hist2['Fecha']);
		//se obtiene la hora
		$y_time   = strtotime($hist2['Hora']);
		$y_hora   = date('H', $y_time);
		$y_minuto = date('i', $y_time);
		//se guardan los datos
		$arrTemp[$y_mes][$y_dia][$y_hora][$y_minuto] = $hist2['Temperatura'];
	}
}
/****************************************************************************/
//datos graficos
$tabla  = '';
foreach($arrHistorial as $hist) {
	//verifico que exista fecha
	if(isset($hist['HeladaDia'])&&$hist['HeladaDia']!='0000-00-00'){
		//variables
		$temp_predic = $hist['Helada'];

		//Se obtiene la fecha
		$x_dia = fecha2NdiaMes($hist['HeladaDia']);
		$x_mes = fecha2NMes($hist['HeladaDia']);
		$x_ano = fecha2Ano($hist['HeladaDia']);
		//se obtiene la hora
		$x_time     = strtotime($hist['HeladaHora']);
		$x_hora     = date('H', $x_time);
		$x_minuto   = date('i', $x_time);

		//Se crea el dato
		if(isset($arrTemp[$x_mes][$x_dia][$x_hora][$x_minuto])&&$arrTemp[$x_mes][$x_dia][$x_hora][$x_minuto]!=''){							
			$temp_real = $arrTemp[$x_mes][$x_dia][$x_hora][$x_minuto];
		}else{
			$temp_real = 0;
		}

		$tabla  .= '
		<tr>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$x_dia.'-'.$x_mes.'-'.$x_ano.'</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$x_hora.':'.$x_minuto.'</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$temp_real.'</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$temp_predic.'</td>
		</tr>';
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

}


/***************************************************************************/
$html .= '
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border: 1px solid black;background-color: #ffffff;">
	<thead>';
		$html .='	
		<tr>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Fecha</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Hora</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura Real</th>
			<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Temperatura Proyectada</th>
		</tr>
	</thead>
	<tbody>';
	$html .= $tabla;	
						
$html .='</tbody>
</table>';
 


/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Informe Temperaturas';
$pdf_subtitulo  = DeSanitizar($_SESSION['usuario']['basic_data']['RazonSocial']);
$pdf_subtitulo .= '
Desde '.fecha_estandar($f_inicio).' hasta '.fecha_estandar($f_termino).'
';

$pdf_file       = 'Informe Temperaturas.pdf';
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
