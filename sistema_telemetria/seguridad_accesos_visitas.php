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
$original = "seguridad_accesos_visitas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){                  $location .= "&idUsuario=".$_GET['idUsuario'];                  $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){                    $location .= "&h_inicio=".$_GET['h_inicio'];                    $search .= "&h_inicio=".$_GET['h_inicio'];}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){                  $location .= "&h_termino=".$_GET['h_termino'];                  $search .= "&h_termino=".$_GET['h_termino'];}
if(isset($_GET['h_salida_inicio']) && $_GET['h_salida_inicio']!=''){      $location .= "&h_salida_inicio=".$_GET['h_salida_inicio'];      $search .= "&h_salida_inicio=".$_GET['h_salida_inicio'];}
if(isset($_GET['h_salida_termino']) && $_GET['h_salida_termino']!=''){    $location .= "&h_salida_termino=".$_GET['h_salida_termino'];    $search .= "&h_salida_termino=".$_GET['h_salida_termino'];}
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){                    $location .= "&f_inicio=".$_GET['f_inicio'];                    $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){                  $location .= "&f_termino=".$_GET['f_termino'];                  $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                        $location .= "&Nombre=".$_GET['Nombre'];                        $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){                              $location .= "&Rut=".$_GET['Rut'];                              $search .= "&Rut=".$_GET['Rut'];}
if(isset($_GET['NDocCedula']) && $_GET['NDocCedula']!=''){                $location .= "&NDocCedula=".$_GET['NDocCedula'];                $search .= "&NDocCedula=".$_GET['NDocCedula'];}
if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){              $location .= "&idUbicacion=".$_GET['idUbicacion'];              $search .= "&idUbicacion=".$_GET['idUbicacion'];}
if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){  $location .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];  $search .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];}
if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){  $location .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];  $search .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];}
if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){  $location .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];  $search .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];}
if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){  $location .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];  $search .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];}
if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){  $location .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];  $search .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];}
if(isset($_GET['PersonaReunion']) && $_GET['PersonaReunion']!=''){        $location .= "&PersonaReunion=".$_GET['PersonaReunion'];        $search .= "&PersonaReunion=".$_GET['PersonaReunion'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                    $location .= "&idEstado=".$_GET['idEstado'];                    $search .= "&idEstado=".$_GET['idEstado'];}
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
	require_once 'A1XRXS_sys/xrxs_form/seguridad_accesos.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/seguridad_accesos.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/seguridad_accesos.php';
}
//se borra un dato
if (!empty($_GET['del_img'])){
	//Llamamos al formulario
	$form_trabajo= 'del_img';
	require_once 'A1XRXS_sys/xrxs_form/seguridad_accesos.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Acceso Visita Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Acceso Visita Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Acceso Visita Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Fecha,Hora,Nombre,idSistema, Rut, NDocCedula, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
	idUbicacion_lvl_5, PersonaReunion, Direccion_img, HoraSalida';
	$SIS_join  = '';
	$SIS_where = 'idAcceso = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'seguridad_accesos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación del Acceso Visita</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Fecha)){               $x1  = $Fecha;               }else{$x1  = $rowData['Fecha'];}
					if(isset($Hora)){                $x2  = $Hora;                }else{$x2  = $rowData['Hora'];}
					if(isset($HoraSalida)){          $x3  = $HoraSalida;          }else{$x3  = $rowData['HoraSalida'];}
					if(isset($Nombre)){              $x4  = $Nombre;              }else{$x4  = $rowData['Nombre'];}
					if(isset($Rut)){                 $x5  = $Rut;                 }else{$x5  = $rowData['Rut'];}
					if(isset($NDocCedula)){          $x6  = $NDocCedula;          }else{$x6  = $rowData['NDocCedula'];}
					if(isset($idUbicacion)){         $x7  = $idUbicacion;         }else{$x7  = $rowData['idUbicacion'];}
					if(isset($idUbicacion_lvl_1)){   $x8  = $idUbicacion_lvl_1;   }else{$x8  = $rowData['idUbicacion_lvl_1'];}
					if(isset($idUbicacion_lvl_2)){   $x9  = $idUbicacion_lvl_2;   }else{$x9  = $rowData['idUbicacion_lvl_2'];}
					if(isset($idUbicacion_lvl_3)){   $x10 = $idUbicacion_lvl_3;   }else{$x10 = $rowData['idUbicacion_lvl_3'];}
					if(isset($idUbicacion_lvl_4)){   $x11 = $idUbicacion_lvl_4;   }else{$x11 = $rowData['idUbicacion_lvl_4'];}
					if(isset($idUbicacion_lvl_5)){   $x12 = $idUbicacion_lvl_5;   }else{$x12 = $rowData['idUbicacion_lvl_5'];}
					if(isset($PersonaReunion)){      $x13 = $PersonaReunion;      }else{$x13 = $rowData['PersonaReunion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha','Fecha', $x1, 2);
					$Form_Inputs->form_time('Hora Entrada','Hora', $x2, 2, 2);
					$Form_Inputs->form_time('Hora Salida','HoraSalida', $x3, 2, 2);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x4, 2);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x5, 2);
					$Form_Inputs->form_input_text('Numero Documento', 'NDocCedula', $x6, 1);
					$Form_Inputs->form_select_depend5('Destino', 'idUbicacion',  $x7,  2,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
													'Nivel 1', 'idUbicacion_lvl_1',  $x8,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
													'Nivel 2', 'idUbicacion_lvl_2',  $x9,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
													'Nivel 3', 'idUbicacion_lvl_3',  $x10,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
													'Nivel 4', 'idUbicacion_lvl_4',  $x11,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
													'Nivel 5', 'idUbicacion_lvl_5',  $x12,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
													$dbConn, 'form1');
					$Form_Inputs->form_input_text('Persona Reunion', 'PersonaReunion', $x13, 2);
					if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){ ?>

						<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
						<img src="upload/<?php echo $rowData['Direccion_img'] ?>" width="100%" >
						</div>
						<a href="<?php echo $location.'&id='.$_GET['id'].'&del_img='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
						<div class="clearfix"></div>

					<?php
					}else{
						$Form_Inputs->form_multiple_upload('Seleccionar foto','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');

					}

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 2, 2);
					$Form_Inputs->form_input_hidden('idAcceso', $_GET['id'], 2);
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
				<h5>Crear Acceso Visita</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Fecha)){               $x1  = $Fecha;               }else{$x1  = '';}
					if(isset($Hora)){                $x2  = $Hora;                }else{$x2  = '';}
					if(isset($Nombre)){              $x3  = $Nombre;              }else{$x3  = '';}
					if(isset($Rut)){                 $x4  = $Rut;                 }else{$x4  = '';}
					if(isset($NDocCedula)){          $x5  = $NDocCedula;          }else{$x5  = '';}
					if(isset($idUbicacion)){         $x6  = $idUbicacion;         }else{$x6  = '';}
					if(isset($idUbicacion_lvl_1)){   $x7  = $idUbicacion_lvl_1;   }else{$x7  = '';}
					if(isset($idUbicacion_lvl_2)){   $x8  = $idUbicacion_lvl_2;   }else{$x8  = '';}
					if(isset($idUbicacion_lvl_3)){   $x9  = $idUbicacion_lvl_3;   }else{$x9  = '';}
					if(isset($idUbicacion_lvl_4)){   $x10 = $idUbicacion_lvl_4;   }else{$x10 = '';}
					if(isset($idUbicacion_lvl_5)){   $x11 = $idUbicacion_lvl_5;   }else{$x11 = '';}
					if(isset($PersonaReunion)){      $x12 = $PersonaReunion;      }else{$x12 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha','Fecha', $x1, 2);
					$Form_Inputs->form_time('Hora Entrada','Hora', $x2, 2, 2);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x3, 2);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x4, 2);
					$Form_Inputs->form_input_text('Numero Documento', 'NDocCedula', $x5, 1);
					$Form_Inputs->form_select_depend5('Destino', 'idUbicacion',  $x6,  2,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
													'Nivel 1', 'idUbicacion_lvl_1',  $x7,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
													'Nivel 2', 'idUbicacion_lvl_2',  $x8,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
													'Nivel 3', 'idUbicacion_lvl_3',  $x9,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
													'Nivel 4', 'idUbicacion_lvl_4',  $x10,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
													'Nivel 5', 'idUbicacion_lvl_5',  $x11,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
													$dbConn, 'form1');
					$Form_Inputs->form_input_text('Persona Reunion', 'PersonaReunion', $x12, 2);
					$Form_Inputs->form_multiple_upload('Seleccionar foto','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
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
			case 'usuario_asc':           $order_by = 'usuarios_listado.Nombre ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente'; break;
			case 'usuario_desc':          $order_by = 'usuarios_listado.Nombre DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
			case 'fecha_asc':             $order_by = 'seguridad_accesos.Fecha ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':            $order_by = 'seguridad_accesos.Fecha DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'hora_entrada_asc':      $order_by = 'seguridad_accesos.Hora ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Entrada Ascendente'; break;
			case 'hora_entrada_desc':     $order_by = 'seguridad_accesos.Hora DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Entrada Descendente';break;
			case 'hora_salida_asc':       $order_by = 'seguridad_accesos.HoraSalida ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Salida Ascendente'; break;
			case 'hora_salida_desc':      $order_by = 'seguridad_accesos.HoraSalida DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Salida Descendente';break;
			case 'nombre_asc':            $order_by = 'seguridad_accesos.Nombre ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
			case 'nombre_desc':           $order_by = 'seguridad_accesos.Nombre DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'rut_asc':               $order_by = 'seguridad_accesos.Rut ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Rut Ascendente'; break;
			case 'rut_desc':              $order_by = 'seguridad_accesos.Rut DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Rut Descendente';break;
			case 'ndoc_asc':              $order_by = 'seguridad_accesos.NDocCedula ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Numero Documento Ascendente'; break;
			case 'ndoc_desc':             $order_by = 'seguridad_accesos.NDocCedula DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Numero Documento Descendente';break;
			case 'destino_asc':           $order_by = 'ubicacion_listado.Nombre ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Destino Ascendente'; break;
			case 'destino_desc':          $order_by = 'ubicacion_listado.Nombre DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Destino Descendente';break;
			case 'persona_asc':           $order_by = 'seguridad_accesos.PersonaReunion ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Persona de Reunion Ascendente'; break;
			case 'persona_desc':          $order_by = 'seguridad_accesos.PersonaReunion DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Persona de Reunion Descendente';break;
			case 'estado_asc':            $order_by = 'core_estado_caja.Nombre ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente'; break;
			case 'estado_desc':           $order_by = 'core_estado_caja.Nombre DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

			default: $order_by = 'seguridad_accesos.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
		}
	}else{
		$order_by = 'seguridad_accesos.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Descendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "seguridad_accesos.idAcceso!=0";
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where.= " AND seguridad_accesos.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idUsuario']) && $_GET['idUsuario'] != ''){
		$SIS_where .= " AND seguridad_accesos.idUsuario = '".$_GET['idUsuario']."'";
	}
	if(isset($_GET['h_inicio'], $_GET['h_termino']) && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
		$SIS_where .= " AND seguridad_accesos.Hora BETWEEN '".$_GET['h_inicio']."' AND '".$_GET['h_termino']."'";
	}
	if(isset($_GET['h_salida_inicio']) && $_GET['h_salida_inicio'] != ''&&isset($_GET['h_salida_termino']) && $_GET['h_salida_termino']!=''){
		$SIS_where .= " AND seguridad_accesos.HoraSalida BETWEEN '".$_GET['h_salida_inicio']."' AND '".$_GET['h_salida_termino']."'";
	}
	if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
		$SIS_where .= " AND seguridad_accesos.Fecha BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
	}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                         $SIS_where .= " AND seguridad_accesos.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['Rut']) && $_GET['Rut']!=''){                               $SIS_where .= " AND seguridad_accesos.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
	if(isset($_GET['NDocCedula']) && $_GET['NDocCedula']!=''){                 $SIS_where .= " AND seguridad_accesos.NDocCedula LIKE '%".EstandarizarInput($_GET['NDocCedula'])."%'";}
	if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){               $SIS_where .= " AND seguridad_accesos.idUbicacion='".$_GET['idUbicacion']."'";}
	if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){   $SIS_where .= " AND seguridad_accesos.idUbicacion_lvl_1='".$_GET['idUbicacion_lvl_1']."'";}
	if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){   $SIS_where .= " AND seguridad_accesos.idUbicacion_lvl_2='".$_GET['idUbicacion_lvl_2']."'";}
	if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){   $SIS_where .= " AND seguridad_accesos.idUbicacion_lvl_3='".$_GET['idUbicacion_lvl_3']."'";}
	if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){   $SIS_where .= " AND seguridad_accesos.idUbicacion_lvl_4='".$_GET['idUbicacion_lvl_4']."'";}
	if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){   $SIS_where .= " AND seguridad_accesos.idUbicacion_lvl_5='".$_GET['idUbicacion_lvl_5']."'";}
	if(isset($_GET['PersonaReunion']) && $_GET['PersonaReunion']!=''){         $SIS_where .= " AND seguridad_accesos.PersonaReunion LIKE '%".EstandarizarInput($_GET['PersonaReunion'])."%'";}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                     $SIS_where .= " AND seguridad_accesos.idEstado='".$_GET['idEstado']."'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idAcceso', 'seguridad_accesos', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	seguridad_accesos.idAcceso,
	seguridad_accesos.Fecha,
	seguridad_accesos.Hora,
	seguridad_accesos.HoraSalida,
	seguridad_accesos.Nombre,
	seguridad_accesos.Rut,
	seguridad_accesos.NDocCedula,
	core_sistemas.Nombre AS Sistema,
	usuarios_listado.Nombre AS Usuario,
	ubicacion_listado.Nombre AS Ubicacion,
	ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
	ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
	ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
	ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
	ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,
	seguridad_accesos.PersonaReunion,
	core_estado_caja.Nombre AS Estado,
	seguridad_accesos.idEstado';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`            ON usuarios_listado.idUsuario            = seguridad_accesos.idUsuario
	LEFT JOIN `core_sistemas`               ON core_sistemas.idSistema               = seguridad_accesos.idSistema
	LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = seguridad_accesos.idUbicacion
	LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = seguridad_accesos.idUbicacion_lvl_1
	LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = seguridad_accesos.idUbicacion_lvl_2
	LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = seguridad_accesos.idUbicacion_lvl_3
	LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = seguridad_accesos.idUbicacion_lvl_4
	LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = seguridad_accesos.idUbicacion_lvl_5
	LEFT JOIN `core_estado_caja`            ON core_estado_caja.idEstado             = seguridad_accesos.idEstado';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'seguridad_accesos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Acceso</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idUsuario)){           $x1  = $idUsuario;           }else{$x1  = '';}
					if(isset($f_inicio)){            $x2  = $f_inicio;            }else{$x2  = '';}
					if(isset($f_termino)){           $x3  = $f_termino;           }else{$x3  = '';}
					if(isset($h_inicio)){            $x4  = $h_inicio;            }else{$x4  = '';}
					if(isset($h_termino)){           $x5  = $h_termino;           }else{$x5  = '';}
					if(isset($h_salida_inicio)){     $x6  = $h_salida_inicio;     }else{$x6  = '';}
					if(isset($h_salida_termino)){    $x7  = $h_salida_termino;    }else{$x7  = '';}
					if(isset($Nombre)){              $x8  = $Nombre;              }else{$x8  = '';}
					if(isset($Rut)){                 $x9  = $Rut;                 }else{$x9  = '';}
					if(isset($NDocCedula)){          $x10 = $NDocCedula;          }else{$x10 = '';}
					if(isset($idUbicacion)){         $x11 = $idUbicacion;         }else{$x11 = '';}
					if(isset($idUbicacion_lvl_1)){   $x12 = $idUbicacion_lvl_1;   }else{$x12 = '';}
					if(isset($idUbicacion_lvl_2)){   $x13 = $idUbicacion_lvl_2;   }else{$x13 = '';}
					if(isset($idUbicacion_lvl_3)){   $x14 = $idUbicacion_lvl_3;   }else{$x14 = '';}
					if(isset($idUbicacion_lvl_4)){   $x15 = $idUbicacion_lvl_4;   }else{$x15 = '';}
					if(isset($idUbicacion_lvl_5)){   $x16 = $idUbicacion_lvl_5;   }else{$x16 = '';}
					if(isset($PersonaReunion)){      $x17 = $PersonaReunion;      }else{$x17 = '';}
					if(isset($idEstado)){            $x18 = $idEstado;            }else{$x18 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x1, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x2, 1);
					$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 1);
					$Form_Inputs->form_time('Hora Entrada Inicio','h_inicio', $x4, 1, 1);
					$Form_Inputs->form_time('Hora Entrada Termino','h_termino', $x5, 1, 1);
					$Form_Inputs->form_time('Hora Salida Inicio','h_salida_inicio', $x6, 1, 1);
					$Form_Inputs->form_time('Hora Salida Termino','h_salida_termino', $x7, 1, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x8, 1);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x9, 1);
					$Form_Inputs->form_input_text('Numero Documento', 'NDocCedula', $x10, 1);
					$Form_Inputs->form_select_depend5('Destino', 'idUbicacion',  $x11,  1,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
													'Nivel 1', 'idUbicacion_lvl_1',  $x12,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
													'Nivel 2', 'idUbicacion_lvl_2',  $x13,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
													'Nivel 3', 'idUbicacion_lvl_3',  $x14,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
													'Nivel 4', 'idUbicacion_lvl_4',  $x15,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
													'Nivel 5', 'idUbicacion_lvl_5',  $x16,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
													$dbConn, 'form1');
					$Form_Inputs->form_input_text('Persona Reunion', 'PersonaReunion', $x17, 1);
					$Form_Inputs->form_select('Estado','idEstado', $x18, 1, 'idEstado', 'Nombre', 'core_estado_caja', 0, '', $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Accesos Visitas</h5>
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
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Hora Entrada</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=hora_entrada_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=hora_entrada_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Hora Salida</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=hora_salida_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=hora_salida_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Rut</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=rut_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=rut_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Numero Doc</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ndoc_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ndoc_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Destino</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=destino_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=destino_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Persona Reunion</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=persona_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=persona_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
						<?php foreach ($arrTipo as $tipo) { ?>
							<tr class="odd">
								<td><?php echo fecha_estandar($tipo['Fecha']); ?></td>
								<td><?php echo $tipo['Hora']; ?></td>
								<td><?php echo $tipo['HoraSalida']; ?></td>
								<td><?php echo $tipo['Nombre']; ?></td>
								<td><?php echo $tipo['Rut']; ?></td>
								<td><?php echo $tipo['NDocCedula']; ?></td>
								<td>
									<?php echo $tipo['Ubicacion'];
									if(isset($tipo['UbicacionLVL_1'])&&$tipo['UbicacionLVL_1']!=''){echo ' - '.$tipo['UbicacionLVL_1'];}
									if(isset($tipo['UbicacionLVL_2'])&&$tipo['UbicacionLVL_2']!=''){echo ' - '.$tipo['UbicacionLVL_2'];}
									if(isset($tipo['UbicacionLVL_3'])&&$tipo['UbicacionLVL_3']!=''){echo ' - '.$tipo['UbicacionLVL_3'];}
									if(isset($tipo['UbicacionLVL_4'])&&$tipo['UbicacionLVL_4']!=''){echo ' - '.$tipo['UbicacionLVL_4'];}
									if(isset($tipo['UbicacionLVL_5'])&&$tipo['UbicacionLVL_5']!=''){echo ' - '.$tipo['UbicacionLVL_5'];}
									?>
								</td>
								<td><?php echo $tipo['PersonaReunion']; ?></td>
								<td><label class="label <?php if(isset($tipo['idEstado'])&&$tipo['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $tipo['Estado']; ?></label></td>
								<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
								<td>
									<div class="btn-group" style="width: 105px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_seguridad_accesos.php?view='.simpleEncode($tipo['idAcceso'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($tipo['Fecha']==fecha_actual()){ ?>
											<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$tipo['idAcceso']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($tipo['idAcceso'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el acceso de '.$tipo['Nombre'].'?'; ?>
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
