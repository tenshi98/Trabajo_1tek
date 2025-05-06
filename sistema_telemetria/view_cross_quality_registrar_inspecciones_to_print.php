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
// Se traen todos los datos del analisis
$SIS_query = '
cross_quality_registrar_inspecciones.fecha_auto,
cross_quality_registrar_inspecciones.Creacion_fecha,
cross_quality_registrar_inspecciones.Temporada,
cross_quality_registrar_inspecciones.Observaciones,

core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
core_cross_quality_analisis_calidad.Nombre AS TipoAnalisis,
sistema_variedades_categorias.Nombre AS ProductoCategoria,
variedades_listado.Nombre AS ProductoNombre,

cross_quality_registrar_inspecciones.idCategoria,
cross_quality_registrar_inspecciones.idTipo,
cross_quality_registrar_inspecciones.idSistema,
(SELECT 
cross_quality_calidad_matriz.cantPuntos
FROM `sistema_variedades_categorias_matriz_calidad`
LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz
WHERE sistema_variedades_categorias_matriz_calidad.idCategoria = cross_quality_registrar_inspecciones.idCategoria
AND sistema_variedades_categorias_matriz_calidad.idProceso = cross_quality_registrar_inspecciones.idTipo
AND sistema_variedades_categorias_matriz_calidad.idSistema = cross_quality_registrar_inspecciones.idSistema
) AS Producto_cantPuntos,

(SELECT 
sistema_variedades_categorias_matriz_calidad.idMatriz
FROM `sistema_variedades_categorias_matriz_calidad`
LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz
WHERE sistema_variedades_categorias_matriz_calidad.idCategoria = cross_quality_registrar_inspecciones.idCategoria
AND sistema_variedades_categorias_matriz_calidad.idProceso = cross_quality_registrar_inspecciones.idTipo
AND sistema_variedades_categorias_matriz_calidad.idSistema = cross_quality_registrar_inspecciones.idSistema
) AS Producto_idCalidad,

ubicacion_listado.Nombre AS UbicacionNombre,
ubicacion_listado_level_1.Nombre AS UbicacionNombre_lvl_1,
ubicacion_listado_level_2.Nombre AS UbicacionNombre_lvl_2,
ubicacion_listado_level_3.Nombre AS UbicacionNombre_lvl_3,
ubicacion_listado_level_4.Nombre AS UbicacionNombre_lvl_4,
ubicacion_listado_level_5.Nombre AS UbicacionNombre_lvl_5';
$SIS_join  = '
LEFT JOIN `core_sistemas`                          ON core_sistemas.idSistema                      = cross_quality_registrar_inspecciones.idSistema
LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                   = cross_quality_registrar_inspecciones.idUsuario
LEFT JOIN `core_cross_quality_analisis_calidad`    ON core_cross_quality_analisis_calidad.idTipo   = cross_quality_registrar_inspecciones.idTipo
LEFT JOIN `sistema_variedades_categorias`          ON sistema_variedades_categorias.idCategoria    = cross_quality_registrar_inspecciones.idCategoria
LEFT JOIN `variedades_listado`                     ON variedades_listado.idProducto                = cross_quality_registrar_inspecciones.idProducto
LEFT JOIN `ubicacion_listado`                      ON ubicacion_listado.idUbicacion                = cross_quality_registrar_inspecciones.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`              ON ubicacion_listado_level_1.idLevel_1          = cross_quality_registrar_inspecciones.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`              ON ubicacion_listado_level_2.idLevel_2          = cross_quality_registrar_inspecciones.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`              ON ubicacion_listado_level_3.idLevel_3          = cross_quality_registrar_inspecciones.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`              ON ubicacion_listado_level_4.idLevel_4          = cross_quality_registrar_inspecciones.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`              ON ubicacion_listado_level_5.idLevel_5          = cross_quality_registrar_inspecciones.idUbicacion_lvl_5';
$SIS_where = 'cross_quality_registrar_inspecciones.idAnalisis ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
// Se trae un listado con todos los trabajadores
$SIS_query = '
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat, 
trabajadores_listado.ApellidoMat,
trabajadores_listado.Cargo, 
trabajadores_listado.Rut';
$SIS_join  = 'LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador   = cross_quality_registrar_inspecciones_trabajador.idTrabajador';
$SIS_where = 'cross_quality_registrar_inspecciones_trabajador.idAnalisis ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrTrabajadores = array();
$arrTrabajadores = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_trabajador', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajadores');

/***************************************************/
// Se trae un listado con todas las maquinas
$SIS_query = '
maquinas_listado.Nombre,
maquinas_listado.Codigo';
$SIS_join  = 'LEFT JOIN `maquinas_listado`  ON maquinas_listado.idMaquina   = cross_quality_registrar_inspecciones_maquina.idMaquina';
$SIS_where = 'cross_quality_registrar_inspecciones_maquina.idAnalisis ='.$X_Puntero;
$SIS_order = 'maquinas_listado.Nombre ASC';
$arrMaquinas = array();
$arrMaquinas = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_maquina', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMaquinas');

/***************************************************/
// Se trae un listado con todas las muestras
$SIS_query = '
cross_quality_registrar_inspecciones_muestras.idMuestras, 
cross_quality_registrar_inspecciones_muestras.n_folio_pallet,
cross_quality_registrar_inspecciones_muestras.lote,
productores_listado.Nombre AS ClienteNombre';
$SIS_join  = 'LEFT JOIN `productores_listado`  ON productores_listado.idProductor   = cross_quality_registrar_inspecciones_muestras.idProductor';
$SIS_where = 'cross_quality_registrar_inspecciones_muestras.idAnalisis ='.$X_Puntero;
$SIS_order = 'productores_listado.Nombre ASC';
$arrMuestras = array();
$arrMuestras = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_muestras', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMuestras');

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Print.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
$html ='<section class="invoice">';
$html .= '
	<section class="invoice">

		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header">
					<i class="fa fa-globe" aria-hidden="true"></i>'.$rowData['TipoAnalisis'].'.
					<small class="pull-right">Fecha Creacion: '.Fecha_estandar($rowData['fecha_auto']).'</small>
				</h2>
			</div>
		</div>

		<div class="row invoice-info">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
				Datos Básicos
				<address>
					<strong>Producto</strong><br/>
					'.$rowData['ProductoCategoria'].', '.$rowData['ProductoNombre'].'<br/>
					Ubicación: '.$rowData['UbicacionNombre'];
					if(isset($rowData['UbicacionNombre_lvl_1'])&&$rowData['UbicacionNombre_lvl_1']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_1'];}
					if(isset($rowData['UbicacionNombre_lvl_2'])&&$rowData['UbicacionNombre_lvl_2']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_2'];}
					if(isset($rowData['UbicacionNombre_lvl_3'])&&$rowData['UbicacionNombre_lvl_3']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_3'];}
					if(isset($rowData['UbicacionNombre_lvl_4'])&&$rowData['UbicacionNombre_lvl_4']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_4'];}
					if(isset($rowData['UbicacionNombre_lvl_5'])&&$rowData['UbicacionNombre_lvl_5']!=''){$html .= ' - '.$rowData['UbicacionNombre_lvl_5'];}
						
					$html .= '<br/>
				</address>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
				Fecha Creacion
				<address>
					Fecha Ingreso: '.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
					Temporada: '.$rowData['Temporada'].'<br/>
				</address>
			</div>
			   
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
				Datos Creacion
				<address>
					Sistema: '.$rowData['Sistema'].'<br/>
					Usuario: '.$rowData['Usuario'].'<br/>
				</address>	
					
			</div>
		</div>

		<div class="">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
				<table class="table">
					<thead>
						<tr>
							<th colspan="6">Detalle</th>
						</tr>
					</thead>
					<tbody>';
						if ($arrTrabajadores!=false && !empty($arrTrabajadores) && $arrTrabajadores!='') {
							$html .= '<tr class="active"><td colspan="6"><strong>Trabajadores Encargados</strong></td></tr>';
							foreach ($arrTrabajadores as $trab) {
								$html .= '
								<tr>
									<td>'.$trab['Rut'].'</td>
									<td colspan="3">'.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'</td>
									<td colspan="2">'.$trab['Cargo'].'</td>
								</tr>';
							}
						}
						if ($arrMaquinas!=false && !empty($arrMaquinas) && $arrMaquinas!='') {
							$html .= '<tr class="active"><td colspan="6"><strong>Maquinas a Utilizar</strong></td></tr>';
							foreach ($arrMaquinas as $maq) {
								$html .= '
								<tr>
									<td colspan="6">'.$maq['Codigo'].' - '.$maq['Nombre'].'</td>
								</tr>';
							}
						}
						if ($arrMuestras!=false && !empty($arrMuestras) && $arrMuestras!='') {
							$html .= '
							<tr class="active"><td colspan="6"><strong>Muestras</strong></td></tr>
							<tr class="active">
								<td colspan="2"><strong>Productor</strong></td>
								<td colspan="2"><strong>N° Folio / Pallet</strong></td>
								<td colspan="2"><strong>Lote</strong></td>
							</tr>';
							foreach ($arrMuestras as $muestra) {
								$html .= '
								<tr>
									<td colspan="2">'.$muestra['ClienteNombre'].'</td>
									<td colspan="2">'.$muestra['n_folio_pallet'].'</td>
									<td colspan="2">'.$muestra['lote'].'</td>
								</tr>';
							}
						}
						$html .= '
					</tbody>
				</table>

			</div>
		</div>

		<div class="col-xs-12">
			<div class="row">
				<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
				<p class="text-muted well well-sm no-shadow" >'.$rowData['Observaciones'].'</p>
			</div>
		</div>
	</section>';

echo $html;
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
