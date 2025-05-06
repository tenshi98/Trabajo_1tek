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
$original = "informe_vehiculos_01.php";
$location = $original;
//Se agregan ubicaciones
$location .='?filtro=true';
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
/*******************************************************************************************/
//Variable
$z = " WHERE vehiculos_listado.idEstado=1 AND vehiculos_listado.idOpciones_4=1";
$d1 = "";
$d2 = "";
$data = "";
$n_meses = 1;
//Verifico el tipo de usuario que esta ingresando
$z.=" AND vehiculos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
if (isset($_GET['Ano'])&&$_GET['Ano']!=''&&isset($_GET['idMes'])&&$_GET['idMes']!=''){
	$d1.=" AND Creacion_mes='".$_GET['idMes']."' AND Creacion_ano='".$_GET['Ano']."'";
	$d2.=" AND idMes='".$_GET['idMes']."' AND Ano='".$_GET['Ano']."'";
	$data .= " ".numero_a_mes($_GET['idMes'])." de ".$_GET['Ano'];

}
if (isset($_GET['fInicio'])&&$_GET['fInicio']!=''&&isset($_GET['fTermino'])&&$_GET['fTermino']!=''){
	$d1.=" AND Creacion_fecha BETWEEN '".$_GET['fInicio']."' AND '".$_GET['fTermino']."'";
	$d2.=" AND Fecha BETWEEN '".$_GET['fInicio']."' AND '".$_GET['fTermino']."'";
	$data .= " entre ".Fecha_estandar($_GET['fInicio'])." al ".Fecha_estandar($_GET['fTermino']);
	$n_meses = diferencia_meses($_GET['fInicio'], $_GET['fTermino'] );
}
/*******************************************************************************************/
// Se trae un listado con todos los elementos
$arrCostos = array();
$query = "SELECT idTipo, Nombre
FROM `vehiculos_costos_tipo`
ORDER BY Nombre ASC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCostos,$row );
}
$costos = "";
$cost = 0;
foreach ($arrCostos as $costo) {
	$costos .= " (SELECT SUM(Valor) FROM `vehiculos_costos` WHERE idVehiculo=vehiculos_listado.idVehiculo AND idTipo=".$costo['idTipo']."  ".$d1."  LIMIT 1) AS Costo_".$cost.", ";
	$cost++;
}
/*******************************************************************************************/

		

// Se trae un listado con todos los elementos
$arrVehiculos = array();
$query = "SELECT 
vehiculos_listado.idVehiculo,
vehiculos_listado.Nombre,
vehiculos_listado.Marca, 
vehiculos_listado.Modelo,
vehiculos_tipo.Nombre AS Tipo,
trabajadores_listado.SueldoLiquido,

".$costos."

(SELECT COUNT(idVehiculo) FROM `apoderados_listado_hijos` WHERE idVehiculo=vehiculos_listado.idVehiculo  LIMIT 1) AS PasajerosCuenta,

(SELECT SUM(sistema_planes.Valor) FROM `apoderados_listado_hijos` LEFT JOIN `sistema_planes` ON sistema_planes.idPlan = apoderados_listado_hijos.idPlan WHERE idVehiculo=vehiculos_listado.idVehiculo  LIMIT 1) AS PasajerosValor,

(SELECT SUM(Monto_1) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_1=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorAcumulado1,
(SELECT SUM(Monto_2) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_2=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorAcumulado2,
(SELECT SUM(Monto_3) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_3=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorAcumulado3,
(SELECT SUM(Monto_4) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_4=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorAcumulado4,
(SELECT SUM(Monto_5) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_5=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorAcumulado5,

(SELECT SUM(montoPago) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_1=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorPagado1,
(SELECT SUM(montoPago) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_2=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorPagado2,
(SELECT SUM(montoPago) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_3=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorPagado3,
(SELECT SUM(montoPago) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_4=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorPagado4,
(SELECT SUM(montoPago) FROM `vehiculos_facturacion_listado_detalle` WHERE idVehiculo_5=vehiculos_listado.idVehiculo ".$d2."  LIMIT 1) AS PasajeroValorPagado5



FROM `vehiculos_listado`
LEFT JOIN `vehiculos_tipo`           ON vehiculos_tipo.idTipo                = vehiculos_listado.idTipo
LEFT JOIN `trabajadores_listado`     ON trabajadores_listado.idTrabajador    = vehiculos_listado.idTrabajador
".$z."
ORDER BY vehiculos_listado.Nombre ASC  ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrVehiculos,$row );
}





?>

                    
                                 
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Calculos <?php echo $data; ?></h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th class="text-center" colspan="4">Vehiculo</th>
						<th class="text-center" colspan="2">Programado</th>
						<th class="text-center" colspan="<?php echo $cost+2; ?>">Costos</th>
						<th class="text-center" colspan="2">Resultado</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr role="row">
						<td style="background-color: #ccc;">Nombre</td>
						<td style="background-color: #ccc;">Marca</td>
						<td style="background-color: #ccc;">Modelo</td>
						<td style="background-color: #ccc;">Tipo</td>

						<td style="background-color: #ccc;">Total Pasajeros</td>
						<td style="background-color: #ccc;">Recoleccion Planificada</td>

						<td style="background-color: #ccc;">Sueldo Chofer</td>
						<?php foreach ($arrCostos as $cost) {
							echo '<td style="background-color: #ccc;">'.$cost['Nombre'].'</td>';
						} ?>
						<td style="background-color: #ccc;">Total Costos</td>

						<td style="background-color: #ccc;">Total Recolectado</td>
						<td style="background-color: #ccc;">Diferencia</td>

					</tr>

					<?php
						$total_prog = 0;
						$total_cost = 0;
						$total_reco = 0;

						foreach ($arrVehiculos as $trab) { 
						
						$total_recolec = 0;
						if($trab['PasajeroValorAcumulado1']<=$trab['PasajeroValorPagado1']){$total_recolec = $total_recolec + $trab['PasajeroValorAcumulado1'];}else{$total_recolec = $total_recolec + $trab['PasajeroValorPagado1'];}
						if($trab['PasajeroValorAcumulado2']<=$trab['PasajeroValorPagado2']){$total_recolec = $total_recolec + $trab['PasajeroValorAcumulado2'];}else{$total_recolec = $total_recolec + $trab['PasajeroValorPagado2'];}
						if($trab['PasajeroValorAcumulado3']<=$trab['PasajeroValorPagado3']){$total_recolec = $total_recolec + $trab['PasajeroValorAcumulado3'];}else{$total_recolec = $total_recolec + $trab['PasajeroValorPagado3'];}
						if($trab['PasajeroValorAcumulado4']<=$trab['PasajeroValorPagado4']){$total_recolec = $total_recolec + $trab['PasajeroValorAcumulado4'];}else{$total_recolec = $total_recolec + $trab['PasajeroValorPagado4'];}
						if($trab['PasajeroValorAcumulado5']<=$trab['PasajeroValorPagado5']){$total_recolec = $total_recolec + $trab['PasajeroValorAcumulado5'];}else{$total_recolec = $total_recolec + $trab['PasajeroValorPagado5'];}
						
						
						
						
						/*$total_recolec = $total_recolec + $trab['PasajeroValorPagado1'];
						$total_recolec = $total_recolec + $trab['PasajeroValorPagado2'];
						$total_recolec = $total_recolec + $trab['PasajeroValorPagado3'];
						$total_recolec = $total_recolec + $trab['PasajeroValorPagado4'];
						$total_recolec = $total_recolec + $trab['PasajeroValorPagado5'];*/
						
						$pas_valor  = $trab['PasajerosValor'] * $n_meses;
						$pas_sueldo = $trab['SueldoLiquido'] * $n_meses;

						$total_prog = $total_prog + $pas_valor;

						?>
						<tr class="odd">
							<td><?php echo $trab['Nombre']; ?></td>
							<td><?php echo $trab['Marca']; ?></td>
							<td><?php echo $trab['Modelo']; ?></td>
							<td><?php echo $trab['Tipo']; ?></td>

							<td align="right"><?php echo $trab['PasajerosCuenta']; ?></td>
							<td align="right" style="background-color: #eee;"><?php echo  valores($pas_valor,0); ?></td>
							
							
							<?php $subtotal = 0; ?>
							<td align="right"><?php echo valores($pas_sueldo,0); $subtotal = $subtotal + $pas_sueldo; ?></td>
							<?php
							$cost = 0;
							foreach ($arrCostos as $costo) { ?>
								<td align="right"><?php echo  valores($trab['Costo_'.$cost],0); ?></td>
							<?php
							$subtotal = $subtotal + $trab['Costo_'.$cost];
							$cost++;
							} ?>
							<td align="right" style="background-color: #eee;"><?php echo  valores($subtotal,0); ?></td>
							<?php $total_cost = $total_cost + $subtotal; ?>

							<td align="right"><?php echo  valores($total_recolec,0); ?></td>
							<td align="right" style="background-color: #eee;"><?php echo  valores($total_recolec-$subtotal,0); ?></td>
							<?php $total_reco = $total_reco + $total_recolec; ?>
							

						</tr>
					<?php } ?>
					<tr class="odd">
						<td colspan="<?php echo 10+$cost?>"></td>
					</tr>
					<tr class="odd">
						<td align="right" colspan="<?php echo 9+$cost?>">Total Planificado</td>
						<td align="right"><?php echo valores($total_prog,0); ?></td>
					</tr>
					<tr class="odd">
						<td align="right" colspan="<?php echo 9+$cost?>">Total Costos</td>
						<td align="right"><?php echo valores($total_cost,0); ?></td>
					</tr>
					<tr class="odd">
						<td align="right" colspan="<?php echo 9+$cost?>">Total Recolectado</td>
						<td align="right"><?php echo valores($total_reco,0); ?></td>
					</tr>
					<tr class="odd">
						<td align="right" colspan="<?php echo 9+$cost?>">Saldo</td>
						<td align="right"><?php echo valores($total_reco-$total_cost,0); ?></td>
					</tr>
				                   
				</tbody>
			</table>
		</div>
	</div>
</div>
  
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php 
				
				//Se verifican si existen los datos
				if(isset($Ano)){       $x1  = $Ano;       }else{$x1  = '';}
				if(isset($idMes)){     $x2  = $idMes;     }else{$x2  = '';}
				if(isset($fInicio)){   $x3  = $fInicio;   }else{$x3  = '';}
				if(isset($fTermino)){  $x4  = $fTermino;  }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Generar Informe por Mes');
				$Form_Inputs->form_select_n_auto('Año','Ano', $x1, 1, 2016, ano_actual());
				$Form_Inputs->form_select_filter('Mes','idMes', $x2, 1, 'idMes', 'Nombre', 'core_tiempo_meses', 0, 'idMes ASC', $dbConn);

				$Form_Inputs->form_tittle(3, 'Generar informe entre fechas');
				$Form_Inputs->form_date('F Inicio','fInicio', $x3, 1);
				$Form_Inputs->form_date('F Termino','fTermino', $x4, 1);
				
	
						
				$Form_Inputs->form_input_hidden('pagina', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>

			</form>
            <?php widget_validator(); ?>
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
