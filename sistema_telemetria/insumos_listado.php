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
$original = "insumos_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){            $location .= "&Nombre=".$_GET['Nombre'];             $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){  $location .= "&idCategoria=".$_GET['idCategoria'];   $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['Marca']) && $_GET['Marca']!=''){              $location .= "&Marca=".$_GET['Marca'];               $search .= "&Fono=".$_GET['Fono'];}
if(isset($_GET['idUml']) && $_GET['idUml']!=''){              $location .= "&idUml=".$_GET['idUml'];               $search .= "&idUml=".$_GET['idUml'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/insumos_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/insumos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Insumo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Insumo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Insumo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	insumos_listado.Nombre,
	insumos_listado.Descripcion,
	insumos_listado.Marca,
	insumos_listado.Codigo,
	insumos_listado.StockLimite,
	insumos_listado.ValorIngreso,
	insumos_listado.ValorEgreso,
	insumos_listado.Direccion_img,
	insumos_listado.idTipoImagen,
	sistema_productos_categorias.Nombre AS Categoria,
	sistema_productos_uml.Nombre AS Unidad,
	insumos_listado.FichaTecnica,
	insumos_listado.HDS,
	core_estados.Nombre AS Estado,
	proveedor_listado.Nombre AS ProveedorFijo';
	$SIS_join  = '
	LEFT JOIN `sistema_productos_categorias`     ON sistema_productos_categorias.idCategoria         = insumos_listado.idCategoria
	LEFT JOIN `sistema_productos_uml`            ON sistema_productos_uml.idUml                      = insumos_listado.idUml
	LEFT JOIN `core_estados`                     ON core_estados.idEstado                            = insumos_listado.idEstado
	LEFT JOIN `proveedor_listado`                ON proveedor_listado.idProveedor                    = insumos_listado.idProveedorFijo';
	$SIS_where = 'insumos_listado.idProducto ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Insumos', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'insumos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'insumos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'insumos_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'insumos_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
							<li class=""><a href="<?php echo 'insumos_listado_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'insumos_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
							<li class=""><a href="<?php echo 'insumos_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha</a></li>
							<li class=""><a href="<?php echo 'insumos_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>

						</ul>
					</li>
				</ul>
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
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Insumo</h2>
							<p class="text-muted">
								<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
								<strong>Marca : </strong><?php echo $rowData['Marca']; ?><br/>
								<strong>Codigo : </strong><?php echo $rowData['Codigo']; ?><br/>
								<strong>Categoria : </strong><?php echo $rowData['Categoria']; ?><br/>
								<strong>Unidad de medida : </strong><?php echo $rowData['Unidad']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['Estado']; ?>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Descripción</h2>
							<p class="text-muted"><?php echo $rowData['Descripcion']; ?></p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Comerciales</h2>
							<p class="text-muted">
								<strong>Proveedor predefinido : </strong><?php echo $rowData['ProveedorFijo']; ?><br/>
								<strong>Stock Minimo : </strong><?php echo Cantidades_decimales_justos($rowData['StockLimite']).' '.$rowData['Unidad']; ?><br/>
								<strong>Valor promedio Ingreso : </strong><?php echo Valores(Cantidades_decimales_justos($rowData['ValorIngreso']), 0); ?><br/>
								<strong>Valor promedio Egreso : </strong><?php echo Valores(Cantidades_decimales_justos($rowData['ValorEgreso']), 0); ?><br/>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
							<table id="items" style="margin-bottom: 20px;">
								<tbody>
									<?php
									//Ficha Tecnica
									if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
										echo '
											<tr class="item-row">
												<td>Ficha Tecnica</td>
												<td width="10">
													<div class="btn-group" style="width: 70px;">
														<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['FichaTecnica'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
														<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['FichaTecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										';
									}
									//Hoja de seguridad
									if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
										echo '
											<tr class="item-row">
												<td>Hoja de seguridad</td>
												<td width="10">
													<div class="btn-group" style="width: 70px;">
														<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['HDS'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
														<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['HDS'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										';
									}
									?>
								</tbody>
							</table>

						</div>
						<div class="clearfix"></div>

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
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Insumo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){         $x1  = $Nombre;           }else{$x1  = '';}
					if(isset($idCategoria)){    $x2  = $idCategoria;      }else{$x2  = '';}
					if(isset($Marca)){          $x3  = $Marca;            }else{$x3  = '';}
					if(isset($idUml)){          $x4  = $idUml;            }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_filter('Categoria','idCategoria', $x2, 2, 'idCategoria', 'Nombre', 'sistema_productos_categorias', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 2);
					$Form_Inputs->form_select_filter('Unidad de Medida','idUml', $x4, 2, 'idUml', 'Nombre', 'sistema_productos_uml', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
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
			case 'marca_asc':        $order_by = 'insumos_listado.Marca ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Marca Ascendente'; break;
			case 'marca_desc':       $order_by = 'insumos_listado.Marca DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Marca Descendente';break;
			case 'nombre_asc':       $order_by = 'insumos_listado.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
			case 'nombre_desc':      $order_by = 'insumos_listado.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'categoria_asc':    $order_by = 'sistema_productos_categorias.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Categoria Ascendente';break;
			case 'categoria_desc':   $order_by = 'sistema_productos_categorias.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Categoria Descendente';break;
			case 'unimed_asc':       $order_by = 'sistema_productos_uml.Nombre ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Unidad Medida Ascendente';break;
			case 'unimed_desc':      $order_by = 'sistema_productos_uml.Nombre DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Unidad Medida Descendente';break;
			case 'estado_asc':       $order_by = 'insumos_listado.idEstado ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':      $order_by = 'insumos_listado.idEstado DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

			default: $order_by = 'insumos_listado.idEstado ASC, insumos_listado.Marca ASC, insumos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado, Marca, Nombre Ascendente';
		}
	}else{
		$order_by = 'insumos_listado.idEstado ASC, insumos_listado.Marca ASC, insumos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado, Marca, Nombre Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "insumos_listado.idProducto >= 1";
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){           $SIS_where .= " AND insumos_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND insumos_listado.idCategoria=".$_GET['idCategoria'];}
	if(isset($_GET['Marca']) && $_GET['Marca']!=''){             $SIS_where .= " AND insumos_listado.Marca LIKE '%".EstandarizarInput($_GET['Marca'])."%'";}
	if(isset($_GET['idUml']) && $_GET['idUml']!=''){             $SIS_where .= " AND insumos_listado.idUml=".$_GET['idUml'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idProducto', 'insumos_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	insumos_listado.idProducto,
	insumos_listado.Nombre AS NombreProd,
	insumos_listado.Marca,
	insumos_listado.Direccion_img,
	insumos_listado.idTipoImagen,
	sistema_productos_categorias.Nombre AS Categoria,
	sistema_productos_uml.Nombre AS Unimed,
	core_estados.Nombre AS Estado,
	insumos_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `sistema_productos_categorias`  ON sistema_productos_categorias.idCategoria = insumos_listado.idCategoria
	LEFT JOIN `sistema_productos_uml`         ON sistema_productos_uml.idUml              = insumos_listado.idUml
	LEFT JOIN `core_estados`                  ON core_estados.idEstado                    = insumos_listado.idEstado';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Insumo</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){         $x1  = $Nombre;           }else{$x1  = '';}
					if(isset($idCategoria)){    $x2  = $idCategoria;      }else{$x2  = '';}
					if(isset($Marca)){          $x3  = $Marca;            }else{$x3  = '';}
					if(isset($idUml)){          $x4  = $idUml;            }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
					$Form_Inputs->form_select_filter('Categoria','idCategoria', $x2, 1, 'idCategoria', 'Nombre', 'sistema_productos_categorias', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 1);
					$Form_Inputs->form_select_filter('Unidad de Medida','idUml', $x4, 1, 'idUml', 'Nombre', 'sistema_productos_uml', 0, '', $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Insumos</h5>
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
							<th width="70">Foto</th>
							<th>
								<div class="pull-left">Marca</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=marca_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=marca_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Categoria</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=categoria_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=categoria_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Unidad Medida</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=unimed_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=unimed_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrProductos as $prod) { ?>
						<tr class="odd">
							<td>
								<?php if ($prod['Direccion_img']=='') { ?>
									<img class="img-round" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/productos.jpg" style="height:30px; width:50px;">
								<?php }else{
									//se selecciona el tipo de imagen
									switch ($prod['idTipoImagen']) {
										//Si no esta configurada
										case 0:
											echo '<img class="img-round" src="upload/'.$prod['Direccion_img'].'" style="height:30px; width:50px;">';
											break;
										//Normal
										case 1:
											echo '<img class="img-round" src="upload/'.$prod['Direccion_img'].'" style="height:30px; width:50px;">';
											break;
										//Tambor
										case 2:
										case 3:
										case 4:
										case 5:
										case 6:
										case 7:
										case 8:
										case 9:
										case 10:
										case 11:
										case 12:
										case 13:
										case 14:
										case 15:
										case 16:
										case 17:
										case 18:
											echo '<img class="img-round" src="'.DB_SITE_REPO.'/LIB_assets/img/3dcube.jpg" style="height:30px; width:50px;">';
											break;
									}
								} ?>
							</td>
							<td><?php echo $prod['Marca']; ?></td>
							<td><?php echo $prod['NombreProd']; ?></td>
							<td><?php echo $prod['Categoria']; ?></td>
							<td><?php echo $prod['Unimed']; ?></td>
							<td><label class="label <?php if(isset($prod['idEstado'])&&$prod['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $prod['Estado']; ?></label></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_insumos.php?view='.simpleEncode($prod['idProducto'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$prod['idProducto']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($prod['idProducto'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el producto '.$prod['NombreProd'].'?'; ?>
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
