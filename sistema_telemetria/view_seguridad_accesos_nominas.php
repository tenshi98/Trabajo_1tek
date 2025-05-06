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
seguridad_accesos_nominas.FechaProgramada,
seguridad_accesos_nominas.HoraInicioProgramada,
seguridad_accesos_nominas.HoraTerminoProgramada,
core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,
seguridad_accesos_nominas.PersonaReunion,
core_estado_caja.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `usuarios_listado`            ON usuarios_listado.idUsuario            = seguridad_accesos_nominas.idUsuario
LEFT JOIN `core_sistemas`               ON core_sistemas.idSistema               = seguridad_accesos_nominas.idSistema
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = seguridad_accesos_nominas.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = seguridad_accesos_nominas.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = seguridad_accesos_nominas.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = seguridad_accesos_nominas.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = seguridad_accesos_nominas.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = seguridad_accesos_nominas.idUbicacion_lvl_5
LEFT JOIN `core_estado_caja`            ON core_estado_caja.idEstado             = seguridad_accesos_nominas.idEstado';
$SIS_where = 'seguridad_accesos_nominas.idAcceso ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'seguridad_accesos_nominas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
seguridad_accesos_nominas_listado.Fecha, 
seguridad_accesos_nominas_listado.HoraEntrada, 
seguridad_accesos_nominas_listado.HoraSalida, 
seguridad_accesos_nominas_listado.Nombre,
seguridad_accesos_nominas_listado.Rut, 
seguridad_accesos_nominas_listado.NDocCedula,
core_estado_nomina_asistencia.Nombre AS Estado';
$SIS_join  = 'LEFT JOIN `core_estado_nomina_asistencia` ON core_estado_nomina_asistencia.idEstado = seguridad_accesos_nominas_listado.idEstado';
$SIS_where = 'seguridad_accesos_nominas_listado.idAcceso ='.$X_Puntero;
$SIS_order = 'seguridad_accesos_nominas_listado.Fecha ASC';
$arrPersonas = array();
$arrPersonas = db_select_array (false, $SIS_query, 'seguridad_accesos_nominas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPersonas');

/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idAcceso ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'seguridad_accesos_nominas_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Nomina de Control de Accesos.
				<small class="pull-right">Nomina N°: <?php echo n_doc($X_Puntero, 8) ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Datos Básicos
			<address>
				<strong>Usuario:</strong> <?php echo $rowData['Usuario']; ?><br/>
				<strong>Sistema:</strong> <?php echo $rowData['Sistema']; ?><br/>
				<strong>Ubicación:</strong> <?php echo $rowData['Ubicacion'];
				if(isset($rowData['UbicacionLVL_1'])&&$rowData['UbicacionLVL_1']!=''){echo ' - '.$rowData['UbicacionLVL_1'];}
				if(isset($rowData['UbicacionLVL_2'])&&$rowData['UbicacionLVL_2']!=''){echo ' - '.$rowData['UbicacionLVL_2'];}
				if(isset($rowData['UbicacionLVL_3'])&&$rowData['UbicacionLVL_3']!=''){echo ' - '.$rowData['UbicacionLVL_3'];}
				if(isset($rowData['UbicacionLVL_4'])&&$rowData['UbicacionLVL_4']!=''){echo ' - '.$rowData['UbicacionLVL_4'];}
				if(isset($rowData['UbicacionLVL_5'])&&$rowData['UbicacionLVL_5']!=''){echo ' - '.$rowData['UbicacionLVL_5'];}
				?>

				<br/>
				<strong>Persona Reunion:</strong> <?php echo $rowData['PersonaReunion']; ?><br/>
				<strong>Estado:</strong> <?php echo $rowData['Estado']; ?><br/>
			</address>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Programacion
			<address>
				<strong>Fecha:</strong> <?php echo Fecha_estandar($rowData['FechaProgramada']); ?><br/>
				<strong>Hora Inicio:</strong> <?php echo $rowData['HoraInicioProgramada']; ?><br/>
				<strong>Hora Termino:</strong> <?php echo $rowData['HoraTerminoProgramada']; ?><br/>
			</address>
		</div>

	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="6">Detalle</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrPersonas!=false && !empty($arrPersonas) && $arrPersonas!='') { ?>
						<?php foreach ($arrPersonas as $otro) { ?>
							<tr>
								<td><?php echo $otro['Nombre']; ?></td>
								<td><?php echo $otro['Rut']; ?></td>
								<td><?php echo $otro['NDocCedula']; ?></td>
								<td><?php echo Fecha_estandar($otro['Fecha']); ?></td>
								<td><?php echo $otro['HoraEntrada'].' - '.$otro['HoraSalida']; ?></td>
								<td><?php echo $otro['Estado']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php
	$zz  = '?idSistema='.simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual());
	$zz .= '&view='.$_GET['view'];
	?>
	<div class="row no-print">
		<br/>
		<div class="col-xs-12">
			<a target="new" href="view_seguridad_accesos_nominas_to_print.php<?php echo $zz ?>" class="btn btn-default">
				<i class="fa fa-print" aria-hidden="true"></i> Imprimir
			</a>

			<a target="new" href="view_seguridad_accesos_nominas_to_pdf.php<?php echo $zz ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
				<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF
			</a>
		</div>
	</div>
      
</section>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">

	<?php if ($arrArchivo!=false && !empty($arrArchivo) && $arrArchivo!=''){ ?>
		<table id="items" style="margin-bottom: 20px;">
			<tbody>
				<tr>
					<th colspan="6">Archivos Adjuntos</th>
				</tr>
				<?php foreach ($arrArchivo as $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $producto['Nombre']; ?></td>
						<td width="160">
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="1download.php?dir=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip" ><i class="fa fa-download" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
    
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
