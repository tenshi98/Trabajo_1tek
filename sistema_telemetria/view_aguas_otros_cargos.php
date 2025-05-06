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
aguas_clientes_otros_cargos.FechaEjecucion,
aguas_clientes_otros_cargos.Fecha,
aguas_clientes_otros_cargos.ValorCargo,
aguas_clientes_otros_cargos.Observacion,
aguas_clientes_otros_cargos.Archivo,

usuarios_listado.Nombre AS NombreUsuario,
core_sistemas.Nombre AS Sistema,
aguas_clientes_listado.Identificador AS ClienteIdentificador,
aguas_clientes_listado.Nombre AS ClienteNombre';
$SIS_join  = '
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema           = aguas_clientes_otros_cargos.idSistema
LEFT JOIN `usuarios_listado`        ON usuarios_listado.idUsuario        = aguas_clientes_otros_cargos.idUsuario
LEFT JOIN `aguas_clientes_listado`  ON aguas_clientes_listado.idCliente  = aguas_clientes_otros_cargos.idCliente';
$SIS_where = 'aguas_clientes_otros_cargos.idOtrosCargos ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'aguas_clientes_otros_cargos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Evento N°<?php echo n_doc($X_Puntero, 7); ?> </div>
		<div id="customer">
			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"></td>
					</tr>
					<tr>
						<td class="meta-head">Cliente</td>
						<td><?php echo $rowData['ClienteIdentificador'].' '.$rowData['ClienteNombre']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Valor Del Cargo</td>
						<td align="right"><?php echo valores($rowData['ValorCargo'], 0); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Creador</td>
						<td><?php echo $rowData['NombreUsuario']?></td>
					</tr>
					<tr>
						<td class="meta-head">Sistema</td>
						<td><?php echo $rowData['Sistema']?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td><?php echo Fecha_estandar($rowData['Fecha']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Ejecucion</td>
						<td><?php echo Fecha_estandar($rowData['FechaEjecucion']); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<table id="items">
			<tbody>
				<?php if(isset($rowData['Archivo'])&&$rowData['Archivo']!=''){ ?>
					<tr><th>Archivo</th></tr>		  
					<tr class="item-row linea_punteada" bgcolor="#F0F0F0">
						<td>
							<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
								<?php echo preview_docs(DB_SITE_REPO.DB_SITE_MAIN_PATH, 'upload/'.$rowData['Archivo'], ''); ?>
							</div>
						</td>
					</tr>
					<tr id="hiderow"><td colspan="6"></td></tr>
				<?php } ?>
				<tr>
					<td colspan="6" class="blank">
						<p>
							<?php
							if(isset($rowData['Observacion'])&&$rowData['Observacion']!=''){
								echo $rowData['Observacion'];
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
