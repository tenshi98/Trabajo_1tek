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
$original = "seguridad_camaras_listado.php";
$location = $original;
$new_location = "seguridad_camaras_listado_configuracion.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_zona'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'camara_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_camaras_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_camara'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'camara_update';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_camaras_listado.php';
}
//se borra un dato
if (!empty($_GET['del_camara'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'camara_del';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_camaras_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Camara Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Camara Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Camara Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit_camara'])){
// consulto los datos
$query = "SELECT idSubconfiguracion
FROM `seguridad_camaras_listado`
WHERE idCamara = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowConfig = mysqli_fetch_assoc ($resultado);	 
// consulto los datos
$query = "SELECT Nombre,idTipoCamara,Config_usuario,Config_Password,Config_IP,
Config_Puerto,Config_Web,idEstado, Chanel
FROM `seguridad_camaras_listado_canales`
WHERE idCanal = ".$_GET['edit_camara'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Camara</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				
				//Se verifican si existen los datos
				if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = $rowData['Nombre'];}
				if(isset($idTipoCamara)){     $x2  = $idTipoCamara;     }else{$x2  = $rowData['idTipoCamara'];}
				if(isset($Config_usuario)){   $x3  = $Config_usuario;   }else{$x3  = $rowData['Config_usuario'];}
				if(isset($Config_Password)){  $x4  = $Config_Password;  }else{$x4  = $rowData['Config_Password'];}
				if(isset($Config_IP)){        $x5  = $Config_IP;        }else{$x5  = $rowData['Config_IP'];}
				if(isset($Config_Puerto)){    $x6  = $Config_Puerto;    }else{$x6  = $rowData['Config_Puerto'];}
				if(isset($Config_Web)){       $x7  = $Config_Web;       }else{$x7  = $rowData['Config_Web'];}
				if(isset($Chanel)){           $x8  = $Chanel;           }else{$x8  = $rowData['Chanel'];}
				if(isset($idEstado)){         $x9  = $idEstado;         }else{$x9  = $rowData['idEstado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre dela Camara', 'Nombre', $x1, 2);	
				//se verifica que permita subconfiguracion
				if(isset($rowConfig['idSubconfiguracion'])&&$rowConfig['idSubconfiguracion']==1){
					$Form_Inputs->form_select('Tipo de Camara','idTipoCamara', $x2, 1, 'idTipoCamara', 'Nombre', 'core_tipos_camara', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Usuario', 'Config_usuario', $x3, 1);
					$Form_Inputs->form_input_text('Password', 'Config_Password', $x4, 1);
					$Form_Inputs->form_input_text('Web o IP', 'Config_IP', $x5, 1);
					$Form_Inputs->form_input_number_spinner('N° Puerto','Config_Puerto', $x6, 0, 10000, 1, 0, 1);
					$Form_Inputs->form_input_text('Web configuracion', 'Config_Web', $x7, 1);
				}
				$Form_Inputs->form_post_data(2,1,1, 'Este numero de canal debe de coincidir con el que figura en el DVR O NVR.');
				$Form_Inputs->form_input_number_spinner('N° de Canal','Chanel', $x8, 0, 99, 1, 0, 2);
				$Form_Inputs->form_select('Estado','idEstado', $x9, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idCamara', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idCanal', $_GET['edit_camara'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_camara">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
// consulto los datos
$query = "SELECT idSubconfiguracion
FROM `seguridad_camaras_listado`
WHERE idCamara = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowConfig = mysqli_fetch_assoc ($resultado);	 
	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Camara</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = '';}
				if(isset($idTipoCamara)){     $x2  = $idTipoCamara;     }else{$x2  = '';}
				if(isset($Config_usuario)){   $x3  = $Config_usuario;   }else{$x3  = '';}
				if(isset($Config_Password)){  $x4  = $Config_Password;  }else{$x4  = '';}
				if(isset($Config_IP)){        $x5  = $Config_IP;        }else{$x5  = '';}
				if(isset($Config_Puerto)){    $x6  = $Config_Puerto;    }else{$x6  = '';}
				if(isset($Config_Web)){       $x7  = $Config_Web;       }else{$x7  = '';}
				if(isset($Chanel)){           $x8  = $Chanel;           }else{$x8  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre de la Camara', 'Nombre', $x1, 2);	
				//se verifica que permita subconfiguracion
				if(isset($rowConfig['idSubconfiguracion'])&&$rowConfig['idSubconfiguracion']==1){
					$Form_Inputs->form_select('Tipo de Camara','idTipoCamara', $x2, 1, 'idTipoCamara', 'Nombre', 'core_tipos_camara', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Usuario', 'Config_usuario', $x3, 1);
					$Form_Inputs->form_input_text('Password', 'Config_Password', $x4, 1);
					$Form_Inputs->form_input_text('Web o IP', 'Config_IP', $x5, 1);
					$Form_Inputs->form_input_number_spinner('N° Puerto','Config_Puerto', $x6, 0, 10000, 1, 0, 1);
					$Form_Inputs->form_input_text('Web configuracion', 'Config_Web', $x7, 1);
				}
				$Form_Inputs->form_post_data(2,1,1, 'Este numero de canal debe de coincidir con el que figura en el DVR O NVR.');
				$Form_Inputs->form_input_number_spinner('N° de Canal','Chanel', $x8, 0, 99, 1, 0, 2);

				$Form_Inputs->form_input_hidden('idCamara', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_zona">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{	 
// consulto los datos
$query = "SELECT Nombre,N_Camaras, idSubconfiguracion
FROM `seguridad_camaras_listado`
WHERE idCamara = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

//Se traen las rutas
$arrCamaras = array();
$query = "SELECT 
seguridad_camaras_listado_canales.idCanal,
seguridad_camaras_listado_canales.idCamara,
seguridad_camaras_listado_canales.Nombre,
seguridad_camaras_listado_canales.Chanel,
seguridad_camaras_listado_canales.Config_usuario,
seguridad_camaras_listado_canales.Config_Password,
seguridad_camaras_listado_canales.Config_IP,
core_estados.Nombre AS estado,
seguridad_camaras_listado_canales.idEstado

FROM `seguridad_camaras_listado_canales`
LEFT JOIN `core_estados`   ON core_estados.idEstado = seguridad_camaras_listado_canales.idEstado
WHERE seguridad_camaras_listado_canales.idCamara = ".$_GET['id']."
ORDER BY seguridad_camaras_listado_canales.idCanal ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCamaras,$row );
}

//Se cuenta el total de camaras
$total_cam = 0;
foreach ($arrCamaras as $zona) {
	$total_cam++;
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Grupo Camaras', $rowData['Nombre'], 'Editar Camaras'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?php if ($rowlevel['level']>=3&&$rowData['N_Camaras']>$total_cam){ ?><a href="<?php echo $new_location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Camara</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'seguridad_camaras_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'seguridad_camaras_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'seguridad_camaras_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class="active"><a href="<?php echo 'seguridad_camaras_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Editar Camaras</a></li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<?php if(isset($rowData['idSubconfiguracion'])&&$rowData['idSubconfiguracion']==1){ ?>
							<th>Usuario</th>
							<th>Password</th>
							<th>IP</th>
						<?php } ?>
						<th width="160">N° de Canal</th>
						<th width="160">Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCamaras as $zona) { ?>
						<tr class="odd">
							<td><?php echo $zona['Nombre']; ?></td>
							<?php if(isset($rowData['idSubconfiguracion'])&&$rowData['idSubconfiguracion']==1){ ?>
								<td><?php echo $zona['Config_usuario']; ?></td>
								<td><?php echo $zona['Config_Password']; ?></td>
								<td><?php echo $zona['Config_IP']; ?></td>
							<?php } ?>
							<td><?php echo $zona['Chanel']; ?></td>
							<td><label class="label <?php if(isset($zona['idEstado'])&&$zona['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $zona['estado']; ?></label></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&edit_camara='.$zona['idCanal']; ?>" title="Editar Información Basica" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										//se verifica que el usuario no sea uno mismo
										$ubicacion = $new_location.'&idCamara='.$zona['idCamara'].'&del_camara='.simpleEncode($zona['idCanal'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la camara '.$zona['Nombre'].'?'; ?>
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
