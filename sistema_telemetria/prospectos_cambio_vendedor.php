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
$original = "prospectos_cambio_vendedor.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){            $location .= "&idTipo=".$_GET['idTipo'];              $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){            $location .= "&Nombre=".$_GET['Nombre'];              $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){                  $location .= "&Rut=".$_GET['Rut'];                    $search .= "&Rut=".$_GET['Rut'];}
if(isset($_GET['fNacimiento']) && $_GET['fNacimiento']!=''){  $location .= "&fNacimiento=".$_GET['fNacimiento'];    $search .= "&fNacimiento=".$_GET['fNacimiento'];}
if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){        $location .= "&idCiudad=".$_GET['idCiudad'];          $search .= "&idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){        $location .= "&idComuna=".$_GET['idComuna'];          $search .= "&idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){      $location .= "&Direccion=".$_GET['Direccion'];        $search .= "&Direccion=".$_GET['Direccion'];}
if(isset($_GET['Giro']) && $_GET['Giro']!=''){                $location .= "&Giro=".$_GET['Giro'];                  $search .= "&Giro=".$_GET['Giro'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){      $location .= "&idUsuario=".$_GET['idUsuario'];        $search .= "&idUsuario=".$_GET['idUsuario'];}

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
	require_once 'A1XRXS_sys/xrxs_form/prospectos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Prospecto Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Prospecto Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Prospecto Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUsuario';
	$SIS_join  = '';
	$SIS_where = 'idProspecto = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'prospectos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
	/*******************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
		$usrfil .= " AND usuarios_listado.idTipoUsuario=5";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación de la Unidad de Medida</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idUsuario)){      $x1  = $idUsuario;     }else{$x1  = $rowData['idUsuario'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Vendedor','idUsuario', $x1, 2, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

					$Form_Inputs->form_input_hidden('idProspecto', $_GET['id'], 2);
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
			case 'rut_asc':       $order_by = 'prospectos_listado.Rut ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Rut Ascendente'; break;
			case 'rut_desc':      $order_by = 'prospectos_listado.Rut DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Rut Descendente';break;
			case 'nombre_asc':    $order_by = 'prospectos_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
			case 'nombre_desc':   $order_by = 'prospectos_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'vendedor_asc':  $order_by = 'usuarios_listado.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Vendedor Ascendente';break;
			case 'vendedor_desc': $order_by = 'usuarios_listado.Nombre DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Vendedor Descendente';break;
			case 'estado_asc':    $order_by = 'prospectos_listado.idEstado ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':   $order_by = 'prospectos_listado.idEstado DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

			default: $order_by = 'prospectos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
		}
	}else{
		$order_by = 'prospectos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "prospectos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	//verifico que sea un administrador
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= ' AND usuarios_listado.idTipoUsuario=5';
	}
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){             $SIS_where .= " AND prospectos_listado.idTipo=".$_GET['idTipo'];}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){             $SIS_where .= " AND prospectos_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['Rut']) && $_GET['Rut']!=''){                   $SIS_where .= " AND prospectos_listado.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
	if(isset($_GET['fNacimiento']) && $_GET['fNacimiento']!=''){   $SIS_where .= " AND prospectos_listado.fNacimiento='".$_GET['fNacimiento']."'";}
	if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){         $SIS_where .= " AND prospectos_listado.idCiudad=".$_GET['idCiudad'];}
	if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){         $SIS_where .= " AND prospectos_listado.idComuna=".$_GET['idComuna'];}
	if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){       $SIS_where .= " AND prospectos_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}
	if(isset($_GET['Giro']) && $_GET['Giro']!=''){                 $SIS_where .= " AND prospectos_listado.Giro LIKE '%".EstandarizarInput($_GET['Giro'])."%'";}
	if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){       $SIS_where .= " AND prospectos_listado.idUsuario=".$_GET['idUsuario'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idProspecto', 'prospectos_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	prospectos_listado.idProspecto,
	prospectos_listado.Rut,
	prospectos_listado.Nombre,
	core_estados.Nombre AS estado,
	core_sistemas.Nombre AS sistema,
	usuarios_listado.Nombre AS Vendedor,
	prospectos_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_estados`      ON core_estados.idEstado          = prospectos_listado.idEstado
	LEFT JOIN `core_sistemas`     ON core_sistemas.idSistema        = prospectos_listado.idSistema
	LEFT JOIN `usuarios_listado`  ON usuarios_listado.idUsuario     = prospectos_listado.idUsuario';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrUsers = array();
	$arrUsers = db_select_array (false, $SIS_query, 'prospectos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

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
					if(isset($idTipo)){           $x1  = $idTipo;            }else{$x1  = '';}
					if(isset($Nombre)){           $x2  = $Nombre;            }else{$x2  = '';}
					if(isset($Rut)){              $x3  = $Rut;               }else{$x3  = '';}
					if(isset($fNacimiento)){      $x4  = $fNacimiento;       }else{$x4  = '';}
					if(isset($idCiudad)){         $x5  = $idCiudad;          }else{$x5  = '';}
					if(isset($idComuna)){         $x6  = $idComuna;          }else{$x6  = '';}
					if(isset($Direccion)){        $x7  = $Direccion;         }else{$x7  = '';}
					if(isset($Giro)){             $x9  = $Giro;              }else{$x9  = '';}
					if(isset($idUsuario)){        $x10 = $idUsuario;         }else{$x10 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Tipo de Prospecto','idTipo', $x1, 1, 'idTipo', 'Nombre', 'prospectos_tipos', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nombres', 'Nombre', $x2, 1);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x3, 1);
					$Form_Inputs->form_date('F Ingreso Sistema','fNacimiento', $x4, 1);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x5, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x6, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x7, 1,'fa fa-map');
					$Form_Inputs->form_input_icon('Giro de la empresa', 'Giro', $x9, 1,'fa fa-industry');
					$Form_Inputs->form_select_join_filter('Vendedor','idUsuario', $x10, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Prospectos</h5>
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
								<div class="pull-left">Rut</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=rut_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=rut_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Nombre del Prospecto</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Vendedor</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=vendedor_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=vendedor_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrUsers as $usuarios){ ?>
						<tr class="odd">
							<td><?php echo $usuarios['Rut']; ?></td>
							<td><?php echo $usuarios['Nombre']; ?></td>
							<td><?php echo $usuarios['Vendedor']; ?></td>
							<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_prospecto.php?view='.simpleEncode($usuarios['idProspecto'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idProspecto']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
