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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
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
// consulto los datos
$SIS_query = '
clientes_listado.email, 
clientes_listado.Nombre,
clientes_listado.Rut, 
clientes_listado.RazonSocial, 
clientes_listado.fNacimiento, 
clientes_listado.Direccion, 
clientes_listado.Fono1, 
clientes_listado.Fono2, 
clientes_listado.Fax,
clientes_listado.PersonaContacto,
clientes_listado.PersonaContacto_Fono,
clientes_listado.PersonaContacto_email,
clientes_listado.PersonaContacto_Cargo,
clientes_listado.Web,
clientes_listado.Giro,
clientes_listado.idTipo,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
clientes_tipos.Nombre AS tipoCliente,
core_rubros.Nombre AS Rubro, 
clientes_listado.Contrato_Nombre,
clientes_listado.Contrato_Numero, 
core_cross_cliente.Nombre AS Contrato_Periodo,
clientes_listado.Contrato_Fecha_Ini, 
clientes_listado.Contrato_Fecha_Term, 
clientes_listado.Contrato_N_Meses,
clientes_listado.Contrato_Representante_Legal,
clientes_listado.Contrato_Representante_Rut,
clientes_listado.Contrato_Representante_Fono,
clientes_listado.Contrato_Valor_Mensual, 
clientes_listado.Contrato_Valor_Anual,
clientes_listado.Contrato_UF_Instalacion ,
clientes_listado.Contrato_UF_Mensual,
clientes_listado.Contrato_Obs,
clientes_listado.idTab_1,
clientes_listado.idTab_2,
clientes_listado.idTab_3,
clientes_listado.idTab_4,
clientes_listado.idTab_5,
clientes_listado.idTab_6,
clientes_listado.idTab_7,
clientes_listado.idTab_8';
$SIS_join  = '
LEFT JOIN `core_estados`            ON core_estados.idEstado            = clientes_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad   = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna  = clientes_listado.idComuna
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema          = clientes_listado.idSistema
LEFT JOIN `clientes_tipos`          ON clientes_tipos.idTipo            = clientes_listado.idTipo
LEFT JOIN `core_rubros`             ON core_rubros.idRubro              = clientes_listado.idRubro
LEFT JOIN `core_cross_cliente`      ON core_cross_cliente.idPeriodo     = clientes_listado.Contrato_idPeriodo';
$SIS_where = 'clientes_listado.idCliente ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*******************************************/
//Listado con los tabs
$arrTabs = array();
$arrTabs = db_select_array (false, 'idTab, Nombre', 'core_telemetria_tabs', '', '', 'idTab ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTabs');

//recorro
$arrTabsSorter = array();
foreach ($arrTabs as $tab) {
	$arrTabsSorter[$tab['idTab']] = $tab['Nombre'];
}

/**********************************************************/
// consulto los datos
$SIS_query = '
usuarios_listado.Nombre AS nombre_usuario,
clientes_observaciones.Fecha,
clientes_observaciones.Observacion';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = clientes_observaciones.idUsuario';
$SIS_where = 'clientes_observaciones.idCliente ='.$X_Puntero;
$SIS_order = 'clientes_observaciones.idObservacion ASC LIMIT 15';
$arrObservaciones = array();
$arrObservaciones = db_select_array (false, $SIS_query, 'clientes_observaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrObservaciones');

/**********************************************************/
//verifico que sea un administrador
$SIS_query = '
bodegas_productos_facturacion.idFacturacion,
core_documentos_mercantiles.Nombre AS Documento,
bodegas_productos_facturacion.N_Doc,
bodegas_productos_facturacion.Creacion_fecha';
$SIS_join  = 'LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = bodegas_productos_facturacion.idDocumentos';
$SIS_where = 'bodegas_productos_facturacion.idSistema ='.$_SESSION['usuario']['basic_data']['idSistema'].' AND bodegas_productos_facturacion.idCliente ='.$X_Puntero;
$SIS_order = 'bodegas_productos_facturacion.idFacturacion DESC LIMIT 15';
$arrVentas = array();
$arrVentas = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrVentas');

/**********************************************************/
//Variable de busqueda
$SIS_where = "cotizacion_listado.idCliente = ".$X_Puntero;
$SIS_where.= " AND cotizacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//verifico que sea un administrador
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_where.="  AND cotizacion_listado.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//consulta
$SIS_query = '
cotizacion_listado.idCotizacion,
cotizacion_listado.Creacion_fecha,
clientes_listado.Nombre AS Cliente';
$SIS_join  = 'LEFT JOIN `clientes_listado` ON clientes_listado.idCliente = cotizacion_listado.idCliente ';
$SIS_order = 'cotizacion_listado.idCotizacion DESC, cotizacion_listado.Creacion_fecha DESC';
$arrCotizaciones = array();
$arrCotizaciones = db_select_array (false, $SIS_query, 'cotizacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCotizaciones');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Cliente</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<?php if($arrObservaciones!=false && !empty($arrObservaciones) && $arrObservaciones!=''){ ?>
					<li class=""><a href="#observaciones" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
				<?php } ?>
				<?php if($arrVentas!=false && !empty($arrVentas) && $arrVentas!=''){ ?>
					<li class=""><a href="#ventas" data-toggle="tab"><i class="fa fa-usd" aria-hidden="true"></i> Ventas realizadas</a></li>
				<?php } ?>
				<?php if($arrCotizaciones!=false && !empty($arrCotizaciones) && $arrCotizaciones!=''){ ?>
					<li class=""><a href="#cotizaciones" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i> Cotizaciones realizadas</a></li>
				<?php } ?>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Cliente : </strong><?php echo $rowData['tipoCliente']; ?><br/>
								<?php
								//Si el cliente es una empresa
								if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
									<strong>Nombre Fantasia: </strong><?php echo $rowData['Nombre']; ?><br/>
								<?php
								//si es una persona
								}else{ ?>
									<strong>Nombre: </strong><?php echo $rowData['Nombre']; ?><br/>
									<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
								<?php } ?>
								<strong>Fecha de Ingreso Sistema : </strong><?php echo Fecha_completa($rowData['fNacimiento']); ?><br/>
								<strong>Región : </strong><?php echo $rowData['nombre_region']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowData['nombre_comuna']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
								<strong>Sistema Relacionado : </strong><?php echo $rowData['sistema']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['estado']; ?>
							</p>

							<?php
							//Si el cliente es una empresa
							if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Comerciales</h2>
								<p class="text-muted word_break">
									<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
									<strong>Razón Social : </strong><?php echo $rowData['RazonSocial']; ?><br/>
									<strong>Giro de la empresa: </strong><?php echo $rowData['Giro']; ?><br/>
									<strong>Rubro : </strong><?php echo $rowData['Rubro']; ?><br/>
								</p>
							<?php } ?>
											
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
							<p class="text-muted word_break">
								<strong>Telefono Fijo : </strong><?php echo formatPhone($rowData['Fono1']); ?><br/>
								<strong>Telefono Movil : </strong><?php echo formatPhone($rowData['Fono2']); ?><br/>
								<strong>Fax : </strong><?php echo $rowData['Fax']; ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowData['email']; ?>"><?php echo $rowData['email']; ?></a><br/>
								<strong>Web : </strong><a target="_blank" rel="noopener noreferrer" href="https://<?php echo $rowData['Web']; ?>"><?php echo $rowData['Web']; ?></a>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Persona de Contacto</h2>
							<p class="text-muted word_break">
								<strong>Persona de Contacto : </strong><?php echo $rowData['PersonaContacto']; ?><br/>
								<strong>Cargo Persona de Contacto : </strong><?php echo $rowData['PersonaContacto_Cargo']; ?><br/>
								<strong>Telefono : </strong><?php echo formatPhone($rowData['PersonaContacto_Fono']); ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowData['PersonaContacto_email']; ?>"><?php echo $rowData['PersonaContacto_email']; ?></a><br/>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Contrato</h2>
							<p class="text-muted word_break">
								<strong>Nombre : </strong><?php echo $rowData['Contrato_Nombre']; ?><br/>
								<strong>Numero o Codigo : </strong><?php echo $rowData['Contrato_Numero']; ?><br/>
								<strong>Periodo : </strong><?php echo $rowData['Contrato_Periodo']; ?><br/>
								<strong>Fecha inicio : </strong><?php echo fecha_estandar($rowData['Contrato_Fecha_Ini']); ?><br/>
								<strong>Fecha termino : </strong><?php echo fecha_estandar($rowData['Contrato_Fecha_Term']); ?><br/>
								<strong>Duracion N° Meses : </strong><?php echo Cantidades_decimales_justos($rowData['Contrato_N_Meses']); ?><br/>
								<strong>Representante Legal Nombre : </strong><?php echo $rowData['Contrato_Representante_Legal']; ?><br/>
								<strong>Representante Legal Rut : </strong><?php echo $rowData['Contrato_Representante_Rut']; ?><br/>
								<strong>Representante Legal Fono : </strong><?php echo formatPhone($rowData['Contrato_Representante_Fono']); ?><br/>
								<strong>Valor Mensual : </strong><?php echo valores($rowData['Contrato_Valor_Mensual'], 0); ?><br/>
								<strong>Valor Anual : </strong><?php echo valores($rowData['Contrato_Valor_Anual'], 0); ?><br/>
								<strong>Valor UF instalacion : </strong><?php echo Cantidades_decimales_justos($rowData['Contrato_UF_Instalacion']); ?><br/>
								<strong>Valor UF mensual : </strong><?php echo Cantidades_decimales_justos($rowData['Contrato_UF_Mensual']); ?><br/>
								<strong>Observaciones : </strong><br/>
								<div class="text-muted well well-sm no-shadow">
									<?php if(isset($rowData['Contrato_Obs'])&&$rowData['Contrato_Obs']!=''){echo $rowData['Contrato_Obs'];}else{echo 'Sin Observaciones';} ?>
									<div class="clearfix"></div>
								</div>
							</p>

							<?php if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==7){ ?>
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Unidades de Negocio</h2>
								<p class="text-muted word_break">
									<?php
										if(isset($rowData['idTab_1'])&&$rowData['idTab_1']==2&&isset($arrTabsSorter[1])){ echo ' - '.$arrTabsSorter[1].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 1, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';}
										if(isset($rowData['idTab_2'])&&$rowData['idTab_2']==2&&isset($arrTabsSorter[2])){ echo ' - '.$arrTabsSorter[2].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 2, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';}
										if(isset($rowData['idTab_3'])&&$rowData['idTab_3']==2&&isset($arrTabsSorter[3])){ echo ' - '.$arrTabsSorter[3].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 3, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';}
										if(isset($rowData['idTab_4'])&&$rowData['idTab_4']==2&&isset($arrTabsSorter[4])){ echo ' - '.$arrTabsSorter[4].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 4, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';}
										if(isset($rowData['idTab_5'])&&$rowData['idTab_5']==2&&isset($arrTabsSorter[5])){ echo ' - '.$arrTabsSorter[5].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 5, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';}
										if(isset($rowData['idTab_6'])&&$rowData['idTab_6']==2&&isset($arrTabsSorter[6])){ echo ' - '.$arrTabsSorter[6].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 6, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';}
										if(isset($rowData['idTab_7'])&&$rowData['idTab_7']==2&&isset($arrTabsSorter[7])){ echo ' - '.$arrTabsSorter[7].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 7, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';}
										if(isset($rowData['idTab_8'])&&$rowData['idTab_8']==2&&isset($arrTabsSorter[8])){ echo ' - '.$arrTabsSorter[8].' <a target="new" href="view_cliente_contrato.php?view='.$_GET['view'].'&idTab='.simpleEncode( 8, fecha_actual()).'" class="btn btn-default btn-sm"><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato Tipo</a><br/>';} 
									?>
								</p>		
							<?php } ?>

						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row">
						<?php
							//se arma la dirección
							$direccion = "";
							if(isset($rowData["Direccion"])&&$rowData["Direccion"]!=''){           $direccion .= $rowData["Direccion"];}
							if(isset($rowData["nombre_comuna"])&&$rowData["nombre_comuna"]!=''){   $direccion .= ', '.$rowData["nombre_comuna"];}
							if(isset($rowData["nombre_region"])&&$rowData["nombre_region"]!=''){   $direccion .= ', '.$rowData["nombre_region"];}
							//se despliega mensaje en caso de no existir dirección
							if($direccion!=''){
								echo mapa_from_direccion($direccion, 0, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1);
							}else{
								$Alert_Text  = 'No tiene una dirección definida';
								alert_post_data(4,2,2,0, $Alert_Text);
							}
						?>
					</div>
				</div>
				<div class="clearfix"></div>

			</div>

			<?php if($arrObservaciones!=false && !empty($arrObservaciones) && $arrObservaciones!=''){ ?>
				<div class="tab-pane fade" id="observaciones">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Autor</th>
										<th width="120">Fecha</th>
										<th>Observacion</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrObservaciones as $observaciones){ ?>
									<tr class="odd">
										<td><?php echo $observaciones['nombre_usuario']; ?></td>
										<td><?php echo $observaciones['Fecha']; ?></td>
										<td class="word_break"><?php echo $observaciones['Observacion']; ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrVentas!=false && !empty($arrVentas) && $arrVentas!=''){ ?>
				<div class="tab-pane fade" id="ventas">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Documento</th>
										<th width="120">Fecha</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrVentas as $venta) { ?>
									<tr class="odd">
										<td>
											<div class="btn-group" style="width: 35px;" >
												<a href="<?php echo 'view_mov_productos.php?view='.simpleEncode($venta['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
											<?php echo $venta['Documento'].' N°'.$venta['N_Doc']; ?>
										</td>
										<td><?php echo Fecha_estandar($venta['Creacion_fecha']); ?></td>	
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrCotizaciones!=false && !empty($arrCotizaciones) && $arrCotizaciones!=''){ ?>
				<div class="tab-pane fade" id="cotizaciones">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>N° Doc</th>
										<th width="120">Fecha</th>
										<th width="10">Acciones</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrCotizaciones as $sol) { ?>
										<tr class="odd">
											<td><?php echo 'Cotizacion N°'.n_doc($sol['idCotizacion'], 5); ?></td>
											<td><?php echo Fecha_estandar($sol['Creacion_fecha']); ?></td>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="<?php echo 'view_cotizacion.php?view='.simpleEncode($sol['idCotizacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Orden" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>
			
        </div>
	</div>
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
