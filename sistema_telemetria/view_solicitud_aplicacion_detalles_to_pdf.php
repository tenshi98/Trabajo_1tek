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
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){   $idSistema   = simpleDecode($_GET['idSistema'], fecha_actual());  }elseif(isset($_POST['idSistema'])&&$_POST['idSistema']!=''){  $idSistema   = simpleDecode($_POST['idSistema'], fecha_actual());}
if(isset($_GET['view'])&&$_GET['view']!=''){      $view        = simpleDecode($_GET['view'], fecha_actual());       }elseif(isset($_POST['view'])&&$_POST['view']!=''){     $view        = simpleDecode($_POST['view'], fecha_actual());}

//Se buscan la imagen i el tipo de PDF
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
	//Consulta
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema ='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}

//se recorre deacuerdo a la cantidad de sensores
$subquery = '';
$Nsens = 6;
for ($i = 1; $i <= $Nsens; $i++) {
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Prom';
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Min';
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Max';
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS Sensor_'.$i.'_Nombre';
}

$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_termino,

cross_predios_listado.Nombre AS PredioNombre,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
cross_predios_listado_zonas.Plantas AS CuartelCantPlantas,

telemetria_listado.Nombre AS NebNombre,
vehiculos_listado.Nombre AS TractorNombre,
telemetria_listado.cantSensores,
cross_solicitud_aplicacion_listado_tractores.idTractores,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,
cross_solicitud_aplicacion_listado_tractores.GeoDistance,
cross_solicitud_aplicacion_listado_tractores.idTelemetria,

cross_solicitud_aplicacion_listado_cuarteles.VelTractor,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
cross_solicitud_aplicacion_listado.f_ejecucion'.$subquery;
$SIS_join  = '
LEFT JOIN `cross_solicitud_aplicacion_listado`             ON cross_solicitud_aplicacion_listado.idSolicitud             = cross_solicitud_aplicacion_listado_tractores.idSolicitud
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles   = cross_solicitud_aplicacion_listado_tractores.idCuarteles
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                            = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                               = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `telemetria_listado_sensores_nombre`             ON telemetria_listado_sensores_nombre.idTelemetria            = cross_solicitud_aplicacion_listado_tractores.idTelemetria';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idTractores ='.$view;
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;}
table {border-collapse: collapse;border-spacing: 0;}
tr.oddrow td{display: line;border-bottom: 1px solid #EEE;}
.tableline td, .tableline th{border-bottom: 1px solid #EEE;line-height: 1.42857143;}
</style>';

$html .= '
<table style="border: 1px solid #f4f4f4;margin: 1%; width: 98%;"   cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td>

				<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="2" rowspan="1" style="vertical-align: top;">Detalles Solicitud de Aplicacion N°'.n_doc($rowData['NSolicitud'], 7).'</td>
							<td style="vertical-align: top;">Fecha Termino: '.Fecha_estandar($rowData['f_termino']).'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:33%;">
								Identificacion<br/>
								<strong>Predio:</strong> '.$rowData['PredioNombre'].'<br/>
								<strong>Especie:</strong> '.$rowData['VariedadCat'].'<br/>
								<strong>Variedad:</strong> '.$rowData['VariedadNombre'].'<br/>
								<strong>Cuartel:</strong> '.$rowData['CuartelNombre'].'<br/>
								<strong>Tractor:</strong> '.$rowData['TractorNombre'].'<br/>
								<strong>Nebulizador:</strong> '.$rowData['NebNombre'].'<br/>
							</td>
							<td style="vertical-align: top; width:33%;">
								Velocidad Tractores (Km/hr)<br/>
								<strong>Minima:</strong> '.Cantidades($rowData['GeoVelocidadMin'], 2).'<br/>
								<strong>Maxima:</strong> '.Cantidades($rowData['GeoVelocidadMax'], 2).'<br/>
								<strong>Promedio:</strong> '.Cantidades($rowData['GeoVelocidadProm'], 2).'<br/>
								<strong>Programada:</strong> '.Cantidades($rowData['VelTractor'], 2).'<br/>
							</td>
							<td style="vertical-align: top; width:33%;">
								Distancia Recorrida(KM)<br/>
								<strong>Recorrida:</strong> '.Cantidades($rowData['GeoDistance'], 2).'<br/>
								<strong>Estimada:</strong> '.Cantidades(($rowData['CuartelDistanciaPlant']*$rowData['CuartelCantPlantas'])/1000, 2).'<br/>
								<strong>Faltante:</strong> '.Cantidades((($rowData['CuartelDistanciaPlant']*$rowData['CuartelCantPlantas'])/1000) - $rowData['GeoDistance'], 2).'<br/>
							</td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:70%;"><strong>Sensor</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Minimo</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Maximo</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Promedio</strong></th>
						</tr>
					</thead>
					<tbody>';
						//si existen productos
						for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
							$html .= '
							<tr>
								<td style="vertical-align: top;">'.$rowData['Sensor_'.$i.'_Nombre'].'</td>
								<td align="right">'.Cantidades($rowData['Sensor_'.$i.'_Min'], 1).'</td>
								<td align="right">'.Cantidades($rowData['Sensor_'.$i.'_Max'], 1).'</td>
								<td align="right">'.Cantidades($rowData['Sensor_'.$i.'_Prom'], 1).'</td>
							</tr>';
						}

					$html .= '
					</tbody>
				</table>';

			$html .= '
			</td>
		</tr>
	</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Detalles Solicitud de Aplicacion N°'.n_doc($rowData['NSolicitud'], 7);
$pdf_subtitulo  = 'Fecha Termino: '.Fecha_estandar($rowData['f_termino']);
$pdf_file       = 'Detalles Solicitud '.n_doc($rowData['NSolicitud'], 7).'.pdf';
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
				$pdf->Image('@'.$imgdata, 15, 130, 180, 120, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
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
