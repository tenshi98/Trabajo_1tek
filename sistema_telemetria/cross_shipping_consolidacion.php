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
$original = "cross_shipping_consolidacion.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];          $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){        $location .= "&idCategoria=".$_GET['idCategoria'];                $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){          $location .= "&idProducto=".$_GET['idProducto'];                  $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['CTNNombreCompañia']) && $_GET['CTNNombreCompañia']!=''){   $location .= "&CTNNombreCompañia=".$_GET['CTNNombreCompañia'];    $search .= "&CTNNombreCompañia=".$_GET['CTNNombreCompañia'];}
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
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//formulario para editar
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//formulario para crear
if (!empty($_POST['submit_clone'])){
	//Llamamos al formulario
	$form_trabajo= 'clona_ingreso';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_estiba'])){
	//Llamamos al formulario
	$form_trabajo= 'new_estiba';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_estiba'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_estiba';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//se borra un dato
if (!empty($_GET['del_estiba'])){
	//Llamamos al formulario
	$form_trabajo= 'del_estiba';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************/
//se hace el ingreso a bodega
if (!empty($_GET['ing_Doc'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_Doc';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Ingreso Realizado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Ingreso Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Ingreso Borrado correctamente';}
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
				if(isset($idArchivoTipo)){    $x1  = $idArchivoTipo;  }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 15, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

				$Form_Inputs->form_select('Tipo Foto','idArchivoTipo', $x1, 2, 'idArchivoTipo', 'Nombre', 'core_cross_shipping_archivos_tipos', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('randompass', $_GET['view'], 2);
				$Form_Inputs->form_input_hidden('CTNNombreCompañia', $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CTNNombreCompañia'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $location.'&view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['cloneEstiba'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Clonar Estiba</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idEstiba)){           $x1  = $idEstiba;           }else{$x1  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['idEstiba'];}
				if(isset($idEstibaUbicacion)){  $x2  = $idEstibaUbicacion;  }else{$x2  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['idEstibaUbicacion'];}
				if(isset($idPosicion)){         $x3  = $idPosicion;         }else{$x3  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['idPosicion'];}
				if(isset($idEnvase)){           $x4  = $idEnvase;           }else{$x4  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['idEnvase'];}
				if(isset($NPallet)){            $x5  = $NPallet;            }else{$x5  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['NPallet'];}
				if(isset($Temperatura)){        $x6  = $Temperatura;        }else{$x6  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['Temperatura'];}
				if(isset($idTermografo)){       $x7  = $idTermografo;       }else{$x7  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['idTermografo'];}
				if(isset($NSerieSensor)){       $x8  = $NSerieSensor;       }else{$x8  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['cloneEstiba']]['NSerieSensor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend1('Estiba','idEstiba', $x1, 2, 'idEstiba', 'Nombre', 'core_estibas', 0, 0,
										 'Ubicación','idEstibaUbicacion', $x2, 2, 'idEstibaUbicacion', 'Nombre', 'core_estibas_ubicacion', 0, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select('Posicion','idPosicion', $x3, 2, 'idPosicion', 'Nombre', 'core_cross_shipping_consolidacion_posicion', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Envase','idEnvase', $x4, 1, 'idEnvase', 'Codigo,Nombre', 'cross_shipping_envase', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nro. De Pallet', 'NPallet', $x5, 2);
				$Form_Inputs->form_input_number('Temp. De Pulpa', 'Temperatura', $x6, 1);
				$Form_Inputs->form_select_filter('Marca Modelo Sensor','idTermografo', $x7, 1, 'idTermografo', 'Codigo,Nombre', 'cross_shipping_termografo', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nro. Serie Sensor', 'NSerieSensor', $x8, 1);

				$Form_Inputs->form_input_hidden('randompass', $_GET['view'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_estiba">
					<a href="<?php echo $location.'&view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editEstiba'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Estiba</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idEstiba)){           $x1  = $idEstiba;           }else{$x1  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['idEstiba'];}
				if(isset($idEstibaUbicacion)){  $x2  = $idEstibaUbicacion;  }else{$x2  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['idEstibaUbicacion'];}
				if(isset($idPosicion)){         $x3  = $idPosicion;         }else{$x3  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['idPosicion'];}
				if(isset($idEnvase)){           $x4  = $idEnvase;           }else{$x4  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['idEnvase'];}
				if(isset($NPallet)){            $x5  = $NPallet;            }else{$x5  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['NPallet'];}
				if(isset($Temperatura)){        $x6  = $Temperatura;        }else{$x6  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['Temperatura'];}
				if(isset($idTermografo)){       $x7  = $idTermografo;       }else{$x7  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['idTermografo'];}
				if(isset($NSerieSensor)){       $x8  = $NSerieSensor;       }else{$x8  = $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['NSerieSensor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend1('Estiba','idEstiba', $x1, 2, 'idEstiba', 'Nombre', 'core_estibas', 0, 0,
										 'Ubicación','idEstibaUbicacion', $x2, 2, 'idEstibaUbicacion', 'Nombre', 'core_estibas_ubicacion', 0, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select('Posicion','idPosicion', $x3, 2, 'idPosicion', 'Nombre', 'core_cross_shipping_consolidacion_posicion', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Envase','idEnvase', $x4, 1, 'idEnvase', 'Codigo,Nombre', 'cross_shipping_envase', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nro. De Pallet', 'NPallet', $x5, 2);
				$Form_Inputs->form_input_number('Temp. De Pulpa', 'Temperatura', $x6, 1);
				$Form_Inputs->form_select_filter('Marca Modelo Sensor','idTermografo', $x7, 1, 'idTermografo', 'Codigo,Nombre', 'cross_shipping_termografo', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nro. Serie Sensor', 'NSerieSensor', $x8, 1);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']][$_GET['editEstiba']]['idInterno'], 2);
				$Form_Inputs->form_input_hidden('randompass', $_GET['view'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_estiba">
					<a href="<?php echo $location.'&view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addEstiba'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Ingreso Estibas</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEstiba)){           $x1  = $idEstiba;           }else{$x1  = '';}
				if(isset($idEstibaUbicacion)){  $x2  = $idEstibaUbicacion;  }else{$x2  = '';}
				if(isset($idPosicion)){         $x3  = $idPosicion;         }else{$x3  = '';}
				if(isset($idEnvase)){           $x4  = $idEnvase;           }else{$x4  = '';}
				if(isset($NPallet)){            $x5  = $NPallet;            }else{$x5  = '';}
				if(isset($Temperatura)){        $x6  = $Temperatura;        }else{$x6  = '';}
				if(isset($idTermografo)){       $x7  = $idTermografo;       }else{$x7  = '';}
				if(isset($NSerieSensor)){       $x8  = $NSerieSensor;       }else{$x8  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend1('Estiba','idEstiba', $x1, 2, 'idEstiba', 'Nombre', 'core_estibas', 0, 0,
										 'Ubicación','idEstibaUbicacion', $x2, 2, 'idEstibaUbicacion', 'Nombre', 'core_estibas_ubicacion', 0, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select('Posicion','idPosicion', $x3, 2, 'idPosicion', 'Nombre', 'core_cross_shipping_consolidacion_posicion', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Envase','idEnvase', $x4, 1, 'idEnvase', 'Codigo,Nombre', 'cross_shipping_envase', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nro. De Pallet', 'NPallet', $x5, 2);
				$Form_Inputs->form_input_number('Temp. De Pulpa', 'Temperatura', $x6, 1);
				$Form_Inputs->form_select_filter('Marca Modelo Sensor','idTermografo', $x7, 1, 'idTermografo', 'Codigo,Nombre', 'cross_shipping_termografo', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nro. Serie Sensor', 'NSerieSensor', $x8, 1);

				$Form_Inputs->form_input_hidden('randompass', $_GET['view'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_estiba">
					<a href="<?php echo $location.'&view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Consolidacion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($CTNNombreCompañia)){     $x1  = $CTNNombreCompañia;     }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CTNNombreCompañia']=='Sin Datos'){    $x1  = '';}else{$x1  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CTNNombreCompañia'];}
				if(isset($Creacion_fecha)){        $x2  = $Creacion_fecha;        }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Creacion_fecha']=='0000-00-00'){      $x2  = '';}else{$x2  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Creacion_fecha'];}
				if(isset($FechaInicioEmbarque)){   $x3  = $FechaInicioEmbarque;   }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['FechaInicioEmbarque']=='0000-00-00'){ $x3  = '';}else{$x3  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['FechaInicioEmbarque'];}
				if(isset($HoraInicioCarga)){       $x4  = $HoraInicioCarga;       }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['HoraInicioCarga']=='Sin Datos'){      $x4  = '';}else{$x4  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['HoraInicioCarga'];}
				if(isset($FechaTerminoEmbarque)){  $x5  = $FechaTerminoEmbarque;  }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['FechaTerminoEmbarque']=='0000-00-00'){$x5  = '';}else{$x5  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['FechaTerminoEmbarque'];}
				if(isset($HoraTerminoCarga)){      $x6  = $HoraTerminoCarga;      }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['HoraTerminoCarga']=='Sin Datos'){     $x6  = '';}else{$x6  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['HoraTerminoCarga'];}
				if(isset($idPlantaDespacho)){      $x7  = $idPlantaDespacho;      }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPlantaDespacho']=='Sin Datos'){     $x7  = '';}else{$x7  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPlantaDespacho'];}
				if(isset($idCategoria)){           $x8  = $idCategoria;           }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idCategoria']=='Sin Datos'){          $x8  = '';}else{$x8  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idCategoria'];}
				if(isset($idProducto)){            $x9  = $idProducto;            }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idProducto']=='Sin Datos'){           $x9  = '';}else{$x9  = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idProducto'];}
				if(isset($CantidadCajas)){         $x10 = $CantidadCajas;         }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CantidadCajas']=='Sin Datos'){        $x10 = '';}else{$x10 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CantidadCajas'];}
				if(isset($idInstructivo)){         $x11 = $idInstructivo;         }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idInstructivo']=='Sin Datos'){        $x11 = '';}else{$x11 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idInstructivo'];}
				if(isset($idNaviera)){             $x12 = $idNaviera;             }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idNaviera']=='Sin Datos'){            $x12 = '';}else{$x12 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idNaviera'];}
				if(isset($idPuertoEmbarque)){      $x13 = $idPuertoEmbarque;      }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPuertoEmbarque']=='Sin Datos'){     $x13 = '';}else{$x13 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPuertoEmbarque'];}
				if(isset($idPuertoDestino)){       $x14 = $idPuertoDestino;       }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPuertoDestino']=='Sin Datos'){      $x14 = '';}else{$x14 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPuertoDestino'];}
				if(isset($idMercado)){             $x15 = $idMercado;             }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idMercado']=='Sin Datos'){            $x15 = '';}else{$x15 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idMercado'];}
				if(isset($idPais)){                $x16 = $idPais;                }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPais']=='Sin Datos'){               $x16 = '';}else{$x16 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idPais'];}
				if(isset($idRecibidor)){           $x17 = $idRecibidor;           }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idRecibidor']=='Sin Datos'){          $x17 = '';}else{$x17 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idRecibidor'];}
				if(isset($idEmpresaTransporte)){   $x18 = $idEmpresaTransporte;   }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idEmpresaTransporte']=='Sin Datos'){  $x18 = '';}else{$x18 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idEmpresaTransporte'];}
				if(isset($ChoferNombreRut)){       $x19 = $ChoferNombreRut;       }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['ChoferNombreRut']=='Sin Datos'){      $x19 = '';}else{$x19 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['ChoferNombreRut'];}
				if(isset($PatenteCamion)){         $x20 = $PatenteCamion;         }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PatenteCamion']=='Sin Datos'){        $x20 = '';}else{$x20 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PatenteCamion'];}
				if(isset($PatenteCarro)){          $x21 = $PatenteCarro;          }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PatenteCarro']=='Sin Datos'){         $x21 = '';}else{$x21 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PatenteCarro'];}
				if(isset($idCondicion)){           $x22 = $idCondicion;           }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idCondicion']=='Sin Datos'){          $x22 = '';}else{$x22 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idCondicion'];}
				if(isset($idSellado)){             $x23 = $idSellado;             }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idSellado']=='Sin Datos'){            $x23 = '';}else{$x23 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idSellado'];}
				if(isset($TSetPoint)){             $x24 = $TSetPoint;             }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TSetPoint']=='Sin Datos'){            $x24 = '';}else{$x24 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TSetPoint'];}
				if(isset($TVentilacion)){          $x25 = $TVentilacion;          }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TVentilacion']=='Sin Datos'){         $x25 = '';}else{$x25 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TVentilacion'];}
				if(isset($TAmbiente)){             $x26 = $TAmbiente;             }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TAmbiente']=='Sin Datos'){            $x26 = '';}else{$x26 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TAmbiente'];}
				if(isset($NumeroSello)){           $x27 = $NumeroSello;           }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['NumeroSello']=='Sin Datos'){          $x27 = '';}else{$x27 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['NumeroSello'];}
				if(isset($idInspector)){           $x28 = $idInspector;           }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idInspector']=='Sin Datos'){          $x28 = '';}else{$x28 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['idInspector'];}
				if(isset($Observaciones)){         $x29 = $Observaciones;         }elseif($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Observaciones']=='Sin Datos'){        $x29 = '';}else{$x29 = $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Cuerpo Indentificacion');
				$Form_Inputs->form_input_text('Contenedor Nro.', 'CTNNombreCompañia', $x1, 2);
				$Form_Inputs->form_date('Fecha del informe','Creacion_fecha', $x2, 2);
				$Form_Inputs->form_date('Fecha Inicio del Embarque','FechaInicioEmbarque', $x3, 1);
				$Form_Inputs->form_time('Hora Inicio Carga','HoraInicioCarga', $x4, 1, 1, 24);
				$Form_Inputs->form_date('Fecha Termino del Embarque','FechaTerminoEmbarque', $x5, 1);
				$Form_Inputs->form_time('Hora Termino Carga','HoraTerminoCarga', $x6, 1, 1, 24);
				$Form_Inputs->form_select_filter('Planta Despachadora','idPlantaDespacho', $x7, 1, 'idPlantaDespacho', 'Nombre', 'cross_shipping_plantas', $w, '', $dbConn);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x8, 2, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x9, 2, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_number_integer('Cantidad de Cajas', 'CantidadCajas', $x10, 1);
				$Form_Inputs->form_select_filter('N° Instructivo','idInstructivo', $x11, 1, 'idInstructivo', 'Codigo,Nombre', 'cross_shipping_instructivo', $w, '', $dbConn);
				$Form_Inputs->form_select_filter('Naviera','idNaviera', $x12, 1, 'idNaviera', 'Codigo,Nombre', 'cross_shipping_naviera', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Puerto Embarque','idPuertoEmbarque', $x13, 1, 'idPuertoEmbarque', 'Codigo,Nombre', 'cross_shipping_puerto_embarque', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Puerto Destino','idPuertoDestino', $x14, 1, 'idPuertoDestino', 'Codigo,Nombre', 'cross_shipping_puerto_destino', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Mercado','idMercado', $x15, 1, 'idMercado', 'Codigo,Nombre', 'cross_shipping_mercado', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Pais','idPais', $x16, 1, 'idPais', 'Nombre', 'core_paises', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Recibidor','idRecibidor', $x17, 1, 'idRecibidor', 'Codigo,Nombre', 'cross_shipping_recibidores', $w, '', $dbConn);

				$Form_Inputs->form_tittle(3, 'Cuerpo Indentificacion Empresa Transportista');
				$Form_Inputs->form_select_filter('Empresa Transporte','idEmpresaTransporte', $x18, 1, 'idEmpresaTransporte', 'Nombre', 'cross_shipping_empresa_transporte', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Conductor', 'ChoferNombreRut', $x19, 1);
				$Form_Inputs->form_input_text('Patente Camion', 'PatenteCamion', $x20, 1);
				$Form_Inputs->form_input_text('Patente Carro', 'PatenteCarro', $x21, 1);

				$Form_Inputs->form_tittle(3, 'Cuerpo Parametros Evaluados');
				$Form_Inputs->form_select('Condición CTN','idCondicion', $x22, 1, 'idCondicion', 'Nombre', 'core_cross_shipping_consolidacion_condicion', 0, '', $dbConn);
				$Form_Inputs->form_select('Sellado Piso','idSellado', $x23, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_input_number('T° Set Point', 'TSetPoint', $x24, 1);
				$Form_Inputs->form_input_number('T° Ventilacion', 'TVentilacion', $x25, 1);
				$Form_Inputs->form_input_number('T° Ambiente', 'TAmbiente', $x26, 1);
				$Form_Inputs->form_input_text('Numero de sello', 'NumeroSello', $x27, 1);
				$Form_Inputs->form_select_filter('Inspector','idInspector', $x28, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);

				$Form_Inputs->form_tittle(3, 'Otros');
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x29, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('randompass', $_GET['view'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
					<a href="<?php echo $location.'&view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
		$ubicacion = $location.'&clear_all='.$_GET['view'];
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view='.$_GET['view'].'&ing_Doc=true';
		$dialogo   = '¿Realmente desea ingresar el documento, una vez realizada no podra realizar cambios?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Control Proceso Preembarque - T° y Estiba de Contenedores</div>

		<div id="customer">

			<table id="meta" class="pull-left" style="width:100%" >
				<tbody>
					<tr>
						<td class="meta-head" colspan="3"><strong>DATOS MAESTROS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&view='.$_GET['view'].'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>

					<tr><td class="meta-head" colspan="4"><strong>Cuerpo Identificacion</strong></td></tr>
					<tr>
						<td class="meta-head">Contenedor Nro.</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CTNNombreCompañia']; ?></td>
						<td class="meta-head">Nro. Del Informe</td>
						<td><?php //if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['NInforme'])&&$_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['NInforme']!=''){echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['NInforme'];}else{echo 'Sin Datos';} ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha del informe</td>
						<td><?php echo fecha_estandar($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Creacion_fecha']); ?></td>
						<td class="meta-head"></td>
						<td></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Inicio del Embarque</td>
						<td><?php echo fecha_estandar($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['FechaInicioEmbarque']); ?></td>
						<td class="meta-head">Hora Inicio Carga</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['HoraInicioCarga']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Termino del Embarque</td>
						<td><?php echo fecha_estandar($_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['FechaTerminoEmbarque']); ?></td>
						<td class="meta-head">Hora Termino Carga</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['HoraTerminoCarga']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Planta Despachadora</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PlantaDespacho']; ?></td>
						<td class="meta-head">Especie/Variedad</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['ProdMuestra']; ?></td>

					</tr>
					<tr>
						<td class="meta-head">Cantidad de Cajas</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CantidadCajas']; ?></td>
						<td class="meta-head">N° Instructivo</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Instructivo']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Naviera</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Naviera']; ?></td>
						<td class="meta-head">Puerto Embarque</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PuertoEmbarque']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Puerto Destino</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PuertoDestino']; ?></td>
						<td class="meta-head">Mercado</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Mercado']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Pais</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Pais']; ?></td>
						<td class="meta-head">Recibidor</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Recibidor']; ?></td>
					</tr>
					
				
				

			
					<tr><td class="meta-head" colspan="4"><strong>Cuerpo Identificacion Empresa Transportista</strong></td></tr>
					<tr>
						<td class="meta-head">Empresa Transportista</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['EmpresaTransporte']; ?></td>
						<td class="meta-head">Conductor</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['ChoferNombreRut']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Patente Camion</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PatenteCamion']; ?></td>
						<td class="meta-head">Patente Carro</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['PatenteCarro']; ?></td>
					</tr>

					<tr><td class="meta-head" colspan="4"><strong>Cuerpo Parametros Evaluados</strong></td></tr>
					<tr>
						<td class="meta-head">Condición CTN</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['CondicionCTN']; ?></td>
						<td class="meta-head">Sellado Piso</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Sellado']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">T°Set Point</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TSetPoint']; ?></td>
						<td class="meta-head">T° Ventilacion</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TVentilacion']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">T° Ambiente</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['TAmbiente']; ?></td>
						<td class="meta-head">Numero de sello</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['NumeroSello']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Inspector</td>
						<td><?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Trabajador']; ?></td>
						<td class="meta-head"></td>
						<td></td>
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
					<td colspan="8">Estibas</td>
					<td>
						<a href="<?php echo $location.'&view='.$_GET['view'].'&addEstiba=true' ?>" title="Agregar Estiba" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Estiba</a>
					</td>
				</tr>
				<tr class="item-row fact_tittle">
					<td>Estiba</td>
					<td>Ubicación</td>
					<td>Posicion</td>
					<td>Envase</td>
					<td>Nro. De Pallet</td>
					<td>Temp. De Pulpa</td>
					<td>Marca Modelo Sensor</td>
					<td>Nro. Serie Sensor</td>
					<td></td>
				</tr>

				<?php
				if (isset($_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['cross_shipping_consolidacion_estibas'][$_GET['view']] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $producto['Estiba']; ?></td>
							<td class="item-name"><?php echo $producto['EstibaUbicacion']; ?></td>
							<td class="item-name"><?php echo $producto['Posicion']; ?></td>
							<td class="item-name"><?php echo $producto['Envase']; ?></td>
							<td class="item-name"><?php echo $producto['NPallet']; ?></td>
							<td class="item-name"><?php echo $producto['Temperatura']; ?></td>
							<td class="item-name"><?php echo $producto['Termografo']; ?></td>
							<td class="item-name"><?php echo $producto['NSerieSensor']; ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo $location.'&view='.$_GET['view'].'&cloneEstiba='.$producto['idInterno']; ?>" title="Clonar Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&view='.$_GET['view'].'&editEstiba='.$producto['idInterno']; ?>" title="Editar Registro" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&view='.$_GET['view'].'&del_estiba='.$producto['idInterno'];
									$dialogo   = '¿Realmente deseas eliminar el registro ?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Registro" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php }
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="9">No hay muestras asignadas</td></tr>';
					} ?>

				
					<tr id="hiderow"><td colspan="9"></td></tr>

					<td colspan="9" class="blank word_break">
						<?php echo $_SESSION['cross_shipping_consolidacion_basicos'][$_GET['view']]['Observaciones']; ?>
					</td>

				</tr>
				<tr><td colspan="9" class="blank"><p>Observaciones</p></td></tr>

			</tbody>
		</table>
    </div>

	<table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td>Archivos Adjuntos</td>
                <td width="160"><a href="<?php echo $location.'&view='.$_GET['view'].'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
            </tr>

			<?php
			if (isset($_SESSION['cross_shipping_consolidacion_archivos'][$_GET['view']])){

				//recorro el lsiatdo entregado por la base de datos
				foreach ($_SESSION['cross_shipping_consolidacion_archivos'][$_GET['view']] as $key => $productos){
					echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>'.$productos['ArchivoTipo'].'</strong></td></tr>';
					foreach ($productos as $producto) {
						if(isset($producto['idFile'])&&$producto['idFile']!=0){
						?>
							<tr class="item-row">
								<td><?php echo $producto['Nombre']; ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
										<?php
										$ubicacion = $location.'&view='.$_GET['view'].'&idArchivoTipo='.$producto['idArchivoTipo'].'&del_file='.$producto['idFile'];
										$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$producto['Nombre']).'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php
						}
					}
				}
			} ?>

		</tbody>
    </table>

</div>

<div class="clearfix"></div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['cloneConsolidacion'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Clonar Consolidacion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($CTNNombreCompañia)){   $x2 = $CTNNombreCompañia;  }else{$x2 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Contenedor Nro.', 'CTNNombreCompañia', $x2, 2);

				$Form_Inputs->form_input_hidden('randompass', genera_password_unica(), 2);
				$Form_Inputs->form_input_hidden('cloneConsolidacion', $_GET['cloneConsolidacion'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Clonar Documento" name="submit_clone">
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
			<h5>Crear Consolidacion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){      $x1 = $Creacion_fecha;     }else{$x1 = '';}
				if(isset($CTNNombreCompañia)){   $x2 = $CTNNombreCompañia;  }else{$x2 = '';}
				if(isset($idCategoria)){         $x3 = $idCategoria;        }else{$x3 = '';}
				if(isset($idProducto)){          $x4 = $idProducto;         }else{$x4 = '';}
				if(isset($Observaciones)){       $x5 = $Observaciones;      }else{$x5 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha del informe','Creacion_fecha', $x1, 2);
				$Form_Inputs->form_input_text('Contenedor Nro.', 'CTNNombreCompañia', $x2, 2);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x3, 2, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x4, 2, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');

				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('randompass', genera_password_unica(), 2);
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
		case 'fecha_asc':      $order_by = 'cross_shipping_consolidacion.Creacion_fecha ASC ';                            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha del informe Ascendente';break;
		case 'fecha_desc':     $order_by = 'cross_shipping_consolidacion.Creacion_fecha DESC ';                           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha del informe Descendente';break;
		case 'producto_asc':   $order_by = 'sistema_variedades_categorias.Nombre ASC, variedades_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Producto Ascendente';break;
		case 'producto_desc':  $order_by = 'sistema_variedades_categorias.Nombre DESC, variedades_listado.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Producto Descendente';break;
		case 'creador_asc':    $order_by = 'usuarios_listado.Nombre ASC ';                                                $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Creador Ascendente';break;
		case 'creador_desc':   $order_by = 'usuarios_listado.Nombre DESC ';                                               $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Creador Descendente';break;
		case 'ctn_asc':        $order_by = 'cross_shipping_consolidacion.CTNNombreCompañia ASC ';                         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Contenedor Ascendente';break;
		case 'ctn_desc':       $order_by = 'cross_shipping_consolidacion.CTNNombreCompañia DESC ';                        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Contenedor Descendente';break;

		default: $order_by = 'cross_shipping_consolidacion.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha del informe Descendente';
	}
}else{
	$order_by = 'cross_shipping_consolidacion.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha del informe Descendente';
}
/**********************************************************/
//Variable con la ubicacion
$SIS_where = "cross_shipping_consolidacion.idConsolidacion!=0";
$SIS_where.= " AND cross_shipping_consolidacion.idEstado=1";//Solo las que esten en espera de aprobacion
$SIS_where.= " AND cross_shipping_consolidacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//Verifico el tipo de usuario que esta ingresando
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){ $SIS_where .= " AND cross_shipping_consolidacion.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){       $SIS_where .= " AND cross_shipping_consolidacion.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){         $SIS_where .= " AND cross_shipping_consolidacion.idProducto=".$_GET['idProducto'];}
if(isset($_GET['CTNNombreCompañia']) && $_GET['CTNNombreCompañia']!=''){  $SIS_where .= " AND cross_shipping_consolidacion.CTNNombreCompañia LIKE '%".EstandarizarInput($_GET['CTNNombreCompañia'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idConsolidacion', 'cross_shipping_consolidacion', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
cross_shipping_consolidacion.idConsolidacion,
cross_shipping_consolidacion.Creacion_fecha,
cross_shipping_consolidacion.CTNNombreCompañia,
usuarios_listado.Nombre AS Usuario,
core_sistemas.Nombre AS Sistema,
sistema_variedades_categorias.Nombre AS ProductoCategoria,
variedades_listado.Nombre AS ProductoNombre';
$SIS_join  = '
LEFT JOIN `usuarios_listado`               ON usuarios_listado.idUsuario                 = cross_shipping_consolidacion.idUsuario
LEFT JOIN `core_sistemas`                  ON core_sistemas.idSistema                    = cross_shipping_consolidacion.idSistema
LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_shipping_consolidacion.idCategoria
LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_shipping_consolidacion.idProducto';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

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
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Consolidacion</a>
	<?php } ?>
</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){      $x1  = $Creacion_fecha;    }else{$x1  = '';}
				if(isset($idCategoria)){         $x2  = $idCategoria;       }else{$x2  = '';}
				if(isset($idProducto)){          $x3  = $idProducto;        }else{$x3  = '';}
				if(isset($CTNNombreCompañia)){   $x4  = $CTNNombreCompañia; }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha del informe','Creacion_fecha', $x1, 1);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x2, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x3, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_text('Contenedor Nro.', 'CTNNombreCompañia', $x4, 1);

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

<?php
//variable 
$pasa = 0;
//se verifica que existan items
if (isset($_SESSION['cross_shipping_consolidacion_basicos'])){
	foreach ($_SESSION['cross_shipping_consolidacion_basicos'] as $tipo) {
		if(isset($tipo['CTNNombreCompañia'])){
			$pasa++;
		}
	}
}
if(isset($pasa)&&$pasa!=0){ ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Consolidaciones Abiertas</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Fecha del informe</th>
							<th>Contenedor Nro.</th>
							<th>Categoria - Producto</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($_SESSION['cross_shipping_consolidacion_basicos'] as $tipo) { ?>
						<tr class="odd">
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo $tipo['CTNNombreCompañia']; ?></td>
							<td><?php echo $tipo['ProdMuestra']; ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&cloneConsolidacion='.$tipo['randompass']; ?>" title="Clonar Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&view='.$tipo['randompass']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&clear_all='.$tipo['randompass'];
										$dialogo   = '¿Realmente deseas eliminar el ingreso de '.$tipo['CTNNombreCompañia'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
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

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Consolidaciones En espera de Aprobacion</h5>
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
							<div class="pull-left">Fecha del informe</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Contenedor Nro.</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=ctn_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=ctn_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Categoria - Producto</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=producto_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=producto_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Creador</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=creador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=creador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
					<tr class="odd">
						<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
						<td><?php echo $tipo['CTNNombreCompañia']; ?></td>
						<td><?php echo $tipo['ProductoCategoria'].' - '.$tipo['ProductoNombre']; ?></td>
						<td><?php echo $tipo['Usuario']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_cross_shipping_consolidacion.php?view='.simpleEncode($tipo['idConsolidacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a target="new" href="<?php echo 'cross_shipping_consolidacion_edit.php?edit='.$tipo['idConsolidacion']; ?>" title="Editar Consolidacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
