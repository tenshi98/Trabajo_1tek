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
$original = "ocompra_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){ $location .= "&idProveedor=".$_GET['idProveedor'];        $search .= "&idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];  $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
/********************************************************************/
if(isset($_GET['soli']) && $_GET['soli']!=''){   $location .= "&soli=".$_GET['soli']; 	}
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borran todas las variables
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'new_prod_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_prod_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'del_prod_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'new_ins_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_ins_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'del_ins_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'new_arriendo_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_arriendo_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'del_arriendo_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'new_servicio_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_servicio_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'del_servicio_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_otros'])){
	//Llamamos al formulario
	$form_trabajo= 'new_otros_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_otros'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_otros_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_otros'])){
	//Llamamos al formulario
	$form_trabajo= 'del_otros_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_boleta'])){
	//Llamamos al formulario
	$form_trabajo= 'new_boleta_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_boleta'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_boleta'])){
	//Llamamos al formulario
	$form_trabajo= 'del_boleta_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_boleta_emp'])){
	//Llamamos al formulario
	$form_trabajo= 'new_boleta_emp_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_boleta_emp'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_emp_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_boleta_emp'])){
	//Llamamos al formulario
	$form_trabajo= 'del_boleta_emp_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_documento'])){
	//Llamamos al formulario
	$form_trabajo= 'new_documentos_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_documento'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_documentos_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_documento'])){
	//Llamamos al formulario
	$form_trabajo= 'del_documentos_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//se borra un articulo desde la solicitud
if (!empty($_GET['del_solicitud'])){
	//Llamamos al formulario
	$form_trabajo= 'del_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//se realiza el ingreso de la Orden de Compra
if (!empty($_GET['ing_ocompra'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Documento Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Documento Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Documento Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
}elseif(!empty($_GET['editDoc'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Documentos Acompañantes</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idDocPago)){   $x1  = $idDocPago;  }else{$x1  = $_SESSION['ocompra_documentos'][$_GET['editDoc']]['idDocPago'];}
				if(isset($NDocPago)){    $x2  = $NDocPago;   }else{$x2  = $_SESSION['ocompra_documentos'][$_GET['editDoc']]['NDocPago'];}
				if(isset($Fpago)){       $x3  = $Fpago;      }else{$x3  = $_SESSION['ocompra_documentos'][$_GET['editDoc']]['Fpago'];}
				if(isset($vTotal)){      $x4  = $vTotal;     }else{$x4  = $_SESSION['ocompra_documentos'][$_GET['editDoc']]['vTotal'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Documento de Pago','idDocPago', $x1, 2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
				$Form_Inputs->form_input_text('N° Documento de Pago', 'NDocPago', $x2, 2);
				$Form_Inputs->form_date('Fecha de Pago','Fpago', $x3, 2);
				$Form_Inputs->form_input_number('Valor', 'vTotal', $x4, 2);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_documentos'][$_GET['editDoc']]['idDoc'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_documento">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addDoc'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Documentos Acompañantes</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idDocPago)){   $x1  = $idDocPago;  }else{$x1  = '';}
				if(isset($NDocPago)){    $x2  = $NDocPago;   }else{$x2  = '';}
				if(isset($Fpago)){       $x3  = $Fpago;      }else{$x3  = '';}
				if(isset($vTotal)){      $x4  = $vTotal;     }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Documento de Pago','idDocPago', $x1, 2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
				$Form_Inputs->form_input_text('N° Documento de Pago', 'NDocPago', $x2, 2);
				$Form_Inputs->form_date('Fecha de Pago','Fpago', $x3, 2);
				$Form_Inputs->form_input_number('Valor', 'vTotal', $x4, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_documento">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editBoletaEmp'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Boletas</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Descripcion)){    $x1  = $Descripcion;   }else{$x1  = $_SESSION['ocompra_boletasEmp'][$_GET['editBoletaEmp']]['Descripcion'];}
				if(isset($Valor)){          $x2  = $Valor;        }else{$x2  = $_SESSION['ocompra_boletasEmp'][$_GET['editBoletaEmp']]['Valor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x1, 2);
				$Form_Inputs->form_input_number('Valor', 'Valor', $x2, 2);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_boletasEmp'][$_GET['editBoletaEmp']]['idBoleta'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_boleta_emp">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addBoletaEmp'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Boletas</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Descripcion)){    $x1  = $Descripcion;   }else{$x1  = '';}
				if(isset($Valor)){          $x2  = $Valor;        }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x1, 2);
				$Form_Inputs->form_input_number('Valor', 'Valor', $x2, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_boleta_emp">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editBoleta'])){  
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Boletas</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){   $x1  = $idTrabajador;  }else{$x1  = $_SESSION['ocompra_boletas'][$_GET['editBoleta']]['idTrabajador'];}
				if(isset($N_Doc)){          $x2  = $N_Doc;         }else{$x2  = $_SESSION['ocompra_boletas'][$_GET['editBoleta']]['N_Doc'];}
				if(isset($Descripcion)){    $x3  = $Descripcion;   }else{$x3  = $_SESSION['ocompra_boletas'][$_GET['editBoleta']]['Descripcion'];}
				if(isset($Valor)){          $x4  = $Valor;        }else{$x4  = $_SESSION['ocompra_boletas'][$_GET['editBoleta']]['Valor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $z, '', $dbConn);
				$Form_Inputs->form_input_number('Numero de Boleta', 'N_Doc', $x2, 2);
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x3, 1);
				$Form_Inputs->form_input_number('Valor', 'Valor', $x4, 2);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_boletas'][$_GET['editBoleta']]['idBoleta'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_boleta">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addBoleta'])){  
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1"; ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Boletas</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){   $x1  = $idTrabajador;  }else{$x1  = '';}
				if(isset($N_Doc)){          $x2  = $N_Doc;         }else{$x2  = '';}
				if(isset($Descripcion)){    $x3  = $Descripcion;   }else{$x3  = '';}
				if(isset($Valor)){          $x4  = $Valor;        }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $z, '', $dbConn);
				$Form_Inputs->form_input_number('Numero de Boleta', 'N_Doc', $x2, 2);
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x3, 1);
				$Form_Inputs->form_input_number('Valor', 'Valor', $x4, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_boleta">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editOtros'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Otros</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){         $x1  = $Nombre;        }else{$x1  = $_SESSION['ocompra_otros'][$_GET['editOtros']]['Nombre'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($_SESSION['ocompra_otros'][$_GET['editOtros']]['Cantidad']);}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['ocompra_otros'][$_GET['editOtros']]['idFrecuencia'];}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($_SESSION['ocompra_otros'][$_GET['editOtros']]['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_input_disabled('Nombre','Nombre_fake', $x1);
				$Form_Inputs->form_input_disabled('Cantidad de dias','Cantidad_fake', $x2);
				/****************************/
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_otros'][$_GET['editOtros']]['idOtros'], 2);

				//if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['ocompra_otros'][$_GET['editOtros']]['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['ocompra_otros'][$_GET['editOtros']]['vUnitario']), 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);
				?>

				<script>
					<?php if(isset($_GET['soli']) && $_GET['soli']!=''){ ?>
						document.getElementById("div_Nombre").style.display = 'none';
						document.getElementById("div_Cantidad").style.display = 'none';
						document.getElementById("div_Nombre_fake").style.display = '';
						document.getElementById("div_Cantidad_fake").style.display = '';
					<?php }else{ ?>
						document.getElementById("div_Nombre").style.display = '';
						document.getElementById("div_Cantidad").style.display = '';
						document.getElementById("div_Nombre_fake").style.display = 'none';
						document.getElementById("div_Cantidad_fake").style.display = 'none';
					<?php } ?>
				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_otros">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addOtros'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Otros</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){         $x1  = $Nombre;        }else{$x1  = '';}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = '';}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = '';}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', '');
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_otros">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editServicios'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Servicio</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idServicio)){     $x1  = $idServicio;    }else{$x1  = $_SESSION['ocompra_servicios'][$_GET['editServicios']]['idServicio'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($_SESSION['ocompra_servicios'][$_GET['editServicios']]['Cantidad']);}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['ocompra_servicios'][$_GET['editServicios']]['idFrecuencia'];}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($_SESSION['ocompra_servicios'][$_GET['editServicios']]['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Servicio','idServicio_fake', $x1, 1, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad de dias','Cantidad_fake', $x2);
				/****************************/
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_servicios'][$_GET['editServicios']]['idServicio'], 2);

				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['ocompra_servicios'][$_GET['editServicios']]['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['ocompra_servicios'][$_GET['editServicios']]['vUnitario']), 2);

				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);

				?>

				<script>
					<?php if(isset($_GET['soli']) && $_GET['soli']!=''){ ?>
						document.getElementById("div_idServicio").style.display = 'none';
						document.getElementById("div_Cantidad").style.display = 'none';
						document.getElementById("div_idServicio_fake").style.display = '';
						document.getElementById("div_Cantidad_fake").style.display = '';
					<?php }else{ ?>
						document.getElementById("div_idServicio").style.display = '';
						document.getElementById("div_Cantidad").style.display = '';
						document.getElementById("div_idServicio_fake").style.display = 'none';
						document.getElementById("div_Cantidad_fake").style.display = 'none';
					<?php } ?>
				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_servicio">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addServicios'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Servicio</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idServicio)){     $x1  = $idServicio;    }else{$x1  = '';}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = '';}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = '';}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);
				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_servicio">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editArriendo'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Equipo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEquipo)){       $x1  = $idEquipo;      }else{$x1  = $_SESSION['ocompra_arriendos'][$_GET['editArriendo']]['idEquipo'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($_SESSION['ocompra_arriendos'][$_GET['editArriendo']]['Cantidad']);}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['ocompra_arriendos'][$_GET['editArriendo']]['idFrecuencia'];}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($_SESSION['ocompra_arriendos'][$_GET['editArriendo']]['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Equipos','idEquipo', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Equipos','idEquipo_fake', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad de dias','Cantidad_fake', $x2);
				/****************************/
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_arriendos'][$_GET['editArriendo']]['idEquipo'], 2);

				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['ocompra_arriendos'][$_GET['editArriendo']]['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['ocompra_arriendos'][$_GET['editArriendo']]['vUnitario']), 2);

				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);

				?>

				<script>
					<?php if(isset($_GET['soli']) && $_GET['soli']!=''){ ?>
						document.getElementById("div_idEquipo").style.display = 'none';
						document.getElementById("div_Cantidad").style.display = 'none';
						document.getElementById("div_idEquipo_fake").style.display = '';
						document.getElementById("div_Cantidad_fake").style.display = '';
					<?php }else{ ?>
						document.getElementById("div_idEquipo").style.display = '';
						document.getElementById("div_Cantidad").style.display = '';
						document.getElementById("div_idEquipo_fake").style.display = 'none';
						document.getElementById("div_Cantidad_fake").style.display = 'none';
					<?php } ?>
				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_arriendo">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addArriendo'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Equipo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEquipo)){       $x1  = $idEquipo;      }else{$x1  = '';}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = '';}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = '';}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Equipos','idEquipo', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_arriendo">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editIns'])){  
//Traigo los datos del producto previamente seleccionado	 
$query = "SELECT  
insumos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed,
proveedor_listado.Nombre AS Proveedor
FROM `insumos_listado`
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml      = insumos_listado.idUml
LEFT JOIN `proveedor_listado`       ON proveedor_listado.idProveedor    = insumos_listado.idProveedor
WHERE insumos_listado.idProducto='".$_SESSION['ocompra_insumos'][$_GET['editIns']]['idProducto']."'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

//filtro
$zx2 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_insumos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
foreach ($arrPermisos as $prod) {
	$zx2 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar solicitud de Insumo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $_SESSION['ocompra_insumos'][$_GET['editIns']]['idProducto'];}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = Cantidades_decimales_justos($_SESSION['ocompra_insumos'][$_GET['editIns']]['Cantidad']);}
				if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = Cantidades_decimales_justos($_SESSION['ocompra_insumos'][$_GET['editIns']]['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Insumo','idProducto_fake', $x1, 1, 'idProducto', 'Nombre', 'insumos_listado', $zx2, $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad','Cantidad_fake', $x2);
				/****************************/

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_insumos'][$_GET['editIns']]['idProducto'], 2);

				if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', $rowData['Unimed']);
				$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['ocompra_insumos'][$_GET['editIns']]['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['ocompra_insumos'][$_GET['editIns']]['vUnitario']), 2);

				echo prod_print_value('insumos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				?>

				<script>
					<?php if(isset($_GET['soli']) && $_GET['soli']!=''){ ?>
						document.getElementById("div_idProducto").style.display = 'none';
						document.getElementById("div_Cantidad").style.display = 'none';
						document.getElementById("div_idProducto_fake").style.display = '';
						document.getElementById("div_Cantidad_fake").style.display = '';
					<?php }else{ ?>
						document.getElementById("div_idProducto").style.display = '';
						document.getElementById("div_Cantidad").style.display = '';
						document.getElementById("div_idProducto_fake").style.display = 'none';
						document.getElementById("div_Cantidad_fake").style.display = 'none';
					<?php } ?>
				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_ins">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addIns'])){  
//filtro
$zx2 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_insumos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
foreach ($arrPermisos as $prod) {
	$zx2 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
}
	 
	 
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
				if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

				$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', '');
				$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', '');
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				echo prod_print_value('insumos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_ins">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editProd'])){  
//Traigo los datos del producto previamente seleccionado	 
$query = "SELECT  
productos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed,
proveedor_listado.Nombre AS Proveedor
FROM `productos_listado`
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml      = productos_listado.idUml
LEFT JOIN `proveedor_listado`       ON proveedor_listado.idProveedor    = productos_listado.idProveedor
WHERE productos_listado.idProducto='".$_SESSION['ocompra_productos'][$_GET['editProd']]['idProducto']."'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

//filtro
$zx1 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_productos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
foreach ($arrPermisos as $prod) {
	$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
}
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar solicitud de Productos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $_SESSION['ocompra_productos'][$_GET['editProd']]['idProducto'];}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = Cantidades_decimales_justos($_SESSION['ocompra_productos'][$_GET['editProd']]['Cantidad']);}
				if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = Cantidades_decimales_justos($_SESSION['ocompra_productos'][$_GET['editProd']]['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Producto','idProducto_fake', $x1, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad','Cantidad_fake', $x2);
				/****************************/

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['ocompra_productos'][$_GET['editProd']]['idProducto'], 2);

				if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', $rowData['Unimed']);
				$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['ocompra_productos'][$_GET['editProd']]['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['ocompra_productos'][$_GET['editProd']]['vUnitario']), 2);

				echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				?>

				<script>
					<?php if(isset($_GET['soli']) && $_GET['soli']!=''){ ?>
						document.getElementById("div_idProducto").style.display = 'none';
						document.getElementById("div_Cantidad").style.display = 'none';
						document.getElementById("div_idProducto_fake").style.display = '';
						document.getElementById("div_Cantidad_fake").style.display = '';
					<?php }else{ ?>
						document.getElementById("div_idProducto").style.display = '';
						document.getElementById("div_Cantidad").style.display = '';
						document.getElementById("div_idProducto_fake").style.display = 'none';
						document.getElementById("div_Cantidad_fake").style.display = 'none';
					<?php } ?>
				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_prod">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addProd'])){
//filtro
$zx1 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_productos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
foreach ($arrPermisos as $prod) {
	$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
}
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
				if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

				$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', '');
				$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', '');
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_prod">
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
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Orden de Compra</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){      $x1 = $idProveedor;    }else{$x1 = $_SESSION['ocompra_basicos']['idProveedor'];}
				if(isset($Creacion_fecha)){   $x2 = $Creacion_fecha; }else{$x2 = $_SESSION['ocompra_basicos']['Creacion_fecha'];}
				if(isset($Observaciones)){    $x3 = $Observaciones;  }else{$x3 = $_SESSION['ocompra_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha de Orden de Compra','Creacion_fecha', $x2, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x3, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Modificar Orden de Compra" name="submit_modBase">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
//Variable para sacar el total
$total = 0;		
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&ing_ocompra=true';
		$dialogo   = '¿Realmente desea ingresar el documento?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i>  Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Orden de Compra</div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary pull-right tooltip" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Proveedor</td>
						<td><?php echo $_SESSION['ocompra_basicos']['Proveedor']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Usuario</td>
						<td><?php echo $_SESSION['ocompra_basicos']['Usuario']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td><?php echo Fecha_estandar($_SESSION['ocompra_basicos']['Creacion_fecha']); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<table id="items">
			<tbody>

				<tr>
					<th colspan="5">Detalle</th>
					<th width="160">Acciones</th>
				</tr>

				<tr class="item-row fact_tittle">
					<td colspan="5">Productos a Solicitar</td>
					<td>
						<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
							<a href="<?php echo $location.'&addProd=true' ?>" title="Agregar Producto" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['ocompra_productos'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['ocompra_productos'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="2"><?php echo $producto['Nombre']; ?></td>
							<td class="item-name" align="right"><?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Unimed']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vUnitario'], 0).' x '.$producto['Unimed']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vTotal'], 0); ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo $location.'&editProd='.$producto['idProducto']; ?>" title="Editar Producto" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="<?php echo 'view_precios.php?type='.simpleEncode( 1, fecha_actual()).'&view='.simpleEncode($producto['idProducto'], fecha_actual()); ?>" title="Ver Variacion Precios Producto" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
									<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
										<?php
										$ubicacion = $location.'&del_prod='.$producto['idProducto'];
										$dialogo   = '¿Realmente deseas eliminar el producto '.$producto['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					  <?php
					}
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Insumos a Solicitar</td>
					<td>
						<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
							<a href="<?php echo $location.'&addIns=true' ?>" title="Agregar Insumo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumos</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['ocompra_insumos'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['ocompra_insumos'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="2"><?php echo $producto['Nombre']; ?></td>
							<td class="item-name" align="right"><?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Unimed']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vUnitario'], 0).' x '.$producto['Unimed']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vTotal'], 0); ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo $location.'&editIns='.$producto['idProducto']; ?>" title="Editar Insumo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="<?php echo 'view_precios.php?type='.simpleEncode( 2, fecha_actual()).'&view='.simpleEncode($producto['idProducto'], fecha_actual()); ?>" title="Ver Variacion Precios Insumo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
									<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
										<?php
										$ubicacion = $location.'&del_ins='.$producto['idProducto'];
										$dialogo   = '¿Realmente deseas eliminar el producto '.$producto['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Insumo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					  <?php
					}
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Arriendo de equipos a Solicitar</td>
					<td>
						<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
							<a href="<?php echo $location.'&addArriendo=true' ?>" title="Agregar Arriendo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Arriendos</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['ocompra_arriendos'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['ocompra_arriendos'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="2"><?php echo $producto['Equipo']; ?></td>
							<td class="item-name" align="right"><?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vUnitario'], 0).' x '.$producto['Frecuencia']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vTotal'], 0); ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo $location.'&editArriendo='.$producto['idEquipo']; ?>" title="Editar Arriendo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="<?php echo 'view_precios.php?type='.simpleEncode( 3, fecha_actual()).'&view='.simpleEncode($producto['idEquipo'], fecha_actual()); ?>" title="Ver Variacion Precios Arriendo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
									<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
										<?php
										$ubicacion = $location.'&del_arriendo='.$producto['idEquipo'];
										$dialogo   = '¿Realmente deseas eliminar el arriendo '.$producto['Equipo'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Arriendo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					 <?php
					}
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Servicios a Solicitar</td>
					<td>
						<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
							<a href="<?php echo $location.'&addServicios=true' ?>" title="Agregar Servicio" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Servicios</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['ocompra_servicios'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['ocompra_servicios'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="2"><?php echo $producto['Servicio']; ?></td>
							<td class="item-name" align="right"><?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vUnitario'], 0).' x '.$producto['Frecuencia']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vTotal'], 0); ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo $location.'&editServicios='.$producto['idServicio']; ?>" title="Editar Servicio" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="<?php echo 'view_precios.php?type='.simpleEncode( 4, fecha_actual()).'&view='.simpleEncode($producto['idServicio'], fecha_actual()); ?>" title="Ver Variacion Precios Servicio" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
									<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
										<?php
										$ubicacion = $location.'&del_servicio='.$producto['idServicio'];
										$dialogo   = '¿Realmente deseas eliminar el servicio '.$producto['Servicio'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Servicio" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					 <?php
					}
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Otros a Solicitar</td>
					<td>
						<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
							<a href="<?php echo $location.'&addOtros=true' ?>" title="Agregar Otro" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Otros</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['ocompra_otros'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['ocompra_otros'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="2"><?php echo $producto['Nombre']; ?></td>
							<td class="item-name" align="right"><?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vUnitario'], 0).' x '.$producto['Frecuencia']; ?></td>
							<td class="item-name" align="right"><?php echo valores($producto['vTotal'], 0); ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editOtros='.$producto['idOtros']; ?>" title="Editar Otros" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
										<?php
										$ubicacion = $location.'&del_otros='.$producto['idOtros'];
										$dialogo   = '¿Realmente deseas eliminar  '.$producto['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Otros" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					 <?php
					}
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Boletas de Honorarios Trabajadores</td>
					<td>
						<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
							<a href="<?php echo $location.'&addBoleta=true' ?>" title="Agregar Boleta de Honorarios" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Boleta</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['ocompra_boletas'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['ocompra_boletas'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="2"><?php echo $producto['trabajador']; ?></td>
							<td class="item-name"><?php echo $producto['Descripcion']; ?></td>
							<td class="item-name"><?php echo 'Boleta N° '.$producto['N_Doc']; ?></td>
							<td class="item-name" align="right"><?php echo Valores($producto['Valor'], 0);$total = $total + $producto['Valor']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editBoleta='.$producto['idBoleta']; ?>" title="Editar Boleta" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
										<?php
										$ubicacion = $location.'&del_boleta='.$producto['idBoleta'];
										$dialogo   = '¿Realmente deseas eliminar la boleta del trabajador '.$producto['trabajador'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Boleta" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					 <?php
					}
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Boletas de Honorarios Empresas</td>
					<td>
						<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
							<a href="<?php echo $location.'&addBoletaEmp=true' ?>" title="Agregar Boleta de Honorarios" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Boleta</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['ocompra_boletasEmp'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['ocompra_boletasEmp'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4"><?php echo $producto['Descripcion']; ?></td>
							<td class="item-name" align="right"><?php echo Valores($producto['Valor'], 0);$total = $total + $producto['Valor']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editBoletaEmp='.$producto['idBoleta']; ?>" title="Editar Boleta" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
										<?php
										$ubicacion = $location.'&del_boleta_emp='.$producto['idBoleta'];
										$dialogo   = '¿Realmente deseas eliminar la boleta de la empresa?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Boleta" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					 <?php
					}
				} ?>

			</tbody>
		</table>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['ocompra_basicos']['Observaciones']; ?></p>
		</div>
	</div>

	<?php if (isset($_SESSION['ocompra_sol_rel'])){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="5">Solicitudes Relacionadas</th>
				</tr>
				<tr>
					<th>Sistema</th>
					<th>N° Solicitud</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th width="10">Acciones</th>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				foreach ($_SESSION['ocompra_sol_rel'] as $key => $producto){ ?>
					<tr class="item-row linea_punteada">
						<td class="item-name"><?php echo $producto['Sistema']; ?></td>
						<td class="item-name"><?php echo n_doc($producto['idSolicitud'], 5); ?></td>
						<td class="item-name"><?php echo $producto['NombreProd']; ?></td>
						<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Medida']; ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php
								//Ubicación
								$ubicacion = $location;
								$ubicacion .= '&del_solicitud='.$producto['bvar'];
								$ubicacion .= '&del_sol_type='.$producto['Type'];
								$ubicacion .= '&del_sol_prod='.$producto['idProdSol'];
								$ubicacion .= '&del_sol_cant='.Cantidades_decimales_justos($producto['Cantidad']);
								$dialogo   = '¿Realmente deseas eliminar la solicitud de '.$producto['NombreProd'].' por '.Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Medida'].' ?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Solicitud" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
	
   	<table id="items">
        <tbody>

			<tr>
                <th colspan="5">Documentos Acompañantes</th>
                <th width="160"><a href="<?php echo $location.'&addDoc=true' ?>" title="Agregar Documento" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Documento</a></th>
            </tr>

			<?php
			if (isset($_SESSION['ocompra_documentos'])){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($_SESSION['ocompra_documentos'] as $key => $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$producto['DocPago'].' N°'.$producto['NDocPago'].' por '.valores($producto['vTotal'], 0).' (Pago para el '.fecha_estandar($producto['Fpago']).')'; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo $location.'&editDoc='.$producto['idDoc']; ?>" title="Editar Documento" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del_documento='.$producto['idDoc'];
								$dialogo   = '¿Realmente deseas eliminar el documento '.$producto['DocPago'].' N°'.str_replace('"','',$producto['NDocPago']).'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Documento" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>

				 <?php
				$numeral++;
				}
			} ?>

		</tbody>
    </table>

    <table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr>
                <th colspan="5">Archivos Adjuntos</th>
                <th width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></th>
            </tr>

			<?php
			if (isset($_SESSION['ocompra_archivos'])){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($_SESSION['ocompra_archivos'] as $key => $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del_file='.$producto['idFile'];
								$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$producto['Nombre']).'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//se crea filtro
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Orden de Compra</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = '';}
				if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = '';}
				if(isset($Observaciones)){    $x3  = $Observaciones;  }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha de Orden de Compra','Creacion_fecha', $x2, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x3, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
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
		case 'ndoc_asc':          $order_by = 'ocompra_listado.idOcompra ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Doc Ascendente';break;
		case 'ndoc_desc':         $order_by = 'ocompra_listado.idOcompra DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Doc Descendente';break;
		case 'proveedor_asc':     $order_by = 'proveedor_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Proveedor Ascendente';break;
		case 'proveedor_desc':    $order_by = 'proveedor_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Proveedor Descendente';break;
		case 'estado_asc':        $order_by = 'core_oc_estado.Nombre ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':       $order_by = 'core_oc_estado.Nombre DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'fecha_asc':         $order_by = 'ocompra_listado.Creacion_fecha ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
		case 'fecha_desc':        $order_by = 'ocompra_listado.Creacion_fecha DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;

		default: $order_by = 'core_oc_estado.idEstado DESC,ocompra_listado.idOcompra DESC, ocompra_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado, N° Doc, Fecha Descendente';
	}
}else{
	$order_by = 'core_oc_estado.idEstado DESC,ocompra_listado.idOcompra DESC, ocompra_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado, N° Doc, Fecha Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "ocompra_listado.idEstado=1 OR ocompra_listado.idEstado=3";
$SIS_where.= " AND ocompra_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$w         = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
//verifico que sea un administrador
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_where.=" AND ocompra_listado.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
}
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){ $SIS_where .= " AND ocompra_listado.idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND ocompra_listado.Creacion_fecha='".$_GET['Creacion_fecha']."'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
ocompra_listado.idOcompra,
ocompra_listado.idEstado,
ocompra_listado.Solicitud,
ocompra_listado.Creacion_fecha,
core_oc_estado.Nombre AS Estado,
proveedor_listado.Nombre AS Proveedor';
$SIS_join  = '
LEFT JOIN `core_oc_estado`      ON core_oc_estado.idEstado         = ocompra_listado.idEstado 
LEFT JOIN `proveedor_listado`   ON proveedor_listado.idProveedor   = ocompra_listado.idProveedor';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrSolicitudes = array();
$arrSolicitudes = db_select_array (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSolicitudes');

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
		<?php if(isset($_SESSION['ocompra_basicos']['idProveedor'])&&$_SESSION['ocompra_basicos']['idProveedor']!=''){ ?>
			<?php
			//Verifico si viene desde una solicitud
			$extra = '';
			if(isset($_SESSION['ocompra_basicos']['Solicitud'])&&$_SESSION['ocompra_basicos']['Solicitud']==1){
				$extra = '&soli=true';
			} ?>

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

			<a href="<?php echo $location.'&view=true'.$extra; ?>" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-arrow-right" aria-hidden="true"></i>  Continuar Orden de Compra</a>
		<?php }else{ ?>
			<a href="<?php echo $location.'&new=true'; ?>" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Orden de Compra</a>
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
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = '';}
				if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha de Orden de Compra','Creacion_fecha', $x2, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ordenes de Compra</h5>
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
						<th width="120">
							<div class="pull-left">N° Doc</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=ndoc_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=ndoc_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Proveedor</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=proveedor_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=proveedor_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Fecha</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				



			  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrSolicitudes as $sol) { ?>
					<tr class="odd <?php if(isset($sol['idEstado'])&&$sol['idEstado']==3){echo 'danger';} ?>">
						<td><?php echo 'OC N°'.n_doc($sol['idOcompra'], 5); ?></td>
						<td><?php echo $sol['Proveedor']; ?></td>
						<td><?php echo $sol['Estado']; ?></td>
						<td><?php echo Fecha_estandar($sol['Creacion_fecha']); ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php
								$extra = '';
								if(isset($sol['Solicitud'])&&$sol['Solicitud']==1){
									$extra = '&soli=true';
								} ?>
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_ocompra.php?view='.simpleEncode($sol['idOcompra'], fecha_actual()); ?>" title="Ver Orden" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2&&isset($sol['idEstado'])&&$sol['idEstado']==3){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'ocompra_listado_editar.php?view='.$sol['idOcompra'].$extra; ?>" title="Editar Orden" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
