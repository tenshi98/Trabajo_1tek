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
//se recorre deacuerdo a la cantidad de sensores
$subquery = '';
$Nsens = 6;
for ($i = 1; $i <= $Nsens; $i++) {
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Prom';
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Min';
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Max';
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS Sensor_'.$i.'_Nombre';
}

$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_termino,

cross_predios_listado.Nombre AS PredioNombre,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
cross_predios_listado_zonas.Plantas AS CuartelCantPlantas,

telemetria_listado.Nombre AS NebNombre,
vehiculos_listado.Nombre AS TractorNombre,
telemetria_listado.cantSensores,
cross_solicitud_aplicacion_listado_tractores.idTractores,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,
cross_solicitud_aplicacion_listado_tractores.GeoDistance,
cross_solicitud_aplicacion_listado_tractores.idTelemetria,

cross_solicitud_aplicacion_listado_cuarteles.VelTractor,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
cross_solicitud_aplicacion_listado.f_ejecucion'.$subquery ;
$SIS_join  = '
LEFT JOIN `cross_solicitud_aplicacion_listado`             ON cross_solicitud_aplicacion_listado.idSolicitud             = cross_solicitud_aplicacion_listado_tractores.idSolicitud
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles   = cross_solicitud_aplicacion_listado_tractores.idCuarteles
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                            = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                               = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `telemetria_listado_sensores_nombre`             ON telemetria_listado_sensores_nombre.idTelemetria            = cross_solicitud_aplicacion_listado_tractores.idTelemetria';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idTractores ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************/
$subquery = '';
$subquery .= ',FechaSistema';
$subquery .= ',HoraSistema';
$subquery .= ',GeoLatitud';
$subquery .= ',GeoLongitud';
$subquery .= ',GeoVelocidad';
//se recorre deacuerdo a la cantidad de sensores
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	$subquery .= ',Sensor_'.$i;
}

$arrMediciones = array();
$arrMediciones = db_select_array (false, 'idTabla'.$subquery, 'telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'], '', 'idZona = '.$rowData['idZona'].' AND idSolicitud = '.$rowData['idSolicitud'], 'FechaSistema ASC, HoraSistema ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

//Se traen las rutas
$arrPuntos = array();
$arrPuntos = db_select_array (false, 'idUbicaciones, Latitud, Longitud', 'cross_predios_listado_zonas_ubicaciones', '', 'idZona = '.$rowData['idZona'], 'idUbicaciones ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPuntos');

//datos para el grafico
$Temp_1   = '';
$arrData  = array();
foreach ($arrMediciones as $med) {
	//Se obtiene la fecha
	$Temp_1 .= "'".$med['HoraSistema']."',";

	if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){$arrData[1]['Value'] .= ", ".$med['Sensor_1'];       }else{ $arrData[1]['Value'] = $med['Sensor_1'];}
	if(isset($arrData[2]['Value'])&&$arrData[2]['Value']!=''){$arrData[2]['Value'] .= ", ".$med['Sensor_2'];       }else{ $arrData[2]['Value'] = $med['Sensor_2'];}
	if(isset($arrData[3]['Value'])&&$arrData[3]['Value']!=''){$arrData[3]['Value'] .= ", ".$med['Sensor_3'];       }else{ $arrData[3]['Value'] = $med['Sensor_3'];}
	if(isset($arrData[4]['Value'])&&$arrData[4]['Value']!=''){$arrData[4]['Value'] .= ", ".$med['GeoVelocidad'];   }else{ $arrData[4]['Value'] = $med['GeoVelocidad'];}

}

$arrData[1]['Name'] = "'Caudal Derecho'";
$arrData[2]['Name'] = "'Caudal Izquierdo'";
$arrData[3]['Name'] = "'Nivel Estanque'";
$arrData[4]['Name'] = "'Velocidad'";

?>

<style>
#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
</style>
<div id="loading"></div>
<script>
//oculto el loader
document.getElementById("loading").style.display = "none";
</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
	<input class="btn btn-sm btn-metis-3 pull-right margin_width fa-input" type="button" onclick="Export()" value="&#xf1c1; Exportar a PDF"/>
</div>
<div class="clearfix"></div>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Detalles Solicitud de Aplicacion N°<?php echo n_doc($rowData['NSolicitud'], 7); ?>.
				<small class="pull-right">Fecha Termino: <?php echo Fecha_estandar($rowData['f_termino']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Identificación</strong>
			<address>
				Predio: <?php echo $rowData['PredioNombre']; ?><br/>
				Especie: <?php echo $rowData['VariedadCat']; ?><br/>
				Variedad: <?php echo $rowData['VariedadNombre']; ?><br/>
				Cuartel: <?php echo $rowData['CuartelNombre']; ?><br/>
				Tractor: <?php echo $rowData['TractorNombre']; ?><br/>
				Nebulizador: <?php echo $rowData['NebNombre']; ?><br/>
			</address>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Velocidad Tractores (Km/hr)</strong>
			<address>
				Minima: <?php echo Cantidades($rowData['GeoVelocidadMin'], 2); ?><br/>
				Maxima: <?php echo Cantidades($rowData['GeoVelocidadMax'], 2); ?><br/>
				Promedio: <?php echo Cantidades($rowData['GeoVelocidadProm'], 2); ?><br/>
				Programada: <?php echo Cantidades($rowData['VelTractor'], 2); ?><br/>
			</address>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Distancia Recorrida(KM)</strong>
			<address>
				Recorrida: <?php echo Cantidades($rowData['GeoDistance'], 2); ?><br/>
				Estimada: <?php echo Cantidades(($rowData['CuartelDistanciaPlant']*$rowData['CuartelCantPlantas'])/1000, 2); ?><br/>
				Faltante: <?php echo Cantidades((($rowData['CuartelDistanciaPlant']*$rowData['CuartelCantPlantas'])/1000) - $rowData['GeoDistance'], 2); ?><br/>
		</div>

	</div>

	<div class="row" style="margin-bottom:15px;">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Sensor</th>
						<th>Minimo</th>
						<th>Maximo</th>
						<th>Promedio</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 1; $i <= $rowData['cantSensores']; $i++) {  ?>
						<tr>
							<td><?php echo $rowData['Sensor_'.$i.'_Nombre']; ?></td>
							<td><?php echo Cantidades($rowData['Sensor_'.$i.'_Min'], 1); ?></td>
							<td><?php echo Cantidades($rowData['Sensor_'.$i.'_Max'], 1); ?></td>
							<td><?php echo Cantidades($rowData['Sensor_'.$i.'_Prom'], 1); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row" style="margin-bottom:15px;">
		<div id="charts" class="col-xs-12" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<?php
			/*******************************************************************************/
			//las fechas
			$Graphics_xData      ='var xData = [['.$Temp_1.'],['.$Temp_1.'],];';
			//los valores
			$Graphics_yData      ='var yData = [['.$arrData[1]['Value'].'],['.$arrData[2]['Value'].'],];';
			//los nombres
			$Graphics_names      = 'var names = ['.$arrData[1]['Name'].','.$arrData[2]['Name'].',];';
			//los tipos
			$Graphics_types      = "var types = ['','',];";
			//si lleva texto en las burbujas
			$Graphics_texts      = "var texts = [[],[],];";
			//los colores de linea
			$Graphics_lineColors = "var lineColors = ['','',];";
			//los tipos de linea
			$Graphics_lineDash   = "var lineDash = ['','',];";
			//los anchos de la linea
			$Graphics_lineWidth  = "var lineWidth = ['','',];";

			$gr_tittle = 'Grafico Caudal / Homogeneidad';
			$gr_unimed = 'Litros * Minutos';
			echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Hora', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
			/*******************************************************************************/
			//las fechas
			$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
			//los valores
			$Graphics_yData      ='var yData = [['.$arrData[3]['Value'].'],];';
			//los nombres
			$Graphics_names      = 'var names = ['.$arrData[3]['Name'].',];';
			//los tipos
			$Graphics_types      = "var types = ['',];";
			//si lleva texto en las burbujas
			$Graphics_texts      = "var texts = [[],];";
			//los colores de linea
			$Graphics_lineColors = "var lineColors = ['',];";
			//los tipos de linea
			$Graphics_lineDash   = "var lineDash = ['',];";
			//los anchos de la linea
			$Graphics_lineWidth  = "var lineWidth = ['',];";

			$gr_tittle = 'Grafico Nivel Estanque';
			$gr_unimed = '% de llenado';
			echo GraphLinear_1('graphLinear_2', $gr_tittle, 'Hora', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
			/*******************************************************************************/
			//las fechas
			$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
			//los valores
			$Graphics_yData      ='var yData = [['.$arrData[4]['Value'].'],];';
			//los nombres
			$Graphics_names      = 'var names = ['.$arrData[4]['Name'].',];';
			//los tipos
			$Graphics_types      = "var types = ['',];";
			//si lleva texto en las burbujas
			$Graphics_texts      = "var texts = [[],];";
			//los colores de linea
			$Graphics_lineColors = "var lineColors = ['',];";
			//los tipos de linea
			$Graphics_lineDash   = "var lineDash = ['',];";
			//los anchos de la linea
			$Graphics_lineWidth  = "var lineWidth = ['',];";

			$gr_tittle = 'Grafico Velocidades';
			$gr_unimed = 'Km * hr';
			echo GraphLinear_1('graphLinear_3', $gr_tittle, 'Hora', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 

			?>
		</div>
	</div>

</section>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
	<?php
	$Alert_Text = 'Ver mapa';
	$Alert_Text.= '<a href="view_solicitud_aplicacion_finalizada_view_mapa.php?idTelemetria='.simpleEncode($rowData['idTelemetria'], fecha_actual()).'&idSolicitud='.simpleEncode($rowData['idSolicitud'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" class="btn btn-primary pull-right margin_form_btn"><i class="fa fa-map-o" aria-hidden="true"></i> Ver mapas</a>';
	alert_post_data(4,2,2,0, $Alert_Text);
	?>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: none;">

	<form method="post" id="make_pdf" action="view_solicitud_aplicacion_detalles_to_pdf.php">
		<input type="hidden" name="img_adj" id="img_adj" />

		<input type="hidden" name="idSistema"  id="idSistema"  value="<?php echo simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()); ?>" />
		<input type="hidden" name="view"       id="view"       value="<?php echo $_GET['view']; ?>" />

		<button type="button" name="create_pdf" id="create_pdf" class="btn btn-danger btn-xs">Hacer PDF</button>

	</form>

	<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/dom-to-image.min.js"></script>
	<script>
		var node = document.getElementById('charts');

		function sendDatatoSRV(img) {
			$('#img_adj').val(img);
			//$('#img_adj').val($('#img-out').html());
			$('#make_pdf').submit();
			//oculto el loader
			document.getElementById("loading").style.display = "none";
		}
		function Export() {
			//muestro el loader
			document.getElementById("loading").style.display = "block";
			//Exporto
			setTimeout(
				function(){
					domtoimage.toPng(node)
					.then(function (dataUrl) {
						var img = new Image();
						img.src = dataUrl;
						//document.getElementById('img-out').appendChild(img);
						//alert(img.src);
						sendDatatoSRV(img.src);
					})
					.catch(function (error) {
						console.error('oops, something went wrong!', error);
						Swal.fire({icon: 'error',title: 'Oops...',text: 'No se puede exportar!'});
						document.getElementById("loading").style.display = "none";
					});
				}
			, 3000);
		}
	</script>
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
