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
postulantes_listado.Direccion_img, 
core_estados.Nombre AS Estado,
core_sistemas.Nombre AS Sistema,
postulantes_listado.Nombre,
postulantes_listado.ApellidoPat,
postulantes_listado.ApellidoMat, 
core_sexo.Nombre AS Sexo,
postulantes_listado.FNacimiento,
core_estado_civil.Nombre AS EstadoCivil,
postulantes_listado.Fono1,
postulantes_listado.Fono2,
postulantes_listado.Rut,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
postulantes_listado.Direccion,
postulantes_listado.Observaciones,
postulantes_listado.SueldoLiquido,
core_tipos_licencia_conducir.Nombre AS LicenciaTipo,
postulantes_listado.File_Curriculum';
$SIS_join  = '
LEFT JOIN `core_estados`                     ON core_estados.idEstado                         = postulantes_listado.idEstado
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                       = postulantes_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad                = postulantes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna               = postulantes_listado.idComuna
LEFT JOIN `core_tipos_licencia_conducir`     ON core_tipos_licencia_conducir.idTipoLicencia   = postulantes_listado.idTipoLicencia
LEFT JOIN `core_sexo`                        ON core_sexo.idSexo                              = postulantes_listado.idSexo
LEFT JOIN `core_estado_civil`                ON core_estado_civil.idEstadoCivil               = postulantes_listado.idEstadoCivil';
$SIS_where = 'postulantes_listado.idPostulante ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'postulantes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ver Datos del Postulante</h5>
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
							<strong>Sexo : </strong><?php echo $rowData['Sexo']; ?><br/>
							<strong>Fecha de Nacimiento : </strong><?php echo Fecha_estandar($rowData['FNacimiento']); ?><br/>
							<strong>Fono1 : </strong><?php echo formatPhone($rowData['Fono1']); ?><br/>
							<strong>Fono2 : </strong><?php echo formatPhone($rowData['Fono2']); ?><br/>
							<strong>Dirección : </strong><?php echo $rowData['Direccion'].', '.$rowData['nombre_comuna'].', '.$rowData['nombre_region']; ?><br/>
							<strong>Estado Civil: </strong><?php echo $rowData['EstadoCivil']; ?><br/>
							<strong>Tipo de Licencia : </strong><?php echo $rowData['LicenciaTipo']; ?><br/>
							<strong>Pretenciones : </strong><?php echo valores($rowData['SueldoLiquido'], 0); ?><br/>

							<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowData['Sistema']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Estudios</h2>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Cursos</h2>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Experiencia Laboral</h2>
						
						

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Otros Datos</h2>
						<p class="text-muted word_break">
							<strong>Observaciones : </strong><br/>
							<div class="text-muted well well-sm no-shadow">
								<?php if(isset($rowData['Observaciones'])&&$rowData['Observaciones']!=''){echo $rowData['Observaciones'];}else{echo 'Sin Observaciones';} ?>
								<div class="clearfix"></div>
							</div>
						</p>
							

						
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<p class="text-muted">
							<?php
							//Curriculum
							if(isset($rowData['File_Curriculum'])&&$rowData['File_Curriculum']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Curriculum'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Curriculum</a>';
							}
							?>
						</p>

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
