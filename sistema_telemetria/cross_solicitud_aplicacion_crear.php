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
$original = "cross_solicitud_aplicacion_crear.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idSolicitud']) && $_GET['idSolicitud']!=''){        $location .= "&idSolicitud=".$_GET['idSolicitud'];        $search .= "&idSolicitud=".$_GET['idSolicitud'];}
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){          $location .= "&NSolicitud=".$_GET['NSolicitud'];          $search .= "&NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){              $location .= "&idPredio=".$_GET['idPredio'];              $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){        $location .= "&idTemporada=".$_GET['idTemporada'];        $search .= "&idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){        $location .= "&idEstadoFen=".$_GET['idEstadoFen'];        $search .= "&idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){        $location .= "&idCategoria=".$_GET['idCategoria'];        $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){          $location .= "&idProducto=".$_GET['idProducto'];          $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){  $location .= "&f_programacion=".$_GET['f_programacion'];  $search .= "&f_programacion=".$_GET['f_programacion'];}
if(isset($_GET['horaProg']) && $_GET['horaProg']!=''){              $location .= "&horaProg=".$_GET['horaProg'];              $search .= "&horaProg=".$_GET['horaProg'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){            $location .= "&idUsuario=".$_GET['idUsuario'];            $search .= "&idUsuario=".$_GET['idUsuario'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se cera la orden - paso 1
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'creacion_1';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se cera la orden - paso 2
if (!empty($_POST['submit_new_2'])){
	//Llamamos al formulario
	$form_trabajo= 'creacion_2';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se cera la orden - paso 3
if (!empty($_POST['submit_new_3'])){
	//Llamamos al formulario
	$form_trabajo= 'creacion_3';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra n los datos temporales
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se modifican los datos basicos
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'mod_base';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se modifican los datos basicos
if (!empty($_POST['submit_modBase_Tract'])){
	//Llamamos al formulario
	$form_trabajo= 'mod_base_tract';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'addCuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edit_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'editCuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'del_Cuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_tractor'])){
	//Llamamos al formulario
	$form_trabajo= 'addtractor';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edit_tractor'])){
	//Llamamos al formulario
	$form_trabajo= 'edittractor';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_trac'])){
	//Llamamos al formulario
	$form_trabajo= 'del_trac';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_material'])){
	//Llamamos al formulario
	$form_trabajo= 'addmaterial';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_material'])){
	//Llamamos al formulario
	$form_trabajo= 'del_material';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_producto'])){
	//Llamamos al formulario
	$form_trabajo= 'addproducto';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edit_producto'])){
	//Llamamos al formulario
	$form_trabajo= 'editproducto';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'del_prod';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se crea la ot
if (!empty($_GET['crear_solicitud'])){
	//Llamamos al formulario
	$form_trabajo= 'crear_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se elimina la observacion
if (!empty($_GET['del_Solicitud'])){
	//Llamamos al formulario
	$form_trabajo= 'del_Solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se clona la maquina
if (!empty($_POST['clone_Solicitud'])){
	//nueva ubicacion
	$location = $original;
	$location .='?pagina='.$_GET['pagina'];
	//Llamamos al formulario
	$form_trabajo= 'clone_Solicitud';
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
if (isset($_GET['cloned'])){      $error['cloned']      = 'sucess/Solicitud clonada correctamente';}
if (isset($_GET['notslectjob'])){ $error['notslectjob'] = 'error/No ha seleccionado un trabajo a realizar';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone_idSolicitud'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	//Busco los datos
	$rowData = db_select_data (false, 'NSolicitud, f_programacion, horaProg, f_programacion_fin, horaProg_fin', 'cross_solicitud_aplicacion_listado', '', 'idSolicitud = '.$_GET['clone_idSolicitud'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Clonar Solicitud <?php echo n_doc($_GET['NSolicitud'], 5); ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($NSolicitud)){           $x1 = $NSolicitud;           }else{$x1 = $rowData['NSolicitud'];}
					if(isset($f_programacion)){       $x2 = $f_programacion;       }else{$x2 = $rowData['f_programacion'];}
					if(isset($horaProg)){             $x3 = $horaProg;             }else{$x3 = $rowData['horaProg'];}
					if(isset($f_programacion_fin)){   $x4 = $f_programacion_fin;   }else{$x4 = $rowData['f_programacion_fin'];}
					if(isset($horaProg_fin)){         $x5 = $horaProg_fin;         }else{$x5 = $rowData['horaProg_fin'];}
					if(isset($Observaciones)){        $x6 = $Observaciones;        }else{$x6 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_values('Numero de solicitud','NSolicitud', $x1, 2);
					$Form_Inputs->form_date('Fecha inicio requerido','f_programacion', $x2, 2);
					$Form_Inputs->form_time('Hora inicio requerido','horaProg', $x3, 2, 1);
					$Form_Inputs->form_date('Fecha termino requerido','f_programacion_fin', $x4, 2);
					$Form_Inputs->form_time('Hora termino requerido','horaProg_fin', $x5, 2, 1);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['clone_idSolicitud'], 2);
					$Form_Inputs->form_input_hidden('NSolicitudOld', $rowData['NSolicitud'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c5; Clonar" name="clone_Solicitud">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_Cuarteles'])){
	//Verifico el tipo de usuario que esta ingresando
	$z ="idPredio=".$_SESSION['sol_apli_basicos']['idPredio'];
	$z.=" AND idEstado=1 ";
	if(isset($_SESSION['sol_apli_basicos']['idCategoria'])&&$_SESSION['sol_apli_basicos']['idCategoria']!=''){ $z.=" AND idCategoria=".$_SESSION['sol_apli_basicos']['idCategoria'];}
	if(isset($_SESSION['sol_apli_basicos']['idProducto'])&&$_SESSION['sol_apli_basicos']['idProducto']!=''){   $z.=" AND idProducto=".$_SESSION['sol_apli_basicos']['idProducto'];}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Cuartel</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idZona)){         $x1  = $idZona;        }else{$x1  = $_SESSION['sol_apli_cuarteles'][$_GET['cuartel_id']]['idZona'];}
					/*if(isset($Mojamiento)){     $x2  = $Mojamiento;    }else{$x2  = Cantidades_decimales_justos($_SESSION['sol_apli_cuarteles'][$_GET['cuartel_id']]['Mojamiento']);}
					if(isset($VelTractor)){     $x3  = $VelTractor;    }else{$x3  = Cantidades_decimales_justos($_SESSION['sol_apli_cuarteles'][$_GET['cuartel_id']]['VelTractor']);}
					if(isset($VelViento)){      $x4  = $VelViento;     }else{$x4  = Cantidades_decimales_justos($_SESSION['sol_apli_cuarteles'][$_GET['cuartel_id']]['VelViento']);}
					if(isset($TempMin)){        $x5  = $TempMin;       }else{$x5  = Cantidades_decimales_justos($_SESSION['sol_apli_cuarteles'][$_GET['cuartel_id']]['TempMin']);}
					if(isset($TempMax)){        $x6  = $TempMax;       }else{$x6  = Cantidades_decimales_justos($_SESSION['sol_apli_cuarteles'][$_GET['cuartel_id']]['TempMax']);}*/

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Identificación cuartel');
					$Form_Inputs->form_select_filter('Cuartel','idZona', $x1, 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', $z, '', $dbConn);

					/*
					$Form_Inputs->form_tittle(3, 'Parámetros de Aplicación');
					$Form_Inputs->form_input_number_spinner('Mojamiento L/ha','Mojamiento', $x2, 0, 10000, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Tractor Km/hr','VelTractor', $x3, 0, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Viento Km/hr','VelViento', $x4, 0, 500, '0.001', 3, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura minima','TempMin', $x5, -20, 500, '0.01', 2, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura maxima','TempMax', $x6, -20, 500, '0.01', 2, 2);*/

					$Form_Inputs->form_input_hidden('idInterno', $_GET['cuartel_id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_cuartel">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif ( isset($_GET['edit_prod'])&&$_GET['edit_prod']!='' ) {
	//consulto
	$SIS_query = '
	productos_listado.idProducto,
	productos_listado.DosisRecomendada,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'idProducto ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Producto Químico</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){     $x1  = $idProducto;    }else{$x1  = $_SESSION['sol_apli_productos'][$_GET['cuartel_id']][$_GET['edit_prod']]['idProducto'];}
					if(isset($DosisAplicar)){   $x2  = $DosisAplicar;  }else{$x2  = $_SESSION['sol_apli_productos'][$_GET['cuartel_id']][$_GET['edit_prod']]['DosisAplicar'];}
					if(isset($Objetivo)){       $x3  = $Objetivo;      }else{$x3  = $_SESSION['sol_apli_productos'][$_GET['cuartel_id']][$_GET['edit_prod']]['Objetivo'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Producto Químico a aplicar');
					$Form_Inputs->form_select_filter('Producto Químico','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_disabled( 'Dosis Recomendada', 'escribeme1', 0);
					$Form_Inputs->form_input_number_spinner('Dosis a aplicar','DosisAplicar', $x2, 0, 2000, '0.01', 2, 2);
					$Form_Inputs->form_input_disabled( 'Unidad de medida', 'escribeme2', 0);
					$Form_Inputs->form_textarea('Objetivo','Objetivo', $x3, 1);

					$Form_Inputs->form_input_hidden('idInterno', $_GET['cuartel_id'], 2);
					$Form_Inputs->form_input_hidden('idInterno3', $_GET['edit_prod'], 2);
					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['DosisRecomendada']).'";';
							echo 'let id_med_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						$(document).ready(function(){
							LoadProducto();
						});

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme1").value = eval("id_data_" + Componente);
								document.getElementById("escribeme2").value = eval("id_med_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_producto">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['add_prod'])){
	//consulto
	$SIS_query = '
	productos_listado.idProducto,
	productos_listado.DosisRecomendada,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'idProducto ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Producto Químico</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){     $x1  = $idProducto;    }else{$x1  = '';}
					if(isset($DosisAplicar)){   $x2  = $DosisAplicar;  }else{$x2  = '';}
					if(isset($Objetivo)){       $x3  = $Objetivo;      }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Producto Químico a aplicar');
					$Form_Inputs->form_select_filter('Producto Químico','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_disabled( 'Dosis Recomendada', 'escribeme1', 0);
					$Form_Inputs->form_input_number_spinner('Dosis a aplicar','DosisAplicar', $x2, 0, 2000, '0.01', 2, 2);
					$Form_Inputs->form_input_disabled( 'Unidad de medida', 'escribeme2', 0);
					$Form_Inputs->form_textarea('Objetivo','Objetivo', $x3, 1);

					$Form_Inputs->form_input_hidden('idInterno', $_GET['cuartel_id'], 2);
					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['DosisRecomendada']).'";';
							echo 'let id_med_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						$(document).ready(function(){
							LoadProducto();
						});

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme1").value = eval("id_data_" + Componente);
								document.getElementById("escribeme2").value = eval("id_med_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_producto">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} elseif ( isset($_GET['edit_trac'])&&$_GET['edit_trac']!='' ) {
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$w .= " AND telemetria_listado.idTab=1";//Agro-Checking
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Tractor</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idVehiculo)){     $x1  = $idVehiculo;    }else{$x1  =  $_SESSION['sol_apli_tractores'][$_GET['cuartel_id']][$_GET['edit_trac']]['idVehiculo'];}
					if(isset($idTelemetria)){   $x2  = $idTelemetria;  }else{$x2  =  $_SESSION['sol_apli_tractores'][$_GET['cuartel_id']][$_GET['edit_trac']]['idTelemetria'];}
					if(isset($idTrabajador)){   $x3  = $idTrabajador;  }else{$x3  =  $_SESSION['sol_apli_tractores'][$_GET['cuartel_id']][$_GET['edit_trac']]['idTrabajador'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Tractor');
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_select_filter('Equipo Aplicacion','idVehiculo', $x1, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Asignado','idTrabajador', $x3, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $x, '', $dbConn);

					$Form_Inputs->form_input_hidden('idInterno', $_GET['cuartel_id'], 2);
					$Form_Inputs->form_input_hidden('idInterno2', $_GET['edit_trac'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_tractor">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['add_trac'])){
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$w .= " AND telemetria_listado.idTab=1";//Agro-Checking
	}
	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Tractor</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idVehiculo)){     $x1  = $idVehiculo;    }else{$x1  = '';}
					if(isset($idTelemetria)){   $x2  = $idTelemetria;  }else{$x2  = '';}
					if(isset($idTrabajador)){   $x3  = $idTrabajador;  }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Tractor');
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_select_filter('Equipo Aplicacion','idVehiculo', $x1, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Asignado','idTrabajador', $x3, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $x, '', $dbConn);

					$Form_Inputs->form_input_hidden('idInterno', $_GET['cuartel_id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_tractor">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addMaterial'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Material de Seguridad</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idMatSeguridad)){     $x1  = $idMatSeguridad;    }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Material de Seguridad','idMatSeguridad', $x1, 2, 'idMatSeguridad', 'Nombre', 'cross_checking_materiales_seguridad', 'idEstado=1', '', $dbConn);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_material">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addCuartel'])){
	//filtros para los cuarteles
	$z ="idPredio=".$_SESSION['sol_apli_basicos']['idPredio'];
	$z.=" AND idEstado=1 ";
	if(isset($_SESSION['sol_apli_basicos']['idCategoria'])&&$_SESSION['sol_apli_basicos']['idCategoria']!=''){ $z.=" AND idCategoria=".$_SESSION['sol_apli_basicos']['idCategoria'];}
	if(isset($_SESSION['sol_apli_basicos']['idProducto'])&&$_SESSION['sol_apli_basicos']['idProducto']!=''){   $z.=" AND idProducto=".$_SESSION['sol_apli_basicos']['idProducto'];}

	//Variable filtro
	$x="idEstado=1 ";
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']."  AND telemetria_listado.idEstado=1";
	$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$m = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Verifico el tipo de usuario
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$w .= " AND telemetria_listado.idTab=1";//Agro-Checking
	}
	//se dibujan los inputs
	$Form_Inputs = new Inputs();
	/**************************************************************/
	//cuarteles filtrados
	$SIS_query = 'idZona,Codigo,Hectareas,Hileras,DistanciaPlant,DistanciaHileras';
	$SIS_join  = '';
	$SIS_where = $z;
	$SIS_order = 'Nombre ASC';
	$arrCuenta = array();
	$arrCuenta = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCuenta');

	/**************************************************************/
	//tractores filtrados
	$SIS_query = 'idVehiculo';
	$SIS_join  = '';
	$SIS_where = $y;
	$SIS_order = '';
	$arrCuenta2 = array();
	$arrCuenta2 = db_select_array (false, $SIS_query, 'vehiculos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCuenta2');

	/**************************************************************/
	//Producto filtrados
	$SIS_query  = '
	productos_listado.idProducto,
	productos_listado.DosisRecomendada,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = $x;
	$SIS_order = 'idProducto ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
					<h5>Agregar Trabajos</h5>
				</header>
				<div class="body">

					<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
						<h3>Parámetros de Aplicación</h3>
						<div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Mojamiento L/ha'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Mojamiento L/ha','Mojamiento', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['Mojamiento']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Velocidad Tractor Km/hr'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Velocidad Tractor Km/hr','VelTractor', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelTractor']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Velocidad Viento Km/hr'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Velocidad Viento Km/hr','VelViento', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelViento']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'T° Minima'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('T° Minima','TempMin', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMin']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'T° Maxima'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('T° Maxima','TempMax', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMax']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Humedad'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Humedad','HumTempMax', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['HumTempMax']), 2); ?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Cuarteles</h3>
							<a onclick="cuartel_all_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Todos Cuarteles</a>
							<a onclick="cuartel_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Cuarteles</a>
						</div>

						<div class="clearfix"></div>
						<div id="insert_cuartel"></div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Productos Quimicos</h3>
							<a onclick="producto_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Productos</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_producto"></div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Tractores</h3>
							<a onclick="tractor_all_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Todos Tractores</a>
							<a onclick="tractor_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Tractores</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_tractor"></div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Materiales de Seguridad</h3>
							<a onclick="material_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Materiales</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_material"></div>

						<div class="form-group" style="margin-top:10px;">
							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_cuartel">
							<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
						</div>

					</form>
					<?php widget_validator(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div style="display: none;">

		<div id="clone_cuartel" class="cuartel_container">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->select_change('Cuarteles','idZona[]', 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', $z,'', 'ChangePredio',$dbConn); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Codigo', 'escribeme1', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Hectareas', 'escribeme2', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Hileras', 'escribeme3', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Dist Plantas', 'escribeme4', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->input_disabled('text', 'Dist Hileras', 'escribeme5', 0, 1); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_cuartel" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="clone_producto" class="prod_container">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->select_change('Producto Químico','idProducto[]', 2, 'idProducto', 'Nombre', 'productos_listado', $x,'', 'OnSelectionChange',$dbConn); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Dosis Recomendada', 'escribeme1', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_number('Dosis a aplicar','DosisAplicar[]', '', 2); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Unidad de medida', 'escribeme2', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->input('text','Objetivo','Objetivo[]', '', 1); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_producto" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="clone_tractor">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
				<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->select('Tractor','idTelemetria[]', '',2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w,'', $dbConn);
				}else{
					$Form_Inputs->select_bodega('Tractor','idTelemetria[]', '', 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
				} ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->select('Equipo Aplicacion','idVehiculo[]', '',2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $y,'', $dbConn); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->select('Trabajador Asignado','idTrabajador[]', '',2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $m,'', $dbConn); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_tractor" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="clone_material">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->select('Material de Seguridad','idMatSeguridad[]', '',2, 'idMatSeguridad', 'Nombre', 'cross_checking_materiales_seguridad', 'idEstado=1','', $dbConn); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_material" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

	</div>
	<div class="clearfix"></div>

	<script>

		let room1 = 0;
		let room2 = 0;
		let room3 = 0;
		let room4 = 0;
		let incre = 0;
		let incr2 = 0;

		/**********************************************************/
		//Se agrega cuartel
		function cuartel_add() {
			//se incrementa en 1
			room1++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_cuartel');
			let objclone = document.getElementById('clone_cuartel'),
			//se clonan los div
			clone_cuartel = objclone.cloneNode(true);
			clone_cuartel.id = 'new_cuartel_'+room1;
			//inserto dentro del div deseado
			objTo.appendChild(clone_cuartel);
		}

		//Se agrega cuartel
		function cuartel_add_2() {
			//se incrementa en 1
			room1++;
			incre++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_cuartel');
			let objclone = document.getElementById('clone_cuartel'),
			//se clonan los div
			clone_cuartel = objclone.cloneNode(true);
			clone_cuartel.id = 'new_cuartel_'+room1;
			//inserto dentro del div deseado
			objTo.appendChild(clone_cuartel);
			//Autoselecciono los items
			let div = document.getElementById('new_cuartel_'+room1);
			if (div) {
				div.querySelector('select').selectedIndex = incre;
				let subdiv = div.querySelector('select');
				ChangePredio (subdiv);
			}
		}
		//Se agregan todos los cuarteles
		function cuartel_all_add() {
			<?php foreach ($arrCuenta as $cc) { ?>
				cuartel_add_2();
			<?php } ?>
		}
		//se eliminan filas
		$(document).on('click', '.remove_cuartel', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/**********************************************************/
		//Se agrega producto
		function producto_add(){
			//se incrementa en 1
			room2++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_producto');
			let objclone = document.getElementById('clone_producto'),
			//se clonan los div
			clone_producto = objclone.cloneNode(true);
			clone_producto.id = 'new_producto_'+room2;
			//inserto dentro del div deseado
			objTo.appendChild(clone_producto);
		}
		//se eliminan filas
		$(document).on('click', '.remove_producto', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/**********************************************************/
		//Se agrega tractor
		function tractor_add() {
			//se incrementa en 1
			room3++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_tractor');
			let objclone = document.getElementById('clone_tractor'),
			//se clonan los div
			clone_tractor = objclone.cloneNode(true);
			clone_tractor.id = 'new_tractor_'+room3;
			//inserto dentro del div deseado
			objTo.appendChild(clone_tractor);
		}
		//Se agrega cuartel
		function tractor_add_2() {
			//se incrementa en 1
			room3++;
			incr2++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_tractor');
			let objclone = document.getElementById('clone_tractor'),
			//se clonan los div
			clone_tractor = objclone.cloneNode(true);
			clone_tractor.id = 'new_tractor_'+room3;
			//inserto dentro del div deseado
			objTo.appendChild(clone_tractor);
			//Autoselecciono los items
			let div = document.getElementById('new_tractor_'+room3);
			if (div) {
				div.querySelector('select').selectedIndex = incr2;
				let subdiv = div.querySelector('select');
				//ChangeTractor (subdiv);
			}
		}
		//Se agregan todos los cuarteles
		function tractor_all_add() {
			<?php foreach ($arrCuenta2 as $cc) { ?>
				tractor_add_2();
			<?php } ?>
		}
		//se eliminan filas
		$(document).on('click', '.remove_tractor', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/**********************************************************/
		//Se agrega tractor
		function material_add() {
			//se incrementa en 1
			room4++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_material');
			let objclone = document.getElementById('clone_material'),
			//se clonan los div
			clone_material = objclone.cloneNode(true);
			clone_material.id = 'new_material_'+room4;
			//inserto dentro del div deseado
			objTo.appendChild(clone_material);
		}
		//se eliminan filas
		$(document).on('click', '.remove_material', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/****************************************************************************************/
		/**********************************************************/
		//se ejecuta al cambiar
		function OnSelectionChange (select) {
			//variables varias
			<?php
			//recorro
			foreach ($arrTipo as $tipo) {
				echo 'let id_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['DosisRecomendada']).'";';
				echo 'let id_med_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
			}
			?>
			let Componente = select.options[select.selectedIndex].value;
			if (Componente != "") {
				//escribo dentro del input
				$(select).closest('.prod_container').find('.escribeme1').val(eval("id_data_" + Componente));
				$(select).closest('.prod_container').find('.escribeme2').val(eval("id_med_" + Componente));
			}
		}
		/**********************************************************/
		//se ejecuta al cambiar
		function ChangePredio (select) {
			//variables varias
			<?php
			foreach ($arrCuenta as $tipo) {
				echo 'let id_codigo_'.$tipo['idZona'].'= "'.$tipo['Codigo'].'";';
				echo 'let id_hectarea_'.$tipo['idZona'].'= "'.Cantidades_decimales_justos($tipo['Hectareas']).'";';
				echo 'let id_hilera_'.$tipo['idZona'].'= "'.$tipo['Hileras'].'";';
				echo 'let id_distancia_p_'.$tipo['idZona'].'= "'.Cantidades_decimales_justos($tipo['DistanciaPlant']).'";';
				echo 'let id_distancia_h_'.$tipo['idZona'].'= "'.Cantidades_decimales_justos($tipo['DistanciaHileras']).'";';
			}
			?>
			let Componente = select.options[select.selectedIndex].value;
			if (Componente != "") {
				//escribo dentro del input
				$(select).closest('.cuartel_container').find('.escribeme1').val('Cod: '+eval("id_codigo_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme2').val('Hect: '+eval("id_hectarea_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme3').val('Hil: '+eval("id_hilera_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme4').val('D Plantas: '+eval("id_distancia_p_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme5').val('D Hileras: '+eval("id_distancia_h_" + Componente));
			}
		}
	</script>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modTrac'])){  ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar Parámetros de Aplicacion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Mojamiento)){    $x0 = $Mojamiento;    }else{$x0 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['Mojamiento']);}
					if(isset($VelTractor)){    $x1 = $VelTractor;    }else{$x1 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelTractor']);}
					if(isset($VelViento)){     $x2 = $VelViento;     }else{$x2 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelViento']);}
					if(isset($TempMin)){       $x3 = $TempMin;       }else{$x3 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMin']);}
					if(isset($TempMax)){       $x4 = $TempMax;       }else{$x4 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMax']);}
					if(isset($HumTempMax)){    $x5 = $HumTempMax;    }else{$x5 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['HumTempMax']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Parámetros de Aplicación');
					$Form_Inputs->form_input_number_spinner('Mojamiento L/ha','Mojamiento', $x0, 0, 10000, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Tractor Km/hr','VelTractor', $x1, 0, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Viento Km/hr','VelViento', $x2, 0, 50, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura minima','TempMin', $x3, -20, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura maxima','TempMax', $x4, -20, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Humedad','HumTempMax', $x5, -20, 500, '0.1', 1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase_Tract">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
	//Verifico el tipo de usuario que esta ingresando
	$y = "idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	/*************************************************************/
	//filtro
	$zx1 = "idCategoria=0";
	$zx2 = "idProducto=0";
	/************************************/
	//Se revisan los permisos a las especies
	$SIS_query = 'idCategoria';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idCategoria ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_variedades_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//recorro
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idCategoria=".$prod['idCategoria'].")";
	}
	/************************************/
	//Se revisan los permisos a las variantes
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_variedades_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//recorro
	foreach ($arrPermisos as $prod) {
		$zx2 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar la Solicitud de Aplicacion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($NSolicitud)){           $x1  = $NSolicitud;           }else{$x1  = $_SESSION['sol_apli_basicos']['NSolicitud'];}
					if(isset($idPrioridad)){          $x2  = $idPrioridad;          }else{$x2  = $_SESSION['sol_apli_basicos']['idPrioridad'];}
					if(isset($idPredio)){             $x3  = $idPredio;             }else{$x3  = $_SESSION['sol_apli_basicos']['idPredio'];}
					if(isset($idTemporada)){          $x4  = $idTemporada;          }else{$x4  = $_SESSION['sol_apli_basicos']['idTemporada'];}
					if(isset($idEstadoFen)){          $x5  = $idEstadoFen;          }else{$x5  = $_SESSION['sol_apli_basicos']['idEstadoFen'];}
					if(isset($idCategoria)){          $x6  = $idCategoria;          }else{$x6  = $_SESSION['sol_apli_basicos']['idCategoria'];}
					if(isset($idProducto)){           $x7  = $idProducto;           }else{$x7  = $_SESSION['sol_apli_basicos']['idProducto'];}
					if(isset($f_programacion)){       $x8  = $f_programacion;       }else{$x8  = $_SESSION['sol_apli_basicos']['f_programacion'];}
					if(isset($horaProg)){             $x9  = $horaProg;             }else{$x9  = $_SESSION['sol_apli_basicos']['horaProg'];}
					if(isset($f_programacion_fin)){   $x10 = $f_programacion_fin;   }else{$x10 = $_SESSION['sol_apli_basicos']['f_programacion_fin'];}
					if(isset($horaProg_fin)){         $x11 = $horaProg_fin;         }else{$x11 = $_SESSION['sol_apli_basicos']['horaProg_fin'];}
					if(isset($Observaciones)){        $x12 = $Observaciones;        }else{$x12 = $_SESSION['sol_apli_basicos']['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_values('Numero de solicitud','NSolicitud', $x1, 2);
					$Form_Inputs->form_select('Prioridad','idPrioridad', $x2, 2, 'idPrioridad', 'Nombre', 'core_cross_prioridad', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Predio','idPredio', $x3, 2, 'idPredio', 'Nombre', 'cross_predios_listado', $z, '', $dbConn);
					$Form_Inputs->form_select_filter('Temporada','idTemporada', $x4, 2, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
					$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x5, 2, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', $zx1, 0,
											'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', $zx2, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_date('Fecha inicio requerido','f_programacion', $x8, 2);
					$Form_Inputs->form_time('Hora inicio requerido','horaProg', $x9, 2, 1);
					$Form_Inputs->form_date('Fecha termino requerido','f_programacion_fin', $x10, 2);
					$Form_Inputs->form_time('Hora termino requerido','horaProg_fin', $x11, 2, 1);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x12, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){ ?>

	<?php
	if(isset($_SESSION['sol_apli_basicos']['Carencias'])&&$_SESSION['sol_apli_basicos']['Carencias']!=''){
		echo alert_post_data(4,1,1,0, $_SESSION['sol_apli_basicos']['Carencias']);
	}
	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<div class="btn-group pull-right" role="group" aria-label="...">

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los datos de la Solicitud en curso?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>
											
			<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

			<?php
			$ubicacion = $location.'&view=true&crear_solicitud=true';
			$dialogo   = '¿Desea generar una nueva solicitud?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary"><i class="fa fa-check-square-o" aria-hidden="true"></i> Generar Nueva Solicitud</a>

		</div>
		<div class="clearfix"></div>
	</div> 


	<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive" style="margin-bottom:30px">

		<div id="page-wrap">
			<div id="header"> SOLICITUD DE APLICACIONES</div>
			<div id="customer">
				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>
						<tr>
							<td class="meta-head">N° Solicitud</td>
							<td><?php echo $_SESSION['sol_apli_basicos']['NSolicitud']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Prioridad</td>
							<td><?php echo $_SESSION['sol_apli_basicos']['Prioridad']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Predio</td>
							<td><?php echo $_SESSION['sol_apli_basicos']['Predio']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Temporada</td>
							<td><?php echo $_SESSION['sol_apli_basicos']['Temporada']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Estado Fenológico</td>
							<td><?php echo $_SESSION['sol_apli_basicos']['EstadoFen']; ?></td>
						</tr>
						<?php if(isset($_SESSION['sol_apli_basicos']['EspecieVariedad'])&&$_SESSION['sol_apli_basicos']['EspecieVariedad']!=''){ ?>
							<tr>
								<td class="meta-head">Especie - Variedad</td>
								<td><?php echo $_SESSION['sol_apli_basicos']['EspecieVariedad']; ?></td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td class="meta-head">Especie - Variedad</td>
								<td>Todas las Especies - Variedades</td>
							</tr>
						<?php } ?>
						<tr>
							<td class="meta-head"><strong>PARAMETROS APLICACION</strong></td>
							<td class="meta-head"><a href="<?php echo $location.'&modTrac=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>
						<tr>
							<td class="meta-head">Mojamiento</td>
							<td><?php if(isset($_SESSION['sol_apli_basicos']['Mojamiento'])&&$_SESSION['sol_apli_basicos']['Mojamiento']!=''){echo $_SESSION['sol_apli_basicos']['Mojamiento'].' L/ha';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Velocidad Tractor</td>
							<td><?php if(isset($_SESSION['sol_apli_basicos']['VelTractor'])&&$_SESSION['sol_apli_basicos']['VelTractor']!=''){echo $_SESSION['sol_apli_basicos']['VelTractor'].' Km/hr';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Velocidad Viento</td>
							<td><?php if(isset($_SESSION['sol_apli_basicos']['VelViento'])&&$_SESSION['sol_apli_basicos']['VelViento']!=''){echo $_SESSION['sol_apli_basicos']['VelViento'].' Km/hr';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Temperatura Min</td>
							<td><?php if(isset($_SESSION['sol_apli_basicos']['TempMin'])&&$_SESSION['sol_apli_basicos']['TempMin']!=''){echo $_SESSION['sol_apli_basicos']['TempMin'].' °';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Temperatura Max</td>
							<td><?php if(isset($_SESSION['sol_apli_basicos']['TempMax'])&&$_SESSION['sol_apli_basicos']['TempMax']!=''){echo $_SESSION['sol_apli_basicos']['TempMax'].' °';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Humedad</td>
							<td><?php if(isset($_SESSION['sol_apli_basicos']['HumTempMax'])&&$_SESSION['sol_apli_basicos']['HumTempMax']!=''){echo $_SESSION['sol_apli_basicos']['HumTempMax'].' %';} ?></td>
						</tr>
					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>
						<tr>
							<td class="meta-head">Fecha inicio requerido</td>
							<td><?php echo Fecha_estandar($_SESSION['sol_apli_basicos']['f_programacion']).' '.$_SESSION['sol_apli_basicos']['horaProg']?></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha termino requerido</td>
							<td><?php echo Fecha_estandar($_SESSION['sol_apli_basicos']['f_programacion_fin']).' '.$_SESSION['sol_apli_basicos']['horaProg_fin']?></td>
						</tr>

					</tbody>
				</table>
			</div>
			<table id="items">
				<tbody>

					<tr>
						<th colspan="8">Detalle</th>
						<th width="160">Acciones</th>
					</tr>
						
					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="6"><strong>Materiales de Seguridad</strong></td>
						<td colspan="2"><strong>Codigo</strong></td>
						<td>
							<?php if(isset($_SESSION['sol_apli_basicos']['Mojamiento'])&&$_SESSION['sol_apli_basicos']['Mojamiento']!=''&&$_SESSION['sol_apli_basicos']['Mojamiento']!=0){ ?>
								<?php if(isset($_SESSION['sol_apli_materiales'])&&$_SESSION['sol_apli_materiales']!=''){ ?>
									<a href="<?php echo $location.'&addMaterial=true' ?>" title="Agregar Materiales" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Materiales</a>
								<?php } ?>
							<?php } ?>
						</td>
					</tr>
					<?php
					//recorro el lsiatdo entregado por la base de datos
					if(isset($_SESSION['sol_apli_materiales'])&&$_SESSION['sol_apli_materiales']!=''){
						foreach ($_SESSION['sol_apli_materiales'] as $key => $material){ ?>

							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="6"><i class="fa fa-eyedropper" aria-hidden="true"></i> <?php echo $material['Nombre']; ?></td>
								<td class="item-name" colspan="2"><?php echo $material['Codigo']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php
										$ubicacion = $location.'&del_material='.$material['valor_id'];
										$dialogo   = '¿Realmente deseas eliminar el material de seguridad '.$material['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Cuartel" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
									</div>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>

					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td><strong>Cuarteles</strong></td>
						<td><strong>Variedad - Especie</strong></td>
						<td><strong>Mojamiento</strong></td>
						<td><strong>Vel. Tractor</strong></td>
						<td><strong>Vel. Viento</strong></td>
						<td><strong>Temp Min</strong></td>
						<td><strong>Temp Max</strong></td>
						<td><strong>Hum Temp Max</strong></td>
						<td>
							<?php if(isset($_SESSION['sol_apli_basicos']['Mojamiento'])&&$_SESSION['sol_apli_basicos']['Mojamiento']!=''&&$_SESSION['sol_apli_basicos']['Mojamiento']!=0){ ?>
								<a href="<?php echo $location.'&addCuartel=true' ?>" title="Agregar Trabajos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Trabajos</a>
							<?php } ?>
						</td>
					</tr>
					<?php
					//recorro el lsiatdo entregado por la base de datos
					if(isset($_SESSION['sol_apli_cuarteles'])&&$_SESSION['sol_apli_cuarteles']!=''){
						foreach ($_SESSION['sol_apli_cuarteles'] as $key => $cuartel){ ?>

							<tr class="item-row linea_punteada" style="background: #eee;">
								<td class="item-name"><?php echo $cuartel['CuartelNombre']; ?></td>
								<td class="item-name"><?php echo $cuartel['CuartelEspecie'].' '.$cuartel['CuartelVariedad']; ?></td>
								<td class="item-name"><?php echo $cuartel['Mojamiento'].' L/ha'; ?></td>
								<td class="item-name"><?php echo $cuartel['VelTractor'].' Km/hr'; ?></td>
								<td class="item-name"><?php echo $cuartel['VelViento'].' Km/hr'; ?></td>
								<td class="item-name"><?php echo $cuartel['TempMin'].' °'; ?></td>
								<td class="item-name"><?php echo $cuartel['TempMax'].' °'; ?></td>
								<td class="item-name"><?php echo $cuartel['HumTempMax'].' %'; ?></td>
								<td>
									<div class="btn-group" style="width: 140px;" >
										<a href="<?php echo $location.'&cuartel_id='.$cuartel['valor_id'].'&edit_Cuarteles=true'; ?>" title="Editar Cuartel" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<a href="<?php echo $location.'&cuartel_id='.$cuartel['valor_id'].'&add_trac=true'; ?>" title="Agregar Tractor" class="btn btn-primary btn-sm tooltip"><i class="fa fa-truck" aria-hidden="true"></i></a>
										<a href="<?php echo $location.'&cuartel_id='.$cuartel['valor_id'].'&add_prod=true'; ?>" title="Agregar Producto Químico" class="btn btn-primary btn-sm tooltip"><i class="fa fa-flask" aria-hidden="true"></i></a>
										<?php
										$ubicacion = $location.'&del_cuartel='.$cuartel['valor_id'];
										$dialogo   = '¿Realmente deseas eliminar el cuartel '.$cuartel['CuartelNombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Cuartel" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
									</div>
								</td>
							</tr>

							<?php 
							/****************************************************************/
							if($_SESSION['sol_apli_tractores'][$cuartel['valor_id']]){
								//Se recorren los tractores
								foreach ($_SESSION['sol_apli_tractores'][$cuartel['valor_id']] as $key => $tract){
									?>

									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="2"><i class="fa fa-truck" aria-hidden="true"></i> <?php echo '<strong>Tractor: </strong>'.$tract['Telemetria']; ?></td>
										<td class="item-name" colspan="4"><?php echo '<strong>Equipo Aplicación: </strong>'.$tract['Vehiculo']; ?></td>
										<td class="item-name" colspan="2"><?php echo '<strong>Trabajador: </strong>'.$tract['Trabajador']; ?></td>
										<td>
											<div class="btn-group" style="width: 70px;" >
												<a href="<?php echo $location.'&cuartel_id='.$cuartel['valor_id'].'&edit_trac='.$tract['valor_id']; ?>" title="Editar Tractor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<?php 
												$ubicacion = $location.'&cuartel_id='.$cuartel['valor_id'].'&del_trac='.$tract['valor_id'];
												$dialogo   = '¿Realmente deseas eliminar el tractor '.$tract['Vehiculo'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Tractor" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
											</div>
										</td>
									</tr>
					
								<?php
								}
							}
							/****************************************************************/
							if($_SESSION['sol_apli_productos'][$cuartel['valor_id']]){
								//Se recorren los quimicos a utilizar
								foreach ($_SESSION['sol_apli_productos'][$cuartel['valor_id']] as $key => $prod){ ?>

									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="5">
											<i class="fa fa-flask" aria-hidden="true"></i>
											<?php echo '<strong>Producto Químico: </strong>'.$prod['Producto']; ?><br/>
											<?php echo '<strong>Objetivo: </strong>'.$prod['Objetivo']; ?><br/>
										</td>
										<td class="item-name" colspan="3">
											<?php echo '<strong>Dosis Recomendada: </strong>'.Cantidades_decimales_justos($prod['DosisRecomendada']).' '.$prod['Unimed']; ?><br/>
											<?php echo '<strong>Dosis a aplicar: </strong>'.Cantidades_decimales_justos($prod['DosisAplicar']).' '.$prod['Unimed']; ?><br/>
										</td>
										<td>
											<div class="btn-group" style="width: 70px;" >
												<a href="<?php echo $location.'&cuartel_id='.$cuartel['valor_id'].'&edit_prod='.$prod['valor_id']; ?>" title="Editar Producto Quimico" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<?php 
												$ubicacion = $location.'&cuartel_id='.$cuartel['valor_id'].'&del_prod='.$prod['valor_id'];
												$dialogo   = '¿Realmente deseas eliminar el producto '.$prod['Producto'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
											</div>
										</td>
									</tr>
							
								<?php
								}
							}
						}
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="8">No hay cuarteles asignados</td></tr>';
					} ?>

				</tbody>
			</table>
		</div>

		<div class="col-xs-12">
			<div class="row">
				<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['sol_apli_basicos']['Observaciones']; ?></p>
			</div>
		</div>

	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new_3'])){
	//filtros para los cuarteles
	$z ="idPredio=".$_SESSION['sol_apli_basicos']['idPredio'];
	$z.=" AND idEstado=1 ";
	if(isset($_SESSION['sol_apli_basicos']['idCategoria'])&&$_SESSION['sol_apli_basicos']['idCategoria']!=''){ $z.=" AND idCategoria=".$_SESSION['sol_apli_basicos']['idCategoria'];}
	if(isset($_SESSION['sol_apli_basicos']['idProducto'])&&$_SESSION['sol_apli_basicos']['idProducto']!=''){   $z.=" AND idProducto=".$_SESSION['sol_apli_basicos']['idProducto'];}

	//Variable filtro
	$x="idEstado=1 ";
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']."  AND telemetria_listado.idEstado=1";
	$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$m = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Verifico el tipo de usuario
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$w .= " AND telemetria_listado.idTab=1";//Agro-Checking
	}
	//se dibujan los inputs
	$Form_Inputs = new Inputs();
	/**************************************************************/
	//cuarteles filtrados
	$SIS_query = 'idZona,Codigo,Hectareas,Hileras,DistanciaPlant,DistanciaHileras';
	$SIS_join  = '';
	$SIS_where = $z;
	$SIS_order = 'Nombre ASC';
	$arrCuenta = array();
	$arrCuenta = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCuenta');

	/**************************************************************/
	//tractores filtrados
	$SIS_query = 'idVehiculo';
	$SIS_join  = '';
	$SIS_where = $y;
	$SIS_order = '';
	$arrCuenta2 = array();
	$arrCuenta2 = db_select_array (false, $SIS_query, 'vehiculos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCuenta2');

	/**************************************************************/
	//Producto filtrados
	$SIS_query  = '
	productos_listado.idProducto,
	productos_listado.DosisRecomendada,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = $x;
	$SIS_order = 'idProducto ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
					<h5>Generar Nueva Solicitud de Aplicacion - PASO 3</h5>
				</header>
				<div class="body">

					<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
						<h3>Parámetros de Aplicación</h3>
						<div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Mojamiento L/ha'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Mojamiento L/ha','Mojamiento', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['Mojamiento']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Velocidad Tractor Km/hr'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Velocidad Tractor Km/hr','VelTractor', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelTractor']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Velocidad Viento Km/hr'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Velocidad Viento Km/hr','VelViento', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelViento']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'T° Minima'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('T° Minima','TempMin', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMin']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'T° Maxima'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('T° Maxima','TempMax', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMax']), 2); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
								<?php $Form_Inputs->form_tittle(6, 'Humedad'); ?>
								<div class="form-group">
									<?php $Form_Inputs->input_number('Humedad','HumTempMax', Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['HumTempMax']), 2); ?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Cuarteles</h3>
							<a onclick="cuartel_all_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Todos Cuarteles</a>
							<a onclick="cuartel_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Cuarteles</a>
						</div>

						<div class="clearfix"></div>
						<div id="insert_cuartel"></div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Productos Quimicos</h3>
							<a onclick="producto_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Productos</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_producto"></div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Tractores</h3>
							<a onclick="tractor_all_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Todos Tractores</a>
							<a onclick="tractor_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Tractores</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_tractor"></div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
							<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Materiales de Seguridad</h3>
							<a onclick="material_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Materiales</a>
						</div>
						<div class="clearfix"></div>
						<div id="insert_material"></div>

						<div class="form-group" style="margin-top:10px;">
							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar y Continuar" name="submit_new_3">
							<a href="<?php echo $location.'&new_2=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver Paso 2</a>
						</div>

					</form>
					<?php widget_validator(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div style="display: none;">

		<div id="clone_cuartel" class="cuartel_container">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->select_change('Cuarteles','idZona[]', 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', $z,'', 'ChangePredio',$dbConn); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Codigo', 'escribeme1', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Hectareas', 'escribeme2', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Hileras', 'escribeme3', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Dist Plantas', 'escribeme4', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->input_disabled('text', 'Dist Hileras', 'escribeme5', 0, 1); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_cuartel" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="clone_producto" class="prod_container">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->select_change('Producto Químico','idProducto[]', 2, 'idProducto', 'Nombre', 'productos_listado', $x,'', 'OnSelectionChange',$dbConn); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Dosis Recomendada', 'escribeme1', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_number('Dosis a aplicar','DosisAplicar[]', '', 2); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->input_disabled('text', 'Unidad de medida', 'escribeme2', 0, 1); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->input('text','Objetivo','Objetivo[]', '', 1); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_producto" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="clone_tractor">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
				<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->select('Tractor','idTelemetria[]', '',2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w,'', $dbConn);
				}else{
					$Form_Inputs->select_bodega('Tractor','idTelemetria[]', '', 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
				} ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
					<?php $Form_Inputs->select('Equipo Aplicacion','idVehiculo[]', '',2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $y,'', $dbConn); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->select('Trabajador Asignado','idTrabajador[]', '',2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $m,'', $dbConn); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_tractor" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="clone_material">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopadding">
				<div class="form-group">
					<div class="input-group">
						<?php $Form_Inputs->select('Material de Seguridad','idMatSeguridad[]', '',2, 'idMatSeguridad', 'Nombre', 'cross_checking_materiales_seguridad', 'idEstado=1','', $dbConn); ?>
						<div class="input-group-btn">
							<button class="btn btn-metis-1 tooltip remove_material" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

	</div>
	<div class="clearfix"></div>

	<script>

		let room1 = 0;
		let room2 = 0;
		let room3 = 0;
		let room4 = 0;
		let incre = 0;
		let incr2 = 0;

		/**********************************************************/
		//Se agrega cuartel
		function cuartel_add() {
			//se incrementa en 1
			room1++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_cuartel');
			let objclone = document.getElementById('clone_cuartel'),
			//se clonan los div
			clone_cuartel = objclone.cloneNode(true);
			clone_cuartel.id = 'new_cuartel_'+room1;
			//inserto dentro del div deseado
			objTo.appendChild(clone_cuartel);
		}

		//Se agrega cuartel
		function cuartel_add_2() {
			//se incrementa en 1
			room1++;
			incre++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_cuartel');
			let objclone = document.getElementById('clone_cuartel'),
			//se clonan los div
			clone_cuartel = objclone.cloneNode(true);
			clone_cuartel.id = 'new_cuartel_'+room1;
			//inserto dentro del div deseado
			objTo.appendChild(clone_cuartel);
			//Autoselecciono los items
			let div = document.getElementById('new_cuartel_'+room1);
			if (div) {
				div.querySelector('select').selectedIndex = incre;
				let subdiv = div.querySelector('select');
				ChangePredio (subdiv);
			}
		}
		//Se agregan todos los cuarteles
		function cuartel_all_add() {
			<?php foreach ($arrCuenta as $cc) { ?>
				cuartel_add_2();
			<?php } ?>
		}
		//se eliminan filas
		$(document).on('click', '.remove_cuartel', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/**********************************************************/
		//Se agrega producto
		function producto_add(){
			//se incrementa en 1
			room2++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_producto');
			let objclone = document.getElementById('clone_producto'),
			//se clonan los div
			clone_producto = objclone.cloneNode(true);
			clone_producto.id = 'new_producto_'+room2;
			//inserto dentro del div deseado
			objTo.appendChild(clone_producto);
		}
		//se eliminan filas
		$(document).on('click', '.remove_producto', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/**********************************************************/
		//Se agrega tractor
		function tractor_add() {
			//se incrementa en 1
			room3++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_tractor');
			let objclone = document.getElementById('clone_tractor'),
			//se clonan los div
			clone_tractor = objclone.cloneNode(true);
			clone_tractor.id = 'new_tractor_'+room3;
			//inserto dentro del div deseado
			objTo.appendChild(clone_tractor);
		}
		//Se agrega cuartel
		function tractor_add_2() {
			//se incrementa en 1
			room3++;
			incr2++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_tractor');
			let objclone = document.getElementById('clone_tractor'),
			//se clonan los div
			clone_tractor = objclone.cloneNode(true);
			clone_tractor.id = 'new_tractor_'+room3;
			//inserto dentro del div deseado
			objTo.appendChild(clone_tractor);
			//Autoselecciono los items
			let div = document.getElementById('new_tractor_'+room3);
			if (div) {
				div.querySelector('select').selectedIndex = incr2;
				let subdiv = div.querySelector('select');
				//ChangeTractor (subdiv);
			}
		}
		//Se agregan todos los cuarteles
		function tractor_all_add() {
			<?php foreach ($arrCuenta2 as $cc) { ?>
				tractor_add_2();
			<?php } ?>
		}
		//se eliminan filas
		$(document).on('click', '.remove_tractor', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/**********************************************************/
		//Se agrega tractor
		function material_add() {
			//se incrementa en 1
			room4++;
			//se estancian los objetos a clonar
			let objTo    = document.getElementById('insert_material');
			let objclone = document.getElementById('clone_material'),
			//se clonan los div
			clone_material = objclone.cloneNode(true);
			clone_material.id = 'new_material_'+room4;
			//inserto dentro del div deseado
			objTo.appendChild(clone_material);
		}
		//se eliminan filas
		$(document).on('click', '.remove_material', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().parent().remove();
		});

		/****************************************************************************************/
		/**********************************************************/
		//se ejecuta al cambiar
		function OnSelectionChange (select) {
			//variables varias
			<?php
			//recorro
			foreach ($arrTipo as $tipo) {
				echo 'let id_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['DosisRecomendada']).'";';
			echo 'let id_med_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
			}
			?>
			let Componente = select.options[select.selectedIndex].value;
			if (Componente != "") {
				//escribo dentro del input
				$(select).closest('.prod_container').find('.escribeme1').val(eval("id_data_" + Componente));
				$(select).closest('.prod_container').find('.escribeme2').val(eval("id_med_" + Componente));
			}
		}
		/**********************************************************/
		//se ejecuta al cambiar
		function ChangePredio (select) {
			//variables varias
			<?php
			foreach ($arrCuenta as $tipo) {
				echo 'let id_codigo_'.$tipo['idZona'].'= "'.$tipo['Codigo'].'";';
				echo 'let id_hectarea_'.$tipo['idZona'].'= "'.Cantidades_decimales_justos($tipo['Hectareas']).'";';
				echo 'let id_hilera_'.$tipo['idZona'].'= "'.$tipo['Hileras'].'";';
				echo 'let id_distancia_p_'.$tipo['idZona'].'= "'.Cantidades_decimales_justos($tipo['DistanciaPlant']).'";';
				echo 'let id_distancia_h_'.$tipo['idZona'].'= "'.Cantidades_decimales_justos($tipo['DistanciaHileras']).'";';
			}
			?>
			let Componente = select.options[select.selectedIndex].value;
			if (Componente != "") {
				//escribo dentro del input
				$(select).closest('.cuartel_container').find('.escribeme1').val('Cod: '+eval("id_codigo_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme2').val('Hect: '+eval("id_hectarea_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme3').val('Hil: '+eval("id_hilera_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme4').val('D Plantas: '+eval("id_distancia_p_" + Componente));
				$(select).closest('.cuartel_container').find('.escribeme5').val('D Hileras: '+eval("id_distancia_h_" + Componente));
			}
		}
	</script>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new_2'])){  ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Generar Nueva Solicitud de Aplicacion - PASO 2</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Mojamiento)){    $x0 = $Mojamiento;    }else{$x0 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['Mojamiento']);}
					if(isset($VelTractor)){    $x1 = $VelTractor;    }else{$x1 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelTractor']);}
					if(isset($VelViento)){     $x2 = $VelViento;     }else{$x2 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['VelViento']);}
					if(isset($TempMin)){       $x3 = $TempMin;       }else{$x3 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMin']);}
					if(isset($TempMax)){       $x4 = $TempMax;       }else{$x4 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['TempMax']);}
					if(isset($HumTempMax)){    $x5 = $HumTempMax;    }else{$x5 = Cantidades_decimales_justos($_SESSION['sol_apli_basicos']['HumTempMax']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Parámetros de Aplicación');
					$Form_Inputs->form_input_number_spinner('Mojamiento L/ha','Mojamiento', $x0, 0, 10000, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Tractor Km/hr','VelTractor', $x1, 0, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Viento Km/hr','VelViento', $x2, 0, 50, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura minima','TempMin', $x3, -20, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura maxima','TempMax', $x4, -20, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Humedad','HumTempMax', $x5, -20, 500, '0.1', 1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="Siguiente &#xf061;" name="submit_new_2">
						<a href="<?php echo $location.'&new=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver Paso 1</a>
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
	//Verifico el tipo de usuario que esta ingresando
	$y = "idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	/*************************************************************/
	//filtro
	$zx1 = "idCategoria=0";
	$zx2 = "idProducto=0";
	/************************************/
	//Se revisan los permisos a las especies
	$SIS_query = 'idCategoria';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idCategoria ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_variedades_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//recorro
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idCategoria=".$prod['idCategoria'].")";
	}
	/************************************/
	//Se revisan los permisos a las variantes
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_variedades_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//recorro
	foreach ($arrPermisos as $prod) {
		$zx2 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Generar Nueva Solicitud de Aplicacion - PASO 1</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($NSolicitud)){           $x1  = $NSolicitud;           }else{$x1  = '';}
					if(isset($idPrioridad)){          $x2  = $idPrioridad;          }else{$x2  = '';}
					if(isset($idPredio)){             $x3  = $idPredio;             }else{$x3  = '';}
					if(isset($idTemporada)){          $x4  = $idTemporada;          }else{$x4  = '';}
					if(isset($idEstadoFen)){          $x5  = $idEstadoFen;          }else{$x5  = '';}
					if(isset($idCategoria)){          $x6  = $idCategoria;          }else{$x6  = '';}
					if(isset($idProducto)){           $x7  = $idProducto;           }else{$x7  = '';}
					if(isset($f_programacion)){       $x8  = $f_programacion;       }else{$x8  = '';}
					if(isset($horaProg)){             $x9  = $horaProg;             }else{$x9  = '';}
					if(isset($f_programacion_fin)){   $x10 = $f_programacion_fin;   }else{$x10 = '';}
					if(isset($horaProg_fin)){         $x11 = $horaProg_fin;         }else{$x11 = '';}
					if(isset($Observaciones)){        $x12 = $Observaciones;        }else{$x12 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_values('Numero de solicitud','NSolicitud', $x1, 2);
					$Form_Inputs->form_select('Prioridad','idPrioridad', $x2, 2, 'idPrioridad', 'Nombre', 'core_cross_prioridad', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Predio','idPredio', $x3, 2, 'idPredio', 'Nombre', 'cross_predios_listado', $z, '', $dbConn);
					$Form_Inputs->form_select_filter('Temporada','idTemporada', $x4, 2, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
					$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x5, 2, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', $zx1, 0,
											'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', $zx2, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_date('Fecha inicio requerido','f_programacion', $x8, 2);
					$Form_Inputs->form_time('Hora inicio requerido','horaProg', $x9, 2, 1);
					$Form_Inputs->form_date('Fecha termino requerido','f_programacion_fin', $x10, 2);
					$Form_Inputs->form_time('Hora termino requerido','horaProg_fin', $x11, 2, 1);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x12, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="Siguiente &#xf061;" name="submit">
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
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	$y = "idEstado=1";
	$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Variable de busqueda
	$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
	$SIS_where.= " AND cross_solicitud_aplicacion_listado.idEstado = 1"; //Solo las programadas
	$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idSolicitud']) && $_GET['idSolicitud']!=''){         $SIS_where .= " AND cross_solicitud_aplicacion_listado.idSolicitud=".$_GET['idSolicitud'];}
	if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
	if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){               $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
	if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){         $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
	if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){         $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
	if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){         $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
	if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
	if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.f_programacion='".$_GET['f_programacion']."'";}
	if(isset($_GET['horaProg']) && $_GET['horaProg']!=''){               $SIS_where .= " AND cross_solicitud_aplicacion_listado.horaProg='".$_GET['horaProg']."'";}
	if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){             $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}

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

		<?php if ($rowlevel['level']>=3){
		if (isset($_SESSION['sol_apli_basicos']['idPredio'])&&$_SESSION['sol_apli_basicos']['idPredio']!=''){ ?>

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

			<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-arrow-right" aria-hidden="true"></i> Continuar Solicitud</a>
		<?php }else{ ?>
			<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-plus" aria-hidden="true"></i> Nueva Solicitud</a>
		<?php }
		} ?>
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
									<div class="btn-group" style="width: 140px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&NSolicitud='.$ot['NSolicitud'].'&clone_idSolicitud='.$ot['idSolicitud']; ?>" title="Clonar Solicitud" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'cross_solicitud_aplicacion_editar.php?view='.$ot['idSolicitud']; ?>" title="Editar Solicitud" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del_Solicitud='.simpleEncode($ot['idSolicitud'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el registro de la Solicitud  '.n_doc($ot['idSolicitud'], 5).'?'; ?>
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
