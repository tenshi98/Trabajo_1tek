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
$original = "clientes_proyectos_listado.php";
$location = $original;
$new_location = "clientes_proyectos_listado_ubicaciones.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'createBasicDataClient';
	require_once 'A1XRXS_sys/xrxs_form/z_ubicacion_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'updateBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_ubicacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'delBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_ubicacion_listado.php';
}
//Si el estado esta distinto de vacio
if (!empty($_GET['estado'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&status='.$_GET['status'];
	//Llamamos al formulario
	$form_trabajo= 'estadoClient';
	require_once 'A1XRXS_sys/xrxs_form/z_ubicacion_listado.php';
}
/***********************************************************/
//formulario para crear
if (!empty($_POST['submit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'];
	//Llamamos al formulario
	$form_trabajo= 'insert_item';
	require_once 'A1XRXS_sys/xrxs_form/z_ubicacion_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'];
	//Llamamos al formulario
	$form_trabajo= 'update_item';
	require_once 'A1XRXS_sys/xrxs_form/z_ubicacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'];
	//Llamamos al formulario
	$form_trabajo= 'del_item';
	require_once 'A1XRXS_sys/xrxs_form/z_ubicacion_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Ubicación Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Ubicación Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Ubicación Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit_itemizado'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	$SIS_join  = '';
	$SIS_where = 'idLevel_'.$_GET['lvl'].' = '.$_GET['edit_itemizado'];
	$rowData = db_select_data (false, $SIS_query, 'ubicacion_listado_level_'.$_GET['lvl'], $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar Rama</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){            $x1  = $Nombre;             }else{$x1  = $rowData['Nombre'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_hidden('idLevel_'.$_GET['lvl'], $_GET['edit_itemizado'], 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);
					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);

					if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){  $Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);}
					if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){  $Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);}
					if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){  $Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);}
					if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){  $Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);}
					if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){  $Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new_itemizado'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Rama</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){            $x1  = $Nombre;             }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUbicacion', $_GET['itemizado'], 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);
					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);

					if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){  $Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);}
					if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){  $Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);}
					if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){  $Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);}
					if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){  $Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);}
					if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){  $Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['itemizado'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idSistema';
	$SIS_join  = '';
	$SIS_where = 'idUbicacion = '.$_GET['itemizado'];
	$rowData = db_select_data (false, $SIS_query, 'ubicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Se crean las variables
	$nmax = 5;
	$subquery = '';
	$leftjoin = '';
	$orderby = '';
	for ($i = 1; $i <= $nmax; $i++) {
		//consulta
		$subquery .= ',ubicacion_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
		$subquery .= ',ubicacion_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
		//Joins
		$xx = $i + 1;
		if($xx<=$nmax){
			$leftjoin .= ' LEFT JOIN `ubicacion_listado_level_'.$xx.'`   ON ubicacion_listado_level_'.$xx.'.idLevel_'.$i.'    = ubicacion_listado_level_'.$i.'.idLevel_'.$i;
		}
		//ORDER BY
		$orderby .= ', ubicacion_listado_level_'.$i.'.Nombre ASC';
	}

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'ubicacion_listado_level_1.idLevel_1 AS bla';
	$SIS_query.= $subquery;
	$SIS_join  = $leftjoin;
	$SIS_where = 'ubicacion_listado_level_1.idUbicacion='.$_GET['itemizado'];
	$SIS_order = 'ubicacion_listado_level_1.Nombre ASC';
	$SIS_order.= $orderby;
	$arrLicitacion = array();
	$arrLicitacion = db_select_array (false, $SIS_query, 'ubicacion_listado_level_1', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrLicitacion');

	/*******************************************************/
	$array3d = array();
	foreach($arrLicitacion as $key) {

		//Creo Variables para la rejilla
		for ($i = 1; $i <= $nmax; $i++) {
			$d[$i]  = $key['LVL_'.$i.'_id'];
			$n[$i]  = $key['LVL_'.$i.'_Nombre'];
		}

		if( $d['1']!=''){
			$array3d[$d['1']]['id']     = $d['1'];
			$array3d[$d['1']]['Nombre'] = $n['1'];
		}
		if( $d['2']!=''){
			$array3d[$d['1']][$d['2']]['id']     = $d['2'];
			$array3d[$d['1']][$d['2']]['Nombre'] = $n['2'];
		}
		if( $d['3']!=''){
			$array3d[$d['1']][$d['2']][$d['3']]['id']     = $d['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Nombre'] = $n['3'];
		}
		if( $d['4']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']     = $d['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre'] = $n['4'];
		}
		if( $d['5']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']     = $d['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre'] = $n['5'];
		}

	}

	/*******************************************************/
	function arrayToUL(array $array, $lv, $rowlevel,$location, $nmax){
		$lv++;
		if($lv==1){
			echo '<ul class="tree">';
		}else{
			echo '<ul style="padding-left: 20px;">';
		}

		foreach ($array as $key => $value){
			//Rearmo la ubicacion de acuerdo a la profundidad
			if (isset($value['id'])){
				$loc = $location.'&lv_'.$lv.'='.$value['id'];
			}else{
				$loc = $location;
			}

			if (isset($value['Nombre'])){
				echo '<li><div class="blum">';
				echo '<div class="pull-left">'.$value['Nombre'].'</div>';

				echo '<div class="btn-group pull-right" >';
					//Boton editar
					if ($rowlevel>=2){
						echo '<a href="'.$loc.'&edit_itemizado='.$value['id'].'&lvl='.$lv.'" title="Editar Esta Rama" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
					}
					//Boton Borrar
					if ($rowlevel>=4){
						$ubicacion = $loc.'&del_idLevel='.simpleEncode($value['id'], fecha_actual()).'&lvl='.$lv.'&nmax='.$nmax;
						$dialogo   = '¿Realmente deseas eliminar todos los datos relacionados a esta Rama?';
						echo '<a onClick="dialogBox(\''.$ubicacion.'\', \''.$dialogo.'\')" title="Borrar Esta Rama" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
					}
				echo '</div>';
				//Boton para crear nueva subrama condicionado a solo si no se utiliza

				echo '<div class="btn-group pull-right" style="margin-right:5px;" >';
					if ($rowlevel>=1){
						$xc = $lv + 1;
						if($lv<$nmax){
							echo '<a href="'.$loc.'&new_itemizado=true&lvl='.$xc.'" title="Crear sub-Rama" class="btn btn-primary btn-sm tooltip"><i class="fa fa-file-o" aria-hidden="true"></i></a>';
						}
					}
				echo '</div>';

				echo '<div class="clearfix"></div>';
				echo '</div>';
			}
			if (!empty($value) && is_array($value)){

				echo arrayToUL($value, $lv, $rowlevel,$loc, $nmax);
			}
			echo '</li>';
		}
		echo '</ul>';
	}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'].'&idSistema='.$rowData['idSistema'].'&new_itemizado=true&lvl=1'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Rama</a><?php } ?>

	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Itemizado Ubicación <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="table-responsive">

				<?php //Se imprime el arbol
				echo arrayToUL($array3d, 0, $rowlevel['level'],$new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'].'&idSistema='.$rowData['idSistema'], $nmax);
				?>

			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['status'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	ubicacion_listado.idUbicacion,
	ubicacion_listado.Nombre,
	core_estados.Nombre AS estado';
	$SIS_join  = 'LEFT JOIN `core_estados`   ON core_estados.idEstado = ubicacion_listado.idEstado';
	$SIS_where = 'idUbicacion = '.$_GET['status'];
	$rowData = db_select_data (false, $SIS_query, 'ubicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Estado Ubicación</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
							<td><?php echo 'Ubicación '.$rowData['Nombre'].' '.$rowData['estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php if ($rowlevel['level']>=2){ ?>
									<?php if ( $rowData['estado']=='Activo' ){ ?>
											<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$_GET['status'].'&estado='.simpleEncode(2, fecha_actual()) ; ?>">OFF</a>
											<a class="btn btn-sm btn-info locked_active" href="#">ON</a>
									<?php } else { ?>
											<a class="btn btn-sm btn-info locked_active" href="#">OFF</a>
											<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$_GET['status'].'&estado='.simpleEncode(1, fecha_actual()) ; ?>" >ON</a>
										<?php } ?>
									<?php } ?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idSistema';
	$SIS_join  = '';
	$SIS_where = 'idUbicacion = '.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'ubicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Ubicación</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){     $x1  = $Nombre;      }else{$x1  = $rowData['Nombre'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idUbicacion', $_GET['edit'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
	//verifico que sea un administrador
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Ubicación</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){       $x1  = $Nombre;       }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idTipo';
	$SIS_join  = '';
	$SIS_where = 'idCliente = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	ubicacion_listado.idUbicacion,
	ubicacion_listado.Nombre,
	core_sistemas.Nombre AS sistema,
	core_estados.Nombre AS Estado,
	ubicacion_listado.idSistema,
	ubicacion_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema     = ubicacion_listado.idSistema
	LEFT JOIN `core_estados`   ON core_estados.idEstado       = ubicacion_listado.idEstado';
	$SIS_where = 'ubicacion_listado.idCliente ='.$_GET['id'];
	$SIS_order = 'ubicacion_listado.Nombre ASC';
	$arrArea = array();
	$arrArea = db_select_array (false, $SIS_query, 'ubicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArea');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Proyecto', $rowData['Nombre'], 'Ubicaciones'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Ubicación</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'clientes_proyectos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos_persona_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
							<?php if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
								<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_contratos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Contratos</a></li>
							<li class="active"><a href="<?php echo 'clientes_proyectos_listado_ubicaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicaciones</a></li>
						</ul>
					</li>
				</ul>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre</th>
							<th>Estado</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrArea as $area) { ?>
						<tr class="odd">
							<td><?php echo $area['Nombre']; ?></td>
							<td><label class="label <?php if(isset($area['idEstado'])&&$area['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $area['Estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $area['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 175px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_ubicacion.php?view='.simpleEncode($area['idUbicacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$area['idUbicacion']; ?>" title="Editar Ubicación" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$area['idUbicacion']; ?>" title="Editar Estado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-power-off" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$area['idUbicacion']; ?>" title="Editar Itemizado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-server" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $new_location.'&del='.simpleEncode($area['idUbicacion'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el registro '.$area['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
