<?php
/************************************************************/
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
$SIS_where = 'cross_shipping_consolidacion.idConsolidacion = '.$_GET['view'];
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
$SIS_where = 'cross_shipping_consolidacion_estibas.idConsolidacion ='.$_GET['view'];
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
$SIS_where = 'cross_shipping_consolidacion_archivo.idConsolidacion ='.$_GET['view'];
$SIS_order = 0;
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_archivo', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

/************************************************************/
if(isset($rowConso['Observacion'])&&$rowConso['Observacion']!=''){
	if(isset($rowConso['idEstado'])&&$rowConso['idEstado']!=2){
		echo '<div class="col-xs-12" style="margin-top:15px;">';
			$Alert_Text  = '<strong>Fecha: </strong>'.fecha_estandar($rowConso['Aprobacion_Fecha']).'<br/>';
			$Alert_Text .= '<strong>Hora: </strong>'.$rowConso['Aprobacion_Hora'].'<br/>';
			$Alert_Text .= '<strong>Observacion: </strong>'.$rowConso['Observacion'];
			alert_post_data(4,1,1,  $Alert_Text);
		echo '</div>
		<div class="clearfix" style="margin-bottom:15px;"></div>';
	}
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Control Proceso Preembarque - T° y Estiba de Contenedores <?php if(isset($rowConso['idEstado'])&&$rowConso['idEstado']!=2){echo '('.$rowConso['Estado'].')';} ?></div>

		<div id="customer">

			<table id="meta" class="pull-left" style="width:100%" >
				<tbody>
					<tr>
						<td class="meta-head" colspan="3"><strong>DATOS MAESTROS</strong></td>
						<td class="meta-head"></td>
					</tr>

					<tr><td class="meta-head" colspan="4"><strong>Cuerpo Identificacion</strong></td></tr>
					<tr>
						<td class="meta-head">Contenedor Nro.</td>
						<td><?php if(isset($rowConso['CTNNombreCompañia'])&&$rowConso['CTNNombreCompañia']!=''){echo $rowConso['CTNNombreCompañia'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Nro. Del Informe</td>
						<td><?php if(isset($rowConso['NInforme'])&&$rowConso['NInforme']!=''){echo $rowConso['NInforme'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha del informe</td>
						<td><?php if(isset($rowConso['Creacion_fecha'])&&$rowConso['Creacion_fecha']!=''){echo fecha_estandar($rowConso['Creacion_fecha']);}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head"></td>
						<td></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Inicio del Embarque</td>
						<td><?php if(isset($rowConso['FechaInicioEmbarque'])&&$rowConso['FechaInicioEmbarque']!=''){echo fecha_estandar($rowConso['FechaInicioEmbarque']);}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Hora Inicio Carga</td>
						<td><?php if(isset($rowConso['HoraInicioCarga'])&&$rowConso['HoraInicioCarga']!=''){echo $rowConso['HoraInicioCarga'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Termino del Embarque</td>
						<td><?php if(isset($rowConso['FechaTerminoEmbarque'])&&$rowConso['FechaTerminoEmbarque']!=''){echo fecha_estandar($rowConso['FechaTerminoEmbarque']);}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Hora Termino Carga</td>
						<td><?php if(isset($rowConso['HoraTerminoCarga'])&&$rowConso['HoraTerminoCarga']!=''){echo $rowConso['HoraTerminoCarga'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Planta Despachadora</td>
						<td><?php if(isset($rowConso['PlantaNombre'])&&$rowConso['PlantaNombre']!=''){echo $rowConso['PlantaCodigo'].' - '.$rowConso['PlantaNombre'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Especie/Variedad</td>
						<td><?php if(isset($rowConso['Especie'])&&$rowConso['Especie']!=''){echo $rowConso['Especie'].' '.$rowConso['Variedad'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Cantidad de Cajas</td>
						<td><?php if(isset($rowConso['CantidadCajas'])&&$rowConso['CantidadCajas']!=''){echo $rowConso['CantidadCajas'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">N° Instructivo</td>
						<td><?php if(isset($rowConso['InstructivoNombre'])&&$rowConso['InstructivoNombre']!=''){echo $rowConso['InstructivoCodigo'].' - '.$rowConso['InstructivoNombre'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Naviera</td>
						<td><?php if(isset($rowConso['NavieraNombre'])&&$rowConso['NavieraNombre']!=''){echo $rowConso['NavieraCodigo'].' - '.$rowConso['NavieraNombre'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Puerto Embarque</td>
						<td><?php if(isset($rowConso['EmbarqueNombre'])&&$rowConso['EmbarqueNombre']!=''){echo $rowConso['EmbarqueCodigo'].' - '.$rowConso['EmbarqueNombre'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Puerto Destino</td>
						<td><?php if(isset($rowConso['DestinoNombre'])&&$rowConso['DestinoNombre']!=''){echo $rowConso['DestinoCodigo'].' - '.$rowConso['DestinoNombre'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Mercado</td>
						<td><?php if(isset($rowConso['MercadoNombre'])&&$rowConso['MercadoNombre']!=''){echo $rowConso['MercadoCodigo'].' - '.$rowConso['MercadoNombre'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Pais</td>
						<td><?php if(isset($rowConso['PaisesNombre'])&&$rowConso['PaisesNombre']!=''){echo $rowConso['PaisesNombre'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Recibidor</td>
						<td><?php if(isset($rowConso['RecibidorNombre'])&&$rowConso['RecibidorNombre']!=''){echo $rowConso['RecibidorCodigo'].' - '.$rowConso['RecibidorNombre'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					
						
					<tr><td class="meta-head" colspan="4"><strong>Cuerpo Identificacion Empresa Transportista</strong></td></tr>
					<tr>
						<td class="meta-head">Empresa Transportista</td>
						<td><?php if(isset($rowConso['TransporteNombre'])&&$rowConso['TransporteNombre']!=''){echo $rowConso['TransporteCodigo'].' - '.$rowConso['TransporteNombre'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Conductor</td>
						<td><?php if(isset($rowConso['ChoferNombreRut'])&&$rowConso['ChoferNombreRut']!=''){echo $rowConso['ChoferNombreRut'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Patente Camion</td>
						<td><?php if(isset($rowConso['PatenteCamion'])&&$rowConso['PatenteCamion']!=''){echo $rowConso['PatenteCamion'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Patente Carro</td>
						<td><?php if(isset($rowConso['PatenteCarro'])&&$rowConso['PatenteCarro']!=''){echo $rowConso['PatenteCarro'];}else{echo 'Sin Datos';} ?></td>
					</tr>

					<tr><td class="meta-head" colspan="4"><strong>Cuerpo Parametros Evaluados</strong></td></tr>
					<tr>
						<td class="meta-head">Condición CTN</td>
						<td><?php if(isset($rowConso['Condicion'])&&$rowConso['Condicion']!=''){echo $rowConso['Condicion'];}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Sellado Piso</td>
						<td><?php if(isset($rowConso['Sellado'])&&$rowConso['Sellado']!=''){echo $rowConso['Sellado'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">T°Set Point</td>
						<td><?php if(isset($rowConso['TSetPoint'])&&$rowConso['TSetPoint']!=''){echo Cantidades_decimales_justos($rowConso['TSetPoint']);}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">T° Ventilacion</td>
						<td><?php if(isset($rowConso['TSetPoint'])&&$rowConso['TSetPoint']!=''){echo Cantidades_decimales_justos($rowConso['TVentilacion']);}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">T° Ambiente</td>
						<td><?php if(isset($rowConso['TAmbiente'])&&$rowConso['TAmbiente']!=''){echo Cantidades_decimales_justos($rowConso['TAmbiente']);}else{echo 'Sin Datos';} ?></td>
						<td class="meta-head">Numero de sello</td>
						<td><?php if(isset($rowConso['NumeroSello'])&&$rowConso['NumeroSello']!=''){echo $rowConso['NumeroSello'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Inspector</td>
						<td colspan="3"><?php if(isset($rowConso['InspectorNombre'])&&$rowConso['InspectorNombre']!=''){echo $rowConso['InspectorNombre'].' '.$rowConso['InspectorApellido'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					

	
				</tbody>
			</table>

		</div>

		<div class="row">
			<?php
			filtrar($arrEstibas, 'Estiba');
			foreach($arrEstibas as $categoria=>$estibas){
				echo '
						
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="box box-normal box-solid">
						<div class="box-header with-border">
							<h3 class="box-title"><span style="color: #333;">Estiba '.$categoria.'</span></h3>
						</div>
						<div class="box-body">
							<div class="value">'; ?>
							
							
								<table id="items" style="margin: 0;">
									<tbody>

										<tr class="item-row fact_tittle">
											<td>Ubicación</td>
											<td>Posicion</td>
											<td>Envase</td>
											<td>Nro. De Pallet</td>
											<td>Temp. De Pulpa</td>
											<td>Marca Modelo Sensor</td>
											<td>Nro. Serie Sensor</td>
										</tr>
										
									
										<?php 
										//recorro el lsiatdo entregado por la base de datos
										foreach ($estibas as $estiba){ ?>
											<tr class="item-row linea_punteada">
												<td class="item-name"><?php echo $estiba['EstibaUbicacion']; ?></td>
												<td class="item-name"><?php echo $estiba['Posicion']; ?></td>
												<td class="item-name"><?php echo $estiba['Envase']; ?></td>
												<td class="item-name"><?php echo $estiba['NPallet']; ?></td>
												<td class="item-name"><?php echo Cantidades_decimales_justos($estiba['Temperatura']); ?></td>
												<td class="item-name"><?php echo $estiba['Termografo']; ?></td>
												<td class="item-name"><?php echo $estiba['NSerieSensor']; ?></td>
											</tr>
										<?php } ?>

										
										

										
									</tbody>
								</table>
							<?php echo '
							</div>
						</div>
					</div>
				</div>';
			} ?>
		</div>
						
						
		<table id="items">
			<tbody>

				<td colspan="8" class="blank word_break">
					<?php echo $rowConso['Observaciones']; ?>
				</td>

				</tr>
				<tr><td colspan="8" class="blank"><p>Observaciones</p></td></tr>

			</tbody>
		</table>
    </div>

	<table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td>Archivos Adjuntos</td>
            </tr>

			<?php
			filtrar($arrArchivos, 'Tipo');
			foreach($arrArchivos as $categoria=>$archivos){
				echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
				echo '<tr class="item-row"><td>';
				echo '<div class="row">';
				foreach ($archivos as $arch) { ?>
					
	
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<img src="upload/<?php echo $arch['Nombre']; ?>" class="img-responsive">
				</div>

			<?php
				}
				echo '</div>';
				echo '</td></tr>';
			} ?>

		</tbody>
    </table>

</div>
<div class="clearfix"></div>
