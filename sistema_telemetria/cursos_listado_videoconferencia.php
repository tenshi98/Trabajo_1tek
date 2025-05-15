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
$original = "cursos_listado.php";
$location = $original;
$new_location = "cursos_listado_videoconferencia.php";
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
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/cursos_listado_videoconferencia.php';
}
//formulario para crear
if (!empty($_POST['submit_edit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/cursos_listado_videoconferencia.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/cursos_listado_videoconferencia.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Videoconferencia agregada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Videoconferencia eliminada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUsuario, Nombre,HoraInicio, HoraTermino, idDia_1, idDia_2, idDia_3, idDia_4, idDia_5, idDia_6, idDia_7';
	$SIS_join  = '';
	$SIS_where = 'idVideoConferencia = '.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cursos_listado_videoconferencia', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar VideoConferencia</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){        $x1  = $Nombre;        }else{$x1  = $rowData['Nombre'];}
					if(isset($idUsuario)){     $x2  = $idUsuario;     }else{$x2  = $rowData['idUsuario'];}
					if(isset($HoraInicio)){    $x3  = $HoraInicio;    }else{$x3  = $rowData['HoraInicio'];}
					if(isset($HoraTermino)){   $x4  = $HoraTermino;   }else{$x4  = $rowData['HoraTermino'];}
					if(isset($idDia_1)){       $x5  = $idDia_1;       }else{$x5  = $rowData['idDia_1'];}
					if(isset($idDia_2)){       $x5 .= ','.$idDia_2;   }else{$x5 .= ','.$rowData['idDia_2'];}
					if(isset($idDia_3)){       $x5 .= ','.$idDia_3;   }else{$x5 .= ','.$rowData['idDia_3'];}
					if(isset($idDia_4)){       $x5 .= ','.$idDia_4;   }else{$x5 .= ','.$rowData['idDia_4'];}
					if(isset($idDia_5)){       $x5 .= ','.$idDia_5;   }else{$x5 .= ','.$rowData['idDia_5'];}
					if(isset($idDia_6)){       $x5 .= ','.$idDia_6;   }else{$x5 .= ','.$rowData['idDia_6'];}
					if(isset($idDia_7)){       $x5 .= ','.$idDia_7;   }else{$x5 .= ','.$rowData['idDia_7'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_join_filter('Profesor','idUsuario', $x2, 2, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_time('Hora Inicio','HoraInicio', $x3, 2, 2);
					$Form_Inputs->form_time('Hora Termino','HoraTermino', $x4, 2, 1);
					$Form_Inputs->form_checkbox_active('Dias','idDia', $x5, 2, 2, 'idDia', 'Nombre', 'core_tiempo_dias', 0, $dbConn);

					$Form_Inputs->form_input_hidden('idCurso', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idVideoConferencia', $_GET['edit'], 2);

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

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	} ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar VideoConferencia</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){        $x1  = $Nombre;        }else{$x1  = '';}
					if(isset($idUsuario)){     $x2  = $idUsuario;     }else{$x2  = '';}
					if(isset($HoraInicio)){    $x3  = $HoraInicio;    }else{$x3  = '';}
					if(isset($HoraTermino)){   $x4  = $HoraTermino;   }else{$x4  = '';}
					if(isset($idDia_1)){       $x5  = $idDia_1;       }else{$x5  = '';}
					if(isset($idDia_2)){       $x5 .= ','.$idDia_2;   }else{$x5 .= ',';}
					if(isset($idDia_3)){       $x5 .= ','.$idDia_3;   }else{$x5 .= ',';}
					if(isset($idDia_4)){       $x5 .= ','.$idDia_4;   }else{$x5 .= ',';}
					if(isset($idDia_5)){       $x5 .= ','.$idDia_5;   }else{$x5 .= ',';}
					if(isset($idDia_6)){       $x5 .= ','.$idDia_6;   }else{$x5 .= ',';}
					if(isset($idDia_7)){       $x5 .= ','.$idDia_7;   }else{$x5 .= ',';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_join_filter('Profesor','idUsuario', $x2, 2, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_time('Hora Inicio','HoraInicio', $x3, 2, 2);
					$Form_Inputs->form_time('Hora Termino','HoraTermino', $x4, 2, 1);
					$Form_Inputs->form_checkbox_active('Dias','idDia', $x5, 2, 2, 'idDia', 'Nombre', 'core_tiempo_dias', 0, $dbConn);

					$Form_Inputs->form_input_hidden('idCurso', $_GET['id'], 2);

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
	$SIS_query = 'Nombre';
	$SIS_join  = '';
	$SIS_where = 'idCurso = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'cursos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cursos_listado_videoconferencia.idVideoConferencia,
	cursos_listado_videoconferencia.Nombre AS NombreVideo,
	cursos_listado_videoconferencia.HoraInicio,
	cursos_listado_videoconferencia.HoraTermino,
	cursos_listado_videoconferencia.idDia_1,
	cursos_listado_videoconferencia.idDia_2,
	cursos_listado_videoconferencia.idDia_3,
	cursos_listado_videoconferencia.idDia_4,
	cursos_listado_videoconferencia.idDia_5,
	cursos_listado_videoconferencia.idDia_6,
	cursos_listado_videoconferencia.idDia_7,
	usuarios_listado.Nombre AS Usuario';
	$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = cursos_listado_videoconferencia.idUsuario';
	$SIS_where = 'cursos_listado_videoconferencia.idCurso = '.$_GET['id'];
	$SIS_order = 'cursos_listado_videoconferencia.Nombre ASC';
	$arrVideo = array();
	$arrVideo = db_select_array (false, $SIS_query, 'cursos_listado_videoconferencia', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrVideo');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Curso', $rowData['Nombre'], 'Editar VideoConferencia Relacionadas'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Agregar VideoConferencia</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'cursos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'cursos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'cursos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'cursos_listado_asignaturas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Asignaturas Relacionadas</a></li>
							<li class=""><a href="<?php echo 'cursos_listado_documentacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Documentos Relacionados</a></li>
							<li class="active"><a href="<?php echo 'cursos_listado_videoconferencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >VideoConferencias Relacionadas</a></li>
						</ul>
					</li>
				</ul>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th colspan="3">Datos Básicos</th>
							<th colspan="7">Dias</th>
							<th width="10"></th>
						</tr>
						<tr role="row">
							<th>Nombre</th>
							<th>Profesor</th>
							<th>Horario</th>

							<th>Lunes</th>
							<th>Martes</th>
							<th>Miercoles</th>
							<th>Jueves</th>
							<th>Viernes</th>
							<th>Sabado</th>
							<th>Domingo</th>

							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">

						<?php foreach ($arrVideo as $video){ ?>
							<tr>
								<td><?php echo $video['NombreVideo']; ?></td>
								<td><?php echo $video['Usuario']; ?></td>
								<td><?php echo $video['HoraInicio'].' - '.$video['HoraTermino']; ?></td>

								<td><?php if(isset($video['idDia_1'])&&$video['idDia_1']==2){echo 'Si';} ?></td>
								<td><?php if(isset($video['idDia_2'])&&$video['idDia_2']==2){echo 'Si';} ?></td>
								<td><?php if(isset($video['idDia_3'])&&$video['idDia_3']==2){echo 'Si';} ?></td>
								<td><?php if(isset($video['idDia_4'])&&$video['idDia_4']==2){echo 'Si';} ?></td>
								<td><?php if(isset($video['idDia_5'])&&$video['idDia_5']==2){echo 'Si';} ?></td>
								<td><?php if(isset($video['idDia_6'])&&$video['idDia_6']==2){echo 'Si';} ?></td>
								<td><?php if(isset($video['idDia_7'])&&$video['idDia_7']==2){echo 'Si';} ?></td>

								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$video['idVideoConferencia']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($video['idVideoConferencia'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la videoconferencia '.$video['NombreVideo'].'?'; ?>
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
