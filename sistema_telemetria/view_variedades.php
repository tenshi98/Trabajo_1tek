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
variedades_listado.Nombre,
variedades_listado.Descripcion,
variedades_listado.Codigo,
variedades_listado.Direccion_img,
variedades_listado.idTipoImagen,
sistema_variedades_categorias.Nombre AS Categoria,
sistema_variedades_tipo.Nombre AS Tipo,
variedades_listado.FichaTecnica,
variedades_listado.HDS,
core_estados.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `sistema_variedades_tipo`       ON sistema_variedades_tipo.idTipo             = variedades_listado.idTipo
LEFT JOIN `sistema_variedades_categorias` ON sistema_variedades_categorias.idCategoria  = variedades_listado.idCategoria
LEFT JOIN `core_estados`                  ON core_estados.idEstado                      = variedades_listado.idEstado';
$SIS_where = 'variedades_listado.idProducto ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'variedades_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos de la variedad <?php echo $rowData['Nombre']; ?></h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/productos.jpg">
						<?php }else{
							echo widget_TipoImagen($rowData['idTipoImagen'], DB_SITE_REPO, DB_SITE_MAIN_PATH, 'upload', $rowData['Direccion_img']);
						} ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Producto</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Codigo : </strong><?php echo $rowData['Codigo']; ?><br/>
							<strong>Especie : </strong><?php echo $rowData['Categoria']; ?><br/>
							<strong>Grupo Especie : </strong><?php echo $rowData['Tipo']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Descripción</h2>
						<p class="text-muted"><?php echo $rowData['Descripcion']; ?></p>
						
						
						
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<p class="text-muted">
							<?php
							//Ficha Tecnica
							if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['FichaTecnica'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Ficha Tecnica</a>';
							}
							//Hoja de seguridad
							if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['HDS'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Hoja de Seguridad</a>';
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
