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
$original = "telemetria_mantencion_maquinas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){      $location .= "&Nombre=".$_GET['Nombre'];            $search .= "&Nombre=".$_GET['Nombre'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_matriz'])){
	//Llamamos al formulario
	$form_trabajo= 'insert_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_mantencion_matriz.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_mat'])){
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_mantencion_matriz.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location.='&idMatriz='.$_GET['idMatriz'];
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_mantencion_matriz.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_mantencion_matriz.php';
}
//se clona la maquina
if (!empty($_POST['clone_Matriz'])){
	//Llamamos al formulario
	$form_trabajo= 'clone_Matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_mantencion_matriz.php';
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
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['mod'])){
// Se traen todos los datos de la maquina
$SIS_query  = 'telemetria_mantencion_matriz.PuntoNombre_'.$_GET['mod'].' AS Nombre';
$SIS_query .= ',telemetria_mantencion_matriz.SensoresTipo_'.$_GET['mod'].' AS Sensor';
$SIS_query .= ',telemetria_mantencion_matriz.SensoresValor_'.$_GET['mod'].' AS Valor';
$SIS_query .= ',telemetria_mantencion_matriz.SensoresNumero_'.$_GET['mod'].' AS SensoresNumero';
$SIS_join  = '';
$rowData = db_select_data (false, $SIS_query, 'telemetria_mantencion_matriz', $SIS_join, 'idMatriz = '.$_GET['idMatriz'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
				$Form_Inputs->form_input_text('Nombre', 'PuntoNombre', $rowData['Nombre'], 2);
				$Form_Inputs->form_select('Tipo de Sensor','SensoresTipo', $rowData['Sensor'], 2, 'idSensores', 'Nombre', 'telemetria_listado_sensores', 0, '', $dbConn);
				$Form_Inputs->form_input_number('Valor a Alcanzar','SensoresValor', Cantidades_decimales_justos($rowData['Valor']), 2);
				$Form_Inputs->form_select_n_auto('N° Sensor Revisado','SensoresNumero', $rowData['SensoresNumero'], 2, 1, 72);

				$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz'], 2);
				$Form_Inputs->form_input_hidden('mod', $_GET['mod'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $location.'&idMatriz='.$_GET['idMatriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz'])){

//numero sensores equipo
$N_Maximo_Sensores = 72;
$SIS_query  = '
telemetria_mantencion_matriz.Nombre,
telemetria_mantencion_matriz.cantPuntos';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$SIS_query .= ',telemetria_mantencion_matriz.PuntoNombre_'.$i;
	$SIS_query .= ',telemetria_mantencion_matriz.SensoresTipo_'.$i;
	$SIS_query .= ',telemetria_mantencion_matriz.SensoresValor_'.$i;
	$SIS_query .= ',telemetria_mantencion_matriz.SensoresNumero_'.$i;
}
$SIS_join  = '';
$rowData = db_select_data (false, $SIS_query, 'telemetria_mantencion_matriz', $SIS_join, 'idMatriz = '.$_GET['idMatriz'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_listado_sensores.idSensores,
telemetria_listado_sensores.Nombre,
core_sensores_funciones.Nombre AS SensorFuncion';
$SIS_join  = 'LEFT JOIN `core_sensores_funciones` ON core_sensores_funciones.idSensorFuncion = telemetria_listado_sensores.idSensorFuncion';
$SIS_where = '';
$SIS_order = 'telemetria_listado_sensores.idSensores ASC';
$arrTipos = array();
$arrTipos = db_select_array (false, $SIS_query, 'telemetria_listado_sensores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Puntos de <?php echo $rowData['Nombre']; ?></h5>
		</header>

        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th>Tipo Sensor</th>
						<th>Funcion</th>
						<th width="120">N° Sensor Revisado</th>
						<th width="120">Valor a Alcanzar</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php for ($i = 1; $i <= $rowData['cantPuntos']; $i++) { ?>
					<tr class="odd">
						<td><?php echo $rowData['PuntoNombre_'.$i]; ?></td>
						<td><?php foreach ($arrTipos as $tipo) { if($rowData['SensoresTipo_'.$i]==$tipo['idSensores']){ echo $tipo['Nombre'];}} ?></td>
						<td><?php foreach ($arrTipos as $tipo) { if($rowData['SensoresTipo_'.$i]==$tipo['idSensores']){ echo $tipo['SensorFuncion'];}} ?></td>
						<td><?php echo $rowData['SensoresNumero_'.$i]; ?></td>
						<td><?php echo $rowData['SensoresValor_'.$i]; ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&idMatriz='.$_GET['idMatriz'].'&mod='.$i; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz_2'])){
// consulto los datos
$SIS_query  = 'Nombre,cantPuntos, idSistema';
$SIS_join  = '';
$rowData = db_select_data (false, $SIS_query, 'telemetria_mantencion_matriz', $SIS_join, 'idMatriz = '.$_GET['idMatriz_2'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificación Matriz</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){      $x1  = $Nombre;       }else{$x1  = $rowData['Nombre'];}
				if(isset($cantPuntos)){  $x2  = $cantPuntos;   }else{$x2  = $rowData['cantPuntos'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_select_n_auto('N° Puntos Revision','cantPuntos', $x2, 2, 1, 72);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz_2'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_mat">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
			<h5>Crear Matriz</h5>
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
				$Form_Inputs->form_select_n_auto('N° Puntos Revision','cantPuntos', $x2, 2, 1, 72);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_matriz">
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
		case 'nombre_asc':   $order_by = 'telemetria_mantencion_matriz.Nombre ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':  $order_by = 'telemetria_mantencion_matriz.Nombre DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'puntos_asc':   $order_by = 'telemetria_mantencion_matriz.cantPuntos ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Puntos Ascendente'; break;
		case 'puntos_desc':  $order_by = 'telemetria_mantencion_matriz.cantPuntos DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Puntos Descendente';break;
		case 'estado_asc':   $order_by = 'core_estados.Nombre ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':  $order_by = 'core_estados.Nombre DESC ';                       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

		default: $order_by = 'telemetria_mantencion_matriz.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'telemetria_mantencion_matriz.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_mantencion_matriz.idMatriz!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND telemetria_mantencion_matriz.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){ $SIS_where .= " AND telemetria_mantencion_matriz.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){    $SIS_where .= " AND telemetria_mantencion_matriz.idEstado=".$_GET['idEstado'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idMatriz', 'telemetria_mantencion_matriz', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_mantencion_matriz.idMatriz,
telemetria_mantencion_matriz.Nombre,
telemetria_mantencion_matriz.cantPuntos,
core_estados.Nombre AS Estado,
telemetria_mantencion_matriz.idEstado';
$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = telemetria_mantencion_matriz.idEstado';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrMatriz = array();
$arrMatriz = db_select_array (false, $SIS_query, 'telemetria_mantencion_matriz', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatriz');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location.'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Matriz</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){    $x1  = $Nombre;     }else{$x1  = '';}
				if(isset($idEstado)){  $x2  = $idEstado;   }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
				$Form_Inputs->form_select('Estado','idEstado', $x2, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Matrices</h5>
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
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">N° Puntos</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=puntos_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=puntos_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrMatriz as $maq) { ?>
					<tr class="odd">
						<td><?php echo $maq['Nombre']; ?></td>
						<td><?php echo $maq['cantPuntos']; ?></td>
						<td><label class="label <?php if(isset($maq['idEstado'])&&$maq['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $maq['Estado']; ?></label></td>
						<td>
							<div class="btn-group" style="width: 140px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&idMatriz_2='.$maq['idMatriz']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&nombre_matriz='.$maq['Nombre'].'&clone_idMatriz='.$maq['idMatriz']; ?>" title="Clonar Matriz" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&idMatriz='.$maq['idMatriz']; ?>" title="Editar Matriz" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($maq['idMatriz'], fecha_actual());
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
