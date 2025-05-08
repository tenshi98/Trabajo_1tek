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
/*                                          Modulo de identificacion del documento                                                */
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
//Cargamos la ubicacion original
$original = "view_crosscrane_apagado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$X_Puntero;
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Si el estado esta distinto de vacio
if (!empty($_GET['idEstadoEncendido'])){
	//Llamamos al formulario
	$form_trabajo= 'EstadoEncendido';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
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

/**************************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Direccion_img,
telemetria_listado.Nombre,
telemetria_listado.IdentificadorEmpresa,
telemetria_listado.Sim_Num_Tel,
telemetria_listado.Sim_Num_Serie,
telemetria_listado.Sim_Compania,
telemetria_listado.Sim_marca,
telemetria_listado.Sim_modelo,
telemetria_listado.IP_Client,
telemetria_listado.Identificador,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
core_estados.Nombre AS Estado,
telemetria_listado.idEstadoEncendido,
core_estado_encendido.Nombre AS EstadoEncendido';
$SIS_join  = '
LEFT JOIN `core_estados`           ON core_estados.idEstado                    = telemetria_listado.idEstado
LEFT JOIN `core_estado_encendido`  ON core_estado_encendido.idEstadoEncendido  = telemetria_listado.idEstadoEncendido';
$SIS_where = 'telemetria_listado.idTelemetria ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo</h5>
		</header>
        <div class="tab-content">
			<div class="wmd-panel">

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<?php if ($rowData['Direccion_img']=='') { ?>
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/maquina.jpg">
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
						<strong>Identificador : </strong><?php echo $rowData['Identificador']; ?><br/>
						<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>
						<strong>Ultima Conexion : </strong><?php echo fecha_estandar($rowData['LastUpdateFecha']).' a las '.$rowData['LastUpdateHora']; ?><br/>
					</p>

					<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Cambiar Estado</h2>
					<?php
					alert_post_data(2,1,1,0, '<strong>AVISO</strong>: Estás apunto de apagar una grúa <strong>manualmente</strong>. 
					Crosstech no se hace responsable por el uso indebido de esta opción o por daños 
					provocados al equipamiento. Sólo usuarios autorizados por '.$_SESSION['usuario']['basic_data']['RazonSocial'].' 
					pueden ejecutar esta acción, quedando registro de éste.');
			
					
					?>

					<table  class="table table-bordered">
						<tr class="item-row">
							<td><label class="label <?php if(isset($rowData['idEstadoEncendido'])&&$rowData['idEstadoEncendido']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $rowData['EstadoEncendido']; ?></label></td>
							<td width="10">
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php if ( $rowData['idEstadoEncendido']==1 ){ ?>   
										<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $location.'&idTelemetria='.$rowData['idTelemetria'].'&idEstadoEncendido=2' ; ?>">OFF</a>
										<a class="btn btn-sm btn-info locked_active" href="#">ON</a>
									<?php } else { ?>
										<a class="btn btn-sm btn-info locked_active" href="#">OFF</a>
										<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $location.'&idTelemetria='.$rowData['idTelemetria'].'&idEstadoEncendido=1' ; ?>">ON</a>
									<?php } ?>
								</div>
							</td>
						</tr>
					</table>

				</div>
				<div class="clearfix"></div>

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
