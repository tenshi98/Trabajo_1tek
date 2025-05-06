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
// Se trae la información del producto
$SIS_query = '
cross_shipping_consolidacion.Creacion_fecha,
cross_shipping_consolidacion.CTNNombreCompañia,
cross_shipping_consolidacion.FechaInicioEmbarque,
cross_shipping_consolidacion.HoraInicioCarga,
cross_shipping_consolidacion.FechaTerminoEmbarque,
cross_shipping_consolidacion.HoraTerminoCarga,
cross_shipping_consolidacion.CantidadCajas,
cross_shipping_consolidacion.ChoferNombreRut,
cross_shipping_consolidacion.PatenteCamion,
cross_shipping_consolidacion.PatenteCarro,
cross_shipping_consolidacion.TSetPoint,
cross_shipping_consolidacion.TVentilacion,
cross_shipping_consolidacion.TAmbiente,
cross_shipping_consolidacion.NumeroSello,
cross_shipping_consolidacion.idInspector,
cross_shipping_consolidacion.Observaciones,
cross_shipping_consolidacion.Observacion,
cross_shipping_consolidacion.Aprobacion_Fecha,
cross_shipping_consolidacion.Aprobacion_Hora,
cross_shipping_consolidacion.idEstado,
cross_shipping_consolidacion.NInforme,

core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS UsuarioCreador,
cross_shipping_plantas.Nombre AS PlantaNombre,
cross_shipping_plantas.Codigo AS PlantaCodigo,
sistema_variedades_categorias.Nombre AS Especie,
variedades_listado.Nombre AS Variedad,
cross_shipping_instructivo.Nombre AS InstructivoNombre,
cross_shipping_instructivo.Codigo AS InstructivoCodigo,
cross_shipping_naviera.Nombre AS NavieraNombre,
cross_shipping_naviera.Codigo AS NavieraCodigo,
cross_shipping_puerto_embarque.Nombre AS EmbarqueNombre,
cross_shipping_puerto_embarque.Codigo AS EmbarqueCodigo,
cross_shipping_puerto_destino.Nombre AS DestinoNombre,
cross_shipping_puerto_destino.Codigo AS DestinoCodigo,
cross_shipping_mercado.Nombre AS MercadoNombre,
cross_shipping_mercado.Codigo AS MercadoCodigo,
core_paises.Nombre AS PaisesNombre,
cross_shipping_empresa_transporte.Nombre AS TransporteNombre,
cross_shipping_empresa_transporte.Codigo AS TransporteCodigo,
core_cross_shipping_consolidacion_condicion.Nombre AS Condicion,
core_sistemas_opciones.Nombre AS Sellado,
core_oc_estado.Nombre AS Estado,
trabajadores_listado.Nombre AS InspectorNombre,
trabajadores_listado.ApellidoPat AS InspectorApellido,
cross_shipping_recibidores.Nombre AS RecibidorNombre,
cross_shipping_recibidores.Codigo AS RecibidorCodigo';
$SIS_join  = '
LEFT JOIN `core_sistemas`                                ON core_sistemas.idSistema                                   = cross_shipping_consolidacion.idSistema
LEFT JOIN `usuarios_listado`                             ON usuarios_listado.idUsuario                                = cross_shipping_consolidacion.idUsuario
LEFT JOIN `cross_shipping_plantas`                       ON cross_shipping_plantas.idPlantaDespacho                   = cross_shipping_consolidacion.idPlantaDespacho
LEFT JOIN `sistema_variedades_categorias`                ON sistema_variedades_categorias.idCategoria                 = cross_shipping_consolidacion.idCategoria
LEFT JOIN `variedades_listado`                           ON variedades_listado.idProducto                             = cross_shipping_consolidacion.idProducto
LEFT JOIN `cross_shipping_instructivo`                   ON cross_shipping_instructivo.idInstructivo                  = cross_shipping_consolidacion.idInstructivo
LEFT JOIN `cross_shipping_naviera`                       ON cross_shipping_naviera.idNaviera                          = cross_shipping_consolidacion.idNaviera
LEFT JOIN `cross_shipping_puerto_embarque`               ON cross_shipping_puerto_embarque.idPuertoEmbarque           = cross_shipping_consolidacion.idPuertoEmbarque
LEFT JOIN `cross_shipping_puerto_destino`                ON cross_shipping_puerto_destino.idPuertoDestino             = cross_shipping_consolidacion.idPuertoDestino
LEFT JOIN `cross_shipping_mercado`                       ON cross_shipping_mercado.idMercado                          = cross_shipping_consolidacion.idMercado
LEFT JOIN `core_paises`                                  ON core_paises.idPais                                        = cross_shipping_consolidacion.idPais
LEFT JOIN `cross_shipping_empresa_transporte`            ON cross_shipping_empresa_transporte.idEmpresaTransporte     = cross_shipping_consolidacion.idEmpresaTransporte
LEFT JOIN `core_cross_shipping_consolidacion_condicion`  ON core_cross_shipping_consolidacion_condicion.idCondicion   = cross_shipping_consolidacion.idCondicion
LEFT JOIN `core_sistemas_opciones`                       ON core_sistemas_opciones.idOpciones                         = cross_shipping_consolidacion.idSellado
LEFT JOIN `core_oc_estado`                               ON core_oc_estado.idEstado                                   = cross_shipping_consolidacion.idEstado
LEFT JOIN `trabajadores_listado`                         ON trabajadores_listado.idTrabajador                         = cross_shipping_consolidacion.idAprobador
LEFT JOIN `cross_shipping_recibidores`                   ON cross_shipping_recibidores.idRecibidor                    = cross_shipping_consolidacion.idRecibidor';
$SIS_where = 'cross_shipping_consolidacion.idConsolidacion ='.$X_Puntero;
$rowConso = db_select_data (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowConso');

/************************************************************/
// Se traen las estibas
$SIS_query = '
cross_shipping_consolidacion_estibas.idEstibaListado,
cross_shipping_consolidacion_estibas.NPallet,
cross_shipping_consolidacion_estibas.Temperatura,
cross_shipping_consolidacion_estibas.NSerieSensor,

core_estibas.Nombre AS Estiba,
core_estibas_ubicacion.Nombre AS EstibaUbicacion,
core_cross_shipping_consolidacion_posicion.Nombre AS Posicion,
cross_shipping_envase.Nombre AS Envase,
cross_shipping_termografo.Nombre AS Termografo';
$SIS_join  = '
LEFT JOIN `core_estibas`                                  ON core_estibas.idEstiba                                    = cross_shipping_consolidacion_estibas.idEstiba
LEFT JOIN `core_estibas_ubicacion`                        ON core_estibas_ubicacion.idEstibaUbicacion                 = cross_shipping_consolidacion_estibas.idEstibaUbicacion
LEFT JOIN `core_cross_shipping_consolidacion_posicion`    ON core_cross_shipping_consolidacion_posicion.idPosicion    = cross_shipping_consolidacion_estibas.idPosicion
LEFT JOIN `cross_shipping_envase`                         ON cross_shipping_envase.idEnvase                           = cross_shipping_consolidacion_estibas.idEnvase
LEFT JOIN `cross_shipping_termografo`                     ON cross_shipping_termografo.idTermografo                   = cross_shipping_consolidacion_estibas.idTermografo';
$SIS_where = 'cross_shipping_consolidacion_estibas.idConsolidacion ='.$X_Puntero;
$SIS_order = 'cross_shipping_consolidacion_estibas.idEstiba ASC, core_estibas_ubicacion.Nombre ASC';
$arrEstibas = array();
$arrEstibas = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_estibas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEstibas');

/************************************************************/
// Se traen los archivos
$SIS_query = '
cross_shipping_consolidacion_archivo.idArchivo,
cross_shipping_consolidacion_archivo.idArchivoTipo,
cross_shipping_consolidacion_archivo.Nombre,
core_cross_shipping_archivos_tipos.Nombre AS Tipo';
$SIS_join  = 'LEFT JOIN `core_cross_shipping_archivos_tipos` ON core_cross_shipping_archivos_tipos.idArchivoTipo = cross_shipping_consolidacion_archivo.idArchivoTipo';
$SIS_where = 'cross_shipping_consolidacion_archivo.idConsolidacion ='.$X_Puntero;
$SIS_order = 'cross_shipping_consolidacion_archivo.Nombre ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_archivo', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

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
				<table style="text-align: left; width: 100%;border: 1px solid #f4f4f4;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="4" rowspan="1" style="text-align: center;background-color:#DDD;padding:5px;"><br/><strong>Control Proceso Preembarque - T° y Estiba de Contenedores</strong><br/>';
							if(isset($rowConso['idEstado'])&&$rowConso['idEstado']!=2){$html .= ' ('.$rowConso['Estado'].')';}
							$html .= '
							</td>
						</tr>
						<tr class="oddrow">
							<td colspan="4" rowspan="1" style="vertical-align: top;background-color:#FFF"></td>
						</tr>
						<tr class="oddrow">
							<td colspan="4" rowspan="1" style="vertical-align: top;background-color:#DDD"><strong>DATOS MAESTROS</strong></td>
						</tr>
						<tr><td colspan="4" rowspan="1" style="vertical-align: top;background-color:#DDD"><strong>Cuerpo Identificacion</strong></td></tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Contenedor Nro.</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['CTNNombreCompañia'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Nro. Del Informe</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['NInforme'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Fecha del informe</td>
							<td style="vertical-align: top; width:30%;">'.fecha_estandar($rowConso['Creacion_fecha']).'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;"></td>
							<td style="vertical-align: top; width:30%;"></td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Fecha Inicio del Embarque</td>
							<td style="vertical-align: top; width:30%;">'.fecha_estandar($rowConso['FechaInicioEmbarque']).'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Hora Inicio Carga</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['HoraInicioCarga'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Fecha Termino del Embarque</td>
							<td style="vertical-align: top; width:30%;">'.fecha_estandar($rowConso['FechaTerminoEmbarque']).'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Hora Termino Carga</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['HoraTerminoCarga'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Planta Despachadora</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['PlantaCodigo'].' - '.$rowConso['PlantaNombre'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Especie/Variedad</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['Especie'].' '.$rowConso['Variedad'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Cantidad de Cajas</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['CantidadCajas'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">N° Instructivo</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['InstructivoCodigo'].' - '.$rowConso['InstructivoNombre'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Naviera</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['NavieraCodigo'].' - '.$rowConso['NavieraNombre'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Puerto Embarque</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['EmbarqueCodigo'].' - '.$rowConso['EmbarqueNombre'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Puerto Destino</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['DestinoCodigo'].' - '.$rowConso['DestinoNombre'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Mercado</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['MercadoCodigo'].' - '.$rowConso['MercadoNombre'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Pais</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['PaisesNombre'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Recibidor</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['RecibidorCodigo'].' - '.$rowConso['RecibidorNombre'].'</td>
						</tr>
						<tr><td colspan="4" rowspan="1" style="vertical-align: top;background-color:#DDD"><strong>Cuerpo Identificacion Empresa Transportista</strong></td></tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Empresa Transportista</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['TransporteCodigo'].' - '.$rowConso['TransporteNombre'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Conductor</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['ChoferNombreRut'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Patente Camion</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['PatenteCamion'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Patente Carro</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['PatenteCarro'].'</td>
						</tr>

						<tr><td colspan="4" rowspan="1" style="vertical-align: top;background-color:#DDD"><strong>Cuerpo Parametros Evaluados</strong></td></tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Condición CTN</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['Condicion'].'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Sellado Piso</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['Sellado'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">T°Set Point</td>
							<td style="vertical-align: top; width:30%;">'.Cantidades_decimales_justos($rowConso['TSetPoint']).'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">T° Ventilacion</td>
							<td style="vertical-align: top; width:30%;">'.Cantidades_decimales_justos($rowConso['TVentilacion']).'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">T° Ambiente</td>
							<td style="vertical-align: top; width:30%;">'.Cantidades_decimales_justos($rowConso['TAmbiente']).'</td>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Numero de sello</td>
							<td style="vertical-align: top; width:30%;">'.$rowConso['NumeroSello'].'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:20%;background-color:#DDD;">Inspector</td>
							<td style="vertical-align: top; width:30%;" colspan="3">'.$rowConso['InspectorNombre'].' '.$rowConso['InspectorApellido'].'</td>
						</tr>

					</tbody>
				</table>

				<br/>
				<br/>
				<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>';
							filtrar($arrEstibas, 'Estiba');
							foreach($arrEstibas as $categoria=>$estibas){
								$html .= '
								<td style="vertical-align: top; width:50%;">
									<table class="zebra tableline" style="text-align: left; width: 98%;border: 1px solid #f4f4f4;" cellpadding="0" cellspacing="0" >
										<thead>
											<tr style="background-color: #f9f9f9;">
												<th colspan="7" style="vertical-align: top; width:100%;"><strong>Estiba '.$categoria.'</strong></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="vertical-align: top;">Ubicación</td>
												<td style="vertical-align: top;">Posicion</td>
												<td style="vertical-align: top;">Envase</td>
												<td style="vertical-align: top;">Nro. De Pallet</td>
												<td style="vertical-align: top;">Temp. De Pulpa</td>
												<td style="vertical-align: top;">Marca Modelo Sensor</td>
												<td style="vertical-align: top;">Nro. Serie Sensor</td>
											</tr>';
										foreach ($estibas as $estiba){
											$html .= '
											<tr>
												<td style="vertical-align: top;">'.$estiba['EstibaUbicacion'].'</td>
												<td style="vertical-align: top;">'.$estiba['Posicion'].'</td>
												<td style="vertical-align: top;">'.$estiba['Envase'].'</td>
												<td style="vertical-align: top;">'.$estiba['NPallet'].'</td>
												<td style="vertical-align: top;">'.Cantidades_decimales_justos($estiba['Temperatura']).'</td>
												<td style="vertical-align: top;">'.$estiba['Termografo'].'</td>
												<td style="vertical-align: top;">'.$estiba['NSerieSensor'].'</td>
											</tr>';
										}
										$html .= '
									</tbody>
								</table>
							</td>';
							}
						$html .= '
						</tr>
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
							<td style="vertical-align: top;text-align: left;background-color: #f9f9f9;border: 1px solid #EEE;">'.$rowConso['Observaciones'].'</td>
						</tr>
					</tbody>
				</table>';

				$html .= '
				<br/>
				<br/>
				<table style="text-align: left; width: 100%; margin-top:20px;" cellpadding="0" cellspacing="0">
					<tbody>

						<tr style="background-color: #f1f1f1;">
							<td colspan="8">Archivos Adjuntos</td>
						</tr>';
						filtrar($arrArchivos, 'Tipo');
						foreach($arrArchivos as $categoria=>$archivos){
							$html .= '<tr><td colspan="8"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
							$html .= '<tr>';

							$xn_col = 1;
							foreach ($archivos as $arch) {
								$html .= '<td style="vertical-align: top; width:12%;"><img src="upload/'.$arch['Nombre'].'"></td>';
								$xn_col++;
								if($xn_col>8){
									$html .= '</tr><tr>';
									$xn_col=1;
								}
							}
							$html .= '</tr>';
						}
					$html .= '
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
$pdf_titulo     = 'Consolidacion Contenedor '.$rowConso['CTNNombreCompañia'];
$pdf_subtitulo  = 'Brown Norte Nro. 100,  Ofina Nro.704, Ñuñoa, Santiago, Chile. Fonos: +569 99099476, +562 9935665. www.agropraxis.cl; e-mail agropraxis@agropraxis.cl';
$pdf_file       = 'Consolidacion Contenedor '.$rowConso['CTNNombreCompañia'].'.pdf';
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
			$pdf->SetFont('helvetica', '', 8);
			//$pdf->AddPage($OpcTcpOrt, $OpcTcpPg);
			$pdf->AddPage('L');
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
