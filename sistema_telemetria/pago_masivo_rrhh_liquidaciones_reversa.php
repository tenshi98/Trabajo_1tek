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
$original = "pago_masivo_rrhh_liquidaciones_reversa.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$search = '';
if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){   $location .= "&idDocPago=".$_GET['idDocPago'];  $search .= "&idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){   $location .= "&N_DocPago=".$_GET['N_DocPago'];  $search .= "&N_DocPago=".$_GET['N_DocPago'];}
if(isset($_GET['Monto']) && $_GET['Monto']!=''){           $location .= "&Monto=".$_GET['Monto'];          $search .= "&Monto=".$_GET['Monto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){   $location .= "&idUsuario=".$_GET['idUsuario'];  $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['Fecha_Inicio'])&&$_GET['Fecha_Inicio']!=''&&isset($_GET['Fecha_Termino'])&&$_GET['Fecha_Termino']!=''){
	$search .="&f_programacion_desde=".$_GET['Fecha_Inicio'];
	$search .="&f_programacion_hasta=".$_GET['Fecha_Termino'];
}
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
/************************************************************/
//formulario para borrar
if (!empty($_GET['del_idDocPago'])){
	//Llamamos al formulario
	$form_trabajo= 'del_pagos';
	require_once 'A1XRXS_sys/xrxs_form/z_pagos_rrhh_liquidaciones_reversa.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['reversa'])){ $error['reversa'] = 'sucess/Pago Reversado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	pagos_rrhh_liquidaciones.idFactTrab,
	sistema_documentos_pago.idDocPago,
	sistema_documentos_pago.Nombre AS DocPago,
	pagos_rrhh_liquidaciones.N_DocPago,
	pagos_rrhh_liquidaciones.F_Pago,
	rrhh_sueldos_facturacion_trabajadores.Creacion_fecha,
	pagos_rrhh_liquidaciones.MontoPagado,
	pagos_rrhh_liquidaciones.montoPactado,
	trabajadores_listado.Nombre,
	trabajadores_listado.ApellidoPat,
	trabajadores_listado.ApellidoMat,
	trabajadores_listado.Rut';
	$SIS_join  = '
	LEFT JOIN `sistema_documentos_pago`                 ON sistema_documentos_pago.idDocPago                 = pagos_rrhh_liquidaciones.idDocPago
	LEFT JOIN `rrhh_sueldos_facturacion_trabajadores`   ON rrhh_sueldos_facturacion_trabajadores.idFactTrab  = pagos_rrhh_liquidaciones.idFactTrab
	LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador                 = rrhh_sueldos_facturacion_trabajadores.idTrabajador';
	$SIS_where = 'pagos_rrhh_liquidaciones.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){	$SIS_where .= ' AND pagos_rrhh_liquidaciones.idDocPago='.$_GET['idDocPago'];}
	if(isset($_GET['N_DocPago'])&&$_GET['N_DocPago']!=''){	$SIS_where .= ' AND pagos_rrhh_liquidaciones.N_DocPago='.$_GET['N_DocPago'];}
	$SIS_order = 0;
	$arrReversa = array();
	$arrReversa = db_select_array (false, $SIS_query, 'pagos_rrhh_liquidaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrReversa');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Facturaciones Pagadas</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Rut</th>
							<th>Trabajador</th>
							<th>Fecha Facturacion</th>
							<th>Fecha Pago</th>
							<th>monto Pactado</th>
							<th>Monto Pagado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						if ($arrReversa!=false && !empty($arrReversa) && $arrReversa!='') {
							//llamamos a la función para filtrar los datos
							filtrar($arrReversa, 'N_DocPago');
							//recorremos el array para imprimirlo con formato HTML
							foreach($arrReversa as $menu=>$productos) { ?>
								<tr class="odd">
									<td colspan="6" style="background-color: #BFBFBF;"><?php echo $productos[0]['DocPago'].' '.$menu; ?></td>
									<td style="background-color: #BFBFBF;">
										<div class="btn-group" style="width: 35px;" >
											<?php if ($rowlevel['level']>=4){
												$ubicacion = $location.'&submit_filter=Filtrar&del_idDocPago='.simpleEncode($productos[0]['idDocPago'], fecha_actual()).'&del_N_DocPago='.simpleEncode($menu, fecha_actual());
												$dialogo   = '¿Realmente deseas eliminar el pago '.$productos[0]['DocPago'].' '.$menu.'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-exchange" aria-hidden="true"></i></a>
											<?php } ?>
										</div>
									</td>
								</tr>
								<?php foreach ($productos as $tipo){ ?>
									<tr class="odd">
										<td><?php echo $tipo['Rut']; ?></td>
										<td><?php echo $tipo['Nombre'].' '.$tipo['ApellidoPat'].' '.$tipo['ApellidoMat']; ?></td>
										<td><?php echo fecha_estandar($tipo['Creacion_fecha']); ?></td>
										<td><?php echo fecha_estandar($tipo['F_Pago']); ?></td>
										<td align="right"><?php echo $tipo['montoPactado']; ?></td>
										<td align="right"><?php echo $tipo['MontoPagado']; ?></td>
										<td>
											<div class="btn-group" style="width: 35px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_rrhh_sueldos.php?view='.simpleEncode($tipo['idFactTrab'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//se crea filtro
	//Verifico el tipo de usuario que esta ingresando
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Filtro de Búsqueda</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idDocPago)){   $x1  = $idDocPago;   }else{$x1  = '';}
					if(isset($N_DocPago)){   $x2  = $N_DocPago;   }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Documento de Pago','idDocPago', $x1, 1, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
					$Form_Inputs->form_input_number('N° Documento de Pago', 'N_DocPago', $x2, 1);

					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
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
			case 'fecha_asc':        $order_by = 'pagos_rrhh_liquidaciones_reversa.Fecha ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':       $order_by = 'pagos_rrhh_liquidaciones_reversa.Fecha DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'documento_asc':    $order_by = 'sistema_documentos_pago.Nombre ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Documento Ascendente'; break;
			case 'documento_desc':   $order_by = 'sistema_documentos_pago.Nombre DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Documento Descendente';break;
			case 'n_documento_asc':  $order_by = 'pagos_rrhh_liquidaciones_reversa.N_DocPago ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Documento Ascendente'; break;
			case 'n_documento_desc': $order_by = 'pagos_rrhh_liquidaciones_reversa.N_DocPago DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Documento Descendente';break;
			case 'monto_asc':        $order_by = 'pagos_rrhh_liquidaciones_reversa.Monto ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Monto Ascendente'; break;
			case 'monto_desc':       $order_by = 'pagos_rrhh_liquidaciones_reversa.Monto DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Monto Descendente';break;
			case 'usuario_asc':      $order_by = 'usuarios_listado.Nombre AS Usuario ASC ';          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente'; break;
			case 'usuario_desc':     $order_by = 'usuarios_listado.Nombre AS Usuario DESC ';         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;

			default: $order_by = 'pagos_rrhh_liquidaciones_reversa.Fecha ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente';
		}
	}else{
		$order_by = 'pagos_rrhh_liquidaciones_reversa.Fecha ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente';
	}

	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "pagos_rrhh_liquidaciones_reversa.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){   $SIS_where .= " AND pagos_rrhh_liquidaciones_reversa.idDocPago=".$_GET['idDocPago'];}
	if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){   $SIS_where .= " AND pagos_rrhh_liquidaciones_reversa.N_DocPago=".$_GET['N_DocPago'];}
	if(isset($_GET['Monto']) && $_GET['Monto']!=''){           $SIS_where .= " AND pagos_rrhh_liquidaciones_reversa.Monto=".$_GET['Monto'];}
	if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){   $SIS_where .= " AND pagos_rrhh_liquidaciones_reversa.idUsuario=".$_GET['idUsuario'];}
	if(isset($_GET['Fecha_Inicio'])&&$_GET['Fecha_Inicio']!=''&&isset($_GET['Fecha_Termino'])&&$_GET['Fecha_Termino']!=''){
		$SIS_where.= " AND pagos_rrhh_liquidaciones_reversa.Fecha BETWEEN '".$_GET['Fecha_Inicio']."' AND '".$_GET['Fecha_Termino']."'";
	}
	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idReversa', 'pagos_rrhh_liquidaciones_reversa', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	pagos_rrhh_liquidaciones_reversa.Fecha,
	pagos_rrhh_liquidaciones_reversa.Hora,
	pagos_rrhh_liquidaciones_reversa.N_DocPago,
	pagos_rrhh_liquidaciones_reversa.Monto,

	usuarios_listado.Nombre AS Usuario,
	sistema_documentos_pago.Nombre AS DocPago';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`          ON usuarios_listado.idUsuario          = pagos_rrhh_liquidaciones_reversa.idUsuario
	LEFT JOIN `sistema_documentos_pago`   ON sistema_documentos_pago.idDocPago   = pagos_rrhh_liquidaciones_reversa.idDocPago';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrAFP = array();
	$arrAFP = db_select_array (false, $SIS_query, 'pagos_rrhh_liquidaciones_reversa', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAFP');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Reversa</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					if(isset($idDocPago)){       $x1  = $idDocPago;       }else{$x1  = '';}
					if(isset($N_DocPago)){       $x2  = $N_DocPago;       }else{$x2  = '';}
					if(isset($Monto)){           $x3  = $Monto;           }else{$x3  = '';}
					if(isset($idUsuario)){       $x4  = $idUsuario;       }else{$x4  = '';}
					if(isset($Fecha_Inicio)){    $x5  = $Fecha_Inicio;    }else{$x5  = '';}
					if(isset($Fecha_Termino)){   $x6  = $Fecha_Termino;   }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Documento de Pago','idDocPago', $x1, 1, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
					$Form_Inputs->form_input_number('N° Documento de Pago', 'N_DocPago', $x2, 1);
					$Form_Inputs->form_input_number('Monto', 'Monto', $x3, 1);
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x4, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_date('Fecha Inicio','Fecha_Inicio', $x5, 1);
					$Form_Inputs->form_date('Fecha Termino','Fecha_Termino', $x6, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Reversas</h5>
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
							<th width="160">
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Documento</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=documento_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=documento_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="180">
								<div class="pull-left">N° Documento</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=n_documento_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=n_documento_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Monto</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=monto_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=monto_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Usuario</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrAFP as $afp) { ?>
						<tr class="odd">
							<td><?php echo $afp['Fecha'].' '.$afp['Hora']; ?></td>
							<td><?php echo $afp['DocPago']; ?></td>
							<td><?php echo $afp['N_DocPago']; ?></td>
							<td align="right"><?php echo valores($afp['Monto'], 0); ?></td>
							<td><?php echo $afp['Usuario']; ?></td>
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
