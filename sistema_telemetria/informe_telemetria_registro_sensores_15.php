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
$original = "informe_telemetria_registro_sensores_15.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){   $location .= "&f_inicio=".$_GET['f_inicio'];           $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){ $location .= "&f_termino=".$_GET['f_termino'];         $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){   $location .= "&h_inicio=".$_GET['h_inicio'];           $search .= "&h_inicio=".$_GET['h_inicio'];}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){ $location .= "&h_termino=".$_GET['h_termino'];         $search .= "&h_termino=".$_GET['h_termino'];}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $location .= "&idTelemetria=".$_GET['idTelemetria'];   $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['idGrupo']) && $_GET['idGrupo']!=''){     $location .= "&idGrupo=".$_GET['idGrupo'];             $search .= "&idGrupo=".$_GET['idGrupo'];}
if(isset($_GET['idGrafico']) && $_GET['idGrafico']!=''){ $location .= "&idGrafico=".$_GET['idGrafico'];         $search .= "&idGrafico=".$_GET['idGrafico'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){   $location .= "&idEstado=".$_GET['idEstado'];           $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['Observacion']) && $_GET['Observacion']!=''){    $location .= "&Observacion=".$_GET['Observacion'];     $search .= "&Observacion=".$_GET['Observacion'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_tracking.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_tracking.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_tracking.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Tracking Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Tracking Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Tracking Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$rowData = db_select_data (false, 'idTracking, f_inicio, f_termino, h_inicio, h_termino, idTelemetria, idGrupo, idGrafico, idEstado, Observacion', 'telemetria_tracking', '', 'idTracking ='.$_GET['id'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

$z = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.id_Geo='2'";	 
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=2";//1Tek C
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificación Tracking</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = $rowData['f_inicio'];}
				if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = $rowData['h_inicio'];}
				if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = $rowData['f_termino'];}
				if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = $rowData['h_termino'];}
				if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = $rowData['idTelemetria'];}
				if(isset($idGrafico)){     $x8  = $idGrafico;    }else{$x8  = $rowData['idGrafico'];}
				if(isset($idEstado)){      $x9  = $idEstado;     }else{$x9  = $rowData['idEstado'];}
				if(isset($Observacion)){   $x10 = $Observacion;  }else{$x10 = $rowData['Observacion'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 2, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 2, 1);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 2, $dbConn);
				$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x8, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x9, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Observacion', 'Observacion', $x10, 1);

				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idTracking', $_GET['id'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
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
$z = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.id_Geo='2'";	 
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=2";//1Tek C
}	 	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Tracking</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}
				if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = '';}
				if(isset($idGrafico)){     $x8  = $idGrafico;    }else{$x8  = '';}
				if(isset($Observacion)){   $x9  = $Observacion;  }else{$x9  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x3, 2, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 2, 1);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 2, $dbConn);
				$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x8, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Observacion', 'Observacion', $x9, 1);

				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);

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
		case 'tracking_asc':       $order_by = 'telemetria_tracking.idTracking ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Codigo Tracking Ascendente'; break;
		case 'tracking_desc':      $order_by = 'telemetria_tracking.idTracking DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Codigo Tracking Descendente';break;
		case 'desde_asc':          $order_by = 'telemetria_tracking.f_inicio ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Desde Ascendente'; break;
		case 'desde_desc':         $order_by = 'telemetria_tracking.f_inicio DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Desde Descendente';break;
		case 'hasta_asc':          $order_by = 'telemetria_tracking.f_termino ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hasta Ascendente'; break;
		case 'hasta_desc':         $order_by = 'telemetria_tracking.f_termino DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hasta Descendente';break;
		case 'equipo_asc':         $order_by = 'telemetria_listado.Nombre ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Equipo Ascendente'; break;
		case 'equipo_desc':        $order_by = 'telemetria_listado.Nombre DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Equipo Descendente';break;
		case 'grupo_asc':          $order_by = 'telemetria_listado_grupos.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Grupo Ascendente'; break;
		case 'grupo_desc':         $order_by = 'telemetria_listado_grupos.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Grupo Descendente';break;
		case 'grafico_asc':        $order_by = 'core_sistemas_opciones.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Opción Grafico Ascendente'; break;
		case 'grafico_desc':       $order_by = 'core_sistemas_opciones.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Opción Grafico Descendente';break;
		case 'estado_asc':         $order_by = 'core_estados.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente'; break;
		case 'estado_desc':        $order_by = 'core_estados.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'observacion_asc':    $order_by = 'telemetria_tracking.idTracking ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Observacion Ascendente'; break;
		case 'observacion_desc':   $order_by = 'telemetria_tracking.idTracking DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Observacion Descendente';break;
		

		default: $order_by = 'telemetria_tracking.idEstado ASC, telemetria_tracking.idTracking DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Codigo Tracking Descendente';
	}
}else{
	$order_by = 'telemetria_tracking.idEstado ASC, telemetria_tracking.idTracking DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Codigo Tracking Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_tracking.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){   $SIS_where .= " AND telemetria_tracking.f_inicio='".$_GET['f_inicio']."'";}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){ $SIS_where .= " AND telemetria_tracking.f_termino='".$_GET['f_termino']."'";}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){   $SIS_where .= " AND telemetria_tracking.h_inicio='".$_GET['h_inicio']."'";}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){ $SIS_where .= " AND telemetria_tracking.h_termino='".$_GET['h_termino']."'";}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $SIS_where .= " AND telemetria_tracking.idTelemetria='".$_GET['idTelemetria']."'";}
if(isset($_GET['idGrupo']) && $_GET['idGrupo']!=''){     $SIS_where .= " AND telemetria_tracking.idGrupo='".$_GET['idGrupo']."'";}
if(isset($_GET['idGrafico']) && $_GET['idGrafico']!=''){ $SIS_where .= " AND telemetria_tracking.idGrafico='".$_GET['idGrafico']."'";}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){   $SIS_where .= " AND telemetria_tracking.idEstado='".$_GET['idEstado']."'";}
if(isset($_GET['Observacion']) && $_GET['Observacion']!=''){    $SIS_where .= " AND telemetria_tracking.Observacion LIKE '%".EstandarizarInput($_GET['Observacion'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idTracking', 'telemetria_tracking', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_tracking.idTracking,
telemetria_tracking.f_inicio,
telemetria_tracking.f_termino,
telemetria_tracking.h_inicio,
telemetria_tracking.h_termino,
telemetria_tracking.idTelemetria,
telemetria_tracking.idGrupo,
telemetria_tracking.idGrafico,
telemetria_tracking.idEstado,
telemetria_tracking.Observacion,

telemetria_listado.Nombre AS equipo,
telemetria_listado_grupos.Nombre AS grupo,
core_sistemas_opciones.Nombre AS grafico,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS RazonSocial';
$SIS_join  = '
LEFT JOIN `telemetria_listado`         ON telemetria_listado.idTelemetria    = telemetria_tracking.idTelemetria
LEFT JOIN `telemetria_listado_grupos`  ON telemetria_listado_grupos.idGrupo  = telemetria_tracking.idGrupo
LEFT JOIN `core_sistemas_opciones`     ON core_sistemas_opciones.idOpciones  = telemetria_tracking.idGrafico
LEFT JOIN `core_estados`               ON core_estados.idEstado              = telemetria_tracking.idEstado
LEFT JOIN `core_sistemas`              ON core_sistemas.idSistema            = telemetria_tracking.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrCategorias = array();
$arrCategorias = db_select_array (false, $SIS_query, 'telemetria_tracking', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategorias');

//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=2";//1Tek C
}


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Tracking</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}
				if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = '';}
				if(isset($idGrafico)){     $x8  = $idGrafico;    }else{$x8  = '';}
				if(isset($idEstado)){      $x9  = $idEstado;     }else{$x9  = '';}
				if(isset($Observacion)){   $x10 = $Observacion;  }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 1);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 1);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 1, $dbConn);
				$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x8, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x9, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Observacion', 'Observacion', $x10, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tracking</h5>
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
							<div class="pull-left">Codigo Tracking</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tracking_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tracking_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Desde</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=desde_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=desde_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Hasta</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=hasta_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=hasta_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Equipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=equipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=equipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Grupo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=grupo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=grupo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Grafico</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=grafico_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=grafico_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Observacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=observacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=observacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCategorias as $cat) { ?>
					<tr class="odd">
						<td><?php echo n_doc($cat['idTracking'], 7); ?></td>
						<td><?php echo $cat['h_inicio'].' - '.fecha_estandar($cat['f_inicio']); ?></td>
						<td><?php echo $cat['h_termino'].' - '.fecha_estandar($cat['f_termino']); ?></td>
						<td><?php echo $cat['equipo']; ?></td>
						<td><?php echo $cat['grupo']; ?></td>
						<td><?php echo $cat['grafico']; ?></td>
						<td><label class="label <?php if(isset($cat['idEstado'])&&$cat['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $cat['estado']; ?></label></td>
						<td><?php echo $cat['Observacion']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $cat['RazonSocial']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php

								$Filtrar = '';
								if(isset($cat['f_inicio']) && $cat['f_inicio']!=''){    $Filtrar .= "&f_inicio=".$cat['f_inicio'];}
								if(isset($cat['f_termino']) && $cat['f_termino']!=''){  $Filtrar .= "&f_termino=".$cat['f_termino'];}
								if(isset($cat['h_inicio']) && $cat['h_inicio']!=''){    $Filtrar .= "&h_inicio=".$cat['h_inicio'];}
								if(isset($cat['h_termino']) && $cat['h_termino']!=''){  $Filtrar .= "&h_termino=".$cat['h_termino'];}
								if(isset($cat['idTelemetria']) && $cat['idTelemetria']!=''){   $Filtrar .= "&idTelemetria=".$cat['idTelemetria'];}
								if(isset($cat['idGrupo']) && $cat['idGrupo']!=''){      $Filtrar .= "&idGrupo=".$cat['idGrupo'];}
								if(isset($cat['idGrafico']) && $cat['idGrafico']!=''){  $Filtrar .= "&idGrafico=".$cat['idGrafico'];}
								if(isset($cat['idEstado']) && $cat['idEstado']!=''){    $Filtrar .= "&idEstado=".$cat['idEstado'];}

								?>
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'informe_telemetria_registro_sensores_12.php?submit_filter=Filtrar'.$Filtrar; ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$cat['idTracking']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($cat['idTracking'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el tracking del equipo '.$cat['equipo'].'?'; ?>
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
