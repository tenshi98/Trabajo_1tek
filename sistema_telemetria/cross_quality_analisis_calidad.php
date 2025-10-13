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
$original = "cross_quality_analisis_calidad.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){         $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];          $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                         $location .= "&idTipo=".$_GET['idTipo'];                          $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Temporada']) && $_GET['Temporada']!=''){                   $location .= "&Temporada=".$_GET['Temporada'];                    $search .= "&Temporada=".$_GET['Temporada'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){               $location .= "&idCategoria=".$_GET['idCategoria'];                $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){                 $location .= "&idProducto=".$_GET['idProducto'];                  $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){               $location .= "&idUbicacion=".$_GET['idUbicacion'];                $search .= "&idUbicacion=".$_GET['idUbicacion'];}
if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){   $location .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];    $search .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];}
if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){   $location .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];    $search .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];}
if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){   $location .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];    $search .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];}
if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){   $location .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];    $search .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];}
if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){   $location .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];    $search .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];}
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
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
//formulario para editar
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_trab'])){
	//Llamamos al formulario
	$form_trabajo= 'addTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
//se borra un trabajo
if (!empty($_GET['del_trab'])){
	//Llamamos al formulario
	$form_trabajo= 'del_trab';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_maq'])){
	//Llamamos al formulario
	$form_trabajo= 'addMaq';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
//se borra un trabajo
if (!empty($_GET['del_maq'])){
	//Llamamos al formulario
	$form_trabajo= 'del_maq';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_muestra'])){
	//Llamamos al formulario
	$form_trabajo= 'new_muestra';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_muestra'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_muestra';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
//se borra un dato
if (!empty($_GET['del_muestra'])){
	//Llamamos al formulario
	$form_trabajo= 'del_muestra';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
}
/**********************************************/
//se hace el ingreso a bodega
if (!empty($_GET['ing_Doc'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_Doc';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_analisis_calidad.php';
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
}elseif(!empty($_GET['cloneMuestra'])){
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3';
	for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
	}
	$SIS_join  = '';
	$SIS_where = 'idMatriz = '.$_GET['idCalidad'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 0;
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

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
					if(isset($idProductor)){     $x1  = $idProductor;     }else{$x1  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['idProductor'];}
					if(isset($n_folio_pallet)){  $x2  = $n_folio_pallet;  }else{$x2  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['n_folio_pallet'];}
					if(isset($idTipo)){          $x3  = $idTipo;          }else{$x3  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['idTipo'];}
					if(isset($lote)){            $x4  = $lote;            }else{$x4  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['lote'];}
					if(isset($f_embalaje)){      $x5  = $f_embalaje;      }else{$x5  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['f_embalaje'];}
					if(isset($f_cosecha)){       $x6  = $f_cosecha;       }else{$x6  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['f_cosecha'];}
					if(isset($H_inspeccion)){    $x7  = $H_inspeccion;    }else{$x7  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['H_inspeccion'];}
					if(isset($cantidad)){        $x8  = $cantidad;        }else{$x8  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['cantidad'];}
					if(isset($peso)){            $x9  = $peso;            }else{$x9  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['cloneMuestra']]['peso'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_select_filter('Productor','idProductor', $x1, 2, 'idProductor', 'Codigo,Nombre', 'productores_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_number('N° Folio / Pallet', 'n_folio_pallet', $x2, 2);
					$Form_Inputs->form_select('Tipo Embalaje','idTipo', $x3, 2, 'idTipo', 'Nombre', 'sistema_cross_analisis_embalaje', $z, '', $dbConn);
					$Form_Inputs->form_input_number('Lote', 'lote', $x4, 2);
					$Form_Inputs->form_date('Fecha Embalaje','f_embalaje', $x5, 2);
					$Form_Inputs->form_date('Fecha Cosecha','f_cosecha', $x6, 2);
					$Form_Inputs->form_time_popover('Hora Inspeccion','H_inspeccion', $x7, 1, 1, 24);
					$Form_Inputs->form_input_number('N° Cajas/Bolsas/Racimos', 'cantidad', $x8, 2);
					$Form_Inputs->form_input_number('Peso Caja', 'peso', $x9, 2);

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
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Medicion (Decimal) sin parametros limitantes
										case 2:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Medicion (Enteros) con parametros limitantes
										case 3:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Medicion (Enteros) sin parametros limitantes
										case 4:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Fecha
										case 5:
											$Form_Inputs->form_date($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 2);
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

									}
								}
							}
						}
					}
					/*************************************************************/
					$Form_Inputs->form_tittle(3, 'Decision');
					//Verifico esta activo el dato 1
					if(isset($rowData['idNota_1'])&&$rowData['idNota_1']==1){
						echo print_select($rowData['idNotaTipo_1'], 'Nota Calidad', 'Resolucion_1', '');
					}
					//Verifico esta activo el dato 2
					if(isset($rowData['idNota_2'])&&$rowData['idNota_2']==1){
						echo print_select($rowData['idNotaTipo_2'], 'Nota Condición', 'Resolucion_2', '');
					}
					//Verifico esta activo el dato 3
					if(isset($rowData['idNota_3'])&&$rowData['idNota_3']==1){
						echo print_select($rowData['idNotaTipo_3'], 'Calificacion', 'Resolucion_3', '');
					}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_muestra">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editMuestra'])){
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3';
	for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
	}
	$SIS_join  = '';
	$SIS_where = 'idMatriz = '.$_GET['idCalidad'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 0;
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

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
					if(isset($idProductor)){     $x1  = $idProductor;     }else{$x1  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['idProductor'];}
					if(isset($n_folio_pallet)){  $x2  = $n_folio_pallet;  }else{$x2  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['n_folio_pallet'];}
					if(isset($idTipo)){          $x3  = $idTipo;          }else{$x3  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['idTipo'];}
					if(isset($lote)){            $x4  = $lote;            }else{$x4  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['lote'];}
					if(isset($f_embalaje)){      $x5  = $f_embalaje;      }else{$x5  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['f_embalaje'];}
					if(isset($f_cosecha)){       $x6  = $f_cosecha;       }else{$x6  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['f_cosecha'];}
					if(isset($H_inspeccion)){    $x7  = $H_inspeccion;    }else{$x7  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['H_inspeccion'];}
					if(isset($cantidad)){        $x8  = $cantidad;        }else{$x8  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['cantidad'];}
					if(isset($peso)){            $x9  = $peso;            }else{$x9  = $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['peso'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_select_filter('Productor','idProductor', $x1, 2, 'idProductor', 'Codigo,Nombre', 'productores_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_number('N° Folio / Pallet', 'n_folio_pallet', $x2, 2);
					$Form_Inputs->form_select('Tipo Embalaje','idTipo', $x3, 2, 'idTipo', 'Nombre', 'sistema_cross_analisis_embalaje', $z, '', $dbConn);
					$Form_Inputs->form_input_number('Lote', 'lote', $x4, 2);
					$Form_Inputs->form_date('Fecha Embalaje','f_embalaje', $x5, 2);
					$Form_Inputs->form_date('Fecha Cosecha','f_cosecha', $x6, 2);
					$Form_Inputs->form_time_popover('Hora Inspeccion','H_inspeccion', $x7, 1, 1, 24);
					$Form_Inputs->form_input_number('N° Cajas/Bolsas/Racimos', 'cantidad', $x8, 2);
					$Form_Inputs->form_input_number('Peso Caja', 'peso', $x9, 2);

					$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['idMuestra'], 2);

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
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 2);
											break;
										//Medicion (Decimal) sin parametros limitantes
										case 2:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 2);
											break;
										//Medicion (Enteros) con parametros limitantes
										case 3:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 2);
											break;
										//Medicion (Enteros) sin parametros limitantes
										case 4:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 2);
											break;
										//Fecha
										case 5:
											$Form_Inputs->form_date($rowData['PuntoNombre_'.$i],'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 2);
											break;
										//Hora
										case 6:
											$Form_Inputs->form_time_popover($rowData['PuntoNombre_'.$i],'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 1, 1, 24);
											break;
										//Texto Libre
										case 7:
											$Form_Inputs->form_textarea($rowData['PuntoNombre_'.$i],'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 1);
											break;
										//Seleccion 1 a 3
										case 8:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 1, 1, 3);
											break;
										//Seleccion 1 a 5
										case 9:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 1, 1, 5);
											break;
										//Seleccion 1 a 10
										case 10:
											$Form_Inputs->form_select_n_auto($rowData['PuntoNombre_'.$i],'Medida_'.$i, $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Medida_'.$i], 1, 1, 10);
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
						echo print_select($rowData['idNotaTipo_1'], 'Nota Calidad', 'Resolucion_1', $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Resolucion_1']);
					}
					//Verifico esta activo el dato 2
					if(isset($rowData['idNota_2'])&&$rowData['idNota_2']==1){
						echo print_select($rowData['idNotaTipo_2'], 'Nota Condición', 'Resolucion_2', $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Resolucion_2']);
					}
					//Verifico esta activo el dato 3
					if(isset($rowData['idNota_3'])&&$rowData['idNota_3']==1){
						echo print_select($rowData['idNotaTipo_3'], 'Calificacion', 'Resolucion_3', $_SESSION['cross_quality_ana_cali_muestras'][$_GET['editMuestra']]['Resolucion_3']);
					}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_muestra">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addMuestra'])){
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3';
	for ($i = 1; $i <= $_GET['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
	}
	$SIS_join  = '';
	$SIS_where = 'idMatriz = '.$_GET['idCalidad'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 0;
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

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
					$Form_Inputs->form_input_number('N° Folio / Pallet', 'n_folio_pallet', $x2, 2);
					$Form_Inputs->form_select('Tipo Embalaje','idTipo', $x3, 2, 'idTipo', 'Nombre', 'sistema_cross_analisis_embalaje', $z, '', $dbConn);
					$Form_Inputs->form_input_number('Lote', 'lote', $x4, 2);
					$Form_Inputs->form_date('Fecha Embalaje','f_embalaje', $x5, 2);
					$Form_Inputs->form_date('Fecha Cosecha','f_cosecha', $x6, 2);
					$Form_Inputs->form_time_popover('Hora Inspeccion','H_inspeccion', $x7, 1, 1, 24);
					$Form_Inputs->form_input_number('N° Cajas/Bolsas/Racimos', 'cantidad', $x8, 2);
					$Form_Inputs->form_input_number('Peso Caja', 'peso', $x9, 2);

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
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Medicion (Decimal) sin parametros limitantes
										case 2:
											$Form_Inputs->form_input_number($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Medicion (Enteros) con parametros limitantes
										case 3:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Medicion (Enteros) sin parametros limitantes
										case 4:
											$Form_Inputs->form_input_number_integer($rowData['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Fecha
										case 5:
											$Form_Inputs->form_date($rowData['PuntoNombre_'.$i],'Medida_'.$i, '', 2);
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

									}
								}
							}
						}
					}
					/*************************************************************/
					$Form_Inputs->form_tittle(3, 'Decision');
					//Verifico esta activo el dato 1
					if(isset($rowData['idNota_1'])&&$rowData['idNota_1']==1){
						echo print_select($rowData['idNotaTipo_1'], 'Nota Calidad', 'Resolucion_1', '');
					}
					//Verifico esta activo el dato 2
					if(isset($rowData['idNota_2'])&&$rowData['idNota_2']==1){
						echo print_select($rowData['idNotaTipo_2'], 'Nota Condición', 'Resolucion_2', '');
					}
					//Verifico esta activo el dato 3
					if(isset($rowData['idNota_3'])&&$rowData['idNota_3']==1){
						echo print_select($rowData['idNotaTipo_3'], 'Calificacion', 'Resolucion_3', '');
					}

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_muestra">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addMaquina'])){
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
					$Form_Inputs->form_select_filter('Maquina','idMaquina', $x1, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $z, '', $dbConn);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_maq">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addTrab'])){
	//Verifico el tipo de usuario que esta ingresando
	$z="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

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

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_trab">
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
				<h5>Modificar Inspeccion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Creacion_fecha)){      $x1  = $Creacion_fecha;    }else{$x1  = $_SESSION['cross_quality_ana_cali_basicos']['Creacion_fecha'];}
					if(isset($idTipo)){              $x2  = $idTipo;            }else{$x2  = $_SESSION['cross_quality_ana_cali_basicos']['idTipo'];}
					if(isset($Temporada)){           $x3  = $Temporada;         }else{$x3  = $_SESSION['cross_quality_ana_cali_basicos']['Temporada'];}
					if(isset($idCategoria)){         $x4  = $idCategoria;       }else{$x4  = $_SESSION['cross_quality_ana_cali_basicos']['idCategoria'];}
					if(isset($idProducto)){          $x5  = $idProducto;        }else{$x5  = $_SESSION['cross_quality_ana_cali_basicos']['idProducto'];}
					if(isset($idUbicacion)){         $x6  = $idUbicacion;       }else{$x6  = $_SESSION['cross_quality_ana_cali_basicos']['idUbicacion'];}

					if(isset($_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_1'])&&$_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_1']!=''){if(isset($idUbicacion_lvl_1)){   $x7  = $idUbicacion_lvl_1; }else{$x7  = $_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_1'];}}else{$x7  = '';}
					if(isset($_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_2'])&&$_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_2']!=''){if(isset($idUbicacion_lvl_2)){   $x8  = $idUbicacion_lvl_2; }else{$x8  = $_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_2'];}}else{$x8  = '';}
					if(isset($_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_3'])&&$_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_3']!=''){if(isset($idUbicacion_lvl_3)){   $x9  = $idUbicacion_lvl_3; }else{$x9  = $_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_3'];}}else{$x9  = '';}
					if(isset($_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_4'])&&$_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_4']!=''){if(isset($idUbicacion_lvl_4)){   $x10 = $idUbicacion_lvl_4; }else{$x10 = $_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_4'];}}else{$x10 = '';}
					if(isset($_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_5'])&&$_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_5']!=''){if(isset($idUbicacion_lvl_5)){   $x11 = $idUbicacion_lvl_5; }else{$x11 = $_SESSION['cross_quality_ana_cali_basicos']['idUbicacion_lvl_5'];}}else{$x11 = '';}

					if(isset($Observaciones)){         $x12  = $Observaciones;       }else{$x12  = $_SESSION['cross_quality_ana_cali_basicos']['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha Ingreso','Creacion_fecha', $x1, 2);
					$Form_Inputs->form_select('Tipo Planilla','idTipo', $x2, 2, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);
					$Form_Inputs->form_select_temporada_2('Temporada','Temporada', $x3, 2, ano_actual());
					$Form_Inputs->form_select_depend1('Categoria','idCategoria', $x4, 2, 'idCategoria', 'Nombre', 'sistema_productos_categorias', 0, 0,
											'Producto','idProducto', $x5, 2, 'idProducto', 'Nombre', 'productos_listado', 'idEstado=1 AND idCalidad!=0', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select_depend5('Ubicación', 'idUbicacion',  $x6,  2,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1',   0,
												'Nivel 1', 'idUbicacion_lvl_1',  $x7,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0,
												'Nivel 2', 'idUbicacion_lvl_2',  $x8,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												'Nivel 3', 'idUbicacion_lvl_3',  $x9,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												'Nivel 4', 'idUbicacion_lvl_4',  $x10,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												'Nivel 5', 'idUbicacion_lvl_5',  $x11,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												$dbConn, 'form1');
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x12, 1);

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
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

			<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

			<?php
			$ubicacion = $location.'&view=true&ing_Doc=true';
			$dialogo   = '¿Realmente desea ingresar el documento, una vez realizada no podra realizar cambios?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

		</div>
		<div class="clearfix"></div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<div id="page-wrap">
			<div id="header"> <?php echo $_SESSION['cross_quality_ana_cali_basicos']['Tipo']; ?></div>

			<div id="customer">

				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>
						<tr>
							<td class="meta-head">Producto</td>
							<td><?php echo $_SESSION['cross_quality_ana_cali_basicos']['Categoria'].' '.$_SESSION['cross_quality_ana_cali_basicos']['ProductoNombre']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Ubicación</td>
							<td>
								<?php echo $_SESSION['cross_quality_ana_cali_basicos']['Ubicacion'];
								if(isset($_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_1'])&&$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_1']!=''){echo ' - '.$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_1'];}
								if(isset($_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_2'])&&$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_2']!=''){echo ' - '.$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_2'];}
								if(isset($_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_3'])&&$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_3']!=''){echo ' - '.$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_3'];}
								if(isset($_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_4'])&&$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_4']!=''){echo ' - '.$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_4'];}
								if(isset($_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_5'])&&$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_5']!=''){echo ' - '.$_SESSION['cross_quality_ana_cali_basicos']['UbicacionLVL_5'];}
								?>
							</td>
						</tr>
					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>
						<tr>
							<td class="meta-head">Fecha Ingreso</td>
							<td colspan="2"><?php echo Fecha_estandar($_SESSION['cross_quality_ana_cali_basicos']['Creacion_fecha']) ?></td>
						</tr>
						<tr>
							<td class="meta-head">Temporada</td>
							<td colspan="2"><?php echo $_SESSION['cross_quality_ana_cali_basicos']['Temporada'] ?></td>
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
							<a href="<?php echo $location.'&addTrab=true' ?>" title="Agregar Trabajadores" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Trabajadores</a>
						</td>
					</tr>
					<?php
					//recorro el lsiatdo entregado por la base de datos
					if(isset($_SESSION['cross_quality_ana_cali_trabajadores'])&&$_SESSION['cross_quality_ana_cali_trabajadores']!=''){
						foreach ($_SESSION['cross_quality_ana_cali_trabajadores'] as $key => $trabajador){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $trabajador['Rut']; ?></td>
								<td class="item-name" colspan="3"><?php echo $trabajador['Nombre']; ?></td>
								<td class="item-name"><?php echo $trabajador['Cargo']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php
										$ubicacion = $location.'&del_trab='.$trabajador['idTrabajador'];
										$dialogo   = '¿Realmente deseas eliminar al trabajador '.$trabajador['Nombre'].'?'; ?>
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
							<a href="<?php echo $location.'&addMaquina=true' ?>" title="Agregar Maquina" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Maquina</a>
						</td>
					</tr>
					<?php
					//recorro el lsiatdo entregado por la base de datos
					if(isset($_SESSION['cross_quality_ana_cali_maquinas'])&&$_SESSION['cross_quality_ana_cali_maquinas']!=''){
						foreach ($_SESSION['cross_quality_ana_cali_maquinas'] as $key => $maquina){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="5"><?php echo $maquina['Nombre']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php
										$ubicacion = $location.'&del_maq='.$maquina['idMaquina'];
										$dialogo   = '¿Realmente deseas eliminar a Maquina '.$maquina['Nombre'].'?'; ?>
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
							<a href="<?php echo $location.'&addMuestra=true&cantPuntos='.$_SESSION['cross_quality_ana_cali_basicos']['ProductoPuntos'].'&idCalidad='.$_SESSION['cross_quality_ana_cali_basicos']['ProductoCalidad'] ?>" title="Agregar Muestra" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Muestra</a>
						</td>
					</tr>
					<tr class="item-row fact_tittle">
						<td colspan="2">Productor</td>
						<td colspan="2">N° Folio / Pallet</td>
						<td>Lote</td>
						<td></td>
					</tr>
					<?php
					if (isset($_SESSION['cross_quality_ana_cali_muestras'])){
						//recorro el lsiatdo entregado por la base de datos
						foreach ($_SESSION['cross_quality_ana_cali_muestras'] as $key => $producto){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2"><?php echo $producto['ProductorNombre']; ?></td>
								<td class="item-name" colspan="2"><?php echo $producto['n_folio_pallet']; ?></td>
								<td class="item-name"><?php echo $producto['lote']; ?></td>
								<td>
									<div class="btn-group" style="width: 105px;" >
										<a href="<?php echo $location.'&cloneMuestra='.$producto['idMuestra'].'&cantPuntos='.$_SESSION['cross_quality_ana_cali_basicos']['ProductoPuntos'].'&idCalidad='.$_SESSION['cross_quality_ana_cali_basicos']['ProductoCalidad']; ?>" title="Clonar Registro" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a>
										<a href="<?php echo $location.'&editMuestra='.$producto['idMuestra'].'&cantPuntos='.$_SESSION['cross_quality_ana_cali_basicos']['ProductoPuntos'].'&idCalidad='.$_SESSION['cross_quality_ana_cali_basicos']['ProductoCalidad']; ?>" title="Editar Registro" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php
										$ubicacion = $location.'&del_muestra='.$producto['idMuestra'];
										$dialogo   = '¿Realmente deseas eliminar el registro ?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Registro" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
					<?php }
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="6">No hay muestras asignadas</td></tr>';
					}
					?>

				</tbody>
			</table>
		</div>

		<div class="col-xs-12">
			<div class="row">
				<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['cross_quality_ana_cali_basicos']['Observaciones']; ?></p>
			</div>
		</div>

		<table id="items" style="margin-bottom: 20px;">
			<tbody>

				<tr class="invoice-total" bgcolor="#f1f1f1">
					<td colspan="5">Archivos Adjuntos</td>
					<td width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
				</tr>

				<?php
				if (isset($_SESSION['cross_quality_ana_cali_archivos'])){
					//recorro el lsiatdo entregado por la base de datos
					$numeral = 1;
					foreach ($_SESSION['cross_quality_ana_cali_archivos'] as $key => $producto){ ?>
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
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Inspeccion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Precarga datos
					$xdata1 = ano_actual();
					$xdata2 = $xdata1+1;
					$xdata = $xdata1.' - '.$xdata2;

					//Se verifican si existen los datos
					if(isset($Creacion_fecha)){      $x1  = $Creacion_fecha;    }else{$x1  = '';}
					if(isset($idTipo)){              $x2  = $idTipo;            }else{$x2  = '';}
					if(isset($Temporada)){           $x3  = $Temporada;         }else{$x3  = $xdata;}
					if(isset($idCategoria)){         $x4  = $idCategoria;       }else{$x4  = '';}
					if(isset($idProducto)){          $x5  = $idProducto;        }else{$x5  = '';}
					if(isset($idUbicacion)){         $x6  = $idUbicacion;       }else{$x6  = '';}
					if(isset($idUbicacion_lvl_1)){   $x7  = $idUbicacion_lvl_1; }else{$x7  = '';}
					if(isset($idUbicacion_lvl_2)){   $x8  = $idUbicacion_lvl_2; }else{$x8  = '';}
					if(isset($idUbicacion_lvl_3)){   $x9  = $idUbicacion_lvl_3; }else{$x9  = '';}
					if(isset($idUbicacion_lvl_4)){   $x10 = $idUbicacion_lvl_4; }else{$x10 = '';}
					if(isset($idUbicacion_lvl_5)){   $x11 = $idUbicacion_lvl_5; }else{$x11 = '';}
					if(isset($Observaciones)){       $x12 = $Observaciones;     }else{$x12 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha Ingreso','Creacion_fecha', $x1, 2);
					$Form_Inputs->form_select('Tipo Planilla','idTipo', $x2, 2, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);
					$Form_Inputs->form_select_temporada_2('Temporada','Temporada', $x3, 2, ano_actual());
					$Form_Inputs->form_select_depend1('Categoria','idCategoria', $x4, 2, 'idCategoria', 'Nombre', 'sistema_productos_categorias', 0, 0,
											'Producto','idProducto', $x5, 2, 'idProducto', 'Nombre', 'productos_listado', 'idEstado=1 AND idCalidad!=0 AND idOpciones_2=1', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select_depend5('Ubicación', 'idUbicacion',  $x6,  2,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1',   0,
												'Nivel 1', 'idUbicacion_lvl_1',  $x7,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0,
												'Nivel 2', 'idUbicacion_lvl_2',  $x8,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												'Nivel 3', 'idUbicacion_lvl_3',  $x9,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												'Nivel 4', 'idUbicacion_lvl_4',  $x10,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												'Nivel 5', 'idUbicacion_lvl_5',  $x11,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												$dbConn, 'form1');

					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x12, 1);

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
			case 'tipo_asc':       $order_by = 'core_cross_quality_analisis_calidad.Nombre ASC ';                           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente'; break;
			case 'tipo_desc':      $order_by = 'core_cross_quality_analisis_calidad.Nombre DESC ';                          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
			case 'fecha_asc':      $order_by = 'cross_quality_analisis_calidad.Creacion_fecha ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ingreso Ascendente';break;
			case 'fecha_desc':     $order_by = 'cross_quality_analisis_calidad.Creacion_fecha DESC ';                       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Ingreso Descendente';break;
			case 'temporada_asc':  $order_by = 'cross_quality_analisis_calidad.Temporada ASC ';                             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Temporada Ascendente';break;
			case 'temporada_desc': $order_by = 'cross_quality_analisis_calidad.Temporada DESC ';                            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Temporada Descendente';break;
			case 'producto_asc':   $order_by = 'sistema_productos_categorias.Nombre ASC, productos_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Producto Ascendente';break;
			case 'producto_desc':  $order_by = 'sistema_productos_categorias.Nombre DESC, productos_listado.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Producto Descendente';break;
			case 'zona_asc':       $order_by = 'ubicacion_listado.Nombre ASC ';                                             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Zona Ascendente';break;
			case 'zona_desc':      $order_by = 'ubicacion_listado.Nombre DESC ';                                            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Zona Descendente';break;
			case 'creador_asc':    $order_by = 'usuarios_listado.Nombre ASC ';                                              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Creador Ascendente';break;
			case 'creador_desc':   $order_by = 'usuarios_listado.Nombre DESC ';                                             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Creador Descendente';break;

			default: $order_by = 'cross_quality_analisis_calidad.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Ingreso Descendente';
		}
	}else{
		$order_by = 'cross_quality_analisis_calidad.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Ingreso Descendente';
	}
	/**********************************************************/
	//Variable con la ubicacion
	$SIS_where = "cross_quality_analisis_calidad.idAnalisis!=0";
	$SIS_where.= " AND cross_quality_analisis_calidad.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//Verifico el tipo de usuario que esta ingresando
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){        $SIS_where .= " AND cross_quality_analisis_calidad.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                        $SIS_where .= " AND cross_quality_analisis_calidad.idTipo=".$_GET['idTipo'];}
	if(isset($_GET['Temporada']) && $_GET['Temporada']!=''){                  $SIS_where .= " AND cross_quality_analisis_calidad.Temporada=".$_GET['Temporada'];}
	if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){              $SIS_where .= " AND cross_quality_analisis_calidad.idCategoria=".$_GET['idCategoria'];}
	if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){                $SIS_where .= " AND cross_quality_analisis_calidad.idProducto=".$_GET['idProducto'];}
	if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){              $SIS_where .= " AND cross_quality_analisis_calidad.idUbicacion=".$_GET['idUbicacion'];}
	if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){  $SIS_where .= " AND cross_quality_analisis_calidad.idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];}
	if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){  $SIS_where .= " AND cross_quality_analisis_calidad.idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];}
	if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){  $SIS_where .= " AND cross_quality_analisis_calidad.idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];}
	if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){  $SIS_where .= " AND cross_quality_analisis_calidad.idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];}
	if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){  $SIS_where .= " AND cross_quality_analisis_calidad.idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idAnalisis', 'cross_quality_analisis_calidad', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	cross_quality_analisis_calidad.idAnalisis,
	cross_quality_analisis_calidad.Creacion_fecha,
	cross_quality_analisis_calidad.Temporada,

	usuarios_listado.Nombre AS Usuario,
	core_sistemas.Nombre AS Sistema,
	core_cross_quality_analisis_calidad.Nombre AS TipoPlanilla,
	sistema_productos_categorias.Nombre AS ProductoCategoria,
	productos_listado.Nombre AS ProductoNombre,

	ubicacion_listado.Nombre AS Ubicacion,
	ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
	ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
	ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
	ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
	ubicacion_listado_level_5.Nombre AS UbicacionLVL_5';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`                      ON usuarios_listado.idUsuario                   = cross_quality_analisis_calidad.idUsuario
	LEFT JOIN `core_sistemas`                         ON core_sistemas.idSistema                      = cross_quality_analisis_calidad.idSistema
	LEFT JOIN `core_cross_quality_analisis_calidad`   ON core_cross_quality_analisis_calidad.idTipo   = cross_quality_analisis_calidad.idTipo
	LEFT JOIN `sistema_productos_categorias`          ON sistema_productos_categorias.idCategoria     = cross_quality_analisis_calidad.idCategoria
	LEFT JOIN `productos_listado`                     ON productos_listado.idProducto                 = cross_quality_analisis_calidad.idProducto
	LEFT JOIN `ubicacion_listado`                     ON ubicacion_listado.idUbicacion                = cross_quality_analisis_calidad.idUbicacion
	LEFT JOIN `ubicacion_listado_level_1`             ON ubicacion_listado_level_1.idLevel_1          = cross_quality_analisis_calidad.idUbicacion_lvl_1
	LEFT JOIN `ubicacion_listado_level_2`             ON ubicacion_listado_level_2.idLevel_2          = cross_quality_analisis_calidad.idUbicacion_lvl_2
	LEFT JOIN `ubicacion_listado_level_3`             ON ubicacion_listado_level_3.idLevel_3          = cross_quality_analisis_calidad.idUbicacion_lvl_3
	LEFT JOIN `ubicacion_listado_level_4`             ON ubicacion_listado_level_4.idLevel_4          = cross_quality_analisis_calidad.idUbicacion_lvl_4
	LEFT JOIN `ubicacion_listado_level_5`             ON ubicacion_listado_level_5.idLevel_5          = cross_quality_analisis_calidad.idUbicacion_lvl_5';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'cross_quality_analisis_calidad', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

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
			<?php if (isset($_SESSION['cross_quality_ana_cali_basicos']['idTipo'])&&$_SESSION['cross_quality_ana_cali_basicos']['idTipo']!=''){ ?>

				<?php
				$ubicacion = $location.'&clear_all=true';
				$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
				<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

				<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-arrow-right" aria-hidden="true"></i> Continuar Inspeccion</a>
			<?php }else{ ?>
				<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Inspeccion</a>
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
					if(isset($Creacion_fecha)){      $x1  = $Creacion_fecha;    }else{$x1  = '';}
					if(isset($idTipo)){              $x2  = $idTipo;            }else{$x2  = '';}
					if(isset($Temporada)){           $x3  = $Temporada;         }else{$x3  = '';}
					if(isset($idCategoria)){         $x4  = $idCategoria;       }else{$x4  = '';}
					if(isset($idProducto)){          $x5  = $idProducto;        }else{$x5  = '';}
					if(isset($idUbicacion)){         $x6  = $idUbicacion;       }else{$x6  = '';}
					if(isset($idUbicacion_lvl_1)){   $x7  = $idUbicacion_lvl_1; }else{$x7  = '';}
					if(isset($idUbicacion_lvl_2)){   $x8  = $idUbicacion_lvl_2; }else{$x8  = '';}
					if(isset($idUbicacion_lvl_3)){   $x9  = $idUbicacion_lvl_3; }else{$x9  = '';}
					if(isset($idUbicacion_lvl_4)){   $x10 = $idUbicacion_lvl_4; }else{$x10 = '';}
					if(isset($idUbicacion_lvl_5)){   $x11 = $idUbicacion_lvl_5; }else{$x11 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha Ingreso','Creacion_fecha', $x1, 1);
					$Form_Inputs->form_select('Tipo Planilla','idTipo', $x2, 1, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);
					$Form_Inputs->form_select_temporada_2('Temporada','Temporada', $x3, 1, ano_actual());
					$Form_Inputs->form_select_depend1('Categoria','idCategoria', $x4, 1, 'idCategoria', 'Nombre', 'sistema_productos_categorias', 0, 0,
											'Producto','idProducto', $x5, 1, 'idProducto', 'Nombre', 'productos_listado', 'idEstado=1 AND idCalidad!=0', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select_depend5('Ubicación', 'idUbicacion',  $x6,  1,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1',   0,
												'Nivel 1', 'idUbicacion_lvl_1',  $x7,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0,
												'Nivel 2', 'idUbicacion_lvl_2',  $x8,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												'Nivel 3', 'idUbicacion_lvl_3',  $x9,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												'Nivel 4', 'idUbicacion_lvl_4',  $x10,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												'Nivel 5', 'idUbicacion_lvl_5',  $x11,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												$dbConn, 'form1');

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Inspecciones</h5>
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
								<div class="pull-left">Tipo</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Fecha Ingreso</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Temporada</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=temporada_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=temporada_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
								<div class="pull-left">Zona</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=zona_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=zona_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
							<td><?php echo $tipo['TipoPlanilla']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo $tipo['Temporada']; ?></td>
							<td><?php echo $tipo['ProductoCategoria'].' - '.$tipo['ProductoNombre']; ?></td>
							<td>
								<?php echo $tipo['Ubicacion'];
								if(isset($tipo['UbicacionLVL_1'])&&$tipo['UbicacionLVL_1']!=''){echo ' - '.$tipo['UbicacionLVL_1'];}
								if(isset($tipo['UbicacionLVL_2'])&&$tipo['UbicacionLVL_2']!=''){echo ' - '.$tipo['UbicacionLVL_2'];}
								if(isset($tipo['UbicacionLVL_3'])&&$tipo['UbicacionLVL_3']!=''){echo ' - '.$tipo['UbicacionLVL_3'];}
								if(isset($tipo['UbicacionLVL_4'])&&$tipo['UbicacionLVL_4']!=''){echo ' - '.$tipo['UbicacionLVL_4'];}
								if(isset($tipo['UbicacionLVL_5'])&&$tipo['UbicacionLVL_5']!=''){echo ' - '.$tipo['UbicacionLVL_5'];}
								?>
							</td>
							<td><?php echo $tipo['Usuario']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_cross_quality_calidad_analisis.php?view='.simpleEncode($tipo['idAnalisis'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo 'cross_quality_analisis_calidad_edit.php?edit='.$tipo['idAnalisis']; ?>" title="Editar Inspeccion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
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
