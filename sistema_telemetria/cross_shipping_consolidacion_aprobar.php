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
$original = "cross_shipping_consolidacion_aprobar.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){         $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];          $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){               $location .= "&idCategoria=".$_GET['idCategoria'];                $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){                 $location .= "&idProducto=".$_GET['idProducto'];                  $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['CTNNombreCompañia']) && $_GET['CTNNombreCompañia']!=''){   $location .= "&CTNNombreCompañia=".$_GET['CTNNombreCompañia'];    $search .= "&CTNNombreCompañia=".$_GET['CTNNombreCompañia'];}
/********************************************************************/
if(isset($_GET['soli']) && $_GET['soli']!=''){   $location .= "&soli=".$_GET['soli']; 	}
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_rechazo'])){
	//Llamamos al formulario
	$form_trabajo= 'rechazo_consolidacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//formulario para crear
if (!empty($_POST['submit_nula'])){
	//Llamamos al formulario
	$form_trabajo= 'nula_consolidacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************/
//se realiza el ingreso de la Orden de Compra
if (!empty($_GET['consolidacion_aprobar'])){
	//Llamamos al formulario
	$form_trabajo= 'aprob_consolidacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Documento Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Documento Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Documento Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['consolidacion_rechazo'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Rechazar Consolidacion de Compra</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Observacion)){     $x1  = $Observacion;    }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Observaciones', 'Observacion', $x1, 2);

					$Form_Inputs->form_input_hidden('idConsolidacion', $_GET['consolidacion_rechazo'], 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('Creacion_hora', hora_actual(), 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_rechazo">
						<a href="<?php echo $location.'&view='.$_GET['consolidacion_rechazo']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['consolidacion_nula'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Anular Consolidacion de Compra</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Observacion)){     $x1  = $Observacion;    }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Observaciones', 'Observacion', $x1, 2);

					$Form_Inputs->form_input_hidden('idConsolidacion', $_GET['consolidacion_nula'], 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('Creacion_hora', hora_actual(), 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_nula">
						<a href="<?php echo $location.'&view='.$_GET['consolidacion_nula']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	usuarios_listado.Nombre,
	sistema_aprobador_cross.idUsuario,
	cross_shipping_consolidacion.idConsolidacion,
	(SELECT COUNT(idAprobaciones) FROM `cross_shipping_consolidacion_aprobaciones` WHERE idConsolidacion=cross_shipping_consolidacion.idConsolidacion AND idUsuario=sistema_aprobador_cross.idUsuario  LIMIT 1) AS C_apro,
	(SELECT Creacion_fecha        FROM `cross_shipping_consolidacion_aprobaciones` WHERE idConsolidacion=cross_shipping_consolidacion.idConsolidacion AND idUsuario=sistema_aprobador_cross.idUsuario LIMIT 1) AS FechaApro,
	(SELECT Creacion_hora         FROM `cross_shipping_consolidacion_aprobaciones` WHERE idConsolidacion=cross_shipping_consolidacion.idConsolidacion AND idUsuario=sistema_aprobador_cross.idUsuario LIMIT 1) AS HoraApro';
	$SIS_join  = '
	LEFT JOIN `sistema_aprobador_cross`  ON sistema_aprobador_cross.idSistema   = cross_shipping_consolidacion.idSistema
	LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario          = sistema_aprobador_cross.idUsuario';
	$SIS_where = 'cross_shipping_consolidacion.idConsolidacion = '.$_GET['view'];
	$SIS_order = 0;
	$arrAprobado = array();
	$arrAprobado = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAprobado');

	?>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Usuarios aprobadores</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Usuario</th>
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrAprobado as $apro) { ?>
							<tr class="odd">
								<td><?php echo $apro['Nombre']; ?></td>
								<td>
									<?php
									if(isset($apro['C_apro'])&&$apro['C_apro']==1){
										echo 'Aprobada el '.fecha_estandar($apro['FechaApro']).' a las '.$apro['HoraApro'].' hrs';
									}elseif(isset($apro['idUsuario'])&&$apro['idUsuario']==$_SESSION['usuario']['basic_data']['idUsuario']){ ?>
										<div class="btn-group" style="width: 105px;" >
											<a href="<?php echo $location.'&consolidacion_rechazo='.$_GET['view']; ?>" title="Rechazar Consolidacion" class="btn btn-danger btn-sm tooltip"><i class="fa fa-times" aria-hidden="true"></i></a>
											<a href="<?php echo $location.'&consolidacion_nula='.$_GET['view']; ?>" title="Anular Consolidacion" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php //Confirmacion
											$ubicacion = $location.'&consolidacion_aprobar='.$_GET['view'];
											$dialogo   = '¿Realmente deseas aprobar la Consolidacion?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Aprobar Consolidacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>
										</div>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<?php include '1include_cross_shipping_consolidacion.php'; ?>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//Se inicializa el paginador de resultados
	//tomo el numero de la pagina si es que este existe
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	/**********************************************************/
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'fecha_asc':      $order_by = 'cross_shipping_consolidacion.Creacion_fecha ASC ';                            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha del informe Ascendente';break;
			case 'fecha_desc':     $order_by = 'cross_shipping_consolidacion.Creacion_fecha DESC ';                           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha del informe Descendente';break;
			case 'producto_asc':   $order_by = 'sistema_variedades_categorias.Nombre ASC, variedades_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Producto Ascendente';break;
			case 'producto_desc':  $order_by = 'sistema_variedades_categorias.Nombre DESC, variedades_listado.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Producto Descendente';break;
			case 'creador_asc':    $order_by = 'usuarios_listado.Nombre ASC ';                                                $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Creador Ascendente';break;
			case 'creador_desc':   $order_by = 'usuarios_listado.Nombre DESC ';                                               $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Creador Descendente';break;
			case 'ctn_asc':        $order_by = 'cross_shipping_consolidacion.CTNNombreCompañia ASC ';                         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Contenedor Ascendente';break;
			case 'ctn_desc':       $order_by = 'cross_shipping_consolidacion.CTNNombreCompañia DESC ';                        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Contenedor Descendente';break;

			default: $order_by = 'cross_shipping_consolidacion.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha del informe Descendente';
		}
	}else{
		$order_by = 'cross_shipping_consolidacion.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha del informe Descendente';
	}
	/**********************************************************/
	//Variable con la ubicacion
	$SIS_where = "cross_shipping_consolidacion.idConsolidacion!=0";
	$SIS_where.= " AND cross_shipping_consolidacion.idEstado=1";//Solo las que esten en espera de aprobacion
	$SIS_where.= " AND cross_shipping_consolidacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//Verifico el tipo de usuario que esta ingresando
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){        $SIS_where .= " AND cross_shipping_consolidacion.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
	if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){              $SIS_where .= " AND cross_shipping_consolidacion.idCategoria=".$_GET['idCategoria'];}
	if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){                $SIS_where .= " AND cross_shipping_consolidacion.idProducto=".$_GET['idProducto'];}
	if(isset($_GET['CTNNombreCompañia']) && $_GET['CTNNombreCompañia']!=''){  $SIS_where .= " AND cross_shipping_consolidacion.CTNNombreCompañia LIKE '%".EstandarizarInput($_GET['CTNNombreCompañia'])."%'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idConsolidacion', 'cross_shipping_consolidacion', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	cross_shipping_consolidacion.idConsolidacion,
	cross_shipping_consolidacion.Creacion_fecha,
	cross_shipping_consolidacion.CTNNombreCompañia,
	usuarios_listado.Nombre AS Usuario,
	core_sistemas.Nombre AS Sistema,
	sistema_variedades_categorias.Nombre AS ProductoCategoria,
	variedades_listado.Nombre AS ProductoNombre';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`               ON usuarios_listado.idUsuario                 = cross_shipping_consolidacion.idUsuario
	LEFT JOIN `core_sistemas`                  ON core_sistemas.idSistema                    = cross_shipping_consolidacion.idSistema
	LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_shipping_consolidacion.idCategoria
	LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_shipping_consolidacion.idProducto';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

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
					if(isset($Creacion_fecha)){      $x1  = $Creacion_fecha;    }else{$x1  = '';}
					if(isset($idCategoria)){         $x2  = $idCategoria;       }else{$x2  = '';}
					if(isset($idProducto)){          $x3  = $idProducto;        }else{$x3  = '';}
					if(isset($CTNNombreCompañia)){   $x4  = $CTNNombreCompañia; }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha del informe','Creacion_fecha', $x1, 1);
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x2, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
											'Variedad','idProducto', $x3, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_text('Contenedor Nro.', 'CTNNombreCompañia', $x4, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Consolidaciones En espera de Aprobacion</h5>
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
								<div class="pull-left">Fecha del informe</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Contenedor Nro.</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ctn_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ctn_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Categoria - Producto</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=producto_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=producto_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Creador</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=creador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=creador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrTipo as $tipo) { ?>
						<tr class="odd">
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo $tipo['CTNNombreCompañia']; ?></td>
							<td><?php echo $tipo['ProductoCategoria'].' - '.$tipo['ProductoNombre']; ?></td>
							<td><?php echo $tipo['Usuario']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_cross_shipping_consolidacion.php?view='.simpleEncode($tipo['idConsolidacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&view='.$tipo['idConsolidacion']; ?>" title="Editar Consolidacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
