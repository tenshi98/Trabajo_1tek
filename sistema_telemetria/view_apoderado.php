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
apoderados_listado.Direccion_img,
apoderados_listado.Nombre,
apoderados_listado.ApellidoPat,
apoderados_listado.ApellidoMat, 
apoderados_listado.Rut,
apoderados_listado.Password,
apoderados_listado.FNacimiento,
apoderados_listado.Fono1,
apoderados_listado.Fono2,
apoderados_listado.GeoLatitud,
apoderados_listado.GeoLongitud,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
apoderados_listado.Direccion,
core_estados.Nombre AS Estado,
core_sistemas.Nombre AS Sistema,
apoderados_listado.F_Inicio_Contrato,
apoderados_listado.F_Termino_Contrato,
apoderados_listado.File_Contrato';
$SIS_join  = '
LEFT JOIN `core_estados`            ON core_estados.idEstado            = apoderados_listado.idEstado
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema          = apoderados_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad   = apoderados_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna  = apoderados_listado.idComuna';
$SIS_where = 'apoderados_listado.idApoderado ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************************************************/
//Se consultan datos
$SIS_query = '
apoderados_listado_hijos.Nombre,
apoderados_listado_hijos.ApellidoPat, 
apoderados_listado_hijos.ApellidoMat,
apoderados_listado_hijos.Direccion_img,
core_sexo.Nombre AS Sexo,
sistema_planes.Nombre AS PlanNombre,
sistema_planes.Valor AS PlanValor';
$SIS_join  = '
LEFT JOIN `core_sexo`       ON core_sexo.idSexo       = apoderados_listado_hijos.idSexo
LEFT JOIN `sistema_planes`  ON sistema_planes.idPlan  = apoderados_listado_hijos.idPlan';
$SIS_where = 'apoderados_listado_hijos.idApoderado ='.$X_Puntero;
$SIS_order = 'apoderados_listado_hijos.idHijos ASC';
$arrCargas = array();
$arrCargas = db_select_array (false, $SIS_query, 'apoderados_listado_hijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCargas');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos del Apoderado</h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">

				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat']; ?><br/>
							<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
							<strong>Fecha de Nacimiento : </strong><?php echo Fecha_estandar($rowData['FNacimiento']); ?><br/>
							<strong>Fono : </strong><?php echo formatPhone($rowData['Fono1']); ?><br/>
							<strong>Fono : </strong><?php echo formatPhone($rowData['Fono2']); ?><br/>
							<strong>Dirección : </strong><?php echo $rowData['Direccion'].', '.$rowData['nombre_comuna'].', '.$rowData['nombre_region']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowData['Sistema']; ?><br/>
							<strong>Fecha de Inicio Contrato : </strong><?php if(isset($rowData['F_Inicio_Contrato'])&&$rowData['F_Inicio_Contrato']!='0000-00-00'){echo Fecha_estandar($rowData['F_Inicio_Contrato']);}else{echo 'Sin fecha de inicio';} ?><br/>
							<strong>Fecha de Termino Contrato : </strong><?php if(isset($rowData['F_Termino_Contrato'])&&$rowData['F_Termino_Contrato']!='0000-00-00'){echo Fecha_estandar($rowData['F_Termino_Contrato']);}else{echo 'Sin fecha de termino';} ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Acceso APP</h2>
						<p class="text-muted">
							<strong>Usuario : </strong><?php echo $rowData['Rut']; ?><br/>
							<strong>Password : </strong><?php echo $rowData['Password']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Hijos</h2>
						<div class="row">
							<?php
							//Se existen cargas estas se despliegan
							if($arrCargas!=false){
								//variable
								$n_carga = 1;
								//recorro
								foreach ($arrCargas as $carga) { ?>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
										<div class="info-box" style="box-shadow:none; color:#999 !important;">
											<span class="info-box-icon">
												 <img src="upload/<?php echo $carga['Direccion_img']; ?>" alt="hijo" height="100%" width="100%"> 
											</span>
											<div class="info-box-content">
												<span class="info-box-text"><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></span>
												<span class="info-box-text"><?php echo $carga['Sexo']; ?></span>
												<span class="info-box-number"><?php echo $carga['PlanNombre']; ?></span>
											</div>
										</div>
									</div>

								<?php 
								}
							//si no existen cargas se muestra mensaje
							}else{
								echo '<p class="text-muted">Apoderado Sin Hijos</p>';
							}
							?>
						</div>
						<div class="clearfix"></div>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<p class="text-muted">
							<?php
							//Contrato
							if(isset($rowData['File_Contrato'])&&$rowData['File_Contrato']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Contrato'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Contrato</a>';
							} ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Ubicación</h2>
						<?php echo mapa_from_gps($rowData['GeoLatitud'], $rowData['GeoLongitud'], 'Dirección', 'Calle', $rowData['Direccion'], $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1); ?>
											
					</div>
					<div class="clearfix"></div>

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
