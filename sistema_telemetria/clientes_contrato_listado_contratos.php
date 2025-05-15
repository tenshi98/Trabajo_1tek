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
$original = "clientes_contrato_listado.php";
$location = $original;
$new_location = "clientes_contrato_listado_contratos.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'createBasicDataContrato';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'updateBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'delBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//Si el estado esta distinto de vacio
if (!empty($_GET['estado'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&status='.$_GET['status'];
	//Llamamos al formulario
	$form_trabajo= 'estadoContrato';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
/***********************************************************/
//formulario para crear
if (!empty($_POST['submit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'];
	//Llamamos al formulario
	$form_trabajo= 'insert_item';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'];
	//Llamamos al formulario
	$form_trabajo= 'update_item';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'];
	//Llamamos al formulario
	$form_trabajo= 'del_item';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Contrato Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Contrato Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Contrato Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit_itemizado'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,Codigo, idUtilizable, idFrecuencia, Cantidad, TiempoProgramado, idTrabajo, Valor, ValorTotal';
	$SIS_join  = '';
	$SIS_where = 'idLevel_'.$_GET['lvl'].' = '.$_GET['edit_itemizado'];
	$rowData = db_select_data (false, $SIS_query, 'licitacion_listado_level_'.$_GET['lvl'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar Rama</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){            $x1  = $Nombre;             }else{$x1  = $rowData['Nombre'];}
					if(isset($Codigo)){            $x2  = $Codigo;             }else{$x2  = $rowData['Codigo'];}
					if(isset($idUtilizable)){      $x3  = $idUtilizable;       }else{$x3  = $rowData['idUtilizable'];}
					if(isset($idFrecuencia)){      $x4  = $idFrecuencia;       }else{$x4  = $rowData['idFrecuencia'];}
					if(isset($Cantidad)){          $x5  = $Cantidad;           }else{$x5  = $rowData['Cantidad'];}
					if(isset($TiempoProgramado)){  $x6  = $TiempoProgramado;   }else{$x6  = $rowData['TiempoProgramado'];}
					if(isset($idTrabajo)){         $x7  = $idTrabajo;          }else{$x7  = $rowData['idTrabajo'];}
					if(isset($Valor)){             $x8  = $Valor;              }else{$x8  = $rowData['Valor'];}
					if(isset($ValorTotal)){        $x9  = $ValorTotal;         }else{$x9  = $rowData['ValorTotal'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 2);
					$Form_Inputs->form_select('Utilizable','idUtilizable', $x3, 2, 'idUtilizable', 'Nombre', 'core_estado_utilizable', 0, '', $dbConn);

					$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x4, 1, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x5, 1);
					$Form_Inputs->form_time('Tiempo Programado','TiempoProgramado', $x6, 1, 1);
					$Form_Inputs->form_select('Tipo Trabajo','idTrabajo', $x7, 1, 'idTrabajo', 'Nombre', 'core_licitacion_trabajos', 0, '', $dbConn);

					$Form_Inputs->form_input_number('Valor', 'Valor', $x8, 1);
					echo '<div class="form-group" id="div_ValorTotal">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Valor Total</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input value="'.$x9.'" type="text" placeholder="Valor Total" class="form-control"  name="Total" id="Total" disabled >
						</div>
					</div>';
					$Form_Inputs->form_input_hidden('ValorTotal', $x9, 2);
					$Form_Inputs->form_input_hidden('idLevel_'.$_GET['lvl'], $_GET['edit_itemizado'], 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

					?>
					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_idFrecuencia').style.display = 'none';
							document.getElementById('div_Cantidad').style.display = 'none';
							document.getElementById('div_TiempoProgramado').style.display = 'none';
							document.getElementById('div_idTrabajo').style.display = 'none';
							document.getElementById('div_Valor').style.display = 'none';
							document.getElementById('div_ValorTotal').style.display = 'none';
							//se ejecuta al inicio
							LoadUtilizable(0);
						});

						/**********************************************************************/
						document.getElementById("Valor").onkeyup = function() {LoadValor()};
						document.getElementById("idUtilizable").onchange = function() {LoadUtilizable(1)};

						/**********************************************************************/
						function LoadValor() {
							let CantIngreso = document.getElementById("Cantidad").value
							let valor       = document.getElementById("Valor").value;
							if (CantIngreso != "" && valor != "") {
								document.getElementById("Total").value      = CantIngreso * valor;
								document.getElementById("ValorTotal").value = CantIngreso * valor;
							}
						}

						/**********************************************************************/
						function LoadUtilizable(caseLoad){
							//obtengo los valores
							let Sensores_val = $("#idUtilizable").val();
							//selecciono
							switch(Sensores_val) {
								//Errores Conjuntos
								case '1':
									document.getElementById('div_idFrecuencia').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_TiempoProgramado').style.display = 'none';
									document.getElementById('div_idTrabajo').style.display = 'none';
									document.getElementById('div_Valor').style.display = 'none';
									document.getElementById('div_ValorTotal').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
										document.querySelector('input[name="Cantidad"]').value = '0';
										document.querySelector('input[name="TiempoProgramado"]').value = '0';
										document.querySelector('input[name="idTrabajo"]').selectedIndex = 0;
										document.querySelector('input[name="Valor"]').value = '0';
										document.querySelector('input[name="ValorTotal"]').value = '0';
									}
								break;
								//Errores Conjuntos
								case '2':
									document.getElementById('div_idFrecuencia').style.display = '';
									document.getElementById('div_Cantidad').style.display = '';
									document.getElementById('div_TiempoProgramado').style.display = '';
									document.getElementById('div_idTrabajo').style.display = '';
									document.getElementById('div_Valor').style.display = '';
									document.getElementById('div_ValorTotal').style.display = '';
								break;
							}
						}

					</script>

					<div class="form-group">

						<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){  $Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);} ?>
						<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){  $Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);} ?>
						<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){  $Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);} ?>
						<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){  $Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);} ?>
						<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){  $Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);} ?>
						<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){  $Form_Inputs->form_input_hidden('idLevel_6', $_GET['lv_6'], 2);} ?>
						<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){  $Form_Inputs->form_input_hidden('idLevel_7', $_GET['lv_7'], 2);} ?>
						<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){  $Form_Inputs->form_input_hidden('idLevel_8', $_GET['lv_8'], 2);} ?>
						<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){  $Form_Inputs->form_input_hidden('idLevel_9', $_GET['lv_9'], 2);} ?>
						<?php if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){$Form_Inputs->form_input_hidden('idLevel_10', $_GET['lv_10'], 2);} ?>
						<?php if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){$Form_Inputs->form_input_hidden('idLevel_11', $_GET['lv_11'], 2);} ?>
						<?php if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){$Form_Inputs->form_input_hidden('idLevel_12', $_GET['lv_12'], 2);} ?>
						<?php if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){$Form_Inputs->form_input_hidden('idLevel_13', $_GET['lv_13'], 2);} ?>
						<?php if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){$Form_Inputs->form_input_hidden('idLevel_14', $_GET['lv_14'], 2);} ?>
						<?php if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){$Form_Inputs->form_input_hidden('idLevel_15', $_GET['lv_15'], 2);} ?>
						<?php if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){$Form_Inputs->form_input_hidden('idLevel_16', $_GET['lv_16'], 2);} ?>
						<?php if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){$Form_Inputs->form_input_hidden('idLevel_17', $_GET['lv_17'], 2);} ?>
						<?php if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){$Form_Inputs->form_input_hidden('idLevel_18', $_GET['lv_18'], 2);} ?>
						<?php if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){$Form_Inputs->form_input_hidden('idLevel_19', $_GET['lv_19'], 2);} ?>
						<?php if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){$Form_Inputs->form_input_hidden('idLevel_20', $_GET['lv_20'], 2);} ?>
						<?php if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){$Form_Inputs->form_input_hidden('idLevel_21', $_GET['lv_21'], 2);} ?>
						<?php if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){$Form_Inputs->form_input_hidden('idLevel_22', $_GET['lv_22'], 2);} ?>
						<?php if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){$Form_Inputs->form_input_hidden('idLevel_23', $_GET['lv_23'], 2);} ?>
						<?php if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){$Form_Inputs->form_input_hidden('idLevel_24', $_GET['lv_24'], 2);} ?>
						<?php if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){$Form_Inputs->form_input_hidden('idLevel_25', $_GET['lv_25'], 2);} ?>

						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new_itemizado'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Rama</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){            $x1  = $Nombre;             }else{$x1  = '';}
					if(isset($Codigo)){            $x2  = $Codigo;             }else{$x2  = '';}
					if(isset($idUtilizable)){      $x3  = $idUtilizable;       }else{$x3  = '';}
					if(isset($idFrecuencia)){      $x4  = $idFrecuencia;       }else{$x4  = '';}
					if(isset($Cantidad)){          $x5  = $Cantidad;           }else{$x5  = '';}
					if(isset($TiempoProgramado)){  $x6  = $TiempoProgramado;   }else{$x6  = '';}
					if(isset($idTrabajo)){         $x7  = $idTrabajo;          }else{$x7  = '';}
					if(isset($Valor)){             $x8  = $Valor;             }else{$x8  = '';}
					if(isset($ValorTotal)){        $x9  = $ValorTotal;         }else{$x9  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 2);
					$Form_Inputs->form_select('Utilizable','idUtilizable', $x3, 2, 'idUtilizable', 'Nombre', 'core_estado_utilizable', 0, '', $dbConn);

					$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x4, 1, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x5, 1);
					$Form_Inputs->form_time('Tiempo Programado','TiempoProgramado', $x6, 1, 1);
					$Form_Inputs->form_select('Tipo Trabajo','idTrabajo', $x7, 1, 'idTrabajo', 'Nombre', 'core_licitacion_trabajos', 0, '', $dbConn);

					$Form_Inputs->form_input_number('Valor', 'Valor', $x8, 1);
					echo '<div class="form-group" id="div_ValorTotal">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Valor Total</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input value="'.$x9.'" type="text" placeholder="Valor Total" class="form-control"  name="Total" id="Total" disabled >
						</div>
					</div>';

					$Form_Inputs->form_input_hidden('ValorTotal', $x9, 2);
					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idLicitacion', $_GET['itemizado'], 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);
					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_idFrecuencia').style.display = 'none';
							document.getElementById('div_Cantidad').style.display = 'none';
							document.getElementById('div_TiempoProgramado').style.display = 'none';
							document.getElementById('div_idTrabajo').style.display = 'none';
							document.getElementById('div_Valor').style.display = 'none';
							document.getElementById('div_ValorTotal').style.display = 'none';
						});

						/**********************************************************************/
						document.getElementById("Valor").onkeyup = function() {LoadValor()};
						document.getElementById("idUtilizable").onchange = function() {LoadUtilizable(1)};

						/**********************************************************************/
						function LoadValor() {
							let CantIngreso = document.getElementById("Cantidad").value
							let valor       = document.getElementById("Valor").value;
							if (CantIngreso != "" && valor != "") {
								document.getElementById("Total").value      = CantIngreso * valor;
								document.getElementById("ValorTotal").value = CantIngreso * valor;
							}
						}

						/**********************************************************************/
						function LoadUtilizable(caseLoad){
							//obtengo los valores
							let Sensores_val = $("#idUtilizable").val();
							//selecciono
							switch(Sensores_val) {
								//Errores Conjuntos
								case '1':
									document.getElementById('div_idFrecuencia').style.display = 'none';
									document.getElementById('div_Cantidad').style.display = 'none';
									document.getElementById('div_TiempoProgramado').style.display = 'none';
									document.getElementById('div_idTrabajo').style.display = 'none';
									document.getElementById('div_Valor').style.display = 'none';
									document.getElementById('div_ValorTotal').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
										document.querySelector('input[name="Cantidad"]').value = '0';
										document.querySelector('input[name="TiempoProgramado"]').value = '0';
										document.querySelector('input[name="idTrabajo"]').selectedIndex = 0;
										document.querySelector('input[name="Valor"]').value = '0';
										document.querySelector('input[name="ValorTotal"]').value = '0';
									}
								break;
								//Errores Conjuntos
								case '2':
									document.getElementById('div_idFrecuencia').style.display = '';
									document.getElementById('div_Cantidad').style.display = '';
									document.getElementById('div_TiempoProgramado').style.display = '';
									document.getElementById('div_idTrabajo').style.display = '';
									document.getElementById('div_Valor').style.display = '';
									document.getElementById('div_ValorTotal').style.display = '';
								break;
							}
						}

					</script>

					<div class="form-group">

						<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){  $Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);} ?>
						<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){  $Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);} ?>
						<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){  $Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);} ?>
						<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){  $Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);} ?>
						<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){  $Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);} ?>
						<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){  $Form_Inputs->form_input_hidden('idLevel_6', $_GET['lv_6'], 2);} ?>
						<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){  $Form_Inputs->form_input_hidden('idLevel_7', $_GET['lv_7'], 2);} ?>
						<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){  $Form_Inputs->form_input_hidden('idLevel_8', $_GET['lv_8'], 2);} ?>
						<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){  $Form_Inputs->form_input_hidden('idLevel_9', $_GET['lv_9'], 2);} ?>
						<?php if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){$Form_Inputs->form_input_hidden('idLevel_10', $_GET['lv_10'], 2);} ?>
						<?php if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){$Form_Inputs->form_input_hidden('idLevel_11', $_GET['lv_11'], 2);} ?>
						<?php if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){$Form_Inputs->form_input_hidden('idLevel_12', $_GET['lv_12'], 2);} ?>
						<?php if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){$Form_Inputs->form_input_hidden('idLevel_13', $_GET['lv_13'], 2);} ?>
						<?php if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){$Form_Inputs->form_input_hidden('idLevel_14', $_GET['lv_14'], 2);} ?>
						<?php if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){$Form_Inputs->form_input_hidden('idLevel_15', $_GET['lv_15'], 2);} ?>
						<?php if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){$Form_Inputs->form_input_hidden('idLevel_16', $_GET['lv_16'], 2);} ?>
						<?php if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){$Form_Inputs->form_input_hidden('idLevel_17', $_GET['lv_17'], 2);} ?>
						<?php if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){$Form_Inputs->form_input_hidden('idLevel_18', $_GET['lv_18'], 2);} ?>
						<?php if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){$Form_Inputs->form_input_hidden('idLevel_19', $_GET['lv_19'], 2);} ?>
						<?php if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){$Form_Inputs->form_input_hidden('idLevel_20', $_GET['lv_20'], 2);} ?>
						<?php if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){$Form_Inputs->form_input_hidden('idLevel_21', $_GET['lv_21'], 2);} ?>
						<?php if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){$Form_Inputs->form_input_hidden('idLevel_22', $_GET['lv_22'], 2);} ?>
						<?php if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){$Form_Inputs->form_input_hidden('idLevel_23', $_GET['lv_23'], 2);} ?>
						<?php if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){$Form_Inputs->form_input_hidden('idLevel_24', $_GET['lv_24'], 2);} ?>
						<?php if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){$Form_Inputs->form_input_hidden('idLevel_25', $_GET['lv_25'], 2);} ?>

						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['itemizado'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idSistema';
	$SIS_join  = '';
	$SIS_where = 'idLicitacion = '.$_GET['itemizado'];
	$rowData = db_select_data (false, $SIS_query, 'licitacion_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
	/*******************************************************/
	//Se crean las variables
	$nmax     = 15;
	$z        = '';
	$leftjoin = '';
	$orderby  = '';
	for ($i = 1; $i <= $nmax; $i++) {
		//consulta
		$z .= ',licitacion_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
		$z .= ',licitacion_listado_level_'.$i.'.Codigo AS LVL_'.$i.'_Codigo';
		$z .= ',licitacion_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
		$z .= ',licitacion_listado_level_'.$i.'.idUtilizable AS LVL_'.$i.'_idUtilizable';
		//Joins
		$xx = $i + 1;
		if($xx<=$nmax){
			$leftjoin .= ' LEFT JOIN `licitacion_listado_level_'.$xx.'`   ON licitacion_listado_level_'.$xx.'.idLevel_'.$i.'    = licitacion_listado_level_'.$i.'.idLevel_'.$i;
		}
		//ORDER BY
		$orderby .= ', licitacion_listado_level_'.$i.'.Codigo ASC';
	}

	//se hace la consulta
	$arrLicitacion = array();
	$arrLicitacion = db_select_array (false, 'licitacion_listado_level_1.idLevel_1 AS bla'.$z, 'licitacion_listado_level_1', $leftjoin, 'licitacion_listado_level_1.idLicitacion ='.$_GET['itemizado'], 'licitacion_listado_level_1.Codigo ASC '.$orderby, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrLicitacion');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUtilizable, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idUtilizable ASC';
	$arrTipos = array();
	$arrTipos = db_select_array (false, $SIS_query, 'core_estado_utilizable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');

	/*******************************************************/
	//Se crea el arreglo
	$TipoMaq = array();
	foreach($arrTipos as $tipo) {
		$TipoMaq[$tipo['idUtilizable']]['idUtilizable']  = $tipo['idUtilizable'];
		$TipoMaq[$tipo['idUtilizable']]['Nombre']        = $tipo['Nombre'];
	}

	/*******************************************************/
	$array3d = array();
	foreach($arrLicitacion as $key) {

		//Creo Variables para la rejilla
		for ($i = 1; $i <= $nmax; $i++) {
			$d[$i]  = $key['LVL_'.$i.'_id'];
			$n[$i]  = $key['LVL_'.$i.'_Nombre'];
			$c[$i]  = $key['LVL_'.$i.'_Codigo'];
			$u[$i]  = $key['LVL_'.$i.'_idUtilizable'];
		}
		if( $d['1']!=''){
			$array3d[$d['1']]['id']     = $d['1'];
			$array3d[$d['1']]['Nombre'] = $n['1'];
			$array3d[$d['1']]['Codigo'] = $c['1'];
			$array3d[$d['1']]['Tipo']   = $u['1'];
		}
		if( $d['2']!=''){
			$array3d[$d['1']][$d['2']]['id']     = $d['2'];
			$array3d[$d['1']][$d['2']]['Nombre'] = $n['2'];
			$array3d[$d['1']][$d['2']]['Codigo'] = $c['2'];
			$array3d[$d['1']][$d['2']]['Tipo']   = $u['2'];
		}
		if( $d['3']!=''){
			$array3d[$d['1']][$d['2']][$d['3']]['id']     = $d['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Nombre'] = $n['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Codigo'] = $c['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Tipo']   = $u['3'];
		}
		if( $d['4']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']     = $d['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre'] = $n['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Codigo'] = $c['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tipo']   = $u['4'];
		}
		if( $d['5']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']     = $d['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre'] = $n['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Codigo'] = $c['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tipo']   = $u['5'];
		}
		if( $d['6']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['id']     = $d['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Nombre'] = $n['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Codigo'] = $c['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tipo']   = $u['6'];
		}
		if( $d['7']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['id']     = $d['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Nombre'] = $n['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Codigo'] = $c['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tipo']   = $u['7'];
		}
		if( $d['8']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['id']     = $d['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Nombre'] = $n['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Codigo'] = $c['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tipo']   = $u['8'];
		}
		if( $d['9']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['id']     = $d['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Nombre'] = $n['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Codigo'] = $c['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tipo']   = $u['9'];
		}
		if( $d['10']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['id']     = $d['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Nombre'] = $n['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Codigo'] = $c['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tipo']   = $u['10'];
		}
		if( $d['11']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['id']     = $d['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Nombre'] = $n['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Codigo'] = $c['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Tipo']   = $u['11'];
		}
		if( $d['12']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['id']     = $d['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Nombre'] = $n['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Codigo'] = $c['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Tipo']   = $u['12'];
		}
		if( $d['13']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['id']     = $d['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Nombre'] = $n['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Codigo'] = $c['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Tipo']   = $u['13'];
		}
		if( $d['14']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['id']     = $d['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Nombre'] = $n['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Codigo'] = $c['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Tipo']   = $u['14'];
		}
		if( $d['15']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['id']     = $d['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Nombre'] = $n['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Codigo'] = $c['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Tipo']   = $u['15'];
		}
		/*if( $d['16']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['id']     = $d['16'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Nombre'] = $n['16'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Codigo'] = $c['16'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Tipo']   = $u['16'];
		}
		if( $d['17']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['id']     = $d['17'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Nombre'] = $n['17'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Codigo'] = $c['17'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Tipo']   = $u['17'];
		}
		if( $d['18']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['id']     = $d['18'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Nombre'] = $n['18'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Codigo'] = $c['18'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Tipo']   = $u['18'];
		}
		if( $d['19']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['id']     = $d['19'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Nombre'] = $n['19'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Codigo'] = $c['19'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Tipo']   = $u['19'];
		}
		if( $d['20']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['id']     = $d['20'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Nombre'] = $n['20'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Codigo'] = $c['20'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Tipo']   = $u['20'];
		}
		if( $d['21']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['id']     = $d['21'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Nombre'] = $n['21'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Codigo'] = $c['21'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Tipo']   = $u['21'];
		}
		if( $d['22']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['id']     = $d['22'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Nombre'] = $n['22'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Codigo'] = $c['22'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Tipo']   = $u['22'];
		}
		if( $d['23']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['id']     = $d['23'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Nombre'] = $n['23'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Codigo'] = $c['23'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Tipo']   = $u['23'];
		}
		if( $d['24']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['id']     = $d['24'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Nombre'] = $n['24'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Codigo'] = $c['24'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Tipo']   = $u['24'];
		}
		if( $d['25']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['id']     = $d['25'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Nombre'] = $n['25'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Codigo'] = $c['25'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Tipo']   = $u['25'];
		}*/

	}

	/*******************************************************/
	function arrayToUL(array $array, array $TipoMaq, $lv, $rowlevel,$location, $nmax){
		$lv++;
		if($lv==1){
			echo '<ul class="tree">';
		}else{
			echo '<ul style="padding-left: 20px;">';
		}

		foreach ($array as $key => $value){
			//Rearmo la ubicacion de acuerdo a la profundidad
			if (isset($value['id'])){
				$loc = $location.'&lv_'.$lv.'='.$value['id'];
			}else{
				$loc = $location;
			}

			if (isset($value['Nombre'])){
				echo '<li><div class="blum">';
				echo '<div class="pull-left"><strong>'.$TipoMaq[$value['Tipo']]['Nombre'].':</strong> '.$value['Codigo'].' - '.$value['Nombre'].'</div>';
				echo '<div class="btn-group pull-right" >';
					//Boton editar
					if ($rowlevel>=2){
						echo '<a href="'.$loc.'&edit_itemizado='.$value['id'].'&lvl='.$lv.'" title="Editar Esta Rama" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
					}
					//Boton Borrar
					if ($rowlevel>=3){
						$ubicacion = $loc.'&del_idLevel='.simpleEncode($value['id'], fecha_actual()).'&lvl='.$lv.'&nmax='.$nmax;
						$dialogo   = '¿Realmente deseas eliminar todos los datos relacionados a esta Rama?';
						echo '<a onClick="dialogBox(\''.$ubicacion.'\', \''.$dialogo.'\')" title="Borrar Esta Rama" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
					}
				echo '</div>';
				//Boton para crear nueva subrama condicionado a solo si no se utiliza
				if ($value['Tipo']==1){
					echo '<div class="btn-group pull-right" style="margin-right:5px;" >';
						if ($rowlevel>=1){
							$xc = $lv + 1;
							if($lv<$nmax){
								echo '<a href="'.$loc.'&new_itemizado=true&lvl='.$xc.'" title="Crear nueva sub-Rama" class="btn btn-primary btn-sm tooltip"><i class="fa fa-file-o" aria-hidden="true"></i></a>';
							}
						}
					echo '</div>';
				}
				echo '<div class="clearfix"></div>';
				echo '</div>';
			}
			if (!empty($value) && is_array($value)){
				echo arrayToUL($value, $TipoMaq, $lv, $rowlevel,$loc, $nmax);
			}
			echo '</li>';
		}
		echo '</ul>';
	}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'].'&idSistema='.$rowData['idSistema'].'&new_itemizado=true&lvl=1'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Rama</a><?php } ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Itemizado Contrato <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="table-responsive">
				<?php //Se imprime el arbol
				echo arrayToUL($array3d, $TipoMaq, 0, $rowlevel['level'],$new_location.'&id='.$_GET['id'].'&itemizado='.$_GET['itemizado'].'&idSistema='.$rowData['idSistema'], $nmax);
				?>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['status'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	licitacion_listado.idLicitacion,
	licitacion_listado.Nombre,
	core_estados.Nombre AS estado';
	$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = licitacion_listado.idEstado';
	$SIS_where = 'idLicitacion = '.$_GET['status'];
	$rowData = db_select_data (false, $SIS_query, 'licitacion_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Estado Contrato</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
							<td><?php echo 'Contrato '.$rowData['Nombre'].' '.$rowData['estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php if ($rowlevel['level']>=2){ ?>
									<?php if ( $rowData['estado']=='Activo' ){ ?>
											<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$_GET['status'].'&estado='.simpleEncode(2, fecha_actual()) ; ?>">OFF</a>
											<a class="btn btn-sm btn-info locked_active" href="#">ON</a>
									<?php } else { ?>
											<a class="btn btn-sm btn-info locked_active" href="#">OFF</a>
											<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$_GET['status'].'&estado='.simpleEncode(1, fecha_actual()) ; ?>" >ON</a>
										<?php } ?>
									<?php } ?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit'])){
	//verifico que sea un administrador
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Codigo, Nombre,FechaInicio, FechaTermino, Presupuesto, idBodegaProd, idBodegaIns,
	idSistema, idAprobado, idTipoLicitacion, ValorMensual, idOpcionItem';
	$SIS_join  = '';
	$SIS_where = 'idLicitacion = '.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'licitacion_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Contrato</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Codigo)){                $x2  = $Codigo;              }else{$x2  = $rowData['Codigo'];}
					if(isset($Nombre)){                $x3  = $Nombre;              }else{$x3  = $rowData['Nombre'];}
					if(isset($FechaInicio)){           $x4  = $FechaInicio;         }else{$x4  = $rowData['FechaInicio'];}
					if(isset($FechaTermino)){          $x5  = $FechaTermino;        }else{$x5  = $rowData['FechaTermino'];}
					if(isset($idTipoLicitacion)){      $x6  = $idTipoLicitacion;    }else{$x6  = $rowData['idTipoLicitacion'];}
					if(isset($ValorMensual)){          $x7  = $ValorMensual;        }else{$x7  = $rowData['ValorMensual'];}
					if(isset($Presupuesto)){           $x8  = $Presupuesto;         }else{$x8  = $rowData['Presupuesto'];}
					if(isset($idBodegaProd)){          $x9  = $idBodegaProd;        }else{$x9  = $rowData['idBodegaProd'];}
					if(isset($idBodegaIns)){           $x10 = $idBodegaIns;         }else{$x10 = $rowData['idBodegaIns'];}
					if(isset($idOpcionItem)){          $x11 = $idOpcionItem;        }else{$x11 = $rowData['idOpcionItem'];}
					if(isset($idAprobado)){            $x12 = $idAprobado;          }else{$x12 = $rowData['idAprobado'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x3, 2);
					$Form_Inputs->form_date('Fecha de Inicio Contrato','FechaInicio', $x4, 1);
					$Form_Inputs->form_date('Fecha de Termino Contrato','FechaTermino', $x5, 1);
					$Form_Inputs->form_select('Tipo Contrato','idTipoLicitacion', $x6, 2, 'idTipoLicitacion', 'Nombre', 'core_licitacion_tipos', 0, '', $dbConn);
					$Form_Inputs->form_values('Valor Fijo Mensual', 'ValorMensual', $x7, 1);
					$Form_Inputs->form_values('Presupuesto', 'Presupuesto', $x8, 1);
					$Form_Inputs->form_select('Bodega Productos','idBodegaProd', $x9, 2, 'idBodega', 'Nombre', 'bodegas_productos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Bodega Insumos','idBodegaIns', $x10, 2, 'idBodega', 'Nombre', 'bodegas_insumos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Utilizar Itemizado','idOpcionItem', $x11, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Estado Aprobacion','idAprobado', $x12, 2, 'idEstado', 'Nombre', 'core_estado_aprobacion', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idLicitacion', $_GET['edit'], 2);

					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_ValorMensual').style.display = 'none';
							document.getElementById('div_Presupuesto').style.display = 'none';
							//se ejecuta al inicio
							LoadTipoLicitacion(0);
						});

						/**********************************************************************/
						document.getElementById("idTipoLicitacion").onchange = function() {LoadTipoLicitacion(1)};

						/**********************************************************************/
						function LoadTipoLicitacion(caseLoad){
							//obtengo los valores
							let TipoLicitacion = $("#idTipoLicitacion").val();
							//selecciono
							switch(TipoLicitacion) {
								//si es A suma Alzada
								case '1':
									document.getElementById('div_ValorMensual').style.display = '';
									document.getElementById('div_Presupuesto').style.display = 'none';
									//Reseteo los valores a 0
									document.querySelector('input[name="Presupuesto"]').value = '0';
								break;
								//si es Por Itemizado
								case '2':
									document.getElementById('div_ValorMensual').style.display = 'none';
									document.getElementById('div_Presupuesto').style.display = '';
									//Reseteo los valores a 0
									document.querySelector('input[name="ValorMensual"]').value = '0';
								break;
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
	//se crea filtro
	//verifico que sea un administrador
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Contrato</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Codigo)){                $x1  = $Codigo;              }else{$x1  = '';}
					if(isset($Nombre)){                $x2  = $Nombre;              }else{$x2  = '';}
					if(isset($FechaInicio)){           $x3  = $FechaInicio;         }else{$x3  = '';}
					if(isset($FechaTermino)){          $x4  = $FechaTermino;        }else{$x4  = '';}
					if(isset($idTipoLicitacion)){      $x5  = $idTipoLicitacion;    }else{$x5  = '';}
					if(isset($ValorMensual)){          $x6  = $ValorMensual;        }else{$x6  = '';}
					if(isset($Presupuesto)){           $x7  = $Presupuesto;         }else{$x7  = '';}
					if(isset($idBodegaProd)){          $x8  = $idBodegaProd;        }else{$x8  = '';}
					if(isset($idBodegaIns)){           $x9  = $idBodegaIns;         }else{$x9  = '';}
					if(isset($idOpcionItem)){          $x10 = $idOpcionItem;        }else{$x10 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x1, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);
					$Form_Inputs->form_date('Fecha de Inicio Contrato','FechaInicio', $x3, 1);
					$Form_Inputs->form_date('Fecha de Termino Contrato','FechaTermino', $x4, 1);
					$Form_Inputs->form_select('Tipo Contrato','idTipoLicitacion', $x5, 2, 'idTipoLicitacion', 'Nombre', 'core_licitacion_tipos', 0, '', $dbConn);
					$Form_Inputs->form_values('Valor Fijo Mensual', 'ValorMensual', $x6, 1);
					$Form_Inputs->form_values('Presupuesto', 'Presupuesto', $x7, 1);
					$Form_Inputs->form_select('Bodega Productos','idBodegaProd', $x8, 2, 'idBodega', 'Nombre', 'bodegas_productos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Bodega Insumos','idBodegaIns', $x9, 2, 'idBodega', 'Nombre', 'bodegas_insumos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Utilizar Itemizado','idOpcionItem', $x10, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idAprobado', 2, 2);
					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);

					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_ValorMensual').style.display = 'none';
							document.getElementById('div_Presupuesto').style.display = 'none';
						});

						/**********************************************************************/
						document.getElementById("idTipoLicitacion").onchange = function() {LoadTipoLicitacion(1)};

						/**********************************************************************/
						function LoadTipoLicitacion(caseLoad){
							//obtengo los valores
							let TipoLicitacion = $("#idTipoLicitacion").val();
							//selecciono
							switch(TipoLicitacion) {
								//si es A suma Alzada
								case '1':
									document.getElementById('div_ValorMensual').style.display = '';
									document.getElementById('div_Presupuesto').style.display = 'none';
									//Reseteo los valores a 0
									document.querySelector('input[name="Presupuesto"]').value = '0';
								break;
								//si es Por Itemizado
								case '2':
									document.getElementById('div_ValorMensual').style.display = 'none';
									document.getElementById('div_Presupuesto').style.display = '';
									//Reseteo los valores a 0
									document.querySelector('input[name="ValorMensual"]').value = '0';
								break;
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idTipo';
	$SIS_join  = '';
	$SIS_where = 'idCliente = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'clientes_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	licitacion_listado.idLicitacion,
	licitacion_listado.Codigo,
	licitacion_listado.Nombre,
	core_sistemas.Nombre AS sistema,
	core_estados.Nombre AS Estado,
	core_estado_aprobacion.Nombre AS EstadoAprobacion,
	licitacion_listado.idSistema,
	licitacion_listado.idEstado,
	licitacion_listado.idOpcionItem';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema          = licitacion_listado.idSistema
	LEFT JOIN `core_estados`            ON core_estados.idEstado            = licitacion_listado.idEstado
	LEFT JOIN `core_estado_aprobacion`  ON core_estado_aprobacion.idEstado  = licitacion_listado.idAprobado';
	$SIS_where = 'licitacion_listado.idCliente = '.$_GET['id'];
	$SIS_order = 'licitacion_listado.Nombre ASC';
	$arrArea = array();
	$arrArea = db_select_array (false, $SIS_query, 'licitacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArea');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Cliente', $rowData['Nombre'], 'Contratos'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Contrato</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'clientes_contrato_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'clientes_contrato_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'clientes_contrato_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'clientes_contrato_listado_datos_persona_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
							<?php if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
								<li class=""><a href="<?php echo 'clientes_contrato_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
							<li class=""><a href="<?php echo 'clientes_contrato_listado_contratos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Contratos</a></li>
							<li class="active"><a href="<?php echo 'clientes_contrato_listado_maquinas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-industry" aria-hidden="true"></i> Maquinas</a></li>
						</ul>
					</li>
				</ul>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th width="160">Codigo</th>
							<th>Nombre</th>
							<th>Estado</th>
							<th>Estado Aprobacion</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrArea as $area) { ?>
						<tr class="odd">
							<td><?php echo $area['Codigo']; ?></td>
							<td><?php echo $area['Nombre']; ?></td>
							<td><label class="label <?php if(isset($area['idEstado'])&&$area['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $area['Estado']; ?></label></td>
							<td><?php echo $area['EstadoAprobacion']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $area['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 175px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_licitacion.php?view='.simpleEncode($area['idLicitacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$area['idLicitacion']; ?>" title="Editar Contrato" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&status='.$area['idLicitacion']; ?>" title="Editar Estado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-power-off" aria-hidden="true"></i></a><?php } ?>
									<?php if(isset($area['idOpcionItem'])&&$area['idOpcionItem']==1){ ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&itemizado='.$area['idLicitacion']; ?>" title="Editar Itemizado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-server" aria-hidden="true"></i></a><?php } ?>
									<?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $new_location.'&del='.simpleEncode($area['idLicitacion'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el registro '.$area['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
