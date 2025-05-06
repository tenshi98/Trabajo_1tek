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
$original = "analisis_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['f_muestreo']) && $_GET['f_muestreo']!=''){   $location .= "&f_muestreo=".$_GET['f_muestreo'];  $search .= "&f_muestreo=".$_GET['f_muestreo'];}
if(isset($_GET['f_recibida']) && $_GET['f_recibida']!=''){   $location .= "&f_recibida=".$_GET['f_recibida'];  $search .= "&f_recibida=".$_GET['f_recibida'];}
if(isset($_GET['f_reporte']) && $_GET['f_reporte']!=''){     $location .= "&f_reporte=".$_GET['f_reporte'];    $search .= "&f_reporte=".$_GET['f_reporte'];}
if(isset($_GET['idMaquina']) && $_GET['idMaquina']!=''){     $location .= "&idMaquina=".$_GET['idMaquina'];    $search .= "&idMaquina=".$_GET['idMaquina'];}
if(isset($_GET['idMatriz']) && $_GET['idMatriz']!=''){       $location .= "&idMatriz=".$_GET['idMatriz'];      $search .= "&idMatriz=".$_GET['idMatriz'];}
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
	require_once 'A1XRXS_sys/xrxs_form/z_analisis_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_analisis_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/z_analisis_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Analisis Ingresado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Analisis Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Analisis Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	// consulto los datos
	$SIS_query = '
	analisis_listado.idMatriz,
	analisis_listado.f_muestreo,
	analisis_listado.f_recibida,
	analisis_listado.f_reporte,
	analisis_listado.n_muestra,
	Medida_1, Medida_2, Medida_3, Medida_4, Medida_5,
	Medida_6, Medida_7, Medida_8, Medida_9, Medida_10,
	Medida_11, Medida_12, Medida_13, Medida_14, Medida_15,
	Medida_16, Medida_17, Medida_18, Medida_19, Medida_20,
	Medida_21, Medida_22, Medida_23, Medida_24, Medida_25,
	Medida_26, Medida_27, Medida_28, Medida_29, Medida_30,
	Medida_31, Medida_32, Medida_33, Medida_34, Medida_35,
	Medida_36, Medida_37, Medida_38, Medida_39, Medida_40,
	Medida_41, Medida_42, Medida_43, Medida_44, Medida_45,
	Medida_46, Medida_47, Medida_48, Medida_49, Medida_50,
	analisis_listado.idEstado,
	analisis_listado.obs_Diagnostico,
	analisis_listado.obs_Accion,
	analisis_listado.idTipo,
	analisis_listado.idLaboratorio,
	maquinas_listado_matriz.cantPuntos';
	$SIS_join  = 'LEFT JOIN `maquinas_listado_matriz` ON maquinas_listado_matriz.idMatriz = analisis_listado.idMatriz';
	$SIS_where = 'idAnalisis = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'analisis_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
	}
	$SIS_join  = '';
	$SIS_where = 'idMatriz = '.$rowData['idMatriz'];
	$rowData2 = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData2');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idGrupo ASC';
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'maquinas_listado_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	// filtros
	$zx1 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación del Analisis</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($f_muestreo)){         $x1  = $f_muestreo;        }else{$x1  = $rowData['f_muestreo'];}
					if(isset($f_recibida)){         $x2  = $f_recibida;        }else{$x2  = $rowData['f_recibida'];}
					if(isset($f_reporte)){          $x3  = $f_reporte;         }else{$x3  = $rowData['f_reporte'];}
					if(isset($idTipo)){             $x4  = $idTipo;            }else{$x4  = $rowData['idTipo'];}
					if(isset($idLaboratorio)){      $x5  = $idLaboratorio;     }else{$x5  = $rowData['idLaboratorio'];}
					if(isset($n_muestra)){          $x6  = $n_muestra;         }else{$x6  = $rowData['n_muestra'];}
					if(isset($obs_Diagnostico)){    $x7  = $obs_Diagnostico;   }else{$x7  = $rowData['obs_Diagnostico'];}
					if(isset($obs_Accion)){         $x8  = $obs_Accion;        }else{$x8  = $rowData['obs_Accion'];}
					if(isset($idEstado)){           $x9  = $idEstado;          }else{$x9  = $rowData['idEstado'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Fechas');
					$Form_Inputs->form_date('Fecha de muestreo','f_muestreo', $x1, 2);
					$Form_Inputs->form_date('Fecha Recibida','f_recibida', $x2, 2);
					$Form_Inputs->form_date('Fecha del reporte','f_reporte', $x3, 2);

					$Form_Inputs->form_tittle(3, 'Laboratorio');
					$Form_Inputs->form_select('Tipo Analisis','idTipo', $x4, 2, 'idTipo', 'Nombre', 'analisis_listado_tipo', 0, '', $dbConn);
					$Form_Inputs->form_select('Laboratorio','idLaboratorio', $x5, 1, 'idLaboratorio', 'Nombre', 'laboratorio_listado', 0, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Datos Iniciales');
					$Form_Inputs->form_input_number('N° de muestra', 'n_muestra', $x6, 2);

					foreach ($arrGrupo as $grupo) {
						$Form_Inputs->form_tittle(3, $grupo['Nombre']);

						for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
							if($grupo['idGrupo']==$rowData2['PuntoidGrupo_'.$i]){
								//Verifico el tipo de dato
								switch ($rowData2['PuntoidTipo_'.$i]) {
									//Medidas
									case 1:
										$Form_Inputs->form_input_number($rowData2['PuntoNombre_'.$i], 'Medida_'.$i, $rowData['Medida_'.$i], 2);
										break;
									//Producto
									case 2:
										$Form_Inputs->form_select_filter($rowData2['PuntoNombre_'.$i],'Medida_'.$i, $rowData['Medida_'.$i], 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
										break;
									//Dispersancia
									case 3:
										$Form_Inputs->form_select($rowData2['PuntoNombre_'.$i],'Medida_'.$i, $rowData['Medida_'.$i], 2, 'idDispersancia', 'Nombre', 'core_analisis_dispersancia', 0, '', $dbConn);
										break;
									//Flashpoint
									case 4:
										$Form_Inputs->form_select($rowData2['PuntoNombre_'.$i],'Medida_'.$i, $rowData['Medida_'.$i], 2, 'idFlashPoint', 'Nombre', 'core_analisis_flashpoint', 0, '', $dbConn);
										break;
								}
							}
						}
					}

					$Form_Inputs->form_tittle(3, 'Final');
					$Form_Inputs->form_textarea('Diagnostico','obs_Diagnostico', $x7, 1);
					$Form_Inputs->form_textarea('Accion','obs_Accion', $x8, 1);
					$Form_Inputs->form_select('Estado','idEstado', $x9, 2, 'idEstado', 'Nombre', 'core_analisis_estado', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idAnalisis', $_GET['id'], 2);

					?>
					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_idLaboratorio').style.display = 'none';
							//se ejecuta al inicio
							LoadTipo(0);
						});

						/**********************************************************************/
						document.getElementById("idTipo").onchange = function() {LoadTipo(1)};

						/**********************************************************************/
						function LoadTipo(caseLoad){
							//obtengo los valores
							let Sensores_val= $("#idTipo").val();
							//selecciono
							switch(Sensores_val) {
								//si es Interno
								case '1':
									document.getElementById('div_idLaboratorio').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idLaboratorio"]').selectedIndex = 0;
									}
								break;
								//si es Externo
								case '2':
									document.getElementById('div_idLaboratorio').style.display = '';
								break;
							}
						}

					</script>

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
}elseif(!empty($_GET['new2'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'cantPuntos';
	$SIS_join  = '';
	$SIS_where = 'idMatriz = '.$_GET['idMatriz'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
		$SIS_query .= ',PuntoNombre_'.$i;
		$SIS_query .= ',PuntoidTipo_'.$i;
		$SIS_query .= ',PuntoidGrupo_'.$i;
	}
	$SIS_join  = '';
	$SIS_where = 'idMatriz = '.$_GET['idMatriz'];
	$rowData2 = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData2');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idGrupo ASC';
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'maquinas_listado_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	// filtros
	$zx1 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Ingreso datos de <?php echo $rowData2['Nombre']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idTipo)){             $x1  = $idTipo;            }else{$x1  = '';}
					if(isset($idLaboratorio)){      $x2  = $idLaboratorio;     }else{$x2  = '';}
					if(isset($n_muestra)){          $x3  = $n_muestra;         }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Laboratorio');
					$Form_Inputs->form_select('Tipo Analisis','idTipo', $x1, 2, 'idTipo', 'Nombre', 'analisis_listado_tipo', 0, '', $dbConn);
					$Form_Inputs->form_select('Laboratorio','idLaboratorio', $x2, 1, 'idLaboratorio', 'Nombre', 'laboratorio_listado', 0, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Datos Iniciales');
					$Form_Inputs->form_input_number('N° de muestra', 'n_muestra', $x3, 2);

					foreach ($arrGrupo as $grupo) {
						//Cuento si hay items dentro de la categoria
						$x_con = 0;
						for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
							if($grupo['idGrupo']==$rowData2['PuntoidGrupo_'.$i]){
								$x_con++;
							}
						}

						//si hay items se muestra todo
						if($x_con!=0){

							$Form_Inputs->form_tittle(3, $grupo['Nombre']);

							for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
								if($grupo['idGrupo']==$rowData2['PuntoidGrupo_'.$i]){
									//Verifico el tipo de dato
									switch ($rowData2['PuntoidTipo_'.$i]) {
										//Medidas
										case 1:
											$Form_Inputs->form_input_number($rowData2['PuntoNombre_'.$i], 'Medida_'.$i, '', 2);
											break;
										//Producto
										case 2:
											$Form_Inputs->form_select_filter($rowData2['PuntoNombre_'.$i],'Medida_'.$i, '', 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
											break;
										//Dispersancia
										case 3:
											$Form_Inputs->form_select($rowData2['PuntoNombre_'.$i],'Medida_'.$i, '', 2, 'idDispersancia', 'Nombre', 'core_analisis_dispersancia', 0, '', $dbConn);
											break;
										//Flashpoint
										case 4:
											$Form_Inputs->form_select($rowData2['PuntoNombre_'.$i],'Medida_'.$i, '', 2, 'idFlashPoint', 'Nombre', 'core_analisis_flashpoint', 0, '', $dbConn);
											break;
									}
								}
							}
						}
					}

					$Form_Inputs->form_tittle(3, 'Final');
					$Form_Inputs->form_textarea('Diagnostico','obs_Diagnostico', '', 1);
					$Form_Inputs->form_textarea('Accion','obs_Accion', '', 1);
					$Form_Inputs->form_select('Estado','idEstado', '', 2, 'idEstado', 'Nombre', 'core_analisis_estado', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('pagina', $_GET['pagina'], 2);
					$Form_Inputs->form_input_hidden('f_muestreo', $_GET['f_muestreo'], 2);
					$Form_Inputs->form_input_hidden('f_recibida', $_GET['f_recibida'], 2);
					$Form_Inputs->form_input_hidden('f_reporte', $_GET['f_reporte'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $_GET['idMaquina'], 2);
					$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);

					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_idLaboratorio').style.display = 'none';
						});

						/**********************************************************************/
						document.getElementById("idTipo").onchange = function() {LoadTipo(1)};

						/**********************************************************************/
						function LoadTipo(caseLoad){
							//obtengo los valores
							let Sensores_val= $("#idTipo").val();
							//selecciono
							switch(Sensores_val) {
								//si es Interno
								case '1':
									document.getElementById('div_idLaboratorio').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idLaboratorio"]').selectedIndex = 0;
									}
								break;
								//si es Externo
								case '2':
									document.getElementById('div_idLaboratorio').style.display = '';
								break;
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit">
						<a href="<?php echo $location.'&new=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//Verifico el tipo de usuario que esta ingresando
	$z="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idConfig_2=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Seleccion de Maquina y Analisis</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($f_muestreo)){         $x1  = $f_muestreo;        }else{$x1  = '';}
					if(isset($f_recibida)){         $x2  = $f_recibida;        }else{$x2  = '';}
					if(isset($f_reporte)){          $x3  = $f_reporte;         }else{$x3  = '';}
					if(isset($idMaquina)){          $x4  = $idMaquina;         }else{$x4  = '';}
					if(isset($idMatriz)){           $x5  = $idMatriz;          }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha de muestreo','f_muestreo', $x1, 2);
					$Form_Inputs->form_date('Fecha Recibida','f_recibida', $x2, 2);
					$Form_Inputs->form_date('Fecha del reporte','f_reporte', $x3, 2);
					$Form_Inputs->form_select_depend1('Maquina','idMaquina', $x4, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $z, 0,
											'Analisis','idMatriz', $x5, 2, 'idMatriz', 'Nombre', 'maquinas_listado_matriz', 'idEstado=1', 0, 
											$dbConn, 'form1');

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf178; Continuar" name="new2">
						<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
			case 'maquina_asc':    $order_by = 'maquinas_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Maquina Ascendente'; break;
			case 'maquina_desc':   $order_by = 'maquinas_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Maquina Descendente';break;
			case 'analisis_asc':   $order_by = 'maquinas_listado_matriz.Nombre ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Analisis Ascendente';break;
			case 'analisis_desc':  $order_by = 'maquinas_listado_matriz.Nombre DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Analisis Descendente';break;
			case 'nmuestra_asc':   $order_by = 'analisis_listado.n_muestra ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Muestra Ascendente'; break;
			case 'nmuestra_desc':  $order_by = 'analisis_listado.n_muestra DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Muestra Descendente';break;
			case 'fmuestreo_asc':  $order_by = 'analisis_listado.f_muestreo ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Muestreo Ascendente';break;
			case 'fmuestreo_desc': $order_by = 'analisis_listado.f_muestreo DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Muestreo Descendente';break;
			case 'frecibida_asc':  $order_by = 'analisis_listado.f_recibida ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Recibida Ascendente'; break;
			case 'frecibida_desc': $order_by = 'analisis_listado.f_recibida DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Recibida Descendente';break;
			case 'freporte_asc':   $order_by = 'analisis_listado.f_reporte ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Reporte Ascendente';break;
			case 'freporte_desc':  $order_by = 'analisis_listado.f_reporte DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Reporte Descendente';break;

			default: $order_by = 'analisis_listado.idAnalisis DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';
		}
	}else{
		$order_by = 'analisis_listado.idAnalisis DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "analisis_listado.idAnalisis!=0";
	$SIS_where.= " AND analisis_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//Verifico el tipo de usuario que esta ingresando

	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['f_muestreo']) && $_GET['f_muestreo']!=''){  $SIS_where .= " AND analisis_listado.f_muestreo='".$_GET['f_muestreo']."'";}
	if(isset($_GET['f_recibida']) && $_GET['f_recibida']!=''){  $SIS_where .= " AND analisis_listado.f_recibida='".$_GET['f_recibida']."'";}
	if(isset($_GET['f_reporte']) && $_GET['f_reporte']!=''){    $SIS_where .= " AND analisis_listado.f_reporte='".$_GET['f_reporte']."'";}
	if(isset($_GET['idMaquina']) && $_GET['idMaquina']!=''){    $SIS_where .= " AND analisis_listado.idMaquina=".$_GET['idMaquina'];}
	if(isset($_GET['idMatriz']) && $_GET['idMatriz']!=''){      $SIS_where .= " AND analisis_listado.idMatriz=".$_GET['idMatriz'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idAnalisis', 'analisis_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	analisis_listado.idAnalisis,
	analisis_listado.n_muestra,
	analisis_listado.f_muestreo,
	analisis_listado.f_recibida,
	analisis_listado.f_reporte,
	core_sistemas.Nombre AS RazonSocial,
	maquinas_listado.Nombre AS NombreMaquina,
	maquinas_listado_matriz.Nombre AS TipoAnalisis';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`            ON core_sistemas.idSistema           = analisis_listado.idSistema
	LEFT JOIN `maquinas_listado`         ON maquinas_listado.idMaquina        = analisis_listado.idMaquina
	LEFT JOIN `maquinas_listado_matriz`  ON maquinas_listado_matriz.idMatriz  = analisis_listado.idMatriz';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'analisis_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location.'&pagina='.$_GET['pagina'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Ingresar Nuevo Analisis</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($f_muestreo)){         $x1  = $f_muestreo;        }else{$x1  = '';}
					if(isset($f_recibida)){         $x2  = $f_recibida;        }else{$x2  = '';}
					if(isset($f_reporte)){          $x3  = $f_reporte;         }else{$x3  = '';}
					if(isset($idMaquina)){          $x4  = $idMaquina;         }else{$x4  = '';}
					if(isset($idMatriz)){           $x5  = $idMatriz;          }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha de muestreo','f_muestreo', $x1, 1);
					$Form_Inputs->form_date('Fecha Recibida','f_recibida', $x2, 1);
					$Form_Inputs->form_date('Fecha del reporte','f_reporte', $x3, 1);
					$Form_Inputs->form_select_depend1('Maquina','idMaquina', $x4, 1, 'idMaquina', 'Nombre', 'maquinas_listado', $w, 0,
											'Analisis','idMatriz', $x5, 1, 'idMatriz', 'Nombre', 'maquinas_listado_matriz', 'idEstado=1', 0, 
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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Analisis</h5>
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
								<div class="pull-left">Maquina</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=maquina_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=maquina_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Analisis</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=analisis_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=analisis_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">
								<div class="pull-left">N° Muestra</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nmuestra_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nmuestra_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="100">
								<div class="pull-left">F muestreo</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fmuestreo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fmuestreo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="100">
								<div class="pull-left">F recibida</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=frecibida_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=frecibida_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="100">
								<div class="pull-left">F reporte</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=freporte_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=freporte_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrTipo as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['NombreMaquina']; ?></td>
							<td><?php echo $tipo['TipoAnalisis']; ?></td>
							<td><?php echo $tipo['n_muestra']; ?></td>
							<td><?php echo fecha_estandar($tipo['f_muestreo']); ?></td>
							<td><?php echo fecha_estandar($tipo['f_recibida']); ?></td>
							<td><?php echo fecha_estandar($tipo['f_reporte']); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['RazonSocial']; ?></td><?php } ?>
							<td>
								<div class="btn-group"style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_analisis.php?view='.simpleEncode($tipo['idAnalisis'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$tipo['idAnalisis']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($tipo['idAnalisis'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el analisis?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
