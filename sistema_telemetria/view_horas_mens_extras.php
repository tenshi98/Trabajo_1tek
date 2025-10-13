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
core_sistemas.Nombre AS SistemaOrigen,
trabajadores_horas_extras_mensuales_facturacion.fecha_auto,
trabajadores_horas_extras_mensuales_facturacion.Creacion_fecha,
trabajadores_horas_extras_mensuales_facturacion.Ano,
trabajadores_horas_extras_mensuales_facturacion.Observaciones,
core_tiempo_meses.Nombre AS Mes';
$SIS_join  = '
LEFT JOIN `core_sistemas`     ON core_sistemas.idSistema     = trabajadores_horas_extras_mensuales_facturacion.idSistema
LEFT JOIN `usuarios_listado`  ON usuarios_listado.idUsuario  = trabajadores_horas_extras_mensuales_facturacion.idUsuario
LEFT JOIN `core_tiempo_meses` ON core_tiempo_meses.idMes     = trabajadores_horas_extras_mensuales_facturacion.idMes';
$SIS_where = 'trabajadores_horas_extras_mensuales_facturacion.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'trabajadores_horas_extras_mensuales_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Rut,
trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje,
trabajadores_horas_extras_mensuales_facturacion_horas.N_Horas, 
core_horas_extras_porcentajes.Porcentaje';
$SIS_join  = '
LEFT JOIN `trabajadores_listado`           ON trabajadores_listado.idTrabajador            = trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador
LEFT JOIN `core_horas_extras_porcentajes`  ON core_horas_extras_porcentajes.idPorcentaje   = trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje';
$SIS_where = 'trabajadores_horas_extras_mensuales_facturacion_horas.idFacturacion ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC';
$arrHoras = array();
$arrHoras = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_mensuales_facturacion_horas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHoras');

$arrHorasExtras = array();
foreach ($arrHoras as $prod){
	$arrHorasExtras[$prod['idTrabajador']]['TrabajadorNombre']                         = $prod['Nombre'].' '.$prod['ApellidoPat'].' '.$prod['ApellidoMat'];
	$arrHorasExtras[$prod['idTrabajador']]['TrabajadorRut']                            = $prod['Rut'];
	$arrHorasExtras[$prod['idTrabajador']]['idTrabajador']                             = $prod['idTrabajador'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['idPorcentaje']]['idTrabajador']      = $prod['idTrabajador'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['idPorcentaje']]['porcentaje_dia']    = $prod['idPorcentaje'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['idPorcentaje']]['horas_dia']         = $prod['N_Horas'];
}

/*****************************************/
//Porcentaje
$SIS_query = 'idPorcentaje, Porcentaje';
$SIS_join  = '';
$SIS_where = 'Porcentaje!=0';
$SIS_order = 'idPorcentaje ASC';
$arrPorcentajes = array();
$arrPorcentajes = db_select_array (false, $SIS_query, 'core_horas_extras_porcentajes', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPorcentajes');

$arrPorcFinal = array();
foreach ($arrPorcentajes as $porcentaje){
	$arrPorcFinal[$porcentaje['idPorcentaje']]['idPorcentaje']  = $porcentaje['idPorcentaje'];
	$arrPorcFinal[$porcentaje['idPorcentaje']]['Porcentaje']    = $porcentaje['Porcentaje'];
}
							
/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_mensuales_facturacion_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje,
SUM(trabajadores_horas_extras_mensuales_facturacion_horas.N_Horas) AS Total, 
core_horas_extras_porcentajes.Porcentaje';
$SIS_join  = 'LEFT JOIN `core_horas_extras_porcentajes` ON core_horas_extras_porcentajes.idPorcentaje = trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje';
$SIS_where = 'trabajadores_horas_extras_mensuales_facturacion_horas.idFacturacion ='.$X_Puntero.' GROUP BY trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje';
$SIS_order = 'trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje ASC';
$arrHorasTotal = array();
$arrHorasTotal = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_mensuales_facturacion_horas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHorasTotal');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Horas Extras Mensuales</div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo</td>
						<td><?php echo $rowData['Ano'].' - '.$rowData['Mes']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Usuario Ingreso</td>
						<td><?php echo $rowData['Usuario']?></td>
					</tr>
					<tr>
						<td class="meta-head">Sistema</td>
						<td><?php echo $rowData['SistemaOrigen']?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Facturacion</td>
						<td colspan="2"><?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Ingreso</td>
						<td colspan="2"><?php echo Fecha_estandar($rowData['fecha_auto']); ?></td>
					</tr>
				</tbody>
			</table>

		</div>
		<table id="items">
			<tbody>

				<?php
				//cuento la cantidad de columnas a utilizar
				$data_column = 2;
				$arrColumnas = array();
				//verifico si existen horas
				if ($arrHorasExtras!=false && !empty($arrHorasExtras) && $arrHorasExtras!=''){
					//recorro las horas
					foreach ($arrHorasExtras as $key => $producto){
						foreach ($producto as $prod) {
							$data_column++;
							$arrColumnas[$prod['idPorcentaje']]['idPorcentaje']  = $arrPorcFinal[$prod['porcentaje_dia']]['idPorcentaje'];
							$arrColumnas[$prod['idPorcentaje']]['Nombre']        = $arrPorcFinal[$prod['porcentaje_dia']]['Porcentaje'];
						}
					}
				}
				//Ordenar las columnas de los porcentajes
				ksort($arrColumnas);

				echo '
				<tr>
					<th colspan="'.($data_column-1).'">Detalle</th>
				</tr>';

				/***************************************************/
				echo '<tr class="item-row fact_tittle">';
				echo '<td>Trabajador</td>';
				//Muestro las columnas con los porcentajes validos
				foreach ($arrColumnas as $porcentaje) {
					echo '<td style="text-align: center;">'.$porcentaje['Nombre'].'%</td>';
				}
				echo '<td style="text-align: center;" width="120">Total Horas</td>';
				echo '</tr>';

				/***************************************************/
				if ($arrHorasExtras!=false && !empty($arrHorasExtras) && $arrHorasExtras!=''){
					//recorro las horas
					foreach ($arrHorasExtras as $key => $producto){
						//Variables
						$total_horas = 0;

						//Codigo
						echo '<tr class="item-row">';
						echo '<td>'.$producto['TrabajadorRut'].' - '.$producto['TrabajadorNombre'].'</td>';
							
						foreach ($arrColumnas as $porcentaje) {
							if(isset($producto[$porcentaje['idPorcentaje']]['porcentaje_dia'])&&$producto[$porcentaje['idPorcentaje']]['porcentaje_dia']){
								echo '<td style="text-align: center;">'.$producto[$porcentaje['idPorcentaje']]['horas_dia'].'</td>';
								$total_horas = $total_horas + $producto[$porcentaje['idPorcentaje']]['horas_dia'];
							}else{
								echo '<td></td>';
							}
						}
						echo '<td style="text-align: center;">'.$total_horas.'</td>';
						echo '</tr>';
					}
				}
				
				echo '<tr id="hiderow"><td colspan="'.($data_column-1).'"><a name="Ancla_obs"></a></td></tr>'; ?>

				<tr class="invoice-total" bgcolor="#f1f1f1">
					<td colspan="<?php echo $data_column-2; ?>" align="right"><strong>Total Horas extras</strong></td>
					<td align="right"></td>
				</tr>

				<?php
				foreach ($arrHorasTotal as $prod) {
					echo '
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="'.($data_column-2).'" align="right">Horas extras al '.$prod['Porcentaje'].'%</td>
						<td align="right">'.$prod['Total'].' Horas</td>
					</tr>';
				} ?>

				<tr>
					<td colspan="10" class="blank word_break">
						<?php echo $rowData['Observaciones']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="10" class="blank"><p>Observaciones</p></td> 
				</tr>

			</tbody>
		</table>
    </div>

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
