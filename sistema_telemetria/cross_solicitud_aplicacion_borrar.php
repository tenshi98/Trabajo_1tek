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
$original = "cross_solicitud_aplicacion_borrar.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $location .= "&NSolicitud=".$_GET['NSolicitud'];          $search .= "&NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $location .= "&idPredio=".$_GET['idPredio'];              $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $location .= "&idTemporada=".$_GET['idTemporada'];        $search .= "&idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $location .= "&idEstadoFen=".$_GET['idEstadoFen'];        $search .= "&idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $location .= "&idCategoria=".$_GET['idCategoria'];        $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $location .= "&idProducto=".$_GET['idProducto'];          $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){  $location .= "&f_programacion=".$_GET['f_programacion'];  $search .= "&f_programacion=".$_GET['f_programacion'];}
if(isset($_GET['horaProg']) && $_GET['horaProg']!=''){       $location .= "&horaProg=".$_GET['horaProg'];              $search .= "&horaProg=".$_GET['horaProg'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $location .= "&idUsuario=".$_GET['idUsuario'];            $search .= "&idUsuario=".$_GET['idUsuario'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se elimina la solicitud
if (!empty($_GET['del_Solicitud'])){
	//Llamamos al formulario
	$form_trabajo= 'del_All_Solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){     $error['created']     = 'sucess/Solicitud Creada correctamente';}
if (isset($_GET['edited'])){      $error['edited']      = 'sucess/Solicitud Modificada correctamente';}
if (isset($_GET['deleted'])){     $error['deleted']     = 'sucess/Solicitud Borrada correctamente';}
if (isset($_GET['notslectjob'])){ $error['notslectjob'] = 'error/No ha seleccionado un trabajo a realizar';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit_Cuarteles'])){ ?>

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
		case 'id_asc':        $order_by = 'cross_solicitud_aplicacion_listado.NSolicitud ASC ';                          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Solicitud Ascendente'; break;
		case 'id_desc':       $order_by = 'cross_solicitud_aplicacion_listado.NSolicitud DESC ';                         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Solicitud Descendente';break;
		case 'fprog_asc':     $order_by = 'cross_solicitud_aplicacion_listado.f_programacion ASC ';                      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Programacion Ascendente';break;
		case 'fprog_desc':    $order_by = 'cross_solicitud_aplicacion_listado.f_programacion DESC ';                     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Programacion Descendente';break;
		case 'predio_asc':    $order_by = 'cross_predios_listado.Nombre ASC ';                                           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Predio Ascendente'; break;
		case 'predio_desc':   $order_by = 'cross_predios_listado.Nombre DESC ';                                          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Predio Descendente';break;
		case 'especie_asc':   $order_by = 'sistema_variedades_categorias.Nombre ASC, variedades_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Especie/Variedad Ascendente'; break;
		case 'especie_desc':  $order_by = 'sistema_variedades_categorias.Nombre DESC, variedades_listado.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Especie/Variedad Descendente';break;
		
	
		default: $order_by = 'cross_solicitud_aplicacion_listado.NSolicitud DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Solicitud Descendente';
	}
}else{
	$order_by = 'cross_solicitud_aplicacion_listado.NSolicitud DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Solicitud Descendente';
}
/**********************************************************/
//filtro de usuarios
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}
//Variable de busqueda
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$y = "idEstado=1";
$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){  $SIS_where .= " AND cross_solicitud_aplicacion_listado.f_programacion=".$_GET['f_programacion'];}
if(isset($_GET['horaProg']) && $_GET['horaProg']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.horaProg=".$_GET['horaProg'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idSolicitud', 'cross_solicitud_aplicacion_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_programacion,
cross_solicitud_aplicacion_listado.f_ejecucion,
cross_predios_listado.Nombre AS NombrePredio,
sistema_variedades_categorias.Nombre AS Especie,
variedades_listado.Nombre AS Variedad';
$SIS_join  = '
LEFT JOIN `cross_predios_listado`           ON cross_predios_listado.idPredio             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `sistema_variedades_categorias`   ON sistema_variedades_categorias.idCategoria  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`              ON variedades_listado.idProducto              = cross_solicitud_aplicacion_listado.idProducto';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');
				
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
				if(isset($NSolicitud)){       $x1  = $NSolicitud;       }else{$x1  = '';}
				if(isset($idPredio)){         $x2  = $idPredio;         }else{$x2  = '';}
				if(isset($idTemporada)){      $x3  = $idTemporada;      }else{$x3  = '';}
				if(isset($idEstadoFen)){      $x4  = $idEstadoFen;      }else{$x4  = '';}
				if(isset($idCategoria)){      $x5  = $idCategoria;      }else{$x5  = '';}
				if(isset($idProducto)){       $x6  = $idProducto;       }else{$x6  = '';}
				if(isset($f_programacion)){   $x7  = $f_programacion;   }else{$x7  = '';}
				if(isset($horaProg)){         $x8  = $horaProg;         }else{$x8  = '';}
				if(isset($idUsuario)){        $x9  = $idUsuario;        }else{$x9  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('N° Solicitud','NSolicitud', $x1, 1);
				$Form_Inputs->form_select_filter('Predio','idPredio', $x2, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $x, '', $dbConn);
				$Form_Inputs->form_select_filter('Temporada','idTemporada', $x3, 1, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
				$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x4, 1, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x5, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x6, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_date('Fecha Programada','f_programacion', $x7, 1);
				$Form_Inputs->form_time('Hora Programada','horaProg', $x8, 1, 2);
				$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x9, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Solicitudes de Aplicacion</h5>
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
						<th width="100">
							<div class="pull-left">#</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=id_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=id_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="140">
							<div class="pull-left">F Solicitud</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fprog_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fprog_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Predio</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=predio_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=predio_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Especie/Variedad</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=especie_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=especie_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOTS as $ot) { ?>
						<tr class="odd">
							<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
							<td><?php echo Fecha_estandar($ot['f_programacion']); ?></td>
							<td><?php echo $ot['NombrePredio']; ?></td>
							<td><?php if(isset($ot['Especie'])&&$ot['Especie']!=''){echo $ot['Especie'].' '.$ot['Variedad'];}else{echo 'Todas las Especies - Variedades';} ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del_Solicitud='.simpleEncode($ot['idSolicitud'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el registro de la Solicitud  '.n_doc($ot['NSolicitud'], 5).'?'; ?>
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
