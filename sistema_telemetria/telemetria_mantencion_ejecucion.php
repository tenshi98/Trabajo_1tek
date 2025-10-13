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
$original = "telemetria_mantencion_ejecucion.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Identificador']) && $_GET['Identificador']!=''){  $location .= "&Identificador=".$_GET['Identificador'];  $search .= "&Identificador=".$_GET['Identificador'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){         $location .= "&Nombre=".$_GET['Nombre'];                $search .= "&Nombre=".$_GET['Nombre'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'mant_create';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
//se resetean los valores de prueba
if (!empty($_GET['reset'])){
	//Se agregan Ubicaciones
	$location .='&verify='.$_GET['verify'];
	//Llamamos al formulario
	$form_trabajo= 'mant_reset';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
//se finaliza la mantencion
if (!empty($_GET['end'])){
	//Llamamos al formulario
	$form_trabajo= 'mant_end';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
//se cancela la mantencion
if (!empty($_POST['submit_cancel'])){
	//Llamamos al formulario
	$form_trabajo= 'mant_cancel';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['create'])){  $error['create']  = 'sucess/Mantencion Creada correctamente';}
if (isset($_GET['reseted'])){ $error['reseted'] = 'sucess/Datos Reseteados correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Cancelar Mantencion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Observacion)){     $x1  = $Observacion;    }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_textarea('Observaciones', 'Observacion', $x1, 2);

				$Form_Inputs->form_input_hidden('idTelemetria', $_GET['edit'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_cancel">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['verify'])){
//numero sensores equipo
$N_Maximo_Sensores = 72;
//Traigo todos los valores	
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS Tel_Sensor_Nombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$i.' AS Tel_Sensor_Tipo_'.$i;

	$subquery .= ',telemetria_mantencion_matriz.PuntoNombre_'.$i.' AS Matriz_Punto_'.$i;
	$subquery .= ',telemetria_mantencion_matriz.SensoresTipo_'.$i.' AS Matriz_Sensor_Tipo_'.$i;
	$subquery .= ',telemetria_mantencion_matriz.SensoresValor_'.$i.' AS Matriz_Sensor_Valor_'.$i;
	$subquery .= ',telemetria_mantencion_matriz.SensoresNumero_'.$i.' AS Matriz_Sensor_Numero_'.$i;

}

// consulto los datos
$SIS_query = '
telemetria_listado.Nombre AS Tel_Equipo,
telemetria_listado.Identificador AS Tel_Identificador,
telemetria_listado.FechaMantencionIni AS Tel_Fecha,
telemetria_listado.HoraMantencionIni AS Tel_Hora,

telemetria_mantencion_matriz.Nombre AS Matriz_Nombre,
telemetria_mantencion_matriz.cantPuntos AS Matriz_Puntos'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_mantencion_matriz`          ON telemetria_mantencion_matriz.idMatriz            = telemetria_listado.idMatriz
LEFT JOIN `telemetria_listado_sensores_nombre`    ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_tipo`      ON telemetria_listado_sensores_tipo.idTelemetria    = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['verify'];
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/*******************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado_sensores.idSensores,
telemetria_listado_sensores.Nombre,
core_sensores_funciones.Nombre AS SensorFuncion';
$SIS_join  = 'LEFT JOIN `core_sensores_funciones` ON core_sensores_funciones.idSensorFuncion = telemetria_listado_sensores.idSensorFuncion';
$SIS_where = '';
$SIS_order = 'idSensores ASC';
$arrTipos = array();
$arrTipos = db_select_array (false, $SIS_query, 'telemetria_listado_sensores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');

/*******************************************************/
$Url  = 'telemetria_mantencion_ejecucion_load.php';
$Url .= '?bla=bla';
$Url .= '&pagina='.$_GET['pagina'];
$Url .= '&verify='.$_GET['verify'];
$Url .= $search;

echo '
	<script type="text/javascript">
		function actualiza_contenido() {
			$("#ContenedorX").load('.$Url.');
		}
		setInterval("actualiza_contenido()", 5000);

	</script>';

?>

<div id="ContenedorX">

	<section class="invoice">

		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header">
					<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['Tel_Equipo'].' ('.$rowData['Tel_Identificador'].')'; ?>.
					<small class="pull-right"> <?php echo $rowData['Matriz_Nombre'] ?></small>
				</h2>
			</div>
		</div>

		<div class="row invoice-info">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
				<strong>Datos Mantencion</strong>
				<address>
					Fecha Inicio: <?php echo fecha_estandar($rowData['Tel_Fecha']); ?><br/>
					Hora Inicio: <?php echo $rowData['Tel_Hora'].' horas'; ?>
					<strong></strong>
				</address>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">

			</div>
		</div>

		<div class="">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Sensor</th>
							<th>Dato a Revisar</th>
							<th>Tipo Sensor <br/>Instalado</th>
							<th>Tipo Sensor <br/>Revisado</th>
							<th>Funcion</th>
							<th style="text-align: center;" width="120">Valor Pruebas</th>
							<th style="text-align: center;" width="120">Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$pass_points = 0;
						for ($i = 1; $i <= $rowData['Matriz_Puntos']; $i++) { ?>
							<tr class="odd">
								<td><?php echo $rowData['Tel_Sensor_Nombre_'.$rowData['Matriz_Sensor_Numero_'.$i]]; ?></td>
								<td><?php echo $rowData['Matriz_Punto_'.$i]; ?></td>
								<td><?php foreach ($arrTipos as $tipo) { if($rowData['Matriz_Sensor_Tipo_'.$rowData['Tel_Sensor_Tipo_'.$i]]==$tipo['idSensores']){ echo $tipo['Nombre'];}} ?></td>
								<td><?php foreach ($arrTipos as $tipo) { if($rowData['Matriz_Sensor_Tipo_'.$i]==$tipo['idSensores']){ echo $tipo['Nombre'];}} ?></td>
								<td><?php foreach ($arrTipos as $tipo) { if($rowData['Matriz_Sensor_Tipo_'.$i]==$tipo['idSensores']){ echo $tipo['SensorFuncion'];}} ?></td>
								<td align="center"><?php echo $rowData['Matriz_Sensor_Valor_'.$i]; ?></td>
								<td align="center">
									<?php
									if($rowData['Matriz_Sensor_Valor_'.$i]<$rowData['Tel_Sensor_Valor_'.$i]){
										echo '<span style="color:#55BD55">Pasa</span>';
										$pass_points++;
									}else{
										echo '<span style="color:#FF3A00">No Pasa</span>';
									}
									?>
								</td>
							</tr>
						<?php } ?>

					</tbody>
				</table>

			</div>
		</div>

		<div class="clearfix"></div>

		<div class="row" style="margin-top:15px;">
			<div class="col-xs-12">

				<?php if($pass_points>=$rowData['Matriz_Puntos']){ ?>
					<a href="<?php echo $location.'&verify='.$_GET['verify'].'&end=true'; ?>" class="btn btn-primary pull-right"  style="margin-left: 5px;" >
						<i class="fa fa-check-circle" aria-hidden="true"></i> Finalizar Mantencion
					</a>
				<?php } ?>

				<a href="<?php echo $location.'&verify='.$_GET['verify'].'&reset=true'; ?>" class="btn btn-default pull-right">
					<i class="fa fa-window-close-o" aria-hidden="true"></i> Resetear Valores
				</a>


			</div>
		</div>

	</section>

</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//se crea filtro
$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.idEstado=1";
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Mantencion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTelemetria)){  $x1  = $idTelemetria;  }else{$x1  = '';}
				if(isset($idMatriz)){      $x2  = $idMatriz;      }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
				}
				$Form_Inputs->form_select_filter('Matriz de Mantenciones','idMatriz', $x2, 2, 'idMatriz', 'Nombre', 'telemetria_mantencion_matriz', $z, '', $dbConn);

				$Form_Inputs->form_input_hidden('idMantencion', 1, 2);
				$Form_Inputs->form_input_hidden('idEstado', 2, 2);
				$Form_Inputs->form_input_hidden('idUsuarioMan', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('FechaMantencionIni', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('HoraMantencionIni', hora_actual(), 2);

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
		case 'nombre_asc':           $order_by = 'telemetria_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':          $order_by = 'telemetria_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'identificador_asc':    $order_by = 'telemetria_listado.Identificador ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Identificador Ascendente';break;
		case 'identificador_desc':   $order_by = 'telemetria_listado.Identificador DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Identificador Descendente';break;

		default: $order_by = 'telemetria_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'telemetria_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_listado.idEstado=2 AND telemetria_listado.idMantencion=1";//Solo los que estan en mantencion
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Identificador']) && $_GET['Identificador']!=''){  $SIS_where .= " AND telemetria_listado.Identificador LIKE '%".EstandarizarInput($_GET['Identificador'])."%'";}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){         $SIS_where .= " AND telemetria_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idTelemetria', 'telemetria_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Identificador,
telemetria_listado.Nombre,
core_sistemas.Nombre AS sistema';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = telemetria_listado.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrUsers = array();
$arrUsers = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Mantencion</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Identificador)){   $x1  = $Identificador;    }else{$x1  = '';}
				if(isset($Nombre)){          $x2  = $Nombre;           }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_icon('Identificador', 'Identificador', $x1, 1,'fa fa-flag');
				$Form_Inputs->form_input_text('Nombre del Equipo', 'Nombre', $x2, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Equipos</h5>
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
						<th>
							<div class="pull-left">Identificador</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=identificador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=identificador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrUsers as $usuarios){ ?>
					<tr class="odd">
						<td><?php echo $usuarios['Nombre']; ?></td>
						<td><?php echo $usuarios['Identificador']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria.php?view='.simpleEncode($usuarios['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&verify='.$usuarios['idTelemetria']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){ ?><a href="<?php echo $location.'&edit='.$usuarios['idTelemetria']; ?>" title="Cerrar Mantencion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
