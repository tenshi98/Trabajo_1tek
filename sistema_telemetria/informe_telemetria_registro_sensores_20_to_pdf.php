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

//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema!="0000-00-00"';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	/****************************************************************/
	$SIS_query = '
	telemetria_listado.Nombre AS NombreEquipo,
	telemetria_listado.cantSensores';
	for ($i = 1; $i <= 72; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
	}
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado.idTelemetria';
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		//Verifico la unidad de medida
		if(isset($rowEquipo['SensoresUniMed_'.$i])&&$rowEquipo['SensoresUniMed_'.$i]==12){
			$consql .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
	}
	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = 'FechaSistema, HoraSistema'.$consql;
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/**********************************************************************/
	//Se traen todos los grupos
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupo');

	//guardo los grupos
	$Grupo = array();
	foreach ($arrGrupo as $sen) {
		$Grupo[$sen['idGrupo']] = $sen['Nombre'];
	}

	/****************************************************************/
	//Variables
	$m_table_title  = '';
	$m_table        = '';
	$arrTableTemp   = array();
	$arrTable       = array();

	/****************************************************************/
	//titulo de la tabla
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		//Verifico la unidad de medida
		if(isset($rowEquipo['SensoresUniMed_'.$i])&&$rowEquipo['SensoresUniMed_'.$i]==12){
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
				$m_table_title   .= '<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">'.$Grupo[$rowEquipo['SensoresGrupo_'.$i]].'</th>';
				$arrTableTemp[$i] = 99999;//se resetea
			}
		}
	}

	//variables
	$posit           = 0;
	$Ult_diaInicio   = '';
	$Ult_diaTermino  = '';
	$Ult_horaInicio  = '';
	$Ult_horaTermino = '';

	//se arman datos
	foreach ($arrEquipos as $fac) {
		//variable
		$table  = '';
		$table2 = '';
		$count  = 0;
		//recorro los sensores
		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			//Verifico la unidad de medida
			if(isset($rowEquipo['SensoresUniMed_'.$x])&&$rowEquipo['SensoresUniMed_'.$x]==12){
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($rowEquipo['SensoresActivo_'.$x])&&$rowEquipo['SensoresActivo_'.$x]==1){
					//Que el valor medido sea distinto de 999
					if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
						//verifico si hay cambios en el valor
						if($arrTableTemp[$x]!=$fac['SensorValue_'.$x]){
							//guardo dato de la tabla
							switch ($fac['SensorValue_'.$x]) {
								case 0: $table .= '<td>Cerrado</td>'; break;
								case 1: $table .= '<td>Abierto</td>'; break;
							}
							//guardo el valor para el proximo bucle
							$arrTableTemp[$x] = $fac['SensorValue_'.$x];
							//cuento
							$count++;
						}else{
							$table  .= '<td></td>';
							//guardo dato de la tabla
							switch ($fac['SensorValue_'.$x]) {
								case 0: $table2 .= '<td>Cerrado</td>'; break;
								case 1: $table2 .= '<td>Abierto</td>'; break;
							}
							//guardo el valor para el proximo bucle
							$arrTableTemp[$x] = $fac['SensorValue_'.$x];
						}
					}
				}
			}
		}
		//se crea la fila
		if($count!=0){
			//variables
			$anterior    = $posit - 1;
			//verifico si existe
			if(isset($arrTable[$anterior]['FechaHasta'], $arrTable[$anterior]['HoraHasta'])){
				$diaInicio   = $arrTable[$anterior]['FechaHasta'];
				$horaInicio  = $arrTable[$anterior]['HoraHasta'];
			}else{
				$diaInicio   = $fac['FechaSistema'];
				$horaInicio  = $fac['HoraSistema'];
			}

			$diaTermino  = $fac['FechaSistema'];
			$horaTermino = $fac['HoraSistema'];
			$HorasTrans  = horas_transcurridas($diaInicio, $diaTermino, $horaInicio, $horaTermino);

			//recorro
			$arrTable[$posit]['FechaDesde'] = $diaInicio;
			$arrTable[$posit]['FechaHasta'] = $diaTermino;
			$arrTable[$posit]['HoraDesde']  = $horaInicio;
			$arrTable[$posit]['HoraHasta']  = $horaTermino;
			$arrTable[$posit]['Duracion']   = $HorasTrans;
			$arrTable[$posit]['Contenido']  = $table;

			//cuento
			$posit++;

			//Guardo el ultimo registro
			$Ult_diaInicio   = $fac['FechaSistema'];
			$Ult_horaInicio  = $fac['HoraSistema'];

		}

		//Guardo el ultimo registro
		$Ult_diaTermino  = $fac['FechaSistema'];
		$Ult_horaTermino = $fac['HoraSistema'];

	}

	//recorro los registros
	for ($x = 1; $x < $posit; $x++) {
		$m_table .= '<tr class="odd">';
		$m_table .= '<td>'.fecha_estandar($arrTable[$x]['FechaDesde']).'</td>';
		$m_table .= '<td>'.$arrTable[$x]['HoraDesde'].'</td>';
		$m_table .= '<td>'.fecha_estandar($arrTable[$x]['FechaHasta']).'</td>';
		$m_table .= '<td>'.$arrTable[$x]['HoraHasta'].'</td>';
		$m_table .= '<td>'.$arrTable[$x]['Duracion'].'</td>';
		$m_table .= $arrTable[$x]['Contenido'];
		$m_table .= '</tr>';
	}

	//Verifico si existe
	if(isset($Ult_diaInicio)&&$Ult_diaInicio!=''&&$Ult_diaInicio!='0000-00-00'){
		//Ultima linea
		$HorasTrans  = horas_transcurridas($Ult_diaInicio, $Ult_diaTermino, $Ult_horaInicio, $Ult_horaTermino);
		$m_table .= '<tr class="odd">';
		$m_table .= '<td>'.fecha_estandar($Ult_diaInicio).'</td>';
		$m_table .= '<td>'.$Ult_horaInicio.'</td>';
		$m_table .= '<td>'.fecha_estandar($Ult_diaTermino).'</td>';
		$m_table .= '<td>'.$Ult_horaTermino.'</td>';
		$m_table .= '<td>'.$HorasTrans.'</td>';
		$m_table .= $table2;
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
				<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Fecha Inicio</th>
				<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Hora Inicio</th>
				<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Fecha Termino</th>
				<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Hora Termino</th>
				<th style="font-size: 10px;text-align:center;background-color: #c3c3c3;">Duracion</th>
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
	$pdf_titulo     = 'Informe Apertura Camara';
	$pdf_subtitulo  = DeSanitizar($_SESSION['usuario']['basic_data']['RazonSocial']);
	$pdf_subtitulo .= '
	Informe equipo '.DeSanitizar($rowEquipo['NombreEquipo']).'
	';
	if(isset($f_inicio, $f_termino, $h_inicio, $h_termino)&&$f_inicio!=''&&$f_termino!=''&&$h_inicio!=''&&$h_termino!=''){
		$pdf_subtitulo .= 'Del '.fecha_estandar($f_inicio).'-'.$h_inicio.' hasta '.fecha_estandar($f_termino).'-'.$h_termino;
	}elseif(isset($f_inicio, $f_termino)&&$f_inicio!=''&&$f_termino!=''){
		$pdf_subtitulo .= 'Del '.fecha_estandar($f_inicio).' hasta '.fecha_estandar($f_termino);
	}
	$pdf_file       = 'Informe equipo '.DeSanitizar($rowEquipo['NombreEquipo']).'.pdf';
	$OpcDom         = "'A4', 'landscape'";
	$OpcTcpOrt      = "L";  //P->PORTRAIT - L->LANDSCAPE
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
