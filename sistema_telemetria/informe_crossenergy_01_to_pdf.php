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
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){        $idSistema     = $_GET['idSistema'];     }elseif(isset($_POST['idSistema'])&&$_POST['idSistema']!=''){       $idSistema     = $_POST['idSistema'];}
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''){          $f_inicio      = $_GET['f_inicio'];      }elseif(isset($_POST['f_inicio'])&&$_POST['f_inicio']!=''){         $f_inicio      = $_POST['f_inicio'];}
if(isset($_GET['f_termino'])&&$_GET['f_termino']!=''){        $f_termino     = $_GET['f_termino'];     }elseif(isset($_POST['f_termino'])&&$_POST['f_termino']!=''){       $f_termino     = $_POST['f_termino'];}
if(isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''){          $h_inicio      = $_GET['h_inicio'];      }elseif(isset($_POST['h_inicio'])&&$_POST['h_inicio']!=''){         $h_inicio      = $_POST['h_inicio'];}
if(isset($_GET['h_termino'])&&$_GET['h_termino']!=''){        $h_termino     = $_GET['h_termino'];     }elseif(isset($_POST['h_termino'])&&$_POST['h_termino']!=''){       $h_termino     = $_POST['h_termino'];}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){  $idTelemetria  = $_GET['idTelemetria'];  }elseif(isset($_POST['idTelemetria'])&&$_POST['idTelemetria']!=''){ $idTelemetria  = $_POST['idTelemetria'];}
if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){            $idGrupo       = $_GET['idGrupo'];       }elseif(isset($_POST['idGrupo'])&&$_POST['idGrupo']!=''){           $idGrupo       = $_POST['idGrupo'];}

//Se buscan la imagen i el tipo de PDF
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = '';
if(isset($f_inicio, $f_termino, $h_inicio, $h_termino)&&$f_inicio!=''&&$f_termino!=''&&$h_inicio!=''&&$h_termino!=''){
	$SIS_where.= "(telemetria_listado_crossenergy_dia.TimeStamp BETWEEN '".$f_inicio." ".$h_inicio."' AND '".$f_termino." ".$h_termino."')";
}elseif(isset($f_inicio, $f_termino)&&$f_inicio!=''&&$f_termino!=''){
	$SIS_where.= "(telemetria_listado_crossenergy_dia.FechaSistema BETWEEN '".$f_inicio."' AND '".$f_termino."')";
}
$SIS_where.= " AND telemetria_listado_crossenergy_dia.idTelemetria=".$idTelemetria;

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_crossenergy_dia', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{

	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo, cantSensores', 'telemetria_listado', '', 'idTelemetria='.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensoresNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$consql .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
		$consql .= ',telemetria_listado_crossenergy_dia.Sensor_'.$i.' AS SensorValue_'.$i;
	}

	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = '
	telemetria_listado_crossenergy_dia.FechaSistema,
	telemetria_listado_crossenergy_dia.HoraSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_crossenergy_dia.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_crossenergy_dia.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_crossenergy_dia.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado_crossenergy_dia.idTelemetria';
	$SIS_order = 'telemetria_listado_crossenergy_dia.FechaSistema ASC, telemetria_listado_crossenergy_dia.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_dia', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/****************************************************************/
	//Se trae el dato del grupo
	$rowGrupo = db_select_data (false, 'Nombre', 'telemetria_listado_grupos', '', 'idGrupo='.$idGrupo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowGrupo');

	//Variables
	$m_table        = '';
	$m_table_title  = '';
	$count          = 0;

	//se arman datos
	foreach ($arrEquipos as $fac) {

		//numero sensores equipo
		$m_table          .= '<tr class="odd">';
		$m_table          .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.fecha_estandar($fac['FechaSistema']).'</td>';
		$m_table          .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$fac['HoraSistema'].'</td>';

		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			if($fac['SensoresGrupo_'.$x]==$idGrupo){
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($fac['SensoresActivo_'.$x])&&$fac['SensoresActivo_'.$x]==1){
					//Que el valor medido sea distinto de 999
					if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
						//Graficos
						$m_table .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.cantidades($fac['SensorValue_'.$x], 2).'</td>';
						//si es el primer recorrido
						if($count==0){
							$m_table_title  .= '<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">'.DeSanitizar($fac['SensoresNombre_'.$x]).'</th>';
						}
					}
				}
			}
		}
		$m_table .= '</tr>';

		$count++;

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
				<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Fecha</th>
				<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Hora</th>
				'.$m_table_title.'
			</tr>
		</thead>
		<tbody>
			'.$m_table.'
		</tbody>
	</table>';

	/**********************************************************************************************************************************/
	/*                                                          Impresion PDF                                                         */
	/**********************************************************************************************************************************/
	//Config
	$pdf_titulo     = 'Resumen Dia';
	$pdf_subtitulo  = DeSanitizar($_SESSION['usuario']['basic_data']['RazonSocial']);
	$pdf_subtitulo .= '
	Informe grupo '.DeSanitizar($rowGrupo['Nombre']).' del equipo '.DeSanitizar($rowEquipo['NombreEquipo']).'
	';
	if(isset($f_inicio, $f_termino, $h_inicio, $h_termino)&&$f_inicio!=''&&$f_termino!=''&&$h_inicio!=''&&$h_termino!=''){
		$pdf_subtitulo .= 'Del '.fecha_estandar($f_inicio).'-'.$h_inicio.' hasta '.fecha_estandar($f_termino).'-'.$h_termino;
	}elseif(isset($f_inicio, $f_termino)&&$f_inicio!=''&&$f_termino!=''){
		$pdf_subtitulo .= 'Del '.fecha_estandar($f_inicio).' hasta '.fecha_estandar($f_termino);
	}
	$pdf_file       = 'Informe Resumen Dia grupo '.DeSanitizar($rowGrupo['Nombre']).' del equipo '.DeSanitizar($rowEquipo['NombreEquipo']).'.pdf';
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
}

?>
