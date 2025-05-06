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
$original = "seguridad_recepcion_documentos.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){    $location .= "&idUsuario=".$_GET['idUsuario'];    $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){      $location .= "&h_inicio=".$_GET['h_inicio'];      $search .= "&h_inicio=".$_GET['h_inicio'];}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){    $location .= "&h_termino=".$_GET['h_termino'];    $search .= "&h_termino=".$_GET['h_termino'];}
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){      $location .= "&f_inicio=".$_GET['f_inicio'];      $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){    $location .= "&f_termino=".$_GET['f_termino'];    $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){          $location .= "&Nombre=".$_GET['Nombre'];          $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['De']) && $_GET['De']!=''){                  $location .= "&De=".$_GET['De'];                  $search .= "&De=".$_GET['De'];}
if(isset($_GET['Para']) && $_GET['Para']!=''){              $location .= "&Para=".$_GET['Para'];              $search .= "&Para=".$_GET['Para'];}
if(isset($_GET['Destino']) && $_GET['Destino']!=''){        $location .= "&Destino=".$_GET['Destino'];        $search .= "&Destino=".$_GET['Destino'];}
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
	require_once 'A1XRXS_sys/xrxs_form/seguridad_recepcion_documentos.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/seguridad_recepcion_documentos.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/seguridad_recepcion_documentos.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Recepcion Documento Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Recepcion Documento Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Recepcion Documento Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Fecha,Hora,idTipo, De, Para, Observaciones';
	$SIS_join  = '';
	$SIS_where = 'idRecepcion = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'seguridad_recepcion_documentos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación de Recepcion Documento</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Fecha)){            $x1  = $Fecha;           }else{$x1  = $rowData['Fecha'];}
					if(isset($Hora)){             $x2  = $Hora;            }else{$x2  = $rowData['Hora'];}
					if(isset($idTipo)){           $x3  = $idTipo;          }else{$x3  = $rowData['idTipo'];}
					if(isset($De)){               $x4  = $De;              }else{$x4  = $rowData['De'];}
					if(isset($Para)){             $x5  = $Para;            }else{$x5  = $rowData['Para'];}
					if(isset($Observaciones)){    $x6  = $Observaciones;   }else{$x6  = $rowData['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha','Fecha', $x1, 2);
					$Form_Inputs->form_time('Hora','Hora', $x2, 2, 2);
					$Form_Inputs->form_select('Tipo Recepcion','idTipo', $x3, 2, 'idTipo', 'Nombre', 'core_tipo_recepcion', 0, '', $dbConn);
					$Form_Inputs->form_input_text('De', 'De', $x4, 2);
					$Form_Inputs->form_input_text('Para', 'Para', $x5, 2);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idRecepcion', $_GET['id'], 2);
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
				<h5>Crear Recepcion Documento</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Fecha)){            $x1  = $Fecha;           }else{$x1  = '';}
					if(isset($Hora)){             $x2  = $Hora;            }else{$x2  = '';}
					if(isset($idTipo)){           $x3  = $idTipo;          }else{$x3  = '';}
					if(isset($De)){               $x4  = $De;              }else{$x4  = '';}
					if(isset($Para)){             $x5  = $Para;            }else{$x5  = '';}
					if(isset($Observaciones)){    $x6  = $Observaciones;   }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha','Fecha', $x1, 2);
					$Form_Inputs->form_time('Hora','Hora', $x2, 2, 2);
					$Form_Inputs->form_select('Tipo Recepcion','idTipo', $x3, 2, 'idTipo', 'Nombre', 'core_tipo_recepcion', 0, '', $dbConn);
					$Form_Inputs->form_input_text('De', 'De', $x4, 2);
					$Form_Inputs->form_input_text('Para', 'Para', $x5, 2);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
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
			case 'usuario_asc':    $order_by = 'usuarios_listado.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente'; break;
			case 'usuario_desc':   $order_by = 'usuarios_listado.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
			case 'hora_asc':       $order_by = 'seguridad_recepcion_documentos.Hora ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Ascendente'; break;
			case 'hora_desc':      $order_by = 'seguridad_recepcion_documentos.Hora DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Descendente';break;
			case 'fecha_asc':      $order_by = 'seguridad_recepcion_documentos.Fecha ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':     $order_by = 'seguridad_recepcion_documentos.Fecha DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'tipo_asc':       $order_by = 'core_tipo_recepcion.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Documento Ascendente'; break;
			case 'tipo_desc':      $order_by = 'core_tipo_recepcion.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Documento Descendente';break;
			case 'de_asc':         $order_by = 'seguridad_recepcion_documentos.De ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> De Ascendente'; break;
			case 'de_desc':        $order_by = 'seguridad_recepcion_documentos.De DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> De Descendente';break;
			case 'para_asc':       $order_by = 'seguridad_recepcion_documentos.Para ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Para Ascendente'; break;
			case 'para_desc':      $order_by = 'seguridad_recepcion_documentos.Para DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Para Descendente';break;

			default: $order_by = 'seguridad_recepcion_documentos.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
		}
	}else{
		$order_by = 'seguridad_recepcion_documentos.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "seguridad_recepcion_documentos.idRecepcion!=0";
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where.= " AND seguridad_recepcion_documentos.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idUsuario']) && $_GET['idUsuario'] != ''){
		$SIS_where .= " AND seguridad_recepcion_documentos.idUsuario = '".$_GET['idUsuario']."'";
	}
	if(isset($_GET['h_inicio'], $_GET['h_termino']) && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
		$SIS_where .= " AND seguridad_recepcion_documentos.Hora BETWEEN '".$_GET['h_inicio']."' AND '".$_GET['h_termino']."'";
	}
	if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
		$SIS_where .= " AND seguridad_recepcion_documentos.Fecha BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
	}
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){  $SIS_where .= " AND seguridad_recepcion_documentos.idTipo='".$_GET['idTipo']."'";}
	if(isset($_GET['De']) && $_GET['De']!=''){          $SIS_where .= " AND seguridad_recepcion_documentos.De LIKE '%".EstandarizarInput($_GET['De'])."%'";}
	if(isset($_GET['Para']) && $_GET['Para']!=''){      $SIS_where .= " AND seguridad_recepcion_documentos.Para LIKE '%".EstandarizarInput($_GET['Para'])."%'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idRecepcion', 'seguridad_recepcion_documentos', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	seguridad_recepcion_documentos.idRecepcion,
	seguridad_recepcion_documentos.Fecha,
	seguridad_recepcion_documentos.Hora,
	seguridad_recepcion_documentos.De,
	seguridad_recepcion_documentos.Para,
	core_sistemas.Nombre AS Sistema,
	usuarios_listado.Nombre AS Usuario,
	core_tipo_recepcion.Nombre AS Tipo';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`     ON usuarios_listado.idUsuario  = seguridad_recepcion_documentos.idUsuario
	LEFT JOIN `core_sistemas`        ON core_sistemas.idSistema     = seguridad_recepcion_documentos.idSistema
	LEFT JOIN `core_tipo_recepcion`  ON core_tipo_recepcion.idTipo  = seguridad_recepcion_documentos.idTipo';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'seguridad_recepcion_documentos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Recepcion</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idUsuario)){   $x1  = $idUsuario;  }else{$x1  = '';}
					if(isset($f_inicio)){    $x2  = $f_inicio;   }else{$x2  = '';}
					if(isset($f_termino)){   $x3  = $f_termino;  }else{$x3  = '';}
					if(isset($h_inicio)){    $x4  = $h_inicio;   }else{$x4  = '';}
					if(isset($h_termino)){   $x5  = $h_termino;  }else{$x5  = '';}
					if(isset($idTipo)){      $x6  = $idTipo;     }else{$x6  = '';}
					if(isset($De)){          $x7  = $De;         }else{$x7  = '';}
					if(isset($Para)){        $x8  = $Para;       }else{$x8  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x1, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x2, 1);
					$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 1);
					$Form_Inputs->form_time('Hora Inicio','h_inicio', $x4, 1, 1);
					$Form_Inputs->form_time('Hora Termino','h_termino', $x5, 1, 1);
					$Form_Inputs->form_select('Tipo Recepcion','idTipo', $x6, 1, 'idTipo', 'Nombre', 'core_tipo_recepcion', 0, '', $dbConn);
					$Form_Inputs->form_input_text('De', 'De', $x7, 1);
					$Form_Inputs->form_input_text('Para', 'Para', $x8, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos Recibidos</h5>
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
								<div class="pull-left">Usuario</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Hora</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=hora_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=hora_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
								<div class="pull-left">De</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=de_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=de_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Para</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=para_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=para_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrTipo as $tipo) { ?>
							<tr class="odd">
								<td><?php echo $tipo['Usuario']; ?></td>
								<td><?php echo fecha_estandar($tipo['Fecha']); ?></td>
								<td><?php echo $tipo['Hora']; ?></td>
								<td><?php echo $tipo['Tipo']; ?></td>
								<td><?php echo $tipo['De']; ?></td>
								<td><?php echo $tipo['Para']; ?></td>
								<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$tipo['idRecepcion']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($tipo['idRecepcion'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la recepcion del documento ?'; ?>
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
