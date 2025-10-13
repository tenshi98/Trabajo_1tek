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
$original = "variedades_categorias.php";
$location = $original;
$new_location = "variedades_categorias_matriz_proceso.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del Transporte sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'insert_matriz';
	require_once 'A1XRXS_sys/xrxs_form/sistema_variedades_categorias_matriz_proceso.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/sistema_variedades_categorias_matriz_proceso.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_matriz';
	require_once 'A1XRXS_sys/xrxs_form/sistema_variedades_categorias_matriz_proceso.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Matriz Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Matriz Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Matriz Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
//verifico que sea un administrador
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
// consulto los datos
$query = "SELECT idMatriz, idProceso, idSistema
FROM `sistema_variedades_categorias_matriz_proceso`
WHERE idVarMatriz = ".$_GET['edit'];
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
			<h5>Editar Matriz</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProceso)){  $x1  = $idProceso; }else{$x1  = $rowData['idProceso'];}
				if(isset($idMatriz)){   $x2  = $idMatriz;  }else{$x2  = $rowData['idMatriz'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend1('Proceso','idProceso', $x1, 2, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, 0,
										 'Matriz','idMatriz', $x2, 2, 'idMatriz', 'Nombre', 'cross_quality_proceso_matriz', $z, 0,
										 $dbConn, 'form1');

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idCategoria',$_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idVarMatriz',$_GET['edit'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
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
//verifico que sea un administrador
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Nueva Matriz</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProceso)){  $x1  = $idProceso; }else{$x1  = '';}
				if(isset($idMatriz)){   $x2  = $idMatriz;  }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend1('Proceso','idProceso', $x1, 2, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, 0,
										 'Matriz','idMatriz', $x2, 2, 'idMatriz', 'Nombre', 'cross_quality_proceso_matriz', $z, 0,
										 $dbConn, 'form1');

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idCategoria',$_GET['id'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
// Se traen todos los datos de mi Transporte
$query = "SELECT Nombre
FROM `sistema_variedades_categorias`
WHERE idCategoria = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

// Se trae un listado con todos los elementos
$arrProductos = array();
$query = "SELECT 
sistema_variedades_categorias_matriz_proceso.idVarMatriz,
cross_quality_proceso_matriz.Nombre AS Matriz,
core_cross_quality_analisis_calidad.Nombre AS Proceso,
core_sistemas.Nombre AS Sistema

FROM `sistema_variedades_categorias_matriz_proceso`
LEFT JOIN `cross_quality_proceso_matriz`         ON cross_quality_proceso_matriz.idMatriz         = sistema_variedades_categorias_matriz_proceso.idMatriz
LEFT JOIN `core_cross_quality_analisis_calidad`  ON core_cross_quality_analisis_calidad.idTipo    = sistema_variedades_categorias_matriz_proceso.idProceso
LEFT JOIN `core_sistemas`                        ON core_sistemas.idSistema                       = sistema_variedades_categorias_matriz_proceso.idSistema

WHERE sistema_variedades_categorias_matriz_proceso.idCategoria = ".$_GET['id']."
AND sistema_variedades_categorias_matriz_proceso.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrProductos,$row );
}


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Especie', $rowData['Nombre'], 'Editar Matrices'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Agregar nueva matriz</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'variedades_categorias.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'variedades_categorias_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'variedades_categorias_matriz_calidad.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Matriz Calidad</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class="active"><a href="<?php echo 'variedades_categorias_matriz_proceso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Matriz Proceso</a></li>
						<li class=""><a href="<?php echo 'variedades_categorias_tipo_embalaje.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Tipo Embalaje</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Matriz</th>
						<th width="200">Sistema</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
					<?php
					filtrar($arrProductos, 'Proceso');
					foreach($arrProductos as $Proceso=>$listproc){
						echo '<tr class="odd" ><td colspan="3"  style="background-color:#DDD"><strong>'.$Proceso.'</strong></td></tr>';
						foreach ($listproc as $subprocesos) { ?>
						<tr class="odd">
							<td><?php echo $subprocesos['Matriz']; ?></td>
							<td><?php echo $subprocesos['Sistema']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $new_location.'&edit='.$subprocesos['idVarMatriz']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
										$ubicacion = $new_location.'&del='.simpleEncode($subprocesos['idVarMatriz'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el dato '.$subprocesos['Matriz'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>	
								</div>
							</td>
						</tr>
					 <?php }
					} ?>

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
