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
orden_trabajo_tareas_quejas.idOT,
core_sistemas.Nombre AS sistema,
usuarios_listado.Nombre AS Usuario,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
orden_trabajo_tareas_quejas.NombreQueja,
usuario_queja.Nombre AS UsuarioQueja,
core_tipo_queja.Nombre AS TipoQueja,
orden_trabajo_tareas_quejas.FechaQueja,
orden_trabajo_tareas_quejas.Observaciones';
$SIS_join  = '
LEFT JOIN `core_sistemas`                   ON core_sistemas.idSistema              = orden_trabajo_tareas_quejas.idSistema
LEFT JOIN `usuarios_listado`                ON usuarios_listado.idUsuario           = orden_trabajo_tareas_quejas.idUsuario
LEFT JOIN `trabajadores_listado`            ON trabajadores_listado.idTrabajador    = orden_trabajo_tareas_quejas.idTrabajadorQueja
LEFT JOIN `usuarios_listado` usuario_queja  ON usuario_queja.idUsuario              = orden_trabajo_tareas_quejas.idUsuarioQueja
LEFT JOIN `core_tipo_queja`                 ON core_tipo_queja.idTipoQueja          = orden_trabajo_tareas_quejas.idTipoQueja';
$SIS_where = 'orden_trabajo_tareas_quejas.idQueja ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_quejas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Quejas de Ordenes de Trabajo.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['FechaQueja']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php				
		echo '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 invoice-col">
			Datos de la queja
			<address>
				<strong>Usuario: </strong>'.$rowData['Usuario'].'<br/>
				<strong>Orden Trabajo Relacionada: </strong>'.n_doc($rowData['idOT'], 8).'<br/>
				<strong>Fecha Queja: </strong>'.fecha_estandar($rowData['FechaQueja']).'<br/>
				<strong>Usuario Queja: </strong>'.$rowData['UsuarioQueja'].'<br/>
				<strong>Trabajador Queja: </strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat'].'<br/>
				<strong>Persona Queja: </strong>'.$rowData['NombreQueja'].'<br/>
				<strong>Tipo Queja: </strong>'.$rowData['TipoQueja'].'<br/>
			</address>
		</div>';
		?>

	</div>

	<?php if(isset($rowData['Observaciones'])&&$rowData['Observaciones']!=''){ ?>
		<div class="col-xs-12">
			<div class="row">
				<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
			</div>
		</div>
	<?php } ?>
	

      
</section>

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
