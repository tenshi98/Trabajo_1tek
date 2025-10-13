<?php
// consulto los datos
$SIS_query = '
ocompra_listado.Creacion_fecha,
ocompra_listado.Observaciones,
usuarios_listado.Nombre AS NombreUsuario,
sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,
proveedor_listado.Nombre AS NombreProveedor,
proveedor_listado.email AS EmailProveedor,
proveedor_listado.Rut AS RutProveedor,
provciudad.Nombre AS CiudadProveedor,
provcomuna.Nombre AS ComunaProveedor,
proveedor_listado.Direccion AS DireccionProveedor,
proveedor_listado.Fono1 AS Fono1Proveedor,
proveedor_listado.Fono2 AS Fono2Proveedor,
proveedor_listado.Fax AS FaxProveedor,
proveedor_listado.PersonaContacto AS PersonaContactoProveedor,
proveedor_listado.Giro AS GiroProveedor,
core_oc_estado.Nombre AS Estado,
ocompra_listado.idEstado,
ocompra_listado.idSistema';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario       = ocompra_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema         = ocompra_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad           = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna           = sistema_origen.idComuna
LEFT JOIN `proveedor_listado`                       ON proveedor_listado.idProveedor    = ocompra_listado.idProveedor
LEFT JOIN `core_ubicacion_ciudad`    provciudad     ON provciudad.idCiudad              = proveedor_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   provcomuna     ON provcomuna.idComuna              = proveedor_listado.idComuna
LEFT JOIN `core_oc_estado`                          ON core_oc_estado.idEstado          = ocompra_listado.idEstado';
$SIS_where = 'ocompra_listado.idOcompra ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
//Insumos
$SIS_query = '
insumos_listado.Nombre,
ocompra_listado_existencias_insumos.Cantidad,
ocompra_listado_existencias_insumos.vUnitario,
ocompra_listado_existencias_insumos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`          ON insumos_listado.idProducto    = ocompra_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`    ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'ocompra_listado_existencias_insumos.idOcompra ='.$X_Puntero;
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

/*****************************************/
//Productos
$SIS_query = '
productos_listado.Nombre,
ocompra_listado_existencias_productos.Cantidad,
ocompra_listado_existencias_productos.vUnitario,
ocompra_listado_existencias_productos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `productos_listado`          ON productos_listado.idProducto    = ocompra_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml`      ON sistema_productos_uml.idUml     = productos_listado.idUml';
$SIS_where = 'ocompra_listado_existencias_productos.idOcompra ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
//Arriendos
$SIS_query = '
equipos_arriendo_listado.Nombre,
ocompra_listado_existencias_arriendos.Cantidad,
ocompra_listado_existencias_arriendos.vUnitario,
ocompra_listado_existencias_arriendos.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `equipos_arriendo_listado`    ON equipos_arriendo_listado.idEquipo     = ocompra_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_tiempo_frecuencia`      ON core_tiempo_frecuencia.idFrecuencia   = ocompra_listado_existencias_arriendos.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_arriendos.idOcompra ='.$X_Puntero;
$SIS_order = 'equipos_arriendo_listado.Nombre ASC';
$arrArriendos = array();
$arrArriendos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_arriendos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArriendos');

/*****************************************/
//Servicios
$SIS_query = '
servicios_listado.Nombre,
ocompra_listado_existencias_servicios.Cantidad,
ocompra_listado_existencias_servicios.vUnitario,
ocompra_listado_existencias_servicios.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `servicios_listado`       ON servicios_listado.idServicio          = ocompra_listado_existencias_servicios.idServicio
LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia   = ocompra_listado_existencias_servicios.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_servicios.idOcompra ='.$X_Puntero;
$SIS_order = 'servicios_listado.Nombre ASC';
$arrServicios = array();
$arrServicios = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrServicios');

/*****************************************/
//Otros
$SIS_query = '
ocompra_listado_existencias_otros.Nombre,
ocompra_listado_existencias_otros.Cantidad,
ocompra_listado_existencias_otros.vUnitario,
ocompra_listado_existencias_otros.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = 'LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_otros.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_otros.idOcompra ='.$X_Puntero;
$SIS_order = 'ocompra_listado_existencias_otros.Nombre ASC';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOtros');

/*****************************************/
//Boletas Trabajadores
$SIS_query = '
ocompra_listado_existencias_boletas.N_Doc,
ocompra_listado_existencias_boletas.Descripcion,
ocompra_listado_existencias_boletas.Valor,
trabajadores_listado.Rut AS TrabRut,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat';
$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = ocompra_listado_existencias_boletas.idTrabajador';
$SIS_where = 'ocompra_listado_existencias_boletas.idOcompra ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrBoletas = array();
$arrBoletas = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_boletas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBoletas');

/*****************************************/
//Boletas Empresas
$SIS_query = 'idExistencia, Descripcion, Valor';
$SIS_join  = '';
$SIS_where = 'idOcompra ='.$X_Puntero;
$SIS_order = 'Descripcion ASC';
$arrBoletasEmp = array();
$arrBoletasEmp = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_boletas_empresas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBoletasEmp');

/*****************************************/
// Se trae un listado con todos los documentos acompañantes
$SIS_query = '
ocompra_listado_documentos.NDocPago,
ocompra_listado_documentos.Fpago,
ocompra_listado_documentos.vTotal,
sistema_documentos_pago.Nombre AS Documento';
$SIS_join  = 'LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago = ocompra_listado_documentos.idDocPago';
$SIS_where = 'ocompra_listado_documentos.idOcompra ='.$X_Puntero;
$SIS_order = 'ocompra_listado_documentos.Fpago ASC';
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, $SIS_query, 'ocompra_listado_documentos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDocumentos');

/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idOcompra ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'ocompra_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

/*****************************************/
// Se trae un con los materiales de las solicitudes
$SIS_query = '
ocompra_listado_sol_rel.Type,
solicitud_listado_existencias_productos.idSolicitud AS Prod_idSolicitud,
solicitud_listado_existencias_productos.Cantidad  AS Prod_Cantidad,
productos_sis.Nombre AS Prod_Sistema,
productos_listado.Nombre AS Prod_Nombre,
productos_med.Nombre AS Prod_Medida,
solicitud_listado_existencias_insumos.idSolicitud AS Ins_idSolicitud,
solicitud_listado_existencias_insumos.Cantidad  AS Ins_Cantidad,
insumos_sis.Nombre AS Ins_Sistema,
insumos_listado.Nombre AS Ins_Nombre,
insumos_med.Nombre AS Ins_Medida,
solicitud_listado_existencias_arriendos.idSolicitud AS Arri_idSolicitud,
solicitud_listado_existencias_arriendos.Cantidad  AS Arri_Cantidad,
arriendo_sis.Nombre AS Arri_Sistema,
equipos_arriendo_listado.Nombre AS Arri_Nombre,
arriendo_med.Nombre AS Arri_Medida,
solicitud_listado_existencias_servicios.idSolicitud AS Serv_idSolicitud,
solicitud_listado_existencias_servicios.Cantidad  AS Serv_Cantidad,
servicio_sis.Nombre AS Serv_Sistema,
servicios_listado.Nombre AS Serv_Nombre,
servicio_med.Nombre AS Serv_Medida';
$SIS_join  = '
LEFT JOIN `solicitud_listado_existencias_productos`    ON solicitud_listado_existencias_productos.idExistencia    = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `productos_listado`                          ON productos_listado.idProducto                            = solicitud_listado_existencias_productos.idProducto
LEFT JOIN `core_sistemas`             productos_sis    ON productos_sis.idSistema                                 = solicitud_listado_existencias_productos.idSistema
LEFT JOIN `sistema_productos_uml`     productos_med    ON productos_med.idUml                                     = productos_listado.idUml
LEFT JOIN `solicitud_listado_existencias_insumos`      ON solicitud_listado_existencias_insumos.idExistencia      = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `insumos_listado`                            ON insumos_listado.idProducto                              = solicitud_listado_existencias_insumos.idProducto
LEFT JOIN `core_sistemas`             insumos_sis      ON insumos_sis.idSistema                                   = solicitud_listado_existencias_insumos.idSistema
LEFT JOIN `sistema_productos_uml`     insumos_med      ON insumos_med.idUml                                       = insumos_listado.idUml
LEFT JOIN `solicitud_listado_existencias_arriendos`    ON solicitud_listado_existencias_arriendos.idExistencia    = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `equipos_arriendo_listado`                   ON equipos_arriendo_listado.idEquipo                       = solicitud_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_sistemas`             arriendo_sis     ON arriendo_sis.idSistema                                  = solicitud_listado_existencias_arriendos.idSistema
LEFT JOIN `core_tiempo_frecuencia`    arriendo_med     ON arriendo_med.idFrecuencia                               = solicitud_listado_existencias_arriendos.idFrecuencia
LEFT JOIN `solicitud_listado_existencias_servicios`    ON solicitud_listado_existencias_servicios.idExistencia    = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `servicios_listado`                          ON servicios_listado.idServicio                            = solicitud_listado_existencias_servicios.idServicio
LEFT JOIN `core_sistemas`             servicio_sis     ON servicio_sis.idSistema                                  = solicitud_listado_existencias_servicios.idSistema
LEFT JOIN `core_tiempo_frecuencia`    servicio_med     ON servicio_med.idFrecuencia                               = solicitud_listado_existencias_servicios.idFrecuencia';
$SIS_where = 'ocompra_listado_sol_rel.idOcompra ='.$X_Puntero;
$SIS_order = 'ocompra_listado_sol_rel.Type ASC';
$arrSolMat = array();
$arrSolMat = db_select_array (false, $SIS_query, 'ocompra_listado_sol_rel', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSolMat');

/*****************************************/
// Se trae un listado con el historial
$SIS_query = '
ocompra_listado_historial.Creacion_fecha, 
ocompra_listado_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = ocompra_listado_historial.idTipo
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = ocompra_listado_historial.idUsuario';
$SIS_where = 'ocompra_listado_historial.idOcompra ='.$X_Puntero;
$SIS_order = 'ocompra_listado_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'ocompra_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/*********************************/
//variables
$alert_borde = '';
$alert_icon  = '';
$alert_obs   = '';
foreach ($arrHistorial as $doc){
	$alert_borde = $doc['Nombre'];
	$alert_icon  = $doc['FonAwesome'];
	$alert_obs   = $doc['Observacion'];
}

?>
<?php if(isset($alert_obs)&&$alert_obs!=''){ ?>
	<div class="col-xs-12" style="margin-top:15px;">
		<?php
			switch ($alert_borde) {
				case 'success':
					$tipo = 1;
					break;
				case 'info':
					$tipo = 2;
					break;
				case 'warning':
					$tipo = 3;
					break;
				case 'danger':
					$tipo = 4;
					break;
			}
			$Alert_Text  = '<div class="icon"><i class="'.$alert_icon.'"></i></div>';
			$Alert_Text .= '<strong>Observacion: </strong>'.$alert_obs;
			alert_post_data($tipo,0,0,0,  $Alert_Text);
		?>
	</div>
	<div class="clearfix" style="margin-bottom:15px;"></div>
<?php } ?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Orden de Compra <?php echo n_doc($X_Puntero , 5); ?>.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php 
		echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Empresa Solicitante
					<address>
						<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
						'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						'.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Empresa Receptora
					<address>
						<strong>'.$rowData['NombreProveedor'].'</strong><br/>
						'.$rowData['CiudadProveedor'].', '.$rowData['ComunaProveedor'].'<br/>
						'.$rowData['DireccionProveedor'].'<br/>
						Fono Fijo: '.formatPhone($rowData['Fono1Proveedor']).'<br/>
						Celular: '.formatPhone($rowData['Fono2Proveedor']).'<br/>
						Fax: '.$rowData['FaxProveedor'].'<br/>
						Rut: '.$rowData['RutProveedor'].'<br/>
						Email: '.$rowData['EmailProveedor'].'<br/>
						Contacto: '.$rowData['PersonaContactoProveedor'].'<br/>
						Giro de la Empresa: '.$rowData['GiroProveedor'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<b>Estado: </b>'.$rowData['Estado'].'<br/>
				</div>';
		?>

	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive"  style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Detalle</th>
						<th align="right" width="160">Cantidad</th>
						<th align="right" width="160">Valor Unitario</th>
						<th align="right" width="160">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrInsumos!=false && !empty($arrInsumos) && $arrInsumos!='') { ?>
						<tr class="active"><td colspan="4"><strong>Insumos</strong></td></tr>
						<?php foreach ($arrInsumos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') { ?>
						<tr class="active"><td colspan="4"><strong>Productos</strong></td></tr>
						<?php foreach ($arrProductos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrArriendos!=false && !empty($arrArriendos) && $arrArriendos!='') { ?>
						<tr class="active"><td colspan="4"><strong>Arriendos</strong></td></tr>
						<?php foreach ($arrArriendos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrServicios!=false && !empty($arrServicios) && $arrServicios!='') { ?>
						<tr class="active"><td colspan="4"><strong>Servicios</strong></td></tr>
						<?php foreach ($arrServicios as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrOtros!=false && !empty($arrOtros) && $arrOtros!='') { ?>
						<tr class="active"><td colspan="4"><strong>Otros</strong></td></tr>
						<?php foreach ($arrOtros as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrBoletas!=false && !empty($arrBoletas) && $arrBoletas!='') { ?>
						<tr class="active"><td colspan="4"><strong>Boletas de Honorarios Trabajadores</strong></td></tr>
						<?php foreach ($arrBoletas as $prod) { ?>
							<tr>
								<td><?php echo $prod['TrabRut'].' - '.$prod['TrabNombre'].' '.$prod['TrabApellidoPat']; ?></td>
								<td><?php echo $prod['Descripcion']; ?></td>
								<td><?php echo 'Boleta N° '.n_doc($prod['N_Doc'], 8); ?></td>
								<td align="right"><?php echo valores($prod['Valor'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrBoletasEmp!=false && !empty($arrBoletasEmp) && $arrBoletasEmp!='') { ?>
						<tr class="active"><td colspan="4"><strong>Boletas de Honorarios Empresas</strong></td></tr>
						<?php foreach ($arrBoletasEmp as $prod) { ?>
							<tr>
								<td colspan="3"><?php echo $prod['Descripcion']; ?></td>
								<td align="right"><?php echo valores($prod['Valor'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					

				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
		</div>
	</div>
	
	
      
</section>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">

	<table id="items">
        <tbody>
			<tr><th colspan="3">Historial</th></tr>
			<tr>
				<th width="160">Fecha</th>
				<th>Usuario</th>
				<th>Observacion</th>
			</tr>			  
			<?php
			if (isset($arrHistorial)){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
					</tr>
				 <?php 	
				}
			} ?>
		</tbody>
    </table>

	<?php if ($arrSolMat!=false && !empty($arrSolMat) && $arrSolMat!='') { ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="4">Solicitudes Relacionadas</th>
				</tr>
				<tr>
					<th>Sistema</th>
					<th>N° Solicitud</th>
					<th>Producto</th>
					<th>Cantidad</th>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrSolMat as $producto){
					switch ($producto['Type']) {
						/****************************************/
						//Productos
						case 1:
						?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Prod_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Prod_idSolicitud'], 5); ?></td>
								<td class="item-name"><?php echo $producto['Prod_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Prod_Cantidad']).' '.$producto['Prod_Medida']; ?></td>
							</tr>
						<?php
							break;
						/****************************************/
						//Insumos
						case 2:
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Ins_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Ins_idSolicitud'], 5); ?></td>
								<td class="item-name"><?php echo $producto['Ins_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Ins_Cantidad']).' '.$producto['Ins_Medida']; ?></td>
							</tr>
						<?php
							break;
						/****************************************/
						//Arriendos
						case 3:
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Arri_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Arri_idSolicitud'], 5); ?></td>
								<td class="item-name"><?php echo $producto['Arri_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Arri_Cantidad']).' '.$producto['Arri_Medida']; ?></td>
							</tr>
						<?php
							break;
						/****************************************/
						//Servicios
						case 4:
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Serv_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Serv_idSolicitud'], 5); ?></td>
								<td class="item-name"><?php echo $producto['Serv_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Serv_Cantidad']).' '.$producto['Serv_Medida']; ?></td>
							</tr>
						<?php
							break;
					}
				} ?>
			</tbody>
		</table>
    <?php } ?>
  

	<table id="items">
        <tbody>
			<tr><th>Documentos Acompañantes</th></tr>		  
			<?php
			if (isset($arrDocumentos)){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrDocumentos as $doc){ ?>
					<tr class="item-row">
						<td><?php echo $doc['Documento'].' N°'.$doc['NDocPago'].' por '.valores($doc['vTotal'], 0).' (Pago para el '.fecha_estandar($doc['Fpago']).')'; ?></td>
					</tr>

				 <?php 	
				}
			} ?>
		</tbody>
    </table>
    <table id="items">
        <tbody>
			<tr><th colspan="6">Archivos Adjuntos</th></tr>		  
			<?php
			if (isset($arrArchivo)){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrArchivo as $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="1download.php?dir=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip" ><i class="fa fa-download" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>

				 <?php 	
				}
			} ?>
		</tbody>
    </table>
</div>

