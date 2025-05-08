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
	$SIS_where .=" (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
/*******************************************************************/
//variables
$ndata_1 = 0;
$ndata_2 = 0;
$ndata_3 = 0;
$error   = '';
//Se verifica si el dato existe
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');
foreach ($_GET["idGrupo"] as $gru) { $ndata_2++;}
if(!isset($_GET['SensoresUniMed']) OR $_GET['SensoresUniMed']==''){$ndata_3++;}
//generacion de errores
if($ndata_1>=10001) { $error = 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados';}
if($ndata_2==0) {     $error = 'No ha seleccionado ningun grupo';}
if($ndata_3!=0) {     $error = 'No ha seleccionado ninguna unidad de medida';}
/*******************************************************************/

//Si no hay errores ejecuto el codigo
if(isset($error)&&$error!=''){
	alert_post_data(4,1,1,0, $error);
}else{
	/****************************************************************/
	//Numero de sensores
	$rowNSensores = db_select_data (false, 'cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	/****************************************************************/
	//obtengo la cantidad real de sensores
	$SIS_query = 'telemetria_listado.Nombre AS NombreEquipo';
	for ($i = 1; $i <= $rowNSensores['cantSensores']; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
	}
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado.idTelemetria';
	$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = 'FechaSistema,HoraSistema';
	for ($i = 1; $i <= $rowNSensores['cantSensores']; $i++) {
		$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
	}
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
	$arrMediciones = array();
	$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

	/*************************************************************/
	//busco los grupos disponibles
	$arrSubgrupo          = array();
	$SIS_whereSubgrupo    = 'idGrupo=0';
	//creo arreglo
	foreach ($_GET["idGrupo"] as $gru) {
		$SIS_whereSubgrupo .= ' OR idGrupo='.$gru;
	}

	/****************************************/
	//Se consulta
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
	//se recorre
	$arrGruposTemp = array();
	foreach ($arrGrupos as $gru) {
		$arrGruposTemp[$gru['idGrupo']]['Nombre'] = TituloMenu($gru['Nombre']);
		$arrGruposTemp[$gru['idGrupo']]['Valor']  = '';
	}

	/****************************************************************/
	//Variables
	$m_table_title  = '';
	//recorro los grupos
	foreach ($_GET["idGrupo"] as $gru) {
		$m_table_title .= '<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">'.$arrGruposTemp[$gru]['Nombre'].'</th>';
	}
	$m_table        = '';
	$Temp_1         = '';

	/*******************************************************************************/
	//se arman datos
	foreach ($arrMediciones as $fac) {
		/************************/
		//Tabla
		$m_table .= '
		<tr>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.fecha_estandar($fac['FechaSistema']).'</td>
			<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$fac['HoraSistema'].'</td>';

		/************************/
		//Variables
		$arrTemp = array();
		//recorro los grupos
		foreach ($_GET["idGrupo"] as $gru) {
			/***********************************************/
			//recorro los sensores
			for ($x = 1; $x <= $rowNSensores['cantSensores']; $x++) {
				if($rowEquipo['SensoresGrupo_'.$x]==$gru){
					//Verifico si el sensor esta activo para guardar el dato
					if(isset($rowEquipo['SensoresActivo_'.$x])&&$rowEquipo['SensoresActivo_'.$x]==1){
						//Que el valor medido sea distinto de 999
						if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
							//promedio
							if($rowEquipo['SensoresUniMed_'.$x]==$_GET['SensoresUniMed']){
								$arrTemp[$gru]['Value'] = $arrTemp[$gru]['Value'] + $fac['SensorValue_'.$x];
								$arrTemp[$gru]['Count']++;
							}
						}
					}
				}
			}
			/***********************************************/
			//saco promedios
			if($arrTemp[$gru]['Count']!=0){
				$arrTemp[$gru]['Prom'] = $arrTemp[$gru]['Value']/$arrTemp[$gru]['Count'];
			}else{
				$arrTemp[$gru]['Prom'] = 0;
			}

			/***********************************************/
			//tabla
			$m_table .= '<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.Cantidades($arrTemp[$gru]['Prom'], 1).'</td>';

		}

		/************************/
		//Tabla
		$m_table .= '</tr>';
	}


	/********************************************************************/
	//Se define el contenido del PDF
	$html = '
	<style>
		tbody tr:nth-child(odd) {background-color: #dfdfdf;}
	</style>';


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
	$pdf_titulo     = 'Trazabilidad';
	$pdf_subtitulo  = DeSanitizar($_SESSION['usuario']['basic_data']['RazonSocial']);
	$pdf_file       = 'Informe Trazabilidad del equipo '.$rowEquipo['NombreEquipo'].'.pdf';
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
