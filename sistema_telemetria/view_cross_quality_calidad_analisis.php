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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['viewMuestra'])){
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
$X_viewMuestra = simpleDecode($_GET['viewMuestra'], fecha_actual());
$X_cantPuntos  = simpleDecode($_GET['cantPuntos'], fecha_actual());
$X_idCalidad   = simpleDecode($_GET['idCalidad'], fecha_actual());
/***********************************************/
//Armo cadena
$SIS_query  = 'Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3';
for ($i = 1; $i <= $X_cantPuntos; $i++) {
	$SIS_query .= ',PuntoNombre_'.$i;
	$SIS_query .= ',PuntoidTipo_'.$i;
	$SIS_query .= ',PuntoidGrupo_'.$i;
	$SIS_query .= ',PuntoUniMed_'.$i;
}

// consulto los datos
$SIS_join  = '';
$SIS_where = 'idMatriz ='.$X_idCalidad;
$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***********************************************/
//Armo cadena
$subquery  = '';
for ($i = 1; $i <= $X_cantPuntos; $i++) {
	$subquery .= ',cross_quality_analisis_calidad_muestras.Medida_'.$i;
}

// consulto los datos
$SIS_query = '
cross_quality_analisis_calidad_muestras.n_folio_pallet,
cross_quality_analisis_calidad_muestras.lote,
cross_quality_analisis_calidad_muestras.f_embalaje,
cross_quality_analisis_calidad_muestras.f_cosecha,
cross_quality_analisis_calidad_muestras.H_inspeccion,
cross_quality_analisis_calidad_muestras.cantidad,
cross_quality_analisis_calidad_muestras.peso, 
cross_quality_analisis_calidad_muestras.Resolucion_1,
cross_quality_analisis_calidad_muestras.Resolucion_2,
cross_quality_analisis_calidad_muestras.Resolucion_3,
productores_listado.Nombre AS Cliente,
sistema_cross_analisis_embalaje.Nombre AS Tipo'.$subquery;
$SIS_join  = '
LEFT JOIN `productores_listado`               ON productores_listado.idProductor         = cross_quality_analisis_calidad_muestras.idProductor
LEFT JOIN `sistema_cross_analisis_embalaje`   ON sistema_cross_analisis_embalaje.idTipo  = cross_quality_analisis_calidad_muestras.idTipo';
$SIS_where = 'cross_quality_analisis_calidad_muestras.idMuestras ='.$X_viewMuestra;
$rowMuestras = db_select_data (false, $SIS_query, 'cross_quality_analisis_calidad_muestras', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowMuestras');

/***********************************************/
// Se consulta
$SIS_query = 'idGrupo, Nombre,Totales';
$SIS_join  = '';
$SIS_where = 'Nombre!=""';
$SIS_order = 'Nombre ASC';
$arrGrupo = array();
$arrGrupo = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupo');

/***********************************************/
// Se consulta
$SIS_query = 'idUml, Nombre';
$SIS_join  = '';
$SIS_where = 'Nombre!=""';
$SIS_order = 'Nombre ASC';
$arrUnidadMedida = array();
$arrUnidadMedida = db_select_array (false, $SIS_query, 'sistema_cross_analisis_uml', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnidadMedida');	
	
?>	
		
<section class="invoice">

	<div class="row">

		<div class="col-xs-4">
			<p class="lead">Datos Básicos:</p>
			<p class="text-muted well well-sm no-shadow" >
				<strong>Productor: </strong>                 <?php echo $rowMuestras['Cliente'].'<br/>'; ?>
				<strong>N° Folio / Pallet: </strong>         <?php echo $rowMuestras['n_folio_pallet'].'<br/>'; ?>
				<strong>Tipo Embalaje: </strong>             <?php echo $rowMuestras['Tipo'].'<br/>'; ?>
				<strong>Lote: </strong>                      <?php echo $rowMuestras['lote'].'<br/>'; ?>
				<strong>Fecha Embalaje: </strong>            <?php echo fecha_estandar($rowMuestras['f_embalaje']).'<br/>'; ?>
				<strong>Fecha Cosecha: </strong>             <?php echo fecha_estandar($rowMuestras['f_cosecha']).'<br/>'; ?>
				<strong>Hora Inspeccion: </strong>           <?php echo $rowMuestras['H_inspeccion'].' hrs.<br/>'; ?>
				<strong>N° Cajas/Bolsas/Racimos: </strong>   <?php echo $rowMuestras['cantidad'].'<br/>'; ?>
				<strong>Peso Caja: </strong>                 <?php echo $rowMuestras['peso'].'<br/>'; ?>
			</p>
		</div>

		<?php
		foreach ($arrGrupo as $grupo) {
			//Cuento si hay items dentro de la categoria
			$x_con = 0;
			for ($i = 1; $i <= $X_cantPuntos; $i++) {
				if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
					$x_con++;
				}
			}
					
			//si hay items se muestra todo
			if($x_con!=0){
				//Variable subtotal
				$subto = 0;
				//se arma la ventana
				echo '
				<div class="col-xs-4">
					<p class="lead">'.$grupo['Nombre'].'</p>
					<p class="text-muted well well-sm no-shadow" >';
					
					for ($i = 1; $i <= $X_cantPuntos; $i++) {
						if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
							//sumo subtotales
							$subto = $subto + $rowMuestras['Medida_'.$i];
							//verifico unidad de medida
							$xuni = '';
							foreach ($arrUnidadMedida as $uml) {
								if($rowData['PuntoUniMed_'.$i]==$uml['idUml']){
									$xuni = ' '.$uml['Nombre'];
								}
							}
									
							//Verifico el tipo de dato
							switch ($rowData['PuntoidTipo_'.$i]) {
								//Medicion (Decimal) con parametros limitantes
								case 1:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].$xuni.'<br/>';
									break;
								//Medicion (Decimal) sin parametros limitantes
								case 2:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].$xuni.'<br/>';
									break;
								//Medicion (Enteros) con parametros limitantes
								case 3:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].$xuni.'<br/>';
									break;
								//Medicion (Enteros) sin parametros limitantes
								case 4:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].$xuni.'<br/>';
									break;
								//Fecha
								case 5:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.fecha_estandar($rowMuestras['Medida_'.$i]).'<br/>';
									break;
								//Hora
								case 6:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].' hrs.<br/>';
									break;
								//Texto Libre
								case 7:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].'<br/>';
									break;
								//Seleccion 1 a 3
								case 8:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].'<br/>';
									break;
								//Seleccion 1 a 5
								case 9:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].'<br/>';
									break;
								//Seleccion 1 a 10
								case 10:
									echo '<strong>'.$rowData['PuntoNombre_'.$i].': </strong>'.$rowMuestras['Medida_'.$i].'<br/>';
									break;

							}
						}
					}
					//Se muestran los subtotales
					if(isset($grupo['Totales'])&&$grupo['Totales']==1){
						echo '<br/><strong>Total: </strong>'.$subto.$xuni.'<br/>';
					}
				echo '</p>
				</div>';
			}
		}

		//se arma la ventana
		echo '
		<div class="col-xs-4">
			<p class="lead">Decision</p>
			<p class="text-muted well well-sm no-shadow" >';
			//Nota Calidad
			if(isset($rowData['idNota_1'])&&$rowData['idNota_1']==1){
				echo '<strong>Nota Calidad: </strong>'.$rowMuestras['Resolucion_1'].'<br/>';
			}
			//Nota Condición
			if(isset($rowData['idNota_2'])&&$rowData['idNota_2']==1){
				echo '<strong>Nota Condición: </strong>'.$rowMuestras['Resolucion_2'].'<br/>';
			}
			//Calificacion
			if(isset($rowData['idNota_3'])&&$rowData['idNota_3']==1){
				echo '<strong>Calificacion: </strong>'.$rowMuestras['Resolucion_3'].'<br/>';
			}
								
		echo '</p>
		</div>';

		?>

	</div>
      
</section>		


<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="view_cross_quality_calidad_analisis.php?view=<?php echo $_GET['view']; ?>"  class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
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
cross_quality_analisis_calidad.fecha_auto,
cross_quality_analisis_calidad.Creacion_fecha,
cross_quality_analisis_calidad.Temporada,
cross_quality_analisis_calidad.Observaciones,
core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
core_cross_quality_analisis_calidad.Nombre AS TipoAnalisis,
sistema_productos_categorias.Nombre AS ProductoCategoria,
productos_listado.Nombre AS ProductoNombre,
cross_quality_calidad_matriz.cantPuntos AS Producto_cantPuntos,
productos_listado.idCalidad AS Producto_idCalidad,
ubicacion_listado.Nombre AS UbicacionNombre,
ubicacion_listado_level_1.Nombre AS UbicacionNombre_lvl_1,
ubicacion_listado_level_2.Nombre AS UbicacionNombre_lvl_2,
ubicacion_listado_level_3.Nombre AS UbicacionNombre_lvl_3,
ubicacion_listado_level_4.Nombre AS UbicacionNombre_lvl_4,
ubicacion_listado_level_5.Nombre AS UbicacionNombre_lvl_5';
$SIS_join  = '
LEFT JOIN `core_sistemas`                          ON core_sistemas.idSistema                      = cross_quality_analisis_calidad.idSistema
LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                   = cross_quality_analisis_calidad.idUsuario
LEFT JOIN `core_cross_quality_analisis_calidad`    ON core_cross_quality_analisis_calidad.idTipo   = cross_quality_analisis_calidad.idTipo
LEFT JOIN `sistema_productos_categorias`           ON sistema_productos_categorias.idCategoria     = cross_quality_analisis_calidad.idCategoria
LEFT JOIN `productos_listado`                      ON productos_listado.idProducto                 = cross_quality_analisis_calidad.idProducto
LEFT JOIN `ubicacion_listado`                      ON ubicacion_listado.idUbicacion                = cross_quality_analisis_calidad.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`              ON ubicacion_listado_level_1.idLevel_1          = cross_quality_analisis_calidad.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`              ON ubicacion_listado_level_2.idLevel_2          = cross_quality_analisis_calidad.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`              ON ubicacion_listado_level_3.idLevel_3          = cross_quality_analisis_calidad.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`              ON ubicacion_listado_level_4.idLevel_4          = cross_quality_analisis_calidad.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`              ON ubicacion_listado_level_5.idLevel_5          = cross_quality_analisis_calidad.idUbicacion_lvl_5
LEFT JOIN `cross_quality_calidad_matriz`           ON cross_quality_calidad_matriz.idMatriz        = productos_listado.idCalidad';
$SIS_where = 'cross_quality_analisis_calidad.idAnalisis ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_quality_analisis_calidad', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
// Se trae un listado con todos los trabajadores
$SIS_query = '
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat, 
trabajadores_listado.ApellidoMat,
trabajadores_listado.Cargo, 
trabajadores_listado.Rut';
$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = cross_quality_analisis_calidad_trabajador.idTrabajador';
$SIS_where = 'cross_quality_analisis_calidad_trabajador.idAnalisis ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrTrabajadores = array();
$arrTrabajadores = db_select_array (false, $SIS_query, 'cross_quality_analisis_calidad_trabajador', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajadores');

/***************************************************/
// Se trae un listado con todas las maquinas
$SIS_query = 'maquinas_listado.Nombre';
$SIS_join  = 'LEFT JOIN `maquinas_listado` ON maquinas_listado.idMaquina = cross_quality_analisis_calidad_maquina.idMaquina';
$SIS_where = 'cross_quality_analisis_calidad_maquina.idAnalisis ='.$X_Puntero;
$SIS_order = 'maquinas_listado.Nombre ASC';
$arrMaquinas = array();
$arrMaquinas = db_select_array (false, $SIS_query, 'cross_quality_analisis_calidad_maquina', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMaquinas');

/***************************************************/
// Se trae un listado con todas las muestras
$SIS_query = '
cross_quality_analisis_calidad_muestras.idMuestras, 
cross_quality_analisis_calidad_muestras.n_folio_pallet,
cross_quality_analisis_calidad_muestras.lote,
productores_listado.Nombre AS ClienteNombre';
$SIS_join  = 'LEFT JOIN `productores_listado` ON productores_listado.idProductor = cross_quality_analisis_calidad_muestras.idProductor';
$SIS_where = 'cross_quality_analisis_calidad_muestras.idAnalisis ='.$X_Puntero;
$SIS_order = 'cross_quality_analisis_calidad_muestras.idMuestras ASC';
$arrMuestras = array();
$arrMuestras = db_select_array (false, $SIS_query, 'cross_quality_analisis_calidad_muestras', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMuestras');

/***************************************************/
// Se trae un listado con todos los archivos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idAnalisis ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'cross_quality_analisis_calidad_archivo', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['TipoAnalisis']?>.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['fecha_auto']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Datos Básicos
			<address>
				<strong>Producto</strong><br/>
				<?php echo $rowData['ProductoCategoria'].', '.$rowData['ProductoNombre']; ?><br/>
				Ubicación: <?php echo $rowData['UbicacionNombre']; ?>
				<?php
					if(isset($rowData['UbicacionNombre_lvl_1'])&&$rowData['UbicacionNombre_lvl_1']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_1'];}
					if(isset($rowData['UbicacionNombre_lvl_2'])&&$rowData['UbicacionNombre_lvl_2']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_2'];}
					if(isset($rowData['UbicacionNombre_lvl_3'])&&$rowData['UbicacionNombre_lvl_3']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_3'];}
					if(isset($rowData['UbicacionNombre_lvl_4'])&&$rowData['UbicacionNombre_lvl_4']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_4'];}
					if(isset($rowData['UbicacionNombre_lvl_5'])&&$rowData['UbicacionNombre_lvl_5']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_5'];}
				?>
				<br/>
			</address>
		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Fecha Creacion
			<address>
				Fecha Ingreso: <?php echo Fecha_estandar($rowData['Creacion_fecha']); ?><br/>
				Temporada: <?php echo $rowData['Temporada']; ?><br/>
			</address>
		</div>
			   
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Datos Creacion
			<address>
				Sistema: <?php echo $rowData['Sistema']; ?><br/>
				Usuario: <?php echo $rowData['Usuario']; ?><br/>
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
				<tbody>
					<?php if ($arrTrabajadores!=false && !empty($arrTrabajadores) && $arrTrabajadores!='') { ?>
						<tr class="active"><td colspan="6"><strong>Trabajadores Encargados</strong></td></tr>
						<?php foreach ($arrTrabajadores as $trab) { ?>
							<tr>
								<td><?php echo $trab['Rut']; ?></td>
								<td colspan="3"><?php echo $trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat']; ?></td>
								<td colspan="2"><?php echo $trab['Cargo']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrMaquinas!=false && !empty($arrMaquinas) && $arrMaquinas!='') { ?>
						<tr class="active"><td colspan="6"><strong>Maquinas a Utilizar</strong></td></tr>
						<?php foreach ($arrMaquinas as $maq) { ?>
							<tr>
								<td colspan="6"><?php echo $maq['Nombre']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrMuestras!=false && !empty($arrMuestras) && $arrMuestras!='') { ?>
						<tr class="active"><td colspan="6"><strong>Muestras</strong></td></tr>
						<tr class="active">
							<td colspan="2"><strong>Productor</strong></td>
							<td colspan="2"><strong>N° Folio / Pallet</strong></td>
							<td><strong>Lote</strong></td>
							<td></td>
						</tr>
						<?php foreach ($arrMuestras as $muestra) { ?>
							<tr>
								<td colspan="2"><?php echo $muestra['ClienteNombre']; ?></td>
								<td colspan="2"><?php echo $muestra['n_folio_pallet']; ?></td>
								<td><?php echo $muestra['lote']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a href="<?php echo 'view_cross_quality_calidad_analisis.php?view='.$_GET['view'].'&viewMuestra='.simpleEncode($muestra['idMuestras'], fecha_actual()).'&cantPuntos='.simpleEncode($rowData['Producto_cantPuntos'], fecha_actual()).'&idCalidad='.simpleEncode($rowData['Producto_idCalidad'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>
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

	<?php if ($arrArchivos!=false && !empty($arrArchivos) && $arrArchivos!=''){ ?>
		<table id="items" style="margin-bottom: 20px;">
			<tbody>
				<tr>
					<th colspan="6">Archivos Adjuntos</th>
				</tr>
				<?php foreach ($arrArchivos as $producto){ ?>
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

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
