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
$original = "vehiculos_costos.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                  $location .= "&idTipo=".$_GET['idTipo'];                  $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idVehiculo']) && $_GET['idVehiculo']!=''){          $location .= "&idVehiculo=".$_GET['idVehiculo'];          $search .= "&idVehiculo=".$_GET['idVehiculo'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];  $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['Valor']) && $_GET['Valor']!=''){                    $location .= "&Valor=".$_GET['Valor'];                    $search .= "&Valor=".$_GET['Valor'];}
if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){    $location .= "&Observaciones=".$_GET['Observaciones'];    $search .= "&Observaciones=".$_GET['Observaciones'];}
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
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_costos.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_costos.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_costos.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Costo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Costo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Costo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idTipo,idVehiculo,Creacion_fecha,Valor,Observaciones';
	$SIS_join  = '';
	$SIS_where = 'idCosto = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'vehiculos_costos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
	/*******************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación Costo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTipo)){             $x1  = $idTipo;            }else{$x1  = $rowData['idTipo'];}
					if(isset($idVehiculo)){         $x2  = $idVehiculo;        }else{$x2  = $rowData['idVehiculo'];}
					if(isset($Creacion_fecha)){     $x3  = $Creacion_fecha;    }else{$x3  = $rowData['Creacion_fecha'];}
					if(isset($Valor)){              $x4  = $Valor;            }else{$x4  = $rowData['Valor'];}
					if(isset($Observaciones)){      $x5  = $Observaciones;     }else{$x5  = $rowData['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Tipo de Costo','idTipo', $x1, 2, 'idTipo', 'Nombre', 'vehiculos_costos_tipo', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x2, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha','Creacion_fecha', $x3, 2);
					$Form_Inputs->form_values('Valor', 'Valor', $x4, 2);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);

					$Form_Inputs->form_input_hidden('idCosto', $_GET['id'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//se crea filtro
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1"; ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Costo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTipo)){             $x1  = $idTipo;            }else{$x1  = '';}
					if(isset($idVehiculo)){         $x2  = $idVehiculo;        }else{$x2  = '';}
					if(isset($Creacion_fecha)){     $x3  = $Creacion_fecha;    }else{$x3  = '';}
					if(isset($Valor)){              $x4  = $Valor;            }else{$x4  = '';}
					if(isset($Observaciones)){      $x5  = $Observaciones;     }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Tipo de Costo','idTipo', $x1, 2, 'idTipo', 'Nombre', 'vehiculos_costos_tipo', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x2, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha','Creacion_fecha', $x3, 2);
					$Form_Inputs->form_values('Valor', 'Valor', $x4, 2);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);

					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
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
			case 'fecha_asc':     $order_by = 'vehiculos_costos.Creacion_fecha ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':    $order_by = 'vehiculos_costos.Creacion_fecha DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'tipo_asc':      $order_by = 'vehiculos_costos_tipo.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
			case 'tipo_desc':     $order_by = 'vehiculos_costos_tipo.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
			case 'vehiculo_asc':  $order_by = 'vehiculos_listado.Nombre ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Vehiculo Ascendente'; break;
			case 'vehiculo_desc': $order_by = 'vehiculos_listado.Nombre DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Vehiculo Descendente';break;
			case 'valor_asc':     $order_by = 'vehiculos_costos.Valor ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Valor Ascendente';break;
			case 'valor_desc':    $order_by = 'vehiculos_costos.Valor DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Valor Descendente';break;

			default: $order_by = 'vehiculos_costos.Creacion_fecha ASC, vehiculos_costos_tipo.Nombre ASC, vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha, Tipo, Vehiculo Ascendente';
		}
	}else{
		$order_by = 'vehiculos_costos.Creacion_fecha ASC, vehiculos_costos_tipo.Nombre ASC, vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha, Tipo, Vehiculo Ascendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "vehiculos_costos.idCosto!=0";
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                  $SIS_where .= " AND vehiculos_costos_tipo.idTipo=".$_GET['idTipo'];}
	if(isset($_GET['idVehiculo']) && $_GET['idVehiculo']!=''){          $SIS_where .= " AND vehiculos_costos_tipo.idVehiculo=".$_GET['idVehiculo'];}
	if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND vehiculos_costos_tipo.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
	if(isset($_GET['Valor']) && $_GET['Valor']!=''){                    $SIS_where .= " AND vehiculos_costos_tipo.Valor LIKE '%".EstandarizarInput($_GET['Valor'])."%'";}
	if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){    $SIS_where .= " AND vehiculos_costos_tipo.Observaciones LIKE '%".EstandarizarInput($_GET['Observaciones'])."%'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idCosto', 'vehiculos_costos', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	vehiculos_costos.idCosto,
	vehiculos_costos_tipo.Nombre AS Tipo,
	vehiculos_listado.Nombre AS VehiculoNombre,
	vehiculos_listado.Patente AS VehiculoPatente,
	vehiculos_costos.Creacion_fecha,
	vehiculos_costos.Valor';
	$SIS_join  = '
	LEFT JOIN `vehiculos_costos_tipo`   ON vehiculos_costos_tipo.idTipo   = vehiculos_costos.idTipo
	LEFT JOIN `vehiculos_listado`       ON vehiculos_listado.idVehiculo   = vehiculos_costos.idVehiculo';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrCategorias = array();
	$arrCategorias = db_select_array (false, $SIS_query, 'vehiculos_costos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategorias');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Costo</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idTipo)){             $x1  = $idTipo;            }else{$x1  = '';}
					if(isset($idVehiculo)){         $x2  = $idVehiculo;        }else{$x2  = '';}
					if(isset($Creacion_fecha)){     $x3  = $Creacion_fecha;    }else{$x3  = '';}
					if(isset($Valor)){              $x4  = $Valor;            }else{$x4  = '';}
					if(isset($Observaciones)){      $x5  = $Observaciones;     }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Tipo de Costo','idTipo', $x1, 1, 'idTipo', 'Nombre', 'vehiculos_costos_tipo', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x2, 1, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha','Creacion_fecha', $x3, 1);
					$Form_Inputs->form_values('Valor', 'Valor', $x4, 1);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Costos Asociados</h5>
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
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Tipo</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Vehiculo</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=vehiculo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=vehiculo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Valor</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=valor_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=valor_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrCategorias as $cat) { ?>
						<tr class="odd">
							<td><?php echo fecha_estandar($cat['Creacion_fecha']); ?></td>
							<td><?php echo $cat['Tipo']; ?></td>
							<td><?php echo $cat['VehiculoNombre'].' Patente '.$cat['VehiculoPatente']; ?></td>
							<td align="right"><?php echo valores($cat['Valor'], 0); ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_vehiculos_costos.php?view='.simpleEncode($cat['idCosto'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$cat['idCosto']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($cat['idCosto'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la zona '.$cat['VehiculoNombre'].' Patente '.$cat['VehiculoPatente'].'?'; ?>
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
