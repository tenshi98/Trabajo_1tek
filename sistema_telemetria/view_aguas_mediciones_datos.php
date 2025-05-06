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
// Se traen todos los datos de la subida
$SIS_query = '
aguas_mediciones_datos.idDatos,
aguas_mediciones_datos.fCreacion,
aguas_mediciones_datos.Fecha,
aguas_mediciones_datos.Nombre AS NombreArchivo,
aguas_mediciones_datos.Observaciones,
usuarios_listado.Nombre AS NombreUsuario,
core_sistemas.Nombre AS Sistema,

aguas_mediciones_datos.idTipo,
aguas_mediciones_datos.ConsumoMedidor,
aguas_mediciones_datos_tipo_medicion.Nombre AS MedidorTipoMed,
aguas_marcadores_listado.Nombre AS MarcadorNombre,
aguas_mediciones_datos.idMarcadoresUsado AS ID,
(SELECT Identificador FROM `aguas_clientes_listado` WHERE idMarcadores = ID AND idFacturable = 3 LIMIT 1)AS ClienteIdentificador,
(SELECT Nombre FROM `aguas_clientes_listado` WHERE idMarcadores = ID AND idFacturable = 3 LIMIT 1)AS ClienteNombre';
$SIS_join  = '
LEFT JOIN `core_sistemas`                          ON core_sistemas.idSistema                               = aguas_mediciones_datos.idSistema
LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                            = aguas_mediciones_datos.idUsuario
LEFT JOIN `aguas_mediciones_datos_tipo_medicion`   ON aguas_mediciones_datos_tipo_medicion.idTipoMedicion   = aguas_mediciones_datos.idTipoMedicion
LEFT JOIN `aguas_marcadores_listado`               ON aguas_marcadores_listado.idMarcadores                 = aguas_mediciones_datos.idMarcadoresUsado';
$SIS_where = 'aguas_mediciones_datos.idDatos ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'aguas_mediciones_datos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************************************/
// consulto los datos
$SIS_query = '
aguas_mediciones_datos_detalle.idDatosDetalle,
aguas_clientes_listado.Nombre,
aguas_clientes_listado.Direccion,
aguas_clientes_listado.Identificador,
aguas_clientes_listado.UnidadHabitacional,
aguas_mediciones_datos_detalle.Consumo,
aguas_marcadores_listado.Nombre AS Marcadores,
aguas_marcadores_remarcadores.Nombre AS Remarcadores';
$SIS_join  = '
LEFT JOIN `aguas_clientes_listado`         ON aguas_clientes_listado.idCliente               = aguas_mediciones_datos_detalle.idCliente
LEFT JOIN `aguas_marcadores_listado`       ON aguas_marcadores_listado.idMarcadores          = aguas_mediciones_datos_detalle.idMarcadores
LEFT JOIN `aguas_marcadores_remarcadores`  ON aguas_marcadores_remarcadores.idRemarcadores   = aguas_mediciones_datos_detalle.idRemarcadores';
$SIS_where = 'aguas_mediciones_datos_detalle.idDatos ='.$X_Puntero;
$SIS_order = 'aguas_mediciones_datos_detalle.idDatosDetalle ASC';
$arrDatosCorrectos = array();
$arrDatosCorrectos = db_select_array (false, $SIS_query, 'aguas_mediciones_datos_detalle', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDatosCorrectos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Ingreso Medidores N°<?php echo n_doc($rowData['idDatos'], 7); ?> </div>
		<div id="customer">
			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"></td>
					</tr>
					<tr>
						<td class="meta-head">Creador</td>
						<td><?php echo $rowData['NombreUsuario']?></td>
					</tr>
					<tr>
						<td class="meta-head">Nombre del Archivo</td>
						<td><?php echo $rowData['NombreArchivo']?></td>
					</tr>
					<tr>
						<td class="meta-head">Sistema</td>
						<td><?php echo $rowData['Sistema']?></td>
					</tr>

					<?php if(isset($rowData['idTipo'])&&$rowData['idTipo']==2){ ?>

						<tr>
							<td class="meta-head">Cliente</td>
							<td><?php echo $rowData['ClienteIdentificador'].' '.$rowData['ClienteNombre']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Medidor Cliente</td>
							<td><?php echo $rowData['MarcadorNombre']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Medicion del periodo</td>
							<td><?php echo cantidades_decimales_justos($rowData['ConsumoMedidor']).' Metros Cubicos'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Distribucion de diferencia</td>
							<td><?php echo $rowData['MedidorTipoMed']; ?></td>
						</tr>

					<?php } ?>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td><?php echo Fecha_estandar($rowData['fCreacion']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Facturacion</td>
						<td><?php echo Fecha_estandar($rowData['Fecha']); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<table id="items">
			<tbody>
				<tr><th colspan="6">Detalle</th></tr>		  
				
				<?php if($arrDatosCorrectos!=false && !empty($arrDatosCorrectos) && $arrDatosCorrectos!='') { ?>
					<tr class="item-row linea_punteada" bgcolor="#F0F0F0">
						<td><strong>Identificador</strong></td>
						<td><strong>Cliente</strong></td>
						<td width="15px"><strong>Medidor</strong></td>
						<td width="15px"><strong>Remarcador</strong></td>
						<td><strong>Dirección</strong></td>
						<td width="15px"><strong>Consumo</strong></td>
					</tr>
					<?php foreach ($arrDatosCorrectos as $datos) { ?>
						<tr class="item-row linea_punteada">
							<td><?php echo $datos['Identificador']; ?></td>
							<td><?php echo $datos['Nombre']; ?></td>
							<td><?php echo $datos['Marcadores']; ?></td>
							<td><?php echo $datos['Remarcadores']; ?></td>
							<td><?php echo $datos['Direccion']; ?></td>
							<td><?php echo cantidades_decimales_justos($datos['Consumo']); ?></td>
						</tr>
					<?php } ?>
					<tr id="hiderow"><td colspan="6"></td></tr>
				<?php } ?>

				<tr>
					<td colspan="6" class="blank">
						<p>
							<?php
							if(isset($rowData['Observaciones'])&&$rowData['Observaciones']!=''){
								echo $rowData['Observaciones'];
							}else{
								echo 'Sin Observaciones';
							} ?>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="6" class="blank"><p>Observaciones</p></td> 
				</tr>
			</tbody>
		</table>
    	<div class="clearfix"></div>
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
