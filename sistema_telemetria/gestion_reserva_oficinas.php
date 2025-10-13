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
$original = "gestion_reserva_oficinas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){                      $location .= "&idUsuario=".$_GET['idUsuario'];                      $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){                        $location .= "&h_inicio=".$_GET['h_inicio'];                        $search .= "&h_inicio=".$_GET['h_inicio'];}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){                      $location .= "&h_termino=".$_GET['h_termino'];                      $search .= "&h_termino=".$_GET['h_termino'];}
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){                        $location .= "&f_inicio=".$_GET['f_inicio'];                        $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){                      $location .= "&f_termino=".$_GET['f_termino'];                      $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                        $location .= "&idEstado=".$_GET['idEstado'];                        $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['Solicitante']) && $_GET['Solicitante']!=''){                  $location .= "&Solicitante=".$_GET['Solicitante'];                  $search .= "&Solicitante=".$_GET['Solicitante'];}
if(isset($_GET['idServicioCafeteria']) && $_GET['idServicioCafeteria']!=''){  $location .= "&idServicioCafeteria=".$_GET['idServicioCafeteria'];  $search .= "&idServicioCafeteria=".$_GET['idServicioCafeteria'];}
if(isset($_GET['CantidadAsistentes']) && $_GET['CantidadAsistentes']!=''){    $location .= "&CantidadAsistentes=".$_GET['CantidadAsistentes'];    $search .= "&CantidadAsistentes=".$_GET['CantidadAsistentes'];}
if(isset($_GET['idOficina']) && $_GET['idOficina']!=''){                      $location .= "&idOficina=".$_GET['idOficina'];                      $search .= "&idOficina=".$_GET['idOficina'];}
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
	require_once 'A1XRXS_sys/xrxs_form/gestion_reserva_oficinas.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/gestion_reserva_oficinas.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/gestion_reserva_oficinas.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Reserva Oficina Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Reserva Oficina Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Reserva Oficina Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Fecha, Hora_Inicio, Hora_Termino, Solicitante, idServicioCafeteria, CantidadAsistentes, idOficina, Observaciones, idEstado';
	$SIS_join  = '';
	$SIS_where = 'idReserva = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'gestion_reserva_oficinas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación Reserva</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Fecha)){                $x1  = $Fecha;                }else{$x1  = $rowData['Fecha'];}
					if(isset($Hora_Inicio)){          $x2  = $Hora_Inicio;          }else{$x2  = $rowData['Hora_Inicio'];}
					if(isset($Hora_Termino)){         $x3  = $Hora_Termino;         }else{$x3  = $rowData['Hora_Termino'];}
					if(isset($Solicitante)){          $x4  = $Solicitante;          }else{$x4  = $rowData['Solicitante'];}
					if(isset($idServicioCafeteria)){  $x5  = $idServicioCafeteria;  }else{$x5  = $rowData['idServicioCafeteria'];}
					if(isset($CantidadAsistentes)){   $x6  = $CantidadAsistentes;   }else{$x6  = $rowData['CantidadAsistentes'];}
					if(isset($idOficina)){            $x7  = $idOficina;            }else{$x7  = $rowData['idOficina'];}
					if(isset($Observaciones)){        $x8  = $Observaciones;        }else{$x8  = $rowData['Observaciones'];}
					if(isset($idEstado)){             $x9  = $idEstado;             }else{$x9  = $rowData['idEstado'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha','Fecha', $x1, 2);
					$Form_Inputs->form_time('Hora Inicio','Hora_Inicio', $x2, 2, 2);
					$Form_Inputs->form_time('Hora Termino','Hora_Termino', $x3, 2, 2);
					$Form_Inputs->form_input_text('Solicitante', 'Solicitante', $x4, 2);
					$Form_Inputs->form_select('Servicio de Cafeteria','idServicioCafeteria', $x5, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad de Asistentes','CantidadAsistentes', $x6, 2);
					$Form_Inputs->form_select('Sala de Reuniones','idOficina', $x7, 2, 'idOficina', 'Nombre', 'oficinas_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x8, 1);
					$Form_Inputs->form_select('Estado','idEstado', $x9, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idReserva', $_GET['id'], 2);
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
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Reserva</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Fecha)){                $x1  = $Fecha;                }else{$x1  = '';}
					if(isset($Hora_Inicio)){          $x2  = $Hora_Inicio;          }else{$x2  = '';}
					if(isset($Hora_Termino)){         $x3  = $Hora_Termino;         }else{$x3  = '';}
					if(isset($Solicitante)){          $x4  = $Solicitante;          }else{$x4  = '';}
					if(isset($idServicioCafeteria)){  $x5  = $idServicioCafeteria;  }else{$x5  = '';}
					if(isset($CantidadAsistentes)){   $x6  = $CantidadAsistentes;   }else{$x6  = '';}
					if(isset($idOficina)){            $x7  = $idOficina;            }else{$x7  = '';}
					if(isset($Observaciones)){        $x8  = $Observaciones;        }else{$x8  = '';}

					//En el caso de que exista un dato
					if(isset($_GET['idOficina'])&&$_GET['idOficina']!='') {
						$x1  = fecha_actual();
						$x2  = hora_actual();
						$x3  = hora_actual();
						$x7  = $_GET['idOficina'];
					}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha','Fecha', $x1, 2);
					$Form_Inputs->form_time('Hora Inicio','Hora_Inicio', $x2, 2, 2);
					$Form_Inputs->form_time('Hora Termino','Hora_Termino', $x3, 2, 2);
					$Form_Inputs->form_input_text('Solicitante', 'Solicitante', $x4, 2);
					$Form_Inputs->form_select('Servicio de Cafeteria','idServicioCafeteria', $x5, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad de Asistentes','CantidadAsistentes', $x6, 2);
					$Form_Inputs->form_select('Sala de Reuniones','idOficina', $x7, 2, 'idOficina', 'Nombre', 'oficinas_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x8, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
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
			case 'usuario_asc':        $order_by = 'usuarios_listado.Nombre ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente'; break;
			case 'usuario_desc':       $order_by = 'usuarios_listado.Nombre DESC ';                       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
			case 'solicitante_asc':    $order_by = 'gestion_reserva_oficinas.Solicitante ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Solicitante Ascendente'; break;
			case 'solicitante_desc':   $order_by = 'gestion_reserva_oficinas.Solicitante DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Solicitante Descendente';break;
			case 'oficina_asc':        $order_by = 'oficinas_listado.Nombre ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Oficina Ascendente'; break;
			case 'oficina_desc':       $order_by = 'oficinas_listado.Nombre DESC ';                       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Oficina Descendente';break;
			case 'fecha_asc':          $order_by = 'gestion_reserva_oficinas.Fecha ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':         $order_by = 'gestion_reserva_oficinas.Fecha DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'hora_asc':           $order_by = 'gestion_reserva_oficinas.Hora_Inicio ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Ascendente'; break;
			case 'hora_desc':          $order_by = 'gestion_reserva_oficinas.Hora_Inicio DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Descendente';break;
			case 'asistentes_asc':     $order_by = 'gestion_reserva_oficinas.CantidadAsistentes ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Asistentes Ascendente'; break;
			case 'asistentes_desc':    $order_by = 'gestion_reserva_oficinas.CantidadAsistentes DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Asistentes Descendente';break;
			case 'estado_asc':         $order_by = 'core_estados.Nombre ASC ';                            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente'; break;
			case 'estado_desc':        $order_by = 'core_estados.Nombre DESC ';                           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
			case 'cofee_asc':          $order_by = 'core_sistemas_opciones.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cafeteria Ascendente'; break;
			case 'cofee_desc':         $order_by = 'core_sistemas_opciones.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Cafeteria Descendente';break;

			default: $order_by = 'oficinas_listado.idEstado ASC, gestion_reserva_oficinas.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
		}
	}else{
		$order_by = 'oficinas_listado.idEstado ASC, gestion_reserva_oficinas.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "gestion_reserva_oficinas.idReserva!=0";
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where.= " AND gestion_reserva_oficinas.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//Se aplican los filtros
	if(isset($_GET['idUsuario']) && $_GET['idUsuario'] != ''){                    $SIS_where .= " AND gestion_reserva_oficinas.idUsuario = '".$_GET['idUsuario']."'";}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                        $SIS_where .= " AND gestion_reserva_oficinas.idEstado='".$_GET['idEstado']."'";}
	if(isset($_GET['Solicitante']) && $_GET['Solicitante']!=''){                  $SIS_where .= " AND gestion_reserva_oficinas.Solicitante LIKE '%".EstandarizarInput($_GET['Solicitante'])."%'";}
	if(isset($_GET['idServicioCafeteria']) && $_GET['idServicioCafeteria']!=''){  $SIS_where .= " AND gestion_reserva_oficinas.idServicioCafeteria='".$_GET['idServicioCafeteria']."'";}
	if(isset($_GET['CantidadAsistentes']) && $_GET['CantidadAsistentes']!=''){    $SIS_where .= " AND gestion_reserva_oficinas.CantidadAsistentes='".$_GET['CantidadAsistentes']."'";}
	if(isset($_GET['idOficina']) && $_GET['idOficina']!=''){                      $SIS_where .= " AND gestion_reserva_oficinas.idOficina='".$_GET['idOficina']."'";}
	if(isset($_GET['h_inicio'], $_GET['h_termino']) && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
		$SIS_where .= " AND gestion_reserva_oficinas.Hora_Inicio BETWEEN '".$_GET['h_inicio']."' AND '".$_GET['h_termino']."'";
	}
	if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
		$SIS_where .= " AND gestion_reserva_oficinas.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idReserva', 'gestion_reserva_oficinas', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	gestion_reserva_oficinas.idReserva,
	gestion_reserva_oficinas.Fecha,
	gestion_reserva_oficinas.Hora_Inicio,
	gestion_reserva_oficinas.Hora_Termino,
	gestion_reserva_oficinas.Solicitante,
	gestion_reserva_oficinas.CantidadAsistentes,

	core_sistemas.Nombre AS Sistema,
	usuarios_listado.Nombre AS Usuario,
	core_estados.Nombre AS estado,
	gestion_reserva_oficinas.idEstado,
	core_sistemas_opciones.Nombre AS Cafeteria,
	oficinas_listado.Nombre AS Oficina';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`            ON core_sistemas.idSistema             = gestion_reserva_oficinas.idSistema
	LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario          = gestion_reserva_oficinas.idUsuario
	LEFT JOIN `core_estados`             ON core_estados.idEstado               = gestion_reserva_oficinas.idEstado
	LEFT JOIN `core_sistemas_opciones`   ON core_sistemas_opciones.idOpciones   = gestion_reserva_oficinas.idServicioCafeteria
	LEFT JOIN `oficinas_listado`         ON oficinas_listado.idOficina          = gestion_reserva_oficinas.idOficina';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrReserva = array();
	$arrReserva = db_select_array (false, $SIS_query, 'gestion_reserva_oficinas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrReserva');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Reserva</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idUsuario)){            $x1  = $idUsuario;            }else{$x1  = '';}
					if(isset($f_inicio)){             $x2  = $f_inicio;             }else{$x2  = '';}
					if(isset($f_termino)){            $x3  = $f_termino;            }else{$x3  = '';}
					if(isset($h_inicio)){             $x4  = $h_inicio;             }else{$x4  = '';}
					if(isset($h_termino)){            $x5  = $h_termino;            }else{$x5  = '';}
					if(isset($idEstado)){             $x6  = $idEstado;             }else{$x6  = '';}
					if(isset($Solicitante)){          $x7  = $Solicitante;          }else{$x7  = '';}
					if(isset($idServicioCafeteria)){  $x8  = $idServicioCafeteria;  }else{$x8  = '';}
					if(isset($CantidadAsistentes)){   $x9  = $CantidadAsistentes;   }else{$x9  = '';}
					if(isset($idOficina)){            $x10 = $idOficina;            }else{$x10 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x1, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x2, 1);
					$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 1);
					$Form_Inputs->form_time('Hora Inicio','h_inicio', $x4, 1, 1);
					$Form_Inputs->form_time('Hora Termino','h_termino', $x5, 1, 1);
					$Form_Inputs->form_select('Estado','idEstado', $x6, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Solicitante', 'Solicitante', $x7, 1);
					$Form_Inputs->form_select('Servicio de Cafeteria','idServicioCafeteria', $x8, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad de Asistentes','CantidadAsistentes', $x9, 1);
					$Form_Inputs->form_select('Sala de Reuniones','idOficina', $x10, 1, 'idOficina', 'Nombre', 'oficinas_listado', 'idEstado=1', '', $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Reservas</h5>
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
								<div class="pull-left">Usuario</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Solicitante</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=solicitante_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=solicitante_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Sala de Reuniones</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=oficina_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=oficina_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Horas</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=hora_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=hora_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Asistentes</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=asistentes_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=asistentes_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Cafeteria</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=cofee_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=cofee_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrReserva as $tipo) { ?>
							<tr class="odd">
								<td><?php echo $tipo['Usuario']; ?></td>
								<td><?php echo $tipo['Solicitante']; ?></td>
								<td><?php echo $tipo['Oficina']; ?></td>
								<td><?php echo fecha_estandar($tipo['Fecha']); ?></td>
								<td><?php echo $tipo['Hora_Inicio'].' - '.$tipo['Hora_Termino']; ?></td>
								<td><?php echo $tipo['CantidadAsistentes'].' personas'; ?></td>
								<td><?php echo $tipo['Cafeteria']; ?></td>
								<td><label class="label <?php if(isset($tipo['idEstado'])&&$tipo['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $tipo['estado']; ?></label></td>
								<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
								<td>
									<div class="btn-group" style="width: 105px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_gestion_reserva_oficinas.php?view='.simpleEncode($tipo['idReserva'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$tipo['idReserva']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($tipo['idReserva'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la reserva de la oficina '.$tipo['Oficina'].' ?'; ?>
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
