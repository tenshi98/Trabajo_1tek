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
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){ $idSistema     = $_GET['idSistema'];     }elseif(isset($_POST['idSistema'])&&$_POST['idSistema']!=''){$idSistema     = $_POST['idSistema'];}
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''){   $f_inicio      = $_GET['f_inicio'];      }elseif(isset($_POST['f_inicio'])&&$_POST['f_inicio']!=''){  $f_inicio      = $_POST['f_inicio'];}
if(isset($_GET['f_termino'])&&$_GET['f_termino']!=''){ $f_termino     = $_GET['f_termino'];     }elseif(isset($_POST['f_termino'])&&$_POST['f_termino']!=''){$f_termino     = $_POST['f_termino'];}
if(isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''){   $h_inicio      = $_GET['h_inicio'];      }elseif(isset($_POST['h_inicio'])&&$_POST['h_inicio']!=''){  $h_inicio      = $_POST['h_inicio'];}
if(isset($_GET['h_termino'])&&$_GET['h_termino']!=''){ $h_termino     = $_GET['h_termino'];     }elseif(isset($_POST['h_termino'])&&$_POST['h_termino']!=''){$h_termino     = $_POST['h_termino'];}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){  $idTelemetria  = $_GET['idTelemetria'];  }elseif(isset($_POST['idTelemetria'])&&$_POST['idTelemetria']!=''){ $idTelemetria  = $_POST['idTelemetria'];}
if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){     $idGrupo       = $_GET['idGrupo'];       }elseif(isset($_POST['idGrupo'])&&$_POST['idGrupo']!=''){    $idGrupo       = $_POST['idGrupo'];}
if(isset($_GET['desde'])&&$_GET['desde']!=''){         $desde         = $_GET['desde'];         }elseif(isset($_POST['desde'])&&$_POST['desde']!=''){        $desde         = $_POST['desde'];           }else{$desde = '';}
if(isset($_GET['hasta'])&&$_GET['hasta']!=''){         $hasta         = $_GET['hasta'];         }elseif(isset($_POST['hasta'])&&$_POST['hasta']!=''){        $hasta         = $_POST['hasta'];           }else{$hasta = '';}
if(isset($_GET['idOpciones'])&&$_GET['idOpciones']!=''){      $idOpciones    = $_GET['idOpciones'];    }elseif(isset($_POST['idOpciones'])&&$_POST['idOpciones']!=''){     $idOpciones    = $_POST['idOpciones'];}

//Se buscan la imagen i el tipo de PDF
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$subf='';
if(isset($f_inicio, $f_termino, $h_inicio, $h_termino)&&$f_inicio!=''&&$f_termino!=''&&$h_inicio!=''&&$h_termino!=''){
	$subf = " AND (TimeStamp BETWEEN '".$f_inicio." ".$h_inicio."' AND '".$f_termino." ".$h_termino."')";
}elseif(isset($f_inicio, $f_termino)&&$f_inicio!=''&&$f_termino!=''){
	$subf = " AND (FechaSistema BETWEEN '".$f_inicio."' AND '".$f_termino."')";
}


/**********************************************************************/
//Funcion para escribir datos
function crear_data($INT_cantsens, $INT_filtro, $INT_idTelemetria, $INT_f_inicio, $INT_f_termino, $INT_desde, $INT_hasta, $dbConn ) {

	$consql = '';
	$subfiltro = '';
	for ($i = 1; $i <= $INT_cantsens; $i++) {
		//$subfiltro .= ' AND telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.' != 999';
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		//$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;

		//desde y hasta activo
		if(isset($INT_desde)&&$INT_desde!=''&&isset($INT_hasta)&&$INT_hasta!=''){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedDesStan_'.$i;
		//solo desde
		}elseif(isset($INT_desde)&&$INT_desde!=''&&(!isset($INT_hasta) OR $INT_hasta=='')){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'>='.$INT_desde.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//solo hasta
		}elseif(isset($INT_hasta)&&$INT_hasta!=''&&(!isset($INT_desde) OR $INT_desde=='')){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<='.$INT_hasta.',IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//ninguno
		}else{
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedDesStan_'.$i;
		}
	}

	/*******************************************************/
	//se consulta
	$SIS_query = 'telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.FechaSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.idTelemetria';
	$SIS_where = 'idTabla!=0 '.$INT_filtro.$subfiltro.' GROUP BY telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.FechaSistema';
	$SIS_order = 'telemetria_listado_tablarelacionada_'.$INT_idTelemetria.'.FechaSistema ASC LIMIT 10000';
	$arrRutas = array();
	$arrRutas = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$INT_idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRutas');

	return $arrRutas;

}
/*******************************************************/
//Consulta por la cantidad de sensores
$SIS_query = 'cantSensores, Nombre';
$SIS_where = 'idTelemetria='.$idTelemetria;
$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

/*******************************************************/
//se consulta
//Variable temporal
$arrTemporal = array();
//Llamo a la funcion
$arrTemporal = crear_data($rowEquipo['cantSensores'], $subf, $idTelemetria, $f_inicio, $f_termino, $desde, $hasta , $dbConn);

/*******************************************************/
//Se trae el dato del grupo
$rowGrupo = db_select_data (false, 'Nombre', 'telemetria_listado_grupos', '', 'idGrupo='.$idGrupo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowGrupo');

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
			<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Equipo</th>
			<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Fecha</th>';
			if(isset($idOpciones)&&$idOpciones!=''&&$idOpciones!=0){ 
				switch ($idOpciones) {
					case 1:
						$html .= '<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Temperatura (°C)</th>';
						break;
					case 2:
						$html .= '<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Humedad (%)</th>';
						break;
				}
			}else{
				$html .= '<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Temperatura (°C)</th>';
				$html .= '<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Humedad (%)</th>';
			}
		$html .= '
		</tr>
	</thead>
	<tbody>';

		foreach ($arrTemporal as $fac) {
			//numero sensores equipo
			$Temperatura       = 0;
			$Temperatura_N     = 0;
			$Humedad           = 0;
			$Humedad_N         = 0;

			for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
				if($fac['SensoresGrupo_'.$x]==$idGrupo){
					//Que el valor medido sea distinto de 999
					if(isset($fac['MedProm_'.$x])&&$fac['MedProm_'.$x]<99900){
						//Si es humedad
						if($fac['SensoresUniMed_'.$x]==2){$Humedad = $Humedad + $fac['MedProm_'.$x];$Humedad_N++;}
						//Si es temperatura
						if($fac['SensoresUniMed_'.$x]==3){$Temperatura = $Temperatura + $fac['MedProm_'.$x];$Temperatura_N++;}
					}
				}
			}

			if($Temperatura_N!=0){  $New_Temperatura = $Temperatura/$Temperatura_N; }else{$New_Temperatura = 0;}
			if($Humedad_N!=0){      $New_Humedad     = $Humedad/$Humedad_N;         }else{$New_Humedad = 0;}

			//omite la linea mientras alguna de las variables contenga datos
			if($Temperatura_N!=0 OR $Humedad_N!=0){
				//Se escriben Datos
				$html .='<tr>';
					$html .='<td style="font-size: 10px;text-align:center;">'.DeSanitizar($rowEquipo['Nombre']).'</td>';
					$html .='<td style="font-size: 10px;text-align:center;">'.$fac['FechaSistema'].'</td>';

					if(isset($idOpciones)&&$idOpciones!=''&&$idOpciones!=0){
						switch ($idOpciones) {
							case 1:
								$html .='<td style="font-size: 10px;text-align:center;">'.cantidades($New_Temperatura, 2).' °C</td>';
								break;
							case 2:
								$html .='<td style="font-size: 10px;text-align:center;">'.cantidades($New_Humedad, 2).' %</td>';
								break;
						}
					}else{
						$html .='<td style="font-size: 10px;text-align:center;">'.cantidades($New_Temperatura, 2).' °C</td>';
						$html .='<td style="font-size: 10px;text-align:center;">'.cantidades($New_Humedad, 2).' %</td>';
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
$pdf_titulo     = 'Informe Promedio Camara';
$pdf_subtitulo  = DeSanitizar($_SESSION['usuario']['basic_data']['RazonSocial']);
$pdf_subtitulo .= '
Informe grupo '.DeSanitizar($rowGrupo['Nombre']).' del equipo '.DeSanitizar($rowEquipo['Nombre']).'
';
if(isset($f_inicio, $f_termino, $h_inicio, $h_termino)&&$f_inicio!=''&&$f_termino!=''&&$h_inicio!=''&&$h_termino!=''){
	$pdf_subtitulo .= 'Del '.fecha_estandar($f_inicio).'-'.$h_inicio.' hasta '.fecha_estandar($f_termino).'-'.$h_termino;
}elseif(isset($f_inicio, $f_termino)&&$f_inicio!=''&&$f_termino!=''){
	$pdf_subtitulo .= 'Del '.fecha_estandar($f_inicio).' hasta '.fecha_estandar($f_termino);
}
$pdf_file       = 'Informe Promedio Camara del equipo '.DeSanitizar($rowEquipo['Nombre']).'.pdf';
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
