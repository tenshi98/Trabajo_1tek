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
$original = "informe_busqueda_ot_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idMaquina'])&&$_GET['idMaquina']!=''){ $search .="&idMaquina=".$_GET['idMaquina'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){   $search .="&idEstado=".$_GET['idEstado'];}
if(isset($_GET['idPrioridad'])&&$_GET['idPrioridad']!=''){    $search .="&idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){       $search .="&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idLicitacion'])&&$_GET['idLicitacion']!=''){  $search .="&idLicitacion=".$_GET['idLicitacion'];}
if(isset($_GET['idOT'])&&$_GET['idOT']!=''){           $search .="&idOT=".$_GET['idOT'];}
if(isset($_GET['f_programacion_inicio'])&&$_GET['f_programacion_inicio']!=''&&isset($_GET['f_programacion_termino'])&&$_GET['f_programacion_termino']!=''){
	$search .="&f_programacion_inicio=".$_GET['f_programacion_inicio'];
	$search .="&f_programacion_termino=".$_GET['f_programacion_termino'];
}
if(isset($_GET['f_termino_inicio'])&&$_GET['f_termino_inicio']!=''&&isset($_GET['f_termino_termino'])&&$_GET['f_termino_termino']!=''){
	$search .="&f_termino_inicio=".$_GET['f_termino_inicio'];
	$search .="&f_termino_termino=".$_GET['f_termino_termino'];
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
		case 'id_asc':         $order_by = 'orden_trabajo_listado.idOT ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> ID Ascendente'; break;
		case 'id_desc':        $order_by = 'orden_trabajo_listado.idOT DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';break;
		case 'fprog_asc':      $order_by = 'orden_trabajo_listado.f_programacion ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> F Prog Ascendente';break;
		case 'fprog_desc':     $order_by = 'orden_trabajo_listado.f_programacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> F Prog Descendente';break;
		case 'maquina_asc':    $order_by = 'maquinas_listado.Nombre ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Maquina Ascendente';break;
		case 'maquina_desc':   $order_by = 'maquinas_listado.Nombre DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Maquina Descendente';break;
		case 'prioridad_asc':  $order_by = 'core_ot_prioridad.Nombre ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prioridad Ascendente';break;
		case 'prioridad_desc': $order_by = 'core_ot_prioridad.Nombre DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Prioridad Descendente';break;
		case 'tipotrab_asc':   $order_by = 'core_ot_tipos.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Trabajo Ascendente';break;
		case 'tipotrab_desc':  $order_by = 'core_ot_tipos.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Trabajo Descendente';break;
		case 'obs_asc':        $order_by = 'orden_trabajo_listado.Observaciones ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Observaciones Ascendente';break;
		case 'obs_desc':       $order_by = 'orden_trabajo_listado.Observaciones DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Observaciones Descendente';break;

		default: $order_by = 'orden_trabajo_listado.idOT DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';
	}
}else{
	$order_by = 'orden_trabajo_listado.idOT DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where  = "orden_trabajo_listado.idOT>=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where .= " AND orden_trabajo_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
if(isset($_GET['idMaquina'])&&$_GET['idMaquina']!=''){$SIS_where.= " AND orden_trabajo_listado.idMaquina=".$_GET['idMaquina'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){  $SIS_where.= " AND orden_trabajo_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['idPrioridad'])&&$_GET['idPrioridad']!=''){   $SIS_where.= " AND orden_trabajo_listado.idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){      $SIS_where.= " AND orden_trabajo_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['idLicitacion'])&&$_GET['idLicitacion']!=''){ $SIS_where.= " AND orden_trabajo_listado.idLicitacion=".$_GET['idLicitacion'];}
if(isset($_GET['idOT'])&&$_GET['idOT']!=''){          $SIS_where.= " AND orden_trabajo_listado.idOT=".$_GET['idOT'];}
if(isset($_GET['f_programacion_inicio'])&&$_GET['f_programacion_inicio']!=''&&isset($_GET['f_programacion_termino'])&&$_GET['f_programacion_termino']!=''){
	$SIS_where.= " AND orden_trabajo_listado.f_programacion BETWEEN '".$_GET['f_programacion_inicio']."' AND '".$_GET['f_programacion_termino']."'";
}
if(isset($_GET['f_termino_inicio'])&&$_GET['f_termino_inicio']!=''&&isset($_GET['f_termino_termino'])&&$_GET['f_termino_termino']!=''){
	$SIS_where.= " AND orden_trabajo_listado.f_termino BETWEEN '".$_GET['f_termino_inicio']."' AND '".$_GET['f_termino_termino']."'";
}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idOT', 'orden_trabajo_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
orden_trabajo_listado.idOT,
orden_trabajo_listado.f_programacion,
orden_trabajo_listado.Observaciones,
maquinas_listado.Nombre AS NombreMaquina,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_tipos.Nombre AS NombreTipo';
$SIS_join  = '
LEFT JOIN `maquinas_listado`     ON maquinas_listado.idMaquina      = orden_trabajo_listado.idMaquina
LEFT JOIN `core_ot_prioridad`    ON core_ot_prioridad.idPrioridad   = orden_trabajo_listado.idPrioridad
LEFT JOIN `core_ot_tipos`        ON core_ot_tipos.idTipo            = orden_trabajo_listado.idTipo';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ordenes de Trabajo</h5>
			<div class="toolbar">
				<?php 
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">#</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=id_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=id_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">F Prog</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fprog_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fprog_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Maquina</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=maquina_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=maquina_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Prioridad</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=prioridad_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=prioridad_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo Trabajo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=tipotrab_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=tipotrab_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Observaciones</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=obs_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=obs_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOTS as $ot) { ?>
					<tr class="odd">
						<td><?php echo $ot['idOT']; ?></td>
						<td><?php echo Fecha_estandar($ot['f_programacion']); ?></td>
						<td><?php echo $ot['NombreMaquina']; ?></td>
						<td><?php echo $ot['NombrePrioridad']; ?></td>
						<td><?php echo $ot['NombreTipo']; ?></td>
						<td><?php echo $ot['Observaciones']; ?></td>
						<td>
							<div class="btn-group" style="width: 140px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_orden_trabajo.php?view='.simpleEncode($ot['idOT'], fecha_actual()); ?>" title="Ver Orden de Trabajo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'orden_trabajo_editar.php?view='.$ot['idOT']; ?>" title="Editar Orden de Trabajo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location.'&clone='.$ot['idOT']; ?>" title="Duplicar Orden de Trabajo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del_ot='.simpleEncode($ot['idOT'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el registro de la OT  '.n_doc($ot['idOT'], 5).'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
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
				if(isset($f_programacion_inicio)){   $x1  = $f_programacion_inicio;      }else{$x1  = '';}
				if(isset($f_programacion_termino)){  $x2  = $f_programacion_termino;     }else{$x2  = '';}
				if(isset($f_termino_inicio)){        $x3  = $f_termino_inicio;           }else{$x3  = '';}
				if(isset($f_termino_termino)){       $x4  = $f_termino_termino;          }else{$x4  = '';}
				if(isset($idMaquina)){               $x5  = $idMaquina;                  }else{$x5  = '';}
				if(isset($idEstado)){                $x6  = $idEstado;                   }else{$x6  = '';}
				if(isset($idPrioridad)){             $x7  = $idPrioridad;                }else{$x7  = '';}
				if(isset($idTipo)){                  $x8  = $idTipo;                     }else{$x8  = '';}
				if(isset($idLicitacion)){            $x9  = $idLicitacion;               }else{$x9  = '';}
				if(isset($idOT)){                    $x10 = $idOT;                       }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Programacion Desde','f_programacion_inicio', $x1, 1);
				$Form_Inputs->form_date('Fecha Programacion Hasta','f_programacion_termino', $x2, 1);
				$Form_Inputs->form_date('Fecha Termino Desde','f_termino_inicio', $x3, 1);
				$Form_Inputs->form_date('Fecha Termino Hasta','f_termino_termino', $x4, 1);
				$Form_Inputs->form_select_filter('Maquina','idMaquina', $x5, 1, 'idMaquina', 'Nombre', 'maquinas_listado', $z, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x6, 1, 'idEstado', 'Nombre', 'core_estado_ot', 0, '', $dbConn);
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x7, 1, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo','idTipo', $x8, 1, 'idTipo', 'Nombre', 'core_ot_tipos', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Contrato','idLicitacion', $x9, 1, 'idLicitacion', 'Nombre', 'licitacion_listado', $z, '', $dbConn);
				$Form_Inputs->form_input_number('N° OT', 'idOT', $x10, 1);
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
