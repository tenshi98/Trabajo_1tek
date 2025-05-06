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
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idZona ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

//Se traen las rutas
$SIS_query = 'idUbicaciones, Latitud, Longitud';
$SIS_join  = '';
$SIS_where = 'idZona ='.$X_Puntero;
$SIS_order = 'idUbicaciones ASC';
$arrPuntos = array();
$arrPuntos = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas_ubicaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPuntos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Puntos del Cuartel <?php echo $rowData['Nombre']; ?></h5>
		</header>
		<div class="tab-content">
			<div class="table-responsive">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row">
						<?php
						//Si no existe una ID se utiliza una por defecto
						if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
							$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
							alert_post_data(4,2,2,0, $Alert_Text);
						}else{
							$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>
							<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
							<div id="map_canvas" style="width: 100%; height: 550px;"></div>
							<script>
								let map;
								var marker;

								async function initMap() {
									const { Map } = await google.maps.importLibrary("maps");

									var myLatlng = new google.maps.LatLng(<?php echo $arrPuntos[0]['Latitud']; ?>, <?php echo $arrPuntos[0]['Longitud']; ?>);

									var myOptions = {
										zoom: 18,
										center: myLatlng,
										mapTypeId: google.maps.MapTypeId.SATELLITE
									};

									map = new Map(document.getElementById("map_canvas"), myOptions);
									//RutasAlternativas();
									dibuja_zona();

								}

								/* ************************************************************************** */
								function dibuja_zona() {

									var triangleCoords = [
										<?php
										//Variables con la primera posicion
										$Latitud_x       = '';
										$Longitud_x      = '';
										$Latitud_z       = 0;
										$Longitud_z      = 0;
										$Latitud_z_prom  = 0;
										$Longitud_z_prom = 0;
										$zcounter        = 0;
										//recorrer
										foreach ($arrPuntos as $puntos) {
											if(isset($puntos['Latitud'])&&$puntos['Latitud']!=''&&isset($puntos['Longitud'])&&$puntos['Longitud']!=''){
												echo '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},
												';
												if(isset($puntos['Latitud'])&&$puntos['Latitud']!='0'&&isset($puntos['Longitud'])&&$puntos['Longitud']!='0'){
													$Latitud_x = $puntos['Latitud'];
													$Longitud_x = $puntos['Longitud'];
													//Calculos para centrar mapa
													$Latitud_z  = $Latitud_z+$puntos['Latitud'];
													$Longitud_z = $Longitud_z+$puntos['Longitud'];
													$zcounter++;
												}
											}
										}
										if(isset($Longitud_x)&&$Longitud_x!=''){
											echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
										}
										//Centralizado del mapa
										$Latitud_z_prom  = $Latitud_z/$zcounter;
										$Longitud_z_prom = $Longitud_z/$zcounter;
										?>
									];

									<?php
									if(isset($Latitud_z_prom)&&$Latitud_z_prom!=0&&isset($Longitud_z_prom)&&$Longitud_z_prom!=0){
										echo 'myLatlng = new google.maps.LatLng('.$Latitud_z_prom.', '.$Longitud_z_prom.');
											map.setCenter(myLatlng);';
									} ?>

										// Construct the polygon.
										var bermudaTriangle = new google.maps.Polygon({
											paths: triangleCoords,
											strokeColor: '#FF0000',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '#FF0000',
											fillOpacity: 0.35
										});
										bermudaTriangle.setMap(map);

								}

							</script>
						<?php } ?>
					</div>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div style="margin-top:20px;">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
							<tr role="row">
								<th>Orden</th>
								<th>Ubicación</th>
							</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							$nx=1;
							foreach ($arrPuntos as $pos) { ?>
								<tr class="odd">
									<td><?php echo $nx; ?></td>
									<td><?php echo 'lat: '.$pos['Latitud'].'<br/>lng: '.$pos['Longitud']; ?></td>
								</tr>
							<?php
							$nx++;
							} ?>        
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
        
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
