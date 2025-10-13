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
$original = "trabajadores_licencias.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){      $location .= "&idTrabajador=".$_GET['idTrabajador'];       $search .= "&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){            $location .= "&idUsuario=".$_GET['idUsuario'];             $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['Fecha_inicio']) && $_GET['Fecha_inicio']!=''){      $location .= "&Fecha_inicio=".$_GET['Fecha_inicio'];       $search .= "&Fecha_inicio=".$_GET['Fecha_inicio'];}
if(isset($_GET['Fecha_termino']) && $_GET['Fecha_termino']!=''){    $location .= "&Fecha_termino=".$_GET['Fecha_termino'];     $search .= "&Fecha_termino=".$_GET['Fecha_termino'];}
if(isset($_GET['N_Dias']) && $_GET['N_Dias']!=''){                  $location .= "&N_Dias=".$_GET['N_Dias'];                   $search .= "&N_Dias=".$_GET['N_Dias'];}
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
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_licencias.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_licencias.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_licencias.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Nueva ubicacion
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_file';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_licencias.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Licencia Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Licencia Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Licencia Borrada correctamente';}
if (isset($_GET['delfile'])){ $error['delfile'] = 'sucess/Archivo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idTrabajador,Fecha_inicio, Fecha_termino, N_Dias,File_Licencia,Observacion, idSistema';
	$SIS_join  = '';
	$SIS_where = 'idLicencia = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'trabajadores_licencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
	/*******************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación de la Licencia</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTrabajador)){    $x1  = $idTrabajador;    }else{$x1  = $rowData['idTrabajador'];}
					if(isset($Fecha_inicio)){    $x2  = $Fecha_inicio;    }else{$x2  = $rowData['Fecha_inicio'];}
					if(isset($Fecha_termino)){   $x3  = $Fecha_termino;   }else{$x3  = $rowData['Fecha_termino'];}
					if(isset($N_Dias)){          $x4  = $N_Dias;          }else{$x4  = $rowData['N_Dias'];}
					if(isset($Observacion)){     $x5  = $Observacion;     }else{$x5  = $rowData['Observacion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha inicio','Fecha_inicio', $x2, 2);
					$Form_Inputs->form_date('Fecha termino','Fecha_termino', $x3, 2);
					$Form_Inputs->form_input_number('N° Dias', 'N_Dias', $x4, 2);
					$Form_Inputs->form_textarea('Observaciones','Observacion', $x5, 1);

					if(isset($rowData['File_Licencia'])&&$rowData['File_Licencia']!=''){ ?>

						<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
							<h3>Archivo</h3>
							<?php echo preview_docs(DB_SITE_REPO.DB_SITE_MAIN_PATH, 'upload/'.$rowData['File_Licencia'], ''); ?>
						</div>
						<a href="<?php echo $location.'&id='.$_GET['id'].'&del_file='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Archivo</a>
						<div class="clearfix"></div>

					<?php
					}else{
						$Form_Inputs->form_multiple_upload('Seleccionar archivo','File_Licencia', 1, '"doc","docx","pdf","jpg", "png", "gif", "jpeg"');

					}

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idLicencia', $_GET['id'], 2);

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
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Licencia</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" novalidate enctype="multipart/form-data" >

					<?php
					//Se verifican si existen los datos
					if(isset($idTrabajador)){    $x1  = $idTrabajador;    }else{$x1  = '';}
					if(isset($Fecha_inicio)){    $x2  = $Fecha_inicio;    }else{$x2  = '';}
					if(isset($Fecha_termino)){   $x3  = $Fecha_termino;   }else{$x3  = '';}
					if(isset($N_Dias)){          $x4  = $N_Dias;          }else{$x4  = '';}
					if(isset($Observacion)){     $x5  = $Observacion;     }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha inicio','Fecha_inicio', $x2, 2);
					$Form_Inputs->form_date('Fecha termino','Fecha_termino', $x3, 2);
					$Form_Inputs->form_input_number('N° Dias', 'N_Dias', $x4, 2);
					$Form_Inputs->form_textarea('Observaciones','Observacion', $x5, 1);
					$Form_Inputs->form_multiple_upload('Seleccionar archivo','File_Licencia', 1, '"doc","docx","pdf","jpg", "png", "gif", "jpeg"');

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('Fecha_ingreso', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idUso', 1, 2);

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
			case 'fecha_asc':        $order_by = 'trabajadores_licencias.Fecha_inicio ASC ';                                                                          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente';break;
			case 'fecha_desc':       $order_by = 'trabajadores_licencias.Fecha_inicio DESC ';                                                                         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'ndias_asc':        $order_by = 'trabajadores_licencias.N_Dias ASC ';                                                                                $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Dias Ascendente';break;
			case 'ndias_desc':       $order_by = 'trabajadores_licencias.N_Dias DESC ';                                                                               $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Dias Descendente';break;
			case 'trabajador_asc':   $order_by = 'trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Trabajador Ascendente'; break;
			case 'trabajador_desc':  $order_by = 'trabajadores_listado.ApellidoPat DESC, trabajadores_listado.ApellidoMat DESC, trabajadores_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Trabajador Descendente';break;
			case 'usuario_asc':      $order_by = 'usuarios_listado.Nombre ASC ';                                                                                      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente'; break;
			case 'usuario_desc':     $order_by = 'usuarios_listado.Nombre DESC ';                                                                                     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;

			default: $order_by = 'trabajadores_licencias.Fecha_inicio DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
		}
	}else{
		$order_by = 'trabajadores_licencias.Fecha_inicio DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "trabajadores_licencias.idLicencia!=0";
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){      $SIS_where .= " AND trabajadores_licencias.idTrabajador=".$_GET['idTrabajador'];}
	if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){            $SIS_where .= " AND trabajadores_licencias.idUsuario=".$_GET['idUsuario'];}
	if(isset($_GET['Fecha_inicio']) && $_GET['Fecha_inicio']!=''){      $SIS_where .= " AND trabajadores_licencias.Fecha_inicio=".$_GET['Fecha_inicio'];}
	if(isset($_GET['Fecha_termino']) && $_GET['Fecha_termino']!=''){    $SIS_where .= " AND trabajadores_licencias.Fecha_termino=".$_GET['Fecha_termino'];}
	if(isset($_GET['N_Dias']) && $_GET['N_Dias']!=''){                  $SIS_where .= " AND trabajadores_licencias.N_Dias=".$_GET['N_Dias'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idLicencia', 'trabajadores_licencias', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	trabajadores_licencias.idLicencia,
	trabajadores_listado.ApellidoPat AS TrabApellidoPat,
	trabajadores_listado.ApellidoMat AS TrabApellidoMat,
	trabajadores_listado.Nombre AS TrabNombre,
	usuarios_listado.Nombre AS UserNombre,
	trabajadores_licencias.Fecha_inicio,
	trabajadores_licencias.Fecha_termino,
	trabajadores_licencias.N_Dias,
	core_sistemas.Nombre AS Sistema,
	trabajadores_licencias.idUso';
	$SIS_join  = '
	LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador  = trabajadores_licencias.idTrabajador
	LEFT JOIN `usuarios_listado`     ON usuarios_listado.idUsuario         = trabajadores_licencias.idUsuario
	LEFT JOIN `core_sistemas`        ON core_sistemas.idSistema            = trabajadores_licencias.idSistema';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrInasHoras = array();
	$arrInasHoras = db_select_array (false, $SIS_query, 'trabajadores_licencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrInasHoras');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Licencia</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idTrabajador)){    $x1  = $idTrabajador;    }else{$x1  = '';}
					if(isset($Fecha_inicio)){    $x2  = $Fecha_inicio;    }else{$x2  = '';}
					if(isset($Fecha_termino)){   $x3  = $Fecha_termino;   }else{$x3  = '';}
					if(isset($N_Dias)){          $x4  = $N_Dias;          }else{$x4  = '';}
					if(isset($idUsuario)){       $x5  = $idUsuario;       }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha inicio','Fecha_inicio', $x2, 1);
					$Form_Inputs->form_date('Fecha termino','Fecha_termino', $x3, 1);
					$Form_Inputs->form_input_number('N° Dias', 'N_Dias', $x4, 1);
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x5, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Licencias</h5>
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
								<div class="pull-left">Fechas</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">N° Dias</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ndias_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ndias_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Trabajador</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=trabajador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=trabajador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Usuario</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrInasHoras as $plan) { ?>
						<tr class="odd">
							<td><?php echo fecha_estandar($plan['Fecha_inicio']).' al '.fecha_estandar($plan['Fecha_termino']); ?></td>
							<td><?php echo $plan['N_Dias']; ?></td>
							<td><?php echo $plan['TrabApellidoPat'].' '.$plan['TrabApellidoMat'].' '.$plan['TrabNombre']; ?></td>
							<td><?php echo $plan['UserNombre']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $plan['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_licencia.php?view='.simpleEncode($plan['idLicencia'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php
									//mientras no haya sido utilizado se puede modificar y borrar el dato
									if(isset($plan['idUso'])&&$plan['idUso']==1){ ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$plan['idLicencia']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($plan['idLicencia'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la licencia del '.fecha_estandar($plan['Fecha_inicio']).'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										<?php } ?>
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
