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
usuarios_listado.Nombre AS Usuario,
trabajadores_descuentos_cuotas_tipos.Nombre AS Documento,
trabajadores_descuentos_cuotas.fecha_auto,
trabajadores_descuentos_cuotas.Creacion_fecha,
trabajadores_descuentos_cuotas.Observaciones,
trabajadores_descuentos_cuotas.Monto,
trabajadores_descuentos_cuotas.N_Cuotas,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

trabajadores_listado.Nombre AS Nombre_trab,
trabajadores_listado.ApellidoPat AS ApellidoPat_trab,
trabajadores_listado.ApellidoMat AS ApellidoMat_trab,
trabajadores_listado.Cargo AS Cargo_trab,
trabajadores_listado.Fono AS Fono_trab,
trabajadores_listado.Rut AS Rut_trab,
trabajadores_listado_tipos.Nombre AS Tipo_trab';
$SIS_join  = '
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema                     = trabajadores_descuentos_cuotas.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                       = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                       = sistema_origen.idComuna
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                   = trabajadores_descuentos_cuotas.idUsuario
LEFT JOIN `trabajadores_descuentos_cuotas_tipos`    ON trabajadores_descuentos_cuotas_tipos.idTipo  = trabajadores_descuentos_cuotas.idTipo
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador            = trabajadores_descuentos_cuotas.idTrabajador
LEFT JOIN `trabajadores_listado_tipos`              ON trabajadores_listado_tipos.idTipo            = trabajadores_listado.idTipo';
$SIS_where = 'trabajadores_descuentos_cuotas.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'trabajadores_descuentos_cuotas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

// Se trae un listado de datos
$SIS_query = 'Fecha, nCuota, TotalCuotas, monto_cuotas';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'nCuota ASC';
$arrCuotas = array();
$arrCuotas = db_select_array (false, $SIS_query, 'trabajadores_descuentos_cuotas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCuotas');

/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'trabajadores_descuentos_cuotas_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['Documento']?>.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Datos del Trabajador
			<address>
				<strong><?php echo $rowData['Nombre_trab'].' '.$rowData['ApellidoPat_trab'].' '.$rowData['ApellidoMat_trab']; ?></strong><br/>
				Rut: <?php echo $rowData['Rut_trab']; ?><br/>
				Fono: <?php echo formatPhone($rowData['Fono_trab']); ?><br/>
				Cargo: <?php echo $rowData['Cargo_trab']; ?><br/>
				Tipo Cargo: <?php echo $rowData['Tipo_trab']; ?>
			</address>
		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Empresa
			<address>
				<strong><?php echo $rowData['SistemaOrigen']; ?></strong><br/>
				<?php echo $rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna']; ?><br/>
				<?php echo $rowData['SistemaOrigenDireccion']; ?><br/>
				Fono: <?php echo formatPhone($rowData['SistemaOrigenFono']); ?><br/>
				Rut: <?php echo $rowData['SistemaOrigenRut']; ?><br/>
				Email: <?php echo $rowData['SistemaOrigenEmail']; ?>
			</address>
		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">';
			<?php 		
			if(isset($rowData['Usuario'])&&$rowData['Usuario']!=''){
				echo '<strong>Usuario creador: </strong>'.$rowData['Usuario'].'<br/>';
			}
			if(isset($rowData['fecha_auto'])&&$rowData['fecha_auto']!=''&&$rowData['fecha_auto']!='0000-00-00'){
				echo '<strong>Fecha Ingreso : </strong>'.Fecha_estandar($rowData['fecha_auto']).'<br/>';
			}
			if(isset($rowData['Monto'])&&$rowData['Monto']!=''){
				echo '<strong>Monto Cuotas : </strong>'.valores($rowData['Monto'],0).'<br/>';
			}
			if(isset($rowData['N_Cuotas'])&&$rowData['N_Cuotas']!=''&&$rowData['N_Cuotas']!='0'){
				echo '<strong>N° Cuotas: </strong>'.$rowData['N_Cuotas'].'<br/>';
			}
			?>
		</div>

	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Fecha Cobro</th>
						<th>Numero Cuota</th>
						<th align="right">Valor</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrCuotas!=false && !empty($arrCuotas) && $arrCuotas!='') { ?>
						<?php foreach ($arrCuotas as $prod) { ?>
							<tr>
								<td><?php echo fecha_estandar($prod['Fecha']); ?></td>
								<td><?php echo 'Cuota '.$prod['nCuota'].' de '.$prod['TotalCuotas']; ?></td>
								<td align="right"><?php echo Valores(Cantidades_decimales_justos($prod['monto_cuotas']), 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="2" align="right"><strong>Total Cuotas</strong></td>
						<td width="160" align="right"><?php echo Valores($rowData['Monto'], 0); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
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
