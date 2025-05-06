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
$original = "gestion_tickets_cancelar.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){            $location .= "&idUsuario=".$_GET['idUsuario'];                    $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idArea']) && $_GET['idArea']!=''){                  $location .= "&idArea=".$_GET['idArea'];                          $search .= "&idArea=".$_GET['idArea'];}
if(isset($_GET['idTipoTicket']) && $_GET['idTipoTicket']!=''){      $location .= "&idTipoTicket=".$_GET['idTipoTicket'];              $search .= "&idTipoTicket=".$_GET['idTipoTicket'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){        $location .= "&idPrioridad=".$_GET['idPrioridad'];                $search .= "&idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['Titulo']) && $_GET['Titulo']!=''){                  $location .= "&Titulo=".$_GET['Titulo'];                          $search .= "&Titulo=".$_GET['Titulo'];}
if(isset($_GET['FechaCreacion']) && $_GET['FechaCreacion']!=''){    $location .= "&FechaCreacion=".$_GET['FechaCreacion'];            $search .= "&FechaCreacion=".$_GET['FechaCreacion'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_gestion_tickets.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Ticket Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Ticket Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Ticket Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'DescripcionCancelacion';
	$SIS_join  = '';
	$SIS_where = 'idTicket = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'gestion_tickets', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Cancelacion Ticket</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($DescripcionCancelacion)){    $x1  = $DescripcionCancelacion;    }else{$x1  = $rowData['DescripcionCancelacion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Descripcion Cancelacion','DescripcionCancelacion', $x1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idTicket', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 3, 2);
					$Form_Inputs->form_input_hidden('idUsuarioAsignado', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('FechaCancelacion', fecha_actual(), 2);

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
			case 'id_asc':              $order_by = 'gestion_tickets.idTicket ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Numero Ticket Ascendente';break;
			case 'id_desc':             $order_by = 'gestion_tickets.idTicket DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Numero Ticket Descendente';break;
			case 'usuario_asc':         $order_by = 'usuarios_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente';break;
			case 'usuario_desc':        $order_by = 'usuarios_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
			case 'tipo_asc':            $order_by = 'core_tipo_ticket.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ticket Ascendente';break;
			case 'tipo_desc':           $order_by = 'core_tipo_ticket.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Ticket Descendente';break;
			case 'titulo_asc':          $order_by = 'gestion_tickets.Titulo ASC ';          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Titulo Ticket Ascendente';break;
			case 'titulo_desc':         $order_by = 'gestion_tickets.Titulo DESC ';         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Titulo Ticket Descendente';break;
			case 'estado_asc':          $order_by = 'core_estado_ticket.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ticket Ascendente';break;
			case 'estado_desc':         $order_by = 'core_estado_ticket.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Ticket Descendente';break;
			case 'prioridad_asc':       $order_by = 'core_ot_prioridad.Nombre ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prioridad Ticket Ascendente';break;
			case 'prioridad_desc':      $order_by = 'core_ot_prioridad.Nombre DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Prioridad Ticket Descendente';break;
			case 'fechacreacion_asc':   $order_by = 'gestion_tickets.FechaCreacion ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Creacion Ticket Ascendente';break;
			case 'fechacreacion_desc':  $order_by = 'gestion_tickets.FechaCreacion DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Creacion Ticket Descendente';break;
			case 'area_asc':            $order_by = 'gestion_tickets_area.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Area Ascendente';break;
			case 'area_desc':           $order_by = 'gestion_tickets_area.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Area Descendente';break;

			default: $order_by = 'gestion_tickets.FechaCreacion DESC'; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Creacion Ascendente';
		}
	}else{
		$order_by = 'gestion_tickets.FechaCreacion DESC'; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Creacion Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "gestion_tickets.idTicket!=0";
	$SIS_where.= " AND gestion_tickets.idEstado=1";      //solo abierto
	$SIS_where.= " AND gestion_tickets.idTipoTicket=1";  //solo tickets
	$SIS_where.= " AND gestion_tickets.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//sistema
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){           $SIS_where .= " AND gestion_tickets.idUsuario=".$_GET['idUsuario'];}
	if(isset($_GET['idArea']) && $_GET['idArea']!=''){                 $SIS_where .= " AND gestion_tickets.idArea=".$_GET['idArea'];}
	if(isset($_GET['idTipoTicket']) && $_GET['idTipoTicket']!=''){     $SIS_where .= " AND gestion_tickets.idTipoTicket=".$_GET['idTipoTicket'];}
	if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){       $SIS_where .= " AND gestion_tickets.idPrioridad=".$_GET['idPrioridad'];}
	if(isset($_GET['Titulo']) && $_GET['Titulo']!=''){                 $SIS_where .= " AND gestion_tickets.Titulo  LIKE '%".EstandarizarInput($_GET['Titulo'])."%'";}
	if(isset($_GET['FechaCreacion']) && $_GET['FechaCreacion']!=''){   $SIS_where .= " AND gestion_tickets.FechaCreacion='".$_GET['FechaCreacion']."'";}
	$SIS_where.= " GROUP BY gestion_tickets.idTicket";

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'gestion_tickets.idTicket', 'gestion_tickets', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	gestion_tickets.idTicket,
	gestion_tickets.Titulo,
	gestion_tickets.FechaCreacion,

	core_sistemas.Nombre AS Sistema,
	usuarios_listado.Nombre AS Usuario,
	core_tipo_ticket.Nombre AS TipoTicket,
	core_estado_ticket.Nombre AS EstadoTicket,
	core_ot_prioridad.Nombre AS PrioridadTicket,
	gestion_tickets_area.Nombre AS AreaTicket';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                  ON core_sistemas.idSistema                  = gestion_tickets.idSistema
	LEFT JOIN `usuarios_listado`               ON usuarios_listado.idUsuario               = gestion_tickets.idUsuario
	LEFT JOIN `core_tipo_ticket`               ON core_tipo_ticket.idTipoTicket            = gestion_tickets.idTipoTicket
	LEFT JOIN `core_estado_ticket`             ON core_estado_ticket.idEstado              = gestion_tickets.idEstado
	LEFT JOIN `core_ot_prioridad`              ON core_ot_prioridad.idPrioridad            = gestion_tickets.idPrioridad
	LEFT JOIN `gestion_tickets_area`           ON gestion_tickets_area.idArea              = gestion_tickets.idArea
	LEFT JOIN `gestion_tickets_area_correos`   ON gestion_tickets_area_correos.idArea      = gestion_tickets.idArea';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrUsers = array();
	$arrUsers = db_select_array (false, $SIS_query, 'gestion_tickets', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	} ?>

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
					if(isset($idUsuario)){          $x1  = $idUsuario;            }else{$x1  = '';}
					if(isset($idArea)){             $x2  = $idArea;               }else{$x2  = '';}
					if(isset($idTipoTicket)){       $x3  = $idTipoTicket;         }else{$x3  = '';}
					if(isset($idPrioridad)){        $x4  = $idPrioridad;          }else{$x4  = '';}
					if(isset($Titulo)){             $x5  = $Titulo;               }else{$x5  = '';}
					if(isset($FechaCreacion)){      $x6  = $FechaCreacion;        }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x1, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_select('Area Ticket','idArea', $x2, 1, 'idArea', 'Nombre', 'crosstech_gestion_tickets_area', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo Ticket','idTipoTicket', $x3, 1, 'idTipoTicket', 'Nombre', 'core_tipo_ticket', 0, '', $dbConn);
					$Form_Inputs->form_select('Prioridad Ticket','idPrioridad', $x4, 1, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Título', 'Titulo', $x5, 1);
					$Form_Inputs->form_date('Fecha Creacion','FechaCreacion', $x6, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tickets</h5>
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
								<div class="pull-left">#</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=id_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=id_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Usuario</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Area</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=area_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=area_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Tipo Ticket</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Prioridad</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=prioridad_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=prioridad_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Titulo</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=titulo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=titulo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Fecha Creacion</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fechacreacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fechacreacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrUsers as $usuarios){ ?>
							<tr class="odd">
								<td><?php echo n_doc($usuarios['idTicket'], 8); ?></td>
								<td><?php echo $usuarios['Usuario']; ?></td>
								<td><?php echo $usuarios['EstadoTicket']; ?></td>
								<td><?php echo $usuarios['AreaTicket']; ?></td>
								<td><?php echo $usuarios['TipoTicket']; ?></td>
								<td><?php echo $usuarios['PrioridadTicket']; ?></td>
								<td><?php echo $usuarios['Titulo']; ?></td>
								<td><?php echo fecha_estandar($usuarios['FechaCreacion']); ?></td>
								<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['Sistema']; ?></td><?php } ?>
								<td>
									<div class="btn-group" style="width: 105px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_gestion_tickets.php?view='.simpleEncode($usuarios['idTicket'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idTicket']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($usuarios['idTicket'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el ticket N°'. n_doc($usuarios['idTicket'], 8).'?'; ?>
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
