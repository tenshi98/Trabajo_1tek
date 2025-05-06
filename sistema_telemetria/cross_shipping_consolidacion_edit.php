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
$new_location = "cross_shipping_consolidacion_edit.php";
$new_location .='?edit='.$_GET['edit'];
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'updateConsolidacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'insert_file';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_file';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_estiba'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'insertEstiba';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_estiba'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'updateEstiba';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
//se borra un dato
if (!empty($_GET['del_estiba'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'delEstiba';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_shipping_consolidacion.php';
}
/**********************************************/
//se borra un dato
if (!empty($_GET['modEdit'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'modEdit';
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
if(!empty($_GET['addFile'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'CTNNombreCompañia';
	$SIS_join  = '';
	$SIS_where = 'idConsolidacion = '.$_GET['edit'];
	$rowConso = db_select_data (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowConso');

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
					$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 15, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

					$Form_Inputs->form_select('Tipo Foto','idArchivoTipo', $x1, 2, 'idArchivoTipo', 'Nombre', 'core_cross_shipping_archivos_tipos', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idConsolidacion', $_GET['edit'], 2);
					$Form_Inputs->form_input_hidden('CTNNombreCompañia', $rowConso['CTNNombreCompañia'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
						<a href="<?php echo $new_location.'&edit='.$_GET['edit']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['cloneEstiba'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idEstiba, idEstibaUbicacion, idPosicion, idEnvase, NPallet, Temperatura, idTermografo, NSerieSensor';
	$SIS_join  = '';
	$SIS_where = 'idEstibaListado = '.$_GET['cloneEstiba'];
	$rowEstiba = db_select_data (false, $SIS_query, 'cross_shipping_consolidacion_estibas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEstiba');

	?>

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
					if(isset($idEstiba)){           $x1  = $idEstiba;           }else{$x1  = $rowEstiba['idEstiba'];}
					if(isset($idEstibaUbicacion)){  $x2  = $idEstibaUbicacion;  }else{$x2  = $rowEstiba['idEstibaUbicacion'];}
					if(isset($idPosicion)){         $x3  = $idPosicion;         }else{$x3  = $rowEstiba['idPosicion'];}
					if(isset($idEnvase)){           $x4  = $idEnvase;           }else{$x4  = $rowEstiba['idEnvase'];}
					if(isset($NPallet)){            $x5  = $NPallet;            }else{$x5  = $rowEstiba['NPallet'];}
					if(isset($Temperatura)){        $x6  = $Temperatura;        }else{$x6  = Cantidades_decimales_justos($rowEstiba['Temperatura']);}
					if(isset($idTermografo)){       $x7  = $idTermografo;       }else{$x7  = $rowEstiba['idTermografo'];}
					if(isset($NSerieSensor)){       $x8  = $NSerieSensor;       }else{$x8  = $rowEstiba['NSerieSensor'];}

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

					$Form_Inputs->form_input_hidden('idConsolidacion', $_GET['edit'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_estiba">
						<a href="<?php echo $new_location.'&edit='.$_GET['edit']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editEstiba'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idEstiba, idEstibaUbicacion, idPosicion, idEnvase, NPallet, Temperatura, idTermografo, NSerieSensor';
	$SIS_join  = '';
	$SIS_where = 'idEstibaListado = '.$_GET['editEstiba'];
	$rowEstiba = db_select_data (false, $SIS_query, 'cross_shipping_consolidacion_estibas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEstiba');

	?>

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
					if(isset($idEstiba)){           $x1  = $idEstiba;           }else{$x1  = $rowEstiba['idEstiba'];}
					if(isset($idEstibaUbicacion)){  $x2  = $idEstibaUbicacion;  }else{$x2  = $rowEstiba['idEstibaUbicacion'];}
					if(isset($idPosicion)){         $x3  = $idPosicion;         }else{$x3  = $rowEstiba['idPosicion'];}
					if(isset($idEnvase)){           $x4  = $idEnvase;           }else{$x4  = $rowEstiba['idEnvase'];}
					if(isset($NPallet)){            $x5  = $NPallet;            }else{$x5  = $rowEstiba['NPallet'];}
					if(isset($Temperatura)){        $x6  = $Temperatura;        }else{$x6  = Cantidades_decimales_justos($rowEstiba['Temperatura']);}
					if(isset($idTermografo)){       $x7  = $idTermografo;       }else{$x7  = $rowEstiba['idTermografo'];}
					if(isset($NSerieSensor)){       $x8  = $NSerieSensor;       }else{$x8  = $rowEstiba['NSerieSensor'];}

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

					$Form_Inputs->form_input_hidden('idEstibaListado', $_GET['editEstiba'], 2);
					$Form_Inputs->form_input_hidden('idConsolidacion', $_GET['edit'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_estiba">
						<a href="<?php echo $new_location.'&edit='.$_GET['edit']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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

					$Form_Inputs->form_input_hidden('idConsolidacion', $_GET['edit'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_estiba">
						<a href="<?php echo $new_location.'&edit='.$_GET['edit']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Creacion_fecha,CTNNombreCompañia,FechaInicioEmbarque,HoraInicioCarga,FechaTerminoEmbarque,
	HoraTerminoCarga,CantidadCajas,ChoferNombreRut,PatenteCamion,PatenteCarro,TSetPoint,TVentilacion,TAmbiente,
	NumeroSello,idInspector,Observaciones,Observacion,Aprobacion_Fecha,Aprobacion_Hora,idSistema,idUsuario,
	idPlantaDespacho,idCategoria,idProducto,idInstructivo,idNaviera,idPuertoEmbarque,idPuertoDestino,idMercado,
	idPais,idEmpresaTransporte,idCondicion,idSellado,idEstado,idAprobador, idRecibidor';
	$SIS_join  = '';
	$SIS_where = 'idConsolidacion = '.$_GET['edit'];
	$rowConso = db_select_data (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowConso');

	/*******************************************************/
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
					if(isset($CTNNombreCompañia)){     $x1  = $CTNNombreCompañia;     }else{$x1  = $rowConso['CTNNombreCompañia'];}
					if(isset($Creacion_fecha)){        $x2  = $Creacion_fecha;        }else{$x2  = $rowConso['Creacion_fecha'];}
					if(isset($FechaInicioEmbarque)){   $x3  = $FechaInicioEmbarque;   }else{$x3  = $rowConso['FechaInicioEmbarque'];}
					if(isset($HoraInicioCarga)){       $x4  = $HoraInicioCarga;       }else{$x4  = $rowConso['HoraInicioCarga'];}
					if(isset($FechaTerminoEmbarque)){  $x5  = $FechaTerminoEmbarque;  }else{$x5  = $rowConso['FechaTerminoEmbarque'];}
					if(isset($HoraTerminoCarga)){      $x6  = $HoraTerminoCarga;      }else{$x6  = $rowConso['HoraTerminoCarga'];}
					if(isset($idPlantaDespacho)){      $x7  = $idPlantaDespacho;      }else{$x7  = $rowConso['idPlantaDespacho'];}
					if(isset($idCategoria)){           $x8  = $idCategoria;           }else{$x8  = $rowConso['idCategoria'];}
					if(isset($idProducto)){            $x9  = $idProducto;            }else{$x9  = $rowConso['idProducto'];}
					if(isset($CantidadCajas)){         $x10 = $CantidadCajas;         }else{$x10 = $rowConso['CantidadCajas'];}
					if(isset($idInstructivo)){         $x11 = $idInstructivo;         }else{$x11 = $rowConso['idInstructivo'];}
					if(isset($idNaviera)){             $x12 = $idNaviera;             }else{$x12 = $rowConso['idNaviera'];}
					if(isset($idPuertoEmbarque)){      $x13 = $idPuertoEmbarque;      }else{$x13 = $rowConso['idPuertoEmbarque'];}
					if(isset($idPuertoDestino)){       $x14 = $idPuertoDestino;       }else{$x14 = $rowConso['idPuertoDestino'];}
					if(isset($idMercado)){             $x15 = $idMercado;             }else{$x15 = $rowConso['idMercado'];}
					if(isset($idPais)){                $x16 = $idPais;                }else{$x16 = $rowConso['idPais'];}
					if(isset($idRecibidor)){           $x17 = $idRecibidor;           }else{$x17 = $rowConso['idRecibidor'];}
					if(isset($idEmpresaTransporte)){   $x18 = $idEmpresaTransporte;   }else{$x18 = $rowConso['idEmpresaTransporte'];}
					if(isset($ChoferNombreRut)){       $x19 = $ChoferNombreRut;       }else{$x19 = $rowConso['ChoferNombreRut'];}
					if(isset($PatenteCamion)){         $x20 = $PatenteCamion;         }else{$x20 = $rowConso['PatenteCamion'];}
					if(isset($PatenteCarro)){          $x21 = $PatenteCarro;          }else{$x21 = $rowConso['PatenteCarro'];}
					if(isset($idCondicion)){           $x22 = $idCondicion;           }else{$x22 = $rowConso['idCondicion'];}
					if(isset($idSellado)){             $x23 = $idSellado;             }else{$x23 = $rowConso['idSellado'];}
					if(isset($TSetPoint)){             $x24 = $TSetPoint;             }else{$x24 = Cantidades_decimales_justos($rowConso['TSetPoint']);}
					if(isset($TVentilacion)){          $x25 = $TVentilacion;          }else{$x25 = Cantidades_decimales_justos($rowConso['TVentilacion']);}
					if(isset($TAmbiente)){             $x26 = $TAmbiente;             }else{$x26 = Cantidades_decimales_justos($rowConso['TAmbiente']);}
					if(isset($NumeroSello)){           $x27 = $NumeroSello;           }else{$x27 = $rowConso['NumeroSello'];}
					if(isset($idInspector)){           $x28 = $idInspector;           }else{$x28 = $rowConso['idInspector'];}
					if(isset($Observaciones)){         $x29 = $Observaciones;         }else{$x29 = $rowConso['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Cuerpo Indentificacion');
					$Form_Inputs->form_input_text('Contenedor Nro.', 'CTNNombreCompañia', $x1, 2);
					$Form_Inputs->form_date('Fecha del informe','Creacion_fecha', $x2, 1);
					$Form_Inputs->form_date('Fecha Inicio del Embarque','FechaInicioEmbarque', $x3, 1);
					$Form_Inputs->form_time('Hora Inicio Carga','HoraInicioCarga', $x4, 1, 1, 24);
					$Form_Inputs->form_date('Fecha Termino del Embarque','FechaTerminoEmbarque', $x5, 1);
					$Form_Inputs->form_time('Hora Termino Carga','HoraTerminoCarga', $x6, 1, 1, 24);
					$Form_Inputs->form_select_filter('Planta Despachadora','idPlantaDespacho', $x7, 1, 'idPlantaDespacho', 'Codigo,Nombre', 'cross_shipping_plantas', $w, '', $dbConn);
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x8, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
											'Variedad','idProducto', $x9, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
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
					$Form_Inputs->form_input_hidden('idConsolidacion', $_GET['edit'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
						<a href="<?php echo $new_location.'&edit='.$_GET['edit']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cross_shipping_consolidacion.idEstado,
	cross_shipping_consolidacion.Creacion_fecha,
	cross_shipping_consolidacion.CTNNombreCompañia,
	cross_shipping_consolidacion.FechaInicioEmbarque,
	cross_shipping_consolidacion.HoraInicioCarga,
	cross_shipping_consolidacion.FechaTerminoEmbarque,
	cross_shipping_consolidacion.HoraTerminoCarga,
	cross_shipping_consolidacion.CantidadCajas,
	cross_shipping_consolidacion.ChoferNombreRut,
	cross_shipping_consolidacion.PatenteCamion,
	cross_shipping_consolidacion.PatenteCarro,
	cross_shipping_consolidacion.TSetPoint,
	cross_shipping_consolidacion.TVentilacion,
	cross_shipping_consolidacion.TAmbiente,
	cross_shipping_consolidacion.NumeroSello,
	cross_shipping_consolidacion.idInspector,
	cross_shipping_consolidacion.Observaciones,
	cross_shipping_consolidacion.Observacion,
	cross_shipping_consolidacion.Aprobacion_Fecha,
	cross_shipping_consolidacion.Aprobacion_Hora,
	cross_shipping_consolidacion.NInforme,

	core_sistemas.Nombre AS Sistema,
	usuarios_listado.Nombre AS UsuarioCreador,
	cross_shipping_plantas.Nombre AS PlantaNombre,
	cross_shipping_plantas.Codigo AS PlantaCodigo,
	sistema_variedades_categorias.Nombre AS Especie,
	variedades_listado.Nombre AS Variedad,
	cross_shipping_instructivo.Nombre AS InstructivoNombre,
	cross_shipping_instructivo.Codigo AS InstructivoCodigo,
	cross_shipping_naviera.Nombre AS NavieraNombre,
	cross_shipping_naviera.Codigo AS NavieraCodigo,
	cross_shipping_puerto_embarque.Nombre AS EmbarqueNombre,
	cross_shipping_puerto_embarque.Codigo AS EmbarqueCodigo,
	cross_shipping_puerto_destino.Nombre AS DestinoNombre,
	cross_shipping_puerto_destino.Codigo AS DestinoCodigo,
	cross_shipping_mercado.Nombre AS MercadoNombre,
	cross_shipping_mercado.Codigo AS MercadoCodigo,
	core_paises.Nombre AS PaisesNombre,
	cross_shipping_empresa_transporte.Nombre AS TransporteNombre,
	cross_shipping_empresa_transporte.Codigo AS TransporteCodigo,
	core_cross_shipping_consolidacion_condicion.Nombre AS Condicion,
	core_sistemas_opciones.Nombre AS Sellado,
	core_oc_estado.Nombre AS Estado,
	trabajadores_listado.Nombre AS InspectorNombre,
	trabajadores_listado.ApellidoPat AS InspectorApellido,
	cross_shipping_recibidores.Nombre AS RecibidorNombre,
	cross_shipping_recibidores.Codigo AS RecibidorCodigo';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                                ON core_sistemas.idSistema                                   = cross_shipping_consolidacion.idSistema
	LEFT JOIN `usuarios_listado`                             ON usuarios_listado.idUsuario                                = cross_shipping_consolidacion.idUsuario
	LEFT JOIN `cross_shipping_plantas`                       ON cross_shipping_plantas.idPlantaDespacho                   = cross_shipping_consolidacion.idPlantaDespacho
	LEFT JOIN `sistema_variedades_categorias`                ON sistema_variedades_categorias.idCategoria                 = cross_shipping_consolidacion.idCategoria
	LEFT JOIN `variedades_listado`                           ON variedades_listado.idProducto                             = cross_shipping_consolidacion.idProducto
	LEFT JOIN `cross_shipping_instructivo`                   ON cross_shipping_instructivo.idInstructivo                  = cross_shipping_consolidacion.idInstructivo
	LEFT JOIN `cross_shipping_naviera`                       ON cross_shipping_naviera.idNaviera                          = cross_shipping_consolidacion.idNaviera
	LEFT JOIN `cross_shipping_puerto_embarque`               ON cross_shipping_puerto_embarque.idPuertoEmbarque           = cross_shipping_consolidacion.idPuertoEmbarque
	LEFT JOIN `cross_shipping_puerto_destino`                ON cross_shipping_puerto_destino.idPuertoDestino             = cross_shipping_consolidacion.idPuertoDestino
	LEFT JOIN `cross_shipping_mercado`                       ON cross_shipping_mercado.idMercado                          = cross_shipping_consolidacion.idMercado
	LEFT JOIN `core_paises`                                  ON core_paises.idPais                                        = cross_shipping_consolidacion.idPais
	LEFT JOIN `cross_shipping_empresa_transporte`            ON cross_shipping_empresa_transporte.idEmpresaTransporte     = cross_shipping_consolidacion.idEmpresaTransporte
	LEFT JOIN `core_cross_shipping_consolidacion_condicion`  ON core_cross_shipping_consolidacion_condicion.idCondicion   = cross_shipping_consolidacion.idCondicion
	LEFT JOIN `core_sistemas_opciones`                       ON core_sistemas_opciones.idOpciones                         = cross_shipping_consolidacion.idSellado
	LEFT JOIN `core_oc_estado`                               ON core_oc_estado.idEstado                                   = cross_shipping_consolidacion.idEstado
	LEFT JOIN `trabajadores_listado`                         ON trabajadores_listado.idTrabajador                         = cross_shipping_consolidacion.idAprobador
	LEFT JOIN `cross_shipping_recibidores`                   ON cross_shipping_recibidores.idRecibidor                    = cross_shipping_consolidacion.idRecibidor';
	$SIS_where = 'cross_shipping_consolidacion.idConsolidacion ='.$_GET['edit'];
	$rowConso = db_select_data (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowConso');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cross_shipping_consolidacion_estibas.idEstibaListado,
	cross_shipping_consolidacion_estibas.NPallet,
	cross_shipping_consolidacion_estibas.Temperatura,
	cross_shipping_consolidacion_estibas.NSerieSensor,

	core_estibas.Nombre AS Estiba,
	core_estibas_ubicacion.Nombre AS EstibaUbicacion,
	core_cross_shipping_consolidacion_posicion.Nombre AS Posicion,
	cross_shipping_envase.Nombre AS Envase,
	cross_shipping_termografo.Nombre AS Termografo';
	$SIS_join  = '
	LEFT JOIN `core_estibas`                                  ON core_estibas.idEstiba                                    = cross_shipping_consolidacion_estibas.idEstiba
	LEFT JOIN `core_estibas_ubicacion`                        ON core_estibas_ubicacion.idEstibaUbicacion                 = cross_shipping_consolidacion_estibas.idEstibaUbicacion
	LEFT JOIN `core_cross_shipping_consolidacion_posicion`    ON core_cross_shipping_consolidacion_posicion.idPosicion    = cross_shipping_consolidacion_estibas.idPosicion
	LEFT JOIN `cross_shipping_envase`                         ON cross_shipping_envase.idEnvase                           = cross_shipping_consolidacion_estibas.idEnvase
	LEFT JOIN `cross_shipping_termografo`                     ON cross_shipping_termografo.idTermografo                   = cross_shipping_consolidacion_estibas.idTermografo';
	$SIS_where = 'cross_shipping_consolidacion_estibas.idConsolidacion ='.$_GET['edit'];
	$SIS_order = 'cross_shipping_consolidacion_estibas.idEstiba ASC';
	$SIS_order.= ', core_estibas_ubicacion.Nombre ASC';
	$arrEstibas = array();
	$arrEstibas = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_estibas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEstibas');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cross_shipping_consolidacion_archivo.idArchivo,
	cross_shipping_consolidacion_archivo.idArchivoTipo,
	cross_shipping_consolidacion_archivo.Nombre,

	core_cross_shipping_archivos_tipos.Nombre AS Tipo';
	$SIS_join  = 'LEFT JOIN `core_cross_shipping_archivos_tipos` ON core_cross_shipping_archivos_tipos.idArchivoTipo = cross_shipping_consolidacion_archivo.idArchivoTipo';
	$SIS_where = 'cross_shipping_consolidacion_archivo.idConsolidacion ='.$_GET['edit'];
	$SIS_order = 0;
	$arrArchivos = array();
	$arrArchivos = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_archivo', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArchivos');

	?>

	<?php //Solo rechazados
	if(isset($rowConso['idEstado'])&&$rowConso['idEstado']==3){ ?>
		<div class="no-print">
			<div class="col-xs-12">
				<a href="<?php echo $new_location.'&edit='.$_GET['edit'].'&modEdit=true' ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
					<i class="fa fa-check" aria-hidden="true"></i> Terminar Edicion
				</a>
			</div>
		</div>
		<div class="clearfix"></div>
	<?php } ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<div id="page-wrap">
			<div id="header"> Control Proceso Preembarque - T° y Estiba de Contenedores</div>

			<div id="customer">

				<table id="meta" class="pull-left" style="width:100%" >
					<tbody>
						<tr>
							<td class="meta-head" colspan="3"><strong>DATOS MAESTROS</strong></td>
							<td class="meta-head"><a href="<?php echo $new_location.'&edit='.$_GET['edit'].'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>

						<tr><td class="meta-head" colspan="4"><strong>Cuerpo Identificacion</strong></td></tr>
						<tr>
							<td class="meta-head">Contenedor Nro.</td>
							<td><?php if(isset($rowConso['CTNNombreCompañia'])&&$rowConso['CTNNombreCompañia']!=''){echo $rowConso['CTNNombreCompañia'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Nro. Del Informe</td>
							<td><?php if(isset($rowConso['NInforme'])&&$rowConso['NInforme']!=''){echo $rowConso['NInforme'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha del informe</td>
							<td><?php if(isset($rowConso['Creacion_fecha'])&&$rowConso['Creacion_fecha']!=''){echo fecha_estandar($rowConso['Creacion_fecha']);}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head"></td>
							<td></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha Inicio del Embarque</td>
							<td><?php if(isset($rowConso['FechaInicioEmbarque'])&&$rowConso['FechaInicioEmbarque']!=''){echo fecha_estandar($rowConso['FechaInicioEmbarque']);}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Hora Inicio Carga</td>
							<td><?php if(isset($rowConso['HoraInicioCarga'])&&$rowConso['HoraInicioCarga']!=''){echo $rowConso['HoraInicioCarga'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha Termino del Embarque</td>
							<td><?php if(isset($rowConso['FechaTerminoEmbarque'])&&$rowConso['FechaTerminoEmbarque']!=''){echo fecha_estandar($rowConso['FechaTerminoEmbarque']);}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Hora Termino Carga</td>
							<td><?php if(isset($rowConso['HoraTerminoCarga'])&&$rowConso['HoraTerminoCarga']!=''){echo $rowConso['HoraTerminoCarga'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Planta Despachadora</td>
							<td><?php if(isset($rowConso['PlantaNombre'])&&$rowConso['PlantaNombre']!=''){echo $rowConso['PlantaCodigo'].' - '.$rowConso['PlantaNombre'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Especie/Variedad</td>
							<td><?php if(isset($rowConso['Especie'])&&$rowConso['Especie']!=''){echo $rowConso['Especie'].' '.$rowConso['Variedad'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Cantidad de Cajas</td>
							<td><?php if(isset($rowConso['CantidadCajas'])&&$rowConso['CantidadCajas']!=''){echo $rowConso['CantidadCajas'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">N° Instructivo</td>
							<td><?php if(isset($rowConso['InstructivoNombre'])&&$rowConso['InstructivoNombre']!=''){echo $rowConso['InstructivoCodigo'].' - '.$rowConso['InstructivoNombre'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Naviera</td>
							<td><?php if(isset($rowConso['NavieraNombre'])&&$rowConso['NavieraNombre']!=''){echo $rowConso['NavieraCodigo'].' - '.$rowConso['NavieraNombre'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Puerto Embarque</td>
							<td><?php if(isset($rowConso['EmbarqueNombre'])&&$rowConso['EmbarqueNombre']!=''){echo $rowConso['EmbarqueCodigo'].' - '.$rowConso['EmbarqueNombre'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Puerto Destino</td>
							<td><?php if(isset($rowConso['DestinoNombre'])&&$rowConso['DestinoNombre']!=''){echo $rowConso['DestinoCodigo'].' - '.$rowConso['DestinoNombre'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Mercado</td>
							<td><?php if(isset($rowConso['MercadoNombre'])&&$rowConso['MercadoNombre']!=''){echo $rowConso['MercadoCodigo'].' - '.$rowConso['MercadoNombre'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Pais</td>
							<td><?php if(isset($rowConso['PaisesNombre'])&&$rowConso['PaisesNombre']!=''){echo $rowConso['PaisesNombre'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Recibidor</td>
							<td><?php if(isset($rowConso['RecibidorNombre'])&&$rowConso['RecibidorNombre']!=''){echo $rowConso['RecibidorCodigo'].' - '.$rowConso['RecibidorNombre'];}else{echo 'Sin Datos';} ?></td>
						</tr>

						<tr><td class="meta-head" colspan="4"><strong>Cuerpo Identificacion Empresa Transportista</strong></td></tr>
						<tr>
							<td class="meta-head">Empresa Transportista</td>
							<td><?php if(isset($rowConso['TransporteNombre'])&&$rowConso['TransporteNombre']!=''){echo $rowConso['TransporteCodigo'].' - '.$rowConso['TransporteNombre'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Conductor</td>
							<td><?php if(isset($rowConso['ChoferNombreRut'])&&$rowConso['ChoferNombreRut']!=''){echo $rowConso['ChoferNombreRut'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Patente Camion</td>
							<td><?php if(isset($rowConso['PatenteCamion'])&&$rowConso['PatenteCamion']!=''){echo $rowConso['PatenteCamion'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Patente Carro</td>
							<td><?php if(isset($rowConso['PatenteCarro'])&&$rowConso['PatenteCarro']!=''){echo $rowConso['PatenteCarro'];}else{echo 'Sin Datos';} ?></td>
						</tr>

						<tr><td class="meta-head" colspan="4"><strong>Cuerpo Parametros Evaluados</strong></td></tr>
						<tr>
							<td class="meta-head">Condición CTN</td>
							<td><?php if(isset($rowConso['Condicion'])&&$rowConso['Condicion']!=''){echo $rowConso['Condicion'];}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Sellado Piso</td>
							<td><?php if(isset($rowConso['Sellado'])&&$rowConso['Sellado']!=''){echo $rowConso['Sellado'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">T°Set Point</td>
							<td><?php if(isset($rowConso['TSetPoint'])&&$rowConso['TSetPoint']!=''){echo Cantidades_decimales_justos($rowConso['TSetPoint']);}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">T° Ventilacion</td>
							<td><?php if(isset($rowConso['TSetPoint'])&&$rowConso['TSetPoint']!=''){echo Cantidades_decimales_justos($rowConso['TVentilacion']);}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">T° Ambiente</td>
							<td><?php if(isset($rowConso['TAmbiente'])&&$rowConso['TAmbiente']!=''){echo Cantidades_decimales_justos($rowConso['TAmbiente']);}else{echo 'Sin Datos';} ?></td>
							<td class="meta-head">Numero de sello</td>
							<td><?php if(isset($rowConso['NumeroSello'])&&$rowConso['NumeroSello']!=''){echo $rowConso['NumeroSello'];}else{echo 'Sin Datos';} ?></td>
						</tr>
						<tr>
							<td class="meta-head">Inspector</td>
							<td><?php if(isset($rowConso['InspectorNombre'])&&$rowConso['InspectorNombre']!=''){echo $rowConso['InspectorNombre'].' '.$rowConso['InspectorApellido'];}else{echo 'Sin Datos';} ?></td>
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
							<a href="<?php echo $new_location.'&edit='.$_GET['edit'].'&addEstiba=true' ?>" title="Agregar Estiba" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Estiba</a>
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
					//recorro el lsiatdo entregado por la base de datos
					foreach ($arrEstibas as $estiba){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $estiba['Estiba']; ?></td>
							<td class="item-name"><?php echo $estiba['EstibaUbicacion']; ?></td>
							<td class="item-name"><?php echo $estiba['Posicion']; ?></td>
							<td class="item-name"><?php echo $estiba['Envase']; ?></td>
							<td class="item-name"><?php echo $estiba['NPallet']; ?></td>
							<td class="item-name"><?php echo Cantidades_decimales_justos($estiba['Temperatura']); ?></td>
							<td class="item-name"><?php echo $estiba['Termografo']; ?></td>
							<td class="item-name"><?php echo $estiba['NSerieSensor']; ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo $new_location.'&edit='.$_GET['edit'].'&cloneEstiba='.$estiba['idEstibaListado']; ?>" title="Clonar Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a>
									<a href="<?php echo $new_location.'&edit='.$_GET['edit'].'&editEstiba='.$estiba['idEstibaListado']; ?>" title="Editar Registro" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $new_location.'&edit='.$_GET['edit'].'&del_estiba='.simpleEncode($estiba['idEstibaListado'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el registro ?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Registro" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>

					<tr id="hiderow"><td colspan="9"></td></tr>

					<td colspan="9" class="blank word_break">
						<?php echo $rowConso['Observaciones']; ?>
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
					<td width="160"><a href="<?php echo $new_location.'&edit='.$_GET['edit'].'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
				</tr>

				<?php
				filtrar($arrArchivos, 'Tipo');
				foreach($arrArchivos as $categoria=>$archivos){
					echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
					foreach ($archivos as $arch) { ?>
						<tr class="item-row">
							<td><?php echo $arch['Nombre']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($arch['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $new_location.'&edit='.$_GET['edit'].'&del_file='.simpleEncode($arch['idArchivo'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$arch['Nombre']).'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
				<?php
					}
				} ?>

			</tbody>
		</table>
	</div>

	<div class="clearfix"></div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
