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
require_once 'core/Load.Utils.Print.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
/**********************************************************************************************************************************/
/*******************************************************/
// consulto los datos
$SIS_query = '
insumos_listado.StockLimite,
insumos_listado.Nombre AS NombreProd,
sistema_productos_uml.Nombre AS UnidadMedida,
(SELECT SUM(Cantidad_ing) FROM bodegas_insumos_facturacion_existencias WHERE idProducto = insumos_listado.idProducto AND idBodega='.$_GET['idBodega'].' LIMIT 1) AS stock_entrada,
(SELECT SUM(Cantidad_eg)  FROM bodegas_insumos_facturacion_existencias WHERE idProducto = insumos_listado.idProducto AND idBodega='.$_GET['idBodega'].' LIMIT 1) AS stock_salida,
(SELECT Nombre            FROM bodegas_insumos_listado                 WHERE idBodega='.$_GET['idBodega'].' LIMIT 1) AS NombreBodega';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml';
$SIS_where = '';
$SIS_order = 'insumos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.PrintFact.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
$my_html ='
	<div class="panel panel-cascade panel-invoice">
        <div class="panel-body">
			Stock Bodega: <strong>'.$arrProductos[0]['NombreBodega'].'</strong><br/>
			Stock al '.fecha_actual().'<br/>
			<br/>
			<br/>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Stock Min</th>
								<th>Stock Actual</th>
							</tr>
						</thead>
						<tbody>';

							foreach ($arrProductos as $productos) {
							$stock_actual = $productos['stock_entrada'] - $productos['stock_salida'];
							if ($productos['StockLimite']>$stock_actual){$delta = 'destaca';}else{$delta = '';}

							$my_html .='<tr class="'.$delta.'">
											<td>'.$productos['NombreProd'].'</td>
											<td width="160">'.Cantidades_decimales_justos($productos['StockLimite']).' '.$productos['UnidadMedida'].'</td>
											<td width="160">'.Cantidades_decimales_justos($stock_actual).' '.$productos['UnidadMedida'].'</td>
										</tr>';
							}

						$my_html .='</tbody>
					</table>
				</div>
			</div>

			<div class="clear"></div>

		</div>
	</div>
</body>
</html>';

echo $my_html;
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
