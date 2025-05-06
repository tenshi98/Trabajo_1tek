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
$original = "ocompra_listado_sin_aprobar.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){        $location .= "&idProveedor=".$_GET['idProveedor'];        $search .= "&idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];  $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
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
	$form_trabajo= 'rechazo_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_nula'])){
	//Llamamos al formulario
	$form_trabajo= 'nula_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//se realiza el ingreso de la Orden de Compra
if (!empty($_GET['compra_aprobar'])){
	//Llamamos al formulario
	$form_trabajo= 'aprob_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
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
if(!empty($_GET['compra_rechazo'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Rechazar Orden de Compra</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Observacion)){     $x1  = $Observacion;    }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Observaciones', 'Observacion', $x1, 2);

					$Form_Inputs->form_input_hidden('idOcompra', $_GET['compra_rechazo'], 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('Creacion_hora', hora_actual(), 2);
					$Form_Inputs->form_input_hidden('idTipo', 4, 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_rechazo">
						<a href="<?php echo $location.'&view='.$_GET['compra_rechazo']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['compra_nula'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Anular Orden de Compra</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Observacion)){     $x1  = $Observacion;    }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Observaciones', 'Observacion', $x1, 2);

					$Form_Inputs->form_input_hidden('idOcompra', $_GET['compra_nula'], 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('Creacion_hora', hora_actual(), 2);
					$Form_Inputs->form_input_hidden('idTipo', 4, 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_nula">
						<a href="<?php echo $location.'&view='.$_GET['compra_nula']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
	sistema_aprobador_oc.idUsuario,
	ocompra_listado.idOcompra,
	(SELECT COUNT(idAprobaciones) FROM `ocompra_listado_aprobaciones` WHERE idOcompra=ocompra_listado.idOcompra AND idUsuario=sistema_aprobador_oc.idUsuario  LIMIT 1) AS C_apro,
	(SELECT Creacion_fecha        FROM `ocompra_listado_aprobaciones` WHERE idOcompra=ocompra_listado.idOcompra AND idUsuario=sistema_aprobador_oc.idUsuario LIMIT 1) AS FechaApro,
	(SELECT Creacion_hora         FROM `ocompra_listado_aprobaciones` WHERE idOcompra=ocompra_listado.idOcompra AND idUsuario=sistema_aprobador_oc.idUsuario LIMIT 1) AS HoraApro';
	$SIS_join  = '
	LEFT JOIN `sistema_aprobador_oc`  ON sistema_aprobador_oc.idSistema   = ocompra_listado.idSistema
	LEFT JOIN `usuarios_listado`      ON usuarios_listado.idUsuario       = sistema_aprobador_oc.idUsuario';
	$SIS_where = 'ocompra_listado.idOcompra = '.$_GET['view'];
	$SIS_order = 0;
	$arrAprobado = array();
	$arrAprobado = db_select_array (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAprobado');

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
											<a href="<?php echo $location.'&compra_rechazo='.$apro['idOcompra']; ?>" title="Rechazar Orden" class="btn btn-danger btn-sm tooltip"><i class="fa fa-times" aria-hidden="true"></i></a>
											<a href="<?php echo $location.'&compra_nula='.$apro['idOcompra']; ?>" title="Anular Orden" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php //Confirmacion
											$ubicacion = $location.'&compra_aprobar='.$apro['idOcompra'];
											$dialogo   = '¿Realmente deseas aprobar la Orden de Compra n '.n_doc($_GET['view'], 5).'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Aprobar Orden" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>
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

	<?php include '1include_ocompra.php'; ?>

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
			case 'ndoc_asc':          $order_by = 'ocompra_listado.idOcompra ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Doc Ascendente';break;
			case 'ndoc_desc':         $order_by = 'ocompra_listado.idOcompra DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Doc Descendente';break;
			case 'proveedor_asc':     $order_by = 'proveedor_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Proveedor Ascendente';break;
			case 'proveedor_desc':    $order_by = 'proveedor_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Proveedor Descendente';break;
			case 'estado_asc':        $order_by = 'core_oc_estado.Nombre ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':       $order_by = 'core_oc_estado.Nombre DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
			case 'fecha_asc':         $order_by = 'ocompra_listado.Creacion_fecha ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':        $order_by = 'ocompra_listado.Creacion_fecha DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;

			default: $order_by = 'core_oc_estado.idEstado DESC,ocompra_listado.idOcompra DESC, ocompra_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado, N° Doc, Fecha Descendente';
		}
	}else{
		$order_by = 'core_oc_estado.idEstado DESC,ocompra_listado.idOcompra DESC, ocompra_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado, N° Doc, Fecha Descendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "ocompra_listado.idEstado=1";
	//verifico que sea un administrador
	$SIS_where.= " AND ocompra_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){        $SIS_where .= " AND ocompra_listado.idProveedor=".$_GET['idProveedor'];}
	if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND ocompra_listado.Creacion_fecha='".$_GET['Creacion_fecha']."'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	ocompra_listado.idOcompra,
	ocompra_listado.idEstado,
	ocompra_listado.Solicitud,
	ocompra_listado.Creacion_fecha,
	core_oc_estado.Nombre AS Estado,
	proveedor_listado.Nombre AS Proveedor';
	$SIS_join  = '
	LEFT JOIN `core_oc_estado`      ON core_oc_estado.idEstado         = ocompra_listado.idEstado 
	LEFT JOIN `proveedor_listado`   ON proveedor_listado.idProveedor   = ocompra_listado.idProveedor';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrSolicitudes = array();
	$arrSolicitudes = db_select_array (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSolicitudes');

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
					if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = '';}
					if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha de Orden de Compra','Creacion_fecha', $x2, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ordenes de Compra</h5>
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
							<th width="120">
								<div class="pull-left">N° Doc</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ndoc_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ndoc_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Proveedor</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=proveedor_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=proveedor_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrSolicitudes as $sol) { ?>
						<tr class="odd <?php if(isset($sol['idEstado'])&&$sol['idEstado']==3){echo 'danger';} ?>">
							<td><?php echo 'OC N°'.n_doc($sol['idOcompra'], 5); ?></td>
							<td><?php echo $sol['Proveedor']; ?></td>
							<td><?php echo $sol['Estado']; ?></td>
							<td><?php echo Fecha_estandar($sol['Creacion_fecha']); ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&view='.$sol['idOcompra']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
