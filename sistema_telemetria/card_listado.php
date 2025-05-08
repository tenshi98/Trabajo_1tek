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
$original = "card_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                $location .= "&Nombre=".$_GET['Nombre'];                 $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idCardImage']) && $_GET['idCardImage']!=''){      $location .= "&idCardImage=".$_GET['idCardImage'];       $search .= "&idCardImage=".$_GET['idCardImage'];}
if(isset($_GET['idCardType']) && $_GET['idCardType']!=''){        $location .= "&idCardType=".$_GET['idCardType'];         $search .= "&idCardType=".$_GET['idCardType'];}
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
	require_once 'A1XRXS_sys/xrxs_form/card_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/card_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Tarjeta Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Tarjeta Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Tarjeta Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	card_listado.Nombre AS CardNombre,
	card_listado.Direccion_img,
	core_sistemas_opciones.Nombre AS Imagen,
	core_card_type.Nombre AS Tipo,
	core_card_position.Nombre AS Posicion';
	$SIS_join  = '
	LEFT JOIN `core_sistemas_opciones`  ON core_sistemas_opciones.idOpciones   = card_listado.idCardImage
	LEFT JOIN `core_card_type`          ON core_card_type.idCardType           = card_listado.idCardType
	LEFT JOIN `core_card_position`      ON core_card_position.idPosition       = card_listado.idPosition';
	$SIS_where = 'card_listado.idCard = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'card_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Tarjetas', $rowData['CardNombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'card_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'card_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'card_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
				</ul>
			</header>
			<div class="tab-content">

				<div class="tab-pane fade active in" id="basicos">
					<div class="wmd-panel">

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<?php if ($rowData['Direccion_img']=='') { ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/card.jpg">
							<?php }else{
								echo '<img src="upload/'.$rowData['Direccion_img'].'" style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia"  >';
							} ?>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de la tarjeta</h2>
							<p class="text-muted">
								<strong>Nombre : </strong><?php echo $rowData['CardNombre']; ?><br/>
								<strong>Tipo Tarjeta : </strong><?php echo $rowData['Tipo']; ?><br/>
								<strong>Posicion Texto : </strong><?php echo $rowData['Posicion']; ?><br/>
								<strong>Uso Avatar : </strong><?php echo $rowData['Imagen']; ?>
							</p>
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
				<h5>Crear Tarjeta</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){       $x1  = $Nombre;       }else{$x1  = '';}
					if(isset($idCardType)){   $x2  = $idCardType;   }else{$x2  = '';}
					if(isset($idPosition)){   $x3  = $idPosition;   }else{$x3  = '';}
					if(isset($idCardImage)){  $x4  = $idCardImage;  }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_depend1('Tipo Tarjeta','idCardType', $x2, 2, 'idCardType', 'Nombre', 'core_card_type', 0, 0,
											'Posicion Texto','idPosition', $x3, 2, 'idPosition', 'Nombre', 'core_card_position', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select('Uso Avatar','idCardImage', $x4, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
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
			case 'nombre_asc':     $order_by = 'card_listado.Nombre ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
			case 'nombre_desc':    $order_by = 'card_listado.Nombre DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'tipo_asc':       $order_by = 'core_card_type.Nombre ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Tarjeta Ascendente';break;
			case 'tipo_desc':      $order_by = 'core_card_type.Nombre DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Tarjeta Descendente';break;
			case 'image_asc':      $order_by = 'core_sistemas_opciones.Nombre ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Uso Avatar Ascendente';break;
			case 'image_desc':     $order_by = 'core_sistemas_opciones.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Uso Avatar Descendente';break;
			case 'posicion_asc':   $order_by = 'core_card_position.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Posicion Texto Ascendente';break;
			case 'posicion_desc':  $order_by = 'core_card_position.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Posicion Texto Descendente';break;

			default: $order_by = 'card_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
		}
	}else{
		$order_by = 'card_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
	/**********************************************************/
	$SIS_where = "card_listado.idCard >= 1";
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){            $SIS_where .= " AND card_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['idCardImage']) && $_GET['idCardImage']!=''){  $SIS_where .= " AND card_listado.idCardImage=".$_GET['idCardImage'];}
	if(isset($_GET['idCardType']) && $_GET['idCardType']!=''){    $SIS_where .= " AND card_listado.idCardType=".$_GET['idCardType'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'card_listado.idCard', 'card_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	card_listado.idCard,
	card_listado.Nombre AS CardNombre,
	card_listado.Direccion_img,
	core_sistemas_opciones.Nombre AS Imagen,
	core_card_type.Nombre AS Tipo,
	core_card_position.Nombre AS Posicion';
	$SIS_join  = '
	LEFT JOIN `core_sistemas_opciones`  ON core_sistemas_opciones.idOpciones   = card_listado.idCardImage
	LEFT JOIN `core_card_type`          ON core_card_type.idCardType           = card_listado.idCardType
	LEFT JOIN `core_card_position`      ON core_card_position.idPosition       = card_listado.idPosition';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'card_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Tarjeta</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){        $x1  = $Nombre;          }else{$x1  = '';}
					if(isset($idCardImage)){   $x2  = $idCardImage;     }else{$x2  = '';}
					if(isset($idCardType)){    $x3  = $idCardType;      }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
					$Form_Inputs->form_select_filter('Uso Avatar','idCardImage', $x2, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Posicion Texto','idCardType', $x3, 1, 'idCardType', 'Nombre', 'core_card_type', 0, '', $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tipos de tarjeta</h5>
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
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Uso Avatar</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=image_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=image_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Tipo Tarjeta</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Posicion Texto</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=posicion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=posicion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
									echo '<img class="img-round" src="upload/'.$prod['Direccion_img'].'" style="height:30px; width:50px;">';
								} ?>
							</td>
							<td><?php echo $prod['CardNombre']; ?></td>
							<td><?php echo $prod['Imagen']; ?></td>
							<td><?php echo $prod['Tipo']; ?></td>
							<td><?php echo $prod['Posicion']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$prod['idCard']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($prod['idCard'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el Tarjeta '.$prod['CardNombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
