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
gestion_tickets.idTicket,
gestion_tickets.Titulo,
gestion_tickets.FechaCreacion,
gestion_tickets.FechaCierre,
gestion_tickets.FechaCancelacion,
gestion_tickets.Descripcion,
gestion_tickets.DescripcionCierre,
gestion_tickets.DescripcionCancelacion,

core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
core_tipo_ticket.Nombre AS TipoTicket,
core_estado_ticket.Nombre AS EstadoTicket,
core_ot_prioridad.Nombre AS PrioridadTicket,
usuario_asignado.Nombre AS UsuarioAsignado,
gestion_tickets_area.Nombre AS AreaTicket';
$SIS_join  = '
LEFT JOIN `core_sistemas`                         ON core_sistemas.idSistema               = gestion_tickets.idSistema
LEFT JOIN `usuarios_listado`                      ON usuarios_listado.idUsuario            = gestion_tickets.idUsuario
LEFT JOIN `core_tipo_ticket`                      ON core_tipo_ticket.idTipoTicket         = gestion_tickets.idTipoTicket
LEFT JOIN `core_estado_ticket`                    ON core_estado_ticket.idEstado           = gestion_tickets.idEstado
LEFT JOIN `core_ot_prioridad`                     ON core_ot_prioridad.idPrioridad         = gestion_tickets.idPrioridad
LEFT JOIN `usuarios_listado`  usuario_asignado    ON usuario_asignado.idUsuario            = gestion_tickets.idUsuarioAsignado
LEFT JOIN `gestion_tickets_area`                  ON gestion_tickets_area.idArea           = gestion_tickets.idArea';
$SIS_where = 'gestion_tickets.idTicket ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'gestion_tickets', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"> <?php echo $rowData['Titulo']; ?></i>.
				<small class="pull-right">Ticket N°<?php echo n_doc($rowData['idTicket'], 8); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Datos del Ticket
			<address>
				<strong>Estado Ticket: </strong><?php echo $rowData['EstadoTicket']; ?><br/>
				<strong>Area Ticket: </strong><?php echo $rowData['AreaTicket']; ?><br/>
				<strong>Tipo Ticket: </strong><?php echo $rowData['TipoTicket']; ?><br/>
				<strong>Prioridad Ticket: </strong><?php echo $rowData['PrioridadTicket']; ?><br/>
			</address>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Usuarios
			<address>
				<strong>Usuario Creacion: </strong><?php echo $rowData['Usuario']; ?><br/>
				<strong>Usuario Asignado: </strong><?php echo $rowData['UsuarioAsignado']; ?><br/>
			</address>
		</div>

	</div>
	

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Problema (<?php echo fecha_estandar($rowData['FechaCreacion']); ?>)</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Descripcion']; ?></p>
		</div>
	</div>

	<?php if(isset($rowData['FechaCierre'])&&$rowData['FechaCierre']!='0000-00-00'){ ?>
		<div class="col-xs-12">
			<div class="row">
				<p class="lead"><a name="Ancla_obs"></a>Solucion (<?php echo fecha_estandar($rowData['FechaCierre']); ?>)</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['DescripcionCierre']; ?></p>
			</div>
		</div>
	<?php } ?>

	<?php if(isset($rowData['FechaCancelacion'])&&$rowData['FechaCancelacion']!='0000-00-00'){ ?>
		<div class="col-xs-12">
			<div class="row">
				<p class="lead"><a name="Ancla_obs"></a>Solucion (<?php echo fecha_estandar($rowData['FechaCancelacion']); ?>)</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['DescripcionCancelacion']; ?></p>
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
