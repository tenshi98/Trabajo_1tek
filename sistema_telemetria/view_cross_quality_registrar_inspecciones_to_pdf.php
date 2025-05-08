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
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
//Se buscan la imagen i el tipo de PDF
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
	//Consulta
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema ='.simpleDecode($_GET['idSistema'], fecha_actual()), $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
// Se traen todos los datos del analisis
$SIS_query = '
cross_quality_registrar_inspecciones.fecha_auto,
cross_quality_registrar_inspecciones.Creacion_fecha,
cross_quality_registrar_inspecciones.Temporada,
cross_quality_registrar_inspecciones.Observaciones,

core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
core_cross_quality_analisis_calidad.Nombre AS TipoAnalisis,
sistema_variedades_categorias.Nombre AS ProductoCategoria,
variedades_listado.Nombre AS ProductoNombre,

cross_quality_registrar_inspecciones.idCategoria,
cross_quality_registrar_inspecciones.idTipo,
cross_quality_registrar_inspecciones.idSistema,
(SELECT
cross_quality_calidad_matriz.cantPuntos
FROM `sistema_variedades_categorias_matriz_calidad`
LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz
WHERE sistema_variedades_categorias_matriz_calidad.idCategoria = cross_quality_registrar_inspecciones.idCategoria
AND sistema_variedades_categorias_matriz_calidad.idProceso = cross_quality_registrar_inspecciones.idTipo
AND sistema_variedades_categorias_matriz_calidad.idSistema = cross_quality_registrar_inspecciones.idSistema
) AS Producto_cantPuntos,

(SELECT
sistema_variedades_categorias_matriz_calidad.idMatriz
FROM `sistema_variedades_categorias_matriz_calidad`
LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz
WHERE sistema_variedades_categorias_matriz_calidad.idCategoria = cross_quality_registrar_inspecciones.idCategoria
AND sistema_variedades_categorias_matriz_calidad.idProceso = cross_quality_registrar_inspecciones.idTipo
AND sistema_variedades_categorias_matriz_calidad.idSistema = cross_quality_registrar_inspecciones.idSistema
) AS Producto_idCalidad,

ubicacion_listado.Nombre AS UbicacionNombre,
ubicacion_listado_level_1.Nombre AS UbicacionNombre_lvl_1,
ubicacion_listado_level_2.Nombre AS UbicacionNombre_lvl_2,
ubicacion_listado_level_3.Nombre AS UbicacionNombre_lvl_3,
ubicacion_listado_level_4.Nombre AS UbicacionNombre_lvl_4,
ubicacion_listado_level_5.Nombre AS UbicacionNombre_lvl_5';
$SIS_join  = '
LEFT JOIN `core_sistemas`                          ON core_sistemas.idSistema                      = cross_quality_registrar_inspecciones.idSistema
LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                   = cross_quality_registrar_inspecciones.idUsuario
LEFT JOIN `core_cross_quality_analisis_calidad`    ON core_cross_quality_analisis_calidad.idTipo   = cross_quality_registrar_inspecciones.idTipo
LEFT JOIN `sistema_variedades_categorias`          ON sistema_variedades_categorias.idCategoria    = cross_quality_registrar_inspecciones.idCategoria
LEFT JOIN `variedades_listado`                     ON variedades_listado.idProducto                = cross_quality_registrar_inspecciones.idProducto
LEFT JOIN `ubicacion_listado`                      ON ubicacion_listado.idUbicacion                = cross_quality_registrar_inspecciones.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`              ON ubicacion_listado_level_1.idLevel_1          = cross_quality_registrar_inspecciones.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`              ON ubicacion_listado_level_2.idLevel_2          = cross_quality_registrar_inspecciones.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`              ON ubicacion_listado_level_3.idLevel_3          = cross_quality_registrar_inspecciones.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`              ON ubicacion_listado_level_4.idLevel_4          = cross_quality_registrar_inspecciones.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`              ON ubicacion_listado_level_5.idLevel_5          = cross_quality_registrar_inspecciones.idUbicacion_lvl_5';
$SIS_where = 'cross_quality_registrar_inspecciones.idAnalisis ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
// Se trae un listado con todos los trabajadores
$SIS_query = '
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Cargo,
trabajadores_listado.Rut';
$SIS_join  = 'LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador   = cross_quality_registrar_inspecciones_trabajador.idTrabajador';
$SIS_where = 'cross_quality_registrar_inspecciones_trabajador.idAnalisis ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrTrabajadores = array();
$arrTrabajadores = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_trabajador', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajadores');

/***************************************************/
// Se trae un listado con todas las maquinas
$SIS_query = '
maquinas_listado.Nombre,
maquinas_listado.Codigo';
$SIS_join  = 'LEFT JOIN `maquinas_listado`  ON maquinas_listado.idMaquina   = cross_quality_registrar_inspecciones_maquina.idMaquina';
$SIS_where = 'cross_quality_registrar_inspecciones_maquina.idAnalisis ='.$X_Puntero;
$SIS_order = 'maquinas_listado.Nombre ASC';
$arrMaquinas = array();
$arrMaquinas = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_maquina', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMaquinas');

/***************************************************/
// Se trae un listado con todas las muestras
$SIS_query = '
cross_quality_registrar_inspecciones_muestras.idMuestras,
cross_quality_registrar_inspecciones_muestras.n_folio_pallet,
cross_quality_registrar_inspecciones_muestras.lote,
productores_listado.Nombre AS ClienteNombre';
$SIS_join  = 'LEFT JOIN `productores_listado`  ON productores_listado.idProductor   = cross_quality_registrar_inspecciones_muestras.idProductor';
$SIS_where = 'cross_quality_registrar_inspecciones_muestras.idAnalisis ='.$X_Puntero;
$SIS_order = 'productores_listado.Nombre ASC';
$arrMuestras = array();
$arrMuestras = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_muestras', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMuestras');

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
							<td colspan="2" rowspan="1" style="vertical-align: top;">'.$rowData['TipoAnalisis'].'</td>
							<td style="vertical-align: top;">Fecha Creacion: '.Fecha_estandar($rowData['fecha_auto']).'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:33%;">
								Datos Básicos<br/>
								<strong>Producto</strong><br/>
								'.$rowData['ProductoCategoria'].', '.$rowData['ProductoNombre'].'<br/>
								Ubicación: '.$rowData['UbicacionNombre'].'<br/>';
								if(isset($rowData['UbicacionNombre_lvl_1'])&&$rowData['UbicacionNombre_lvl_1']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_1'];}
								if(isset($rowData['UbicacionNombre_lvl_2'])&&$rowData['UbicacionNombre_lvl_2']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_2'];}
								if(isset($rowData['UbicacionNombre_lvl_3'])&&$rowData['UbicacionNombre_lvl_3']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_3'];}
								if(isset($rowData['UbicacionNombre_lvl_4'])&&$rowData['UbicacionNombre_lvl_4']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_4'];}
								if(isset($rowData['UbicacionNombre_lvl_5'])&&$rowData['UbicacionNombre_lvl_5']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_5'];}
							$html .= '</td>

							<td style="vertical-align: top;width:33%;">
								Fecha Creacion<br/>
								Fecha Ingreso: '.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
								Temporada: '.$rowData['Temporada'].'<br/>
							</td>
							<td style="vertical-align: top;width:33%;">
								Datos Creacion<br/>
								Sistema: '.$rowData['Sistema'].'<br/>
								Usuario: '.$rowData['Usuario'].'<br/>
							</td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th colspan="2" style="vertical-align: top; width:88%;"><strong>Detalle</strong></th>
							<th style="vertical-align: top; width:12%;"><strong>Valor Total</strong></th>
						</tr>
					</thead>
					<tbody>';

					if ($arrTrabajadores!=false && !empty($arrTrabajadores) && $arrTrabajadores!='') {
						$html .= '<tr class="active"><td colspan="6"><strong>Trabajadores Encargados</strong></td></tr>';
						foreach ($arrTrabajadores as $trab) {
							$html .= '
							<tr>
								<td style="vertical-align: top;">'.$trab['Rut'].'</td>
								<td style="vertical-align: top;">'.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'</td>
								<td style="vertical-align: top;">'.$trab['Cargo'].'</td>
							</tr>';
						}
					}
					if ($arrMaquinas!=false && !empty($arrMaquinas) && $arrMaquinas!='') {
						$html .= '<tr class="active"><td colspan="6"><strong>Maquinas a Utilizar</strong></td></tr>';
						foreach ($arrMaquinas as $maq) {
							$html .= '
							<tr>
								<td colspan="3" style="vertical-align: top;">'.$maq['Codigo'].' - '.$maq['Nombre'].'</td>
							</tr>';
						}
					}
					if ($arrMuestras!=false && !empty($arrMuestras) && $arrMuestras!='') {
						$html .= '
							<tr>
								<td colspan="3" style="vertical-align: top;"><strong>Muestras</strong></td>
							</tr>
							<tr>
								<td style="vertical-align: top;">Productor</td>
								<td style="vertical-align: top;">N° Folio / Pallet</td>
								<td style="vertical-align: top;">Lote</td>
							</tr>';
						foreach ($arrMuestras as $muestra) {
							$html .= '
							<tr>
								<td style="vertical-align: top;">'.$muestra['ClienteNombre'].'</td>
								<td style="vertical-align: top;">'.$muestra['n_folio_pallet'].'</td>
								<td style="vertical-align: top;">'.$muestra['lote'].'</td>
							</tr>';
						}
					}

				$html .= '
					</tbody>
				</table>

				<br/>
				<br/>

				<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
					<tbody><tr><td style="vertical-align: top;">Observaciones:</td></tr></tbody>
				</table>
				<table style="text-align: left; width: 100%;margin-top:20px;" cellpadding="5" cellspacing="0">
					<tbody>
						<tr>
							<td style="vertical-align: top;text-align: left;background-color: #f9f9f9;border: 1px solid #EEE;">'.$rowData['Observaciones'].'</td>
						</tr>
					</tbody>
				</table>';

			$html .= '</td>
		</tr>
	</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = $rowData['TipoAnalisis'];
$pdf_subtitulo  = '';
$pdf_file       = $rowData['TipoAnalisis'].'.pdf';
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
			if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
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

?>
