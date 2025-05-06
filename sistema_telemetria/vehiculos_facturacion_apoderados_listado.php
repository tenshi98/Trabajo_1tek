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
$original = "vehiculos_facturacion_apoderados_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){           $location .= "&Fecha=".$_GET['Fecha'];                 $search .= "&Fecha=".$_GET['Fecha'];}
if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){  $location .= "&Observaciones=".$_GET['Observaciones']; $search .= "&Observaciones=".$_GET['Observaciones'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/

//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'create_new';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_apoderados_listado.php';
}
//se borran los datos temporales
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_apoderados_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_temp_datos'])){
	//se agregan ubicaciones
	$location .='&view=true';
	//Llamamos al formulario
	$form_trabajo= 'edit_datos';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_apoderados_listado.php';
}
//se agregan todos los clientes
if (!empty($_GET['addclientall'])){
	//se agregan ubicaciones
	$location .='&view=true';
	//Llamamos al formulario
	$form_trabajo= 'add_all_cliente';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_apoderados_listado.php';
}
//se borra un dato
if (!empty($_GET['del_cliente'])){
	//se agregan ubicaciones
	$location .='&view=true';
	//Llamamos al formulario
	$form_trabajo= 'del_cliente';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_apoderados_listado.php';
}
//se borran los datos temporales
if (!empty($_GET['facturar'])){
	//Llamamos al formulario
	$form_trabajo= 'facturar';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_apoderados_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Datos Creados correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Datos Modificados correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Datos borrados correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['moddatos'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificación de los datos basicos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Fecha)){$x1  = $Fecha;          }else{$x1  = $_SESSION['vehiculos_apoderados_basicos']['Fecha'];}
				if(isset($Observaciones)){  $x2  = $Observaciones;  }else{$x2  = $_SESSION['vehiculos_apoderados_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Facturacion','Fecha', $x1, 2);
				$Form_Inputs->form_textarea('Observaciones', 'Observaciones', $x2, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fCreacion', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_temp_datos">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
			<?php widget_validator(); ?>

		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){ ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los datos del documento en curso?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>
										
		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&facturar=true';
		$dialogo   = '¿Desea ingresar el documento?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary"><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive">

	<div id="page-wrap">
		<div id="header"> Ingreso Datos </div>

		<div id="customer">


			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&view=true&moddatos=true' ?>" class="btn btn-xs btn-primary pull-right">Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td><?php echo Fecha_estandar($_SESSION['vehiculos_apoderados_basicos']['fCreacion']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Creador</td>
						<td><?php echo $_SESSION['vehiculos_apoderados_basicos']['Usuario']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Sistema</td>
						<td><?php echo $_SESSION['vehiculos_apoderados_basicos']['Sistema']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Facturacion</td>
						<td><?php echo Fecha_estandar($_SESSION['vehiculos_apoderados_basicos']['Fecha']); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<table id="items">
			<tbody>

				<tr>
					<th colspan="3">Detalle</th>
					<th width="120" style="width:70px;">
						<a href="<?php echo $location.'&view=true&addclientall=true' ?>" title="Agregar Todos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Todos</a>
					</th>
				</tr>

				<?php if (isset($_SESSION['vehiculos_apoderados_detalle'])){ ?>

					<tr class="item-row linea_punteada" bgcolor="#F0F0F0">
						<td class="item-name"><strong>Apoderado</strong></td>
						<td class="item-name"><strong>Plan</strong></td>
						<td class="item-name"  width="100"><strong>Monto</strong></td>
						<td width="120" style="width:70px;"><strong>Acciones</strong></td>
					</tr>
	
					<?php
					//variables
					$totalGeneral = 0;
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['vehiculos_apoderados_detalle'] as $key => $hijo){ ?>
						<tr class="item-row linea_punteada">

							<td class="item-name"><?php echo $hijo['Apoderado']; ?></td>
							<td class="item-name"><?php echo $hijo['PlanNombre']; ?></td>
							<td class="item-name" align="right"><?php echo valores($hijo['MontoPactado'], 0);$totalGeneral = $totalGeneral+$hijo['MontoPactado'];  ?></td>
							<td width="120" style="width:70px;">
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_apoderado.php?view='.simpleEncode($hijo['idApoderado'], fecha_actual()) ?>" title="Ver Datos Apoderado" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&view=true&del_cliente='.$hijo['idApoderado'];
									$dialogo   = '¿Realmente deseas eliminar el dato '.$hijo['Apoderado'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Cliente" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr class="item-row linea_punteada">
						<td class="item-name"  colspan="2"><strong>Total</strong></td>
						<td class="item-name" align="right"><?php echo valores($totalGeneral, 0); ?></td>
						<td width="120" style="width:70px;"></td>
					</tr>

					<tr id="hiderow"><td colspan="4"></td></tr>
				<?php } ?>

				<tr>
					<td colspan="4" class="blank">
						<p>
							<?php
							if(isset($_SESSION['vehiculos_apoderados_basicos']['Observaciones'])&&$_SESSION['vehiculos_apoderados_basicos']['Observaciones']!=''){
								echo $_SESSION['vehiculos_apoderados_basicos']['Observaciones'];
							}else{
								echo 'Sin Observaciones';
							} ?>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="blank"><p>Observaciones</p></td> 
				</tr>
			</tbody>
		</table>
			<div class="clearfix"></div>

		</div>

</div>




	
	
<div class="clearfix"></div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Facturacion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Fecha)){  $x1  = $Fecha;            }else{$x1  = '';}
				if(isset($Observaciones)){    $x2  = $Observaciones;    }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Facturacion','Fecha', $x1, 2);
				$Form_Inputs->form_textarea('Observaciones', 'Observaciones', $x2, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fCreacion', fecha_actual(), 2);

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
		case 'fechacreacion_asc':  $order_by = 'vehiculos_facturacion_apoderados_listado.fCreacion ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Creacion Ascendente'; break;
		case 'fechacreacion_desc': $order_by = 'vehiculos_facturacion_apoderados_listado.fCreacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Creacion Descendente';break;
		case 'fechafact_asc':      $order_by = 'vehiculos_facturacion_apoderados_listado.Fecha ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Facturacion Ascendente';break;
		case 'fechafact_desc':     $order_by = 'vehiculos_facturacion_apoderados_listado.Fecha DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Facturacion Descendente';break;
		case 'creador_asc':        $order_by = 'usuarios_listado.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Creador Ascendente';break;
		case 'creador_desc':       $order_by = 'usuarios_listado.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Creador Descendente';break;

		default: $order_by = 'vehiculos_facturacion_apoderados_listado.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Facturacion Descendente';
	}
}else{
	$order_by = 'vehiculos_facturacion_apoderados_listado.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Facturacion Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "vehiculos_facturacion_apoderados_listado.idFacturacion!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND vehiculos_facturacion_apoderados_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){           $SIS_where .= " AND vehiculos_facturacion_apoderados_listado.Fecha='".$_GET['Fecha']."'";}
if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){  $SIS_where .= " AND vehiculos_facturacion_apoderados_listado.Observaciones LIKE '%".EstandarizarInput($_GET['Observaciones'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idFacturacion', 'vehiculos_facturacion_apoderados_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
vehiculos_facturacion_apoderados_listado.idFacturacion,
vehiculos_facturacion_apoderados_listado.fCreacion,
vehiculos_facturacion_apoderados_listado.Fecha,
usuarios_listado.Nombre AS NombreUsuario,
core_sistemas.Nombre AS Sistema';
$SIS_join  = '
LEFT JOIN `core_sistemas`     ON core_sistemas.idSistema      = vehiculos_facturacion_apoderados_listado.idSistema
LEFT JOIN `usuarios_listado`  ON usuarios_listado.idUsuario   = vehiculos_facturacion_apoderados_listado.idUsuario';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrDatos = array();
$arrDatos = db_select_array (false, $SIS_query, 'vehiculos_facturacion_apoderados_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDatos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Facturacion</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Fecha)){  $x1  = $Fecha;            }else{$x1  = '';}
				if(isset($Observaciones)){    $x2  = $Observaciones;    }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Facturacion','Fecha', $x1, 1);
				$Form_Inputs->form_textarea('Observaciones', 'Observaciones', $x2, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Facturaciones</h5>
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
							<div class="pull-left">Fecha Creacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechacreacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechacreacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha Facturacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechafact_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechafact_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
					<?php foreach ($arrDatos as $cont) { ?>
						<tr class="odd">
							<td><?php echo Fecha_estandar($cont['fCreacion']); ?></td>
							<td><?php echo Fecha_estandar($cont['Fecha']); ?></td>
							<td><?php echo $cont['NombreUsuario']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $cont['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_vehiculos_facturacion_apoderados_listado.php?view='.simpleEncode($cont['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
