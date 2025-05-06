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
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "principal_software.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
//Filtro
if(isset($_GET['filterCat'])&&$_GET['filterCat']!=''){
	$SIS_where = 'soporte_software_listado.idCategoria='.$_GET['filterCat'];
}else{
	$SIS_where = '';
}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'Nombre', 'soporte_software_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
soporte_software_listado.Nombre,
soporte_software_listado.Descripcion,
soporte_software_listado.Peso,
soporte_software_listado.SitioWeb,
soporte_software_listado.SitioDescarga,

soporte_software_listado_licencias.Nombre AS Licencia,
soporte_software_listado_categorias.Nombre AS Categoria,
soporte_software_listado_medidas.Nombre AS MedidaPeso';
$SIS_join  = '
LEFT JOIN `soporte_software_listado_licencias`   ON soporte_software_listado_licencias.idLicencia     = soporte_software_listado.idLicencia
LEFT JOIN `soporte_software_listado_categorias`  ON soporte_software_listado_categorias.idCategoria   = soporte_software_listado.idCategoria
LEFT JOIN `soporte_software_listado_medidas`     ON soporte_software_listado_medidas.idMedidaPeso     = soporte_software_listado.idMedidaPeso';
$SIS_order = 'soporte_software_listado.Nombre ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrSoftware = array();
$arrSoftware = db_select_array (false, $SIS_query, 'soporte_software_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSoftware');

// Se trae un listado con todos los elementos
$SIS_query = '
soporte_software_listado_categorias.idCategoria,
soporte_software_listado_categorias.Nombre,
count(soporte_software_listado.idCategoria)AS cuenta';
$SIS_join  = 'LEFT JOIN `soporte_software_listado`  ON soporte_software_listado.idCategoria   = soporte_software_listado_categorias.idCategoria';
$SIS_where = 'soporte_software_listado_categorias.idCategoria!=0 GROUP BY soporte_software_listado_categorias.Nombre';
$SIS_order = 'soporte_software_listado_categorias.Nombre ASC';
$arrCategorias = array();
$arrCategorias = db_select_array (false, $SIS_query, 'soporte_software_listado_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategorias');

?>

<div class="row">

	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
		<?php foreach ($arrSoftware as $soft) { ?>
			<div class="block task task-high boxsoftware">
				<div class="row with-padding">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<div class="task-description">
							<a href="#"><?php echo $soft['Nombre']; ?></a>
							<i><?php echo $soft['Categoria']; ?></i>
							<span><?php echo $soft['Descripcion']; ?></span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<div class="task-info">
							<span><span class="label label-success"><?php echo $soft['Licencia']; ?></span></span>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="pull-left">
						<span></span>
					</div>
					<div class="pull-right clearfix" style="width: 70px;">
						<ul class="footer-icons-group">
							<?php if(isset($soft['SitioWeb'])&&$soft['SitioWeb']!=''){ ?><li><a href="<?php echo $soft['SitioWeb']; ?>" target="_blank" rel="noopener noreferrer" title="Ir al Sitio" class="tooltip" style="position: relative;"><i class="fa fa-firefox" aria-hidden="true"></i></a></li><?php } ?>
							<li><a href="<?php echo $soft['SitioDescarga']; ?>" target="_blank" rel="noopener noreferrer" title="Descargar" class="tooltip" style="position: relative;"><i class="fa fa-cloud-download" aria-hidden="true"></i></a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 mail-left-box">
  		<div class="list-group inbox-options">
			<?php $todos = 0; foreach ($arrCategorias as $cat) { $todos = $todos + $cat['cuenta'];} ?>

			<div class="list-group-item">Filtro</div>
			<a href="<?php echo $original.'?pagina=1'; ?>" class="list-group-item">
				<i class="fa fa-inbox" aria-hidden="true"></i> Mostrar Todos
				<span class="badge  bg-primary"><?php echo $todos; ?></span>
			</a>

			<?php foreach ($arrCategorias as $cat) { ?>
				<a href="<?php echo $original.'?pagina=1&filterCat='.$cat['idCategoria']; ?>" class="list-group-item">
					<i class="fa fa-inbox" aria-hidden="true"></i>
					<?php echo $cat['Nombre']; ?>
					<span class="badge bg-primary"><?php echo $cat['cuenta']; ?></span>
				</a>
			<?php } ?>

  		</div>
	</div>

</div>

<?php echo paginador_1($total_paginas, $original, '', $num_pag); ?>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px; margin-top:30px">
	<a href="principal.php" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
