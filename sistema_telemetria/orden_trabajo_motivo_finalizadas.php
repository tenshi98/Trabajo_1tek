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
$original = "orden_trabajo_motivo_finalizadas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idOT']) && $_GET['idOT']!=''){                     $location .= "&idOT=".$_GET['idOT'];                            $search .= "&idOT=".$_GET['idOT'];}
if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){ $location .= "&f_programacion=".$_GET['f_programacion'];        $search .= "&f_programacion=".$_GET['f_programacion'];}
if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){       $location .= "&idUbicacion=".$_GET['idUbicacion'];              $search .= "&idUbicacion=".$_GET['idUbicacion'];}
if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){  $location .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];  $search .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];}
if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){  $location .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];  $search .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];}
if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){  $location .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];  $search .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];}
if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){  $location .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];  $search .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];}
if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){  $location .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];  $search .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){       $location .= "&idPrioridad=".$_GET['idPrioridad'];              $search .= "&idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                 $location .= "&idTipo=".$_GET['idTipo'];                        $search .= "&idTipo=".$_GET['idTipo'];}
			
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){     $error['created']     = 'sucess/Orden de Trabajo Creada correctamente';}
if (isset($_GET['edited'])){      $error['edited']      = 'sucess/Orden de Trabajo Modificada correctamente';}
if (isset($_GET['deleted'])){     $error['deleted']     = 'sucess/Orden de Trabajo Borrada correctamente';}
if (isset($_GET['notslectjob'])){ $error['notslectjob'] = 'error/No ha seleccionado un trabajo a realizar';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone'])){  ?>

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
		case 'id_asc':             $order_by = 'orden_trabajo_tareas_listado.idOT ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> ID Ascendente'; break;
		case 'id_desc':            $order_by = 'orden_trabajo_tareas_listado.idOT DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';break;
		case 'fprog_asc':          $order_by = 'orden_trabajo_tareas_listado.f_programacion ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Programacion Ascendente';break;
		case 'fprog_desc':         $order_by = 'orden_trabajo_tareas_listado.f_programacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Programacion Descendente';break;
		case 'ubicacion_asc':      $order_by = 'ubicacion_listado.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Ubicación Ascendente'; break;
		case 'ubicacion_desc':     $order_by = 'ubicacion_listado.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Ubicación Descendente';break;
		case 'prioridad_asc':      $order_by = 'core_ot_prioridad.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prioridad Ascendente';break;
		case 'prioridad_desc':     $order_by = 'core_ot_prioridad.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Prioridad Descendente';break;
		case 'tipotrab_asc':       $order_by = 'core_ot_motivos_tipos.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Trabajo Ascendente'; break;
		case 'tipotrab_desc':      $order_by = 'core_ot_motivos_tipos.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Trabajo Descendente';break;

		default: $order_by = 'orden_trabajo_tareas_listado.idOT DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> OT Descendente';
	}
}else{
	$order_by = 'orden_trabajo_tareas_listado.idOT DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> OT Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where  = "orden_trabajo_tareas_listado.idOT!=0";
$SIS_where .= " AND orden_trabajo_tareas_listado.idEstado = 3";//solo las finalizadas
//Verifico el tipo de usuario que esta ingresando
$SIS_where .= " AND orden_trabajo_tareas_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idOT']) && $_GET['idOT']!=''){                     $SIS_where .= " AND orden_trabajo_tareas_listado.idOT=".$_GET['idOT'];}
if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){ $SIS_where .= " AND orden_trabajo_tareas_listado.f_programacion='".$_GET['Nombre']."'";}
if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){       $SIS_where .= " AND orden_trabajo_tareas_listado.idUbicacion=".$_GET['idUbicacion'];}
if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){  $SIS_where .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];}
if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){  $SIS_where .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];}
if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){  $SIS_where .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];}
if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){  $SIS_where .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];}
if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){  $SIS_where .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){       $SIS_where .= " AND orden_trabajo_tareas_listado.idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                 $SIS_where .= " AND orden_trabajo_tareas_listado.idTipo=".$_GET['Nombre'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idOT', 'orden_trabajo_tareas_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
orden_trabajo_tareas_listado.idOT,
orden_trabajo_tareas_listado.f_programacion,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_motivos_tipos.Nombre AS NombreTipo';
$SIS_join  = '
LEFT JOIN `core_ot_prioridad`           ON core_ot_prioridad.idPrioridad         = orden_trabajo_tareas_listado.idPrioridad
LEFT JOIN `core_ot_motivos_tipos`       ON core_ot_motivos_tipos.idTipo          = orden_trabajo_tareas_listado.idTipo
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = orden_trabajo_tareas_listado.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = orden_trabajo_tareas_listado.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = orden_trabajo_tareas_listado.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = orden_trabajo_tareas_listado.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = orden_trabajo_tareas_listado.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = orden_trabajo_tareas_listado.idUbicacion_lvl_5';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');

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
				
				if(isset($idOT)){                $x1  = $idOT;                }else{$x1  = '';}
				if(isset($f_programacion)){      $x2  = $f_programacion;      }else{$x2  = '';}
				if(isset($idUbicacion)){         $x3  = $idUbicacion;         }else{$x3  = '';}
				if(isset($idUbicacion_lvl_1)){   $x4  = $idUbicacion_lvl_1;   }else{$x4  = '';}
				if(isset($idUbicacion_lvl_2)){   $x5  = $idUbicacion_lvl_2;   }else{$x5  = '';}
				if(isset($idUbicacion_lvl_3)){   $x6  = $idUbicacion_lvl_3;   }else{$x6  = '';}
				if(isset($idUbicacion_lvl_4)){   $x7  = $idUbicacion_lvl_4;   }else{$x7  = '';}
				if(isset($idUbicacion_lvl_5)){   $x8  = $idUbicacion_lvl_5;   }else{$x8  = '';}
				if(isset($idPrioridad)){         $x9  = $idPrioridad;         }else{$x9  = '';}
				if(isset($idTipo)){              $x10 = $idTipo;              }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('OT','idOT', $x1, 1);
				$Form_Inputs->form_date('Fecha Programada','f_programacion', $x2, 1);
				$Form_Inputs->form_select_depend5('Ubicación', 'idUbicacion',  $x3,  1,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
												  'Nivel 1', 'idUbicacion_lvl_1',  $x4,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
												  'Nivel 2', 'idUbicacion_lvl_2',  $x5,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												  'Nivel 3', 'idUbicacion_lvl_3',  $x6,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												  'Nivel 4', 'idUbicacion_lvl_4',  $x7,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												  'Nivel 5', 'idUbicacion_lvl_5',  $x8,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												  $dbConn, 'form1');
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x9, 1, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Trabajo','idTipo', $x10, 1, 'idTipo', 'Nombre', 'core_ot_motivos_tipos', 0, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ordenes de Trabajo</h5>
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
							<div class="pull-left">#</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=id_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=id_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">F Prog</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fprog_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fprog_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Ubicación</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=ubicacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=ubicacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Prioridad</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=prioridad_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=prioridad_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo Trabajo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipotrab_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipotrab_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOTS as $ot) { ?>
					<tr class="odd">
						<td><?php echo n_doc($ot['idOT'], 8); ?></td>
						<td><?php echo Fecha_estandar($ot['f_programacion']); ?></td>
						<td>
							<?php echo $ot['Ubicacion'];
							if(isset($ot['UbicacionLVL_1'])&&$ot['UbicacionLVL_1']!=''){echo ' - '.$ot['UbicacionLVL_1'];}
							if(isset($ot['UbicacionLVL_2'])&&$ot['UbicacionLVL_2']!=''){echo ' - '.$ot['UbicacionLVL_2'];}
							if(isset($ot['UbicacionLVL_3'])&&$ot['UbicacionLVL_3']!=''){echo ' - '.$ot['UbicacionLVL_3'];}
							if(isset($ot['UbicacionLVL_4'])&&$ot['UbicacionLVL_4']!=''){echo ' - '.$ot['UbicacionLVL_4'];}
							if(isset($ot['UbicacionLVL_5'])&&$ot['UbicacionLVL_5']!=''){echo ' - '.$ot['UbicacionLVL_5'];}
							?>
						</td>
						<td><?php echo $ot['NombrePrioridad']; ?></td>
						<td><?php echo $ot['NombreTipo']; ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_orden_tarea_trabajo.php?view='.simpleEncode($ot['idOT'], fecha_actual()); ?>" title="Ver Orden de Trabajo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
