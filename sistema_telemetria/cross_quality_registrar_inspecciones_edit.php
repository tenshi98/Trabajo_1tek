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
$original = "cross_quality_registrar_inspecciones.php";
$location = $original;
$new_location = "cross_quality_registrar_inspecciones_edit.php";
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
	$form_trabajo= 'modBase_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_trab'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'addTrab_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
//se borra un trabajo
if (!empty($_GET['del_trab'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_trab_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_maq'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'addMaq_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
//se borra un trabajo
if (!empty($_GET['del_maq'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_maq_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'new_file_ing_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_file_ing_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_muestra'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'new_muestra_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_muestra'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'edit_muestra_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
//se borra un dato
if (!empty($_GET['del_muestra'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_muestra_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
}
/**********************************************/
//se hace el ingreso a bodega
if (!empty($_GET['ing_Doc'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'ing_Doc_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_registrar_inspecciones.php';
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
	// Se traen todos los datos del analisis
	$SIS_query = 'idAnalisis,Creacion_fecha,idTipo,Temporada,idCategoria,idProducto,idUbicacion,idUbicacion_lvl_1,idUbicacion_lvl_2,idUbicacion_lvl_3,idUbicacion_lvl_4,idUbicacion_lvl_5,idSistema';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
					//Se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 1, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

					$Form_Inputs->form_input_hidden('idAnalisis', $rowData['idAnalisis'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', $rowData['Creacion_fecha'], 2);
					$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
					$Form_Inputs->form_input_hidden('Temporada', $rowData['Temporada'], 2);
					$Form_Inputs->form_input_hidden('idCategoria', $rowData['idCategoria'], 2);
					$Form_Inputs->form_input_hidden('idProducto', $rowData['idProducto'], 2);
					$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
					if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
					if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
					if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
					if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
					if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['cloneMuestra'])){
	//Armo cadena
	$SIS_query  = 'Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3, Validar_1, Validar_2, Validar_3';
	for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
		$SIS_query .= ',Validacion_'.$i;
	}

	// consulto los datos
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idCalidad'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/***********************************************/
	// Se trae un listado con todos los grupos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = 'idGrupo!=0';
	$SIS_order = 'Nombre ASC';
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

	/***********************************************/
	// consulto los datos
	$SIS_query = 'idMuestras,n_folio_pallet,lote,f_embalaje,f_cosecha,H_inspeccion,cantidad,peso,idProductor,idTipo';
	$SIS_join  = '';
	$SIS_where = 'idMuestras ='.$_GET['cloneMuestra'];
	$rowMuestras = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones_muestras', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowMuestras');

	/*****************************************************/
	// Se traen todos los datos del analisis
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Ingreso datos de <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idProductor)){     $x1  = $idProductor;     }else{$x1  = $rowMuestras['idProductor'];}
					if(isset($n_folio_pallet)){  $x2  = $n_folio_pallet;  }else{$x2  = $rowMuestras['n_folio_pallet'];}
					if(isset($idTipo)){          $x3  = $idTipo;          }else{$x3  = $rowMuestras['idTipo'];}
					if(isset($lote)){            $x4  = $lote;            }else{$x4  = $rowMuestras['lote'];}
					if(isset($f_embalaje)){      $x5  = $f_embalaje;      }else{$x5  = $rowMuestras['f_embalaje'];}
					if(isset($f_cosecha)){       $x6  = $f_cosecha;       }else{$x6  = $rowMuestras['f_cosecha'];}
					if(isset($H_inspeccion)){    $x7  = $H_inspeccion;    }else{$x7  = $rowMuestras['H_inspeccion'];}
					if(isset($cantidad)){        $x8  = $cantidad;        }else{$x8  = $rowMuestras['cantidad'];}
					if(isset($peso)){            $x9  = $peso;            }else{$x9  = $rowMuestras['peso'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_select_filter('Productor','idProductor', $x1, 2, 'idProductor', 'Codigo,Nombre', 'productores_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_text('N° Folio / Pallet', 'n_folio_pallet', $x2, 2);
					$Form_Inputs->form_select_filter('Tipo Embalaje','idTipo', $x3, 2, 'idTipo', 'Codigo,Nombre', 'sistema_cross_analisis_embalaje', $z, '', $dbConn);
					$Form_Inputs->form_input_text('Lote', 'lote', $x4, 2);
					$Form_Inputs->form_date('Fecha Embalaje','f_embalaje', $x5, 2);
					$Form_Inputs->form_date('Fecha Cosecha','f_cosecha', $x6, 2);
					$Form_Inputs->form_time_popover('Hora Inspeccion','H_inspeccion', $x7, 1, 1, 24);
					$Form_Inputs->form_input_number('N° Cajas/Bolsas/Racimos', 'cantidad', $x8, 2);
					$Form_Inputs->form_input_number('Peso Caja', 'peso', $x9, 2);

					$Form_Inputs->form_input_hidden('idAnalisis', $_GET['edit'], 2);

					$Form_Inputs->form_tittle(3, 'Datos Tipo Planilla');
					foreach ($arrGrupo as $grupo) {
						//Cuento si hay items dentro de la categoria
						$x_con = 0;
						for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
							if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
								$x_con++;
							}
						}

						//si hay items se muestra todo
						if($x_con!=0){

							echo '<h4>'.$grupo['Nombre'].'</h4>';

							for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
								if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
									//Verifico el tipo de dato
									switch ($rowData['PuntoidTipo_'.$i]) {
										//Medicion (Decimal) con parametros limitantes
										case 1:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Medicion (Decimal) sin parametros limitantes
										case 2:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Medicion (Enteros) con parametros limitantes
										case 3:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Medicion (Enteros) sin parametros limitantes
										case 4:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Fecha
										case 5:
											$Form_Inputs->form_date($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1);
											break;
										//Hora
										case 6:
											$Form_Inputs->form_time_popover($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 24);
											break;
										//Texto Libre
										case 7:
											$Form_Inputs->form_textarea($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1);
											break;
										//Seleccion 1 a 3
										case 8:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 3);
											break;
										//Seleccion 1 a 5
										case 9:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 5);
											break;
										//Seleccion 1 a 10
										case 10:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 10);
											break;
										//Texto Libre con Validacion
										case 11:
											$Form_Inputs->form_input_validate($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, $rowData['Validacion_'.$i]);
											break;

									}
								}
							}
						}
					}
					/*************************************************************/
					$Form_Inputs->form_tittle(3, 'Decision');
					//Verifico esta activo el dato 1
					if(isset($rowData['idNota_1'])&&$rowData['idNota_1']==1){
						echo print_select($rowData['idNotaTipo_1'], 'Nota Calidad', 'Resolucion_1', '', $rowData['Validar_1']);
					}
					//Verifico esta activo el dato 2
					if(isset($rowData['idNota_2'])&&$rowData['idNota_2']==1){
						echo print_select($rowData['idNotaTipo_2'], 'Nota Condición', 'Resolucion_2', '', $rowData['Validar_2']);
					}
					//Verifico esta activo el dato 3
					if(isset($rowData['idNota_3'])&&$rowData['idNota_3']==1){
						echo print_select($rowData['idNotaTipo_3'], 'Calificacion', 'Resolucion_3', '', $rowData['Validar_3']);
					}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_muestra">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editMuestra'])){
	//Armo cadena
	$SIS_query  = 'Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3, Validar_1, Validar_2, Validar_3';
	for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
		$SIS_query .= ',Validacion_'.$i;
	}

	// consulto los datos
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idCalidad'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/***********************************************/
	// Se trae un listado con todos los grupos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = 'idGrupo!=0';
	$SIS_order = 'Nombre ASC';
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

	/***********************************************/
	//Armo cadena
	$subquery  = '';
	for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
		$subquery .= ',cross_quality_registrar_inspecciones_muestras.Medida_'.$i;
	}
	// consulto los datos
	$SIS_query = 'idMuestras,n_folio_pallet,lote,f_embalaje,f_cosecha,H_inspeccion,cantidad,peso,Resolucion_1,Resolucion_2,Resolucion_3,idProductor,idTipo'.$subquery;
	$SIS_join  = '';
	$SIS_where = 'idMuestras ='.$_GET['editMuestra'];
	$rowMuestras = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones_muestras', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowMuestras');

	/*****************************************************/
	// Se traen todos los datos del analisis
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Ingreso datos de <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idProductor)){     $x1  = $idProductor;     }else{$x1  = $rowMuestras['idProductor'];}
					if(isset($n_folio_pallet)){  $x2  = $n_folio_pallet;  }else{$x2  = $rowMuestras['n_folio_pallet'];}
					if(isset($idTipo)){          $x3  = $idTipo;          }else{$x3  = $rowMuestras['idTipo'];}
					if(isset($lote)){            $x4  = $lote;            }else{$x4  = $rowMuestras['lote'];}
					if(isset($f_embalaje)){      $x5  = $f_embalaje;      }else{$x5  = $rowMuestras['f_embalaje'];}
					if(isset($f_cosecha)){       $x6  = $f_cosecha;       }else{$x6  = $rowMuestras['f_cosecha'];}
					if(isset($H_inspeccion)){    $x7  = $H_inspeccion;    }else{$x7  = $rowMuestras['H_inspeccion'];}
					if(isset($cantidad)){        $x8  = $cantidad;        }else{$x8  = $rowMuestras['cantidad'];}
					if(isset($peso)){            $x9  = $peso;            }else{$x9  = $rowMuestras['peso'];}
					if(isset($Resolucion_1)){    $x10 = $Resolucion_1;    }else{$x10 = $rowMuestras['Resolucion_1'];}
					if(isset($Resolucion_2)){    $x11 = $Resolucion_2;    }else{$x11 = $rowMuestras['Resolucion_2'];}
					if(isset($Resolucion_3)){    $x12 = $Resolucion_3;    }else{$x12 = $rowMuestras['Resolucion_3'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_select_filter('Productor','idProductor', $x1, 2, 'idProductor', 'Codigo,Nombre', 'productores_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_text('N° Folio / Pallet', 'n_folio_pallet', $x2, 2);
					$Form_Inputs->form_select_filter('Tipo Embalaje','idTipo', $x3, 2, 'idTipo', 'Codigo,Nombre', 'sistema_cross_analisis_embalaje', $z, '', $dbConn);
					$Form_Inputs->form_input_text('Lote', 'lote', $x4, 2);
					$Form_Inputs->form_date('Fecha Embalaje','f_embalaje', $x5, 2);
					$Form_Inputs->form_date('Fecha Cosecha','f_cosecha', $x6, 2);
					$Form_Inputs->form_time_popover('Hora Inspeccion','H_inspeccion', $x7, 1, 1, 24);
					$Form_Inputs->form_input_number('N° Cajas/Bolsas/Racimos', 'cantidad', $x8, 2);
					$Form_Inputs->form_input_number('Peso Caja', 'peso', $x9, 2);

					$Form_Inputs->form_input_hidden('idMuestras', $rowMuestras['idMuestras'], 2);
					$Form_Inputs->form_input_hidden('idAnalisis', $_GET['edit'], 2);

					$Form_Inputs->form_tittle(3, 'Datos Tipo Planilla');
					foreach ($arrGrupo as $grupo) {
						//Cuento si hay items dentro de la categoria
						$x_con = 0;
						for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
							if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
								$x_con++;
							}
						}

						//si hay items se muestra todo
						if($x_con!=0){

							echo '<h4>'.$grupo['Nombre'].'</h4>';

							for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
								if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
									//Verifico el tipo de dato
									switch ($rowData['PuntoidTipo_'.$i]) {
										//Medicion (Decimal) con parametros limitantes
										case 1:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $rowMuestras['Medida_'.$i], 1);
											break;
										//Medicion (Decimal) sin parametros limitantes
										case 2:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $rowMuestras['Medida_'.$i], 1);
											break;
										//Medicion (Enteros) con parametros limitantes
										case 3:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $rowMuestras['Medida_'.$i], 1);
											break;
										//Medicion (Enteros) sin parametros limitantes
										case 4:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $rowMuestras['Medida_'.$i], 1);
											break;
										//Fecha
										case 5:
											$Form_Inputs->form_date($rowData['PuntoNombre_'.$i],'Medida_'.$i, $rowMuestras['Medida_'.$i], 1);
											break;
										//Hora
										case 6:
											$Form_Inputs->form_time_popover($rowData['PuntoNombre_'.$i],'Medida_'.$i, $rowMuestras['Medida_'.$i], 1, 1, 24);
											break;
										//Texto Libre
										case 7:
											$Form_Inputs->form_textarea($rowData['PuntoNombre_'.$i],'Medida_'.$i, $rowMuestras['Medida_'.$i], 1);
											break;
										//Seleccion 1 a 3
										case 8:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, $rowMuestras['Medida_'.$i], 1, 1, 3);
											break;
										//Seleccion 1 a 5
										case 9:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, $rowMuestras['Medida_'.$i], 1, 1, 5);
											break;
										//Seleccion 1 a 10
										case 10:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, $rowMuestras['Medida_'.$i], 1, 1, 10);
											break;
										//Texto Libre con Validacion
										case 11:
											$Form_Inputs->form_input_validate($rowData['PuntoNombre_'.$i],'Medida_'.$i, $rowMuestras['Medida_'.$i], 1, $rowData['Validacion_'.$i]);
											break;

									}
								}
							}
						}
					}
					/*************************************************************/
					$Form_Inputs->form_tittle(3, 'Decision');
					//Verifico esta activo el dato 1
					if(isset($rowData['idNota_1'])&&$rowData['idNota_1']==1){
						echo print_select($rowData['idNotaTipo_1'], 'Nota Calidad', 'Resolucion_1', $x10, $rowData['Validar_1']);
					}
					//Verifico esta activo el dato 2
					if(isset($rowData['idNota_2'])&&$rowData['idNota_2']==1){
						echo print_select($rowData['idNotaTipo_2'], 'Nota Condición', 'Resolucion_2', $x11, $rowData['Validar_2']);
					}
					//Verifico esta activo el dato 3
					if(isset($rowData['idNota_3'])&&$rowData['idNota_3']==1){
						echo print_select($rowData['idNotaTipo_3'], 'Calificacion', 'Resolucion_3', $x12, $rowData['Validar_3']);
					}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_muestra">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addMuestra'])){
	//Armo cadena
	$SIS_query  = 'Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3, Validar_1, Validar_2, Validar_3';
	for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
		$SIS_query .= ',Validacion_'.$i;
	}

	// consulto los datos
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idCalidad'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************************/
	// Se trae un listado con todos los grupos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = 'idGrupo!=0';
	$SIS_order = 'Nombre ASC';
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

	/*****************************************************/
	// Se traen todos los datos del analisis
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Ingreso datos de <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idProductor)){     $x1  = $idProductor;     }else{$x1  = '';}
					if(isset($n_folio_pallet)){  $x2  = $n_folio_pallet;  }else{$x2  = '';}
					if(isset($idTipo)){          $x3  = $idTipo;          }else{$x3  = '';}
					if(isset($lote)){            $x4  = $lote;            }else{$x4  = '';}
					if(isset($f_embalaje)){      $x5  = $f_embalaje;      }else{$x5  = '';}
					if(isset($f_cosecha)){       $x6  = $f_cosecha;       }else{$x6  = '';}
					if(isset($H_inspeccion)){    $x7  = $H_inspeccion;    }else{$x7  = '';}
					if(isset($cantidad)){        $x8  = $cantidad;        }else{$x8  = '';}
					if(isset($peso)){            $x9  = $peso;            }else{$x9  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_select_filter('Productor','idProductor', $x1, 2, 'idProductor', 'Codigo,Nombre', 'productores_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_text('N° Folio / Pallet', 'n_folio_pallet', $x2, 2);
					$Form_Inputs->form_select_filter('Tipo Embalaje','idTipo', $x3, 2, 'idTipo', 'Codigo,Nombre', 'sistema_cross_analisis_embalaje', $z, '', $dbConn);
					$Form_Inputs->form_input_text('Lote', 'lote', $x4, 2);
					$Form_Inputs->form_date('Fecha Embalaje','f_embalaje', $x5, 2);
					$Form_Inputs->form_date('Fecha Cosecha','f_cosecha', $x6, 2);
					$Form_Inputs->form_time_popover('Hora Inspeccion','H_inspeccion', $x7, 1, 1, 24);
					$Form_Inputs->form_input_number('N° Cajas/Bolsas/Racimos', 'cantidad', $x8, 2);
					$Form_Inputs->form_input_number('Peso Caja', 'peso', $x9, 2);

					$Form_Inputs->form_input_hidden('idAnalisis', $_GET['edit'], 2);

					$Form_Inputs->form_tittle(3, 'Datos Tipo Planilla');
					foreach ($arrGrupo as $grupo) {
						//Cuento si hay items dentro de la categoria
						$x_con = 0;
						for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
							if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
								$x_con++;
							}
						}

						//si hay items se muestra todo
						if($x_con!=0){

							echo '<h4>'.$grupo['Nombre'].'</h4>';

							for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
								if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
									//Verifico el tipo de dato
									switch ($rowData['PuntoidTipo_'.$i]) {
										//Medicion (Decimal) con parametros limitantes
										case 1:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Medicion (Decimal) sin parametros limitantes
										case 2:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Medicion (Enteros) con parametros limitantes
										case 3:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Medicion (Enteros) sin parametros limitantes
										case 4:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 1);
											break;
										//Fecha
										case 5:
											$Form_Inputs->form_date($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1);
											break;
										//Hora
										case 6:
											$Form_Inputs->form_time_popover($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 24);
											break;
										//Texto Libre
										case 7:
											$Form_Inputs->form_textarea($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1);
											break;
										//Seleccion 1 a 3
										case 8:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 3);
											break;
										//Seleccion 1 a 5
										case 9:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 5);
											break;
										//Seleccion 1 a 10
										case 10:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, 1, 10);
											break;
										//Texto Libre con Validacion
										case 11:
											$Form_Inputs->form_input_validate($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 1, $rowData['Validacion_'.$i]);
											break;

									}
								}
							}
						}
					}
					/*************************************************************/
					$Form_Inputs->form_tittle(3, 'Decision');
					//Verifico esta activo el dato 1
					if(isset($rowData['idNota_1'])&&$rowData['idNota_1']==1){
						echo print_select($rowData['idNotaTipo_1'], 'Nota Calidad', 'Resolucion_1', '', $rowData['Validar_1']);
					}
					//Verifico esta activo el dato 2
					if(isset($rowData['idNota_2'])&&$rowData['idNota_2']==1){
						echo print_select($rowData['idNotaTipo_2'], 'Nota Condición', 'Resolucion_2', '', $rowData['Validar_2']);
					}
					//Verifico esta activo el dato 3
					if(isset($rowData['idNota_3'])&&$rowData['idNota_3']==1){
						echo print_select($rowData['idNotaTipo_3'], 'Calificacion', 'Resolucion_3', '', $rowData['Validar_3']);
					}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_muestra">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addMaquina'])){
	// Se traen todos los datos del analisis
	$SIS_query = 'idAnalisis,Creacion_fecha,idTipo,Temporada,idCategoria,idProducto,idUbicacion,idUbicacion_lvl_1,idUbicacion_lvl_2,idUbicacion_lvl_3,idUbicacion_lvl_4,idUbicacion_lvl_5,idSistema';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Maquina</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idMaquina)){        $x1  = $idMaquina;        }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Maquina','idMaquina', $x1, 2, 'idMaquina', 'Codigo,Nombre', 'maquinas_listado', $z, '', $dbConn);

					$Form_Inputs->form_input_hidden('idAnalisis', $rowData['idAnalisis'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', $rowData['Creacion_fecha'], 2);
					$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
					$Form_Inputs->form_input_hidden('Temporada', $rowData['Temporada'], 2);
					$Form_Inputs->form_input_hidden('idCategoria', $rowData['idCategoria'], 2);
					$Form_Inputs->form_input_hidden('idProducto', $rowData['idProducto'], 2);
					$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
					if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
					if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
					if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
					if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
					if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_maq">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addTrab'])){
	// Se traen todos los datos del analisis
	$SIS_query = 'idAnalisis,Creacion_fecha,idTipo,Temporada,idCategoria,idProducto,idUbicacion,idUbicacion_lvl_1,idUbicacion_lvl_2,idUbicacion_lvl_3,idUbicacion_lvl_4,idUbicacion_lvl_5,idSistema';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************************/
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

					$Form_Inputs->form_input_hidden('idAnalisis', $rowData['idAnalisis'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', $rowData['Creacion_fecha'], 2);
					$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
					$Form_Inputs->form_input_hidden('Temporada', $rowData['Temporada'], 2);
					$Form_Inputs->form_input_hidden('idCategoria', $rowData['idCategoria'], 2);
					$Form_Inputs->form_input_hidden('idProducto', $rowData['idProducto'], 2);
					$Form_Inputs->form_input_hidden('idUbicacion', $rowData['idUbicacion'], 2);
					if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_1', $rowData['idUbicacion_lvl_1'], 2);}
					if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_2', $rowData['idUbicacion_lvl_2'], 2);}
					if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_3', $rowData['idUbicacion_lvl_3'], 2);}
					if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_4', $rowData['idUbicacion_lvl_4'], 2);}
					if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=0){$Form_Inputs->form_input_hidden('idUbicacion_lvl_5', $rowData['idUbicacion_lvl_5'], 2);}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_trab">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
	// Se traen todos los datos del analisis
	$SIS_query = 'Creacion_fecha,idTipo,Temporada,idCategoria,idProducto,idUbicacion,idUbicacion_lvl_1,idUbicacion_lvl_2,idUbicacion_lvl_3,idUbicacion_lvl_4,idUbicacion_lvl_5,Observaciones,idSistema';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/************************************/
	//Se revisan los permisos a las especies
	$SIS_query = 'idCategoria';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos1 = array();
	$arrPermisos1 = db_select_array (false, $SIS_query, 'core_sistemas_variedades_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos1');

	/************************************/
	//Se revisan los permisos a las variantes
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos2 = array();
	$arrPermisos2 = db_select_array (false, $SIS_query, 'core_sistemas_variedades_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos2');

	/*************************************************************/
	//filtro
	$zx1 = "idCategoria=0";
	$zx2 = "idProducto=0";
	foreach ($arrPermisos1 as $prod) {
		$zx1 .= " OR (idCategoria=".$prod['idCategoria'].")";
	}
	foreach ($arrPermisos2 as $prod) {
		$zx2 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	//verifico que sea un administrador
	$z = "idEstado=1 AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar Inspeccion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Creacion_fecha)){      $x1  = $Creacion_fecha;    }else{$x1  = $rowData['Creacion_fecha'];}
					if(isset($idTipo)){              $x2  = $idTipo;            }else{$x2  = $rowData['idTipo'];}
					if(isset($Temporada)){           $x3  = $Temporada;         }else{$x3  = $rowData['Temporada'];}
					if(isset($idCategoria)){         $x4  = $idCategoria;       }else{$x4  = $rowData['idCategoria'];}
					if(isset($idProducto)){          $x5  = $idProducto;        }else{$x5  = $rowData['idProducto'];}
					if(isset($idUbicacion)){         $x6  = $idUbicacion;       }else{$x6  = $rowData['idUbicacion'];}

					if(isset($rowData['idUbicacion_lvl_1'])&&$rowData['idUbicacion_lvl_1']!=''){if(isset($idUbicacion_lvl_1)){   $x7  = $idUbicacion_lvl_1; }else{$x7  = $rowData['idUbicacion_lvl_1'];}}
					if(isset($rowData['idUbicacion_lvl_2'])&&$rowData['idUbicacion_lvl_2']!=''){if(isset($idUbicacion_lvl_2)){   $x8  = $idUbicacion_lvl_2; }else{$x8  = $rowData['idUbicacion_lvl_2'];}}
					if(isset($rowData['idUbicacion_lvl_3'])&&$rowData['idUbicacion_lvl_3']!=''){if(isset($idUbicacion_lvl_3)){   $x9  = $idUbicacion_lvl_3; }else{$x9  = $rowData['idUbicacion_lvl_3'];}}
					if(isset($rowData['idUbicacion_lvl_4'])&&$rowData['idUbicacion_lvl_4']!=''){if(isset($idUbicacion_lvl_4)){   $x10 = $idUbicacion_lvl_4; }else{$x10 = $rowData['idUbicacion_lvl_4'];}}
					if(isset($rowData['idUbicacion_lvl_5'])&&$rowData['idUbicacion_lvl_5']!=''){if(isset($idUbicacion_lvl_5)){   $x11 = $idUbicacion_lvl_5; }else{$x11 = $rowData['idUbicacion_lvl_5'];}}
					if(isset($Observaciones)){       $x12 = $Observaciones;     }else{$x12 = $rowData['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha Ingreso','Creacion_fecha', $x1, 2);
					$Form_Inputs->form_select('Tipo Planilla','idTipo', $x2, 2, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);
					$Form_Inputs->form_select_temporada_2('Temporada','Temporada', $x3, 2, ano_actual());
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x4, 2, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', $zx1, 0,
											'Variedad','idProducto', $x5, 2, 'idProducto', 'Nombre', 'variedades_listado', $zx2, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select_depend5('Ubicación', 'idUbicacion',  $x6,  2,  'idUbicacion',  'Nombre',  'ubicacion_listado',  $z,   0,
												'Nivel 1', 'idUbicacion_lvl_1',  $x7,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0,
												'Nivel 2', 'idUbicacion_lvl_2',  $x8,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												'Nivel 3', 'idUbicacion_lvl_3',  $x9,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												'Nivel 4', 'idUbicacion_lvl_4',  $x10,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												'Nivel 5', 'idUbicacion_lvl_5',  $x11,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												$dbConn, 'form1');

					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x12, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idAnalisis', $_GET['edit'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit'])){
	// Se traen todos los datos del analisis
	$SIS_query = '
	cross_quality_registrar_inspecciones.fecha_auto,
	cross_quality_registrar_inspecciones.Creacion_fecha,
	cross_quality_registrar_inspecciones.Temporada,
	cross_quality_registrar_inspecciones.Observaciones,

	core_sistemas.Nombre AS Sistema,
	usuarios_listado.Nombre AS Usuario,
	core_cross_quality_analisis_calidad.Nombre AS TipoAnalisis,
	sistema_variedades_categorias.Nombre AS ProductoCategoria,
	variedades_listado.Nombre AS ProductoNombre,

	cross_quality_registrar_inspecciones.idCategoria,
	cross_quality_registrar_inspecciones.idTipo,
	cross_quality_registrar_inspecciones.idSistema,
	(SELECT
	cross_quality_calidad_matriz.cantPuntos
	FROM `sistema_variedades_categorias_matriz_calidad`
	LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz
	WHERE sistema_variedades_categorias_matriz_calidad.idCategoria = cross_quality_registrar_inspecciones.idCategoria
	AND sistema_variedades_categorias_matriz_calidad.idProceso = cross_quality_registrar_inspecciones.idTipo
	AND sistema_variedades_categorias_matriz_calidad.idSistema = cross_quality_registrar_inspecciones.idSistema
	) AS Producto_cantPuntos,

	(SELECT
	sistema_variedades_categorias_matriz_calidad.idMatriz
	FROM `sistema_variedades_categorias_matriz_calidad`
	LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz
	WHERE sistema_variedades_categorias_matriz_calidad.idCategoria = cross_quality_registrar_inspecciones.idCategoria
	AND sistema_variedades_categorias_matriz_calidad.idProceso = cross_quality_registrar_inspecciones.idTipo
	AND sistema_variedades_categorias_matriz_calidad.idSistema = cross_quality_registrar_inspecciones.idSistema
	) AS Producto_idCalidad,

	ubicacion_listado.Nombre AS UbicacionNombre,
	ubicacion_listado_level_1.Nombre AS UbicacionNombre_lvl_1,
	ubicacion_listado_level_2.Nombre AS UbicacionNombre_lvl_2,
	ubicacion_listado_level_3.Nombre AS UbicacionNombre_lvl_3,
	ubicacion_listado_level_4.Nombre AS UbicacionNombre_lvl_4,
	ubicacion_listado_level_5.Nombre AS UbicacionNombre_lvl_5';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                          ON core_sistemas.idSistema                      = cross_quality_registrar_inspecciones.idSistema
	LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                   = cross_quality_registrar_inspecciones.idUsuario
	LEFT JOIN `core_cross_quality_analisis_calidad`    ON core_cross_quality_analisis_calidad.idTipo   = cross_quality_registrar_inspecciones.idTipo
	LEFT JOIN `sistema_variedades_categorias`          ON sistema_variedades_categorias.idCategoria    = cross_quality_registrar_inspecciones.idCategoria
	LEFT JOIN `variedades_listado`                     ON variedades_listado.idProducto                = cross_quality_registrar_inspecciones.idProducto
	LEFT JOIN `ubicacion_listado`                      ON ubicacion_listado.idUbicacion                = cross_quality_registrar_inspecciones.idUbicacion
	LEFT JOIN `ubicacion_listado_level_1`              ON ubicacion_listado_level_1.idLevel_1          = cross_quality_registrar_inspecciones.idUbicacion_lvl_1
	LEFT JOIN `ubicacion_listado_level_2`              ON ubicacion_listado_level_2.idLevel_2          = cross_quality_registrar_inspecciones.idUbicacion_lvl_2
	LEFT JOIN `ubicacion_listado_level_3`              ON ubicacion_listado_level_3.idLevel_3          = cross_quality_registrar_inspecciones.idUbicacion_lvl_3
	LEFT JOIN `ubicacion_listado_level_4`              ON ubicacion_listado_level_4.idLevel_4          = cross_quality_registrar_inspecciones.idUbicacion_lvl_4
	LEFT JOIN `ubicacion_listado_level_5`              ON ubicacion_listado_level_5.idLevel_5          = cross_quality_registrar_inspecciones.idUbicacion_lvl_5';
	$SIS_where = 'cross_quality_registrar_inspecciones.idAnalisis ='.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_registrar_inspecciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/***************************************************/
	// Se trae un listado con todos los trabajadores
	$SIS_query = '
	cross_quality_registrar_inspecciones_trabajador.idTrabajadores,
	trabajadores_listado.Nombre,
	trabajadores_listado.ApellidoPat,
	trabajadores_listado.ApellidoMat,
	trabajadores_listado.Cargo,
	trabajadores_listado.Rut';
	$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = cross_quality_registrar_inspecciones_trabajador.idTrabajador';
	$SIS_where = 'cross_quality_registrar_inspecciones_trabajador.idAnalisis ='.$_GET['edit'];
	$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
	$arrTrabajadores = array();
	$arrTrabajadores = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_trabajador', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTrabajadores');

	/***************************************************/
	// Se trae un listado con todas las maquinas
	$SIS_query = '
	cross_quality_registrar_inspecciones_maquina.idMaquinas,
	maquinas_listado.Nombre,
	maquinas_listado.Codigo';
	$SIS_join  = 'LEFT JOIN `maquinas_listado` ON maquinas_listado.idMaquina = cross_quality_registrar_inspecciones_maquina.idMaquina';
	$SIS_where = 'cross_quality_registrar_inspecciones_maquina.idAnalisis ='.$_GET['edit'];
	$SIS_order = 'maquinas_listado.Nombre ASC';
	$arrMaquinas = array();
	$arrMaquinas = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_maquina', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMaquinas');

	/***************************************************/
	// Se trae un listado con todas las muestras
	$SIS_query = '
	cross_quality_registrar_inspecciones_muestras.idMuestras,
	cross_quality_registrar_inspecciones_muestras.n_folio_pallet,
	cross_quality_registrar_inspecciones_muestras.lote,
	productores_listado.Nombre AS ProductorNombre';
	$SIS_join  = 'LEFT JOIN `productores_listado` ON productores_listado.idProductor = cross_quality_registrar_inspecciones_muestras.idProductor';
	$SIS_where = 'cross_quality_registrar_inspecciones_muestras.idAnalisis ='.$_GET['edit'];
	$SIS_order = 'productores_listado.Nombre ASC';
	$arrMuestras = array();
	$arrMuestras = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_muestras', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMuestras');

	/***************************************************/
	// Se trae un listado con todos los archivos
	$SIS_query = 'idArchivo, Nombre';
	$SIS_join  = '';
	$SIS_where = 'idAnalisis ='.$_GET['edit'];
	$SIS_order = 'Nombre ASC';
	$arrArchivos = array();
	$arrArchivos = db_select_array (false, $SIS_query, 'cross_quality_registrar_inspecciones_archivo', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArchivos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<div id="page-wrap">
			<div id="header"> <?php echo $rowData['TipoAnalisis']?></div>

			<div id="customer">

				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"><a href="<?php echo $new_location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>
						<tr>
							<td class="meta-head">Producto</td>
							<td><?php echo $rowData['ProductoCategoria'].', '.$rowData['ProductoNombre']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Ubicación</td>
							<td>
								<?php echo $rowData['UbicacionNombre'];
								if(isset($rowData['UbicacionNombre_lvl_1'])&&$rowData['UbicacionNombre_lvl_1']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_1'];}
								if(isset($rowData['UbicacionNombre_lvl_2'])&&$rowData['UbicacionNombre_lvl_2']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_2'];}
								if(isset($rowData['UbicacionNombre_lvl_3'])&&$rowData['UbicacionNombre_lvl_3']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_3'];}
								if(isset($rowData['UbicacionNombre_lvl_4'])&&$rowData['UbicacionNombre_lvl_4']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_4'];}
								if(isset($rowData['UbicacionNombre_lvl_5'])&&$rowData['UbicacionNombre_lvl_5']!=''){echo ' - '.$rowData['UbicacionNombre_lvl_5'];}
								?>
							</td>
						</tr>
					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>
						<tr>
							<td class="meta-head">Fecha Ingreso</td>
							<td colspan="2"><?php echo Fecha_estandar($rowData['Creacion_fecha']) ?></td>
						</tr>
						<tr>
							<td class="meta-head">Temporada</td>
							<td colspan="2"><?php echo $rowData['Temporada'] ?></td>
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

					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="5">Trabajadores Encargados</td>
						<td>
							<a href="<?php echo $new_location.'&addTrab=true' ?>" title="Agregar Trabajadores" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Trabajadores</a>
						</td>
					</tr>
					<?php if ($arrTrabajadores!=false && !empty($arrTrabajadores) && $arrTrabajadores!='') {
						foreach ($arrTrabajadores as $trab) { ?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $trab['Rut']; ?></td>
								<td class="item-name" colspan="3"><?php echo $trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat']; ?></td>
								<td class="item-name"><?php echo $trab['Cargo']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php
										$ubicacion = $new_location.'&del_trab='.simpleEncode($trab['idTrabajadores'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar al trabajador '.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Trabajador" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
									</div>
								</td>
							</tr>
					<?php }
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="6">No hay trabajadores asignados</td></tr>';
					} ?>
					<tr id="hiderow"><td colspan="6"></td></tr>
					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="5">Maquinas a Utilizar</td>
						<td>
							<a href="<?php echo $new_location.'&addMaquina=true' ?>" title="Agregar Maquina" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Maquina</a>
						</td>
					</tr>
					<?php
					if ($arrMaquinas!=false && !empty($arrMaquinas) && $arrMaquinas!='') {
						foreach ($arrMaquinas as $maq) { ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="5"><?php echo $maq['Codigo'].' - '.$maq['Nombre']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php
										$ubicacion = $new_location.'&del_maq='.simpleEncode($maq['idMaquinas'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar a Maquina '.$maq['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Trabajador" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
									</div>
								</td>
							</tr>
						<?php }
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="6">No hay maquinas asignadas</td></tr>';
					} ?>
					<tr id="hiderow"><td colspan="6"></td></tr>
					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="5">Muestras</td>
						<td>
							<a href="<?php echo $new_location.'&addMuestra=true&cantPuntos='.$rowData['Producto_cantPuntos'].'&idCalidad='.$rowData['Producto_idCalidad']; ?>" title="Agregar Muestra" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Muestra</a>
						</td>
					</tr>
					<tr class="item-row fact_tittle">
						<td colspan="2">Productor</td>
						<td colspan="2">N° Folio / Pallet</td>
						<td>Lote</td>
						<td></td>
					</tr>
					<?php
					if ($arrMuestras!=false && !empty($arrMuestras) && $arrMuestras!='') {
						//recorro el lsiatdo entregado por la base de datos
						foreach ($arrMuestras as $muestra) { ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2"><?php echo $muestra['ProductorNombre']; ?></td>
								<td class="item-name" colspan="2"><?php echo $muestra['n_folio_pallet']; ?></td>
								<td class="item-name"><?php echo $muestra['lote']; ?></td>
								<td>
									<div class="btn-group" style="width: 105px;" >
										<a href="<?php echo $new_location.'&cloneMuestra='.$muestra['idMuestras'].'&cantPuntos='.$rowData['Producto_cantPuntos'].'&idCalidad='.$rowData['Producto_idCalidad']; ?>" title="Clonar Registro" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a>
										<a href="<?php echo $new_location.'&editMuestra='.$muestra['idMuestras'].'&cantPuntos='.$rowData['Producto_cantPuntos'].'&idCalidad='.$rowData['Producto_idCalidad']; ?>" title="Editar Registro" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php
										$ubicacion = $new_location.'&del_muestra='.simpleEncode($muestra['idMuestras'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el registro ?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Registro" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
					<?php }
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="6">No hay muestras asignadas</td></tr>';
					}
					echo '<tr id="hiderow"><td colspan="6"><a name="Ancla_obs"></a></td></tr>';
					?>

					<tr>
						<td colspan="6" class="blank word_break">
							<?php echo $rowData['Observaciones']; ?>
						</td>
					</tr>
					<tr><td colspan="6" class="blank"><p>Observaciones</p></td></tr>

				</tbody>
			</table>
		</div>

		<table id="items" style="margin-bottom: 20px;">
			<tbody>

				<tr class="invoice-total" bgcolor="#f1f1f1">
					<td colspan="5">Archivos Adjuntos</td>
					<td width="160"><a href="<?php echo $new_location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
				</tr>

				<?php
				if ($arrArchivos!=false && !empty($arrArchivos) && $arrArchivos!=''){
					//recorro el lsiatdo entregado por la base de datos
					$numeral = 1;
					foreach ($arrArchivos as $producto){ ?>
						<tr class="item-row">
							<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $new_location.'&del_file='.simpleEncode($producto['idArchivo'], fecha_actual());
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

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location.'?pagina=1' ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
