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
//Verifico si es superusuario
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Type.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_usr_admin.php";
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
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
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
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'usuario, email, Nombre,Rut, fNacimiento, Direccion, Fono, idCiudad, idComuna';
	$SIS_join  = '';
	$SIS_where = 'idUsuario = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación datos del Usuario <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){          $x1  = $Nombre;        }else{$x1  = $rowData['Nombre'];}
					if(isset($Fono)){            $x2  = $Fono;          }else{$x2  = $rowData['Fono'];}
					if(isset($email)){           $x3  = $email;         }else{$x3  = $rowData['email'];}
					if(isset($Rut)){             $x4  = $Rut;           }else{$x4  = $rowData['Rut'];}
					if(isset($fNacimiento)){     $x5  = $fNacimiento;   }else{$x5  = $rowData['fNacimiento'];}
					if(isset($idCiudad)){        $x6  = $idCiudad;      }else{$x6  = $rowData['idCiudad'];}
					if(isset($idComuna)){        $x7  = $idComuna;      }else{$x7  = $rowData['idComuna'];}
					if(isset($Direccion)){       $x8  = $Direccion;     }else{$x8  = $rowData['Direccion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_phone('Fono', 'Fono', $x2, 1);
					$Form_Inputs->form_input_icon('Email', 'email', $x3, 1,'fa fa-envelope-o');
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x4, 1);
					$Form_Inputs->form_date('Fecha de Nacimiento','fNacimiento', $x5, 1);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x6, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x7, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x8, 1,'fa fa-map');

					$Form_Inputs->form_input_hidden('idUsuario', $_GET['id'], 2);
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
}elseif(!empty($_GET['new'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Usuario</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($usuario)){         $x1  = $usuario;       }else{$x1  = '';}
					if(isset($password)){        $x2  = $password;      }else{$x2  = '';}
					if(isset($repassword)){      $x3  = $repassword;    }else{$x3  = '';}
					if(isset($Nombre)){          $x4  = $Nombre;        }else{$x4  = '';}
					if(isset($Fono)){            $x5  = $Fono;          }else{$x5  = '';}
					if(isset($email)){           $x6  = $email;         }else{$x6  = '';}
					if(isset($Rut)){             $x7  = $Rut;           }else{$x7  = '';}
					if(isset($fNacimiento)){     $x8  = $fNacimiento;   }else{$x8  = '';}
					if(isset($idCiudad)){        $x9  = $idCiudad;      }else{$x9  = '';}
					if(isset($idComuna)){        $x10 = $idComuna;      }else{$x10 = '';}
					if(isset($Direccion)){       $x11 = $Direccion;     }else{$x11 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_icon('Usuario', 'usuario', $x1, 2,'fa fa-user');
					$Form_Inputs->form_input_password('Password', 'password', $x2, 2);
					$Form_Inputs->form_input_password('Repetir Password', 'repassword', $x3, 2);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x4, 2);
					$Form_Inputs->form_input_phone('Fono', 'Fono', $x5, 1);
					$Form_Inputs->form_input_icon('Email', 'email', $x6, 1,'fa fa-envelope-o');
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x7, 1);
					$Form_Inputs->form_date('Fecha de Nacimiento','fNacimiento', $x8, 1);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x9, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x10, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x8, 1,'fa fa-map');

					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idTipoUsuario', 1, 2);
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
}elseif(!empty($_GET['view'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	usuarios_listado.usuario,
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
	LEFT JOIN `core_ubicacion_comunas`   ON core_ubicacion_comunas.idComuna   = usuarios_listado.idComuna';
	$SIS_where = 'usuarios_listado.idUsuario = '.$_GET['view'];
	$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Fecha, Hora';
	$SIS_join  = '';
	$SIS_where = 'idUsuario = '.$_GET['view'];
	$SIS_order = 'idAcceso DESC';
	$SIS_order.= ' LIMIT 13';
	$arrAccess = array();
	$arrAccess = db_select_array (false, $SIS_query, 'usuarios_accesos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAccess');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Datos</h5>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="#ingresos" data-toggle="tab"><i class="fa fa-sign-in" aria-hidden="true"></i> Ingresos</a></li>
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
							<h2 class="text-primary">Datos del Perfil</h2>
							<p class="text-muted">
								<strong>Usuario : </strong><?php echo $rowData['usuario']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['estado']; ?><br/>
								<strong>Ultimo Acceso : </strong><?php echo $rowData['Ultimo_acceso']; ?>
							</p>

							<h2 class="text-primary">Datos Personales</h2>
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
						</div>
						<div class="clearfix"></div>

					</div>
				</div>

				<div class="tab-pane fade" id="ingresos">
					<div class="wmd-panel">

						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th width="209">Fecha</th>
									<th width="472">Hora</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrAccess as $accesos) { ?>
									<tr class="odd">
										<td><?php echo $accesos['Fecha']; ?></td>
										<td><?php echo $accesos['Hora']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
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
	//Filtro solo a los super usuarios
	$SIS_where = "usuarios_listado.idTipoUsuario=1";

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idUsuario', 'usuarios_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	usuarios_listado.idUsuario,
	usuarios_listado.usuario,
	usuarios_listado.Nombre,
	usuarios_listado.Ultimo_acceso,
	core_estados.Nombre AS estado,
	usuarios_listado.idEstado';
	$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = usuarios_listado.idEstado';
	$SIS_order = 'usuarios_listado.usuario ASC LIMIT '.$comienzo.', '.$cant_reg;
	$arrUsers = array();
	$arrUsers = db_select_array (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

	//paginacion
	$search='';

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Usuario</a>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Usuarios</h5>
				<div class="toolbar">
					<?php
					//paginacion
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Usuario</th>
							<th>Nombre del usuario</th>
							<th>Ultimo acceso</th>
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrUsers as $usuarios){ ?>
						<tr class="odd">
							<td><?php echo $usuarios['usuario']; ?></td>
							<td><?php echo $usuarios['Nombre']; ?></td>
							<td><?php echo $usuarios['Ultimo_acceso']; ?></td>
							<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['estado']; ?></label></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo $location.'&view='.$usuarios['idUsuario']; ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&id='.$usuarios['idUsuario']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del='.simpleEncode($usuarios['idUsuario'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el registro '.$usuarios['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pagrow">
				<?php
				//paginacion
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
