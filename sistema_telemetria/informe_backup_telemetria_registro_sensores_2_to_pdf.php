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
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){        $idSistema     = $_GET['idSistema'];     }elseif(isset($_POST['idSistema'])&&$_POST['idSistema']!=''){       $idSistema     = $_POST['idSistema'];}
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''){          $f_inicio      = $_GET['f_inicio'];      }elseif(isset($_POST['f_inicio'])&&$_POST['f_inicio']!=''){         $f_inicio      = $_POST['f_inicio'];}
if(isset($_GET['f_termino'])&&$_GET['f_termino']!=''){        $f_termino     = $_GET['f_termino'];     }elseif(isset($_POST['f_termino'])&&$_POST['f_termino']!=''){       $f_termino     = $_POST['f_termino'];}
if(isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''){          $h_inicio      = $_GET['h_inicio'];      }elseif(isset($_POST['h_inicio'])&&$_POST['h_inicio']!=''){         $h_inicio      = $_POST['h_inicio'];}
if(isset($_GET['h_termino'])&&$_GET['h_termino']!=''){        $h_termino     = $_GET['h_termino'];     }elseif(isset($_POST['h_termino'])&&$_POST['h_termino']!=''){       $h_termino     = $_POST['h_termino'];}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){  $idTelemetria  = $_GET['idTelemetria'];  }elseif(isset($_POST['idTelemetria'])&&$_POST['idTelemetria']!=''){ $idTelemetria  = $_POST['idTelemetria'];}
if(isset($_GET['sensorn'])&&$_GET['sensorn']!=''){            $sensorn       = $_GET['sensorn'];       }elseif(isset($_POST['sensorn'])&&$_POST['sensorn']!=''){           $sensorn       = $_POST['sensorn'];}
if(isset($_GET['idDetalle'])&&$_GET['idDetalle']!=''){        $idDetalle     = $_GET['idDetalle'];     }elseif(isset($_POST['idDetalle'])&&$_POST['idDetalle']!=''){       $idDetalle     = $_POST['idDetalle'];}

//Se buscan la imagen i el tipo de PDF
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = '';
if(isset($f_inicio, $f_termino, $h_inicio, $h_termino)&&$f_inicio!=''&&$f_termino!=''&&$h_inicio!=''&&$h_termino!=''){
	$SIS_where.="(backup_telemetria_listado_tablarelacionada_".$idTelemetria.".TimeStamp BETWEEN '".$f_inicio." ".$h_inicio."' AND '".$f_termino." ".$h_termino."')";
}elseif(isset($f_inicio, $f_termino)&&$f_inicio!=''&&$f_termino!=''){
	$SIS_where.="(backup_telemetria_listado_tablarelacionada_".$idTelemetria.".FechaSistema BETWEEN '".$f_inicio."' AND '".$f_termino."')";
}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'backup_telemetria_listado_tablarelacionada_'.$idTelemetria, '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo', 'telemetria_listado', '', 'idTelemetria='.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	/****************************************/
	//consulto
	$SIS_query = '
	telemetria_listado_sensores_nombre.SensoresNombre_'.$sensorn.' AS SensorNombre,
	telemetria_listado_sensores_grupo.SensoresGrupo_'.$sensorn.' AS SensorGrupo,

	backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTabla,
	backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema,
	backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.HoraSistema,
	backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$sensorn.' AS SensorValue,
	telemetria_listado_unidad_medida.Nombre AS Unimed';
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`   ON telemetria_listado_sensores_nombre.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`    ON telemetria_listado_sensores_grupo.idTelemetria    = backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`   ON telemetria_listado_sensores_unimed.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_unidad_medida`     ON telemetria_listado_unidad_medida.idUniMed         = telemetria_listado_sensores_unimed.SensoresUniMed_'.$sensorn;
	$SIS_order = 'backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema ASC, backup_telemetria_listado_tablarelacionada_'.$idTelemetria.'.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/****************************************/
	//Se trae grupo
	$rowGrupo = db_select_data (false, 'Nombre', 'telemetria_listado_grupos', '', 'idGrupo='.$arrEquipos[0]['SensorGrupo'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowGrupo');

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
		<thead>
			<tr>
				<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Fecha</th>
				<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Hora</th>';
				$html .= '<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Medicion</th>';
			$html .= '
			</tr>
		</thead>
		<tbody>';

			foreach ($arrEquipos as $rutas) {
				if(isset($rutas['SensorValue'])&&$rutas['SensorValue']<99900){$xdata=Cantidades_decimales_justos($rutas['SensorValue']).' '.DeSanitizar($rutas['Unimed']);}else{$xdata='Sin Datos';}

				$html .='<tr>
							<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.fecha_estandar($rutas['FechaSistema']).'</td>
							<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$rutas['HoraSistema'].'</td>';
				//Si se ven detalles
				if(isset($idDetalle)&&$idDetalle==1){
					$html .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$xdata.'</td>';
					$html .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades_decimales_justos($rutas['SensorMinMed']).' '.DeSanitizar($rutas['Unimed']).'</td>';
					$html .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades_decimales_justos($rutas['SensorMaxMed']).' '.DeSanitizar($rutas['Unimed']).'</td>';
				//Si no se ven detalles
				}elseif(isset($idDetalle)&&$idDetalle==2){
					$html .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$xdata.'</td>';
				}
				$html .='</tr>';
			}

	$html .='</tbody>
	</table>';

	/**********************************************************************************************************************************/
	/*                                                          Impresion PDF                                                         */
	/**********************************************************************************************************************************/
	//Config
	$pdf_titulo     = 'Registro Sensores';
	$pdf_subtitulo  = 'Informe Sensor '.DeSanitizar($rowGrupo['Nombre']).' '.DeSanitizar($arrEquipos[0]['SensorNombre']);
	$pdf_file       = 'Registro Sensores del equipo '.DeSanitizar($rowEquipo['NombreEquipo']).'.pdf';
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
}

?>
