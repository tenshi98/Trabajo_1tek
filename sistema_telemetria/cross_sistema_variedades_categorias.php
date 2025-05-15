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
$original = "cross_sistema_variedades_categorias.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){   $location .= "&Nombre=".$_GET['Nombre']; $search .= "&Nombre=".$_GET['Nombre'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Especie Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Especie Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Especie Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	$SIS_join  = '';
	$SIS_where = 'idCategoria = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'sistema_variedades_categorias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	sistema_variedades_categorias_matriz_calidad.idMatriz,
	cross_quality_calidad_matriz.Nombre AS Matriz,
	core_cross_quality_analisis_calidad.Nombre AS Proceso';
	$SIS_join  = '
	LEFT JOIN `cross_quality_calidad_matriz`         ON cross_quality_calidad_matriz.idMatriz         = sistema_variedades_categorias_matriz_calidad.idMatriz
	LEFT JOIN `core_cross_quality_analisis_calidad`  ON core_cross_quality_analisis_calidad.idTipo    = sistema_variedades_categorias_matriz_calidad.idProceso';
	$SIS_where = 'sistema_variedades_categorias_matriz_calidad.idCategoria = '.$_GET['id'];
	$SIS_where.= ' AND sistema_variedades_categorias_matriz_calidad.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrMatrizCalidad = array();
	$arrMatrizCalidad = db_select_array (false, $SIS_query, 'sistema_variedades_categorias_matriz_calidad', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatrizCalidad');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	sistema_variedades_categorias_matriz_proceso.idMatriz,
	cross_quality_calidad_matriz.Nombre AS Matriz,
	core_cross_quality_analisis_calidad.Nombre AS Proceso';
	$SIS_join  = '
	LEFT JOIN `cross_quality_calidad_matriz`         ON cross_quality_calidad_matriz.idMatriz         = sistema_variedades_categorias_matriz_proceso.idMatriz
	LEFT JOIN `core_cross_quality_analisis_calidad`  ON core_cross_quality_analisis_calidad.idTipo    = sistema_variedades_categorias_matriz_proceso.idProceso';
	$SIS_where = 'sistema_variedades_categorias_matriz_proceso.idCategoria = '.$_GET['id'];
	$SIS_where.= ' AND sistema_variedades_categorias_matriz_proceso.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrMatrizProceso = array();
	$arrMatrizProceso = db_select_array (false, $SIS_query, 'sistema_variedades_categorias_matriz_proceso', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatrizProceso');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	sistema_variedades_categorias_tipo_emb.idEmbalaje,
	sistema_cross_analisis_embalaje.Nombre AS Embalaje,
	core_cross_quality_analisis_calidad.Nombre AS Proceso';
	$SIS_join  = '
	LEFT JOIN `sistema_cross_analisis_embalaje`      ON sistema_cross_analisis_embalaje.idTipo        = sistema_variedades_categorias_tipo_emb.idTipo
	LEFT JOIN `core_cross_quality_analisis_calidad`  ON core_cross_quality_analisis_calidad.idTipo    = sistema_variedades_categorias_tipo_emb.idProceso';
	$SIS_where = 'sistema_variedades_categorias_tipo_emb.idCategoria = '.$_GET['id'];
	$SIS_where.= ' AND sistema_variedades_categorias_tipo_emb.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrTiposEmbalaje = array();
	$arrTiposEmbalaje = db_select_array (false, $SIS_query, 'sistema_variedades_categorias_tipo_emb', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTiposEmbalaje');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Especie', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'cross_sistema_variedades_categorias.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'cross_sistema_variedades_categorias_matriz_calidad.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Matriz Calidad</a></li>
					<li class=""><a href="<?php echo 'cross_sistema_variedades_categorias_matriz_proceso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Matriz Proceso</a></li>
					<li class=""><a href="<?php echo 'cross_sistema_variedades_categorias_tipo_embalaje.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Tipo Embalaje</a></li>
				</ul>
			</header>
			<div class="tab-content">

				<div class="tab-pane fade active in" id="basicos">
					<div class="wmd-panel">

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/productos.jpg">
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
							<p class="text-muted">
								<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							</p>

						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="box">
								<header>
									<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Matrices de calidad</h5>
								</header>
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th>Matriz</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
											<?php
											filtrar($arrMatrizCalidad, 'Proceso');
											foreach($arrMatrizCalidad as $Proceso=>$listproc){
												echo '<tr class="odd" ><td style="background-color:#DDD"><strong>'.$Proceso.'</strong></td></tr>';
												foreach ($listproc as $subprocesos) { ?>
												<tr class="odd">
													<td><?php echo $subprocesos['Matriz']; ?></td>
												</tr>
											<?php }
											} ?>

										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="box">
								<header>
									<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Matrices de Proceso</h5>
								</header>
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th>Matriz</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
											<?php
											filtrar($arrMatrizProceso, 'Proceso');
											foreach($arrMatrizProceso as $Proceso=>$listproc){
												echo '<tr class="odd" ><td style="background-color:#DDD"><strong>'.$Proceso.'</strong></td></tr>';
												foreach ($listproc as $subprocesos) { ?>
												<tr class="odd">
													<td><?php echo $subprocesos['Matriz']; ?></td>
												</tr>
											<?php }
											} ?>

										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="box">
								<header>
									<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tipos de Embalaje</h5>
								</header>
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th>Embalaje</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
											<?php
											filtrar($arrTiposEmbalaje, 'Proceso');
											foreach($arrTiposEmbalaje as $Proceso=>$listproc){
												echo '<tr class="odd" ><td style="background-color:#DDD"><strong>'.$Proceso.'</strong></td></tr>';
												foreach ($listproc as $subprocesos) { ?>
												<tr class="odd">
													<td><?php echo $subprocesos['Embalaje']; ?></td>
												</tr>
											<?php }
											} ?>

										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
	//paginador de resultados
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	/**********************************************************/
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'nombre_asc':    $order_by = 'sistema_variedades_categorias.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
			case 'nombre_desc':   $order_by = 'sistema_variedades_categorias.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;

			default: $order_by = 'sistema_variedades_categorias.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
		}
	}else{
		$order_by = 'sistema_variedades_categorias.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "sistema_variedades_categorias.idCategoria!=0";
	$SIS_where.= " AND core_sistemas_variedades_categorias.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//verifico que sea un administrador
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){ $SIS_where .= " AND sistema_variedades_categorias.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	$SIS_join  = 'LEFT JOIN `sistema_variedades_categorias` ON sistema_variedades_categorias.idCategoria = core_sistemas_variedades_categorias.idCategoria';

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'core_sistemas_variedades_categorias.idCategoria', 'core_sistemas_variedades_categorias', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	core_sistemas_variedades_categorias.idCategoria,
	sistema_variedades_categorias.Nombre';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrCategorias = array();
	$arrCategorias = db_select_array (false, $SIS_query, 'core_sistemas_variedades_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategorias');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;     }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);

					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
						<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Especies</h5>
				<div class="toolbar">
					<?php
					//Se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCategorias as $cat) { ?>
						<tr class="odd">
							<td><?php echo $cat['Nombre']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$cat['idCategoria']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($cat['idCategoria'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la Especie '.$cat['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pagrow">
				<?php
				//se llama al paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
