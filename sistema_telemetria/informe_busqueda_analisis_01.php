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
$original = "informe_busqueda_analisis_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['n_muestra'])&&$_GET['n_muestra']!=''){    $search .="&n_muestra=".$_GET['n_muestra'];}
if(isset($_GET['idMaquina'])&&$_GET['idMaquina']!=''){    $search .="&idMaquina=".$_GET['idMaquina'];}
if(isset($_GET['idMatriz'])&&$_GET['idMatriz']!=''){      $search .="&idMatriz=".$_GET['idMatriz'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){      $search .="&idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_muestreo_ini'])&&$_GET['f_muestreo_ini']!=''&&isset($_GET['f_muestreo_fin'])&&$_GET['f_muestreo_fin']!=''){
	$search .="&f_muestreo_ini=".$_GET['f_muestreo_ini'];
	$search .="&f_muestreo_fin=".$_GET['f_muestreo_fin'];
}
if(isset($_GET['f_recibida_ini'])&&$_GET['f_recibida_ini']!=''&&isset($_GET['f_recibida_fin'])&&$_GET['f_recibida_fin']!=''){
	$search .="&f_recibida_ini=".$_GET['f_recibida_ini'];
	$search .="&f_recibida_fin=".$_GET['f_recibida_fin'];
}
if(isset($_GET['f_reporte_ini'])&&$_GET['f_reporte_ini']!=''&&isset($_GET['f_reporte_fin'])&&$_GET['f_reporte_fin']!=''){
	$search .="&f_reporte_ini=".$_GET['f_reporte_ini'];
	$search .="&f_reporte_fin=".$_GET['f_reporte_fin'];
}

//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
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
		case 'maquina_asc':     $order_by = 'maquinas_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Maquina Ascendente'; break;
		case 'maquina_desc':    $order_by = 'maquinas_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Maquina Descendente';break;
		case 'analisis_asc':    $order_by = 'maquinas_listado_matriz.Nombre ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Analisis Ascendente';break;
		case 'analisis_desc':   $order_by = 'maquinas_listado_matriz.Nombre DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Analisis Descendente';break;
		case 'estado_asc':      $order_by = 'core_analisis_estado.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':     $order_by = 'core_analisis_estado.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'fmuestro_asc':    $order_by = 'analisis_listado.f_muestreo ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha muestreo Ascendente';break;
		case 'fmuestro_desc':   $order_by = 'analisis_listado.f_muestreo DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha muestreo Descendente';break;
		case 'frecibida_asc':   $order_by = 'analisis_listado.f_recibida ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha recibida Ascendente';break;
		case 'frecibida_desc':  $order_by = 'analisis_listado.f_recibida DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha recibida Descendente';break;
		case 'freporte_asc':    $order_by = 'analisis_listado.f_reporte ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha reporte Ascendente';break;
		case 'freporte_desc':   $order_by = 'analisis_listado.f_reporte DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha reporte Descendente';break;

		default: $order_by = 'analisis_listado.idAnalisis ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Analisis Ascendente';
	}
}else{
	$order_by = 'analisis_listado.idAnalisis ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Analisis Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "analisis_listado.idAnalisis!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND analisis_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

if(isset($_GET['n_muestra'])&&$_GET['n_muestra']!=''){  $SIS_where.= " AND analisis_listado.n_muestra=".$_GET['n_muestra'];}
if(isset($_GET['idMaquina'])&&$_GET['idMaquina']!=''){  $SIS_where.= " AND analisis_listado.idMaquina=".$_GET['idMaquina'];}
if(isset($_GET['idMatriz'])&&$_GET['idMatriz']!=''){    $SIS_where.= " AND analisis_listado.idMatriz=".$_GET['idMatriz'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){    $SIS_where.= " AND analisis_listado.idEstado=".$_GET['idEstado'];}

if(isset($_GET['f_muestreo_ini'])&&$_GET['f_muestreo_ini']!=''&&isset($_GET['f_muestreo_fin'])&&$_GET['f_muestreo_fin']!=''){
	$SIS_where.= " AND analisis_listado.Creacion_fecha BETWEEN '".$_GET['f_muestreo_ini']."' AND '".$_GET['f_muestreo_fin']."'";
}
if(isset($_GET['f_recibida_ini'])&&$_GET['f_recibida_ini']!=''&&isset($_GET['f_recibida_fin'])&&$_GET['f_recibida_fin']!=''){
	$SIS_where.= " AND analisis_listado.Pago_fecha BETWEEN '".$_GET['f_recibida_ini']."' AND '".$_GET['f_recibida_fin']."'";
}
if(isset($_GET['f_reporte_ini'])&&$_GET['f_reporte_ini']!=''&&isset($_GET['f_reporte_fin'])&&$_GET['f_reporte_fin']!=''){
	$SIS_where.= " AND analisis_listado.F_Pago BETWEEN '".$_GET['f_reporte_ini']."' AND '".$_GET['f_reporte_fin']."'";
}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idAnalisis', 'analisis_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
analisis_listado.idAnalisis,
core_sistemas.Nombre AS Sistema,
maquinas_listado.Nombre AS Maquina,
maquinas_listado_matriz.Nombre AS Analisis,
core_analisis_estado.Nombre AS Estado,
analisis_listado.n_muestra,
analisis_listado.f_muestreo,
analisis_listado.f_recibida,
analisis_listado.f_reporte';
$SIS_join  = '
LEFT JOIN `core_sistemas`            ON core_sistemas.idSistema            = analisis_listado.idSistema
LEFT JOIN `maquinas_listado`         ON maquinas_listado.idMaquina         = analisis_listado.idMaquina
LEFT JOIN `maquinas_listado_matriz`  ON maquinas_listado_matriz.idMatriz   = analisis_listado.idMatriz
LEFT JOIN `core_analisis_estado`     ON core_analisis_estado.idEstado      = analisis_listado.idEstado';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'analisis_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
	</ul>

</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos</h5>
			<div class="toolbar">
				<?php echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="200">
							<div class="pull-left">Maquina</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=maquina_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=maquina_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="200">
							<div class="pull-left">Analisis</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=analisis_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=analisis_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="200">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="270">
							<div class="pull-left">Fecha Muestreo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fmuestro_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fmuestro_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="270">
							<div class="pull-left">Fecha Recibida</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=frecibida_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=frecibida_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="270">
							<div class="pull-left">Fecha Reporte</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=freporte_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=freporte_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Maquina']; ?></td>
							<td><?php echo $tipo['Analisis'].' N°'.$tipo['n_muestra']; ?></td>
							<td><?php echo $tipo['Estado']; ?></td>
							<td><?php echo Fecha_estandar($tipo['f_muestreo']); ?></td>
							<td><?php echo Fecha_estandar($tipo['f_recibida']); ?></td>
							<td><?php echo Fecha_estandar($tipo['f_reporte']); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_analisis.php?view='.simpleEncode($tipo['idAnalisis'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($n_muestra)){        $x1  = $n_muestra;        }else{$x1  = '';}
				if(isset($idMaquina)){        $x2  = $idMaquina;        }else{$x2  = '';}
				if(isset($idMatriz)){         $x3  = $idMatriz;         }else{$x3  = '';}
				if(isset($idEstado)){         $x4  = $idEstado;         }else{$x4  = '';}
				if(isset($f_muestreo_ini)){   $x5  = $f_muestreo_ini;   }else{$x5  = '';}
				if(isset($f_muestreo_fin)){   $x6  = $f_muestreo_fin;   }else{$x6  = '';}
				if(isset($f_recibida_ini)){   $x7  = $f_recibida_ini;   }else{$x7  = '';}
				if(isset($f_recibida_fin)){   $x8  = $f_recibida_fin;   }else{$x8  = '';}
				if(isset($f_reporte_ini)){    $x9  = $f_reporte_ini;    }else{$x9  = '';}
				if(isset($f_reporte_fin)){    $x10 = $f_reporte_fin;    }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('N° Muestra de Pago', 'n_muestra', $x1, 1);
				$Form_Inputs->form_select_depend1('Maquina','idMaquina', $x2, 1, 'idMaquina', 'Nombre', 'maquinas_listado', $z, 0,
										 'Analisis','idMatriz', $x3, 1, 'idMatriz', 'Nombre', 'maquinas_listado_matriz', 'idEstado=1', 0, 
										  $dbConn, 'form1');
				$Form_Inputs->form_select('Tipo Documento','idEstado', $x4, 1, 'idEstado', 'Nombre', 'core_analisis_estado', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Muestreo Desde','f_muestreo_ini', $x5, 1);
				$Form_Inputs->form_date('Fecha Muestreo Hasta','f_muestreo_fin', $x6, 1);
				$Form_Inputs->form_date('Fecha Recibida Desde','f_recibida_ini', $x7, 1);
				$Form_Inputs->form_date('Fecha Recibida Hasta','f_recibida_fin', $x8, 1);
				$Form_Inputs->form_date('Fecha Reporte Desde','f_reporte_ini', $x9, 1);
				$Form_Inputs->form_date('Fecha Reporte Hasta','f_reporte_fin', $x10, 1);
				
				
						
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>

			</form>
            <?php widget_validator(); ?>
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
