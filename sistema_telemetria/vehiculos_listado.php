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
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "vehiculos_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){ $location .= "&Nombre=".$_GET['Nombre'];        $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){ $location .= "&idTipo=".$_GET['idTipo'];        $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Marca']) && $_GET['Marca']!=''){   $location .= "&Marca=".$_GET['Marca'];          $search .= "&Marca=".$_GET['Marca'];}
if(isset($_GET['Modelo']) && $_GET['Modelo']!=''){ $location .= "&Modelo=".$_GET['Modelo'];        $search .= "&Modelo=".$_GET['Modelo'];}
if(isset($_GET['Patente']) && $_GET['Patente']!=''){      $location .= "&Patente=".$_GET['Patente'];      $search .= "&Patente=".$_GET['Patente'];}
if(isset($_GET['idProceso']) && $_GET['idProceso']!=''){  $location .= "&idProceso=".$_GET['idProceso'];  $search .= "&idProceso=".$_GET['idProceso'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Vehiculo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Vehiculo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Vehiculo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$query = "SELECT 
vehiculos_listado.Direccion_img,

vehiculos_listado.Nombre,
vehiculos_listado.Marca,
vehiculos_listado.Modelo, 
vehiculos_listado.Num_serie, 
vehiculos_listado.AnoFab, 
vehiculos_listado.Patente, 
vehiculos_listado.Password,
vehiculos_listado.idOpciones_1, 
vehiculos_listado.idOpciones_2, 
vehiculos_listado.idOpciones_3, 
vehiculos_listado.idOpciones_4, 
vehiculos_listado.idOpciones_5,
vehiculos_listado.idOpciones_6, 
vehiculos_listado.idOpciones_7,
vehiculos_listado.idOpciones_8,
vehiculos_listado.Capacidad,
vehiculos_listado.MCubicos, 
vehiculos_listado.CapacidadPersonas,
vehiculos_listado.LimiteVelocidad,
vehiculos_listado.AlertLimiteVelocidad,

vehiculos_listado.doc_mantencion,
vehiculos_listado.doc_padron,
vehiculos_listado.doc_permiso_circulacion,
vehiculos_listado.doc_resolucion_sanitaria,
vehiculos_listado.doc_revision_tecnica,
vehiculos_listado.doc_seguro_carga,
vehiculos_listado.doc_soap,
vehiculos_listado.doc_cert_trans_personas,
vehiculos_listado.doc_ficha_tecnica,

vehiculos_listado.doc_fecha_mantencion,
vehiculos_listado.doc_fecha_permiso_circulacion,
vehiculos_listado.doc_fecha_resolucion_sanitaria,
vehiculos_listado.doc_fecha_revision_tecnica,
vehiculos_listado.doc_fecha_seguro_carga,
vehiculos_listado.doc_fecha_soap,
vehiculos_listado.doc_fecha_cert_trans_personas,

core_sistemas.Nombre AS Sistema,
core_estados.Nombre AS Estado,
vehiculos_tipo.Nombre AS Tipo,
vehiculos_zonas.Nombre AS Zona,
telemetria_listado.Nombre AS Sensor,
bodegas_productos_listado.Nombre AS Bodega,
vehiculos_rutas.Nombre AS Ruta,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
core_estado_aprobacion_vehiculos.Nombre AS AprobacionEstado,
vehiculos_listado.Motivo AS AprobacionMotivo,
vehiculos_listado.idProceso,
vehiculos_tipo_carga.Nombre AS VehiculoTipoCarga

FROM `vehiculos_listado`
LEFT JOIN `core_sistemas`                      ON core_sistemas.idSistema                     = vehiculos_listado.idSistema
LEFT JOIN `core_estados`                       ON core_estados.idEstado                       = vehiculos_listado.idEstado
LEFT JOIN `vehiculos_tipo`                     ON vehiculos_tipo.idTipo                       = vehiculos_listado.idTipo
LEFT JOIN `vehiculos_zonas`                    ON vehiculos_zonas.idZona                      = vehiculos_listado.idZona
LEFT JOIN `telemetria_listado`                 ON telemetria_listado.idTelemetria             = vehiculos_listado.idTelemetria
LEFT JOIN `bodegas_productos_listado`          ON bodegas_productos_listado.idBodega          = vehiculos_listado.idBodega
LEFT JOIN `vehiculos_rutas`                    ON vehiculos_rutas.idRuta                      = vehiculos_listado.idRuta
LEFT JOIN `trabajadores_listado`               ON trabajadores_listado.idTrabajador           = vehiculos_listado.idTrabajador
LEFT JOIN `core_estado_aprobacion_vehiculos`   ON core_estado_aprobacion_vehiculos.idProceso  = vehiculos_listado.idProceso
LEFT JOIN `vehiculos_tipo_carga`               ON vehiculos_tipo_carga.idTipoCarga            = vehiculos_listado.idTipoCarga

WHERE vehiculos_listado.idVehiculo = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);
	
if(isset($rowData['idOpciones_5'])&&$rowData['idOpciones_5']==1){
	// Se trae un listado con todos los pasajeros
	$arrCargas = array();
	$query = "SELECT  
	apoderados_listado_hijos.Nombre,
	apoderados_listado_hijos.ApellidoPat, 
	apoderados_listado_hijos.ApellidoMat,
	apoderados_listado_hijos.Direccion_img,
	core_sexo.Nombre AS Sexo,
	sistema_planes.Nombre AS PlanNombre,
	sistema_planes.Valor AS PlanValor

	FROM `apoderados_listado_hijos`
	LEFT JOIN `core_sexo`       ON core_sexo.idSexo       = apoderados_listado_hijos.idSexo
	LEFT JOIN `sistema_planes`  ON sistema_planes.idPlan  = apoderados_listado_hijos.idPlan
	WHERE apoderados_listado_hijos.idVehiculo = ".$_GET['id']."
	ORDER BY apoderados_listado_hijos.idHijos ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrCargas,$row );
	}
}
if(isset($rowData['idOpciones_7'])&&$rowData['idOpciones_7']==1){
	// consulto los datos
	$arrPeonetas = array();
	$query = "SELECT idPeoneta, Nombre,ApellidoPat, ApellidoMat, Rut, Fecha
	FROM `vehiculos_listado_peonetas`
	WHERE idVehiculo = ".$_GET['id']."
	ORDER BY ApellidoPat ASC, ApellidoMat ASC, Nombre ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrPeonetas,$row );
	}
}


if(isset($rowData['idOpciones_8'])&&$rowData['idOpciones_8']==1){
	// Se trae un listado con todos los colegios
	$arrColegios = array();
	$query = "SELECT 
	colegios_listado.Nombre
	
	FROM `vehiculos_listado_colegios`
	LEFT JOIN `colegios_listado` ON colegios_listado.idColegio = vehiculos_listado_colegios.idColegio
	WHERE vehiculos_listado_colegios.idVehiculo = ".$_GET['id']."
	ORDER BY colegios_listado.Nombre ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrColegios,$row );
	}
}

/************************************************/
//Accesos a los equipos de telemetria
$trans_1 = "telemetria_listado.php";
$trans_2 = "admin_telemetria_listado.php";

//Accesos a bodegas de productos
$trans_3 = "bodegas_productos_egreso.php";
$trans_4 = "bodegas_productos_ingreso.php";
$trans_5 = "bodegas_productos_simple_stock.php";
$trans_6 = "bodegas_productos_stock.php";

//Accesos a rutas
$trans_7 = "vehiculos_rutas.php";
$trans_8 = "vehiculos_ruta_alternativa.php";

//Accesos a trabajadores
$trans_9 = "trabajadores_listado.php";

//Accesos a apoderados
$trans_10 = "apoderados_listado.php";

//Accesos a clientes
$trans_11 = "clientes_listado.php";

//Accesos a colegios
$trans_12 = "colegios_listado.php";

//realizo la consulta
$query = "SELECT

(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_1."' AND visualizacion!=9999 LIMIT 1) AS tran_1,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_2."' AND visualizacion!=9999 LIMIT 1) AS tran_2,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_3."' AND visualizacion!=9999 LIMIT 1) AS tran_3,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_4."' AND visualizacion!=9999 LIMIT 1) AS tran_4,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_5."' AND visualizacion!=9999 LIMIT 1) AS tran_5,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_6."' AND visualizacion!=9999 LIMIT 1) AS tran_6,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_7."' AND visualizacion!=9999 LIMIT 1) AS tran_7,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_8."' AND visualizacion!=9999 LIMIT 1) AS tran_8,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_9."' AND visualizacion!=9999 LIMIT 1) AS tran_9,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_10."' AND visualizacion!=9999 LIMIT 1) AS tran_10,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_11."' AND visualizacion!=9999 LIMIT 1) AS tran_11,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ='".$trans_12."' AND visualizacion!=9999 LIMIT 1) AS tran_12

FROM usuarios_listado
WHERE usuarios_listado.idUsuario='".$_GET['id']."' ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowDatax = mysqli_fetch_assoc ($resultado);


$telemetria  = $rowDatax['tran_1'] + $rowDatax['tran_2'];
$bodega      = $rowDatax['tran_3'] + $rowDatax['tran_4'] + $rowDatax['tran_5'] + $rowDatax['tran_6'];
$ruta        = $rowDatax['tran_7'] + $rowDatax['tran_8'];
$trabajador  = $rowDatax['tran_9'];
$pasajeros   = $rowDatax['tran_10'];
$peonetas    = $rowDatax['tran_11'];
$colegios    = $rowDatax['tran_12'];

$todos = $telemetria + $bodega + $ruta + $trabajador + $pasajeros + $peonetas + $colegios;

$idTipoUsuario  = $_SESSION['usuario']['basic_data']['idTipoUsuario'];


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php 
	$vehiculo = $rowData['Nombre'];
	if(isset($rowData['Patente'])&&$rowData['Patente']!=''){
		$vehiculo .= ' Patente '.$rowData['Patente'];
	}
	echo widget_title('bg-aqua', 'fa-cog', 100, 'Vehiculo', $vehiculo, 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'vehiculos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'vehiculos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<?php if($todos!=0 OR $idTipoUsuario==1){ ?>
					<li class=""><a href="<?php echo 'vehiculos_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<?php } ?>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if(isset($rowData['idOpciones_1'])&&$rowData['idOpciones_1']==1){ ?>		
							<li class=""><a href="<?php echo 'vehiculos_listado_opc_1.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Telemetria</a></li>
						<?php }
						if(isset($rowData['idOpciones_2'])&&$rowData['idOpciones_2']==1){ ?>
							<li class=""><a href="<?php echo 'vehiculos_listado_opc_2.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-database" aria-hidden="true"></i> Bodega</a></li>
						<?php }
						if(isset($rowData['idOpciones_3'])&&$rowData['idOpciones_3']==1){ ?>
							<li class=""><a href="<?php echo 'vehiculos_listado_opc_3.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ruta</a></li>
						<?php }
						if(isset($rowData['idOpciones_4'])&&$rowData['idOpciones_4']==1){ ?>
							<li class=""><a href="<?php echo 'vehiculos_listado_opc_4.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-car" aria-hidden="true"></i> Conductor</a></li>
						<?php }
						if(isset($rowData['idOpciones_5'])&&$rowData['idOpciones_5']==1){ ?>
							<li class=""><a href="<?php echo 'vehiculos_listado_opc_5.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-users" aria-hidden="true"></i> Pasajeros</a></li>
						<?php }
						if(isset($rowData['idOpciones_6'])&&$rowData['idOpciones_6']==1){ ?>
							<li class=""><a href="<?php echo 'vehiculos_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password APP</a></li>
						<?php }
						//Si se utilizan peonetas 
						if(isset($rowData['idOpciones_7'])&&$rowData['idOpciones_7']==1){ ?>
							<li class=""><a href="<?php echo 'vehiculos_listado_peonetas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-users" aria-hidden="true"></i> Peonetas</a></li>
						<?php }
						//Si se utilizan colegios 
						if(isset($rowData['idOpciones_8'])&&$rowData['idOpciones_8']==1){ ?>
							<li class=""><a href="<?php echo 'vehiculos_listado_colegios.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i> Colegios</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'vehiculos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Foto</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_geocercas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> GeoCercas</a></li>

						<li class=""><a href="<?php echo 'vehiculos_listado_doc_padron.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Padron</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_permiso_circulacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Permiso Circulacion</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_soap.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - SOAP</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_revision_tecnica.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Revision Tecnica</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_seguro_carga.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Seguro Carga</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_resolucion_sanitaria.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Resolucion Sanitaria</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_mantencion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Mantenciones</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_trans_personas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Cert. Transporte Personas</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Ficha Tecnica</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/car_siluete.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Tipo : </strong><?php echo $rowData['Tipo']; ?><br/>
							<strong>Marca : </strong><?php echo $rowData['Marca']; ?><br/>
							<strong>Modelo : </strong><?php echo $rowData['Modelo']; ?><br/>
							<strong>Numero de serie : </strong><?php echo $rowData['Num_serie']; ?><br/>
							<strong>Año de Fabricacion : </strong><?php echo $rowData['AnoFab']; ?><br/>
							<strong>Patente : </strong><?php echo $rowData['Patente']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowData['Sistema']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?>
							<?php
							//se verifica si telemetria esta activo y se muestra
							if(isset($rowData['idOpciones_1'])&&$rowData['idOpciones_1']==1){
								echo '<br/><strong>Sensor Telemetrico : </strong>'.$rowData['Sensor'];
							}
							//se verifica si bodega esta activo y se muestra
							if(isset($rowData['idOpciones_2'])&&$rowData['idOpciones_2']==1){
								echo '<br/><strong>Bodega : </strong>'.$rowData['Bodega'];
							}
							//se verifica si ruta esta activo y se muestra
							if(isset($rowData['idOpciones_3'])&&$rowData['idOpciones_3']==1){
								echo '<br/><strong>Ruta : </strong>'.$rowData['Ruta'];
							}
							//se verifica si trabajador esta activo y se muestra
							if(isset($rowData['idOpciones_4'])&&$rowData['idOpciones_4']==1){
								echo '<br/><strong>Trabajador asignado: </strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat'];
							}
							//se verifica el estado de aprobacion
							if(isset($rowData['AprobacionEstado'])&&$rowData['AprobacionEstado']!=''){
								echo '<br/><strong>Proceso Aprobacion: </strong>'.$rowData['AprobacionEstado'];
								if(isset($rowData['idProceso'])&&$rowData['idProceso']==3){echo ' ('.$rowData['AprobacionMotivo'].')';}
							} ?>

						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Caracteristicos</h2>
						<p class="text-muted">
							<strong>Zona de Trabajo : </strong><?php echo $rowData['Zona']; ?><br/>
							<strong>Capacidad Pasajeros : </strong><?php echo $rowData['CapacidadPersonas']; ?><br/>
							<strong>Capacidad (Kilos) : </strong><?php echo Cantidades_decimales_justos($rowData['Capacidad']); ?><br/>
							<strong>Metros Cubicos (M3) : </strong><?php echo Cantidades_decimales_justos($rowData['MCubicos']); ?><br/>
							<strong>Tipo de Carga : </strong><?php echo $rowData['VehiculoTipoCarga']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Movilizacion</h2>
						<p class="text-muted">
							<strong>Velocidad Maxima : </strong><?php echo Cantidades_decimales_justos($rowData['LimiteVelocidad']); ?><br/>
							<strong>N° Maximo Alertas de Velocidad : </strong><?php echo $rowData['AlertLimiteVelocidad']; ?><br/>
						</p>

						<?php if(isset($rowData['idOpciones_6'])&&$rowData['idOpciones_6']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de acceso a la APP</h2>
							<p class="text-muted">
								<strong>Usuario : </strong><?php echo $rowData['Patente']; ?><br/>
								<strong>Password : </strong><?php echo $rowData['Password']; ?><br/>
							</p>
						<?php } ?>

						<?php
						//Se verifica si se transportan personas
						if(isset($rowData['idOpciones_5'])&&$rowData['idOpciones_5']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Personas Transportadas</h2>
							<div class="row">
								<?php
								//Se existen cargas estas se despliegan
								if($arrCargas!=false){
									//variable
									$n_carga = 1;
									//recorro
									foreach ($arrCargas as $carga) { ?>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
											<div class="info-box" style="box-shadow:none; color:#999 !important;">
												<span class="info-box-icon">
													 <img src="upload/<?php echo $carga['Direccion_img']; ?>" alt="hijo" height="100%" width="100%"> 
												</span>
												<div class="info-box-content">
													<span class="info-box-text"><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></span>
													<span class="info-box-text"><?php echo $carga['Sexo']; ?></span>
													<span class="info-box-number"><?php echo $carga['PlanNombre']; ?></span>
												</div>
											</div>
										</div>

									<?php
									}
								//si no existen cargas se muestra mensaje
								}else{
									echo '<p class="text-muted">Sin personas asignadas</p>';
								}
								?>
							</div>
							<div class="clearfix"></div>
						<?php } ?>

						<?php
						//Se verifica si se tiene peonetas
						if(isset($rowData['idOpciones_7'])&&$rowData['idOpciones_7']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Peonetas Asignados</h2>
							<p class="text-muted">
								<?php
								//Verifico el total de peonetas
								$nn     = 0;
								$n_peon = 1;
								foreach ($arrPeonetas as $peoneta) {
									$nn++;
								}
								//Se existen peonetas estas se despliegan
								if($nn!=0){
									foreach ($arrPeonetas as $peoneta) {
										echo '<strong>Peoneta #'.$n_peon.' : </strong>'.$peoneta['Nombre'].' '.$peoneta['ApellidoPat'].' '.$peoneta['ApellidoMat'].'<br/>';
										$n_peon++;
									}
								//si no existen peonetas se muestra mensaje
								}else{
									echo '<p class="text-muted">Sin peonetas asignados</p>';
								}
								?>
							</p>
						<?php } ?>

						<?php if(isset($rowData['idOpciones_8'])&&$rowData['idOpciones_8']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Colegios Asignados</h2>
							<table id="items" style="margin-bottom: 20px;">
								<tbody>
									<?php foreach ($arrColegios as $colegio) { ?>
										<tr class="item-row">
											<td><?php $colegio['NombreColegio']; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php } ?>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php
								//Fecha ultima mantencion
								if(isset($rowData['doc_mantencion'])&&$rowData['doc_mantencion']!=''){
									echo '
										<tr class="item-row">
											<td>Fecha ultima mantencion (vence el '.fecha_estandar($rowData['doc_fecha_mantencion']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_mantencion'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_mantencion'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Padron del Vehiculo
								if(isset($rowData['doc_padron'])&&$rowData['doc_padron']!=''){
									echo '
										<tr class="item-row">
											<td>Padron del Vehiculo</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_padron'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_padron'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Permiso de Circulacion
								if(isset($rowData['doc_permiso_circulacion'])&&$rowData['doc_permiso_circulacion']!=''){
									echo '
										<tr class="item-row">
											<td>Permiso de Circulacion (vence el '.fecha_estandar($rowData['doc_fecha_permiso_circulacion']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_permiso_circulacion'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_permiso_circulacion'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Resolucion Sanitaria 
								if(isset($rowData['doc_resolucion_sanitaria'])&&$rowData['doc_resolucion_sanitaria']!=''){
									echo '
										<tr class="item-row">
											<td>Resolucion Sanitaria (vence el '.fecha_estandar($rowData['doc_fecha_resolucion_sanitaria']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_resolucion_sanitaria'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_resolucion_sanitaria'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Revision tecnica
								if(isset($rowData['doc_revision_tecnica'])&&$rowData['doc_revision_tecnica']!=''){
									echo '
										<tr class="item-row">
											<td>Revision tecnica (vence el '.fecha_estandar($rowData['doc_fecha_revision_tecnica']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_revision_tecnica'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_revision_tecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Seguro de Carga
								if(isset($rowData['doc_seguro_carga'])&&$rowData['doc_seguro_carga']!=''){
									echo '
										<tr class="item-row">
											<td>Seguro de Carga (vence el '.fecha_estandar($rowData['doc_fecha_seguro_carga']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_seguro_carga'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_seguro_carga'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Seguro SOAP 
								if(isset($rowData['doc_soap'])&&$rowData['doc_soap']!=''){
									echo '
										<tr class="item-row">
											<td>Seguro SOAP (vence el '.fecha_estandar($rowData['doc_fecha_soap']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_soap'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_soap'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Certificado Transporte Personas 
								if(isset($rowData['doc_cert_trans_personas'])&&$rowData['doc_cert_trans_personas']!=''){
									echo '
										<tr class="item-row">
											<td>Certificado Transporte Personas (vence el '.fecha_estandar($rowData['doc_fecha_cert_trans_personas']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_cert_trans_personas'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_cert_trans_personas'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Ficha Tecnica
								if(isset($rowData['doc_ficha_tecnica'])&&$rowData['doc_ficha_tecnica']!=''){
									echo '
										<tr class="item-row">
											<td>Ficha Tecnica</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_ficha_tecnica'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_ficha_tecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
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
        </div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Vehiculo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){       $x1  = $Nombre;       }else{$x1  = '';}
				if(isset($idTipo)){       $x2  = $idTipo;       }else{$x2  = '';}
				if(isset($Marca)){        $x3  = $Marca;        }else{$x3  = '';}
				if(isset($Modelo)){       $x4  = $Modelo;       }else{$x4  = '';}
				if(isset($Patente)){      $x5  = $Patente;      }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_select('Tipo de Vehiculo','idTipo', $x2, 2, 'idTipo', 'Nombre', 'vehiculos_tipo', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 2);
				$Form_Inputs->form_input_text('Modelo', 'Modelo', $x4, 2);
				$Form_Inputs->form_input_text('Patente', 'Patente', $x5, 2);
				
				
		
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idOpciones_1', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_2', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_3', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_4', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_5', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_6', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_7', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_8', 2, 2);
				$Form_Inputs->form_input_hidden('idProceso', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
/**********************************************************/
//paginador de resultados
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'nombre_asc':    $order_by = 'vehiculos_listado.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':   $order_by = 'vehiculos_listado.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'marca_asc':     $order_by = 'vehiculos_listado.Marca ASC ';                   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Marca Ascendente';break;
		case 'marca_desc':    $order_by = 'vehiculos_listado.Marca DESC ';                  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Marca Descendente';break;
		case 'modelo_asc':    $order_by = 'vehiculos_listado.Modelo ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Modelo Ascendente';break;
		case 'modelo_desc':   $order_by = 'vehiculos_listado.Modelo DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Modelo Descendente';break;
		case 'tipo_asc':      $order_by = 'vehiculos_tipo.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
		case 'tipo_desc':     $order_by = 'vehiculos_tipo.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'estado_asc':    $order_by = 'core_estados.Nombre ASC ';                       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':   $order_by = 'core_estados.Nombre DESC ';                      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'proceso_asc':   $order_by = 'core_estado_aprobacion_vehiculos.Nombre ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Proceso Ascendente';break;
		case 'proceso_desc':  $order_by = 'core_estado_aprobacion_vehiculos.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Proceso Descendente';break;

		default: $order_by = 'vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "vehiculos_listado.idVehiculo!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND vehiculos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){ $SIS_where .= " AND vehiculos_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){ $SIS_where .= " AND vehiculos_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['Marca']) && $_GET['Marca']!=''){   $SIS_where .= " AND vehiculos_listado.Marca LIKE '%".EstandarizarInput($_GET['Marca'])."%'";}
if(isset($_GET['Modelo']) && $_GET['Modelo']!=''){ $SIS_where .= " AND vehiculos_listado.Modelo LIKE '%".EstandarizarInput($_GET['Modelo'])."%'";}
if(isset($_GET['Patente']) && $_GET['Patente']!=''){      $SIS_where .= " AND vehiculos_listado.Patente LIKE '%".EstandarizarInput($_GET['Patente'])."%'";}
if(isset($_GET['idProceso']) && $_GET['idProceso']!=''){  $SIS_where .= " AND vehiculos_listado.idProceso=".$_GET['idProceso'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idVehiculo', 'vehiculos_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
vehiculos_listado.idVehiculo,
vehiculos_listado.Nombre,
vehiculos_listado.Marca, 
vehiculos_listado.Modelo,
vehiculos_tipo.Nombre AS Tipo,
core_sistemas.Nombre AS RazonSocial,
core_estados.Nombre AS Estado,
vehiculos_listado.idEstado,
core_estado_aprobacion_vehiculos.Nombre AS Proceso';
$SIS_join  = '
LEFT JOIN `vehiculos_tipo`                     ON vehiculos_tipo.idTipo                       = vehiculos_listado.idTipo
LEFT JOIN `core_sistemas`                      ON core_sistemas.idSistema                     = vehiculos_listado.idSistema
LEFT JOIN `core_estados`                       ON core_estados.idEstado                       = vehiculos_listado.idEstado
LEFT JOIN `core_estado_aprobacion_vehiculos`   ON core_estado_aprobacion_vehiculos.idProceso  = vehiculos_listado.idProceso';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTrabajador = array();
$arrTrabajador = db_select_array (false, $SIS_query, 'vehiculos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTrabajador');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Vehiculo</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){       $x1  = $Nombre;       }else{$x1  = '';}
				if(isset($idTipo)){       $x2  = $idTipo;       }else{$x2  = '';}
				if(isset($Marca)){        $x3  = $Marca;        }else{$x3  = '';}
				if(isset($Modelo)){       $x4  = $Modelo;       }else{$x4  = '';}
				if(isset($Patente)){      $x5  = $Patente;      }else{$x5  = '';}
				if(isset($idProceso)){    $x6  = $idProceso;    }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
				$Form_Inputs->form_select('Tipo de Vehiculo','idTipo', $x2, 1, 'idTipo', 'Nombre', 'vehiculos_tipo', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 1);
				$Form_Inputs->form_input_text('Modelo', 'Modelo', $x4, 1);
				$Form_Inputs->form_input_text('Patente', 'Patente', $x5, 1);
				$Form_Inputs->form_select('Proceso','idProceso', $x6, 1, 'idProceso', 'Nombre', 'core_estado_aprobacion_vehiculos', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('pagina', 1, 1);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>

			</form>
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div>

                       
                                 
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Vehiculos</h5>
			<div class="toolbar">
				<?php
				//Se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Marca</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=marca_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=marca_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Modelo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=modelo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=modelo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Proceso</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=proceso_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=proceso_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrTrabajador as $trab) { ?>
					<tr class="odd">
						<td><?php echo $trab['Nombre']; ?></td>
						<td><?php echo $trab['Marca']; ?></td>
						<td><?php echo $trab['Modelo']; ?></td>
						<td><?php echo $trab['Tipo']; ?></td>
						<td><label class="label <?php if(isset($trab['idEstado'])&&$trab['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $trab['Estado']; ?></label></td>
						<td><?php echo $trab['Proceso']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $trab['RazonSocial']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_vehiculos.php?view='.simpleEncode($trab['idVehiculo'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$trab['idVehiculo']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($trab['idVehiculo'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el trabajador '.$trab['Nombre'].' '.$trab['Marca'].' '.$trab['Modelo'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php
			//se llama al paginador
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
