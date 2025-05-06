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
$original = "cross_quality_calidad_matriz_clonar.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){      $location .= "&idEstado=".$_GET['idEstado'];      $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['cantPuntos']) && $_GET['cantPuntos']!=''){  $location .= "&cantPuntos=".$_GET['cantPuntos'];  $search .= "&cantPuntos=".$_GET['cantPuntos'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){          $location .= "&Nombre=".$_GET['Nombre'];          $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){          $location .= "&idTipo=".$_GET['idTipo'];          $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){    $location .= "&idSistema=".$_GET['idSistema'];    $search .= "&idSistema=".$_GET['idSistema'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se clona la maquina
if (!empty($_POST['clone_Matriz'])){
	//Llamamos al formulario
	$form_trabajo= 'clone_Matriz_sis';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_calidad_matriz.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Tipo Planilla Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Tipo Planilla Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Tipo Planilla Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone_idMatriz'])){

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Clonar Tipo Planilla <?php echo $_GET['nombre_matriz']; ?></h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){    $x1  = $Nombre;    }else{$x1  = '';}
				if(isset($idSistema)){ $x2  = $idSistema; }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_select('Sistema','idSistema', $x2, 2, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);

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
		case 'npuntos_asc':   $order_by = 'cross_quality_calidad_matriz.cantPuntos ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N Puntos Ascendente'; break;
		case 'npuntos_desc':  $order_by = 'cross_quality_calidad_matriz.cantPuntos DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N Puntos Descendente';break;
		case 'nombre_asc':    $order_by = 'cross_quality_calidad_matriz.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':   $order_by = 'cross_quality_calidad_matriz.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'estado_asc':    $order_by = 'core_estados.Nombre ASC ';                         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente'; break;
		case 'estado_desc':   $order_by = 'core_estados.Nombre DESC ';                        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'planilla_asc':  $order_by = 'core_cross_quality_analisis_calidad.Nombre ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Planilla Ascendente'; break;
		case 'planilla_desc': $order_by = 'core_cross_quality_analisis_calidad.Nombre DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Planilla Descendente';break;
		case 'sistema_asc':   $order_by = 'core_sistemas.Nombre ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Sistema Ascendente'; break;
		case 'sistema_desc':  $order_by = 'core_sistemas.Nombre DESC ';                       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Sistema Descendente';break;

		default: $order_by = 'cross_quality_calidad_matriz.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'cross_quality_calidad_matriz.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "cross_quality_calidad_matriz.idMatriz!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){      $SIS_where .= " AND cross_quality_calidad_matriz.idEstado=".$_GET['idEstado'];}
if(isset($_GET['cantPuntos']) && $_GET['cantPuntos']!=''){  $SIS_where .= " AND cross_quality_calidad_matriz.cantPuntos=".$_GET['cantPuntos'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){          $SIS_where .= " AND cross_quality_calidad_matriz.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){          $SIS_where .= " AND cross_quality_calidad_matriz.idTipo=".$_GET['idTipo'];}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){    $SIS_where .= " AND cross_quality_calidad_matriz.idSistema=".$_GET['idSistema'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idMatriz', 'cross_quality_calidad_matriz', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
cross_quality_calidad_matriz.idMatriz,
cross_quality_calidad_matriz.Nombre,
cross_quality_calidad_matriz.cantPuntos,
core_estados.Nombre AS Estado,
core_cross_quality_analisis_calidad.Nombre AS Planilla,
core_sistemas.Nombre AS RazonSocial,
cross_quality_calidad_matriz.idEstado';
$SIS_join  = '
LEFT JOIN `core_estados`                         ON core_estados.idEstado                        = cross_quality_calidad_matriz.idEstado
LEFT JOIN `core_cross_quality_analisis_calidad`  ON core_cross_quality_analisis_calidad.idTipo   = cross_quality_calidad_matriz.idTipo
LEFT JOIN `core_sistemas`                        ON core_sistemas.idSistema                      = cross_quality_calidad_matriz.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrMatriz = array();
$arrMatriz = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatriz');

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
				if(isset($Nombre)){     $x1  = $Nombre;      }else{$x1  = '';}
				if(isset($cantPuntos)){ $x2  = $cantPuntos;  }else{$x2  = '';}
				if(isset($idTipo)){     $x3  = $idTipo;      }else{$x3  = '';}
				if(isset($idEstado)){   $x4  = $idEstado;    }else{$x4  = '';}
				if(isset($idSistema)){  $x5  = $idSistema;   }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
				$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 1, 1, 100);
				$Form_Inputs->form_select('Tipo Planilla','idTipo', $x3, 1, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x4, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
				$Form_Inputs->form_select('Sistema','idSistema', $x5, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tipos Planillas</h5>
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
							<div class="pull-left">Planilla</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=planilla_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=planilla_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">N° Puntos</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=npuntos_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=npuntos_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Sistema</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=sistema_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=sistema_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrMatriz as $maq) { ?>
						<tr class="odd">
							<td><?php echo $maq['Nombre']; ?></td>
							<td><?php echo $maq['Planilla']; ?></td>
							<td><label class="label <?php if(isset($maq['idEstado'])&&$maq['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $maq['Estado']; ?></label></td>
							<td><?php echo $maq['cantPuntos']; ?></td>
							<td><?php echo $maq['RazonSocial']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_cross_quality_calidad_matriz.php?view='.simpleEncode($maq['idMatriz'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&nombre_matriz='.$maq['Nombre'].'&clone_idMatriz='.$maq['idMatriz']; ?>" title="Clonar Tipo Planilla" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
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
