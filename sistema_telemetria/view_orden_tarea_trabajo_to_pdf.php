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
// Se trae un listado con todos los elementos
$SIS_query = '
orden_trabajo_listado.idOT,
orden_trabajo_listado.f_creacion,
orden_trabajo_listado.f_programacion,
orden_trabajo_listado.f_termino,
orden_trabajo_listado.horaProg,
orden_trabajo_listado.horaInicio,
orden_trabajo_listado.horaTermino,
orden_trabajo_listado.Observaciones,
orden_trabajo_listado.idEstado,
maquinas_listado.Nombre AS NombreMaquina,
core_estado_ot.Nombre AS NombreEstado,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_tipos.Nombre AS NombreTipo,
orden_trabajo_listado.idSupervisor,
trabajadores_listado.Nombre AS NombreTrab,
trabajadores_listado.ApellidoPat,
clientes_listado.Nombre AS ClienteNombre,
clientes_listado.RazonSocial AS ClienteRazonSocial';
$SIS_join  = '
LEFT JOIN `maquinas_listado`      ON maquinas_listado.idMaquina         = orden_trabajo_listado.idMaquina
LEFT JOIN `core_estado_ot`        ON core_estado_ot.idEstado            = orden_trabajo_listado.idEstado
LEFT JOIN `core_ot_prioridad`     ON core_ot_prioridad.idPrioridad      = orden_trabajo_listado.idPrioridad
LEFT JOIN `core_ot_tipos`         ON core_ot_tipos.idTipo               = orden_trabajo_listado.idTipo
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador  = orden_trabajo_listado.idSupervisor
LEFT JOIN `clientes_listado`      ON clientes_listado.idCliente         = maquinas_listado.idCliente';
$SIS_where = 'orden_trabajo_listado.idOT ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Cargo,
trabajadores_listado.Rut';
$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = orden_trabajo_listado_responsable.idTrabajador';
$SIS_where = 'orden_trabajo_listado_responsable.idOT ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrTrabajadores = array();
$arrTrabajadores = db_select_array (false, $SIS_query, 'orden_trabajo_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajadores');

//Si la OT solo esta programada
if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){

	/***************************************************/
	// Se trae un listado con todos los insumos utilizados
	$SIS_query = '
	insumos_listado.Nombre AS NombreProducto,
	sistema_productos_uml.Nombre AS UnidadMedida,
	orden_trabajo_listado_insumos.Cantidad';
	$SIS_join  = '
	LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto    = orden_trabajo_listado_insumos.idProducto
	LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = insumos_listado.idUml';
	$SIS_where = 'orden_trabajo_listado_insumos.idOT ='.$X_Puntero;
	$SIS_order = 'insumos_listado.Nombre ASC';
	$arrInsumos = array();
	$arrInsumos = db_select_array (false, $SIS_query, 'orden_trabajo_listado_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

	/***************************************************/
	// Se trae un listado con todos los productos utilizados
	$SIS_query = '
	productos_listado.Nombre AS NombreProducto,
	sistema_productos_uml.Nombre AS UnidadMedida,
	orden_trabajo_listado_productos.Cantidad AS Cantidad';
	$SIS_join  = '
	LEFT JOIN `productos_listado`       ON productos_listado.idProducto    = orden_trabajo_listado_productos.idProducto
	LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml     = productos_listado.idUml';
	$SIS_where = 'orden_trabajo_listado_productos.idOT ='.$X_Puntero;
	$SIS_order = 'productos_listado.Nombre ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'orden_trabajo_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

//Si ya esta ejecutada
}else{

	/***************************************************/
	// Se trae un listado con todos los productos utilizados
	$SIS_query = '
	insumos_listado.Nombre AS NombreProducto,
	sistema_productos_uml.Nombre AS UnidadMedida,
	bodegas_insumos_facturacion_existencias.Cantidad_eg AS Cantidad,
	bodegas_insumos_listado.Nombre AS NombreBodega';
	$SIS_join  = '
	LEFT JOIN `insumos_listado`            ON insumos_listado.idProducto           = bodegas_insumos_facturacion_existencias.idProducto
	LEFT JOIN `sistema_productos_uml`      ON sistema_productos_uml.idUml          = insumos_listado.idUml
	LEFT JOIN `bodegas_insumos_listado`    ON bodegas_insumos_listado.idBodega     = bodegas_insumos_facturacion_existencias.idBodega';
	$SIS_where = 'bodegas_insumos_facturacion_existencias.idOT ='.$X_Puntero;
	$SIS_order = 'insumos_listado.Nombre ASC';
	$arrInsumos = array();
	$arrInsumos = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

	/***************************************************/
	// Se trae un listado con todos los productos utilizados
	$SIS_query = '
	productos_listado.Nombre AS NombreProducto,
	sistema_productos_uml.Nombre AS UnidadMedida,
	bodegas_productos_facturacion_existencias.Cantidad_eg AS Cantidad,
	bodegas_productos_listado.Nombre AS NombreBodega';
	$SIS_join  = '
	LEFT JOIN `productos_listado`            ON productos_listado.idProducto           = bodegas_productos_facturacion_existencias.idProducto
	LEFT JOIN `sistema_productos_uml`        ON sistema_productos_uml.idUml            = productos_listado.idUml
	LEFT JOIN `bodegas_productos_listado`    ON bodegas_productos_listado.idBodega     = bodegas_productos_facturacion_existencias.idBodega';
	$SIS_where = 'bodegas_productos_facturacion_existencias.idOT ='.$X_Puntero;
	$SIS_order = 'productos_listado.Nombre ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');
}

/***************************************************/
// Se trae un listado con todos los trabajos relacionados a la orden
$SIS_query = '
orden_trabajo_listado_trabajos.NombreComponente,
orden_trabajo_listado_trabajos.NombreTrabajo,
orden_trabajo_listado_trabajos.idSubTipo,
orden_trabajo_listado_trabajos.Grasa_inicial,
orden_trabajo_listado_trabajos.Grasa_relubricacion,
orden_trabajo_listado_trabajos.Aceite,
orden_trabajo_listado_trabajos.Cantidad,
orden_trabajo_listado_trabajos.idTrabajo,
orden_trabajo_listado_trabajos.Observacion,
orden_trabajo_listado_trabajos.idAnalisis,
productos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS NombreUnidad';
$SIS_join  = '
LEFT JOIN `productos_listado`      ON productos_listado.idProducto  = orden_trabajo_listado_trabajos.idProducto
LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml   = orden_trabajo_listado_trabajos.idUml';
$SIS_where = 'orden_trabajo_listado_trabajos.idOT ='.$X_Puntero;
$SIS_order = 'orden_trabajo_listado_trabajos.NombreComponente ASC, orden_trabajo_listado_trabajos.NombreTrabajo ASC';
$arrTrabajo = array();
$arrTrabajo = db_select_array (false, $SIS_query, 'orden_trabajo_listado_trabajos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajo');

/********************************************************************/
//Se define el contenido del PDF
$html ='<style>
#address {height: auto !important;}
.otdata td {text-align: left !important;}
.otdata{width: 65% !important;}
.otdata2{width: 30% !important;}
</style>
<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive">

<div id="page-wrap">
    <div id="header"> ORDEN DE TRABAJO N° '.n_doc($X_Puntero, 8).'</div>

    <div id="customer">
        <table id="meta" class="pull-left otdata">
            <tbody>
				<tr>
                    <td class="meta-head"><strong>DATOS BASICOS</strong></td>
                    <td class="meta-head"></td>
                </tr>';
				if(isset($rowData['ClienteNombre'])&&$rowData['ClienteNombre']!=''){
					$html .='<tr>
						<td class="meta-head">Cliente</td>
						<td>'.$rowData['ClienteNombre'].'</td>
					</tr>';
				}
				$html .='
				<tr>
                    <td class="meta-head">Maquina</td>
                    <td>'.$rowData['NombreMaquina'].'</td>
                </tr>
				<tr>
                    <td class="meta-head">Prioridad</td>
                    <td>'.$rowData['NombrePrioridad'].'</td>
                </tr>
				<tr>
                    <td class="meta-head">Tipo de Trabajo</td>
                    <td>'.$rowData['NombreTipo'].'</td>
                </tr>
				<tr>
                    <td class="meta-head">Estado</td>
                    <td>'.$rowData['NombreEstado'].'</td>
                </tr>';

				if(isset($rowData['idSupervisor'])&&$rowData['idSupervisor']!=''&&$rowData['idSupervisor']!=0){
					$html .='<tr>
						<td class="meta-head">Supervisor</td>
						<td>'.$rowData['NombreTrab'].' '.$rowData['ApellidoPat'].'</td>
					</tr>';
				}
            $html .='</tbody>
        </table>
        <table id="meta" class="otdata2">
            <tbody>';
				if($rowData['f_creacion']!='0000-00-00'){
					$html .='<tr>
						<td class="meta-head">Fecha creación</td>
						<td>'.Fecha_estandar($rowData['f_creacion']).'</td>
					</tr>';
				}

				if($rowData['f_programacion']!='0000-00-00'){
					$html .='<tr>
						<td class="meta-head">Fecha programada</td>
						<td>'.Fecha_estandar($rowData['f_programacion']).'</td>
					</tr>';
				}

				if($rowData['f_termino']!='0000-00-00'){
					$html .='<tr>
						<td class="meta-head">Fecha termino</td>
						<td>'.Fecha_estandar($rowData['f_termino']).'</td>
					</tr>';
				}

				if($rowData['horaInicio']!='00:00:00'){
					$html .='<tr>
						<td class="meta-head">Hora inicio</td>
						<td>'.$rowData['horaInicio'].'</td>
					</tr>';
				}

				if($rowData['horaTermino']!='00:00:00'){
					$html .='<tr>
						<td class="meta-head">Hora termino</td>
						<td>'.$rowData['horaTermino'].'</td>
					</tr>';
				}

				if($rowData['horaProg']!='00:00:00'){
					$html .='<tr>
						<td class="meta-head">Tiempo Programado</td>
						<td>'.$rowData['horaProg'].'</td>
					</tr>';
				}
            $html .='</tbody>
        </table>
    </div>
    <table id="items">
        <tbody>

			<tr><th colspan="6">Detalle</th></tr>';

			/**********************************************************************************/
            $html .='<tr class="item-row fact_tittle"><td colspan="6">Trabajadores</td></tr>';
			foreach ($arrTrabajadores as $trab) {
				$html .='<tr class="item-row linea_punteada">
					<td class="item-name">'.$trab['Rut'].'</td>
					<td class="item-name" colspan="4">'.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'</td>
					<td class="item-name">'.$trab['Cargo'].'</td>
				</tr>';
			}
			$html .='<tr id="hiderow"><td colspan="6"></td></tr>';
            /**********************************************************************************/
            if($arrInsumos!=false && !empty($arrInsumos) && $arrInsumos!='') {
				$html .='<tr class="item-row fact_tittle"><td colspan="6">';
				if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){$html .='Insumos Programados';}else{$html .='Insumos Utilizados';}
				$html .='</td></tr>';
				foreach ($arrInsumos as $insumos) {
					if(isset($insumos['Cantidad'])&&$insumos['Cantidad']!=0){
						$html .='<tr class="item-row linea_punteada">
							<td class="item-name" colspan="5">'.$insumos['NombreProducto'];
							if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){$html .=' - '.$insumos['NombreBodega'];}
							$html .='</td>
							<td class="item-name">'.Cantidades_decimales_justos($insumos['Cantidad']).' '.$insumos['UnidadMedida'].'</td>
						</tr>';
					}
				}
				$html .='<tr id="hiderow"><td colspan="6"></td></tr>';
			}
            /**********************************************************************************/
            if($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') {
				$html .='<tr class="item-row fact_tittle"><td colspan="6">';
				if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){$html .='Productos Programados';}else{$html .='Productos Utilizados';}
				$html .='</td></tr>';
				foreach ($arrProductos as $prod) {
					if(isset($prod['Cantidad'])&&$prod['Cantidad']!=0){
						$html .='<tr class="item-row linea_punteada">
							<td class="item-name" colspan="5">'.$prod['NombreProducto'];
							if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){$html .=' - '.$prod['NombreBodega'];}
							$html .='</td>
							<td class="item-name">'.Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['UnidadMedida'].'</td>
						</tr>';
					}
				}
				$html .='<tr id="hiderow"><td colspan="6"></td></tr>';
			}
			/**********************************************************************************/
			if($arrTrabajo!=false && !empty($arrTrabajo) && $arrTrabajo!='') {
				$html .='<tr class="item-row fact_tittle"><td colspan="6">';
				if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){$html .='Trabajos Programados';}else{$html .='Trabajos Ejecutados';}
				$html .='</td></tr>';
				foreach ($arrTrabajo as $trab) {
					$html .='<tr class="item-row linea_punteada">
						<td class="item-name" colspan="2">'.$trab['NombreComponente'].'</td>
						<td class="item-name" colspan="2">'.$trab['NombreTrabajo'].'</td>
						<td class="item-name" colspan="2">';

						//Se verifica el tipo de trabajo a realizar
						switch ($trab['idTrabajo']) {
							case 1: //Analisis
								$html .='<strong>Analisis N°: </strong>'.n_doc($trab['idAnalisis'], 6);
								break;
							case 2: //Consumo de Productos
								//El tipo de maquina que es
								switch ($trab['idSubTipo']) {
									case 1: //Grasa
										if(isset($trab['Grasa_inicial'])&&$trab['Grasa_inicial']!=0){         $html .= Cantidades_decimales_justos($trab['Grasa_inicial']);}
										if(isset($trab['Grasa_relubricacion'])&&$trab['Grasa_relubricacion']!=0){$html .= Cantidades_decimales_justos($trab['Grasa_relubricacion']);}
										break;
									case 2: //Aceite
										$html .= Cantidades_decimales_justos($trab['Aceite']);
										break;
									case 3: //Normal
										$html .= Cantidades_decimales_justos($trab['Cantidad']);
										break;
									case 4: //Otro
										break;
								}
								$html .=' '.$trab['NombreUnidad'].' de '.$trab['NombreProducto'];
								break;
							case 3: //Observacion
								$html .='<strong>Obs: </strong>'.$trab['Observacion'];
								break;
						}
						$html .='
						</td>
					</tr>';
				}
				$html .='<tr id="hiderow"><td colspan="6"></td></tr>';
			}
			/**********************************************************************************/
            $html .='
            <tr><td colspan="6" class="blank"><p>'.$rowData['Observaciones'].'</p></td></tr>
            <tr><td colspan="6" class="blank"><p>Observacion</p></td></tr>
        </tbody>
    </table>
    <div class="clearfix"></div>
    </div>

</div>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'ORDEN DE TRABAJO N° '.$X_Puntero;
$pdf_subtitulo  = '';
$pdf_file       = 'ORDEN DE TRABAJO N° '.$X_Puntero.'.pdf';
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
