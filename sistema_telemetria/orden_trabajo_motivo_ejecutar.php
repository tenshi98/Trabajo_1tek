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
$original = "orden_trabajo_motivo_ejecutar.php";
$location = $original;
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
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se modifican los datos basicos
if (!empty($_POST['submit_editObs'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_ot_list';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_trab'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_addTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edittrab'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view']; 
	//Llamamos al formulario
	$form_trabajo= 'edit_editTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se borra un trabajo
if (!empty($_GET['del_trab'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_delTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
/*************************************************************************/
//se agrega un insumo
if (!empty($_POST['submit_ins'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_addIns';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se agrega un insumo
if (!empty($_POST['submit_editins'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_editIns';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se elimina un insumo
if (!empty($_GET['del_ins'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_delIns';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
/*************************************************************************/
//se agrega un producto
if (!empty($_POST['submit_prod'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_addProd';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se agrega un producto
if (!empty($_POST['submit_editprod'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_editProd';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se elimina un producto
if (!empty($_GET['del_prod'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_delProd';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
/*************************************************************************/
//se agrega un subcomponente
if (!empty($_POST['submit_tarea'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_addTarea';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se agrega un subcomponente
if (!empty($_POST['submit_edittarea'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_editTarea';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se elimina un subcomponente
if (!empty($_GET['del_tarea'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_delTarea';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
/*************************************************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_editTarea_insert_file';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//nueva ubicacion
	$location .= "?view=".$_GET['view'];
	//Llamamos al formulario
	$form_trabajo= 'edit_editTarea_del_file';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['edited'])){     $error['edited']      = 'sucess/Datos editados correctamente';}
if (isset($_GET['addtrab'])){    $error['addtrab']     = 'sucess/Trabajador agregado correctamente';}
if (isset($_GET['edittrab'])){   $error['edittrab']    = 'sucess/Trabajador Modificado correctamente';}
if (isset($_GET['deltrab'])){    $error['deltrab']     = 'sucess/Trabajador Borrado correctamente';}
if (isset($_GET['addins'])){     $error['addins']      = 'sucess/Insumo agregado correctamente';}
if (isset($_GET['editins'])){    $error['editins']     = 'sucess/Insumo Modificado correctamente';}
if (isset($_GET['delins'])){     $error['delins']      = 'sucess/Insumo Borrado correctamente';}
if (isset($_GET['addprod'])){    $error['addprod']     = 'sucess/Producto agregado correctamente';}
if (isset($_GET['editprod'])){   $error['editprod']    = 'sucess/Producto Modificado correctamente';}
if (isset($_GET['delprod'])){    $error['delprod']     = 'sucess/Producto Borrado correctamente';}
if (isset($_GET['addtarea'])){   $error['addtarea']    = 'sucess/Tarea agregada correctamente';}
if (isset($_GET['edittarea'])){  $error['edittarea']   = 'sucess/Tarea Modificada correctamente';}
if (isset($_GET['deltarea'])){   $error['deltarea']    = 'sucess/Tarea Borrada correctamente';}
if (isset($_GET['addArchivo'])){ $error['addArchivo']  = 'sucess/Archivo agregado correctamente';}
if (isset($_GET['delArchivo'])){ $error['delArchivo']  = 'sucess/Archivo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['addFile'])){
//Se traen los datos de la ot
$SIS_query = 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idEstado, idPrioridad, idTipo, f_programacion';
$SIS_join  = '';
$SIS_where = 'idOT ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Subir Archivo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idArchivoTipo)){    $x1  = $idArchivoTipo;  }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','NombreArchivo', 15, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
				if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
				if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
				if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
				if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
				if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
				$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);
				$Form_Inputs->form_input_hidden('idEstadoTarea', 1, 2);
				$Form_Inputs->form_input_hidden('idTrabajoOT', $_GET['addFile'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addTarea'])){
//Se traen los datos de la ot
$SIS_query = 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idEstado, idPrioridad, idTipo, f_programacion';
$SIS_join  = '';
$SIS_where = 'idOT ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
}else{
	//Se revisan los permisos a los contratos
	$SIS_query = 'idLicitacion';
	$SIS_join  = '';
	$SIS_where = 'idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
	$SIS_order = 'idLicitacion ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'usuarios_contratos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	//filtro
	$z = "idLicitacion=0";
	foreach ($arrPermisos as $prod) {
		$z .= " OR (idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idAprobado=2 AND idLicitacion=".$prod['idLicitacion'].")";
	}
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Tarea</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idLicitacion)){     $x0  = $idLicitacion;     }else{$x0  = '';}
				if(isset($idLevel_1)){        $x1  = $idLevel_1;        }else{$x1  = '';}
				if(isset($idLevel_2)){        $x2  = $idLevel_2;        }else{$x2  = '';}
				if(isset($idLevel_3)){        $x3  = $idLevel_3;        }else{$x3  = '';}
				if(isset($idLevel_4)){        $x4  = $idLevel_4;        }else{$x4  = '';}
				if(isset($idLevel_5)){        $x5  = $idLevel_5;        }else{$x5  = '';}
				if(isset($idLevel_6)){        $x6  = $idLevel_6;        }else{$x6  = '';}
				if(isset($idLevel_7)){        $x7  = $idLevel_7;        }else{$x7  = '';}
				if(isset($idLevel_8)){        $x8  = $idLevel_8;        }else{$x8  = '';}
				if(isset($idLevel_9)){        $x9  = $idLevel_9;        }else{$x9  = '';}
				if(isset($idLevel_10)){       $x10  = $idLevel_10;      }else{$x10  = '';}
				if(isset($idLevel_11)){       $x11  = $idLevel_11;      }else{$x11  = '';}
				if(isset($idLevel_12)){       $x12  = $idLevel_12;      }else{$x12  = '';}
				if(isset($idLevel_13)){       $x13  = $idLevel_13;      }else{$x13  = '';}
				if(isset($idLevel_14)){       $x14  = $idLevel_14;      }else{$x14  = '';}
				if(isset($idLevel_15)){       $x15  = $idLevel_15;      }else{$x15  = '';}
				if(isset($idLevel_16)){       $x16  = $idLevel_16;      }else{$x16  = '';}
				if(isset($idLevel_17)){       $x17  = $idLevel_17;      }else{$x17  = '';}
				if(isset($idLevel_18)){       $x18  = $idLevel_18;      }else{$x18  = '';}
				if(isset($idLevel_19)){       $x19  = $idLevel_19;      }else{$x19  = '';}
				if(isset($idLevel_20)){       $x20  = $idLevel_20;      }else{$x20  = '';}
				if(isset($idLevel_21)){       $x21  = $idLevel_21;      }else{$x21  = '';}
				if(isset($idLevel_22)){       $x22  = $idLevel_22;      }else{$x22  = '';}
				if(isset($idLevel_23)){       $x23  = $idLevel_23;      }else{$x23  = '';}
				if(isset($idLevel_24)){       $x24  = $idLevel_24;      }else{$x24  = '';}
				if(isset($idLevel_25)){       $x25  = $idLevel_25;      }else{$x25  = '';}
				if(isset($Observacion)){      $x26  = $Observacion;     }else{$x26  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend25('Contrato','idLicitacion',$x0 ,2,'idLicitacion','Nombre','licitacion_listado',$z,0,
										  'Nivel 1','idLevel_1',$x1 ,2,'idLevel_1','Nombre','licitacion_listado_level_1',0,0,
										  'Nivel 2','idLevel_2',$x2 ,1,'idLevel_2','Nombre','licitacion_listado_level_2',0,0,
										  'Nivel 3','idLevel_3',$x3 ,1,'idLevel_3','Nombre','licitacion_listado_level_3',0,0,
										  'Nivel 4','idLevel_4',$x4 ,1,'idLevel_4','Nombre','licitacion_listado_level_4',0,0,
										  'Nivel 5','idLevel_5',$x5 ,1,'idLevel_5','Nombre','licitacion_listado_level_5',0,0,
										  'Nivel 6','idLevel_6',$x6 ,1,'idLevel_6','Nombre','licitacion_listado_level_6',0,0,
										  'Nivel 7','idLevel_7',$x7 ,1,'idLevel_7','Nombre','licitacion_listado_level_7',0,0,
										  'Nivel 8','idLevel_8',$x8 ,1,'idLevel_8','Nombre','licitacion_listado_level_8',0,0,
										  'Nivel 9','idLevel_9',$x9 ,1,'idLevel_9','Nombre','licitacion_listado_level_9',0,0,
										  'Nivel 10','idLevel_10',$x10 ,1,'idLevel_10','Nombre','licitacion_listado_level_10',0,0,
										  'Nivel 11','idLevel_11',$x11 ,1,'idLevel_11','Nombre','licitacion_listado_level_11',0,0,
										  'Nivel 12','idLevel_12',$x12 ,1,'idLevel_12','Nombre','licitacion_listado_level_12',0,0,
										  'Nivel 13','idLevel_13',$x13 ,1,'idLevel_13','Nombre','licitacion_listado_level_13',0,0,
										  'Nivel 14','idLevel_14',$x14 ,1,'idLevel_14','Nombre','licitacion_listado_level_14',0,0,
										  'Nivel 15','idLevel_15',$x15 ,1,'idLevel_15','Nombre','licitacion_listado_level_15',0,0,
										  'Nivel 16','idLevel_16',$x16 ,1,'idLevel_16','Nombre','licitacion_listado_level_16',0,0,
										  'Nivel 17','idLevel_17',$x17 ,1,'idLevel_17','Nombre','licitacion_listado_level_17',0,0,
										  'Nivel 18','idLevel_18',$x18 ,1,'idLevel_18','Nombre','licitacion_listado_level_18',0,0,
										  'Nivel 19','idLevel_19',$x19 ,1,'idLevel_19','Nombre','licitacion_listado_level_19',0,0,
										  'Nivel 20','idLevel_20',$x20 ,1,'idLevel_20','Nombre','licitacion_listado_level_20',0,0,
										  'Nivel 21','idLevel_21',$x21 ,1,'idLevel_21','Nombre','licitacion_listado_level_21',0,0,
										  'Nivel 22','idLevel_22',$x22 ,1,'idLevel_22','Nombre','licitacion_listado_level_22',0,0,
										  'Nivel 23','idLevel_23',$x23 ,1,'idLevel_23','Nombre','licitacion_listado_level_23',0,0,
										  'Nivel 24','idLevel_24',$x24 ,1,'idLevel_24','Nombre','licitacion_listado_level_24',0,0,
										  $dbConn, 'form1');
				$Form_Inputs->form_textarea('Observacion','Observacion', $x26, 1);

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
				if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
				if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
				if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
				if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
				if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
				$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);
				$Form_Inputs->form_input_hidden('idEstadoTarea', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_tarea">
					<a href="<?php echo $location.'?view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editTarea'])){
//Se traen los datos de la ot
$SIS_query = 'idEstadoTarea, Observacion';
$SIS_join  = '';
$SIS_where = 'idTrabajoOT ='.$_GET['editTarea'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
}else{
	//Se revisan los permisos a los contratos
	$SIS_query = 'idLicitacion';
	$SIS_join  = '';
	$SIS_where = 'idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
	$SIS_order = 'idLicitacion ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'usuarios_contratos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	//filtro
	$z = "idLicitacion=0";
	foreach ($arrPermisos as $prod) {
		$z .= " OR (idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idAprobado=2 AND idLicitacion=".$prod['idLicitacion'].")";
	}
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Tarea</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEstadoTarea)){    $x1  = $idEstadoTarea;   }else{$x1  = $rowData['idEstadoTarea'];}
				if(isset($Observacion)){      $x2  = $Observacion;     }else{$x2  = $rowData['Observacion'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_post_data(1,1,1, 'Una vez marcada la tarea como <strong>realizada</strong> no se podran hacer mas modificaciones');

				$Form_Inputs->form_select('Estado Tarea','idEstadoTarea', $x1, 2, 'idEstadoTarea', 'Nombre', 'core_estado_ot_motivos_tareas', 0, '', $dbConn);
				$Form_Inputs->form_textarea('Observacion','Observacion', $x2, 1);

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idTrabajoOT', $_GET['editTarea'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edittarea">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addProd'])){
//Se traen los datos de la ot
$SIS_query = 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idEstado, idPrioridad, idTipo, f_programacion';
$SIS_join  = '';
$SIS_where = 'idOT ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

//filtro
$SIS_where = "idProducto=0";
foreach ($arrPermisos as $prod) {
	$SIS_where .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
}

//Imprimo las variables
$SIS_query = '
productos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_order = 'sistema_productos_uml.Nombre ASC';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Productos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = '';}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $SIS_where, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
				if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
				if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
				if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
				if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
				if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
				$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);

				?>

				<script>
					/**********************************************************************/
					<?php
					foreach ($arrTipo as $tipo) {
						echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
					}
					?>

					/**********************************************************************/
					document.getElementById("idProducto").onchange = function() {LoadProducto()};

					/**********************************************************************/
					function LoadProducto(){
						let Componente = document.getElementById("idProducto").value;
						if (Componente != "") {
							//escribo dentro del input
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_prod">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_prod'])){
//Se traen los datos de la ot
$SIS_query = '
productos_listado.Nombre AS Producto, 
orden_trabajo_tareas_listado_productos.Cantidad,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `productos_listado`         ON productos_listado.idProducto  = orden_trabajo_tareas_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`     ON sistema_productos_uml.idUml   = productos_listado.idUml';
$SIS_where = 'idProductos ='.$_GET['edit_prod'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_productos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Productos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Cantidad)){  $x1  = $Cantidad; }else{$x1  = $rowData['Cantidad'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Producto</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" value="'.$rowData['Producto'].'" placeholder="Producto" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x1, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" value="'.$rowData['Unidad'].'" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idProductos', $_GET['edit_prod'], 2);
					
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Editar" name="submit_editprod">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addIns'])){
//Se traen los datos de la ot
$SIS_query = 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idEstado, idPrioridad, idTipo, f_programacion';
$SIS_join  = '';
$SIS_where = 'idOT ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

//filtro
$SIS_where = "idProducto=0";
foreach ($arrPermisos as $prod) {
	$SIS_where .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
}

//Imprimo las variables
$SIS_query = '
insumos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml';
$SIS_order = 'sistema_productos_uml.Nombre ASC';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Insumos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = '';}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $SIS_where, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
				if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
				if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
				if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
				if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
				if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
				$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);

				?>

				<script>
					/**********************************************************************/
					<?php
					foreach ($arrTipo as $tipo) {
						echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
					}
					?>

					/**********************************************************************/
					document.getElementById("idProducto").onchange = function() {LoadProducto()};

					/**********************************************************************/
					function LoadProducto(){
						let Componente = document.getElementById("idProducto").value;
						if (Componente != "") {
							//escribo dentro del input
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_ins">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_ins'])){
//Se traen los datos de la ot
$SIS_query = '
insumos_listado.Nombre AS Producto, 
orden_trabajo_tareas_listado_insumos.Cantidad,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto  = orden_trabajo_tareas_listado_insumos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml = insumos_listado.idUml';
$SIS_where = 'idInsumos ='.$_GET['edit_ins'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_insumos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Insumos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Cantidad)){   $x1  = $Cantidad;  }else{$x1  = $rowData['Cantidad'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Insumo</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" value="'.$rowData['Producto'].'" placeholder="Insumo" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x1, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" value="'.$rowData['Unidad'].'" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idInsumos', $_GET['edit_ins'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Editar" name="submit_editins">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addTrab'])){
//Se traen los datos de la ot
$SIS_query = 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idEstado, idPrioridad, idTipo, f_programacion';
$SIS_join  = '';
$SIS_where = 'idOT ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Trabajador</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){     $x1  = $idTrabajador;    }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador responsable','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
				if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
				if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
				if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
				if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
				if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
				$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_trab">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_trab'])){
//Se traen los datos de la ot
$SIS_query = 'idTrabajador';
$SIS_join  = '';
$SIS_where = 'idResponsable ='.$_GET['edit_trab'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_responsable', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Trabajador</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){     $x1  = $idTrabajador;    }else{$x1  = $rowData['idTrabajador'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador responsable','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idResponsable', $_GET['edit_trab'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Editar" name="submit_edittrab">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_obs'])){
//Se traen los datos de la ot
$SIS_query = 'Observaciones';
$SIS_join  = '';
$SIS_where = 'idOT ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar datos basicos de la OT</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Observaciones)){    $x1  = $Observaciones;    }else{$x1  = $rowData['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_textarea('Observacion','Observaciones', $x1, 1);

				$Form_Inputs->form_input_hidden('idOT', $_GET['view'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_editObs">
					<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
// Se trae un listado con todos los elementos
$SIS_query = '
orden_trabajo_tareas_listado.idOT,
orden_trabajo_tareas_listado.f_creacion,
orden_trabajo_tareas_listado.f_programacion,
orden_trabajo_tareas_listado.f_termino,
orden_trabajo_tareas_listado.hora_Inicio,
orden_trabajo_tareas_listado.hora_Termino,
orden_trabajo_tareas_listado.Observaciones,
orden_trabajo_tareas_listado.idEstado,

core_estado_ot_motivos.Nombre AS NombreEstado,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_motivos_tipos.Nombre AS NombreTipo,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5';
$SIS_join  = '
LEFT JOIN `core_estado_ot_motivos`     ON core_estado_ot_motivos.idEstado       = orden_trabajo_tareas_listado.idEstado
LEFT JOIN `core_ot_prioridad`          ON core_ot_prioridad.idPrioridad         = orden_trabajo_tareas_listado.idPrioridad
LEFT JOIN `core_ot_motivos_tipos`      ON core_ot_motivos_tipos.idTipo          = orden_trabajo_tareas_listado.idTipo
LEFT JOIN `ubicacion_listado`          ON ubicacion_listado.idUbicacion         = orden_trabajo_tareas_listado.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`  ON ubicacion_listado_level_1.idLevel_1   = orden_trabajo_tareas_listado.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`  ON ubicacion_listado_level_2.idLevel_2   = orden_trabajo_tareas_listado.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`  ON ubicacion_listado_level_3.idLevel_3   = orden_trabajo_tareas_listado.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`  ON ubicacion_listado_level_4.idLevel_4   = orden_trabajo_tareas_listado.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`  ON ubicacion_listado_level_5.idLevel_5   = orden_trabajo_tareas_listado.idUbicacion_lvl_5';
$SIS_where = 'orden_trabajo_tareas_listado.idOT ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/************************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
orden_trabajo_tareas_listado_responsable.idResponsable,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Cargo, 
trabajadores_listado.Rut';
$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = orden_trabajo_tareas_listado_responsable.idTrabajador';
$SIS_where = 'orden_trabajo_tareas_listado_responsable.idOT ='.$_GET['view'];
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrTrabajadores = array();
$arrTrabajadores = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTrabajadores');

/************************************************************/
// Se trae un listado con todos los insumos utilizados
$SIS_query = '
orden_trabajo_tareas_listado_insumos.idInsumos AS idMain,
insumos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS UnidadMedida,
orden_trabajo_tareas_listado_insumos.Cantidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto    = orden_trabajo_tareas_listado_insumos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'orden_trabajo_tareas_listado_insumos.idOT ='.$_GET['view'];
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrInsumos');

/************************************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
orden_trabajo_tareas_listado_productos.idProductos AS idMain,
productos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS UnidadMedida,
orden_trabajo_tareas_listado_productos.Cantidad AS Cantidad';
$SIS_join  = '
LEFT JOIN `productos_listado`       ON productos_listado.idProducto    = orden_trabajo_tareas_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml     = productos_listado.idUml';
$SIS_where = 'orden_trabajo_tareas_listado_productos.idOT ='.$_GET['view'];
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

/************************************************************/
// Se trae un listado con todos los trabajos relacionados a la orden
$SIS_query = '
orden_trabajo_tareas_listado_tareas.idTrabajoOT,
orden_trabajo_tareas_listado_tareas.Observacion,
orden_trabajo_tareas_listado_tareas.idEstadoTarea,
core_estado_ot_motivos_tareas.Nombre AS EstadoTarea,
licitacion_listado.Nombre AS Licitacion,
licitacion_listado_level_1.Nombre AS LicitacionLVL_1,
licitacion_listado_level_2.Nombre AS LicitacionLVL_2,
licitacion_listado_level_3.Nombre AS LicitacionLVL_3,
licitacion_listado_level_4.Nombre AS LicitacionLVL_4,
licitacion_listado_level_5.Nombre AS LicitacionLVL_5,
licitacion_listado_level_6.Nombre AS LicitacionLVL_6,
licitacion_listado_level_7.Nombre AS LicitacionLVL_7,
licitacion_listado_level_8.Nombre AS LicitacionLVL_8,
licitacion_listado_level_9.Nombre AS LicitacionLVL_9,
licitacion_listado_level_10.Nombre AS LicitacionLVL_10,
licitacion_listado_level_11.Nombre AS LicitacionLVL_11,
licitacion_listado_level_12.Nombre AS LicitacionLVL_12,
licitacion_listado_level_13.Nombre AS LicitacionLVL_13,
licitacion_listado_level_14.Nombre AS LicitacionLVL_14,
licitacion_listado_level_15.Nombre AS LicitacionLVL_15,
licitacion_listado_level_16.Nombre AS LicitacionLVL_16,
licitacion_listado_level_17.Nombre AS LicitacionLVL_17,
licitacion_listado_level_18.Nombre AS LicitacionLVL_18,
licitacion_listado_level_19.Nombre AS LicitacionLVL_19,
licitacion_listado_level_20.Nombre AS LicitacionLVL_20,
licitacion_listado_level_21.Nombre AS LicitacionLVL_21,
licitacion_listado_level_22.Nombre AS LicitacionLVL_22,
licitacion_listado_level_23.Nombre AS LicitacionLVL_23,
licitacion_listado_level_24.Nombre AS LicitacionLVL_24,
licitacion_listado_level_25.Nombre AS LicitacionLVL_25';
$SIS_join  = '
LEFT JOIN `core_estado_ot_motivos_tareas`  ON core_estado_ot_motivos_tareas.idEstadoTarea   = orden_trabajo_tareas_listado_tareas.idEstadoTarea
LEFT JOIN `licitacion_listado`             ON licitacion_listado.idLicitacion               = orden_trabajo_tareas_listado_tareas.idLicitacion
LEFT JOIN `licitacion_listado_level_1`     ON licitacion_listado_level_1.idLevel_1          = orden_trabajo_tareas_listado_tareas.idLevel_1
LEFT JOIN `licitacion_listado_level_2`     ON licitacion_listado_level_2.idLevel_2          = orden_trabajo_tareas_listado_tareas.idLevel_2
LEFT JOIN `licitacion_listado_level_3`     ON licitacion_listado_level_3.idLevel_3          = orden_trabajo_tareas_listado_tareas.idLevel_3
LEFT JOIN `licitacion_listado_level_4`     ON licitacion_listado_level_4.idLevel_4          = orden_trabajo_tareas_listado_tareas.idLevel_4
LEFT JOIN `licitacion_listado_level_5`     ON licitacion_listado_level_5.idLevel_5          = orden_trabajo_tareas_listado_tareas.idLevel_5
LEFT JOIN `licitacion_listado_level_6`     ON licitacion_listado_level_6.idLevel_6          = orden_trabajo_tareas_listado_tareas.idLevel_6
LEFT JOIN `licitacion_listado_level_7`     ON licitacion_listado_level_7.idLevel_7          = orden_trabajo_tareas_listado_tareas.idLevel_7
LEFT JOIN `licitacion_listado_level_8`     ON licitacion_listado_level_8.idLevel_8          = orden_trabajo_tareas_listado_tareas.idLevel_8
LEFT JOIN `licitacion_listado_level_9`     ON licitacion_listado_level_9.idLevel_9          = orden_trabajo_tareas_listado_tareas.idLevel_9
LEFT JOIN `licitacion_listado_level_10`    ON licitacion_listado_level_10.idLevel_10        = orden_trabajo_tareas_listado_tareas.idLevel_10
LEFT JOIN `licitacion_listado_level_11`    ON licitacion_listado_level_11.idLevel_11        = orden_trabajo_tareas_listado_tareas.idLevel_11
LEFT JOIN `licitacion_listado_level_12`    ON licitacion_listado_level_12.idLevel_12        = orden_trabajo_tareas_listado_tareas.idLevel_12
LEFT JOIN `licitacion_listado_level_13`    ON licitacion_listado_level_13.idLevel_13        = orden_trabajo_tareas_listado_tareas.idLevel_13
LEFT JOIN `licitacion_listado_level_14`    ON licitacion_listado_level_14.idLevel_14        = orden_trabajo_tareas_listado_tareas.idLevel_14
LEFT JOIN `licitacion_listado_level_15`    ON licitacion_listado_level_15.idLevel_15        = orden_trabajo_tareas_listado_tareas.idLevel_15
LEFT JOIN `licitacion_listado_level_16`    ON licitacion_listado_level_16.idLevel_16        = orden_trabajo_tareas_listado_tareas.idLevel_16
LEFT JOIN `licitacion_listado_level_17`    ON licitacion_listado_level_17.idLevel_17        = orden_trabajo_tareas_listado_tareas.idLevel_17
LEFT JOIN `licitacion_listado_level_18`    ON licitacion_listado_level_18.idLevel_18        = orden_trabajo_tareas_listado_tareas.idLevel_18
LEFT JOIN `licitacion_listado_level_19`    ON licitacion_listado_level_19.idLevel_19        = orden_trabajo_tareas_listado_tareas.idLevel_19
LEFT JOIN `licitacion_listado_level_20`    ON licitacion_listado_level_20.idLevel_20        = orden_trabajo_tareas_listado_tareas.idLevel_20
LEFT JOIN `licitacion_listado_level_21`    ON licitacion_listado_level_21.idLevel_21        = orden_trabajo_tareas_listado_tareas.idLevel_21
LEFT JOIN `licitacion_listado_level_22`    ON licitacion_listado_level_22.idLevel_22        = orden_trabajo_tareas_listado_tareas.idLevel_22
LEFT JOIN `licitacion_listado_level_23`    ON licitacion_listado_level_23.idLevel_23        = orden_trabajo_tareas_listado_tareas.idLevel_23
LEFT JOIN `licitacion_listado_level_24`    ON licitacion_listado_level_24.idLevel_24        = orden_trabajo_tareas_listado_tareas.idLevel_24
LEFT JOIN `licitacion_listado_level_25`    ON licitacion_listado_level_25.idLevel_25        = orden_trabajo_tareas_listado_tareas.idLevel_25';
$SIS_where = 'orden_trabajo_tareas_listado_tareas.idOT ='.$_GET['view'];
$SIS_order = 'licitacion_listado.Nombre ASC';
$arrTarea = array();
$arrTarea = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTarea');

/************************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = 'idAdjunto, idTrabajoOT, NombreArchivo';
$SIS_join  = '';
$SIS_where = 'idOT ='.$_GET['view'];
$SIS_order = 'NombreArchivo ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas_adjuntos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArchivos');

/************************************************************/
// Se trae un listado con el historial
$SIS_query = '
orden_trabajo_tareas_listado_historial.Creacion_fecha, 
orden_trabajo_tareas_listado_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = orden_trabajo_tareas_listado_historial.idTipo
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = orden_trabajo_tareas_listado_historial.idUsuario';
$SIS_where = 'orden_trabajo_tareas_listado_historial.idOT ='.$_GET['view'];
$SIS_order = 'orden_trabajo_tareas_listado_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrHistorial');

?>

<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive">
	<div id="page-wrap">
		<div id="header"> ORDEN DE TRABAJO N° <?php echo n_doc($_GET['view'], 8); ?></div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"></td>
					</tr>
					<tr>
						<td class="meta-head">Ubicación</td>
						<td>
							<?php echo $rowData['Ubicacion'];
							if(isset($rowData['UbicacionLVL_1'])&&$rowData['UbicacionLVL_1']!=''){echo ' - '.$rowData['UbicacionLVL_1'];}
							if(isset($rowData['UbicacionLVL_2'])&&$rowData['UbicacionLVL_2']!=''){echo ' - '.$rowData['UbicacionLVL_2'];}
							if(isset($rowData['UbicacionLVL_3'])&&$rowData['UbicacionLVL_3']!=''){echo ' - '.$rowData['UbicacionLVL_3'];}
							if(isset($rowData['UbicacionLVL_4'])&&$rowData['UbicacionLVL_4']!=''){echo ' - '.$rowData['UbicacionLVL_4'];}
							if(isset($rowData['UbicacionLVL_5'])&&$rowData['UbicacionLVL_5']!=''){echo ' - '.$rowData['UbicacionLVL_5'];}
							?>
						</td>
					</tr>
					<tr>
						<td class="meta-head">Prioridad</td>
						<td><?php echo $rowData['NombrePrioridad']?></td>
					</tr>
					<tr>
						<td class="meta-head">Tipo de Trabajo</td>
						<td><?php echo $rowData['NombreTipo']?></td>
					</tr>
					<tr>
						<td class="meta-head">Estado</td>
						<td><?php echo $rowData['NombreEstado']?></td>
					</tr>

				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>

					<?php if($rowData['f_creacion']!='0000-00-00'){ ?>
						<tr>
							<td class="meta-head">Fecha creación</td>
							<td><?php if($rowData['f_creacion']!='0000-00-00'){echo Fecha_estandar($rowData['f_creacion']);} ?></td>
						</tr>
					<?php } ?>

					<?php if($rowData['f_programacion']!='0000-00-00'){ ?>
						<tr>
							<td class="meta-head">Fecha programada</td>
							<td><?php if($rowData['f_programacion']!='0000-00-00'){echo Fecha_estandar($rowData['f_programacion']);} ?></td>
						</tr>
					<?php } ?>

					<?php if($rowData['f_termino']!='0000-00-00'){ ?>
						<tr>
							<td class="meta-head">Fecha termino</td>
							<td><?php if($rowData['f_termino']!='0000-00-00'){echo Fecha_estandar($rowData['f_termino']);} ?></td>
						</tr>
					<?php } ?>

					<?php if($rowData['hora_Inicio']!='00:00:00'){ ?>
						<tr>
							<td class="meta-head">Hora inicio</td>
							<td><?php if($rowData['hora_Inicio']!='00:00:00'){echo $rowData['hora_Inicio'];} ?></td>
						</tr>
					<?php } ?>

					<?php if($rowData['hora_Termino']!='00:00:00'){ ?>
						<tr>
							<td class="meta-head">Hora termino</td>
							<td><?php if($rowData['hora_Termino']!='00:00:00'){echo $rowData['hora_Termino'];} ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
		<table id="items">
			<tbody>

				<tr>
					<th colspan="5">Detalle</th>
					<th width="160">Acciones</th>
				</tr>

				<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="5">Trabajadores  <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Encargados';}else{echo 'Utilizados';} ?></td>
						<td>
							<?php //Si la OT solo esta programada
							if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']<3){ ?>
								<a href="<?php echo $location.'?view='.$_GET['view'].'&addTrab=true' ?>" title="Agregar Trabajadores" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Trabajadores</a>
							<?php } ?>
						</td>
					</tr>
					<?php foreach ($arrTrabajadores as $trab) {  ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $trab['Rut']; ?></td>
							<td class="item-name" colspan="3"><?php echo $trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat']; ?></td>
							<td class="item-name"><?php echo $trab['Cargo']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php //Si la OT solo esta programada
									if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']<3){ ?>
										<a href="<?php echo $location.'?view='.$_GET['view'].'&edit_trab='.$trab['idResponsable']; ?>" title="Editar Trabajador" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php
										$ubicacion = $location.'?view='.$_GET['view'].'&del_trab='.simpleEncode($trab['idResponsable'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar al trabajador '.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Trabajador" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr id="hiderow"><td colspan="6"></td></tr>
				<?php /**********************************************************************************/ ?>
					<tr class="item-row fact_tittle">
						<td colspan="5">Insumos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Utilizados';} ?></td>
						<td>
							<?php //Si la OT solo esta programada
							if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']<3){ ?>
								<a href="<?php echo $location.'?view='.$_GET['view'].'&addIns=true' ?>" title="Agregar Insumos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumos</a>
							<?php } ?>
						</td>
					</tr>
					<?php foreach ($arrInsumos as $insumos) {
						if(isset($insumos['Cantidad'])&&$insumos['Cantidad']!=0){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="4"><?php echo $insumos['NombreProducto']; if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){echo ' - '.$prod['NombreBodega'];} ?></td>
								<td class="item-name"><?php echo $insumos['Cantidad'].' '.$insumos['UnidadMedida']; ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php //Si la OT solo esta programada
										if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']<3){ ?>
											<a href="<?php echo $location.'?view='.$_GET['view'].'&edit_ins='.$insumos['idMain']; ?>" title="Editar Insumos" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											<?php
											$ubicacion = $location.'?view='.$_GET['view'].'&del_ins='.simpleEncode($insumos['idMain'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el insumo '.$insumos['NombreProducto'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Insumo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
					} ?>
					<tr id="hiderow"><td colspan="6"></td></tr>
				<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="5">Productos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Utilizados';} ?></td>
						<td>
							<?php //Si la OT solo esta programada
							if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']<3){ ?>
								<a href="<?php echo $location.'?view='.$_GET['view'].'&addProd=true' ?>" title="Agregar Productos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a>
							<?php } ?>
						</td>
					</tr>
					<?php foreach ($arrProductos as $prod) {
						if(isset($prod['Cantidad'])&&$prod['Cantidad']!=0){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="4"><?php echo $prod['NombreProducto']; if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){echo ' - '.$prod['NombreBodega'];} ?></td>
								<td class="item-name"><?php echo $prod['Cantidad'].' '.$prod['UnidadMedida']; ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php //Si la OT solo esta programada
										if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']<3){ ?>
											<a href="<?php echo $location.'?view='.$_GET['view'].'&edit_prod='.$prod['idMain']; ?>" title="Editar Productos" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											<?php
											$ubicacion = $location.'?view='.$_GET['view'].'&del_prod='.simpleEncode($prod['idMain'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el producto '.$prod['NombreProducto'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
					} ?>
					<tr id="hiderow"><td colspan="6"></td></tr>
				<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="5">Tareas <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Ejecutados';} ?></td>
						<td>
							<?php //Si la OT solo esta programada
							if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']<3){ ?>
								<a href="<?php echo $location.'?view='.$_GET['view'].'&addTarea=true' ?>" title="Agregar Tareas" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Tarea</a>
							<?php } ?>
						</td>
					</tr>
					<?php foreach ($arrTarea as $tarea) {
						$s_tarea = $tarea['LicitacionLVL_1'];
						if(isset($tarea['LicitacionLVL_2'])&&$tarea['LicitacionLVL_2']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_2'];}
						if(isset($tarea['LicitacionLVL_3'])&&$tarea['LicitacionLVL_3']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_3'];}
						if(isset($tarea['LicitacionLVL_4'])&&$tarea['LicitacionLVL_4']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_4'];}
						if(isset($tarea['LicitacionLVL_5'])&&$tarea['LicitacionLVL_5']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_5'];}
						if(isset($tarea['LicitacionLVL_6'])&&$tarea['LicitacionLVL_6']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_6'];}
						if(isset($tarea['LicitacionLVL_7'])&&$tarea['LicitacionLVL_7']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_7'];}
						if(isset($tarea['LicitacionLVL_8'])&&$tarea['LicitacionLVL_8']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_8'];}
						if(isset($tarea['LicitacionLVL_9'])&&$tarea['LicitacionLVL_9']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_9'];}
						if(isset($tarea['LicitacionLVL_10'])&&$tarea['LicitacionLVL_10']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_10'];}
						if(isset($tarea['LicitacionLVL_11'])&&$tarea['LicitacionLVL_11']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_11'];}
						if(isset($tarea['LicitacionLVL_12'])&&$tarea['LicitacionLVL_12']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_12'];}
						if(isset($tarea['LicitacionLVL_13'])&&$tarea['LicitacionLVL_13']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_13'];}
						if(isset($tarea['LicitacionLVL_14'])&&$tarea['LicitacionLVL_14']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_14'];}
						if(isset($tarea['LicitacionLVL_15'])&&$tarea['LicitacionLVL_15']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_15'];}
						if(isset($tarea['LicitacionLVL_16'])&&$tarea['LicitacionLVL_16']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_16'];}
						if(isset($tarea['LicitacionLVL_17'])&&$tarea['LicitacionLVL_17']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_17'];}
						if(isset($tarea['LicitacionLVL_18'])&&$tarea['LicitacionLVL_18']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_18'];}
						if(isset($tarea['LicitacionLVL_19'])&&$tarea['LicitacionLVL_19']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_19'];}
						if(isset($tarea['LicitacionLVL_20'])&&$tarea['LicitacionLVL_20']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_20'];}
						if(isset($tarea['LicitacionLVL_21'])&&$tarea['LicitacionLVL_21']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_21'];}
						if(isset($tarea['LicitacionLVL_22'])&&$tarea['LicitacionLVL_22']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_22'];}
						if(isset($tarea['LicitacionLVL_23'])&&$tarea['LicitacionLVL_23']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_23'];}
						if(isset($tarea['LicitacionLVL_24'])&&$tarea['LicitacionLVL_24']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_24'];}
						if(isset($tarea['LicitacionLVL_25'])&&$tarea['LicitacionLVL_25']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_25'];}
						?>
						<tr class="item-row linea_punteada">
							<td class="item-name">
								<strong>Estado: </strong><?php echo $tarea['EstadoTarea']; ?>
							</td>
							<td class="item-name" colspan="4">
								<strong>Licitacion: </strong><?php echo $tarea['Licitacion']; ?><br/>
								<strong>Tarea: </strong><?php echo $s_tarea; ?><br/>
								<strong>Observacion: </strong><?php echo $tarea['Observacion']; ?>
							</td>
							<td class="item-name">
								<div class="btn-group" style="width: 105px;" >
									<?php
									//Solo si esta programada
									if(isset($tarea['idEstadoTarea'])&&$tarea['idEstadoTarea']==1){
										$ubicacion  = $location.'?view='.$_GET['view'];
										$dialogo = 'Deseas borrar la tarea';

										//Boton para cambiar agregar archivos
										echo '<a href="'.$ubicacion.'&addFile='.$tarea['idTrabajoOT'].'" title="Agregar Archivos" class="btn btn-success btn-sm tooltip"><i class="fa fa-upload" aria-hidden="true"></i></a>';
										//Boton para cambiar el estado de la tarea
										echo '<a href="'.$ubicacion.'&editTarea='.$tarea['idTrabajoOT'].'" title="Editar Tarea" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
										echo '<a onClick="dialogBox(\''.$ubicacion.'&del_tarea='.$tarea['idTrabajoOT'].'\', \''.$dialogo.'\')" title="Borrar Trabajo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';	
									}
									?>	
								</div>
							</td>
						</tr>
						<?php if($arrArchivos){
								$zxcv = 0;
								foreach ($arrArchivos as $arch) {
									if(isset($arch['idTrabajoOT'])&&$arch['idTrabajoOT']==$tarea['idTrabajoOT']){
										$zxcv++;
									}
								}
								if($zxcv!=0){
								?>
									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="6">
											<strong>Archivos Adjuntos Tarea: </strong><?php echo $s_tarea; ?><br/>
											<div class="row">
												<?php foreach ($arrArchivos as $arch) { ?>
													<?php if(isset($arch['idTrabajoOT'])&&$arch['idTrabajoOT']==$tarea['idTrabajoOT']){ ?>
														<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
															<img src="upload/<?php echo $arch['NombreArchivo']; ?>" class="img-responsive">
															<?php
															if(isset($tarea['idEstadoTarea'])&&$tarea['idEstadoTarea']==1){
																$ubicacion  = $location.'?view='.$_GET['view'];
																$dialogo = 'Deseas borrar el archivo?';
																
																//Boton para borrar archivos
																echo '<a onClick="dialogBox(\''.$ubicacion.'&del_file='.$arch['idAdjunto'].'\', \''.$dialogo.'\')" title="Borrar Archivo" class="btn btn-xs btn-metis-1 tooltip" style="position: initial;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Archivo</a>';	
															} ?>
														</div>
													<?php } ?>
												<?php } ?>
											</div>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
					<?php } ?>

					<?php /**********************************************************************************/?>

					<tr id="hiderow"><td colspan="6"></td></tr>
				<?php /**********************************************************************************/?>

				<tr>
					<td colspan="5" class="blank"><p><?php echo $rowData['Observaciones']?></p></td>
					<td class="blank">
						<div class="btn-group" style="width: 35px;" >
							<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']<3){ ?>
								<a href="<?php echo $location.'?view='.$_GET['view'].'&edit_obs=true'; ?>" title="Editar Observacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							<?php } ?>
						</div>
					</td>
				</tr>
				<tr><td colspan="6" class="blank"><p>Observacion</p></td></tr>

			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>
<br/>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">
	<div class="row">
		<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
			<div class="table-responsive">
				<table id="items">
					<tbody>
						<tr>
							<th colspan="3">Historial</th>
						</tr>
						<tr>
							<th width="160">Fecha</th>
							<th>Usuario</th>
							<th>Observacion</th>
						</tr>
						<?php foreach ($arrHistorial as $doc){ ?>
							<tr class="item-row">
								<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
								<td><?php echo $doc['Usuario']; ?></td>
								<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
</div>
  
<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location; ?>"  class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'id_asc':             $order_by = 'orden_trabajo_tareas_listado.idOT ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> ID Ascendente'; break;
		case 'id_desc':            $order_by = 'orden_trabajo_tareas_listado.idOT DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';break;
		case 'fprog_asc':          $order_by = 'orden_trabajo_tareas_listado.f_programacion ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Programacion Ascendente';break;
		case 'fprog_desc':         $order_by = 'orden_trabajo_tareas_listado.f_programacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Programacion Descendente';break;
		case 'ejecucion_asc':      $order_by = 'core_estado_ot_motivos.Nombre ASC ';                $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ejecucion Ascendente';break;
		case 'ejecucion_desc':     $order_by = 'core_estado_ot_motivos.Nombre DESC ';               $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Ejecucion Descendente';break;
		case 'ubicacion_asc':      $order_by = 'ubicacion_listado.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Ubicación Ascendente'; break;
		case 'ubicacion_desc':     $order_by = 'ubicacion_listado.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Ubicación Descendente';break;
		case 'prioridad_asc':      $order_by = 'core_ot_prioridad.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prioridad Ascendente';break;
		case 'prioridad_desc':     $order_by = 'core_ot_prioridad.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Prioridad Descendente';break;
		case 'tipotrab_asc':       $order_by = 'core_ot_motivos_tipos.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Trabajo Ascendente'; break;
		case 'tipotrab_desc':      $order_by = 'core_ot_motivos_tipos.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Trabajo Descendente';break;

		default: $order_by = 'orden_trabajo_tareas_listado.idEstado DESC, orden_trabajo_tareas_listado.f_programacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Ejecucion, Fecha Programacion Descendente';
	}
}else{
	$order_by = 'orden_trabajo_tareas_listado.idEstado DESC, orden_trabajo_tareas_listado.f_programacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Ejecucion, Fecha Programacion Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "orden_trabajo_tareas_listado.idOT!=0";
$SIS_where .= " AND orden_trabajo_tareas_listado.idEstado < 3";//solo las Programada y En Ejecucion
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
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){             $SIS_where .= " AND orden_trabajo_tareas_listado.idEstado=".$_GET['Nombre'];}
/**********************************************************/

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
core_ot_motivos_tipos.Nombre AS NombreTipo,
core_estado_ot_motivos.Nombre AS NombreEstado';
$SIS_join  = '
LEFT JOIN `core_estado_ot_motivos`      ON core_estado_ot_motivos.idEstado       = orden_trabajo_tareas_listado.idEstado
LEFT JOIN `core_ot_prioridad`           ON core_ot_prioridad.idPrioridad         = orden_trabajo_tareas_listado.idPrioridad
LEFT JOIN `core_ot_motivos_tipos`       ON core_ot_motivos_tipos.idTipo          = orden_trabajo_tareas_listado.idTipo
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = orden_trabajo_tareas_listado.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = orden_trabajo_tareas_listado.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = orden_trabajo_tareas_listado.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = orden_trabajo_tareas_listado.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = orden_trabajo_tareas_listado.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = orden_trabajo_tareas_listado.idUbicacion_lvl_5';
$SIS_order = $order_by;
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
				if(isset($idEstado)){            $x11 = $idEstado;            }else{$x11 = '';}

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
				$Form_Inputs->form_select('Estado Ejecucion','idEstado', $x11, 1, 'idEstado', 'Nombre', 'core_estado_ot_motivos', 'idEstado<3', '', $dbConn);

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
							<div class="pull-left">Estado Ejecucion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=ejecucion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=ejecucion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
						<td><?php echo $ot['NombreEstado']; ?></td>
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
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_orden_tarea_trabajo.php?view='.simpleEncode($ot['idOT'], fecha_actual()); ?>" title="Ver Orden de Trabajo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'?view='.$ot['idOT']; ?>" title="Ejecutar Orden de Trabajo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
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
