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
trabajadores_horas_extras_facturacion.fecha_auto,
trabajadores_horas_extras_facturacion.Creacion_fecha,
trabajadores_horas_extras_facturacion.Fecha_desde,
trabajadores_horas_extras_facturacion.Fecha_hasta,
trabajadores_horas_extras_facturacion.Observaciones';
$SIS_join  = '
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema         = trabajadores_horas_extras_facturacion.idSistema
LEFT JOIN `usuarios_listado`        ON usuarios_listado.idUsuario      = trabajadores_horas_extras_facturacion.idUsuario';
$SIS_where = 'trabajadores_horas_extras_facturacion.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'trabajadores_horas_extras_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
trabajadores_horas_extras_facturacion_horas.idTrabajador,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Rut,
trabajadores_horas_extras_facturacion_horas.nSem, 
trabajadores_horas_extras_facturacion_horas.Fecha, 
trabajadores_horas_extras_facturacion_horas.N_Horas, 
core_horas_extras_porcentajes.Porcentaje';
$SIS_join  = '
LEFT JOIN `trabajadores_listado`           ON trabajadores_listado.idTrabajador            = trabajadores_horas_extras_facturacion_horas.idTrabajador
LEFT JOIN `core_horas_extras_porcentajes`  ON core_horas_extras_porcentajes.idPorcentaje   = trabajadores_horas_extras_facturacion_horas.idPorcentaje';
$SIS_where = 'trabajadores_horas_extras_facturacion_horas.idFacturacion ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC';
$arrHoras = array();
$arrHoras = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_facturacion_horas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHoras');

$arrHorasExtras = array();
foreach ($arrHoras as $prod){
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']]['nSem']                        = $prod['nSem'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']]['idTrabajador']                = $prod['idTrabajador'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']]['TrabajadorNombre']            = $prod['Nombre'].' '.$prod['ApellidoPat'].' '.$prod['ApellidoMat'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']]['TrabajadorRut']               = $prod['Rut'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']][$prod['Fecha']]['fecha_dia']   = $prod['Fecha'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']][$prod['Fecha']]['horas_dia']   = $prod['N_Horas'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']][$prod['Fecha']]['porcentaje']  = $prod['Porcentaje'];
}
/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
trabajadores_horas_extras_facturacion_turnos.idTurnos,
trabajadores_horas_extras_facturacion_turnos.idTrabajador,
trabajadores_horas_extras_facturacion_turnos.nSem, 
core_horas_extras_turnos.Nombre AS Turno';
$SIS_join  = 'LEFT JOIN `core_horas_extras_turnos` ON core_horas_extras_turnos.idTurnos = trabajadores_horas_extras_facturacion_turnos.idTurnos';
$SIS_where = 'trabajadores_horas_extras_facturacion_turnos.idFacturacion ='.$X_Puntero;
$SIS_order = 'trabajadores_horas_extras_facturacion_turnos.nSem ASC';
$arrTurnos = array();
$arrTurnos = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_facturacion_turnos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTurnos');

foreach ($arrTurnos as $prod){
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']]['Turno']      = $prod['Turno'];
	$arrHorasExtras[$prod['idTrabajador']][$prod['nSem']]['idTurnos']   = $prod['idTurnos'];
}

/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 0;
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_facturacion_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
trabajadores_horas_extras_facturacion_horas.idPorcentaje,
SUM(trabajadores_horas_extras_facturacion_horas.N_Horas) AS Total, 
core_horas_extras_porcentajes.Porcentaje';
$SIS_join  = 'LEFT JOIN `core_horas_extras_porcentajes` ON core_horas_extras_porcentajes.idPorcentaje = trabajadores_horas_extras_facturacion_horas.idPorcentaje';
$SIS_where = 'trabajadores_horas_extras_facturacion_horas.idFacturacion ='.$X_Puntero.' GROUP BY trabajadores_horas_extras_facturacion_horas.idPorcentaje';
$SIS_order = 'trabajadores_horas_extras_facturacion_horas.idPorcentaje ASC';
$arrHorasTotal = array();
$arrHorasTotal = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_facturacion_horas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHorasTotal');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Horas Extras</div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Desde</td>
						<td><?php echo Fecha_estandar($rowData['Fecha_desde']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Hasta</td>
						<td><?php echo Fecha_estandar($rowData['Fecha_hasta']); ?></td>
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
				<tr>
					<th colspan="10">Detalle</th>
				</tr>
				<tr class="item-row fact_tittle">
					<td>Trabajador</td>
					<td>N° Semana</td>
					<td>Lunes</td>
					<td>Martes</td>
					<td>Miercoles</td>
					<td>Jueves</td>
					<td>Viernes</td>
					<td>Sabado</td>
					<td>Domingo</td>
					<td>Turno</td>
				</tr>

				<?php

				//Obtengo el numero de semanas de la seleccion
				$nSemanas      = ceil ((dias_transcurridos($rowData['Fecha_desde'],$rowData['Fecha_hasta']))/7);
				$DiaActual     = $rowData['Fecha_desde'];
				$nDias         = dias_transcurridos($rowData['Fecha_desde'],$rowData['Fecha_hasta']);
				$Dia           = 1;
				$DiaActual_ex  = $rowData['Fecha_desde'];
				$Dia_ex        = 1;
				$TotalHoras    = array();

				//Recorro las semanas seleccionadas
				for($xsi1=1;$xsi1<=$nSemanas;$xsi1++){
					echo '<tr class="item-row fact_tittle">';
					//Cadena para los dias disponibles
					$cadena = '';
					//Recorro los dias de la semana
					for($i=1;$i<=7;$i++){
						//imprimo la primera celda y el numero de semana actual
						if($xsi1==1&&$i==1){
							$nSem = fecha2NSemana($rowData['Fecha_desde']);
							echo '<td></td>';
							echo '<td>'.$nSem.'</td>';
						}elseif($xsi1!=1&&$i==1){
							$nSem = fecha2NSemana($DiaActual);
							echo '<td></td>';
							echo '<td>'.$nSem.'</td>';
						}
						//Imprimo la fecha en caso de existir
						if($i==fecha2NDiaSemana($DiaActual)&&$Dia<=($nDias+1)){
							$cadena .= '&fecha_dia_'.$i.'='.$DiaActual;
							echo '<td>'.Fecha_estandar($DiaActual).'</td>';
							$DiaActual = sumarDias($DiaActual,1);
							$Dia++;
						}else{
							echo '<td></td>';
						}
					}
					echo '<td></td>';
					echo '</tr>';
					/***************************************************/
					if ($arrHorasExtras!=false && !empty($arrHorasExtras) && $arrHorasExtras!=''){
						//imprimo la primera celda y el numero de semana actual
						foreach ($arrHorasExtras as $key => $producto){
							//Subcadena con el trabajador
							if(isset($producto[$nSem]['idTrabajador'])&&$producto[$nSem]['idTrabajador']){
								$subcadena = '&idTrabajador='.$producto[$nSem]['idTrabajador'];
							}else{
								$subcadena = '';
							}
							if(isset($producto[$nSem]['nSem'])){
								echo '<tr>';
								echo '<td colspan="2">'.$producto[$nSem]['TrabajadorRut'].' '.$producto[$nSem]['TrabajadorNombre'].'</td>';
										
								//Recorro los dias de la semana
								for($i=1;$i<=7;$i++){

									//Imprimo la fecha en caso de existir
									if($i==fecha2NDiaSemana($DiaActual_ex)&&$Dia_ex<=($nDias+1)){
										if(isset($producto[$nSem][Fecha_normalizada($DiaActual_ex)]['horas_dia'])){
											echo '<td>'.$producto[$nSem][Fecha_normalizada($DiaActual_ex)]['horas_dia'].' ('.$producto[$nSem][Fecha_normalizada($DiaActual_ex)]['porcentaje'].'%)</td>';
										}else{
											echo '<td></td>';
										}

										$DiaActual_ex = sumarDias($DiaActual_ex,1);
										$Dia_ex++;
									}else{
										echo '<td></td>';
									}
								}
								echo '<td>'.$producto[$nSem]['Turno'].'</td>';
								echo '</tr>';
							}
						}
					}
				}
				
				echo '<tr id="hiderow"><td colspan="10"><a name="Ancla_obs"></a></td></tr>'; ?>

				<tr class="invoice-total" bgcolor="#f1f1f1">
					<td colspan="9" align="right"><strong>Total Horas extras</strong></td>
					<td align="right"></td>
				</tr>

				<?php
				foreach ($arrHorasTotal as $prod) {
					echo '
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="9" align="right">Horas extras al '.$prod['Porcentaje'].'%</td>
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
