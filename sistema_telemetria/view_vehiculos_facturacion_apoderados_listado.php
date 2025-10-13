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
//Se traen todos los datos
$SIS_query = '
vehiculos_facturacion_apoderados_listado.idFacturacion,
vehiculos_facturacion_apoderados_listado.Fecha,
vehiculos_facturacion_apoderados_listado.Observaciones,
vehiculos_facturacion_apoderados_listado.fCreacion,
vehiculos_facturacion_apoderados_listado.idMes,
vehiculos_facturacion_apoderados_listado.Ano,

usuarios_listado.Nombre AS UsuarioNombre,

core_sistemas.Nombre AS SistemaNombre,
core_sistemas.Rut AS SistemaRut,
core_sistemas.Direccion AS SistemaDireccion,
siscom.Nombre AS SistemaComuna,
sisciu.Nombre AS SistemaCiudad,
core_sistemas.Contacto_Fono1 AS SistemaFono1,
core_sistemas.Contacto_Fono2 AS SistemaFono2';
$SIS_join  = '
LEFT JOIN `core_sistemas`                       ON core_sistemas.idSistema              = vehiculos_facturacion_apoderados_listado.idSistema
LEFT JOIN `core_ubicacion_comunas`   siscom     ON siscom.idComuna                      = core_sistemas.idComuna
LEFT JOIN `core_ubicacion_ciudad`    sisciu     ON sisciu.idCiudad                      = core_sistemas.idCiudad
LEFT JOIN `usuarios_listado`                    ON usuarios_listado.idUsuario           = vehiculos_facturacion_apoderados_listado.idUsuario';
$SIS_where = 'vehiculos_facturacion_apoderados_listado.idFacturacion ='.$X_Puntero;
$rowDatos = db_select_data (false, $SIS_query, 'vehiculos_facturacion_apoderados_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowDatos');

// Se trae un listado con todos los elementos
$SIS_query = '
apoderados_listado.Nombre AS ApoderadoNombre,
apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,
vehiculos_facturacion_apoderados_listado_detalle.MontoPactado AS Monto,
sistema_planes_transporte.Nombre AS Plan,
vehiculos_facturacion_apoderados_listado_detalle.idEstadoPago,
core_estado_facturacion.Nombre AS EstadoPago,
sistema_documentos_pago.Nombre AS DocumentoPago,
vehiculos_facturacion_apoderados_listado_detalle.nDocPago AS DocumentoNumero,
vehiculos_facturacion_apoderados_listado_detalle.Pagofecha AS DocumentoFecha';
$SIS_join  = '
LEFT JOIN `apoderados_listado`         ON apoderados_listado.idApoderado      = vehiculos_facturacion_apoderados_listado_detalle.idApoderado
LEFT JOIN `sistema_planes_transporte`  ON sistema_planes_transporte.idPlan    = vehiculos_facturacion_apoderados_listado_detalle.idPlan
LEFT JOIN `core_estado_facturacion`    ON core_estado_facturacion.idEstado    = vehiculos_facturacion_apoderados_listado_detalle.idEstadoPago
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago   = vehiculos_facturacion_apoderados_listado_detalle.idDocPago';
$SIS_where = 'vehiculos_facturacion_apoderados_listado_detalle.idFacturacion ='.$X_Puntero;
$SIS_order = 'apoderados_listado.ApellidoPat ASC';
$arrDetalle = array();
$arrDetalle = db_select_array (false, $SIS_query, 'vehiculos_facturacion_apoderados_listado_detalle', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDetalle');

?>

<div class="col-xs-12">

	<div class="row">
		<div class="invoice">
			<div class="row">
				<div class="col-xs-12 text-right">
					<h1>Documento <small><?php echo N_Doc($rowDatos['idFacturacion'], 7) ?></small></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4><?php echo $rowDatos['SistemaNombre']?></h4>
						</div>
						<div class="panel-body">
							<p>
								<?php 
								if(isset($rowDatos['SistemaRut'])&&$rowDatos['SistemaRut']!=''){         echo 'R.U.T.: '.$rowDatos['SistemaRut'].'<br/>';}
								if(isset($rowDatos['SistemaDireccion'])&&$rowDatos['SistemaDireccion']!=''){    echo $rowDatos['SistemaDireccion'].' '.$rowDatos['SistemaComuna'].' '.$rowDatos['SistemaCiudad'].'<br/>';}
								if(isset($rowDatos['SistemaFono1'])&&$rowDatos['SistemaFono1']!=''){     echo 'Telefono Fijo: '.formatPhone($rowDatos['SistemaFono1']).'<br/>';}
								if(isset($rowDatos['SistemaFono2'])&&$rowDatos['SistemaFono2']!=''){     echo 'Celular: '.formatPhone($rowDatos['SistemaFono2']).'<br/>';}
								
								?>
							</p>
						</div>
					</div>
				</div>
				<div class="col-xs-6 ">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>
								Datos de Creacion 
							</h4>
						</div>
						<div class="panel-body">
							<p>
								<?php 
								echo 'Creador: '.$rowDatos['UsuarioNombre'].'<br/>';
								echo 'Fecha Creacion: '.fecha_estandar($rowDatos['fCreacion']).'<br/>';
								echo 'Fecha Ingreso: '.fecha_estandar($rowDatos['Fecha']).'<br/>';
								echo 'Mes Facturacion: '.numero_a_mes($rowDatos['idMes']).'<br/>';
								echo 'Año Facturacion: '.$rowDatos['Ano'].'<br/>';
								?>
							</p>
						</div>
					</div>
				</div>
			</div>
			<!-- / end client details section -->
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Apoderado</th>
						<th>Plan</th>
						<th>Estado</th>
						<th width="100px" align="right">Monto</th>
					</tr>
				</thead>
				<tbody>

					<?php
					//Variables
					$t_total = 0;
					//recorro
					foreach ($arrDetalle as $det) { ?>
						<tr>
							<td><?php echo $det['ApoderadoNombre'].' '.$det['ApoderadoApellidoPat'].' '.$det['ApoderadoApellidoMat']; ?></td>
							<td><?php echo $det['Plan']; ?></td>
							<td>
								<?php echo $det['EstadoPago'];
								//si esta pagado
								if(isset($det['idEstadoPago'])&&$det['idEstadoPago']==2){
									echo ' (Documento Pago '.$det['DocumentoPago'].' N°'.$det['DocumentoNumero'].', fecha '.fecha_estandar($det['DocumentoFecha']).')';
								} ?>
							</td>
							<td align="right"><?php echo Valores($det['Monto'], 0);$t_total=$t_total+$det['Monto']; ?></td>
						</tr>

					<?php } ?>
		
								

	
					<tr>
						<td colspan="3"><strong>Total</strong></td>
						<td align="right"><strong><?php echo Valores($t_total, 0); ?></strong></td>
					</tr>

				</tbody>
			</table>
		
			
			
			<div class="col-xs-12">
				<div class="row">
					<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
					<p class="text-muted well well-sm no-shadow" ><?php echo $rowDatos['Observaciones']; ?></p>
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
