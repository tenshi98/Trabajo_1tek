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
$original = "principal_agenda_telefonica.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/principal_agenda_telefonica.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/principal_agenda_telefonica.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/principal_agenda_telefonica.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Contacto Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Contacto Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Contacto Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,Fono, idSistema, idUsuario';
	$SIS_join  = '';
	$SIS_where = 'idAgenda = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'principal_agenda_telefonica', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación del Contacto</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;     }else{$x1  = $rowData['Nombre'];}
					if(isset($Fono)){        $x2  = $Fono;       }else{$x2  = $rowData['Fono'];}
					if(isset($idUsuario)){   $x3  = $idUsuario;  }else{$x3  = $rowData['idUsuario'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_phone('Telefono', 'Fono', $x2, 2);

					$zx ='';
					$zy ='';
					if($x3==$_SESSION['usuario']['basic_data']['idUsuario']){
						$zx ='selected=""';
					}elseif($x3==9999){
						$zy ='selected=""';
					}
					echo '<div class="form-group" id="div_idUsuario">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_idSistema">Visibilidad</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="idUsuario" id="idUsuario" class="form-control" required="">
								<option value="" selected="">Seleccione una Opción</option>
								<option '.$zx.' value="'.$_SESSION['usuario']['basic_data']['idUsuario'].'">Solo yo</option>
								<option '.$zy.' value="9999">Todos</option>
							</select>
						</div>
					</div>';

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idAgenda', $_GET['id'], 2);
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
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Nuevo Contacto</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;     }else{$x1  = '';}
					if(isset($Fono)){        $x2  = $Fono;       }else{$x2  = '';}
					if(isset($idUsuario)){   $x3  = $idUsuario;  }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_phone('Telefono', 'Fono', $x2, 2);

					$zx ='';
					$zy ='';
					if($x3==$_SESSION['usuario']['basic_data']['idUsuario']){
						$zx ='selected=""';
					}elseif($x3==9999){
						$zy ='selected=""';
					}
					echo '<div class="form-group" id="div_idUsuario">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_idSistema">Visibilidad</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="idUsuario" id="idUsuario" class="form-control" required="">
								<option value="" selected="">Seleccione una Opción</option>
								<option '.$zx.' value="'.$_SESSION['usuario']['basic_data']['idUsuario'].'">Solo yo</option>
								<option '.$zy.' value="9999">Todos</option>
							</select>
						</div>
					</div>';

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
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
	//Se inicializa el paginador de resultados
	//tomo el numero de la pagina si es que este existe
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where  = "principal_agenda_telefonica.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//filtro si el documento lo creo el usuario o el sistema
	$SIS_where .= " AND principal_agenda_telefonica.idUsuario = '".$_SESSION['usuario']['basic_data']['idUsuario']."'";
	$SIS_where .= " OR principal_agenda_telefonica.idUsuario = '9999' ";
	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idAgenda', 'principal_agenda_telefonica', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	principal_agenda_telefonica.idAgenda,
	principal_agenda_telefonica.Nombre,
	principal_agenda_telefonica.Fono,
	principal_agenda_telefonica.idUsuario,
	core_sistemas.Nombre AS Sistema';
	$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = principal_agenda_telefonica.idSistema';
	$SIS_order = 'Nombre ASC LIMIT '.$comienzo.', '.$cant_reg;
	$arrContactos = array();
	$arrContactos = db_select_array (false, $SIS_query, 'principal_agenda_telefonica', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrContactos');

	//paginador
	$search='';

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Contactos</h5>
				<div class="toolbar">
					<?php
					//Paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre</th>
							<th>Fono</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrContactos as $cont) { ?>
						<tr class="odd">
							<td><?php echo $cont['Nombre']; ?></td>
							<td><?php echo formatPhone($cont['Fono']); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $cont['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if($cont['idUsuario']!=9999){ ?>
										<a href="<?php echo $location.'&id='.$cont['idAgenda']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
										$ubicacion = $location.'&del='.simpleEncode($cont['idAgenda'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el contacto '.$cont['Nombre'].'?'; ?>
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
				//paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px; margin-top:30px">
		<a href="principal.php" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
