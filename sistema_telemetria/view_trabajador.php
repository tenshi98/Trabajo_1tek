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
trabajadores_listado.Direccion_img,

trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Rut,
core_sexo.Nombre AS Sexo,
trabajadores_listado.FNacimiento,
trabajadores_listado.Fono,
trabajadores_listado.email,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
trabajadores_listado.Direccion,
core_estado_civil.Nombre AS EstadoCivil,
core_estados.Nombre AS Estado,
core_sistemas.Nombre AS Sistema,

trabajadores_listado.ContactoPersona,
trabajadores_listado.ContactoFono,

trabajadores_listado_tipos.Nombre AS TipoTrabajador,
trabajadores_listado.Cargo, 
sistema_afp.Nombre AS nombre_afp,
sistema_salud.Nombre AS nombre_salud,
core_tipos_contrato.Nombre AS TipoContrato,
core_tipos_contrato_trabajador.Nombre AS TipoContratoTrab,
core_tipos_trabajadores.Nombre AS TipoConTrabajador,
trabajadores_listado.horas_pactadas,
trabajadores_listado.Gratificacion,
trabajadores_listado.FechaContrato,
trabajadores_listado.F_Inicio_Contrato,
trabajadores_listado.F_Termino_Contrato,
trabajadores_listado.Observaciones,
trabajadores_listado.SueldoLiquido,
trabajadores_listado.SueldoDia,
trabajadores_listado.SueldoHora,
trabajadores_listado.UbicacionTrabajo,

core_tipos_licencia_conducir.Nombre AS LicenciaTipo,
trabajadores_listado.CA_Licencia AS LicenciaCA, 
trabajadores_listado.LicenciaFechaControlUltimo AS LicenciaControlUlt,
trabajadores_listado.LicenciaFechaControl AS LicenciaControl,

trabajadores_listado.File_Curriculum,
trabajadores_listado.File_Antecedentes,
trabajadores_listado.File_Carnet,
trabajadores_listado.File_Contrato,
trabajadores_listado.File_Licencia,
trabajadores_listado.File_RHTM,
trabajadores_listado.File_RHTM_Fecha,

trabajadores_listado.idTipoContratoTrab,

contratista_listado.Nombre AS Contratista,

centrocosto_listado.Nombre AS CentroCosto_Nombre,
centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5,

core_bancos.Nombre AS Pago_Banco,
core_tipo_cuenta.Nombre AS Pago_TipoCuenta,
trabajadores_listado.N_Cuenta AS Pago_N_Cuenta';
$SIS_join  = '
LEFT JOIN `core_estados`                     ON core_estados.idEstado                               = trabajadores_listado.idEstado
LEFT JOIN `trabajadores_listado_tipos`       ON trabajadores_listado_tipos.idTipo                   = trabajadores_listado.idTipo
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                             = trabajadores_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad                      = trabajadores_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna                     = trabajadores_listado.idComuna
LEFT JOIN `sistema_afp`                      ON sistema_afp.idAFP                                   = trabajadores_listado.idAFP
LEFT JOIN `sistema_salud`                    ON sistema_salud.idSalud                               = trabajadores_listado.idSalud
LEFT JOIN `core_tipos_contrato`              ON core_tipos_contrato.idTipoContrato                  = trabajadores_listado.idTipoContrato
LEFT JOIN `core_tipos_licencia_conducir`     ON core_tipos_licencia_conducir.idTipoLicencia         = trabajadores_listado.idTipoLicencia
LEFT JOIN `core_sexo`                        ON core_sexo.idSexo                                    = trabajadores_listado.idSexo
LEFT JOIN `core_estado_civil`                ON core_estado_civil.idEstadoCivil                     = trabajadores_listado.idEstadoCivil
LEFT JOIN `core_tipos_contrato_trabajador`   ON core_tipos_contrato_trabajador.idTipoContratoTrab   = trabajadores_listado.idTipoContratoTrab
LEFT JOIN `core_tipos_trabajadores`          ON core_tipos_trabajadores.idTipoTrabajador            = trabajadores_listado.idTipoTrabajador
LEFT JOIN `contratista_listado`              ON contratista_listado.idContratista                   = trabajadores_listado.idContratista
LEFT JOIN `centrocosto_listado`              ON centrocosto_listado.idCentroCosto                   = trabajadores_listado.idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`      ON centrocosto_listado_level_1.idLevel_1               = trabajadores_listado.idLevel_1
LEFT JOIN `centrocosto_listado_level_2`      ON centrocosto_listado_level_2.idLevel_2               = trabajadores_listado.idLevel_2
LEFT JOIN `centrocosto_listado_level_3`      ON centrocosto_listado_level_3.idLevel_3               = trabajadores_listado.idLevel_3
LEFT JOIN `centrocosto_listado_level_4`      ON centrocosto_listado_level_4.idLevel_4               = trabajadores_listado.idLevel_4
LEFT JOIN `centrocosto_listado_level_5`      ON centrocosto_listado_level_5.idLevel_5               = trabajadores_listado.idLevel_5
LEFT JOIN `core_bancos`                      ON core_bancos.idBanco                                 = trabajadores_listado.idBanco
LEFT JOIN `core_tipo_cuenta`                 ON core_tipo_cuenta.idTipoCuenta                       = trabajadores_listado.idTipoCuenta';
$SIS_where = 'trabajadores_listado.idTrabajador ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

// Se trae un listado con todos los elementos
$SIS_query = 'Nombre,ApellidoPat, ApellidoMat';
$SIS_join  = '';
$SIS_where = 'idTrabajador ='.$X_Puntero;
$SIS_order = 'idCarga ASC';
$arrCargas = array();
$arrCargas = db_select_array (false, $SIS_query, 'trabajadores_listado_cargas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCargas');

// consulto los datos
$SIS_query = '
trabajadores_listado_bonos_fijos.idBono,
sistema_bonos_fijos.Nombre AS Bono,
trabajadores_listado_bonos_fijos.Monto';
$SIS_join  = 'LEFT JOIN `sistema_bonos_fijos` ON sistema_bonos_fijos.idBonoFijo = trabajadores_listado_bonos_fijos.idBonoFijo';
$SIS_where = 'trabajadores_listado_bonos_fijos.idTrabajador ='.$X_Puntero;
$SIS_order = 'sistema_bonos_fijos.Nombre ASC';
$arrBonos = array();
$arrBonos = db_select_array (false, $SIS_query, 'trabajadores_listado_bonos_fijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBonos');

// consulto los datos
$SIS_query = 'idAnexo,Documento, Fecha_ingreso';
$SIS_join  = '';
$SIS_where = 'idTrabajador ='.$X_Puntero;
$SIS_order = 'Fecha_ingreso DESC';
$arrAnexos = array();
$arrAnexos = db_select_array (false, $SIS_query, 'trabajadores_listado_anexos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAnexos');

// Se trae un listado con todas las ot
$SIS_query = '
sistema_productos_categorias.Nombre AS Categoria,
insumos_listado.Nombre AS Producto,
sistema_productos_uml.Nombre AS Uml,
bodegas_insumos_facturacion_existencias.Cantidad_eg AS Cantidad,
bodegas_insumos_facturacion_existencias.Creacion_fecha AS Fecha,
bodegas_insumos_facturacion_existencias.idFacturacion AS idFacturacion';
$SIS_join  = '
LEFT JOIN `insumos_listado`                 ON insumos_listado.idProducto                 = bodegas_insumos_facturacion_existencias.idProducto
LEFT JOIN `sistema_productos_categorias`    ON sistema_productos_categorias.idCategoria   = insumos_listado.idCategoria
LEFT JOIN `sistema_productos_uml`           ON sistema_productos_uml.idUml                = insumos_listado.idUml';
$SIS_where = 'bodegas_insumos_facturacion_existencias.idTrabajador ='.$X_Puntero;
$SIS_order = 'bodegas_insumos_facturacion_existencias.Creacion_fecha DESC LIMIT 20';
$arrActivos = array();
$arrActivos = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrActivos');

/************************************************************/
// Se trae un listado con todos los descuentos del trabajador
$SIS_query = '
trabajadores_listado_descuentos_fijos.idDescuento,
sistema_descuentos_fijos.Nombre AS Descuento,
trabajadores_listado_descuentos_fijos.Monto,
sistema_afp.Nombre AS AFP';
$SIS_join  = '
LEFT JOIN `sistema_descuentos_fijos`   ON sistema_descuentos_fijos.idDescuentoFijo     = trabajadores_listado_descuentos_fijos.idDescuentoFijo
LEFT JOIN `sistema_afp`                ON sistema_afp.idAFP                            = trabajadores_listado_descuentos_fijos.idAFP';
$SIS_where = 'trabajadores_listado_descuentos_fijos.idTrabajador ='.$X_Puntero;
$SIS_order = 'sistema_descuentos_fijos.Nombre ASC';
$arrDescuentos = array();
$arrDescuentos = db_select_array (false, $SIS_query, 'trabajadores_listado_descuentos_fijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDescuentos');

?>

<div class="no-print">
	<div class="col-xs-12">
		<a target="new" href="view_trabajador_ficha.php?view=<?php echo $_GET['view'] ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
			<i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Ficha
		</a>
		<a target="new" href="view_trabajador_contrato.php?view=<?php echo $_GET['view'] ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
			<i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar Contrato TIPO
		</a>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos del Trabajador</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="#ot" data-toggle="tab"><i class="fa fa-bookmark-o" aria-hidden="true"></i> Ordenes de Trabajo</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">

				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat']; ?><br/>
							<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
							<strong>Sexo : </strong><?php echo $rowData['Sexo']; ?><br/>
							<strong>Fecha de Nacimiento : </strong><?php echo Fecha_estandar($rowData['FNacimiento']); ?><br/>
							<strong>Fono : </strong><?php echo formatPhone($rowData['Fono']); ?><br/>
							<strong>Email : </strong><?php echo $rowData['email']; ?><br/>
							<strong>Dirección : </strong><?php echo $rowData['Direccion'].', '.$rowData['nombre_comuna'].', '.$rowData['nombre_region']; ?><br/>
							<strong>Estado Civil: </strong><?php echo $rowData['EstadoCivil']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowData['Sistema']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Cargas Familiares</h2>
						<p class="text-muted">
							<?php
							//Se existen cargas estas se despliegan
							if($arrCargas!=false){
								//variable
								$n_carga = 1;
								//recorro
								foreach ($arrCargas as $carga) {
									echo '<strong>Carga #'.$n_carga.' : </strong>'.$carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat'].'<br/>';
									$n_carga++;
								}
							//si no existen cargas se muestra mensaje
							}else{
								echo 'Trabajador sin cargas familiares';
							}
							?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
						<p class="text-muted">
							<strong>Persona de Contacto : </strong><?php echo $rowData['ContactoPersona']; ?><br/>
							<strong>Fono de Persona de Contacto : </strong><?php echo formatPhone($rowData['ContactoFono']); ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Laborales</h2>
						<p class="text-muted">
							<span class="text-danger"><strong>Datos Trabajador</strong></span><br/>
							<strong>Tipo Trabajador : </strong><?php echo $rowData['TipoTrabajador']; ?><br/>
							<strong>Cargo : </strong><?php echo $rowData['Cargo']; ?><br/>

							<br/><span class="text-danger"><strong>Datos Contrato</strong></span><br/>
							<?php if(isset($rowData['Contratista'])&&$rowData['Contratista']!=''){ ?><strong>Contratista : </strong><?php echo $rowData['Contratista']; ?><br/><?php } ?>
							<strong>Tipo de Trabajador : </strong><?php echo $rowData['TipoConTrabajador']; ?><br/>
							<strong>Tipo de Contrato : </strong><?php echo $rowData['TipoContrato']; ?><br/>
							<strong>Tipo de Sueldo : </strong><?php echo $rowData['TipoContratoTrab']; ?><br/>
							<strong>Horas Pactadas : </strong><?php echo $rowData['horas_pactadas']; ?> Horas<br/>
							<strong>Fecha de Contrato : </strong><?php if(isset($rowData['FechaContrato'])&&$rowData['FechaContrato']!='0000-00-00'){echo Fecha_estandar($rowData['FechaContrato']);}else{echo 'Sin fecha de Contrato';} ?><br/>
							<strong>Fecha de Inicio Contrato : </strong><?php if(isset($rowData['F_Inicio_Contrato'])&&$rowData['F_Inicio_Contrato']!='0000-00-00'){echo Fecha_estandar($rowData['F_Inicio_Contrato']);}else{echo 'Sin fecha de inicio';} ?><br/>
							<strong>Fecha de Termino Contrato : </strong><?php if(isset($rowData['F_Termino_Contrato'])&&$rowData['F_Termino_Contrato']!='0000-00-00'){echo Fecha_estandar($rowData['F_Termino_Contrato']);}else{echo 'Sin fecha de termino';} ?><br/>
							<strong>Ubicación Trabajo : </strong><?php echo $rowData['UbicacionTrabajo']; ?><br/>

							<br/><span class="text-danger"><strong>Remuneraciones</strong></span><br/>
							<?php if(isset($rowData['idTipoContratoTrab'])){ 
								switch ($rowData['idTipoContratoTrab']) {
									case 1:
									case 2:
										echo '<strong>Sueldo Liquido a Pago : </strong>'.valores($rowData['SueldoLiquido'], 0).'<br/>';
										break;
									case 3:
									case 4:
										echo '<strong>Sueldo Liquido a Pago por dia : </strong>'.valores($rowData['SueldoDia'], 0).'<br/>';
										break;
									case 5:
										echo '<strong>Sueldo Liquido a Pago por hora : </strong>'.valores($rowData['SueldoHora'], 0).'<br/>';
										break;
								}
							} ?>
							<strong>Gratificacion : </strong><?php echo valores($rowData['Gratificacion'], 0); ?><br/>

							<br/><span class="text-danger"><strong>Forma de Pago</strong></span><br/>
							<strong>Banco : </strong><?php echo $rowData['Pago_Banco']; ?><br/>
							<strong>Tipo de cuenta deposito : </strong><?php echo $rowData['Pago_TipoCuenta']; ?><br/>
							<strong>Nro. Cta. Deposito : </strong><?php echo $rowData['Pago_N_Cuenta']; ?><br/>

							<br/><span class="text-danger"><strong>Descuentos Previsionales</strong></span><br/>
							<strong>AFP : </strong><?php echo $rowData['nombre_afp']; ?><br/>
							<?php foreach ($arrDescuentos as $bon) { ?>
								<strong><?php echo $bon['Descuento'].' ('.$bon['AFP'].')'; ?> : </strong><?php echo valores($bon['Monto'], 0); ?><br/>
							<?php } ?>
							<strong>Salud : </strong><?php echo $rowData['nombre_salud']; ?><br/>

							<br/><span class="text-danger"><strong>Bonos Fijos Asignados</strong></span><br/>
							<?php
							//Verifico el total de cargas
							$nn = 0;
							$n_carga = 1;
							foreach ($arrBonos as $bon) {
								$nn++;
							}
							//Se existen cargas estas se despliegan
							if($nn!=0){
								foreach ($arrBonos as $bon) {
									echo '<strong>Bono '.$bon['Bono'].' : </strong> '.valores($bon['Monto'], 0).'<br/>';
									$n_carga++;
								}
							//si no existen cargas se muestra mensaje
							}else{
								echo 'Trabajador sin Bonos Fijos Asignados';
							}
							?>
							<?php
							if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
								echo '<br/><strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
								if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){echo ' - '.$rowData['CentroCosto_Level_1'];}
								if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){echo ' - '.$rowData['CentroCosto_Level_2'];}
								if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){echo ' - '.$rowData['CentroCosto_Level_3'];}
								if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){echo ' - '.$rowData['CentroCosto_Level_4'];}
								if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){echo ' - '.$rowData['CentroCosto_Level_5'];}
								echo '<br/>';
							}
							?>

							<br/><span class="text-danger"><strong>Observaciones</strong></span><br/>
							<div class="text-muted well well-sm no-shadow">
								<?php if(isset($rowData['Observaciones'])&&$rowData['Observaciones']!=''){echo $rowData['Observaciones'];}else{echo 'Sin Observaciones';} ?>
								<div class="clearfix"></div>
							</div>

						</p>
						
							
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Licencia de Conducir</h2>
						<p class="text-muted">
							<strong>Tipo de Licencia : </strong><?php echo $rowData['LicenciaTipo']; ?><br/>
							<strong>Numero CA : </strong><?php echo $rowData['LicenciaCA']; ?><br/>
							<strong>Fecha Ultimo Control : </strong><?php if(isset($rowData['LicenciaControlUlt'])&&$rowData['LicenciaControlUlt']!='0000-00-00'){echo Fecha_estandar($rowData['LicenciaControlUlt']);}else{echo 'Sin fecha de ultimo control';} ?><br/>
							<strong>Fecha Control : </strong><?php if(isset($rowData['LicenciaControl'])&&$rowData['LicenciaControl']!='0000-00-00'){echo Fecha_estandar($rowData['LicenciaControl']);}else{echo 'Sin fecha de control';} ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php
								//Contrato
								if(isset($rowData['File_Contrato'])&&$rowData['File_Contrato']!=''){
									echo '
										<tr class="item-row">
											<td>Contrato de Trabajo</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Contrato'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Contrato'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Anexos al contrato
								foreach ($arrAnexos as $tipo) {
									echo '
										<tr class="item-row">
											<td>Anexo del '.fecha_estandar($tipo['Fecha_ingreso']).' :'.$tipo['Documento'].'</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($tipo['Documento'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($tipo['Documento'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Curriculum
								if(isset($rowData['File_Curriculum'])&&$rowData['File_Curriculum']!=''){
									echo '
										<tr class="item-row">
											<td>Curriculum</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Curriculum'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Curriculum'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Antecedentes
								if(isset($rowData['File_Antecedentes'])&&$rowData['File_Antecedentes']!=''){
									echo '
										<tr class="item-row">
											<td>Papel de Antecedentes Penales</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Antecedentes'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Antecedentes'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Carnet
								if(isset($rowData['File_Carnet'])&&$rowData['File_Carnet']!=''){
									echo '
										<tr class="item-row">
											<td>Carnet de Identidad</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Carnet'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Carnet'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Licencia Conducir
								if(isset($rowData['File_Licencia'])&&$rowData['File_Licencia']!=''){
									echo '
										<tr class="item-row">
											<td>Licencia de Conducir</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Licencia'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Licencia'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//RHTM
								if(isset($rowData['File_RHTM'])&&$rowData['File_RHTM']!=''){
									echo '
										<tr class="item-row">
											<td>RHTM Revisado el '.fecha_estandar($rowData['File_RHTM_Fecha']).'</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_RHTM'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_RHTM'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								
								?>
							</tbody>
						</table>
						
										
					</div>
					<div class="clearfix"></div>

				</div>

			</div>

			<div class="tab-pane fade" id="ot">
				<div class="wmd-panel">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th colspan="5">Ordenes de Trabajo realizadas</th>
								</tr>
								<tr role="row">
									<th># OT</th>
									<th>Fecha</th>
									<th>Estado</th>
									<th>Ubicación</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								                   
							</tbody>
						</table>
					</div>
				</div>
			</div>

        </div>
	</div>
</div>

<?php if ($arrActivos!=false && !empty($arrActivos) && $arrActivos!=''){ ?>   
	<?php 
	filtrar($arrActivos, 'Categoria'); ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Insumos entregados</h5>
				<ul class="nav nav-tabs pull-right">
					<?php
					$xx=1;
					$var='';
					foreach($arrActivos as $menu=>$productos) {
						if($xx==1){$var='active';}else{$var='';}
						echo '<li class="'.$var.'"><a href="#'.espacio_guion($menu).'" data-toggle="tab">'.$menu.'</a></li>';
						$xx=2;
					}
					?>
				</ul>
			</header>
			<div class="body tab-content">

				<?php
				$xx=1;
				$var='';
				foreach($arrActivos as $menu=>$productos) {	
					if($xx==1){$var='active in';}else{$var='';} ?>
					<div class="tab-pane fade <?php echo $var; ?>" id="<?php echo espacio_guion($menu); ?>">
						<div class="wmd-panel">
							<div class="table-responsive">
								<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
									<thead>
									<tr role="row">
										<th width="120">Fecha</th>
										<th>Articulo</th>
									</tr>
									</thead>

									<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($productos as $producto) { ?>
										<tr class="odd">
											<td><?php echo $producto['Fecha']; ?></td>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="<?php echo 'view_mov_insumos.php?view='.simpleEncode($producto['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												</div>
												<?php echo cantidades($producto['Cantidad'], 0).' '.$producto['Uml'].' de '.$producto['Producto']; ?>
												
											</td>
											
										
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php
				$xx=2;
				} ?>


			</div>
		</div>
	</div>

<?php } ?>
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
