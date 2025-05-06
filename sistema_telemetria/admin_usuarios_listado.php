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
$original = "admin_usuarios_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['usuario']) && $_GET['usuario']!=''){               $location .= "&usuario=".$_GET['usuario'];              $search .= "&usuario=".$_GET['usuario'];}
if(isset($_GET['idTipoUsuario']) && $_GET['idTipoUsuario']!=''){   $location .= "&idTipoUsuario=".$_GET['idTipoUsuario'];  $search .= "&idTipoUsuario=".$_GET['idTipoUsuario'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                 $location .= "&Nombre=".$_GET['Nombre'];                $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['Fono']) && $_GET['Fono']!=''){                     $location .= "&Fono=".$_GET['Fono'];                    $search .= "&Fono=".$_GET['Fono'];}
if(isset($_GET['email']) && $_GET['email']!=''){                   $location .= "&email=".$_GET['email'];                  $search .= "&email=".$_GET['email'];}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){                       $location .= "&Rut=".$_GET['Rut'];                      $search .= "&Rut=".$_GET['Rut'];}
if(isset($_GET['fNacimiento']) && $_GET['fNacimiento']!=''){       $location .= "&fNacimiento=".$_GET['fNacimiento'];      $search .= "&fNacimiento=".$_GET['fNacimiento'];}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){           $location .= "&idSistema=".$_GET['idSistema'];          $search .= "&idSistema=".$_GET['idSistema'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Usuario Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Usuario Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Usuario Borrado correctamente';}
if (isset($_GET['clone'])){   $error['clone']   = 'sucess/Usuario clonado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);

// consulto los datos
$SIS_query = '
usuarios_listado.usuario,
usuarios_tipos.Nombre AS tipo,
usuarios_listado.email,
usuarios_listado.Nombre,
usuarios_listado.Rut,
usuarios_listado.fNacimiento,
usuarios_listado.Direccion,
usuarios_listado.Fono,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
usuarios_listado.Ultimo_acceso,
usuarios_listado.Direccion_img,
core_estados.Nombre AS estado';
$SIS_join  = '
LEFT JOIN `core_estados`             ON core_estados.idEstado             = usuarios_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`    ON core_ubicacion_ciudad.idCiudad    = usuarios_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   ON core_ubicacion_comunas.idComuna   = usuarios_listado.idComuna
LEFT JOIN `usuarios_tipos`           ON usuarios_tipos.idTipoUsuario      = usuarios_listado.idTipoUsuario';
$SIS_where = 'idUsuario ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/**********************************/
//Permisos a sistemas
$SIS_query = 'core_sistemas.Nombre AS Sistema	';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = usuarios_sistemas.idSistema';
$SIS_where = 'usuarios_sistemas.idUsuario ='.$_GET['id'];
$SIS_order = 'core_sistemas.Nombre ASC';
$arrSistemas = array();
$arrSistemas = db_select_array (false, $SIS_query, 'usuarios_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSistemas');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Usuario', $rowData['Nombre'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'admin_usuarios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'admin_usuarios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'admin_usuarios_listado_permisos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Permisos</a></li>
				<li class=""><a href="<?php echo 'admin_usuarios_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class=""><a href="<?php echo 'admin_usuarios_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Perfil</h2>
						<p class="text-muted">
							<strong>Usuario : </strong><?php echo $rowData['usuario']; ?><br/>
							<strong>Tipo de usuario : </strong><?php echo $rowData['tipo']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['estado']; ?><br/>
							<strong>Ultimo Acceso : </strong><?php echo $rowData['Ultimo_acceso']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Personales</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Fono : </strong><?php echo formatPhone($rowData['Fono']); ?><br/>
							<strong>Email : </strong><?php echo $rowData['email']; ?><br/>
							<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
							<strong>Fecha de Nacimiento : </strong><?php echo Fecha_completa($rowData['fNacimiento']); ?><br/>
							<strong>Ciudad : </strong><?php echo $rowData['Ciudad']; ?><br/>
							<strong>Comuna : </strong><?php echo $rowData['Comuna']; ?><br/>
							<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Sistemas Asignados</h2>
						<p class="text-muted">
							<?php foreach($arrSistemas as $sis) { ?>
								<strong><?php echo ' - '.$sis['Sistema']; ?></strong><br/>
							<?php } ?>
						</p>
					</div>

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
		case 'usuario_asc':    $order_by = 'usuarios_listado.usuario ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente'; break;
		case 'usuario_desc':   $order_by = 'usuarios_listado.usuario DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
		case 'nombre_asc':     $order_by = 'usuarios_listado.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
		case 'nombre_desc':    $order_by = 'usuarios_listado.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'tipo_asc':       $order_by = 'usuarios_tipos.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
		case 'tipo_desc':      $order_by = 'usuarios_tipos.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'estado_asc':     $order_by = 'core_estados.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':    $order_by = 'core_estados.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

		default: $order_by = 'usuarios_listado.idEstado ASC, usuarios_tipos.Nombre ASC, usuarios_listado.usuario ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo, Usuario Ascendente';
	}
}else{
	$order_by = 'usuarios_listado.idEstado ASC, usuarios_tipos.Nombre ASC, usuarios_listado.usuario ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo, Usuario Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "usuarios_listado.idTipoUsuario!=1";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['usuario']) && $_GET['usuario']!=''){              $SIS_where .= " AND usuarios_listado.usuario LIKE '%".EstandarizarInput($_GET['usuario'])."%'";}
if(isset($_GET['idTipoUsuario']) && $_GET['idTipoUsuario']!=''){  $SIS_where .= " AND usuarios_listado.idTipoUsuario=".$_GET['idTipoUsuario'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                $SIS_where .= " AND usuarios_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['Fono']) && $_GET['Fono']!=''){                    $SIS_where .= " AND usuarios_listado.Fono LIKE '%".EstandarizarInput($_GET['Fono'])."%'";}
if(isset($_GET['email']) && $_GET['email']!=''){                  $SIS_where .= " AND usuarios_listado.email LIKE '%".EstandarizarInput($_GET['email'])."%'";}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){                      $SIS_where .= " AND usuarios_listado.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
if(isset($_GET['fNacimiento']) && $_GET['fNacimiento']!=''){      $SIS_where .= " AND usuarios_listado.fNacimiento='".$_GET['fNacimiento']."'";}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'usuarios_listado.idUsuario', 'usuarios_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
usuarios_listado.idUsuario,
usuarios_listado.usuario,
usuarios_tipos.Nombre AS tipo,
usuarios_listado.Nombre,
core_estados.Nombre AS estado,
usuarios_listado.idEstado';
$SIS_join  = '
LEFT JOIN `core_estados`    ON core_estados.idEstado        = usuarios_listado.idEstado
LEFT JOIN `usuarios_tipos`  ON usuarios_tipos.idTipoUsuario = usuarios_listado.idTipoUsuario';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrUsers = array();
$arrUsers = db_select_array (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

// Se trae un listado con todos los elementos
$SIS_query = '
usuarios_sistemas.idUsuario,
usuarios_sistemas.idSistema,
core_sistemas.Nombre AS Sistema';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = usuarios_sistemas.idSistema';
$SIS_where = 'usuarios_sistemas.idUsuario!=0';
$SIS_order = 'core_sistemas.Nombre ASC';
$arrSistemas = array();
$arrSistemas = db_select_array (false, $SIS_query, 'usuarios_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSistemas');

$arrSystem = array();
foreach ($arrSistemas as $sis) {
	$arrSystem[$sis['idUsuario']][$sis['idSistema']]['Sistema']   = $sis['Sistema'];
	$arrSystem[$sis['idUsuario']][$sis['idSistema']]['idSistema'] = $sis['idSistema'];
}

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
				if(isset($usuario)){        $x1  = $usuario;        }else{$x1  = '';}
				if(isset($idTipoUsuario)){  $x3  = $idTipoUsuario;  }else{$x3  = '';}
				if(isset($Nombre)){         $x4  = $Nombre;         }else{$x4  = '';}
				if(isset($Fono)){           $x5  = $Fono;           }else{$x5  = '';}
				if(isset($email)){          $x6  = $email;          }else{$x6  = '';}
				if(isset($Rut)){            $x7  = $Rut;            }else{$x7  = '';}
				if(isset($fNacimiento)){    $x8  = $fNacimiento;    }else{$x8  = '';}
				if(isset($idSistema)){      $x9  = $idSistema;      }else{$x9  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
				$Form_Inputs->form_input_icon('Nombre de Usuario', 'usuario', $x1, 1,'fa fa-user');
				$Form_Inputs->form_select('Tipo de usuario','idTipoUsuario', $x3, 1, 'idTipoUsuario', 'Nombre', 'usuarios_tipos', 'idTipoUsuario!=1', '', $dbConn);
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x4, 1);
				$Form_Inputs->form_input_phone('Fono', 'Fono', $x5, 1);
				$Form_Inputs->form_input_icon('Email', 'email', $x6, 1,'fa fa-envelope-o');
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x7, 1);
				$Form_Inputs->form_date('F Nacimiento','fNacimiento', $x8, 1);
				$Form_Inputs->form_select('Sistema','idSistema', $x9, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Usuarios</h5>
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
							<div class="pull-left">Nombre del usuario</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo Usuario</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="160">Sistema</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrUsers as $usuarios) {
						//Variable
						$s_paso = 0;
						//si el filtro de sistema esta activo
						if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){
							if(isset($arrSystem[$usuarios['idUsuario']])){
								foreach ($arrSystem[$usuarios['idUsuario']] as $sis) {
									if($_GET['idSistema']==$sis['idSistema']){
										$s_paso++;
									}
								}
							}
						}else{
							$s_paso = 1;
						}
						//Si esta permitido mostrarlo
						if(isset($s_paso)&&$s_paso>0){ ?>
							<tr class="odd">
								<td><?php echo $usuarios['usuario']; ?></td>
								<td><?php echo $usuarios['Nombre']; ?></td>
								<td><?php echo $usuarios['tipo']; ?></td>
								<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['estado']; ?></label></td>	
								<td>
									<?php
									if(isset($arrSystem[$usuarios['idUsuario']])){
										foreach ($arrSystem[$usuarios['idUsuario']] as $sis) {
											echo $sis['Sistema'].'<br/>';
										}
									}
									?>
								</td>

								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_usuario.php?view='.simpleEncode($usuarios['idUsuario'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idUsuario']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									</div>
								</td>
							</tr>
						<?php } ?>
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
