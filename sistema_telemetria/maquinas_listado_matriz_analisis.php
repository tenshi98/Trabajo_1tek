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
$original = "maquinas_listado.php";
$location = $original;
$new_location = "maquinas_listado_matriz_analisis.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se clona la maquina
if (!empty($_POST['clone_Matriz'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'clone_Matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Matriz Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Matriz Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Matriz Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone_idMatriz'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Clonar Matriz <?php echo $_GET['nombre_matriz']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_hidden('idMatriz', $_GET['clone_idMatriz'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c5; Clonar" name="clone_Matriz">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['mod'])){
	//Armo cadena
	$SIS_query  = 'PuntoNombre_'.$_GET['mod'].' AS Nombre';
	$SIS_query .= ',PuntoMedAceptable_'.$_GET['mod'].' AS Aceptable';
	$SIS_query .= ',PuntoMedAlerta_'.$_GET['mod'].' AS Alerta';
	$SIS_query .= ',PuntoMedCondenatorio_'.$_GET['mod'].' AS Condenatorio';
	$SIS_query .= ',PuntoUniMed_'.$_GET['mod'].' AS UniMed';
	$SIS_query .= ',PuntoidTipo_'.$_GET['mod'].' AS Tipo';
	$SIS_query .= ',PuntoidGrupo_'.$_GET['mod'].' AS Grupo';

	// consulto los datos
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idMatriz'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Parametros</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'PuntoNombre', $rowData['Nombre'], 1);
					$Form_Inputs->form_select_depend1('Tipo', 'PuntoidTipo',  $rowData['Tipo'],  1, 'idTipo', 'Nombre', 'core_analisis_tipos', 0,  0,
											'Grupo', 'PuntoidGrupo',  $rowData['Grupo'],  1,  'idGrupo', 'Nombre', 'maquinas_listado_matriz_grupos', 0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_input_number('Aceptable','PuntoMedAceptable', Cantidades_decimales_justos($rowData['Aceptable']), 1);
					$Form_Inputs->form_input_number('Alerta','PuntoMedAlerta', Cantidades_decimales_justos($rowData['Alerta']), 1);
					$Form_Inputs->form_input_number('Condenatorio','PuntoMedCondenatorio', Cantidades_decimales_justos($rowData['Condenatorio']), 1);
					$Form_Inputs->form_select('Unidad de Medida','PuntoUniMed', $rowData['UniMed'], 1, 'idUml', 'Nombre', 'sistema_analisis_uml', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz'], 2);
					$Form_Inputs->form_input_hidden('mod', $_GET['mod'], 2);
					?>

					<script>
						document.getElementById('div_PuntoMedAceptable').style.display = 'none';
						document.getElementById('div_PuntoMedAlerta').style.display = 'none';
						document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
						document.getElementById('div_PuntoUniMed').style.display = 'none';

						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

							let Sensores_val= $("#PuntoidTipo").val();

							//si es medicion
							if(Sensores_val == 1){
								document.getElementById('div_PuntoMedAceptable').style.display = '';
								document.getElementById('div_PuntoMedAlerta').style.display = '';
								document.getElementById('div_PuntoMedCondenatorio').style.display = '';
								document.getElementById('div_PuntoUniMed').style.display = '';
							//para el resto
							} else {
								document.getElementById('div_PuntoMedAceptable').style.display = 'none';
								document.getElementById('div_PuntoMedAlerta').style.display = 'none';
								document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
								document.getElementById('div_PuntoUniMed').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="PuntoMedAceptable"]').value = '0';
								document.querySelector('input[name="PuntoMedAlerta"]').value = '0';
								document.querySelector('input[name="PuntoMedCondenatorio"]').value = '0';
								document.querySelector('input[name="PuntoUniMed"]').value = '0';

							}
						});

						$("#PuntoidTipo").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected1 = $(this).val(); //Asignamos el valor seleccionado

							//si es medicion
							if(modelSelected1 == 1){
								document.getElementById('div_PuntoMedAceptable').style.display = '';
								document.getElementById('div_PuntoMedAlerta').style.display = '';
								document.getElementById('div_PuntoMedCondenatorio').style.display = '';
								document.getElementById('div_PuntoUniMed').style.display = '';
							//para el resto
							} else {
								document.getElementById('div_PuntoMedAceptable').style.display = 'none';
								document.getElementById('div_PuntoMedAlerta').style.display = 'none';
								document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
								document.getElementById('div_PuntoUniMed').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="PuntoMedAceptable"]').value = '0';
								document.querySelector('input[name="PuntoMedAlerta"]').value = '0';
								document.querySelector('input[name="PuntoMedCondenatorio"]').value = '0';
								document.querySelector('input[name="PuntoUniMed"]').value = '0';
							}
						});

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz='.$_GET['idMatriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz'])){
	// consulto los datos
	$SIS_query = 'Nombre,cantPuntos';
	for ($i = 1; $i <= 50; $i++) {
		$SIS_query.= ',PuntoNombre_'.$i;
		$SIS_query.= ',PuntoMedAceptable_'.$i;
		$SIS_query.= ',PuntoMedAlerta_'.$i;
		$SIS_query.= ',PuntoMedCondenatorio_'.$i;
		$SIS_query.= ',PuntoUniMed_'.$i;
		$SIS_query.= ',PuntoidGrupo_'.$i;
		$SIS_query.= ',PuntoidTipo_'.$i;
	}
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idMatriz'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/************************************************/
	//consulto
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUml,Nombre', 'sistema_analisis_uml', '', 'idUml!=0', 'idUml ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');
	$arrTipos = array();
	$arrTipos = db_select_array (false, 'idTipo,Nombre', 'core_analisis_tipos', '', 'idTipo!=0', 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'maquinas_listado_matriz_grupos', '', 'idGrupo!=0', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	/************************************************/
	//Ordeno
	$arrFinalUnimed = array();
	$arrFinalTipos = array();
	$arrFinalGrupos = array();
	foreach ($arrUnimed as $data) {  $arrFinalUnimed[$data['idUml']]   = $data['Nombre'];}
	foreach ($arrTipos as $data) {   $arrFinalTipos[$data['idTipo']]   = $data['Nombre'];}
	foreach ($arrGrupos as $data) {  $arrFinalGrupos[$data['idGrupo']] = $data['Nombre'];}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Puntos de Analisis</h5>
			</header>

			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Tipo</th>
							<th>Nombre</th>
							<th>Grupo</th>
							<th>Aceptable</th>
							<th>Alerta</th>
							<th>Condenatorio</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
							//compruebo
							if(isset($arrFinalUnimed[$rowData['PuntoUniMed_'.$i]])){    $unimed = $arrFinalUnimed[$rowData['PuntoUniMed_'.$i]];     }else{ $unimed = '';}
							if(isset($arrFinalTipos[$rowData['PuntoidTipo_'.$i]])){     $tipo   = $arrFinalTipos[$rowData['PuntoidTipo_'.$i]];      }else{ $tipo   = '';}
							if(isset($arrFinalGrupos[$rowData['PuntoidGrupo_'.$i]])){   $grupo  = $arrFinalGrupos[$rowData['PuntoidGrupo_'.$i]];    }else{ $grupo  = '';}
							?>
							<tr class="odd">
								<td><?php echo 'p'.$i ?></td>
								<td><?php echo $tipo; ?></td>
								<td><?php echo $rowData['PuntoNombre_'.$i]; ?></td>
								<td><?php echo $grupo; ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAceptable_'.$i]).' '.$unimed;    }else{echo 'No Aplica';} ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAlerta_'.$i]).' '.$unimed;       }else{echo 'No Aplica';} ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedCondenatorio_'.$i]).' '.$unimed; }else{echo 'No Aplica';} ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz='.$_GET['idMatriz'].'&mod='.$i; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz_2'])){
	// consulto los datos
	$SIS_query = 'Nombre,cantPuntos, idEstado';
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idMatriz_2'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación Matriz de Analisis</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;       }else{$x1  = $rowData['Nombre'];}
					if(isset($cantPuntos)){  $x2  = $cantPuntos;   }else{$x2  = $rowData['cantPuntos'];}
					if(isset($idEstado)){    $x3  = $idEstado;     }else{$x3  = $rowData['idEstado'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 2, 1, 50);
					$Form_Inputs->form_select('Estado','idEstado', $x3, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz_2'], 2);
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
	validaPermisoUser($rowlevel['level'], 3, $dbConn);

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Matriz de Analisis</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;       }else{$x1  = '';}
					if(isset($cantPuntos)){  $x2  = $cantPuntos;   }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 2, 1, 50);

					$Form_Inputs->form_input_hidden('idMaquina', simpleDecode($_GET['id'], fecha_actual()), 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit">
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
	$SIS_query = 'Nombre,idConfig_1, idConfig_2, idConfig_3, idConfig_4';
	$SIS_join  = '';
	$SIS_where = 'idMaquina ='.simpleDecode($_GET['id'], fecha_actual());
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	// Se trae un listado de la matriz
	$SIS_query = '
	maquinas_listado_matriz.idMatriz,
	maquinas_listado_matriz.Nombre,
	maquinas_listado_matriz.cantPuntos,
	core_estados.Nombre AS Estado,
	maquinas_listado_matriz.idEstado';
	$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = maquinas_listado_matriz.idEstado';
	$SIS_where = 'maquinas_listado_matriz.idMaquina ='.simpleDecode($_GET['id'], fecha_actual());
	$SIS_order = 'maquinas_listado_matriz.Nombre ASC';
	$arrMatriz = array();
	$arrMatriz = db_select_array (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatriz');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Maquinas', $rowData['Nombre'], 'Matriz Analisis'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Matriz</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'maquinas_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'maquinas_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'maquinas_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<?php
							//Dependencia Clientes
							if(isset($rowData['idConfig_3'])&&$rowData['idConfig_3']==1){ ?>
								<li class=""><a href="<?php echo 'maquinas_listado_datos_clientes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-users" aria-hidden="true"></i> Clientes</a></li>
							<?php } ?>
							<?php
							//Uso Ubicación
							if(isset($rowData['idConfig_4'])&&$rowData['idConfig_4']==1){ ?>
								<li class=""><a href="<?php echo 'maquinas_listado_ubicacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicación</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'maquinas_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha Tecnica</a></li>
							<li class=""><a href="<?php echo 'maquinas_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>
							<li class=""><a href="<?php echo 'maquinas_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
							<li class=""><a href="<?php echo 'maquinas_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'maquinas_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
							<?php
							//Uso de componentes
							if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){ ?>
								<li class=""><a href="<?php echo 'maquinas_listado_componentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Componentes</a></li>
							<?php } ?>
							<?php
							//uso de matriz de analisis
							if(isset($rowData['idConfig_2'])&&$rowData['idConfig_2']==1){ ?>
								<li class="active"><a href="<?php echo 'maquinas_listado_matriz_analisis.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-microchip" aria-hidden="true"></i> Matriz Analisis</a></li>
							<?php } ?>

						</ul>
					</li>
				</ul>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre</th>
							<th width="120">Estado</th>
							<th width="10">N° Puntos</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrMatriz as $maq) { ?>
						<tr class="odd">
							<td><?php echo $maq['Nombre']; ?></td>
							<td><label class="label <?php if(isset($maq['idEstado'])&&$maq['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $maq['Estado']; ?></label></td>
							<td><?php echo $maq['cantPuntos']; ?></td>
							<td>
								<div class="btn-group" style="width: 140px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz_2='.$maq['idMatriz']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&nombre_matriz='.$maq['Nombre'].'&clone_idMatriz='.$maq['idMatriz']; ?>" title="Clonar Matriz" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idMatriz='.$maq['idMatriz']; ?>" title="Editar Matriz" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($maq['idMatriz'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la matriz '.$maq['Nombre'].'?'; ?>
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
