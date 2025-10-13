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
$original = "licitacion_listado.php";
$location = $original;
$new_location = "licitacion_listado_itemizado.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert_item';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update_item';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
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
if (isset($_GET['created'])){ $error['created'] = 'sucess/Contrato Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Contrato Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Contrato Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
// consulto los datos
$query = "SELECT Nombre,Codigo, idUtilizable, idFrecuencia, Cantidad, TiempoProgramado, idTrabajo, Valor, ValorTotal
FROM `licitacion_listado_level_".$_GET['lvl']."`
WHERE idLevel_".$_GET['lvl']." = ".$_GET['edit'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	 
 
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
				if(isset($Valor)){             $x8  = $Valor;             }else{$x8  = $rowData['Valor'];}
				if(isset($ValorTotal)){        $x9  = $ValorTotal;         }else{$x9  = $rowData['ValorTotal'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 2);
				$Form_Inputs->form_select('Utilizable','idUtilizable', $x3, 2, 'idUtilizable', 'Nombre', 'core_estado_utilizable', 0, '', $dbConn);

				$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x4, 1, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);
				$Form_Inputs->form_input_number('N° Tareas x Contrato', 'Cantidad', $x5, 1);
				$Form_Inputs->form_time('Tiempo Programado','TiempoProgramado', $x6, 1, 1);
				$Form_Inputs->form_select('Tipo Trabajo','idTrabajo', $x7, 1, 'idTrabajo', 'Nombre', 'core_licitacion_trabajos', 0, '', $dbConn);

				$Form_Inputs->form_input_number('Valor', 'Valor', $x8, 1);
				echo '<div class="form-group" id="div_ValorTotal">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Valor Total</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input value="'.$x9.'" type="text" placeholder="Valor Total" class="form-control"  name="Total" id="Total" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('ValorTotal', $x9, 1);
				$Form_Inputs->form_input_hidden('idLevel_'.$_GET['lvl'], $_GET['edit'], 1);
				$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idLicitacion', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);
				  	 
				?> 
				<script>
					//funcion para actualizar el valor total
				document.getElementById("Valor").onkeyup = function() {myFunction()};
				document.getElementById("Cantidad").onkeyup = function() {myFunction()};
				
					function myFunction() {
						let CantIngreso = document.getElementById("Cantidad").value
						let Valor = document.getElementById("Valor").value;
						if (CantIngreso != "" && Valor != "") {
							//escribo dentro del input
							document.getElementById("Total").value      = CantIngreso * Valor;
							document.getElementById("ValorTotal").value = CantIngreso * Valor;
						}
					}

				</script>
				<script>
					document.getElementById('div_idFrecuencia').style.display = 'none';
					document.getElementById('div_Cantidad').style.display = 'none';
					document.getElementById('div_TiempoProgramado').style.display = 'none';
					document.getElementById('div_idTrabajo').style.display = 'none';
					document.getElementById('div_Valor').style.display = 'none';
					document.getElementById('div_ValorTotal').style.display = 'none';

					$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

						let Sensores_val= $("#idUtilizable").val();

						//si es SI
						if(Sensores_val == 1){
							document.getElementById('div_idFrecuencia').style.display = 'none';
							document.getElementById('div_Cantidad').style.display = 'none';
							document.getElementById('div_TiempoProgramado').style.display = 'none';
							document.getElementById('div_idTrabajo').style.display = 'none';
							document.getElementById('div_Valor').style.display = 'none';
							document.getElementById('div_ValorTotal').style.display = 'none';

						//si es NO
						} else if(Sensores_val == 2){
							document.getElementById('div_idFrecuencia').style.display = '';
							document.getElementById('div_Cantidad').style.display = '';
							document.getElementById('div_TiempoProgramado').style.display = '';
							document.getElementById('div_idTrabajo').style.display = '';
							document.getElementById('div_Valor').style.display = '';
							document.getElementById('div_ValorTotal').style.display = '';
						}

					});

					$("#idUtilizable").on("change", function(){ //se ejecuta al cambiar valor del select
						let modelSelected1 = $(this).val(); //Asignamos el valor seleccionado

						//si es SI
						if(modelSelected1 == 1){
							document.getElementById('div_idFrecuencia').style.display = 'none';
							document.getElementById('div_Cantidad').style.display = 'none';
							document.getElementById('div_TiempoProgramado').style.display = 'none';
							document.getElementById('div_idTrabajo').style.display = 'none';
							document.getElementById('div_Valor').style.display = 'none';
							document.getElementById('div_ValorTotal').style.display = 'none';
							//Reseteo los valores a 0
							document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
							document.querySelector('input[name="Cantidad"]').value = '0';
							document.querySelector('input[name="TiempoProgramado"]').value = '0';
							document.querySelector('input[name="idTrabajo"]').selectedIndex = 0;
							document.querySelector('input[name="Valor"]').value = '0';
							document.querySelector('input[name="ValorTotal"]').value = '0';

						//si es NO
						} else if(modelSelected1 == 2){
							document.getElementById('div_idFrecuencia').style.display = '';
							document.getElementById('div_Cantidad').style.display = '';
							document.getElementById('div_TiempoProgramado').style.display = '';
							document.getElementById('div_idTrabajo').style.display = '';
							document.getElementById('div_Valor').style.display = '';
							document.getElementById('div_ValorTotal').style.display = '';

						}
					});

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
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

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
				$Form_Inputs->form_input_number('N° Tareas x Contrato', 'Cantidad', $x5, 1);
				$Form_Inputs->form_time('Tiempo Programado','TiempoProgramado', $x6, 1, 1);
				$Form_Inputs->form_select('Tipo Trabajo','idTrabajo', $x7, 1, 'idTrabajo', 'Nombre', 'core_licitacion_trabajos', 0, '', $dbConn);

				$Form_Inputs->form_input_number('Valor', 'Valor', $x8, 1);
				echo '<div class="form-group" id="div_ValorTotal">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Valor Total</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input value="'.$x9.'" type="text" placeholder="Valor Total" class="form-control"  name="Total" id="Total" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('ValorTotal', $x9, 1);
				$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idLicitacion', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

				?>

				<script>
					//funcion para actualizar el valor total
				document.getElementById("Valor").onkeyup = function() {myFunction()};
				document.getElementById("Cantidad").onkeyup = function() {myFunction()};
				
					function myFunction() {
						var CantIngreso = document.getElementById("Cantidad").value
						var Valor = document.getElementById("Valor").value;
						if (CantIngreso != "" && Valor != "") {
							//escribo dentro del input
							document.getElementById("Total").value      = CantIngreso * Valor;
							document.getElementById("ValorTotal").value = CantIngreso * Valor;
						}
					}

				</script>
				<script>
					document.getElementById('div_idFrecuencia').style.display = 'none';
					document.getElementById('div_Cantidad').style.display = 'none';
					document.getElementById('div_TiempoProgramado').style.display = 'none';
					document.getElementById('div_idTrabajo').style.display = 'none';
					document.getElementById('div_Valor').style.display = 'none';
					document.getElementById('div_ValorTotal').style.display = 'none';

					$("#idUtilizable").on("change", function(){ //se ejecuta al cambiar valor del select
						let modelSelected1 = $(this).val(); //Asignamos el valor seleccionado

						//si es SI
						if(modelSelected1 == 1){
							document.getElementById('div_idFrecuencia').style.display = 'none';
							document.getElementById('div_Cantidad').style.display = 'none';
							document.getElementById('div_TiempoProgramado').style.display = 'none';
							document.getElementById('div_idTrabajo').style.display = 'none';
							document.getElementById('div_Valor').style.display = 'none';
							document.getElementById('div_ValorTotal').style.display = 'none';
							//Reseteo los valores a 0
							document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
							document.querySelector('input[name="Cantidad"]').value = '0';
							document.querySelector('input[name="TiempoProgramado"]').value = '0';
							document.querySelector('input[name="idTrabajo"]').selectedIndex = 0;
							document.querySelector('input[name="Valor"]').value = '0';
							document.querySelector('input[name="ValorTotal"]').value = '0';

						//si es NO
						} else if(modelSelected1 == 2){
							document.getElementById('div_idFrecuencia').style.display = '';
							document.getElementById('div_Cantidad').style.display = '';
							document.getElementById('div_TiempoProgramado').style.display = '';
							document.getElementById('div_idTrabajo').style.display = '';
							document.getElementById('div_Valor').style.display = '';
							document.getElementById('div_ValorTotal').style.display = '';

						}
					});

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
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
// consulto los datos
$query = "SELECT Nombre,idSistema, idOpcionItem
FROM `licitacion_listado`
WHERE idLicitacion = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

//Se crean las variables
$nmax = 15;
$z = '';
$leftjoin = '';
$orderby = '';
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
$query = "SELECT
licitacion_listado_level_1.idLevel_1 AS bla
".$z."
FROM `licitacion_listado_level_1`
".$leftjoin."
WHERE licitacion_listado_level_1.idLicitacion=".$_GET['id']."
ORDER BY licitacion_listado_level_1.Codigo ASC ".$orderby."

";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrLicitacion,$row );
}

// Se trae un listado con todos los tipos de componentes
$arrTipos = array();
$query = "SELECT idUtilizable, Nombre
FROM `core_estado_utilizable`
ORDER BY idUtilizable ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipos,$row );
}
//Se crea el arreglo
$TipoMaq = array();
foreach($arrTipos as $tipo) {
	$TipoMaq[$tipo['idUtilizable']]['idUtilizable']  = $tipo['idUtilizable'];
	$TipoMaq[$tipo['idUtilizable']]['Nombre']        = $tipo['Nombre'];
}
	


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







function arrayToUL(array $array, array $TipoMaq, $lv, $rowlevel,$location, $nmax)
{
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
					echo '<a href="'.$loc.'&edit='.$value['id'].'&lvl='.$lv.'" title="Editar Esta Rama" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
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
							echo '<a href="'.$loc.'&new=true&lvl='.$xc.'" title="Crear sub-Rama" class="btn btn-primary btn-sm tooltip"><i class="fa fa-file-o" aria-hidden="true"></i></a>';
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

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Contrato', $rowData['Nombre'], 'Itemizado'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'].'&new=true&lvl=1'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Rama</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'licitacion_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'licitacion_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'licitacion_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if(isset($rowData['idOpcionItem'])&&$rowData['idOpcionItem']==1){ ?>
							<li class="active"><a href="<?php echo 'licitacion_listado_itemizado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sitemap" aria-hidden="true"></i> Itemizado</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'licitacion_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class=""><a href="<?php echo 'licitacion_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>
					</ul>
				</li> 
                          
			</ul>
		</header>
        <div class="table-responsive">

			<?php //Se imprime el arbol
			echo arrayToUL($array3d, $TipoMaq, 0, $rowlevel['level'],$new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'], $nmax);
			?>

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
