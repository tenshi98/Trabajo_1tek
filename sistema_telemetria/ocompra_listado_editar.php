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
$new_location = "ocompra_listado_editar.php";
//Se agregan ubicaciones
$new_location .='?view='.$_GET['view'];
if(isset($_GET['soli']) && $_GET['soli']!=''){   $new_location .= "&soli=".$_GET['soli']; 	}

//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'update_ocompra';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_prod'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_prod_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_prod'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_prod_update';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_prod'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_prod_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_ins'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_ins_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_ins'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_ins_update';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_ins'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_ins_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_arriendo'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_arriendo_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_arriendo'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_arriendo_update';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_arriendo'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_arriendo_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_servicio'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_servicio_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_servicio'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_servicio_update';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_servicio'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_servicio_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_otros'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_otros_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_otros'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_otros_update';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_otros'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_otros_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_boleta'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_boleta'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_update';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_boleta'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_boleta_emp'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_insert_emp';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_boleta_emp'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_update_emp';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_boleta_emp'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_boleta_del_emp';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_documento'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_documento_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_documento'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_documento_update';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_documento'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_documento_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_file_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_file_del';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}

/**********************************************/
//se borra un articulo desde la solicitud
if (!empty($_GET['del_solicitud'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_del_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_ocompra_listado.php';
}
/**********************************************/
//se realiza el ingreso de la Orden de Compra
if (!empty($_GET['ing_ocompra'])){
	//se agregan ubicaciones
	$location .= '?pagina=1';
	//Llamamos al formulario
	$form_trabajo= 'edit_oc_ok';
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
				//Se verifican si existen los datos
				if(isset($idSistema)){   $x1  = $idSistema;  }else{$x1  = '';}

         
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 1, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				/**************************************/
					
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editDoc'])){
//Traigo los datos del producto previamente seleccionado
$SIS_query = 'idDocPago, NDocPago, Fpago, vTotal, idSistema';
$SIS_join  = '';
$SIS_where = 'idDocumento ='.$_GET['editDoc'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_documentos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

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
				if(isset($idDocPago)){   $x1  = $idDocPago;  }else{$x1  = $rowData['idDocPago'];}
				if(isset($NDocPago)){    $x2  = $NDocPago;   }else{$x2  = $rowData['NDocPago'];}
				if(isset($Fpago)){       $x3  = $Fpago;      }else{$x3  = $rowData['Fpago'];}
				if(isset($vTotal)){      $x4  = $vTotal;     }else{$x4  = Cantidades_decimales_justos($rowData['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Documento de Pago','idDocPago', $x1, 2, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
				$Form_Inputs->form_input_text('N° Documento de Pago', 'NDocPago', $x2, 2);
				$Form_Inputs->form_date('Fecha de Pago','Fpago', $x3, 2);
				$Form_Inputs->form_input_number('Valor', 'vTotal', $x4, 2);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idDocumento', $_GET['editDoc'], 2);
				/**************************************/
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_documento">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				/**************************************/
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_documento">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editBoletaEmp'])){
//se consiltan los datos
$SIS_query = 'Descripcion, Valor';
$SIS_join  = '';
$SIS_where = 'idExistencia ='.$_GET['editBoletaEmp'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_existencias_boletas_empresas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
				if(isset($Descripcion)){    $x1  = $Descripcion;   }else{$x1  = $rowData['Descripcion'];}
				if(isset($Valor)){          $x2  = $Valor;        }else{$x2  = Cantidades_decimales_justos($rowData['Valor']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x1, 2);
				$Form_Inputs->form_input_number('Valor', 'Valor', $x2, 2);

				$Form_Inputs->form_input_hidden('idExistencia', $_GET['editBoletaEmp'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_boleta_emp">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addBoletaEmp'])){ ?>

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

				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_boleta_emp">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editBoleta'])){
//se consiltan los datos
$SIS_query = 'idTrabajador, N_Doc, Descripcion, Valor';
$SIS_join  = '';
$SIS_where = 'idExistencia ='.$_GET['editBoleta'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_existencias_boletas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
				if(isset($idTrabajador)){   $x1  = $idTrabajador;  }else{$x1  = $rowData['idTrabajador'];}
				if(isset($N_Doc)){          $x2  = $N_Doc;         }else{$x2  = $rowData['N_Doc'];}
				if(isset($Descripcion)){    $x3  = $Descripcion;   }else{$x3  = $rowData['Descripcion'];}
				if(isset($Valor)){          $x4  = $Valor;        }else{$x4  = Cantidades_decimales_justos($rowData['Valor']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $z, '', $dbConn);
				$Form_Inputs->form_input_number('Numero de Boleta', 'N_Doc', $x2, 2);
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x3, 1);
				$Form_Inputs->form_input_number('Valor', 'Valor', $x4, 2);

				$Form_Inputs->form_input_hidden('idExistencia', $_GET['editBoleta'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_boleta">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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

				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_boleta">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editOtros'])){  
// Se consulta
$SIS_query = 'Nombre,Cantidad, vUnitario, idSistema, vTotal, idFrecuencia';
$SIS_join  = '';
$SIS_where = 'idExistencia ='.$_GET['editOtros'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_existencias_otros', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

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
				if(isset($Nombre)){         $x1  = $Nombre;        }else{$x1  = $rowData['Nombre'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($rowData['Cantidad']);}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $rowData['idFrecuencia'];}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($rowData['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_input_disabled('Nombre','Nombre_fake', $x1);
				$Form_Inputs->form_input_disabled('Cantidad','Cantidad_fake', $x2);
				/****************************/
				$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				//if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario',Cantidades_decimales_justos($rowData['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($rowData['vUnitario']), 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idExistencia', $_GET['editOtros'], 2);
				/**************************************/
				
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
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', '');
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);	
				
				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				/**************************************/
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_otros">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editServicios'])){  
//Traigo los datos del producto previamente seleccionado
$SIS_query = '
ocompra_listado_existencias_servicios.idServicio, 
ocompra_listado_existencias_servicios.Cantidad, 
ocompra_listado_existencias_servicios.vUnitario, 
ocompra_listado_existencias_servicios.idSistema, 
ocompra_listado_existencias_servicios.vTotal,
ocompra_listado_existencias_servicios.idFrecuencia,
core_tiempo_frecuencia.Nombre AS Unimed,
proveedor_listado.Nombre AS Proveedor';
$SIS_join  = '
LEFT JOIN `core_tiempo_frecuencia`     ON core_tiempo_frecuencia.idFrecuencia    = ocompra_listado_existencias_servicios.idFrecuencia
LEFT JOIN `servicios_listado`          ON servicios_listado.idServicio           = ocompra_listado_existencias_servicios.idServicio
LEFT JOIN `proveedor_listado`          ON proveedor_listado.idProveedor          = servicios_listado.idProveedor';
$SIS_where = 'ocompra_listado_existencias_servicios.idExistencia ='.$_GET['editServicios'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_existencias_servicios', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

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
				if(isset($idServicio)){     $x1  = $idServicio;    }else{$x1  = $rowData['idServicio'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($rowData['Cantidad']);}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $rowData['idFrecuencia'];}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($rowData['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Servicio','idServicio_fake', $x1, 1, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad','Cantidad_fake', $x2);
				/****************************/
				$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				//if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario',Cantidades_decimales_justos($rowData['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($rowData['vUnitario']), 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idExistencia', $_GET['editServicios'], 2);
				/**************************************/
				
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
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', '');
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				/**************************************/
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_servicio">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editArriendo'])){  
//Traigo los datos del producto previamente seleccionado
$SIS_query = '
ocompra_listado_existencias_arriendos.idEquipo, 
ocompra_listado_existencias_arriendos.Cantidad, 
ocompra_listado_existencias_arriendos.vUnitario, 
ocompra_listado_existencias_arriendos.idSistema, 
ocompra_listado_existencias_arriendos.vTotal,
ocompra_listado_existencias_arriendos.idFrecuencia,
core_tiempo_frecuencia.Nombre AS Unimed,
proveedor_listado.Nombre AS Proveedor';
$SIS_join  = '
LEFT JOIN `core_tiempo_frecuencia`     ON core_tiempo_frecuencia.idFrecuencia    = ocompra_listado_existencias_arriendos.idFrecuencia
LEFT JOIN `equipos_arriendo_listado`   ON equipos_arriendo_listado.idEquipo      = ocompra_listado_existencias_arriendos.idEquipo
LEFT JOIN `proveedor_listado`          ON proveedor_listado.idProveedor          = equipos_arriendo_listado.idProveedor';
$SIS_where = 'ocompra_listado_existencias_arriendos.idExistencia ='.$_GET['editArriendo'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_existencias_arriendos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

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
				if(isset($idEquipo)){       $x1  = $idEquipo;      }else{$x1  = $rowData['idEquipo'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($rowData['Cantidad']);}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $rowData['idFrecuencia'];}
				if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($rowData['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Equipos','idEquipo', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Equipos','idEquipo_fake', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad','Cantidad_fake', $x2);
				/****************************/
				$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				//if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario',Cantidades_decimales_justos($rowData['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($rowData['vUnitario']), 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idExistencia', $_GET['editArriendo'], 2);
				/**************************************/
				
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
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				//$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', '');
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
				$Form_Inputs->form_input_hidden('vUnitario', '', 2);

				//echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);	
				
				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				/**************************************/
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_arriendo">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editIns'])){  
//Traigo los datos del producto previamente seleccionado	
$SIS_query = '
ocompra_listado_existencias_insumos.idProducto, 
ocompra_listado_existencias_insumos.Cantidad, 
ocompra_listado_existencias_insumos.vUnitario, 
ocompra_listado_existencias_insumos.idSistema, 
ocompra_listado_existencias_insumos.vTotal,
sistema_productos_uml.Nombre AS Unimed,
proveedor_listado.Nombre AS Proveedor';
$SIS_join  = '
LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto       = ocompra_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml      = insumos_listado.idUml
LEFT JOIN `proveedor_listado`       ON proveedor_listado.idProveedor    = insumos_listado.idProveedor';
$SIS_where = 'ocompra_listado_existencias_insumos.idExistencia ='.$_GET['editIns'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_existencias_insumos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/*************************************/
//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

/*************************************/
//filtro
$zx2 = "idProducto=0";
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
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $rowData['idProducto'];}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = Cantidades_decimales_justos($rowData['Cantidad']);}
				if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = Cantidades_decimales_justos($rowData['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Insumo','idProducto_fake', $x1, 1, 'idProducto', 'Nombre', 'insumos_listado', $zx2, $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad','Cantidad_fake', $x2);
				/****************************/
				
				if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', $rowData['Unimed']);
				$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario',Cantidades_decimales_justos($rowData['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($rowData['vUnitario']), 2);

				echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idExistencia', $_GET['editIns'], 2);
				/**************************************/
				
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
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addIns'])){  
//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

/*************************************/
//filtro
$zx2 = "idProducto=0";
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

				echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				/**************************************/
				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_ins">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editProd'])){  
//Traigo los datos del producto previamente seleccionado
$SIS_query = '
ocompra_listado_existencias_productos.idProducto, 
ocompra_listado_existencias_productos.Cantidad, 
ocompra_listado_existencias_productos.vUnitario, 
ocompra_listado_existencias_productos.idSistema, 
ocompra_listado_existencias_productos.vTotal,
sistema_productos_uml.Nombre AS Unimed,
proveedor_listado.Nombre AS Proveedor';
$SIS_join  = '
LEFT JOIN `productos_listado`       ON productos_listado.idProducto     = ocompra_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml      = productos_listado.idUml
LEFT JOIN `proveedor_listado`       ON proveedor_listado.idProveedor    = productos_listado.idProveedor';
$SIS_where = 'ocompra_listado_existencias_productos.idExistencia ='.$_GET['editProd'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado_existencias_productos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/*************************************/
//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos',  $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

/*************************************/
//filtro
$zx1 = "idProducto=0";
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
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $rowData['idProducto'];}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = Cantidades_decimales_justos($rowData['Cantidad']);}
				if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = Cantidades_decimales_justos($rowData['vTotal']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
				/****************************/
				$Form_Inputs->form_select_disabled('Producto','idProducto_fake', $x1, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, $dbConn);
				$Form_Inputs->form_input_disabled('Cantidad','Cantidad_fake', $x2);
				/****************************/
				
				if(isset($rowData['Proveedor'])&&$rowData['Proveedor']!=''){$prov=$rowData['Proveedor'];}else{$prov='Sin proveedor';}
				$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', $rowData['Unimed']);
				$Form_Inputs->form_input_disabled('Proveedor Actual','proveedor', $prov);
				$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario',Cantidades_decimales_justos($rowData['vUnitario']));
				$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
				$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($rowData['vUnitario']), 2);

				echo prod_print_value('productos_listado', 'idProducto', 'unimed', 'proveedor', $dbConn);
				echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idExistencia', $_GET['editProd'], 2);
				/**************************************/
				
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
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addProd'])){
//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

/*************************************/
//filtro
$zx1 = "idProducto=0";
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
				
				
				
				/**************************************/
				//Datos para agregar al sistema
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['idProveedor'], 2);
				$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
				/**************************************/

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_prod">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
//se traen los datos
$SIS_query = 'idProveedor, Creacion_fecha, Observaciones, idSistema';
$SIS_join  = '';
$SIS_where = 'idOcompra ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/*************************************/
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
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = $rowData['idProveedor'];}
				if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = $rowData['Creacion_fecha'];}
				if(isset($Observaciones)){    $x3  = $Observaciones;  }else{$x3  = $rowData['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha de Orden de Compra','Creacion_fecha', $x2, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x3, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idOcompra', $_GET['view'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Modificar Documento" name="submit_modBase">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
//Se consulta
$SIS_query = '
usuarios_listado.Nombre AS Usuario,
core_oc_estado.Nombre AS Estado,
proveedor_listado.Nombre AS Proveedor,
ocompra_listado.Creacion_fecha,
ocompra_listado.Observaciones,
ocompra_listado.idProveedor,
ocompra_listado.idEstado';
$SIS_join  = '
LEFT JOIN `usuarios_listado`   ON usuarios_listado.idUsuario      = ocompra_listado.idUsuario
LEFT JOIN `core_oc_estado`     ON core_oc_estado.idEstado         = ocompra_listado.idEstado
LEFT JOIN `proveedor_listado`  ON proveedor_listado.idProveedor   = ocompra_listado.idProveedor';
$SIS_where = 'ocompra_listado.idOcompra ='.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/*****************************************/
//Insumos
$SIS_query = '
ocompra_listado_existencias_insumos.idProducto,
ocompra_listado_existencias_insumos.idExistencia,
insumos_listado.Nombre,
ocompra_listado_existencias_insumos.Cantidad,
ocompra_listado_existencias_insumos.vUnitario,
ocompra_listado_existencias_insumos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`          ON insumos_listado.idProducto    = ocompra_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`    ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'ocompra_listado_existencias_insumos.idOcompra ='.$_GET['view'];
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrInsumos');

/*****************************************/
//Productos
$SIS_query = '
ocompra_listado_existencias_productos.idProducto,
ocompra_listado_existencias_productos.idExistencia,
productos_listado.Nombre,
ocompra_listado_existencias_productos.Cantidad,
ocompra_listado_existencias_productos.vUnitario,
ocompra_listado_existencias_productos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `productos_listado`          ON productos_listado.idProducto    = ocompra_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml`      ON sistema_productos_uml.idUml     = productos_listado.idUml';
$SIS_where = 'ocompra_listado_existencias_productos.idOcompra ='.$_GET['view'];
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

/*****************************************/
//Arriendos
$SIS_query = '
ocompra_listado_existencias_arriendos.idEquipo,
ocompra_listado_existencias_arriendos.idExistencia,
equipos_arriendo_listado.Nombre,
ocompra_listado_existencias_arriendos.Cantidad,
ocompra_listado_existencias_arriendos.vUnitario,
ocompra_listado_existencias_arriendos.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `equipos_arriendo_listado`    ON equipos_arriendo_listado.idEquipo     = ocompra_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_tiempo_frecuencia`      ON core_tiempo_frecuencia.idFrecuencia   = ocompra_listado_existencias_arriendos.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_arriendos.idOcompra ='.$_GET['view'];
$SIS_order = 'equipos_arriendo_listado.Nombre ASC';
$arrArriendos = array();
$arrArriendos = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_arriendos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArriendos');

/*****************************************/
//Servicios
$SIS_query = '
ocompra_listado_existencias_servicios.idServicio,
ocompra_listado_existencias_servicios.idExistencia,
servicios_listado.Nombre,
ocompra_listado_existencias_servicios.Cantidad,
ocompra_listado_existencias_servicios.vUnitario,
ocompra_listado_existencias_servicios.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `servicios_listado`       ON servicios_listado.idServicio          = ocompra_listado_existencias_servicios.idServicio
LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia   = ocompra_listado_existencias_servicios.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_servicios.idOcompra ='.$_GET['view'];
$SIS_order = 'servicios_listado.Nombre ASC';
$arrServicios = array();
$arrServicios = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrServicios');

/*****************************************/
//Otros
$SIS_query = '
ocompra_listado_existencias_otros.idExistencia,
ocompra_listado_existencias_otros.Nombre,
ocompra_listado_existencias_otros.Cantidad,
ocompra_listado_existencias_otros.vUnitario,
ocompra_listado_existencias_otros.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = 'LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_otros.idFrecuencia';
$SIS_where = 'ocompra_listado_existencias_otros.idOcompra ='.$_GET['view'];
$SIS_order = 'ocompra_listado_existencias_otros.Nombre ASC';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOtros');

/*****************************************/
//Boletas Trabajadores
$SIS_query = '
ocompra_listado_existencias_boletas.idExistencia,
ocompra_listado_existencias_boletas.N_Doc,
ocompra_listado_existencias_boletas.Descripcion,
ocompra_listado_existencias_boletas.Valor,
trabajadores_listado.Rut AS TrabRut,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat';
$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = ocompra_listado_existencias_boletas.idTrabajador';
$SIS_where = 'ocompra_listado_existencias_boletas.idOcompra ='.$_GET['view'];
$SIS_order = 'ocompra_listado_existencias_boletas.N_Doc ASC';
$arrBoletas = array();
$arrBoletas = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_boletas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBoletas');

/*****************************************/
//Boletas Empresas
$SIS_query = 'idExistencia, Descripcion, Valor';
$SIS_join  = '';
$SIS_where = 'idOcompra ='.$_GET['view'];
$SIS_order = 'Descripcion ASC';
$arrBoletasEmp = array();
$arrBoletasEmp = db_select_array (false, $SIS_query, 'ocompra_listado_existencias_boletas_empresas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBoletasEmp');

/*****************************************/
// Se trae un listado con todos los documentos acompañantes
$SIS_query = '
ocompra_listado_documentos.idDocumento,
ocompra_listado_documentos.NDocPago,
ocompra_listado_documentos.Fpago,
ocompra_listado_documentos.vTotal,
sistema_documentos_pago.Nombre AS Documento';
$SIS_join  = 'LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago = ocompra_listado_documentos.idDocPago';
$SIS_where = 'ocompra_listado_documentos.idOcompra ='.$_GET['view'];
$SIS_order = 'ocompra_listado_documentos.Fpago ASC';
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, $SIS_query, 'ocompra_listado_documentos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDocumentos');

/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'idFile, Nombre';
$SIS_join  = '';
$SIS_where = 'idOcompra ='.$_GET['view'];
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'ocompra_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArchivo');

/*****************************************/
// Se trae un con los Productos de las solicitudes
$SIS_query = '
ocompra_listado_sol_rel.idSolRel,
ocompra_listado_sol_rel.Type,
ocompra_listado_sol_rel.idExistencia,
solicitud_listado_existencias_productos.idSolicitud AS Prod_idSolicitud,
solicitud_listado_existencias_productos.Cantidad  AS Prod_Cantidad,
productos_sis.Nombre AS Prod_Sistema,
productos_listado.Nombre AS Prod_Nombre,
productos_med.Nombre AS Prod_Medida,
solicitud_listado_existencias_productos.idProducto AS Prod_Soli,
solicitud_listado_existencias_insumos.idSolicitud AS Ins_idSolicitud,
solicitud_listado_existencias_insumos.Cantidad  AS Ins_Cantidad,
insumos_sis.Nombre AS Ins_Sistema,
insumos_listado.Nombre AS Ins_Nombre,
insumos_med.Nombre AS Ins_Medida,
solicitud_listado_existencias_insumos.idProducto AS Ins_Soli,
solicitud_listado_existencias_arriendos.idSolicitud AS Arri_idSolicitud,
solicitud_listado_existencias_arriendos.Cantidad  AS Arri_Cantidad,
arriendo_sis.Nombre AS Arri_Sistema,
equipos_arriendo_listado.Nombre AS Arri_Nombre,
arriendo_med.Nombre AS Arri_Medida,
solicitud_listado_existencias_arriendos.idEquipo AS Arri_Soli,
solicitud_listado_existencias_servicios.idSolicitud AS Serv_idSolicitud,
solicitud_listado_existencias_servicios.Cantidad  AS Serv_Cantidad,
servicio_sis.Nombre AS Serv_Sistema,
servicios_listado.Nombre AS Serv_Nombre,
servicio_med.Nombre AS Serv_Medida,
solicitud_listado_existencias_servicios.idServicio AS Serv_Soli,
solicitud_listado_existencias_otros.idSolicitud AS Otro_idSolicitud,
solicitud_listado_existencias_otros.Cantidad  AS Otro_Cantidad,
otros_sis.Nombre AS Otro_Sistema,
solicitud_listado_existencias_otros.Nombre AS Otro_Nombre,
otros_med.Nombre AS Otro_Medida,
solicitud_listado_existencias_otros.Nombre AS Otro_Soli';
$SIS_join  = '
LEFT JOIN `solicitud_listado_existencias_productos`    ON solicitud_listado_existencias_productos.idExistencia    = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `productos_listado`                          ON productos_listado.idProducto                            = solicitud_listado_existencias_productos.idProducto
LEFT JOIN `core_sistemas`             productos_sis    ON productos_sis.idSistema                                 = solicitud_listado_existencias_productos.idSistema
LEFT JOIN `sistema_productos_uml`     productos_med    ON productos_med.idUml                                     = productos_listado.idUml
LEFT JOIN `solicitud_listado_existencias_insumos`      ON solicitud_listado_existencias_insumos.idExistencia      = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `insumos_listado`                            ON insumos_listado.idProducto                              = solicitud_listado_existencias_insumos.idProducto
LEFT JOIN `core_sistemas`             insumos_sis      ON insumos_sis.idSistema                                   = solicitud_listado_existencias_insumos.idSistema
LEFT JOIN `sistema_productos_uml`     insumos_med      ON insumos_med.idUml                                       = insumos_listado.idUml
LEFT JOIN `solicitud_listado_existencias_arriendos`    ON solicitud_listado_existencias_arriendos.idExistencia    = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `equipos_arriendo_listado`                   ON equipos_arriendo_listado.idEquipo                       = solicitud_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_sistemas`             arriendo_sis     ON arriendo_sis.idSistema                                  = solicitud_listado_existencias_arriendos.idSistema
LEFT JOIN `core_tiempo_frecuencia`    arriendo_med     ON arriendo_med.idFrecuencia                               = solicitud_listado_existencias_arriendos.idFrecuencia
LEFT JOIN `solicitud_listado_existencias_servicios`    ON solicitud_listado_existencias_servicios.idExistencia    = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `servicios_listado`                          ON servicios_listado.idServicio                            = solicitud_listado_existencias_servicios.idServicio
LEFT JOIN `core_sistemas`             servicio_sis     ON servicio_sis.idSistema                                  = solicitud_listado_existencias_servicios.idSistema
LEFT JOIN `core_tiempo_frecuencia`    servicio_med     ON servicio_med.idFrecuencia                               = solicitud_listado_existencias_servicios.idFrecuencia
LEFT JOIN `solicitud_listado_existencias_otros`        ON solicitud_listado_existencias_otros.idExistencia        = ocompra_listado_sol_rel.idExistencia
LEFT JOIN `core_sistemas`             otros_sis        ON otros_sis.idSistema                                     = solicitud_listado_existencias_otros.idSistema
LEFT JOIN `core_tiempo_frecuencia`    otros_med        ON otros_med.idFrecuencia                                  = solicitud_listado_existencias_otros.idFrecuencia';
$SIS_where = 'ocompra_listado_sol_rel.idOcompra ='.$_GET['view'];
$SIS_order = 'ocompra_listado_sol_rel.Type ASC';
$arrSolMat = array();
$arrSolMat = db_select_array (false, $SIS_query, 'ocompra_listado_sol_rel', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSolMat');

//Variable para sacar el total
$total = 0;		
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<?php
	$ubicacion = $new_location.'&view='.$_GET['view'].'&ing_ocompra='.$_GET['view'];
	$dialogo   = '¿Desea terminar el documento?'; ?>
	<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary pull-right margin_form_btn" ><i class="fa fa-check-square-o" aria-hidden="true"></i>  Ingresar Documento</a>

	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

<div id="page-wrap">
    <div id="header"> Modificacion Orden de Compra N°<?php echo n_doc($_GET['view'], 5); ?></div>
   

    <div id="customer">
        
        <table id="meta" class="pull-left otdata">
            <tbody>
                <tr>
                    <td class="meta-head"><strong>DATOS BASICOS</strong></td>
                    <td class="meta-head"><a href="<?php echo $new_location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary pull-right tooltip" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
                </tr>
                <tr>
                    <td class="meta-head">Proveedor</td>
                    <td><?php echo $rowData['Proveedor']?></td>
                </tr>
                <tr>
                    <td class="meta-head">Usuario</td>
                    <td><?php echo $rowData['Usuario']?></td>
                </tr>
                <tr>
                    <td class="meta-head">Estado</td>
                    <td><?php echo $rowData['Estado']?></td>
                </tr>
            </tbody>
        </table>
        <table id="meta" class="otdata2">
            <tbody>
                <tr>
                    <td class="meta-head">Fecha Creacion</td>
                    <td><?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    

	<?php
	//Se envia proveedor por referencia
	$new_location.='&idEstado='.$rowData['idEstado'];
	$new_location.='&idProveedor='.$rowData['idProveedor'];

	?>

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
						<a href="<?php echo $new_location.'&addProd=true' ?>" title="Agregar Producto" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrProductos as $prod) { ?>
					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="2">
							<?php echo $prod['Nombre']; ?>
						</td>
						<td class="item-name">
							<?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vUnitario'], 0).' x '.$prod['Unidad']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vTotal'], 0); ?>
						</td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo $new_location.'&editProd='.$prod['idExistencia']; ?>" title="Editar Producto" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<a href="<?php echo 'view_precios.php?type='.simpleEncode( 1, fecha_actual()).'&view='.simpleEncode($prod['idProducto'], fecha_actual()); ?>" title="Ver Variacion Precios Producto" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
								<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
									<?php
									$ubicacion = $new_location.'&del_prod='.simpleEncode($prod['idExistencia'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el producto '.$prod['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
			<?php }
			} ?>

			<tr class="item-row fact_tittle">
				<td colspan="5">Insumos a Solicitar</td>
				<td>
					<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
						<a href="<?php echo $new_location.'&addIns=true' ?>" title="Agregar Insumo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumos</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			if ($arrInsumos!=false && !empty($arrInsumos) && $arrInsumos!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrInsumos as $prod) { ?>
					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="2">
							<?php echo $prod['Nombre']; ?>
						</td>
						<td class="item-name">
							<?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vUnitario'], 0).' x '.$prod['Unidad']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vTotal'], 0); ?>
						</td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo $new_location.'&editIns='.$prod['idExistencia']; ?>" title="Editar Insumo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<a href="<?php echo 'view_precios.php?type='.simpleEncode( 2, fecha_actual()).'&view='.simpleEncode($prod['idProducto'], fecha_actual()); ?>" title="Ver Variacion Precios Insumo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
										<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
									<?php
									$ubicacion = $new_location.'&del_ins='.simpleEncode($prod['idExistencia'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el producto '.$prod['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Insumo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
			<?php }
			} ?>

			<tr class="item-row fact_tittle">
				<td colspan="5">Arriendo de equipos a Solicitar</td>
				<td>
					<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
						<a href="<?php echo $new_location.'&addArriendo=true' ?>" title="Agregar Arriendo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Arriendos</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			if ($arrArriendos!=false && !empty($arrArriendos) && $arrArriendos!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrArriendos as $prod){ ?>
					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="2">
							<?php echo $prod['Nombre']; ?>
						</td>
						<td class="item-name">
							<?php  echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vTotal'], 0); ?>
						</td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo $new_location.'&editArriendo='.$prod['idExistencia']; ?>" title="Editar Arriendo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<a href="<?php echo 'view_precios.php?type='.simpleEncode( 3, fecha_actual()).'&view='.simpleEncode($prod['idEquipo'], fecha_actual()); ?>" title="Ver Variacion Precios Arriendo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
								<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
									<?php
									$ubicacion = $new_location.'&del_arriendo='.simpleEncode($prod['idExistencia'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el arriendo '.$prod['Nombre'].'?'; ?>
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
						<a href="<?php echo $new_location.'&addServicios=true' ?>" title="Agregar Servicio" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Servicios</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			if ($arrServicios!=false && !empty($arrServicios) && $arrServicios!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrServicios as $prod){ ?>
					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="2">
							<?php echo $prod['Nombre']; ?>
						</td>
						<td class="item-name">
							<?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vTotal'], 0); ?>
						</td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo $new_location.'&editServicios='.$prod['idExistencia']; ?>" title="Editar Servicio" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<a href="<?php echo 'view_precios.php?type='.simpleEncode( 4, fecha_actual()).'&view='.simpleEncode($prod['idServicio'], fecha_actual()); ?>" title="Ver Variacion Precios Servicio" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
								<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
									<?php
									$ubicacion = $new_location.'&del_servicio='.simpleEncode($prod['idExistencia'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el servicio '.$prod['Nombre'].'?'; ?>
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
						<a href="<?php echo $new_location.'&addOtros=true' ?>" title="Agregar Otro" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Otros</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			if ($arrOtros!=false && !empty($arrOtros) && $arrOtros!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrOtros as $prod){ ?>
					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="2"><?php echo $prod['Nombre']; ?></td>
						<td class="item-name">
							<?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?>
						</td>
						<td class="item-name">
							<?php echo valores($prod['vTotal'], 0); ?>
						</td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo $new_location.'&editOtros='.$prod['idExistencia']; ?>" title="Editar Otros" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
									<?php
									$ubicacion = $new_location.'&del_otros='.simpleEncode($prod['idExistencia'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar  '.$prod['Nombre'].'?'; ?>
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
						<a href="<?php echo $new_location.'&addBoleta=true' ?>" title="Agregar Boleta de Honorarios" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Boleta</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			if ($arrBoletas!=false && !empty($arrBoletas) && $arrBoletas!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrBoletas as $prod){ ?>
					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="2"><?php echo $prod['TrabRut'].' - '.$prod['TrabNombre'].' '.$prod['TrabApellidoPat']; ?></td>
						<td class="item-name"><?php echo $prod['Descripcion']; ?></td>
						<td class="item-name"><?php echo 'Boleta N° '.$prod['N_Doc']; ?></td>
						<td align="right" class="item-name"><?php echo valores($prod['Valor'], 0); ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo $new_location.'&editBoleta='.$prod['idExistencia']; ?>" title="Editar Boleta" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
									<?php
									$ubicacion = $new_location.'&del_boleta='.simpleEncode($prod['idExistencia'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la boleta del trabajador '.$prod['TrabNombre'].' '.$prod['TrabApellidoPat'].'?'; ?>
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
						<a href="<?php echo $new_location.'&addBoletaEmp=true' ?>" title="Agregar Boleta de Honorarios" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Boleta</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			if ($arrBoletasEmp!=false && !empty($arrBoletasEmp) && $arrBoletasEmp!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrBoletasEmp as $prod){ ?>
					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="4"><?php echo $prod['Descripcion']; ?></td>
						<td align="right" class="item-name"><?php echo valores($prod['Valor'], 0); ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo $new_location.'&editBoletaEmp='.$prod['idExistencia']; ?>" title="Editar Boleta" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
									<?php
									$ubicacion = $new_location.'&del_boleta_emp='.simpleEncode($prod['idExistencia'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la boleta de la empresa?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Boleta" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
				 <?php 	
				}
			} ?>

			<tr id="hiderow">
                <td colspan="6"><a name="Ancla_obs"></a></td>
            </tr>
			
            <tr>
				<td colspan="6" class="blank word_break">
					<?php echo $rowData['Observaciones']; ?>
				</td>
            </tr>
            <tr>
                <td colspan="6" class="blank"><p>Observaciones</p></td> 
            </tr>
            
        </tbody>
    </table>
    
   	<?php if ($arrSolMat!=false && !empty($arrSolMat) && $arrSolMat!='') { ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="6">Solicitudes Relacionadas</th>
				</tr>
				<tr>
					<th>Sistema</th>
					<th>N° Solicitud</th>
					<th>Tipo</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th width="10">Acciones</th>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrSolMat as $producto){
					switch ($producto['Type']) {
						/****************************************/
						//Productos
						case 1:
						?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Prod_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Prod_idSolicitud'], 5); ?></td>
								<td class="item-name">Productos</td>
								<td class="item-name"><?php echo $producto['Prod_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Prod_Cantidad']).' '.$producto['Prod_Medida']; ?></td>
								<td class="item-name">
									<div class="btn-group" style="width: 35px;" >
										<?php 
										//Ubicación
										$ubicacion = $new_location;
										$ubicacion .= '&del_solicitud='.$producto['idExistencia'];
										$ubicacion .= '&del_sol_SolRel='.$producto['idSolRel'];
										$ubicacion .= '&del_sol_type='.$producto['Type'];
										$ubicacion .= '&del_sol_prod='.$producto['Prod_Soli'];
										$ubicacion .= '&del_sol_cant='.Cantidades_decimales_justos($producto['Prod_Cantidad']);
										$dialogo   = '¿Realmente deseas eliminar la solicitud de '.$producto['Prod_Nombre'].' por '.Cantidades_decimales_justos($producto['Prod_Cantidad']).' '.$producto['Prod_Medida'].' ?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Solicitud" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php
							break;
						/****************************************/
						//Insumos
						case 2:
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Ins_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Ins_idSolicitud'], 5); ?></td>
								<td class="item-name">Insumos</td>
								<td class="item-name"><?php echo $producto['Ins_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Ins_Cantidad']).' '.$producto['Ins_Medida']; ?></td>
								<td class="item-name">
									<div class="btn-group" style="width: 35px;" >
										<?php 
										//Ubicación
										$ubicacion = $new_location;
										$ubicacion .= '&del_solicitud='.$producto['idExistencia'];
										$ubicacion .= '&del_sol_SolRel='.simpleEncode($producto['idSolRel'], fecha_actual());
										$ubicacion .= '&del_sol_type='.$producto['Type'];
										$ubicacion .= '&del_sol_prod='.$producto['Ins_Soli'];
										$ubicacion .= '&del_sol_cant='.Cantidades_decimales_justos($producto['Ins_Cantidad']);
										$dialogo   = '¿Realmente deseas eliminar la solicitud de '.$producto['Ins_Nombre'].' por '.Cantidades_decimales_justos($producto['Ins_Cantidad']).' '.$producto['Ins_Medida'].' ?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Solicitud" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php
							break;
						/****************************************/
						//Arriendos
						case 3:
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Arri_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Arri_idSolicitud'], 5); ?></td>
								<td class="item-name">Arriendos</td>
								<td class="item-name"><?php echo $producto['Arri_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Arri_Cantidad']).' '.$producto['Arri_Medida']; ?></td>
								<td class="item-name">
									<div class="btn-group" style="width: 35px;" >
										<?php 
										//Ubicación
										$ubicacion = $new_location;
										$ubicacion .= '&del_solicitud='.$producto['idExistencia'];
										$ubicacion .= '&del_sol_SolRel='.simpleEncode($producto['idSolRel'], fecha_actual());
										$ubicacion .= '&del_sol_type='.$producto['Type'];
										$ubicacion .= '&del_sol_prod='.$producto['Arri_Soli'];
										$ubicacion .= '&del_sol_cant='.Cantidades_decimales_justos($producto['Arri_Cantidad']);
										$dialogo   = '¿Realmente deseas eliminar la solicitud de '.$producto['Arri_Nombre'].' por '.Cantidades_decimales_justos($producto['Arri_Cantidad']).' '.$producto['Arri_Medida'].' ?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Solicitud" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php
							break;
						/****************************************/
						//Servicios
						case 4:
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Serv_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Serv_idSolicitud'], 5); ?></td>
								<td class="item-name">Servicios</td>
								<td class="item-name"><?php echo $producto['Serv_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Serv_Cantidad']).' '.$producto['Serv_Medida']; ?></td>
								<td class="item-name">
									<div class="btn-group" style="width: 35px;" >
										<?php 
										//Ubicación
										$ubicacion = $new_location;
										$ubicacion .= '&del_solicitud='.$producto['idExistencia'];
										$ubicacion .= '&del_sol_SolRel='.simpleEncode($producto['idSolRel'], fecha_actual());
										$ubicacion .= '&del_sol_type='.$producto['Type'];
										$ubicacion .= '&del_sol_prod='.$producto['Serv_Soli'];
										$ubicacion .= '&del_sol_cant='.Cantidades_decimales_justos($producto['Serv_Cantidad']);
										$dialogo   = '¿Realmente deseas eliminar la solicitud de '.$producto['Serv_Nombre'].' por '.Cantidades_decimales_justos($producto['Serv_Cantidad']).' '.$producto['Serv_Medida'].' ?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Solicitud" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php
							break;
						/****************************************/
						//Otros
						case 5:
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $producto['Otro_Sistema']; ?></td>
								<td class="item-name"><?php echo n_doc($producto['Otro_idSolicitud'], 5); ?></td>
								<td class="item-name">Otros</td>
								<td class="item-name"><?php echo $producto['Otro_Nombre']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($producto['Otro_Cantidad']).' '.$producto['Otro_Medida']; ?></td>
								<td class="item-name">
									<div class="btn-group" style="width: 35px;" >
										<?php 
										//Ubicación
										$ubicacion = $new_location;
										$ubicacion .= '&del_solicitud='.$producto['idExistencia'];
										$ubicacion .= '&del_sol_SolRel='.simpleEncode($producto['idSolRel'], fecha_actual());
										$ubicacion .= '&del_sol_type='.$producto['Type'];
										$ubicacion .= '&del_sol_prod='.$producto['Otro_Soli'];
										$ubicacion .= '&del_sol_cant='.Cantidades_decimales_justos($producto['Otro_Cantidad']);
										$dialogo   = '¿Realmente deseas eliminar la solicitud de '.$producto['Otro_Nombre'].' por '.Cantidades_decimales_justos($producto['Otro_Cantidad']).' '.$producto['Otro_Medida'].' ?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Solicitud" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php
							break;
					}
				} ?>
			</tbody>
		</table>
	<?php } ?>
	
   	<table id="items">
        <tbody>

			<tr>
                <th colspan="5">Documentos Acompañantes</th>
                <th width="160"><a href="<?php echo $new_location.'&addDoc=true' ?>" title="Agregar Documento" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Documento</a></th>
            </tr>

			<?php
			if ($arrDocumentos!=false && !empty($arrDocumentos) && $arrDocumentos!=''){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($arrDocumentos as $prod){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$prod['Documento'].' N°'.$prod['NDocPago'].' por '.valores($prod['vTotal'], 0).' (Pago para el '.fecha_estandar($prod['Fpago']).')'; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo $new_location.'&editDoc='.$prod['idDocumento']; ?>" title="Editar Documento" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $new_location.'&del_documento='.simpleEncode($prod['idDocumento'], fecha_actual());
								$dialogo   = '¿Realmente deseas eliminar el documento '.$prod['Documento'].' N°'.str_replace('"','',$prod['NDocPago']).'?'; ?>
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
                <th width="160"><a href="<?php echo $new_location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></th>
            </tr>

			<?php
			if ($arrArchivo!=false && !empty($arrArchivo) && $arrArchivo!=''){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($arrArchivo as $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="<?php echo '1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $new_location.'&del_file='.simpleEncode($producto['idFile'], fecha_actual());
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

</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
