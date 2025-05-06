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
$new_location = "vehiculos_listado_estado.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Si el estado esta distinto de vacio
if (!empty($_GET['estado'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'estado';
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
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Estado cambiado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = '
vehiculos_listado.idVehiculo,
vehiculos_listado.Nombre,
vehiculos_listado.Patente,
vehiculos_listado.idOpciones_1,
vehiculos_listado.idOpciones_2,
vehiculos_listado.idOpciones_3,
vehiculos_listado.idOpciones_4,
vehiculos_listado.idOpciones_5,
vehiculos_listado.idOpciones_6, 
vehiculos_listado.idOpciones_7,
vehiculos_listado.idOpciones_8,
vehiculos_listado.idEstado,
core_estados.Nombre AS Estado';
$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = vehiculos_listado.idEstado';
$SIS_where = 'idVehiculo ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'vehiculos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
$SIS_query = '
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_1.'" AND visualizacion!=9999 LIMIT 1) AS tran_1,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_2.'" AND visualizacion!=9999 LIMIT 1) AS tran_2,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_3.'" AND visualizacion!=9999 LIMIT 1) AS tran_3,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_4.'" AND visualizacion!=9999 LIMIT 1) AS tran_4,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_5.'" AND visualizacion!=9999 LIMIT 1) AS tran_5,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_6.'" AND visualizacion!=9999 LIMIT 1) AS tran_6,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_7.'" AND visualizacion!=9999 LIMIT 1) AS tran_7,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_8.'" AND visualizacion!=9999 LIMIT 1) AS tran_8,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_9.'" AND visualizacion!=9999 LIMIT 1) AS tran_9,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_10.'" AND visualizacion!=9999 LIMIT 1) AS tran_10,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_11.'" AND visualizacion!=9999 LIMIT 1) AS tran_11,
(SELECT COUNT(visualizacion) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_12.'" AND visualizacion!=9999 LIMIT 1) AS tran_12';
$SIS_join  = '';
$SIS_where = 'usuarios_listado.idUsuario='.$_GET['id'];
$rowDatax = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowDatax');


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
	echo widget_title('bg-aqua', 'fa-cog', 100, 'Vehiculo', $vehiculo, 'Editar Estado'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'vehiculos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
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
						<li class="active"><a href="<?php echo 'vehiculos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-picture-o" aria-hidden="true"></i>  Foto</a></li>
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
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd">
						<td><?php echo 'Vehiculo '.$rowData['Estado']; ?></td>
						<td>
							<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
								<?php if ($rowlevel['level']>=2){ ?>
									<?php if ( $rowData['idEstado']==1 ){ ?>
										<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$rowData['idVehiculo'].'&estado='.simpleEncode(2, fecha_actual()) ; ?>">OFF</a>
										<a class="btn btn-sm btn-info locked_active" href="#">ON</a>
									<?php } else { ?>
										<a class="btn btn-sm btn-info locked_active" href="#">OFF</a>
										<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$rowData['idVehiculo'].'&estado='.simpleEncode(1, fecha_actual()) ; ?>">ON</a>
									<?php } ?>
								<?php } ?>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
