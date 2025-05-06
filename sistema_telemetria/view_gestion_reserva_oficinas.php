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
gestion_reserva_oficinas.idReserva,
gestion_reserva_oficinas.Fecha,
gestion_reserva_oficinas.Hora_Inicio,
gestion_reserva_oficinas.Hora_Termino,
gestion_reserva_oficinas.Solicitante,
gestion_reserva_oficinas.CantidadAsistentes,
gestion_reserva_oficinas.Observaciones,

core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
core_estados.Nombre AS estado,
gestion_reserva_oficinas.idEstado,
core_sistemas_opciones.Nombre AS Cafeteria,
oficinas_listado.Nombre AS Oficina';
$SIS_join  = '
LEFT JOIN `core_sistemas`            ON core_sistemas.idSistema             = gestion_reserva_oficinas.idSistema
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario          = gestion_reserva_oficinas.idUsuario
LEFT JOIN `core_estados`             ON core_estados.idEstado               = gestion_reserva_oficinas.idEstado
LEFT JOIN `core_sistemas_opciones`   ON core_sistemas_opciones.idOpciones   = gestion_reserva_oficinas.idServicioCafeteria
LEFT JOIN `oficinas_listado`         ON oficinas_listado.idOficina          = gestion_reserva_oficinas.idOficina';
$SIS_where = 'gestion_reserva_oficinas.idReserva ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'gestion_reserva_oficinas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Reserva de Oficina.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['Fecha']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php				
		echo '
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Datos Reserva
			<address>
				<strong>Usuario: </strong>'.$rowData['Usuario'].'<br/>
				<strong>Solicitante: </strong>'.$rowData['Solicitante'].'<br/>
				<strong>Sala de Reuniones: </strong>'.$rowData['Oficina'].'<br/>
				<strong>Fecha: </strong>'.fecha_estandar($rowData['Fecha']).'<br/>
				<strong>Horas: </strong>'.$rowData['Hora_Inicio'].' - '.$rowData['Hora_Termino'].'<br/>
				<strong>Cantidad Asistentes: </strong>'.$rowData['CantidadAsistentes'].' personas<br/>
			</address>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Otros Datos
			<address>
				<strong>Servicio de Cafeteria: </strong>'.$rowData['Cafeteria'].'<br/>
				<strong>Estado: </strong>'.$rowData['estado'].'<br/>
				<strong>Sistema: </strong>'.$rowData['Sistema'].'<br/>
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
