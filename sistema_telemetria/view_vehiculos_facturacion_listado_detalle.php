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
vehiculos_facturacion_listado_detalle.idFacturacionDetalle,

hijo_1.Nombre AS Hijo_1_Nombre,
hijo_1.ApellidoPat AS Hijo_1_ApellidoPat,
hijo_1.ApellidoMat AS Hijo_1_ApellidoMat,
hijo_2.Nombre AS Hijo_2_Nombre,
hijo_2.ApellidoPat AS Hijo_2_ApellidoPat,
hijo_2.ApellidoMat AS Hijo_2_ApellidoMat,
hijo_3.Nombre AS Hijo_3_Nombre,
hijo_3.ApellidoPat AS Hijo_3_ApellidoPat,
hijo_3.ApellidoMat AS Hijo_3_ApellidoMat,
hijo_4.Nombre AS Hijo_4_Nombre,
hijo_4.ApellidoPat AS Hijo_4_ApellidoPat,
hijo_4.ApellidoMat AS Hijo_4_ApellidoMat,
hijo_5.Nombre AS Hijo_5_Nombre,
hijo_5.ApellidoPat AS Hijo_5_ApellidoPat,
hijo_5.ApellidoMat AS Hijo_5_ApellidoMat,

vehiculo_1.Nombre AS Vehiculo_1_Nombre,
vehiculo_1.Patente AS Vehiculo_1_Patente,
vehiculo_2.Nombre AS Vehiculo_2_Nombre,
vehiculo_2.Patente AS Vehiculo_2_Patente,
vehiculo_3.Nombre AS Vehiculo_3_Nombre,
vehiculo_3.Patente AS Vehiculo_3_Patente,
vehiculo_4.Nombre AS Vehiculo_4_Nombre,
vehiculo_4.Patente AS Vehiculo_4_Patente,
vehiculo_5.Nombre AS Vehiculo_5_Nombre,
vehiculo_5.Patente AS Vehiculo_5_Patente,

core_sistemas.Nombre AS SistemaNombre,
core_sistemas.Rut AS SistemaRut,
core_sistemas.Direccion AS SistemaDireccion,
siscom.Nombre AS SistemaComuna,
sisciu.Nombre AS SistemaCiudad,
core_sistemas.Contacto_Fono1 AS SistemaFono1,
core_sistemas.Contacto_Fono2 AS SistemaFono2,

apoderados_listado.Nombre AS ApoderadoNombre,
apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,
apocom.Nombre AS ApoderadoComuna,
apociu.Nombre AS ApoderadoCiudad,
apoderados_listado.Direccion AS ApoderadoDireccion,
apoderados_listado.Fono1 AS ApoderadoFono1,
apoderados_listado.Fono2 AS ApoderadoFono2,
apoderados_listado.Rut AS ApoderadoRut,

vehiculos_facturacion_listado_detalle.Fecha, 
vehiculos_facturacion_listado_detalle.fCreacion,
vehiculos_facturacion_listado_detalle.Monto_1,
vehiculos_facturacion_listado_detalle.Monto_2,
vehiculos_facturacion_listado_detalle.Monto_3,
vehiculos_facturacion_listado_detalle.Monto_4,
vehiculos_facturacion_listado_detalle.Monto_5,
vehiculos_facturacion_listado_detalle.MontoSubTotal,
vehiculos_facturacion_listado_detalle.MontoAtraso,
vehiculos_facturacion_listado_detalle.MontoAdelanto,
vehiculos_facturacion_listado_detalle.MontoTotal';
$SIS_join  = '
LEFT JOIN `apoderados_listado_hijos`  hijo_1    ON hijo_1.idHijos                       = vehiculos_facturacion_listado_detalle.idHijos_1
LEFT JOIN `apoderados_listado_hijos`  hijo_2    ON hijo_2.idHijos                       = vehiculos_facturacion_listado_detalle.idHijos_2
LEFT JOIN `apoderados_listado_hijos`  hijo_3    ON hijo_3.idHijos                       = vehiculos_facturacion_listado_detalle.idHijos_3
LEFT JOIN `apoderados_listado_hijos`  hijo_4    ON hijo_4.idHijos                       = vehiculos_facturacion_listado_detalle.idHijos_4
LEFT JOIN `apoderados_listado_hijos`  hijo_5    ON hijo_5.idHijos                       = vehiculos_facturacion_listado_detalle.idHijos_5
LEFT JOIN `vehiculos_listado`   vehiculo_1      ON vehiculo_1.idVehiculo                = vehiculos_facturacion_listado_detalle.idVehiculo_1
LEFT JOIN `vehiculos_listado`   vehiculo_2      ON vehiculo_2.idVehiculo                = vehiculos_facturacion_listado_detalle.idVehiculo_2
LEFT JOIN `vehiculos_listado`   vehiculo_3      ON vehiculo_3.idVehiculo                = vehiculos_facturacion_listado_detalle.idVehiculo_3
LEFT JOIN `vehiculos_listado`   vehiculo_4      ON vehiculo_4.idVehiculo                = vehiculos_facturacion_listado_detalle.idVehiculo_4
LEFT JOIN `vehiculos_listado`   vehiculo_5      ON vehiculo_5.idVehiculo                = vehiculos_facturacion_listado_detalle.idVehiculo_5
LEFT JOIN `apoderados_listado`                  ON apoderados_listado.idApoderado       = vehiculos_facturacion_listado_detalle.idApoderado
LEFT JOIN `core_sistemas`                       ON core_sistemas.idSistema              = vehiculos_facturacion_listado_detalle.idSistema
LEFT JOIN `core_ubicacion_comunas`   siscom     ON siscom.idComuna                      = core_sistemas.idComuna
LEFT JOIN `core_ubicacion_ciudad`    sisciu     ON sisciu.idCiudad                      = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`   apocom     ON apocom.idComuna                      = apoderados_listado.idComuna
LEFT JOIN `core_ubicacion_ciudad`    apociu     ON apociu.idCiudad                      = apoderados_listado.idCiudad';
$SIS_where = 'vehiculos_facturacion_listado_detalle.idFacturacionDetalle ='.$X_Puntero;
$rowDatos = db_select_data (false, $SIS_query, 'vehiculos_facturacion_listado_detalle', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowDatos');

?>

<div class="col-xs-12">

	<div class="row no-print">
		<div class="col-xs-12">
			<a target="new" href="view_facturacion_to_print_1.php?view=<?php echo $X_Puntero; ?>" class="btn btn-default pull-right" style="margin-right: 5px;"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>

		</div>
	</div>

	<div class="row">
		<div class="invoice">
			<div class="row">
				<div class="col-xs-12 text-right">
					<h1>Documento <small><?php echo N_Doc($rowDatos['idFacturacionDetalle'], 7) ?></small></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4><a href="#"><?php echo $rowDatos['SistemaNombre']?></a></h4>
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
								<?php 
								if(isset($rowDatos['ApoderadoNombre'])&&$rowDatos['ApoderadoNombre']!=''){echo $rowDatos['ApoderadoNombre'];}
								if(isset($rowDatos['ApoderadoApellidoPat'])&&$rowDatos['ApoderadoApellidoPat']!=''){echo ' '.$rowDatos['ApoderadoApellidoPat'];}
								if(isset($rowDatos['ApoderadoApellidoMat'])&&$rowDatos['ApoderadoApellidoMat']!=''){echo ' '.$rowDatos['ApoderadoApellidoMat'];}
								?>
							</h4>
						</div>
						<div class="panel-body">
							<p>
								<?php 
								if(isset($rowDatos['ApoderadoRut'])&&$rowDatos['ApoderadoRut']!=''){         echo 'R.U.T.: '.$rowDatos['ApoderadoRut'].'<br/>';}
								if(isset($rowDatos['ApoderadoDireccion'])&&$rowDatos['ApoderadoDireccion']!=''){    echo $rowDatos['ApoderadoDireccion'].' '.$rowDatos['ApoderadoComuna'].' '.$rowDatos['ApoderadoCiudad'].'<br/>';}
								if(isset($rowDatos['ApoderadoFono1'])&&$rowDatos['ApoderadoFono1']!=''){     echo 'Telefono Fijo: '.formatPhone($rowDatos['ApoderadoFono1']).'<br/>';}
								if(isset($rowDatos['ApoderadoFono2'])&&$rowDatos['ApoderadoFono2']!=''){     echo 'Celular: '.formatPhone($rowDatos['ApoderadoFono2']).'<br/>';}
								
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
						<th><h4>Vehiculo</h4></th>
						<th><h4>Nombre</h4></th>
						<th width="100px" align="right"><h4>Total Item</h4></th>
					</tr>
				</thead>
				<tbody>

					<?php if(isset($rowDatos['Vehiculo_1_Nombre'])&&$rowDatos['Vehiculo_1_Nombre']!=''){ ?>
						<tr>
							<td><?php echo $rowDatos['Vehiculo_1_Nombre'].' Patente '.$rowDatos['Vehiculo_1_Patente']; ?></td>
							<td><?php echo $rowDatos['Hijo_1_Nombre'].' '.$rowDatos['Hijo_1_ApellidoPat'].' '.$rowDatos['Hijo_1_ApellidoMat']; ?></td>
							<td align="right"><?php echo Valores($rowDatos['Monto_1'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowDatos['Vehiculo_2_Nombre'])&&$rowDatos['Vehiculo_2_Nombre']!=''){ ?>
						<tr>
							<td><?php echo $rowDatos['Vehiculo_2_Nombre'].' Patente '.$rowDatos['Vehiculo_2_Patente']; ?></td>
							<td><?php echo $rowDatos['Hijo_2_Nombre'].' '.$rowDatos['Hijo_2_ApellidoPat'].' '.$rowDatos['Hijo_2_ApellidoMat']; ?></td>
							<td align="right"><?php echo Valores($rowDatos['Monto_2'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowDatos['Vehiculo_3_Nombre'])&&$rowDatos['Vehiculo_3_Nombre']!=''){ ?>
						<tr>
							<td><?php echo $rowDatos['Vehiculo_3_Nombre'].' Patente '.$rowDatos['Vehiculo_3_Patente']; ?></td>
							<td><?php echo $rowDatos['Hijo_3_Nombre'].' '.$rowDatos['Hijo_3_ApellidoPat'].' '.$rowDatos['Hijo_3_ApellidoMat']; ?></td>
							<td align="right"><?php echo Valores($rowDatos['Monto_3'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowDatos['Vehiculo_4_Nombre'])&&$rowDatos['Vehiculo_4_Nombre']!=''){ ?>
						<tr>
							<td><?php echo $rowDatos['Vehiculo_4_Nombre'].' Patente '.$rowDatos['Vehiculo_4_Patente']; ?></td>
							<td><?php echo $rowDatos['Hijo_4_Nombre'].' '.$rowDatos['Hijo_4_ApellidoPat'].' '.$rowDatos['Hijo_4_ApellidoMat']; ?></td>
							<td align="right"><?php echo Valores($rowDatos['Monto_4'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowDatos['Vehiculo_5_Nombre'])&&$rowDatos['Vehiculo_5_Nombre']!=''){ ?>
						<tr>
							<td><?php echo $rowDatos['Vehiculo_5_Nombre'].' Patente '.$rowDatos['Vehiculo_5_Patente']; ?></td>
							<td><?php echo $rowDatos['Hijo_5_Nombre'].' '.$rowDatos['Hijo_5_ApellidoPat'].' '.$rowDatos['Hijo_5_ApellidoMat']; ?></td>
							<td align="right"><?php echo Valores($rowDatos['Monto_5'], 0); ?></td>
						</tr>
					<?php } ?>

					<tr>
						<td colspan="2"><strong>Subtotal</strong></td>
						<td align="right"><strong><?php echo Valores($rowDatos['MontoSubTotal'], 0); ?></strong></td>
					</tr>
					<tr>
						<td colspan="2"><strong>Atrasos</strong></td>
						<td align="right"><strong><?php echo Valores($rowDatos['MontoAtraso'], 0); ?></strong></td>
					</tr>
					<tr>
						<td colspan="2"><strong>Adelantos</strong></td>
						<td align="right"><strong><?php echo Valores($rowDatos['MontoAdelanto'], 0); ?></strong></td>
					</tr>
					<tr>
						<td colspan="2"><strong>Total</strong></td>
						<td align="right"><strong><?php echo Valores($rowDatos['MontoTotal'], 0); ?></strong></td>
					</tr>

				</tbody>
			</table>

			<div class="row">
				<div class="col-xs-12">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 well well-sm no-shadow" style="background-color: #fff;">
						<p><?php echo 'Son: '.numtoletras($rowDatos['MontoTotal']); ?></p>
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
