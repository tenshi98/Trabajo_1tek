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
telemetria_listado.Nombre,
telemetria_listado.IdentificadorEmpresa,
telemetria_listado.Sim_Num_Tel,
telemetria_listado.Sim_Num_Serie,
telemetria_listado.Sim_modelo,
telemetria_listado.Sim_marca,
telemetria_listado.Sim_Compania,
telemetria_listado.IP_Client,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.TiempoDetencion,
telemetria_listado.Capacidad,
opc2.Nombre AS Geo,
opc3.Nombre AS Sensores,
telemetria_listado.cantSensores,
telemetria_listado.Direccion_img,
core_sistemas.Nombre AS sistema,
telemetria_listado.id_Geo,
telemetria_listado.id_Sensores,

telemetria_listado.Jornada_inicio,
telemetria_listado.Jornada_termino,
telemetria_listado.Colacion_inicio,
telemetria_listado.Colacion_termino,
telemetria_listado.Microparada,

core_estados.Nombre AS Estado,
telemetria_listado.LimiteVelocidad,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
telemetria_listado.Direccion,
telemetria_zonas.Nombre AS Zona';
$SIS_join  = '
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema          = telemetria_listado.idSistema
LEFT JOIN `core_sistemas_opciones`    opc2   ON opc2.idOpciones                  = telemetria_listado.id_Geo
LEFT JOIN `core_sistemas_opciones`    opc3   ON opc3.idOpciones                  = telemetria_listado.id_Sensores
LEFT JOIN `core_estados`                     ON core_estados.idEstado            = telemetria_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad   = telemetria_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna  = telemetria_listado.idComuna
LEFT JOIN `telemetria_zonas`                 ON telemetria_zonas.idZona          = telemetria_listado.idZona';
$SIS_where = 'telemetria_listado.idTelemetria ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************/
//Se consulta
$arrOpciones = array();
$arrOpciones = db_select_array (false, 'idOpciones,Nombre', 'core_sistemas_opciones', '', '', 'idOpciones ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOpciones');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

/********************************************/
//recorro
$arrFinalOpciones = array();
$arrFinalUnimed   = array();

foreach ($arrOpciones as $sen) { $arrFinalOpciones[$sen['idOpciones']] = $sen['Nombre'];}
foreach ($arrUnimed as $sen) {   $arrFinalUnimed[$sen['idUniMed']]     = $sen['Nombre'];}

$arrFinalOpciones[0]  = 'No Asignado';
$arrFinalUnimed[0]    = 'No Asignado';

if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){

	//numero sensores equipo
	$subquery = '';
	for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	//consulto
	$SIS_query = 'telemetria_listado.GeoVelocidad'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_tipo`        ON telemetria_listado_sensores_tipo.idTelemetria        = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`       ON telemetria_listado_sensores_grupo.idTelemetria       = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$X_Puntero;
	$rowMed = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowMed');

	//consulto
	$arrSensores = array();
	$arrSensores = db_select_array (false, 'idSensores,Nombre', 'telemetria_listado_sensores', '', '', 'idSensores ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSensores');						

	//consulto
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');	

	/********************************************/
	//recorro
	$arrFinalSensores = array();
	$arrFinalGrupos = array();

	foreach ($arrSensores as $sen) { $arrFinalSensores[$sen['idSensores']] = $sen['Nombre'];}
	foreach ($arrGrupos as $sen) {   $arrFinalGrupos[$sen['idGrupo']]      = $sen['Nombre'];}

	$arrFinalSensores[0]  = 'No Asignado';
	$arrFinalGrupos[0]    = 'No Asignado';

}

if(isset($rowData['idTrabajador'])&&$rowData['idTrabajador']!=0){
	// consulto los datos
	$SIS_query = '
	trabajadores_listado.Nombre,
	trabajadores_listado.ApellidoPat,
	trabajadores_listado.ApellidoMat,
	trabajadores_listado.Cargo,
	trabajadores_listado.Fono,
	trabajadores_listado.Rut,
	trabajadores_listado.Observaciones,
	trabajadores_listado_tipos.Nombre AS TipoTrabajador,
	core_sistemas.Nombre AS Sistema,
	core_ubicacion_ciudad.Nombre AS nombre_region,
	core_ubicacion_comunas.Nombre AS nombre_comuna,
	trabajadores_listado.Direccion,
	trabajadores_listado.F_Inicio_Contrato,
	trabajadores_listado.F_Termino_Contrato,
	sistema_afp.Nombre AS nombre_afp,
	sistema_salud.Nombre AS nombre_salud';
	$SIS_join  = '
	LEFT JOIN `trabajadores_listado_tipos`  ON trabajadores_listado_tipos.idTipo   = trabajadores_listado.idTipo
	LEFT JOIN `core_sistemas`               ON core_sistemas.idSistema             = trabajadores_listado.idSistema
	LEFT JOIN `core_ubicacion_ciudad`       ON core_ubicacion_ciudad.idCiudad      = trabajadores_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`      ON core_ubicacion_comunas.idComuna     = trabajadores_listado.idComuna
	LEFT JOIN `sistema_afp`                 ON sistema_afp.idAFP                   = trabajadores_listado.idAFP
	LEFT JOIN `sistema_salud`               ON sistema_salud.idSalud               = trabajadores_listado.idSalud';
	$SIS_where = 'trabajadores_listado.idTrabajador ='.$rowData['idTrabajador'];
	$rowTrabajador = db_select_data (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowTrabajador');

}

if(isset($rowData['idBodega'])&&$rowData['idBodega']!=0){

	//se consulta
	$SIS_query = '
	productos_listado.StockLimite,
	productos_listado.Nombre AS NombreProd,
	core_tipo_producto.Nombre AS tipo_producto,
	sistema_productos_uml.Nombre AS UnidadMedida,
	SUM(bodegas_productos_facturacion_existencias.Cantidad_ing) AS stock_entrada,
	SUM(bodegas_productos_facturacion_existencias.Cantidad_eg) AS stock_salida,
	bodegas_productos_listado.Nombre AS NombreBodega';
	$SIS_join  = '
	LEFT JOIN `productos_listado`           ON productos_listado.idProducto         = bodegas_productos_facturacion_existencias.idProducto
	LEFT JOIN `sistema_productos_uml`       ON sistema_productos_uml.idUml          = productos_listado.idUml
	LEFT JOIN `bodegas_productos_listado`   ON bodegas_productos_listado.idBodega   = bodegas_productos_facturacion_existencias.idBodega
	LEFT JOIN `core_tipo_producto`          ON core_tipo_producto.idTipoProducto    = productos_listado.idTipoProducto';
	$SIS_where = 'bodegas_productos_facturacion_existencias.idBodega='.$rowData['idBodega'].' GROUP BY bodegas_productos_facturacion_existencias.idProducto';
	$SIS_order = 'core_tipo_producto.Nombre ASC, productos_listado.Nombre ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

}

//numero sensores equipo
$subquery = '';
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
// Se trae un listado con todas las alertas
$SIS_query = '
telemetria_listado_errores.idErrores,
telemetria_listado_errores.Descripcion,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Hora,
telemetria_listado_errores.Valor,
telemetria_listado_errores.Valor_min,
telemetria_listado_errores.Valor_max,
telemetria_listado_errores.Sensor'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado`                  ON telemetria_listado.idTelemetria                  = telemetria_listado_errores.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado_errores.idTelemetria = '.$X_Puntero.' AND telemetria_listado_errores.idTipo!=999 AND telemetria_listado_errores.Valor<99900';
$SIS_order = 'telemetria_listado_errores.idErrores DESC LIMIT 20';
$arrAlertas = array();
$arrAlertas = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAlertas');

// Se trae un listado con todas las fuera de linea
$SIS_query = 'idFueraLinea, Fecha_inicio, Hora_inicio, Fecha_termino, Hora_termino, Tiempo';
$SIS_join  = '';
$SIS_where = 'idTelemetria = '.$X_Puntero;
$SIS_order = 'idFueraLinea DESC LIMIT 20';
$arrFlinea = array();
$arrFlinea = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFlinea');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>

				<?php if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){ ?>
				<li class=""><a href="#mediciones" data-toggle="tab"><i class="fa fa-wifi" aria-hidden="true"></i> Ultimas Mediciones</a></li>
				<?php } ?>

				<?php if(isset($rowData['idTrabajador'])&&$rowData['idTrabajador']!=0){ ?>
				<li class=""><a href="#trabajador" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> Datos del Trabajador</a></li>
				<?php } ?>

				<?php if(isset($rowData['idBodega'])&&$rowData['idBodega']!=0){ ?>
				<li class=""><a href="#bodega" data-toggle="tab"><i class="fa fa-building-o" aria-hidden="true"></i> Stock Bodega</a></li>
				<?php } ?>

				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="#alertas" data-toggle="tab"><i class="fa fa-bullhorn"  aria-hidden="true"></i> Alertas</a></li>
						<li class=""><a href="#flinea" data-toggle="tab"><i class="fa fa-power-off" aria-hidden="true"></i> Fuera de Linea</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/maquina.jpg">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Equipo</h2>
						<p class="text-muted">
							<?php if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){ ?><strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/><?php } ?>
							<?php if(isset($rowData['IdentificadorEmpresa'])&&$rowData['IdentificadorEmpresa']!=''){ ?><strong>Identificador Empresa : </strong><?php echo $rowData['IdentificadorEmpresa']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_Num_Tel'])&&$rowData['Sim_Num_Tel']!=''){ ?><strong>SIM - Numero Telefonico : </strong><?php echo $rowData['Sim_Num_Tel']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_Num_Serie'])&&$rowData['Sim_Num_Serie']!=''){ ?><strong>SIM - Numero Serie : </strong><?php echo $rowData['Sim_Num_Serie']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_Compania'])&&$rowData['Sim_Compania']!=''){ ?><strong>SIM - Compañia : </strong><?php echo $rowData['Sim_Compania']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_marca'])&&$rowData['Sim_marca']!=''){ ?><strong>BAM - Marca : </strong><?php echo $rowData['Sim_marca']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_modelo'])&&$rowData['Sim_modelo']!=''){ ?><strong>BAM - Modelo : </strong><?php echo $rowData['Sim_modelo']; ?><br/><?php } ?>
							<?php if(isset($rowData['IP_Client'])&&$rowData['IP_Client']!=''){ ?><strong>IP Cliente : </strong><?php echo $rowData['IP_Client']; ?><br/><?php } ?>
							<?php if(isset($rowData['idTelemetria'])&&$rowData['idTelemetria']!=''){ ?><strong>ID Equipo : </strong><?php echo $rowData['idTelemetria']; ?><br/><?php } ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Configuracion</h2>
						<p class="text-muted">
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>
							<strong>Geolocalizacion : </strong><?php echo $rowData['Geo']; ?><br/>
							<?php if($rowData['id_Geo']==1){ ?>
							<strong>Limite Velocidad : </strong><?php echo Cantidades_decimales_justos($rowData['LimiteVelocidad']).' KM/h'; ?><br/>
							<?php }
							if($rowData['id_Geo']==2){ ?>
								<strong>Zona : </strong><?php echo $rowData['Zona']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion'].', '.$rowData['Comuna'].', '.$rowData['Ciudad']; ?><br/>
							<?php } ?>
							<strong>Sensores : </strong><?php echo $rowData['Sensores'].' ';if($rowData['id_Sensores']==1){echo '('.$rowData['cantSensores'].' Sensores)';} ?><br/>
							<strong>Tiempo Fuera Linea Maximo : </strong><?php echo $rowData['TiempoFueraLinea']; ?> Horas<br/>
							<?php if($rowData['id_Geo']==1){ ?>
							<strong>Tiempo Maximo Detencion : </strong><?php echo $rowData['TiempoDetencion']; ?> Horas<br/>
							<?php } ?>
							<?php if(isset($rowData['Capacidad'])&&$rowData['Capacidad']!=0){ ?>
								<strong>Capacidad : </strong><?php echo Cantidades_decimales_justos($rowData['Capacidad']); ?><br/>
							<?php } ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Jornada Laboral</h2>
						<p class="text-muted">
							<strong>Hora Inicio Jornada : </strong><?php echo $rowData['Jornada_inicio'].' hrs'; ?><br/>
							<strong>Hora Termino Jornada : </strong><?php echo $rowData['Jornada_termino'].' hrs'; ?><br/>
							<strong>Hora Inicio Colacion : </strong><?php echo $rowData['Colacion_inicio'].' hrs'; ?><br/>
							<strong>Hora Termino Colacion : </strong><?php echo $rowData['Colacion_termino'].' hrs'; ?><br/>
							<strong>Tiempo Microparadas : </strong><?php echo $rowData['Microparada'].' hrs'; ?><br/>
						</p>

					</div>
					<div class="clearfix"></div>

				</div>
			</div>

			<?php if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){ ?>
				<div class="tab-pane fade" id="mediciones">
					<div class="wmd-panel">
						<div class="table-responsive">

							<div class="form-group" style="padding-top:10px;padding-bottom:10px;">
								<?php if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){ ?>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'telemetria_gestion_flota_view_equipo_mediciones.php?view='.$X_Puntero.'&cantSensores='.$rowData['cantSensores']; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Ver Ultima Ubicación</a>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_sensores_1.php?view='.$X_Puntero; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Informe Medicion Sensores</a>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_velocidad.php?view='.$X_Puntero; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Informe Medicion Velocidades</a>
								<?php }elseif(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==2){ ?>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'telemetria_gestion_sensores_view_equipo_mediciones.php?view='.$X_Puntero.'&cantSensores='.$rowData['cantSensores']; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Ver Ultima Ubicación</a>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_sensores_2.php?view='.$X_Puntero; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Informe Medicion Sensores</a>
								<?php } ?>
								<div style="padding-bottom:10px;padding-top:10px;"></div>
							</div>

							<?php if(isset($rowData['LimiteVelocidad'])&&$rowData['LimiteVelocidad']!=0){ ?>
								<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
									<thead>
										<tr role="row">
											<th>Parametro</th>
											<th>Fecha/hora</th>
											<th>Medicion Actual</th>
											<th>Maximo Medicion</th>
										</tr>
									</thead>
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<tr class="odd <?php if($rowMed['GeoVelocidad'] > $rowData['LimiteVelocidad']){echo 'danger';} ?>">
											<td>Velocidad</td>
											<td><?php echo fecha_estandar($rowData['LastUpdateFecha']).' - '.$rowData['LastUpdateHora'].' hrs'; ?></td>
											<td><?php echo Cantidades($rowMed['GeoVelocidad'], 0).' KM/h'; ?></td>
											<td><?php echo Cantidades($rowData['LimiteVelocidad'], 0).' KM/h'; ?></td>
										</tr>

									</tbody>
								</table>
							<?php } ?>

							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>#</th>
										<th>Nombre</th>
										<th>Tipo Sensor</th>
										<th>Grupo</th>
										<th>Fecha/hora</th>
										<th>Medicion Actual</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
										//solo sensores activos
										if(isset($rowMed['SensoresActivo_'.$i])&&$rowMed['SensoresActivo_'.$i]==1){
											$unimed = ' '.$arrFinalUnimed[$rowMed['SensoresUniMed_'.$i]];
											$s_alert = '';
											?>
											<tr class="odd <?php echo $s_alert; ?>">
												<td><?php echo 's'.$i ?></td>
												<td><?php echo $rowMed['SensoresNombre_'.$i]; ?></td>
												<td><?php echo $arrFinalSensores[$rowMed['SensoresTipo_'.$i]]; ?></td>
												<td><?php echo $arrFinalGrupos[$rowMed['SensoresGrupo_'.$i]]; ?></td>
												<td><?php echo fecha_estandar($rowMed['LastUpdateFecha']).' - '.$rowMed['LastUpdateHora'].' hrs'; ?></td>
												<td><?php
													if(isset($rowMed['SensoresMedActual_'.$i])&&$rowMed['SensoresMedActual_'.$i]<99900){
														echo Cantidades_decimales_justos($rowMed['SensoresMedActual_'.$i]).$unimed;
													}else{
														echo 'Sin Datos';
													} ?>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if(isset($rowData['idTrabajador'])&&$rowData['idTrabajador']!=0){ ?>
				<div class="tab-pane fade" id="trabajador">
					<div class="wmd-panel">

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<?php if ($rowData['Direccion_img']=='') { ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/maquina.jpg">
							<?php }else{  ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
							<?php } ?>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
							<p class="text-muted">
								<strong>Nombre : </strong><?php echo $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat']; ?><br/>
								<strong>Fono : </strong><?php echo formatPhone($rowTrabajador['Fono']); ?><br/>
								<strong>Rut : </strong><?php echo $rowTrabajador['Rut']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowTrabajador['Direccion'].', '.$rowTrabajador['nombre_comuna'].', '.$rowTrabajador['nombre_region']; ?><br/>
								<strong>Observaciones : </strong><?php echo $rowTrabajador['Observaciones']; ?>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Laborales</h2>
							<p class="text-muted">
								<strong>Tipo Trabajador : </strong><?php echo $rowTrabajador['TipoTrabajador']; ?><br/>
								<strong>Cargo : </strong><?php echo $rowTrabajador['Cargo']; ?><br/>
								<strong>Sistema : </strong><?php echo $rowTrabajador['Sistema']; ?><br/>
								<strong>AFP : </strong><?php echo $rowTrabajador['nombre_afp']; ?><br/>
								<strong>Salud : </strong><?php echo $rowTrabajador['nombre_salud']; ?><br/>
								<strong>Fecha de Inicio Contrato : </strong><?php if(isset($rowTrabajador['F_Inicio_Contrato'])&&$rowTrabajador['F_Inicio_Contrato']!='0000-00-00'){echo Fecha_estandar($rowTrabajador['F_Inicio_Contrato']);}else{echo 'Sin fecha de inicio';} ?><br/>
								<strong>Fecha de Termino Contrato : </strong><?php if(isset($rowTrabajador['F_Termino_Contrato'])&&$rowTrabajador['F_Termino_Contrato']!='0000-00-00'){echo Fecha_estandar($rowTrabajador['F_Termino_Contrato']);}else{echo 'Sin fecha de termino';} ?>
							</p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			<?php } ?>

			<?php if(isset($rowData['idBodega'])&&$rowData['idBodega']!=0){ ?>
				<div class="tab-pane fade" id="bodega">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Tipo</th>
										<th>Nombre</th>
										<th>Stock Min</th>
										<th>Stock Actual</th>
									</tr>
								</thead>

								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrProductos as $productos) {
										$stock_actual = $productos['stock_entrada'] - $productos['stock_salida'];
										if ($stock_actual!=0&&$productos['NombreProd']!=''){ ?>
											<tr class="odd <?php if ($productos['StockLimite']>$stock_actual){echo 'danger';} ?>">
												<td><?php echo $productos['tipo_producto']; ?></td>
												<td><?php echo $productos['NombreProd']; ?></td>
												<td><?php echo Cantidades_decimales_justos($productos['StockLimite']); ?> <?php echo $productos['UnidadMedida']; ?></td>
												<td><?php echo Cantidades_decimales_justos($stock_actual) ?> <?php echo $productos['UnidadMedida']; ?></td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<div class="tab-pane fade" id="alertas">
				<div class="wmd-panel">
					<div class="table-responsive">

						<div class="form-group" style="padding-top:10px;padding-bottom:10px;">
							<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_errores_'.$rowData['id_Geo'].'.php?idTelemetria='.$X_Puntero.'&submit_filter=Filtrar'; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Abrir Reporte</a>
							<div style="padding-bottom:10px;padding-top:10px;"></div>
						</div>

						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Descripcion</th>
									<th>Fecha</th>
									<th>Hora</th>
									<th>Valor</th>
									<th>Min</th>
									<th>Max</th>
									<?php if($rowData['id_Geo']==1){ ?><th>Ubicación</th><?php } ?>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrAlertas as $error) {
									//Guardo la unidad de medida
									$unimed = ' '.$arrFinalUnimed[$error['SensoresUniMed_'.$error['Sensor']]]; ?>
									<tr>
										<td><?php echo $error['Descripcion']; ?></td>
										<td><?php echo fecha_estandar($error['Fecha']); ?></td>
										<td><?php echo $error['Hora']; ?></td>
										<td><?php echo Cantidades_decimales_justos($error['Valor']).$unimed; ?></td>
										<td><?php echo Cantidades_decimales_justos($error['Valor_min']).$unimed; ?></td>
										<td><?php echo Cantidades_decimales_justos($error['Valor_max']).$unimed; ?></td>
										<?php if($rowData['id_Geo']==1){ ?>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="<?php echo 'informe_telemetria_errores_'.$rowData['id_Geo'].'_view.php?view='.$error['idErrores'].'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												</div>
											</td>
										<?php } ?>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="flinea">
				<div class="wmd-panel">
					<div class="table-responsive">

						<div class="form-group" style="padding-top:10px;padding-bottom:10px;">
							<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_fuera_linea_'.$rowData['id_Geo'].'.php?idTelemetria='.$X_Puntero.'&submit_filter=Filtrar'; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Abrir Reporte</a>
							<div style="padding-bottom:10px;padding-top:10px;"></div>
						</div>

						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Fecha Inicio</th>
									<th>Hora Inicio</th>
									<th>Fecha Termino</th>
									<th>Hora Termino</th>
									<th>Tiempo</th>
									<?php if($rowData['id_Geo']==1){ ?><th>Ubicación</th><?php } ?>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrFlinea as $error) {  ?>
									<tr>
										<td><?php echo fecha_estandar($error['Fecha_inicio']); ?></td>
										<td><?php echo $error['Hora_inicio'].' hrs'; ?></td>
										<td><?php echo fecha_estandar($error['Fecha_termino']); ?></td>
										<td><?php echo $error['Hora_termino'].' hrs'; ?></td>
										<td><?php echo $error['Tiempo'].' hrs'; ?></td>
										<?php if($rowData['id_Geo']==1){ ?>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="<?php echo 'informe_telemetria_fuera_linea_'.$rowData['id_Geo'].'_view.php?view='.$error['idFueraLinea'].'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												</div>
											</td>
										<?php } ?>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>

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
