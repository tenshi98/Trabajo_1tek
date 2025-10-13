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
$original = "postulantes_listado.php";
$location = $original;
$new_location = "postulantes_listado_estudios.php";
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
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/postulantes_listado_estudios.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/postulantes_listado_estudios.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/postulantes_listado_estudios.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Estudio Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Estudio Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Estudio Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
// consulto los datos
$query = "SELECT Nombre,ApellidoPat, ApellidoMat
FROM `postulantes_listado`
WHERE idPostulante = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

// consulto los datos
$query = "SELECT AnoInicio,AnoTermino,idEstado,idEstudioCat,idEstudio,Nombre,Descripcion
FROM `postulantes_listado_estudios`
WHERE idEstudioPost = ".$_GET['edit'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowDatax = mysqli_fetch_assoc ($resultado);

 ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Estudio</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($AnoInicio)){        $x1  = $AnoInicio;         }else{$x1  = $rowDatax['AnoInicio'];}
				if(isset($AnoTermino)){       $x2  = $AnoTermino;        }else{$x2  = $rowDatax['AnoTermino'];}
				if(isset($idEstado)){         $x3  = $idEstado;          }else{$x3  = $rowDatax['idEstado'];}
				if(isset($idEstudioCat)){     $x4  = $idEstudioCat;      }else{$x4  = $rowDatax['idEstudioCat'];}
				if(isset($idEstudio)){        $x5  = $idEstudio;         }else{$x5  = $rowDatax['idEstudio'];}
				if(isset($Nombre)){           $x6  = $Nombre;            }else{$x6  = $rowDatax['Nombre'];}
				if(isset($Descripcion)){      $x7  = $Descripcion;       }else{$x7  = $rowDatax['Descripcion'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('Año Inicio','AnoInicio', $x1, 2, 1970, ano_actual());
				$Form_Inputs->form_select_n_auto('Año Termino','AnoTermino', $x2, 1, 1970, ano_actual());
				$Form_Inputs->form_select('idEstado','idEstado', $x3, 2, 'idEstado', 'Nombre', 'core_estado_estudio', 0, '', $dbConn);
				$Form_Inputs->form_select_depend1('Categoria', 'idEstudioCat',  $x4,  2,  'idEstudioCat', 'Nombre',  'sistema_estudios_categoria',  0,   0,
										 'Curso', 'idEstudio',  $x5,  2,  'idEstudio',  'Nombre',  'sistema_estudios_listado',  0,   0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_text('Casa de Estudio', 'Nombre', $x6, 2);
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x7, 1);

				$Form_Inputs->form_input_hidden('idEstudioPost', $_GET['edit'], 2);
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
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Estudio</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($AnoInicio)){        $x1  = $AnoInicio;         }else{$x1  = '';}
				if(isset($AnoTermino)){       $x2  = $AnoTermino;        }else{$x2  = '';}
				if(isset($idEstado)){         $x3  = $idEstado;          }else{$x3  = '';}
				if(isset($idEstudioCat)){     $x4  = $idEstudioCat;      }else{$x4  = '';}
				if(isset($idEstudio)){        $x5  = $idEstudio;         }else{$x5  = '';}
				if(isset($Nombre)){           $x6  = $Nombre;            }else{$x6  = '';}
				if(isset($Descripcion)){      $x7  = $Descripcion;       }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('AnoInicio','AnoInicio', $x1, 2, 1970, ano_actual());
				$Form_Inputs->form_select_n_auto('AnoTermino','AnoTermino', $x2, 1, 1970, ano_actual());
				$Form_Inputs->form_select('idEstado','idEstado', $x3, 2, 'idEstado', 'Nombre', 'core_estado_estudio', 0, '', $dbConn);
				$Form_Inputs->form_select_depend1('Categoria', 'idEstudioCat',  $x4,  2,  'idEstudioCat', 'Nombre',  'sistema_estudios_categoria',  0,   0,
										 'Curso', 'idEstudio',  $x5,  2,  'idEstudio',  'Nombre',  'sistema_estudios_listado',  0,   0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_text('Casa de Estudio', 'Nombre', $x6, 2);
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x7, 1);	
				
				$Form_Inputs->form_input_hidden('idPostulante', $_GET['id'], 2);
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
// consulto los datos
$query = "SELECT Nombre,ApellidoPat, ApellidoMat
FROM `postulantes_listado`
WHERE idPostulante = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

// consulto los datos
$arrEstudios = array();
$query = "SELECT 
postulantes_listado_estudios.idEstudioPost,
postulantes_listado_estudios.AnoInicio,
postulantes_listado_estudios.AnoTermino,
postulantes_listado_estudios.Nombre,
core_estado_estudio.Nombre AS CursoEstado,
sistema_estudios_categoria.Nombre AS CursoCategoria,
sistema_estudios_listado.Nombre AS CursoListado

FROM `postulantes_listado_estudios`
LEFT JOIN `sistema_estudios_categoria`   ON sistema_estudios_categoria.idEstudioCat   = postulantes_listado_estudios.idEstudioCat
LEFT JOIN `sistema_estudios_listado`     ON sistema_estudios_listado.idEstudio        = postulantes_listado_estudios.idEstudio
LEFT JOIN `core_estado_estudio`         ON core_estado_estudio.idEstado             = postulantes_listado_estudios.idEstado

WHERE idPostulante = ".$_GET['id']."
ORDER BY idEstudioPost ASC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrEstudios,$row );
}



?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Postulante', $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat'], 'Estudios'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Estudio</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'postulantes_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'postulantes_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class="active"><a href="<?php echo 'postulantes_listado_estudios.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i>  Estudios</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'postulantes_listado_cursos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i>  Cursos</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_experiencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-industry" aria-hidden="true"></i>  Experiencia</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_curriculum.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i>  Curriculum</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_otros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-archive" aria-hidden="true"></i>  Otros</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_estado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-text-o" aria-hidden="true"></i>  Estado Contrato</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Fechas</th>
						<th>Estado</th>
						<th>Curso</th>
						<th>Casa de Estudios</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrEstudios as $estudios) { ?>
					<tr class="odd">
						<td><?php echo $estudios['AnoInicio'].' - '.$estudios['AnoTermino']; ?></td>
						<td><?php echo $estudios['CursoEstado']; ?></td>
						<td><?php echo $estudios['CursoCategoria'].' - '.$estudios['CursoListado']; ?></td>
						<td><?php echo $estudios['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$estudios['idEstudioPost']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($estudios['idEstudioPost'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el estudio '.$estudios['CursoCategoria'].' - '.$estudios['CursoListado'].'?'; ?>
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
