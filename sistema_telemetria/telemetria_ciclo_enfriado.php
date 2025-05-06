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
$original = "telemetria_ciclo_enfriado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){       $location .= "&f_inicio=".$_GET['f_inicio'];               $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){     $location .= "&f_termino=".$_GET['f_termino'];             $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){       $location .= "&h_inicio=".$_GET['h_inicio'];               $search .= "&h_inicio=".$_GET['h_inicio'];}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){     $location .= "&h_termino=".$_GET['h_termino'];             $search .= "&h_termino=".$_GET['h_termino'];}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){      $location .= "&idTelemetria=".$_GET['idTelemetria'];       $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['idGrupo']) && $_GET['idGrupo']!=''){         $location .= "&idGrupo=".$_GET['idGrupo'];                 $search .= "&idGrupo=".$_GET['idGrupo'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $location .= "&idCategoria=".$_GET['idCategoria'];         $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $location .= "&idProducto=".$_GET['idProducto'];           $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['CantidadPallet']) && $_GET['CantidadPallet']!=''){  $location .= "&CantidadPallet=".$_GET['CantidadPallet'];   $search .= "&CantidadPallet=".$_GET['CantidadPallet'];}
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
	require_once 'A1XRXS_sys/xrxs_form/telemetria_ciclo_enfriado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_ciclo_enfriado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_ciclo_enfriado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Ciclo Enfriado Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Ciclo Enfriado Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Ciclo Enfriado Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$SIS_query = '
telemetria_ciclo_enfriado.idTelemetria, 
telemetria_ciclo_enfriado.f_inicio, 
telemetria_ciclo_enfriado.h_inicio, 
telemetria_ciclo_enfriado.f_termino, 
telemetria_ciclo_enfriado.h_termino, 
telemetria_ciclo_enfriado.idCategoria, 
telemetria_ciclo_enfriado.idProducto, 
telemetria_ciclo_enfriado.CantidadPallet,
telemetria_listado_grupos.Nombre AS Grupo';
$SIS_join  = 'LEFT JOIN `telemetria_listado_grupos` ON telemetria_listado_grupos.idGrupo = telemetria_ciclo_enfriado.idGrupo';
$SIS_where = 'idCiclo ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'telemetria_ciclo_enfriado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//se crea filtro
$z = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
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
			<h5>Modificación Ciclo Enfriado</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php  
				//Se verifican si existen los datos
				if(isset($idTelemetria)){    $x1 = $idTelemetria;   }else{$x1 = $rowData['idTelemetria'];}
				if(isset($f_inicio)){        $x2 = $f_inicio;       }else{$x2 = $rowData['f_inicio'];}
				if(isset($h_inicio)){        $x3 = $h_inicio;       }else{$x3 = $rowData['h_inicio'];}
				if(isset($f_termino)){       $x4 = $f_termino;      }else{$x4 = $rowData['f_termino'];}
				if(isset($h_termino)){       $x5 = $h_termino;      }else{$x5 = $rowData['h_termino'];}
				if(isset($idCategoria)){     $x6 = $idCategoria;    }else{$x6 = $rowData['idCategoria'];}
				if(isset($idProducto)){      $x7 = $idProducto;     }else{$x7 = $rowData['idProducto'];}
				if(isset($CantidadPallet)){  $x8 = $CantidadPallet; }else{$x8 = $rowData['CantidadPallet'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_input_disabled('Grupos','fake_emp', $rowData['Grupo']);
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x2, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x3, 2, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x5, 2, 1);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 2, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x7, 2, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_text('CantidadPallet', 'CantidadPallet', $x8, 2);

				$Form_Inputs->form_input_hidden('idCiclo', $_GET['id'], 2);
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
$z = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
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
			<h5>Crear Ciclo Enfriado</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTelemetria)){    $x1 = $idTelemetria;   }else{$x1 = '';}
				if(isset($f_inicio)){        $x2 = $f_inicio;       }else{$x2 = '';}
				if(isset($h_inicio)){        $x3 = $h_inicio;       }else{$x3 = '';}
				if(isset($f_termino)){       $x4 = $f_termino;      }else{$x4 = '';}
				if(isset($h_termino)){       $x5 = $h_termino;      }else{$x5 = '';}
				if(isset($idCategoria)){     $x6 = $idCategoria;    }else{$x6 = '';}
				if(isset($idProducto)){      $x7 = $idProducto;     }else{$x7 = '';}
				if(isset($CantidadPallet)){  $x8 = $CantidadPallet; }else{$x8 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 2, $dbConn);
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x2, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x3, 2, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x5, 2, 1);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 2, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x7, 2, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_text('CantidadPallet', 'CantidadPallet', $x8, 2);

				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('f_ingreso', fecha_actual(), 2);

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
		case 'equipo_asc':         $order_by = 'telemetria_listado.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Equipo Ascendente'; break;
		case 'equipo_desc':        $order_by = 'telemetria_listado.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Equipo Descendente';break;
		case 'grupo_asc':          $order_by = 'telemetria_listado_grupos.Nombre ASC ';          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Grupo Ascendente'; break;
		case 'grupo_desc':         $order_by = 'telemetria_listado_grupos.Nombre DESC ';         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Grupo Descendente';break;
		case 'desde_asc':          $order_by = 'telemetria_ciclo_enfriado.f_inicio ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Desde Ascendente'; break;
		case 'desde_desc':         $order_by = 'telemetria_ciclo_enfriado.f_inicio DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Desde Descendente';break;
		case 'hasta_asc':          $order_by = 'telemetria_ciclo_enfriado.f_termino ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hasta Ascendente'; break;
		case 'hasta_desc':         $order_by = 'telemetria_ciclo_enfriado.f_termino DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hasta Descendente';break;
		case 'duracion_asc':       $order_by = 'telemetria_ciclo_enfriado.Duracion ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Duracion Ascendente'; break;
		case 'duracion_desc':      $order_by = 'telemetria_ciclo_enfriado.Duracion DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Duracion Descendente';break;
		case 'categoria_asc':      $order_by = 'sistema_variedades_categorias.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Categoria Ascendente'; break;
		case 'categoria_desc':     $order_by = 'sistema_variedades_categorias.Nombre DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Categoria Descendente';break;
		case 'producto_asc':       $order_by = 'variedades_listado.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Producto Ascendente'; break;
		case 'producto_desc':      $order_by = 'variedades_listado.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Producto Descendente';break;
		case 'cantidad_asc':       $order_by = 'telemetria_ciclo_enfriado.CantidadPallet ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cantidad Pallet Ascendente'; break;
		case 'cantidad_desc':      $order_by = 'telemetria_ciclo_enfriado.CantidadPallet DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Cantidad Pallet Descendente';break;

		default: $order_by = 'telemetria_ciclo_enfriado.f_inicio DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
	}
}else{
	$order_by = 'telemetria_ciclo_enfriado.f_inicio DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_ciclo_enfriado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){       $SIS_where .= " AND telemetria_ciclo_enfriado.f_inicio='".$_GET['f_inicio']."'";}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){     $SIS_where .= " AND telemetria_ciclo_enfriado.f_termino='".$_GET['f_termino']."'";}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){       $SIS_where .= " AND telemetria_ciclo_enfriado.h_inicio='".$_GET['h_inicio']."'";}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){     $SIS_where .= " AND telemetria_ciclo_enfriado.h_termino='".$_GET['h_termino']."'";}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){      $SIS_where .= " AND telemetria_ciclo_enfriado.idTelemetria='".$_GET['idTelemetria']."'";}
if(isset($_GET['idGrupo']) && $_GET['idGrupo']!=''){         $SIS_where .= " AND telemetria_ciclo_enfriado.idGrupo='".$_GET['idGrupo']."'";}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND telemetria_ciclo_enfriado.idCategoria='".$_GET['idCategoria']."'";}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND telemetria_ciclo_enfriado.idProducto='".$_GET['idProducto']."'";}
if(isset($_GET['CantidadPallet']) && $_GET['CantidadPallet']!=''){  $SIS_where .= " AND telemetria_ciclo_enfriado.CantidadPallet LIKE '%".EstandarizarInput($_GET['CantidadPallet'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idCiclo', 'telemetria_ciclo_enfriado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_ciclo_enfriado.idCiclo,
telemetria_ciclo_enfriado.f_inicio,
telemetria_ciclo_enfriado.f_termino,
telemetria_ciclo_enfriado.h_inicio,
telemetria_ciclo_enfriado.h_termino,
telemetria_ciclo_enfriado.CantidadPallet,
telemetria_ciclo_enfriado.Duracion,

telemetria_listado.Nombre AS Equipo,
telemetria_listado_grupos.Nombre AS Grupo,
sistema_variedades_categorias.Nombre AS ProductoCategoria,
variedades_listado.Nombre AS ProductoNombre,
core_sistemas.Nombre AS RazonSocial';
$SIS_join  = '
LEFT JOIN `telemetria_listado`             ON telemetria_listado.idTelemetria            = telemetria_ciclo_enfriado.idTelemetria
LEFT JOIN `telemetria_listado_grupos`      ON telemetria_listado_grupos.idGrupo          = telemetria_ciclo_enfriado.idGrupo
LEFT JOIN `core_sistemas`                  ON core_sistemas.idSistema                    = telemetria_ciclo_enfriado.idSistema
LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = telemetria_ciclo_enfriado.idCategoria
LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = telemetria_ciclo_enfriado.idProducto';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrCategorias = array();
$arrCategorias = db_select_array (false, $SIS_query, 'telemetria_ciclo_enfriado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategorias');

//Filtro de Búsqueda
$z = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
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

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Ciclo Enfriado</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idTelemetria)){    $x1 = $idTelemetria;   }else{$x1 = '';}
				if(isset($f_inicio)){        $x2 = $f_inicio;       }else{$x2 = '';}
				if(isset($h_inicio)){        $x3 = $h_inicio;       }else{$x3 = '';}
				if(isset($f_termino)){       $x4 = $f_termino;      }else{$x4 = '';}
				if(isset($h_termino)){       $x5 = $h_termino;      }else{$x5 = '';}
				if(isset($idCategoria)){     $x6 = $idCategoria;    }else{$x6 = '';}
				if(isset($idProducto)){      $x7 = $idProducto;     }else{$x7 = '';}
				if(isset($CantidadPallet)){  $x8 = $CantidadPallet; }else{$x8 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 1, $dbConn);
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x2, 1);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x3, 1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 1);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x5, 1, 1);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_text('CantidadPallet', 'CantidadPallet', $x8, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ciclos de Enfriado</h5>
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
							<div class="pull-left">Duracion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=duracion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=duracion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Categoria</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=categoria_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=categoria_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Producto</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=producto_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=producto_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Cantidad Pallet</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=cantidad_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=cantidad_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCategorias as $cat) { ?>
					<tr class="odd">
						<td><?php echo $cat['Equipo']; ?></td>
						<td><?php echo $cat['Grupo']; ?></td>
						<td><?php echo $cat['h_inicio'].' - '.fecha_estandar($cat['f_inicio']); ?></td>
						<td><?php echo $cat['h_termino'].' - '.fecha_estandar($cat['f_termino']); ?></td>
						<td><?php echo Cantidades($cat['Duracion'], 1); ?></td>
						<td><?php echo $cat['ProductoCategoria']; ?></td>
						<td><?php echo $cat['ProductoNombre']; ?></td>
						<td><?php echo $cat['CantidadPallet']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $cat['RazonSocial']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$cat['idCiclo']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($cat['idCiclo'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el tracking del equipo '.$cat['Equipo'].'?'; ?>
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
