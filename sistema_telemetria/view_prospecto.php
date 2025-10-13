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
prospectos_listado.email, 
prospectos_listado.Nombre,
prospectos_listado.Rut, 
prospectos_listado.RazonSocial, 
prospectos_listado.fNacimiento, 
prospectos_listado.Direccion, 
prospectos_listado.Fono1, 
prospectos_listado.Fono2, 
prospectos_listado.Fax,
prospectos_listado.PersonaContacto,
prospectos_listado.PersonaContacto_Fono,
prospectos_listado.PersonaContacto_email,
prospectos_listado.PersonaContacto_Cargo,
prospectos_listado.Web,
prospectos_listado.Giro,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
prospectos_tipos.Nombre AS tipoProspecto,
core_rubros.Nombre AS Rubro,
usuarios_listado.Nombre AS prospectoVendedor,
prospectos_estado_fidelizacion.Nombre AS prospectoEstado,
prospectos_listado.F_Ingreso AS prospectoFecha,
prospectos_etapa.Nombre AS prospectoEtapa,
prospectos_listado.idTab_1,
prospectos_listado.idTab_2,
prospectos_listado.idTab_3,
prospectos_listado.idTab_4,
prospectos_listado.idTab_5,
prospectos_listado.idTab_6,
prospectos_listado.idTab_7,
prospectos_listado.idTab_8';
$SIS_join  = '
LEFT JOIN `core_estados`                      ON core_estados.idEstado                                = prospectos_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`             ON core_ubicacion_ciudad.idCiudad                       = prospectos_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`            ON core_ubicacion_comunas.idComuna                      = prospectos_listado.idComuna
LEFT JOIN `core_sistemas`                     ON core_sistemas.idSistema                              = prospectos_listado.idSistema
LEFT JOIN `prospectos_tipos`                  ON prospectos_tipos.idTipo                              = prospectos_listado.idTipo
LEFT JOIN `core_rubros`                       ON core_rubros.idRubro                                  = prospectos_listado.idRubro
LEFT JOIN `usuarios_listado`                  ON usuarios_listado.idUsuario                           = prospectos_listado.idUsuario
LEFT JOIN `prospectos_estado_fidelizacion`    ON prospectos_estado_fidelizacion.idEstadoFidelizacion  = prospectos_listado.idEstadoFidelizacion
LEFT JOIN `prospectos_etapa`                  ON prospectos_etapa.idEtapa                             = prospectos_listado.idEtapa';
$SIS_where = 'prospectos_listado.idProspecto ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'prospectos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

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
// Se trae un listado con todas las observaciones el Prospecto
$SIS_query = '
usuarios_listado.Nombre AS nombre_usuario,
prospectos_observaciones.Fecha,
prospectos_observaciones.Observacion';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = prospectos_observaciones.idUsuario';
$SIS_where = 'prospectos_observaciones.idProspecto ='.$X_Puntero;
$SIS_order = 'prospectos_observaciones.idObservacion ASC LIMIT 15';
$arrObservaciones = array();
$arrObservaciones = db_select_array (false, $SIS_query, 'prospectos_observaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrObservaciones');

/**********************************************************/
// Se trae un listado con todas las etapa el Prospecto
$SIS_query = '
prospectos_etapa_fidelizacion.idEtapaFide,
usuarios_listado.Nombre AS nombre_usuario,
prospectos_etapa_fidelizacion.Fecha,
prospectos_etapa.Nombre AS Etapa';
$SIS_join  = '
LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = prospectos_etapa_fidelizacion.idUsuario
LEFT JOIN `prospectos_etapa` ON prospectos_etapa.idEtapa   = prospectos_etapa_fidelizacion.idEtapa';
$SIS_where = 'prospectos_etapa_fidelizacion.idProspecto ='.$X_Puntero;
$SIS_order = 'prospectos_etapa.Nombre DESC';
$arrEtapa = array();
$arrEtapa = db_select_array (false, $SIS_query, 'prospectos_etapa_fidelizacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEtapa');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Prospecto</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<?php if($arrObservaciones!=false && !empty($arrObservaciones) && $arrObservaciones!=''){ ?>
					<li class=""><a href="#observaciones" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
				<?php } ?>
				<?php if($arrEtapa!=false && !empty($arrEtapa) && $arrEtapa!=''){ ?>
					<li class=""><a href="#etapas" data-toggle="tab"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Etapas</a></li>
				<?php } ?>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Prospecto</h2>
							<p class="text-muted word_break">
								<strong>Vendedor : </strong><?php echo $rowData['prospectoVendedor']; ?><br/>
								<strong>Fecha de Registrado : </strong><?php echo Fecha_completa($rowData['prospectoFecha']); ?><br/>
								<strong>Estado Fidelizacion: </strong><?php echo $rowData['prospectoEstado']; ?><br/>
								<strong>Etapa Fidelizacion: </strong><?php echo $rowData['prospectoEtapa']; ?>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Prospecto : </strong><?php echo $rowData['tipoProspecto']; ?><br/>
								<strong>Nombre Fantasia: </strong><?php echo $rowData['Nombre']; ?><br/>
								<strong>Fecha de Ingreso Sistema : </strong><?php echo Fecha_completa($rowData['fNacimiento']); ?><br/>
								<strong>Región : </strong><?php echo $rowData['nombre_region']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowData['nombre_comuna']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
								<strong>Sistema Relacionado : </strong><?php echo $rowData['sistema']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['estado']; ?>
							</p>

							<?php if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==7){ ?>
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Unidades de Negocio</h2>
								<p class="text-muted word_break">
									<?php
										if(isset($rowData['idTab_1'])&&$rowData['idTab_1']==2&&isset($arrTabsSorter[1])){ echo ' - '.$arrTabsSorter[1].'<br/>';}
										if(isset($rowData['idTab_2'])&&$rowData['idTab_2']==2&&isset($arrTabsSorter[2])){ echo ' - '.$arrTabsSorter[2].'<br/>';}
										if(isset($rowData['idTab_3'])&&$rowData['idTab_3']==2&&isset($arrTabsSorter[3])){ echo ' - '.$arrTabsSorter[3].'<br/>';}
										if(isset($rowData['idTab_4'])&&$rowData['idTab_4']==2&&isset($arrTabsSorter[4])){ echo ' - '.$arrTabsSorter[4].'<br/>';}
										if(isset($rowData['idTab_5'])&&$rowData['idTab_5']==2&&isset($arrTabsSorter[5])){ echo ' - '.$arrTabsSorter[5].'<br/>';}
										if(isset($rowData['idTab_6'])&&$rowData['idTab_6']==2&&isset($arrTabsSorter[6])){ echo ' - '.$arrTabsSorter[6].'<br/>';}
										if(isset($rowData['idTab_7'])&&$rowData['idTab_7']==2&&isset($arrTabsSorter[7])){ echo ' - '.$arrTabsSorter[7].'<br/>';}
										if(isset($rowData['idTab_8'])&&$rowData['idTab_8']==2&&isset($arrTabsSorter[8])){ echo ' - '.$arrTabsSorter[8].'<br/>';} 
									?>
								</p>		
							<?php } ?>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Comerciales</h2>
							<p class="text-muted word_break">
								<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
								<strong>Razón Social : </strong><?php echo $rowData['RazonSocial']; ?><br/>
								<strong>Giro de la empresa: </strong><?php echo $rowData['Giro']; ?><br/>
								<strong>Rubro : </strong><?php echo $rowData['Rubro']; ?><br/>
							</p>
											
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

			<?php if($arrEtapa!=false && !empty($arrEtapa) && $arrEtapa!=''){ ?>
				<div class="tab-pane fade" id="etapas">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th width="120">Fecha</th>
										<th>Autor</th>
										<th>Etapa</th>
										<th width="10">Acciones</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrEtapa as $etapa) { ?>
										<tr class="odd">
											<td><?php echo fecha_estandar($etapa['Fecha']); ?></td>
											<td><?php echo $etapa['nombre_usuario']; ?></td>
											<td><?php echo $etapa['Etapa']; ?></td>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="<?php echo 'view_prospecto_etapa.php?view='.simpleEncode($etapa['idEtapaFide'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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
