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
$original = "trabajadores_horas_extras.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){     $location .= "&idTrabajador=".$_GET['idTrabajador'];     $search .= "&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['N_Doc']) && $_GET['N_Doc']!=''){            $location .= "&N_Doc=".$_GET['N_Doc'];                   $search .= "&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){   $location .= "&Observaciones=".$_GET['Observaciones'];   $search .= "&Observaciones=".$_GET['Observaciones'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_ingreso';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
//formulario para editar
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_horas'])){
	//Llamamos al formulario
	$form_trabajo= 'new_horas_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_horas'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_horas_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
//se borra un dato
if (!empty($_GET['del_horas'])){
	//Llamamos al formulario
	$form_trabajo= 'del_horas_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
/**********************************************/
if (!empty($_GET['ing_bodega'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_bodega';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_horas_extras.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Boleta de Honorarios Realizada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Boleta de Honorarios Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Boleta de Honorarios Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['addFile'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Subir Archivo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php
				//Se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 1, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editHora'])){  
//Verifico el tipo de usuario que esta ingresando
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Horas Extras</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){      $x0   = $idTrabajador;      }else{$x0   = $_GET['idTrabajador'];}
				if(isset($horas_dia_1)){       $x1   = $horas_dia_1;       }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_1']]['horas_dia'])){       $x1   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_1']]['horas_dia'];       }else{$x1   = '';}
				if(isset($horas_dia_2)){       $x2   = $horas_dia_2;       }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_2']]['horas_dia'])){       $x2   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_2']]['horas_dia'];       }else{$x2   = '';}
				if(isset($horas_dia_3)){       $x3   = $horas_dia_3;       }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_3']]['horas_dia'])){       $x3   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_3']]['horas_dia'];       }else{$x3   = '';}
				if(isset($horas_dia_4)){       $x4   = $horas_dia_4;       }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_4']]['horas_dia'])){       $x4   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_4']]['horas_dia'];       }else{$x4   = '';}
				if(isset($horas_dia_5)){       $x5   = $horas_dia_5;       }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_5']]['horas_dia'])){       $x5   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_5']]['horas_dia'];       }else{$x5   = '';}
				if(isset($horas_dia_6)){       $x6   = $horas_dia_6;       }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_6']]['horas_dia'])){       $x6   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_6']]['horas_dia'];       }else{$x6   = '';}
				if(isset($horas_dia_7)){       $x7   = $horas_dia_7;       }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_7']]['horas_dia'])){       $x7   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_7']]['horas_dia'];       }else{$x7   = '';}
				if(isset($porcentaje_dia_1)){  $x8   = $porcentaje_dia_1;  }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_1']]['porcentaje_dia'])){  $x8   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_1']]['porcentaje_dia'];  }else{$x8   = '';}
				if(isset($porcentaje_dia_2)){  $x9   = $porcentaje_dia_2;  }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_2']]['porcentaje_dia'])){  $x9   = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_2']]['porcentaje_dia'];  }else{$x9   = '';}
				if(isset($porcentaje_dia_3)){  $x10  = $porcentaje_dia_3;  }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_3']]['porcentaje_dia'])){  $x10  = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_3']]['porcentaje_dia'];  }else{$x10  = '';}
				if(isset($porcentaje_dia_4)){  $x11  = $porcentaje_dia_4;  }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_4']]['porcentaje_dia'])){  $x11  = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_4']]['porcentaje_dia'];  }else{$x11  = '';}
				if(isset($porcentaje_dia_5)){  $x12  = $porcentaje_dia_5;  }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_5']]['porcentaje_dia'])){  $x12  = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_5']]['porcentaje_dia'];  }else{$x12  = '';}
				if(isset($porcentaje_dia_6)){  $x13  = $porcentaje_dia_6;  }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_6']]['porcentaje_dia'])){  $x13  = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_6']]['porcentaje_dia'];  }else{$x13  = '';}
				if(isset($porcentaje_dia_7)){  $x14  = $porcentaje_dia_7;  }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_7']]['porcentaje_dia'])){  $x14  = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']][$_GET['fecha_dia_7']]['porcentaje_dia'];  }else{$x14  = '';}
				if(isset($idTurnos)){          $x15  = $idTurnos;          }elseif(isset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']]['idTurnos'])){                              $x15  = $_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']]['idTurnos'];                              }else{$x15  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x0, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
				if(isset($_GET['fecha_dia_1'])&&$_GET['fecha_dia_1']){
					$Form_Inputs->form_input_number('N° Horas Lunes '.fecha_estandar($_GET['fecha_dia_1']), 'horas_dia_1', $x1, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_1', $x8, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_2'])&&$_GET['fecha_dia_2']){
					$Form_Inputs->form_input_number('N° Horas Martes '.fecha_estandar($_GET['fecha_dia_2']), 'horas_dia_2', $x2, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_2', $x9, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_3'])&&$_GET['fecha_dia_3']){
					$Form_Inputs->form_input_number('N° Horas Miercoles '.fecha_estandar($_GET['fecha_dia_3']), 'horas_dia_3', $x3, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_3', $x10, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_4'])&&$_GET['fecha_dia_4']){
					$Form_Inputs->form_input_number('N° Horas Jueves '.fecha_estandar($_GET['fecha_dia_4']), 'horas_dia_4', $x4, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_4', $x11, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_5'])&&$_GET['fecha_dia_5']){
					$Form_Inputs->form_input_number('N° Horas Viernes '.fecha_estandar($_GET['fecha_dia_5']), 'horas_dia_5', $x5, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_5', $x12, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_6'])&&$_GET['fecha_dia_6']){
					$Form_Inputs->form_input_number('N° Horas Sabado '.fecha_estandar($_GET['fecha_dia_6']), 'horas_dia_6', $x6, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_6', $x13, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_7'])&&$_GET['fecha_dia_7']){
					$Form_Inputs->form_input_number('N° Horas Domingo '.fecha_estandar($_GET['fecha_dia_7']), 'horas_dia_7', $x7, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_7', $x14, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				//Turno
				$Form_Inputs->form_select('Turno','idTurnos', $x15, 2, 'idTurnos', 'Nombre', 'core_horas_extras_turnos', 0, '', $dbConn);

				//Envio otros datos
				if(isset($_GET['nSem'])&&$_GET['nSem']){                 $Form_Inputs->form_input_hidden('nSem', $_GET['nSem'], 2);}
				if(isset($_GET['fecha_dia_1'])&&$_GET['fecha_dia_1']){   $Form_Inputs->form_input_hidden('fecha_dia_1', $_GET['fecha_dia_1'], 2);}
				if(isset($_GET['fecha_dia_2'])&&$_GET['fecha_dia_2']){   $Form_Inputs->form_input_hidden('fecha_dia_2', $_GET['fecha_dia_2'], 2);}
				if(isset($_GET['fecha_dia_3'])&&$_GET['fecha_dia_3']){   $Form_Inputs->form_input_hidden('fecha_dia_3', $_GET['fecha_dia_3'], 2);}
				if(isset($_GET['fecha_dia_4'])&&$_GET['fecha_dia_4']){   $Form_Inputs->form_input_hidden('fecha_dia_4', $_GET['fecha_dia_4'], 2);}
				if(isset($_GET['fecha_dia_5'])&&$_GET['fecha_dia_5']){   $Form_Inputs->form_input_hidden('fecha_dia_5', $_GET['fecha_dia_5'], 2);}
				if(isset($_GET['fecha_dia_6'])&&$_GET['fecha_dia_6']){   $Form_Inputs->form_input_hidden('fecha_dia_6', $_GET['fecha_dia_6'], 2);}
				if(isset($_GET['fecha_dia_7'])&&$_GET['fecha_dia_7']){   $Form_Inputs->form_input_hidden('fecha_dia_7', $_GET['fecha_dia_7'], 2);}
				
				
				
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_horas">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addHora'])){  
//Verifico el tipo de usuario que esta ingresando
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Horas Extras</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){      $x0   = $idTrabajador;      }else{$x0   = '';}
				if(isset($horas_dia_1)){       $x1   = $horas_dia_1;       }else{$x1   = '';}
				if(isset($horas_dia_2)){       $x2   = $horas_dia_2;       }else{$x2   = '';}
				if(isset($horas_dia_3)){       $x3   = $horas_dia_3;       }else{$x3   = '';}
				if(isset($horas_dia_4)){       $x4   = $horas_dia_4;       }else{$x4   = '';}
				if(isset($horas_dia_5)){       $x5   = $horas_dia_5;       }else{$x5   = '';}
				if(isset($horas_dia_6)){       $x6   = $horas_dia_6;       }else{$x6   = '';}
				if(isset($horas_dia_7)){       $x7   = $horas_dia_7;       }else{$x7   = '';}
				if(isset($porcentaje_dia_1)){  $x8   = $porcentaje_dia_1;  }else{$x8   = '1';}
				if(isset($porcentaje_dia_2)){  $x9   = $porcentaje_dia_2;  }else{$x9   = '1';}
				if(isset($porcentaje_dia_3)){  $x10  = $porcentaje_dia_3;  }else{$x10  = '1';}
				if(isset($porcentaje_dia_4)){  $x11  = $porcentaje_dia_4;  }else{$x11  = '1';}
				if(isset($porcentaje_dia_5)){  $x12  = $porcentaje_dia_5;  }else{$x12  = '1';}
				if(isset($porcentaje_dia_6)){  $x13  = $porcentaje_dia_6;  }else{$x13  = '1';}
				if(isset($porcentaje_dia_7)){  $x14  = $porcentaje_dia_7;  }else{$x14  = '1';}
				if(isset($idTurnos)){          $x15  = $idTurnos;          }else{$x15  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x0, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
				if(isset($_GET['fecha_dia_1'])&&$_GET['fecha_dia_1']){
					$Form_Inputs->form_input_number('N° Horas Lunes '.fecha_estandar($_GET['fecha_dia_1']), 'horas_dia_1', $x1, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_1', $x8, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_2'])&&$_GET['fecha_dia_2']){
					$Form_Inputs->form_input_number('N° Horas Martes '.fecha_estandar($_GET['fecha_dia_2']), 'horas_dia_2', $x2, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_2', $x9, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_3'])&&$_GET['fecha_dia_3']){
					$Form_Inputs->form_input_number('N° Horas Miercoles '.fecha_estandar($_GET['fecha_dia_3']), 'horas_dia_3', $x3, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_3', $x10, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_4'])&&$_GET['fecha_dia_4']){
					$Form_Inputs->form_input_number('N° Horas Jueves '.fecha_estandar($_GET['fecha_dia_4']), 'horas_dia_4', $x4, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_4', $x11, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_5'])&&$_GET['fecha_dia_5']){
					$Form_Inputs->form_input_number('N° Horas Viernes '.fecha_estandar($_GET['fecha_dia_5']), 'horas_dia_5', $x5, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_5', $x12, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_6'])&&$_GET['fecha_dia_6']){
					$Form_Inputs->form_input_number('N° Horas Sabado '.fecha_estandar($_GET['fecha_dia_6']), 'horas_dia_6', $x6, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_6', $x13, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				if(isset($_GET['fecha_dia_7'])&&$_GET['fecha_dia_7']){
					$Form_Inputs->form_input_number('N° Horas Domingo '.fecha_estandar($_GET['fecha_dia_7']), 'horas_dia_7', $x7, 1);
					$Form_Inputs->form_select('Porcentaje Horas','porcentaje_dia_7', $x14, 1, 'idPorcentaje', 'Porcentaje', 'core_horas_extras_porcentajes', 0, '', $dbConn);
				}
				//Turno
				$Form_Inputs->form_select('Turno','idTurnos', $x15, 2, 'idTurnos', 'Nombre', 'core_horas_extras_turnos', 0, '', $dbConn);

				//Envio otros datos
				if(isset($_GET['nSem'])&&$_GET['nSem']){                 $Form_Inputs->form_input_hidden('nSem', $_GET['nSem'], 2);}
				if(isset($_GET['fecha_dia_1'])&&$_GET['fecha_dia_1']){   $Form_Inputs->form_input_hidden('fecha_dia_1', $_GET['fecha_dia_1'], 2);}
				if(isset($_GET['fecha_dia_2'])&&$_GET['fecha_dia_2']){   $Form_Inputs->form_input_hidden('fecha_dia_2', $_GET['fecha_dia_2'], 2);}
				if(isset($_GET['fecha_dia_3'])&&$_GET['fecha_dia_3']){   $Form_Inputs->form_input_hidden('fecha_dia_3', $_GET['fecha_dia_3'], 2);}
				if(isset($_GET['fecha_dia_4'])&&$_GET['fecha_dia_4']){   $Form_Inputs->form_input_hidden('fecha_dia_4', $_GET['fecha_dia_4'], 2);}
				if(isset($_GET['fecha_dia_5'])&&$_GET['fecha_dia_5']){   $Form_Inputs->form_input_hidden('fecha_dia_5', $_GET['fecha_dia_5'], 2);}
				if(isset($_GET['fecha_dia_6'])&&$_GET['fecha_dia_6']){   $Form_Inputs->form_input_hidden('fecha_dia_6', $_GET['fecha_dia_6'], 2);}
				if(isset($_GET['fecha_dia_7'])&&$_GET['fecha_dia_7']){   $Form_Inputs->form_input_hidden('fecha_dia_7', $_GET['fecha_dia_7'], 2);}
				
				
				
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_horas">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar datos basicos del Ingreso</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){  $x1  = $Creacion_fecha;     }else{$x1  = $_SESSION['horas_extras_ing_basicos']['Creacion_fecha'];}
				if(isset($Fecha_desde)){     $x2  = $Fecha_desde;        }else{$x2  = $_SESSION['horas_extras_ing_basicos']['Fecha_desde'];}
				if(isset($Fecha_hasta)){     $x3  = $Fecha_hasta;        }else{$x3  = $_SESSION['horas_extras_ing_basicos']['Fecha_hasta'];}
				if(isset($Observaciones)){   $x4  = $Observaciones;      }else{$x4  = $_SESSION['horas_extras_ing_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Facturacion','Creacion_fecha', $x1, 2);
				$Form_Inputs->form_date('Periodo Inicio','Fecha_desde', $x2, 2);
				$Form_Inputs->form_date('Periodo Termino','Fecha_hasta', $x3, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x4, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);

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

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger dialogBox"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&ing_bodega=true';
		$dialogo   = '¿Realmente desea ingresar el documento, una vez realizada no podra realizar cambios?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Ingreso Horas Extras</div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Desde</td>
						<td><?php echo Fecha_estandar($_SESSION['horas_extras_ing_basicos']['Fecha_desde']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Hasta</td>
						<td><?php echo Fecha_estandar($_SESSION['horas_extras_ing_basicos']['Fecha_hasta']); ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Facturacion</td>
						<td colspan="2"><?php echo Fecha_estandar($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']); ?></td>
					</tr>
				</tbody>
			</table>

				
		</div>
		<table id="items">
			<tbody>

				<tr>
					<th colspan="10">Detalle</th>
					<th width="160">Acciones</th>
				</tr>

				<tr class="item-row fact_tittle">
					<td>Trabajador</td>
					<td>N° Semana</td>
					<td>Lunes</td>
					<td>Martes</td>
					<td>Miercoles</td>
					<td>Jueves</td>
					<td>Viernes</td>
					<td>Sabado</td>
					<td>Domingo</td>
					<td>Turno</td>
					<td width="160">Acciones</td>
				</tr>

				<?php
				//Obtengo el numero de semanas de la seleccion
				$nSemanas      = ceil ((dias_transcurridos($_SESSION['horas_extras_ing_basicos']['Fecha_desde'],$_SESSION['horas_extras_ing_basicos']['Fecha_hasta']))/7);
				$DiaActual     = $_SESSION['horas_extras_ing_basicos']['Fecha_desde'];
				$nDias         = dias_transcurridos($_SESSION['horas_extras_ing_basicos']['Fecha_desde'],$_SESSION['horas_extras_ing_basicos']['Fecha_hasta']);
				$Dia           = 1;
				$DiaActual_ex  = $_SESSION['horas_extras_ing_basicos']['Fecha_desde'];
				$Dia_ex        = 1;
				$TotalHoras    = array();
				//elimino los datos temporales guardados
				unset($_SESSION['horas_extras_mens_ing_horas']);
						
				
						
						
				//Recorro las semanas seleccionadas
				for($xsi1=1;$xsi1<=$nSemanas;$xsi1++){
					echo '<tr class="item-row fact_tittle">';
					//Cadena para los dias disponibles
					$cadena = '';
					//Recorro los dias de la semana
					for($i=1;$i<=7;$i++){
						//imprimo la primera celda y el numero de semana actual
						if($xsi1==1&&$i==1){
							$nSem = fecha2NSemana($_SESSION['horas_extras_ing_basicos']['Fecha_desde']);
							echo '<td></td>';
							echo '<td>'.$nSem.'</td>';
						}elseif($xsi1!=1&&$i==1){
							$nSem = fecha2NSemana($DiaActual);
							echo '<td></td>';
							echo '<td>'.$nSem.'</td>';
						}
						//Imprimo la fecha en caso de existir
						if($i==fecha2NDiaSemana($DiaActual)&&$Dia<=($nDias+1)){
							$cadena .= '&fecha_dia_'.$i.'='.$DiaActual;
							echo '<td>'.Fecha_estandar($DiaActual).'</td>';
							$DiaActual = sumarDias($DiaActual,1);
							$Dia++;
						}else{
							echo '<td></td>';
						}

					}
					echo '<td></td>';
					echo '<td><a href="'.$location.'&addHora=true&nSem='.$nSem.$cadena.'" title="Agregar Horas Extras" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Horas Extras</a></td>';
					echo '</tr>';
					/***************************************************/
					if (isset($_SESSION['horas_extras_ing_horas'])){
						
						
						//imprimo la primera celda y el numero de semana actual
						foreach ($_SESSION['horas_extras_ing_horas'] as $key => $producto){
							//Subcadena con el trabajador
							if(isset($producto[$nSem]['idTrabajador'])&&$producto[$nSem]['idTrabajador']){
								$subcadena = '&idTrabajador='.$producto[$nSem]['idTrabajador'];
							}else{
								$subcadena = '';
							}
							
							
							if(isset($producto[$nSem]['nSem'])){
								echo '<tr>';
								echo '<td colspan="2">'.$producto[$nSem]['TrabajadorRut'].' '.$producto[$nSem]['TrabajadorNombre'].'</td>';
										
								//Recorro los dias de la semana
								for($i=1;$i<=7;$i++){

									//Imprimo la fecha en caso de existir
									if($i==fecha2NDiaSemana($DiaActual_ex)&&$Dia_ex<=($nDias+1)){
										if(isset($producto[$nSem][$DiaActual_ex]['horas_dia'])){
											echo '<td>'.$producto[$nSem][$DiaActual_ex]['horas_dia'].' ('.$producto[$nSem][$DiaActual_ex]['porcentaje'].'%)</td>';
											//sumo las horas
											if(isset($TotalHoras[$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['Total'])&&$TotalHoras[$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['Total']!=''){
												$TotalHoras[$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['Total'] = $TotalHoras[$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['Total'] + $producto[$nSem][$DiaActual_ex]['horas_dia'];
											}else{
												$TotalHoras[$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['Total'] = $producto[$nSem][$DiaActual_ex]['horas_dia'];
											}
											
											
											/************************************************/
											/************************************************/
											$_SESSION['horas_extras_mens_ing_horas'][$producto[$nSem]['idTrabajador']][$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['idTrabajador']      = $producto[$nSem]['idTrabajador'];
											$_SESSION['horas_extras_mens_ing_horas'][$producto[$nSem]['idTrabajador']][$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['porcentaje_dia']    = $producto[$nSem][$DiaActual_ex]['porcentaje_dia'];
											/************************************************/
											if(isset($_SESSION['horas_extras_mens_ing_horas'][$producto[$nSem]['idTrabajador']][$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['horas_dia'])&&$_SESSION['horas_extras_mens_ing_horas'][$producto[$nSem]['idTrabajador']][$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['horas_dia']!=''){
												$_SESSION['horas_extras_mens_ing_horas'][$producto[$nSem]['idTrabajador']][$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['horas_dia'] = $_SESSION['horas_extras_mens_ing_horas'][$producto[$nSem]['idTrabajador']][$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['horas_dia'] + $producto[$nSem][$DiaActual_ex]['horas_dia'];
											}else{
												$_SESSION['horas_extras_mens_ing_horas'][$producto[$nSem]['idTrabajador']][$producto[$nSem][$DiaActual_ex]['porcentaje_dia']]['horas_dia']         = $producto[$nSem][$DiaActual_ex]['horas_dia'];
											}
											
											
										}else{
											echo '<td></td>';
										}
										$DiaActual_ex = sumarDias($DiaActual_ex,1);
										$Dia_ex++;

									}else{
										echo '<td></td>';

									}
								}
								echo '<td>'.$producto[$nSem]['Turno'].'</td>';
								echo '
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="'.$location.'&editHora=true&nSem='.$nSem.$cadena.$subcadena.'" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									';
									//se verifica que el usuario no sea uno mismo
									$ubicacion = $location.'&del_horas=true&nSem='.$nSem.$subcadena;
									$dialogo   = '¿Realmente deseas eliminar el registro de la semana?';
									echo '<a onClick="dialogBox(\''.$ubicacion.'\', \''.$dialogo.'\')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>

									</div>
								</td>';
								echo '</tr>';
							//Si no hay horas para esa semana	
							}else{
								//Recorro los dias de la semana
								for($i=1;$i<=7;$i++){
									//$DiaActual_ex = sumarDias($DiaActual_ex,1);
									//$Dia_ex++;
								}
							}

						}
					}
				
				
				}
				echo '<tr id="hiderow"><td colspan="6"><a name="Ancla_obs"></a></td></tr>'; ?>
				
				
		
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="10" align="right"><strong>Total Horas extras</strong></td>
						<td align="right"></td>
					</tr>

					<?php
					//foreach ($arrPorcentajes as $prod) {
					foreach ($_SESSION['horas_extras_table'] as $key => $prod){
						if(isset($TotalHoras[$prod['idPorcentaje']]['Total'])&&$TotalHoras[$prod['idPorcentaje']]['Total']!=''){
							echo '
							<tr class="invoice-total" bgcolor="#f1f1f1">
								<td colspan="10" align="right">Horas extras al '.$prod['Nombre'].'%</td>
								<td align="right">'.$TotalHoras[$prod['idPorcentaje']]['Total'].' Horas</td>
							</tr>
							';
						}
					}
					?>

			</tbody>
		</table>
    </div>

    <div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['horas_extras_ing_basicos']['Observaciones']; ?></p>
		</div>
	</div>

    <table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td colspan="5">Archivos Adjuntos</td>
                <td width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
            </tr>

			<?php
			if (isset($_SESSION['horas_extras_ing_archivos'])){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($_SESSION['horas_extras_ing_archivos'] as $key => $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del_file='.$producto['idFile'];
								$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$producto['Nombre']).'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>

				 <?php
				$numeral++;
				}
			} ?>

		</tbody>
    </table>

</div>

<div class="clearfix"></div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Ingresar Horas Extras</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){  $x1  = $Creacion_fecha;     }else{$x1  = '';}
				if(isset($Fecha_desde)){     $x2  = $Fecha_desde;        }else{$x2  = '';}
				if(isset($Fecha_hasta)){     $x3  = $Fecha_hasta;        }else{$x3  = '';}
				if(isset($Observaciones)){   $x4  = $Observaciones;      }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Facturacion','Creacion_fecha', $x1, 2);
				$Form_Inputs->form_date('Periodo Inicio','Fecha_desde', $x2, 2);
				$Form_Inputs->form_date('Periodo Termino','Fecha_hasta', $x3, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x4, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Crear Documento" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'periodo_asc':  $order_by = 'trabajadores_horas_extras_facturacion.Creacion_ano ASC, trabajadores_horas_extras_facturacion.Creacion_mes ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Periodo Ascendente'; break;
		case 'periodo_desc': $order_by = 'trabajadores_horas_extras_facturacion.Creacion_ano DESC, trabajadores_horas_extras_facturacion.Creacion_mes DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Periodo Descendente';break;
		case 'fechas_asc':   $order_by = 'trabajadores_horas_extras_facturacion.Fecha_desde ASC ';                                                             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente';break;
		case 'fechas_desc':  $order_by = 'trabajadores_horas_extras_facturacion.Fecha_desde DESC ';                                                            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
	
		default: $order_by = 'trabajadores_horas_extras_facturacion.Creacion_ano DESC, trabajadores_horas_extras_facturacion.Creacion_mes DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Periodo Descendente';
	}
}else{
	$order_by = 'trabajadores_horas_extras_facturacion.Creacion_ano DESC, trabajadores_horas_extras_facturacion.Creacion_mes DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Periodo Descendente';
}
/**********************************************************/
//Variable con la ubicacion
$SIS_where = "trabajadores_horas_extras_facturacion.idFacturacion!=0";//Solo ingresos
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND trabajadores_horas_extras_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND trabajadores_horas_extras_facturacion.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['Creacion_mes']) && $_GET['Creacion_mes']!=''){      $SIS_where .= " AND trabajadores_horas_extras_facturacion.Creacion_mes=".$_GET['Creacion_mes'];}
if(isset($_GET['Creacion_ano']) && $_GET['Creacion_ano']!=''){      $SIS_where .= " AND trabajadores_horas_extras_facturacion.Creacion_ano=".$_GET['Creacion_ano'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idFacturacion', 'trabajadores_horas_extras_facturacion', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
trabajadores_horas_extras_facturacion.idFacturacion,
trabajadores_horas_extras_facturacion.Creacion_fecha,
trabajadores_horas_extras_facturacion.Creacion_mes,
trabajadores_horas_extras_facturacion.Creacion_ano,
trabajadores_horas_extras_facturacion.Fecha_desde,
trabajadores_horas_extras_facturacion.Fecha_hasta,
core_sistemas.Nombre AS Sistema';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = trabajadores_horas_extras_facturacion.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?>
		<?php if (isset($_SESSION['horas_extras_ing_basicos']['idUsuario'])&&$_SESSION['horas_extras_ing_basicos']['idUsuario']!=''){ ?>

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

			<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-arrow-right" aria-hidden="true"></i> Continuar Ingreso Horas</a>
		<?php }else{ ?>
			<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Ingreso Horas</a>
		<?php } ?>
	<?php } ?>
</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){     $x1  = $Creacion_fecha;   }else{$x1  = '';}
				if(isset($Creacion_mes)){       $x2  = $Creacion_mes;     }else{$x2  = '';}
				if(isset($Creacion_ano)){       $x3  = $Creacion_ano;     }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Documento','Creacion_fecha', $x1, 1);
				$Form_Inputs->form_select_filter('Mes','Creacion_mes', $x2, 1, 'idMes', 'Nombre', 'core_tiempo_meses', 0, 'idMes ASC', $dbConn);
				$Form_Inputs->form_select_n_auto('Año','Creacion_ano', $x3, 1, 2016, ano_actual());
						
			
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ingreso Horas Extras</h5>
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
							<div class="pull-left">Periodo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=periodo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=periodo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fechas</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechas_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechas_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
						<tr class="odd">
							<td><?php echo numero_a_mes($tipo['Creacion_mes']).' '.$tipo['Creacion_ano'].' ('.Fecha_estandar($tipo['Creacion_fecha']).')'  ; ?></td>
							<td><?php echo Fecha_estandar($tipo['Fecha_desde']).' - '.Fecha_estandar($tipo['Fecha_hasta']); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_horas_extras.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
