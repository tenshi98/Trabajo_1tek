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
$original = "orden_trabajo_editar.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$_GET['view'];
if(isset($_GET['ter']) && $_GET['ter']!=''){    $location .= "&ter=".$_GET['ter']; 	}

/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se modifican los datos basicos
if (!empty($_POST['submit_editBase'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_ot_list';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se modifican los datos basicos
if (!empty($_POST['submit_editObs'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_ot_list';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_trab'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_addTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edittrab'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_editTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se borra un trabajo
if (!empty($_GET['del_trab'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_delTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un insumo
if (!empty($_POST['submit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_addIns';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se agrega un insumo
if (!empty($_POST['submit_editins'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_editIns';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se elimina un insumo
if (!empty($_GET['del_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_delIns';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un producto
if (!empty($_POST['submit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_addProd';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se agrega un producto
if (!empty($_POST['submit_editprod'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_editProd';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se elimina un producto
if (!empty($_GET['del_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_delProd';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se elimina un subcomponente
if (!empty($_GET['del_tarea_row'])){
	//Llamamos al formulario
	$form_trabajo= 'del_tarea_row';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un componente
if (!empty($_POST['submit_itemizado_row'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_itemizado_row';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un producto
if (!empty($_POST['submit_producto_row'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_producto_row';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
/*************************************************************************/
//se agrega un subcomponente
if (!empty($_POST['submit_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_tarea_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se elimina un subcomponente
if (!empty($_GET['del_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'del_tarea_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se elimina un subcomponente
if (!empty($_GET['aproTrab'])){
	//Llamamos al formulario
	$form_trabajo= 'aprobar_trabajo';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un componente
if (!empty($_POST['submit_itemizado'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_itemizado_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un producto
if (!empty($_POST['submit_producto'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_producto_edit';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
/*************************************************************************/
//se agrega un producto
if (!empty($_POST['submit_editTrabajo'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_editTrabajo';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se cierra la OT
if (!empty($_GET['cerrar_ot'])){
	//Llamamos al formulario
	$form_trabajo= 'cerrar_ot';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['edited'])){     $error['edited']     = 'sucess/Datos editados correctamente';}
if (isset($_GET['addtrab'])){    $error['addtrab']    = 'sucess/Trabajador agregado correctamente';}
if (isset($_GET['edittrab'])){   $error['edittrab']   = 'sucess/Trabajador Modificado correctamente';}
if (isset($_GET['deltrab'])){    $error['deltrab']    = 'sucess/Trabajador Borrado correctamente';}
if (isset($_GET['addins'])){     $error['addins']     = 'sucess/Insumo agregado correctamente';}
if (isset($_GET['editins'])){    $error['editins']    = 'sucess/Insumo Modificado correctamente';}
if (isset($_GET['delins'])){     $error['delins']     = 'sucess/Insumo Borrado correctamente';}
if (isset($_GET['addprod'])){    $error['addprod']    = 'sucess/Producto agregado correctamente';}
if (isset($_GET['editprod'])){   $error['editprod']   = 'sucess/Producto Modificado correctamente';}
if (isset($_GET['delprod'])){    $error['delprod']    = 'sucess/Producto Borrado correctamente';}
if (isset($_GET['addtarea'])){   $error['addtarea']   = 'sucess/Tarea agregada correctamente';}
if (isset($_GET['edittarea'])){  $error['edittarea']  = 'sucess/Tarea Modificada correctamente';}
if (isset($_GET['deltarea'])){   $error['deltarea']   = 'sucess/Tarea Borrada correctamente';}

//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['editobservacion_row'])){
//Se traen los datos de la ot
$query = "SELECT Observacion
FROM `orden_trabajo_listado_trabajos`
WHERE idTrabajoOT = ".$_GET['idInterno'];
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
			<h5>Modificar Observacion del trabajo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Observacion)){    $x1  = $Observacion;    }else{$x1  = $rowData['Observacion'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_textarea('Observaciones','Observacion', $x1, 2);

				$Form_Inputs->form_input_hidden('idInterno', $_GET['idInterno'], 2);
				$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_editTrabajo">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editanalisis_row'])){
//Se traen los datos de la ot
$query = "SELECT idAnalisis
FROM `orden_trabajo_listado_trabajos`
WHERE idTrabajoOT = ".$_GET['idInterno'];
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
			<h5>Modificar analisis del trabajo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idAnalisis)){    $x1  = $idAnalisis;    }else{$x1  = $rowData['idAnalisis'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('N° Analisis','idAnalisis', $x1, 2);

				$Form_Inputs->form_input_hidden('idInterno', $_GET['idInterno'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_editTrabajo">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editproducto'])){
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
			<h5>Editar Productos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
        		
				<?php
				//Se verifican si existen los datos
				if(isset($idSubTipo)){            $x1 = $idSubTipo;              }else{$x1 = $_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['idSubTipo'];}
				if(isset($idProducto)){           $x2 = $idProducto;             }else{$x2 = $_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['idProducto'];}
				if(isset($Grasa_inicial)){        $x3 = $Grasa_inicial;          }else{$x3 = Cantidades_decimales_justos($_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Grasa_inicial']);}
				if(isset($Grasa_relubricacion)){  $x4 = $Grasa_relubricacion;    }else{$x4 = Cantidades_decimales_justos($_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Grasa_relubricacion']);}
				if(isset($Aceite)){               $x5 = $Aceite;                 }else{$x5 = Cantidades_decimales_justos($_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Aceite']);}
				if(isset($Cantidad)){             $x6 = $Cantidad;               }else{$x6 = Cantidades_decimales_justos($_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Cantidad']);}
				if(isset($idUml_fake)){           $x7 = $idUml_fake;             }else{$x7 = $_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Unimed'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend1('Tareas Relacionadas','idSubTipo', $x1, 2, 'idSubTipo', 'Nombre', 'core_maquinas_tipo', 0, 0,
										 'Producto utilizado','idProducto', $x2, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_number('Grasa inicial','Grasa_inicial', $x3, 2);
				$Form_Inputs->form_input_number('Grasa relubricacion','Grasa_relubricacion', $x4, 2);
				$Form_Inputs->form_input_number('Cantidad de Aceite','Aceite', $x5, 2);
				$Form_Inputs->form_input_number('Cantidad a consumir','Cantidad', $x6, 2);
				$Form_Inputs->form_input_disabled('Unidad de Medida','idUml_fake',  $x7);

					
				$Form_Inputs->form_input_hidden('tabla', $_GET['tabla'], 2);
				$Form_Inputs->form_input_hidden('id_tabla', $_GET['id_tabla'], 2);
				$Form_Inputs->form_input_hidden('idInterno', $_GET['idInterno'], 2);
				$Form_Inputs->form_input_hidden('idUml', $_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['idUml'], 2);

				/***********************************************************************/
				//Imprimo las variables
				$arrTipo = array();
				$query = "SELECT 
				productos_listado.idProducto,
				sistema_productos_uml.Nombre AS Unimed,
				productos_listado.idUml
				FROM `productos_listado`
				LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml
				WHERE ".$zx1."
				ORDER BY sistema_productos_uml.Nombre";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if(!$resultado){
					//Genero numero aleatorio
					$vardata = genera_password(8,'alfanumerico');
									
					//Guardo el error en una variable temporal
					
					
					
									
				}
				while ( $row = mysqli_fetch_assoc ($resultado)){
				array_push( $arrTipo,$row );
				}

				?>

				<script>
					/**********************************************************************/
					<?php
					foreach ($arrTipo as $tipo) {
						echo '
						let id_data1_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";
						let id_data2_'.$tipo['idProducto'].'= "'.$tipo['idUml'].'";
						';
					}
					?>
					/**********************************************************************/
					$(document).ready(function(){
						document.getElementById('div_Grasa_inicial').style.display = 'none';
						document.getElementById('div_Grasa_relubricacion').style.display = 'none';
						document.getElementById('div_Aceite').style.display = 'none';
						document.getElementById('div_Cantidad').style.display = 'none';
						document.getElementById('div_idProducto').style.display = '';
						//cargo al inicio
						LoadProducto();
						LoadSubTipo(0);
					});

					/**********************************************************************/
					document.getElementById("idProducto").onchange = function() {LoadProducto()};
					document.getElementById("idSubTipo").onchange = function() {LoadSubTipo(1)};

					/**********************************************************************/
					function LoadProducto(){
						let Componente = document.getElementById("idProducto").value;
						if (Componente != "") {
							//escribo dentro del input
							document.getElementById("idUml_fake").value = eval("id_data1_" + Componente);
							document.getElementById("idUml").value      = eval("id_data2_" + Componente);
						}
					}

					/**********************************************************************/
					function LoadSubTipo(caseLoad){
						//obtengo valor
						let Sensores_val_2= $("#idSubTipo").val();
						//si es grasa
						switch(Sensores_val_2) {
							//Errores Conjuntos
							case '1':
								document.getElementById('div_Grasa_inicial').style.display = '';
								document.getElementById('div_Grasa_relubricacion').style.display = '';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idProducto').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
								}
							break;
							//si es aceite
							case '2':
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = '';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idProducto').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
								}
							break;
							//si es normal
							case '3':
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = '';
								document.getElementById('div_idProducto').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
								}
							break;
							//si es otro
							case '4':
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idProducto').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
								}
							break;
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_producto">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addItemizado'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Itemizado</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>
        		
				<?php
				//variables
				$tablamad = $_GET['addItemizado'] + 1;
				//Se verifican si existen los datos
				if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Itemizado','idItemizado', $x1, 1, 'idLevel_'.$tablamad, 'Nombre', 'licitacion_listado_level_'.$tablamad, 'idLevel_'.$_GET['addItemizado'].'='.$_GET['lvl'], '', $dbConn);

				$Form_Inputs->form_input_hidden('tabla', $_GET['tabla'], 2);
				$Form_Inputs->form_input_hidden('id_tabla', $_GET['id_tabla'], 2);
				$Form_Inputs->form_input_hidden('idInterno', $_GET['idInterno'], 2);
				$Form_Inputs->form_input_hidden('tablaitem', $tablamad, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_itemizado">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addtrabajo'])){
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = 'idMaquina';
	$SIS_join  = '';
	$SIS_where = 'idOT ='.$idOT;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	//Verifico el tipo de usuario que esta ingresando
	$z="idMaquina=".$rowData['idMaquina'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Tarea</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idLevel_1)){        $x1  = $idLevel_1;        }else{$x1  = '';}
					if(isset($idLevel_2)){        $x2  = $idLevel_2;        }else{$x2  = '';}
					if(isset($idLevel_3)){        $x3  = $idLevel_3;        }else{$x3  = '';}
					if(isset($idLevel_4)){        $x4  = $idLevel_4;        }else{$x4  = '';}
					if(isset($idLevel_5)){        $x5  = $idLevel_5;        }else{$x5  = '';}
					if(isset($idLevel_6)){        $x6  = $idLevel_6;        }else{$x6  = '';}
					if(isset($idLevel_7)){        $x7  = $idLevel_7;        }else{$x7  = '';}
					if(isset($idLevel_8)){        $x8  = $idLevel_8;        }else{$x8  = '';}
					if(isset($idLevel_9)){        $x9  = $idLevel_9;        }else{$x9  = '';}
					if(isset($idLevel_10)){       $x10  = $idLevel_10;      }else{$x10  = '';}
					if(isset($idLevel_11)){       $x11  = $idLevel_11;      }else{$x11  = '';}
					if(isset($idLevel_12)){       $x12  = $idLevel_12;      }else{$x12  = '';}
					if(isset($idLevel_13)){       $x13  = $idLevel_13;      }else{$x13  = '';}
					if(isset($idLevel_14)){       $x14  = $idLevel_14;      }else{$x14  = '';}
					if(isset($idLevel_15)){       $x15  = $idLevel_15;      }else{$x15  = '';}
					if(isset($idLevel_16)){       $x16  = $idLevel_16;      }else{$x16  = '';}
					if(isset($idLevel_17)){       $x17  = $idLevel_17;      }else{$x17  = '';}
					if(isset($idLevel_18)){       $x18  = $idLevel_18;      }else{$x18  = '';}
					if(isset($idLevel_19)){       $x19  = $idLevel_19;      }else{$x19  = '';}
					if(isset($idLevel_20)){       $x20  = $idLevel_20;      }else{$x20  = '';}
					if(isset($idLevel_21)){       $x21  = $idLevel_21;      }else{$x21  = '';}
					if(isset($idLevel_22)){       $x22  = $idLevel_22;      }else{$x22  = '';}
					if(isset($idLevel_23)){       $x23  = $idLevel_23;      }else{$x23  = '';}
					if(isset($idLevel_24)){       $x24  = $idLevel_24;      }else{$x24  = '';}
					if(isset($idLevel_25)){       $x25  = $idLevel_25;      }else{$x25  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_depend25('Nivel 1','idLevel_1',$x1 ,1,'idLevel_1','Nombre','maquinas_listado_level_1',$z,0,
											'Nivel 2','idLevel_2',$x2 ,1,'idLevel_2','Nombre','maquinas_listado_level_2',0,0,
											'Nivel 3','idLevel_3',$x3 ,1,'idLevel_3','Nombre','maquinas_listado_level_3',0,0,
											'Nivel 4','idLevel_4',$x4 ,1,'idLevel_4','Nombre','maquinas_listado_level_4',0,0,
											'Nivel 5','idLevel_5',$x5 ,1,'idLevel_5','Nombre','maquinas_listado_level_5',0,0,
											'Nivel 6','idLevel_6',$x6 ,1,'idLevel_6','Nombre','maquinas_listado_level_6',0,0,
											'Nivel 7','idLevel_7',$x7 ,1,'idLevel_7','Nombre','maquinas_listado_level_7',0,0,
											'Nivel 8','idLevel_8',$x8 ,1,'idLevel_8','Nombre','maquinas_listado_level_8',0,0,
											'Nivel 9','idLevel_9',$x9 ,1,'idLevel_9','Nombre','maquinas_listado_level_9',0,0,
											'Nivel 10','idLevel_10',$x10 ,1,'idLevel_10','Nombre','maquinas_listado_level_10',0,0,
											'Nivel 11','idLevel_11',$x11 ,1,'idLevel_11','Nombre','maquinas_listado_level_11',0,0,
											'Nivel 12','idLevel_12',$x12 ,1,'idLevel_12','Nombre','maquinas_listado_level_12',0,0,
											'Nivel 13','idLevel_13',$x13 ,1,'idLevel_13','Nombre','maquinas_listado_level_13',0,0,
											'Nivel 14','idLevel_14',$x14 ,1,'idLevel_14','Nombre','maquinas_listado_level_14',0,0,
											'Nivel 15','idLevel_15',$x15 ,1,'idLevel_15','Nombre','maquinas_listado_level_15',0,0,
											'Nivel 16','idLevel_16',$x16 ,1,'idLevel_16','Nombre','maquinas_listado_level_16',0,0,
											'Nivel 17','idLevel_17',$x17 ,1,'idLevel_17','Nombre','maquinas_listado_level_17',0,0,
											'Nivel 18','idLevel_18',$x18 ,1,'idLevel_18','Nombre','maquinas_listado_level_18',0,0,
											'Nivel 19','idLevel_19',$x19 ,1,'idLevel_19','Nombre','maquinas_listado_level_19',0,0,
											'Nivel 20','idLevel_20',$x20 ,1,'idLevel_20','Nombre','maquinas_listado_level_20',0,0,
											'Nivel 21','idLevel_21',$x21 ,1,'idLevel_21','Nombre','maquinas_listado_level_21',0,0,
											'Nivel 22','idLevel_22',$x22 ,1,'idLevel_22','Nombre','maquinas_listado_level_22',0,0,
											'Nivel 23','idLevel_23',$x23 ,1,'idLevel_23','Nombre','maquinas_listado_level_23',0,0,
											'Nivel 24','idLevel_24',$x24 ,1,'idLevel_24','Nombre','maquinas_listado_level_24',0,0,
											'Nivel 25','idLevel_24',$x24 ,1,'idLevel_24','Nombre','maquinas_listado_level_24',0,0,
											$dbConn, 'form1');


					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_tarea">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editproducto_row'])){
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = '
	orden_trabajo_listado_trabajos.idSubTipo,
	orden_trabajo_listado_trabajos.idProducto,
	orden_trabajo_listado_trabajos.Grasa_inicial,
	orden_trabajo_listado_trabajos.Grasa_relubricacion,
	orden_trabajo_listado_trabajos.Aceite,
	orden_trabajo_listado_trabajos.Cantidad,
	orden_trabajo_listado_trabajos.idUml,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = orden_trabajo_listado_trabajos.idUml';
	$SIS_where = 'orden_trabajo_listado_trabajos.idTrabajoOT ='.$_GET['idInterno'];
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado_trabajos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	//filtro
	$zx1 = "idProducto=0";
	//Se revisan los permisos a los productos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//Recorro
	foreach ($arrPermisos as $prod) {
		$zx1 .= ' OR (idEstado=1 AND idProducto='.$prod['idProducto'].' AND idSubTipo='.$rowData['idSubTipo'].')';
	}

	//Obtengo unidades de medida
	$SIS_query = '
	productos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed,
	productos_listado.idUml';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = $zx1;
	$SIS_order = 'sistema_productos_uml.Nombre';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Productos</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idSubTipo)){            $x1 = $idSubTipo;              }else{$x1 = $rowData['idSubTipo'];}
					if(isset($idProducto)){           $x2 = $idProducto;             }else{$x2 = $rowData['idProducto'];}
					if(isset($Grasa_inicial)){        $x3 = $Grasa_inicial;          }else{$x3 = Cantidades_decimales_justos($rowData['Grasa_inicial']);}
					if(isset($Grasa_relubricacion)){  $x4 = $Grasa_relubricacion;    }else{$x4 = Cantidades_decimales_justos($rowData['Grasa_relubricacion']);}
					if(isset($Aceite)){               $x5 = $Aceite;                 }else{$x5 = Cantidades_decimales_justos($rowData['Aceite']);}
					if(isset($Cantidad)){             $x6 = $Cantidad;               }else{$x6 = Cantidades_decimales_justos($rowData['Cantidad']);}
					if(isset($idUml_fake)){           $x7 = $idUml_fake;             }else{$x7 = $rowData['Unimed'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Producto utilizado','idProducto', $x2, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);

					//Se ejecuta si se hace un cambio en el tipo de tarea
					switch ($rowData['idSubTipo']) {
						case 1: //Grasa
							$Form_Inputs->form_input_number('Grasa inicial','Grasa_inicial', $x3, 2);
							$Form_Inputs->form_input_number('Grasa relubricacion','Grasa_relubricacion', $x4, 2);
						break;

						case 2: //Aceite
							$Form_Inputs->form_input_number('Cantidad de Aceite','Aceite', $x5, 2);
						break;

						case 3: //Normal
							$Form_Inputs->form_input_number('Cantidad a consumir','Cantidad', $x6, 2);
						break;

						case 4: //Otro
							$Form_Inputs->form_input_disabled('Unidad de Medida','idUml_fake',  $x7);
						break;
					}

					$Form_Inputs->form_input_hidden('tabla', $_GET['tabla'], 2);
					$Form_Inputs->form_input_hidden('id_tabla', $_GET['id_tabla'], 2);
					$Form_Inputs->form_input_hidden('idInterno', $_GET['idInterno'], 2);
					$Form_Inputs->form_input_hidden('idUml', $rowData['idUml'], 2);

					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo '
							let id_data1_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";
							let id_data2_'.$tipo['idProducto'].'= "'.$tipo['idUml'].'";
							';
						}
						?>

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("idUml_fake").value = eval("id_data1_" + Componente);
								document.getElementById("idUml").value      = eval("id_data2_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_producto_row">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addItemizado_row'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Itemizado</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//variables
					$tablamad = $_GET['addItemizado_row'] + 1;
					//Se verifican si existen los datos
					if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Itemizado','idItemizado', $x1, 1, 'idLevel_'.$tablamad, 'Nombre', 'licitacion_listado_level_'.$tablamad, 'idLevel_'.$_GET['addItemizado_row'].'='.$_GET['lvl'], '', $dbConn);

					$Form_Inputs->form_input_hidden('tabla', $_GET['tabla'], 2);
					$Form_Inputs->form_input_hidden('id_tabla', $_GET['id_tabla'], 2);
					$Form_Inputs->form_input_hidden('idInterno', $_GET['idInterno'], 2);
					$Form_Inputs->form_input_hidden('tablaitem', $tablamad, 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_itemizado_row">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addProd'])){
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = 'idSistema, idMaquina, idEstado, idPrioridad, idTipo, f_programacion';
	$SIS_join  = '';
	$SIS_where = 'orden_trabajo_listado.idOT ='.$idOT;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	//Obtengo unidades de medida
	$SIS_query = '
	productos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'sistema_productos_uml.Nombre';
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

	//filtro
	$zx1 = "idProducto=0";
	//Se revisan los permisos a los productos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//Recorro
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

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

					echo '<div class="form-group" id="div_">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
						</div>
					</div>';

					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $rowData['idMaquina'], 2);
					$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
					$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
					$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
					$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);

					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrUnimed as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme").value = eval("id_data_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_prod">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_prod'])){
	//Variables
	$idOT        = simpleDecode($_GET['view'], fecha_actual());
	$idProductos = simpleDecode($_GET['edit_prod'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = '
	orden_trabajo_listado_productos.idProducto,
	orden_trabajo_listado_productos.Cantidad,
	sistema_productos_uml.Nombre AS Unidad';
	$SIS_join  = '
	LEFT JOIN `productos_listado`       ON productos_listado.idProducto  = orden_trabajo_listado_productos.idProducto
	LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = productos_listado.idUml';
	$SIS_where = 'orden_trabajo_listado_productos.idProductos ='.$idProductos;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado_productos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	//Obtengo unidades de medida
	$SIS_query = '
	productos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

	//filtro
	$zx1 = "idProducto=0";
	//Se revisan los permisos a los productos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//Recorro
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Productos</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $rowData['idProducto'];}
					if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = $rowData['Cantidad'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

					echo '<div class="form-group" id="div_">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="text" value="'.$rowData['Unidad'].'" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
						</div>
					</div>';

					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
					$Form_Inputs->form_input_hidden('idProductos', $idProductos, 2);

					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrUnimed as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme").value = eval("id_data_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Editar" name="submit_editprod">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addIns'])){
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = 'idSistema, idMaquina, idEstado, idPrioridad, idTipo, f_programacion';
	$SIS_join  = '';
	$SIS_where = 'orden_trabajo_listado.idOT ='.$idOT;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	//Obtengo unidades de medida
	$SIS_query = '
	insumos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

	//filtro
	$zx1 = "idProducto=0";
	//Se revisan los permisos a los productos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//Recorro
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
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

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

					echo '<div class="form-group" id="div_">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
						</div>
					</div>';

					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $rowData['idMaquina'], 2);
					$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
					$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
					$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
					$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);

					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrUnimed as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme").value = eval("id_data_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_ins">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_ins'])){
	//Variables
	$idOT      = simpleDecode($_GET['view'], fecha_actual());
	$idInsumos = simpleDecode($_GET['edit_ins'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = '
	orden_trabajo_listado_insumos.idProducto,
	orden_trabajo_listado_insumos.Cantidad,
	sistema_productos_uml.Nombre AS Unidad';
	$SIS_join  = '
	LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto  = orden_trabajo_listado_insumos.idProducto
	LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml = insumos_listado.idUml';
	$SIS_where = 'orden_trabajo_listado_insumos.idInsumos ='.$idInsumos;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado_insumos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	//Obtengo unidades de medida
	$SIS_query = '
	insumos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

	//filtro
	$zx1 = "idProducto=0";
	//Se revisan los permisos a los productos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'idProducto ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
	//Recorro
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Insumos</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $rowData['idProducto'];}
					if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = $rowData['Cantidad'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

					echo '<div class="form-group" id="div_">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="text" value="'.$rowData['Unidad'].'" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
						</div>
					</div>';

					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
					$Form_Inputs->form_input_hidden('idInsumos', $idInsumos, 2);

					?>

					<script>
						/**********************************************************************/
						<?php
						foreach ($arrUnimed as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme").value = eval("id_data_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Editar" name="submit_editins">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addTrab'])){
	//Verifico el tipo de usuario que esta ingresando
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = 'idSistema, idMaquina, idEstado, idPrioridad, idTipo, f_programacion';
	$SIS_join  = '';
	$SIS_where = 'orden_trabajo_listado.idOT ='.$idOT;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

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

					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idSistema', $rowData['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $rowData['idMaquina'], 2);
					$Form_Inputs->form_input_hidden('idEstado', $rowData['idEstado'], 2);
					$Form_Inputs->form_input_hidden('idPrioridad', $rowData['idPrioridad'], 2);
					$Form_Inputs->form_input_hidden('idTipo', $rowData['idTipo'], 2);
					$Form_Inputs->form_input_hidden('f_programacion', $rowData['f_programacion'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_trab">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_trab'])){
	//Verifico el tipo de usuario que esta ingresando
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Variables
	$idOT          = simpleDecode($_GET['view'], fecha_actual());
	$idResponsable = simpleDecode($_GET['edit_trab'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = 'idTrabajador';
	$SIS_join  = '';
	$SIS_where = 'idResponsable ='.$idResponsable;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado_responsable', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Trabajador</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTrabajador)){     $x1  = $idTrabajador;    }else{$x1  = $rowData['idTrabajador'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Trabajador responsable','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);

					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
					$Form_Inputs->form_input_hidden('idResponsable', $idResponsable, 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Editar" name="submit_edittrab">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_obs'])){
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = 'Observaciones';
	$SIS_join  = '';
	$SIS_where = 'orden_trabajo_listado.idOT ='.$idOT;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar datos basicos de la OT</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Observaciones)){    $x1  = $Observaciones;    }else{$x1  = $rowData['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Observacion','Observaciones', $x1, 1);

					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_editObs">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());
	//Se traen los datos de la ot
	$SIS_query = 'idEstado, idPrioridad, idTipo, f_programacion, idSistema,f_termino,horaInicio,
	horaTermino,horaProg, idSupervisor';
	$SIS_join  = '';
	$SIS_where = 'orden_trabajo_listado.idOT ='.$idOT;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar datos basicos de la OT</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idPrioridad)){      $x1  = $idPrioridad;      }else{$x1  = $rowData['idPrioridad'];}
					if(isset($idTipo)){           $x2  = $idTipo;           }else{$x2  = $rowData['idTipo'];}
					if(isset($f_programacion)){   $x3  = $f_programacion;   }else{$x3  = $rowData['f_programacion'];}
					if(isset($f_termino)){        $x4  = $f_termino;        }else{$x4  = $rowData['f_termino'];}
					if(isset($horaInicio)){       $x5  = $horaInicio;       }else{$x5  = $rowData['horaInicio'];}
					if(isset($horaTermino)){      $x6  = $horaTermino;      }else{$x6  = $rowData['horaTermino'];}
					if(isset($horaProg)){         $x7  = $horaProg;         }else{$x7  = $rowData['horaProg'];}
					if(isset($idSupervisor)){     $x9  = $idSupervisor;     }else{$x9  = $rowData['idSupervisor'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Prioridad','idPrioridad', $x1, 2, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Trabajo','idTipo', $x2, 2, 'idTipo', 'Nombre', 'core_ot_tipos', 0, '', $dbConn);
					$Form_Inputs->form_date('Fecha Programada','f_programacion', $x3, 2);

					//Si la OT solo esta programada
					if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){
						if(isset($_GET['ter'])&&$_GET['ter']!=''&&$_GET['ter']=='true'){
							$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 2);
							$Form_Inputs->form_select_filter('Supervisor','idSupervisor', $x9, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);
							$Form_Inputs->form_time('Hora inicio','horaInicio', $x5, 2, 1);
							$Form_Inputs->form_time('Hora termino','horaTermino', $x6, 2, 1);
							//$Form_Inputs->form_time('Tiempo Programado','horaProg', $x7, 2, 1);
						}
					//Si la OT esta terminada
					}elseif(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==2){
						$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 2);
						$Form_Inputs->form_select_filter('Supervisor','idSupervisor', $x9, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);
						$Form_Inputs->form_time('Hora inicio','horaInicio', $x5, 2, 1);
						$Form_Inputs->form_time('Hora termino','horaTermino', $x6, 2, 1);
						$Form_Inputs->form_time('Tiempo Programado','horaProg', $x7, 2, 1);
					}

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idOT', $idOT, 2);

					?>
					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_editBase">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
	//Variables
	$idOT = simpleDecode($_GET['view'], fecha_actual());

	// Se trae un listado con todos los elementos
	$SIS_query = '
	orden_trabajo_listado.idOT,
	orden_trabajo_listado.f_creacion,
	orden_trabajo_listado.f_programacion,
	orden_trabajo_listado.f_termino,
	orden_trabajo_listado.horaProg,
	orden_trabajo_listado.horaInicio,
	orden_trabajo_listado.horaTermino,
	orden_trabajo_listado.Observaciones,
	orden_trabajo_listado.idEstado,
	maquinas_listado.Nombre AS NombreMaquina,
	core_estado_ot.Nombre AS NombreEstado,
	core_ot_prioridad.Nombre AS NombrePrioridad,
	core_ot_tipos.Nombre AS NombreTipo,
	orden_trabajo_listado.idSupervisor,
	trabajadores_listado.Nombre AS NombreTrab,
	trabajadores_listado.ApellidoPat,
	clientes_listado.Nombre AS NombreCliente';
	$SIS_join  = '
	LEFT JOIN `maquinas_listado`           ON maquinas_listado.idMaquina            = orden_trabajo_listado.idMaquina
	LEFT JOIN `core_estado_ot`             ON core_estado_ot.idEstado               = orden_trabajo_listado.idEstado
	LEFT JOIN `core_ot_prioridad`          ON core_ot_prioridad.idPrioridad         = orden_trabajo_listado.idPrioridad
	LEFT JOIN `core_ot_tipos`              ON core_ot_tipos.idTipo                  = orden_trabajo_listado.idTipo
	LEFT JOIN `trabajadores_listado`       ON trabajadores_listado.idTrabajador     = orden_trabajo_listado.idSupervisor
	LEFT JOIN `clientes_listado`           ON clientes_listado.idCliente            = orden_trabajo_listado.idCliente';
	$SIS_where = 'orden_trabajo_listado.idOT ='.$idOT;
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	/***************************************************/
	//Se traen a todos los trabajadores relacionados a las ot
	$SIS_query = '
	orden_trabajo_listado_responsable.idResponsable,
	trabajadores_listado.Nombre,
	trabajadores_listado.ApellidoPat,
	trabajadores_listado.ApellidoMat,
	trabajadores_listado.Cargo,
	trabajadores_listado.Rut';
	$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = orden_trabajo_listado_responsable.idTrabajador';
	$SIS_where = 'orden_trabajo_listado_responsable.idOT ='.$idOT;
	$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
	$arrTrabajadores = array();
	$arrTrabajadores = db_select_array (false, $SIS_query, 'orden_trabajo_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajadores');

	//Si la OT solo esta programada
	if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){

		/***************************************************/
		// Se trae un listado con todos los insumos utilizados
		$SIS_query = '
		orden_trabajo_listado_insumos.idInsumos AS idMain,
		insumos_listado.Nombre AS NombreProducto,
		sistema_productos_uml.Nombre AS UnidadMedida,
		orden_trabajo_listado_insumos.Cantidad';
		$SIS_join  = '
		LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto    = orden_trabajo_listado_insumos.idProducto
		LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = insumos_listado.idUml';
		$SIS_where = 'orden_trabajo_listado_insumos.idOT ='.$idOT;
		$SIS_order = 'insumos_listado.Nombre ASC';
		$arrInsumos = array();
		$arrInsumos = db_select_array (false, $SIS_query, 'orden_trabajo_listado_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

		/***************************************************/
		// Se trae un listado con todos los productos utilizados
		$SIS_query = '
		orden_trabajo_listado_productos.idProductos AS idMain,
		productos_listado.Nombre AS NombreProducto,
		sistema_productos_uml.Nombre AS UnidadMedida,
		orden_trabajo_listado_productos.Cantidad AS Cantidad';
		$SIS_join  = '
		LEFT JOIN `productos_listado`       ON productos_listado.idProducto    = orden_trabajo_listado_productos.idProducto
		LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml     = productos_listado.idUml';
		$SIS_where = 'orden_trabajo_listado_productos.idOT ='.$idOT;
		$SIS_order = 'productos_listado.Nombre ASC';
		$arrProductos = array();
		$arrProductos = db_select_array (false, $SIS_query, 'orden_trabajo_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

	//Si ya esta ejecutada
	}else{

		/***************************************************/
		// Se trae un listado con todos los insumos utilizados
		$SIS_query = '
		insumos_listado.Nombre AS NombreProducto,
		sistema_productos_uml.Nombre AS UnidadMedida,
		bodegas_insumos_facturacion_existencias.Cantidad_eg AS Cantidad,
		bodegas_insumos_listado.Nombre AS NombreBodega';
		$SIS_join  = '
		LEFT JOIN `insumos_listado`            ON insumos_listado.idProducto           = bodegas_insumos_facturacion_existencias.idProducto
		LEFT JOIN `sistema_productos_uml`      ON sistema_productos_uml.idUml          = insumos_listado.idUml
		LEFT JOIN `bodegas_insumos_listado`    ON bodegas_insumos_listado.idBodega     = bodegas_insumos_facturacion_existencias.idBodega';
		$SIS_where = 'bodegas_insumos_facturacion_existencias.idOT ='.$idOT;
		$SIS_order = 'insumos_listado.Nombre ASC';
		$arrInsumos = array();
		$arrInsumos = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

		/***************************************************/
		// Se trae un listado con todos los productos utilizados
		$SIS_query = '
		productos_listado.Nombre AS NombreProducto,
		sistema_productos_uml.Nombre AS UnidadMedida,
		bodegas_productos_facturacion_existencias.Cantidad_eg AS Cantidad,
		bodegas_productos_listado.Nombre AS NombreBodega';
		$SIS_join  = '
		LEFT JOIN `productos_listado`            ON productos_listado.idProducto           = bodegas_productos_facturacion_existencias.idProducto
		LEFT JOIN `sistema_productos_uml`        ON sistema_productos_uml.idUml            = productos_listado.idUml
		LEFT JOIN `bodegas_productos_listado`    ON bodegas_productos_listado.idBodega     = bodegas_productos_facturacion_existencias.idBodega';
		$SIS_where = 'bodegas_productos_facturacion_existencias.idOT ='.$idOT;
		$SIS_order = 'productos_listado.Nombre ASC';
		$arrProductos = array();
		$arrProductos = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

	}

	/***************************************************/
	// Se trae un listado con todos los trabajos relacionados a la orden
	$SIS_query = '
	orden_trabajo_listado_trabajos.NombreComponente,
	orden_trabajo_listado_trabajos.NombreTrabajo,
	orden_trabajo_listado_trabajos.idSubTipo,
	orden_trabajo_listado_trabajos.Grasa_inicial,
	orden_trabajo_listado_trabajos.Grasa_relubricacion,
	orden_trabajo_listado_trabajos.Aceite,
	orden_trabajo_listado_trabajos.Cantidad,
	orden_trabajo_listado_trabajos.idTrabajo,
	orden_trabajo_listado_trabajos.Observacion,
	orden_trabajo_listado_trabajos.idAnalisis,
	orden_trabajo_listado_trabajos.idTrabajoOT,
	orden_trabajo_listado_trabajos.comp_tabla_id,
	orden_trabajo_listado_trabajos.comp_tabla,
	orden_trabajo_listado_trabajos.item_m_tabla_id,
	orden_trabajo_listado_trabajos.item_m_tabla,
	productos_listado.Nombre AS NombreProducto,
	sistema_productos_uml.Nombre AS NombreUnidad';
	$SIS_join  = '
	LEFT JOIN `productos_listado`      ON productos_listado.idProducto  = orden_trabajo_listado_trabajos.idProducto
	LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml   = orden_trabajo_listado_trabajos.idUml';
	$SIS_where = 'orden_trabajo_listado_trabajos.idOT ='.$idOT;
	$SIS_order = 'NombreComponente ASC, NombreTrabajo ASC, idTrabajoOT ASC';
	$arrTrabajo = array();
	$arrTrabajo = db_select_array (false, $SIS_query, 'orden_trabajo_listado_trabajos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajo');

	?>

	<?php if(isset($_GET['ter'])&&$_GET['ter']!=''){ ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >

			<?php
			$ubicacion = $location.'&cerrar_ot=true';
			$dialogo   = '¿Desea cerrar el documento?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary pull-right margin_form_btn"><i class="fa fa-check-square-o" aria-hidden="true"></i> Cerrar Documento</a>

			<div class="clearfix"></div>
		</div>
	<?php } ?>

	<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive">
		<div id="page-wrap">
			<div id="header"> ORDEN DE TRABAJO N° <?php echo n_doc($_GET['view'], 8); ?></div>

			<div id="customer">

				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>
						<?php if(isset($rowData['NombreCliente'])&&$rowData['NombreCliente']!=''){ ?>
							<tr>
								<td class="meta-head">Cliente</td>
								<td><?php echo $rowData['NombreCliente'] ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td class="meta-head">Maquina</td>
							<td><?php echo $rowData['NombreMaquina']?></td>
						</tr>
						<tr>
							<td class="meta-head">Prioridad</td>
							<td><?php echo $rowData['NombrePrioridad']?></td>
						</tr>
						<tr>
							<td class="meta-head">Tipo de Trabajo</td>
							<td><?php echo $rowData['NombreTipo']?></td>
						</tr>
						<tr>
							<td class="meta-head">Estado</td>
							<td><?php echo $rowData['NombreEstado']?></td>
						</tr>

						<?php if(isset($rowData['idSupervisor'])&&$rowData['idSupervisor']!=''&&$rowData['idSupervisor']!=0){ ?>
							<tr>
								<td class="meta-head">Supervisor</td>
								<td><?php echo $rowData['NombreTrab'].' '.$rowData['ApellidoPat']?></td>
							</tr>
						<?php }elseif(isset($_GET['ter'])&&$_GET['ter']!=''){ ?>
							<tr>
								<td class="meta-head">Supervisor</td>
								<td><strong style="color:red;">Modificar datos basicos</strong></td>
							</tr>
						<?php } ?>

					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>

						<?php if($rowData['f_creacion']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha creación</td>
								<td><?php if($rowData['f_creacion']!='0000-00-00'){echo Fecha_estandar($rowData['f_creacion']);} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['f_programacion']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha programada</td>
								<td><?php if($rowData['f_programacion']!='0000-00-00'){echo Fecha_estandar($rowData['f_programacion']);} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['f_termino']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha termino</td>
								<td><?php if($rowData['f_termino']!='0000-00-00'){echo Fecha_estandar($rowData['f_termino']);} ?></td>
							</tr>
						<?php }elseif(isset($_GET['ter'])&&$_GET['ter']!=''){ ?>
							<tr>
								<td class="meta-head">Fecha termino</td>
								<td><strong style="color:red;">Modificar datos basicos</strong></td>
							</tr>
						<?php } ?>

						<?php if($rowData['horaInicio']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Hora inicio</td>
								<td><?php if($rowData['horaInicio']!='00:00:00'){echo $rowData['horaInicio'];} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['horaTermino']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Hora termino</td>
								<td><?php if($rowData['horaTermino']!='00:00:00'){echo $rowData['horaTermino'];} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['horaProg']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Tiempo Programado</td>
								<td><?php if($rowData['horaProg']!='00:00:00'){echo $rowData['horaProg'];} ?></td>
							</tr>
						<?php } ?>

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
								<?php //Si la OT solo esta programada
								if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){ ?>
									<a href="<?php echo $location.'&addTrab=true' ?>" title="Agregar Trabajadores" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Trabajadores</a>
								<?php } ?>
							</td>
						</tr>
						<?php foreach ($arrTrabajadores as $trab) {  ?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $trab['Rut']; ?></td>
								<td class="item-name" colspan="3"><?php echo $trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat']; ?></td>
								<td class="item-name"><?php echo $trab['Cargo']; ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo $location.'&edit_trab='.simpleEncode($trab['idResponsable'], fecha_actual()); ?>" title="Editar Trabajador" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php
										$ubicacion = $location.'&del_trab='.simpleEncode($trab['idResponsable'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar al trabajador '.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Trabajador" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
									</div>
								</td>
							</tr>
						<?php } ?>
						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php /**********************************************************************************/ ?>
						<tr class="item-row fact_tittle">
							<td colspan="5">Insumos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Utilizados';} ?></td>
							<td>
								<?php //Si la OT solo esta programada
								if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){ ?>
									<a href="<?php echo $location.'&addIns=true' ?>" title="Agregar Insumos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumos</a>
								<?php } ?>
							</td>
						</tr>
						<?php foreach ($arrInsumos as $insumos) {
							if(isset($insumos['Cantidad'])&&$insumos['Cantidad']!=0){ ?>
								<tr class="item-row linea_punteada">
									<td class="item-name" colspan="4"><?php echo $insumos['NombreProducto']; if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){echo ' - '.$prod['NombreBodega'];} ?></td>
									<td class="item-name"><?php echo $insumos['Cantidad'].' '.$insumos['UnidadMedida']; ?></td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php //Si la OT solo esta programada
											if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){ ?>
												<a href="<?php echo $location.'&edit_ins='.simpleEncode($insumos['idMain'], fecha_actual()); ?>" title="Editar Insumos" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<?php
												$ubicacion = $location.'&del_ins='.simpleEncode($insumos['idMain'], fecha_actual());
												$dialogo   = '¿Realmente deseas eliminar el insumo '.$insumos['NombreProducto'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Insumo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
											<?php } ?>
										</div>
									</td>
								</tr>
							<?php
							} 
						} ?>
						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php /**********************************************************************************/?>
						<tr class="item-row fact_tittle">
							<td colspan="5">Productos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Utilizados';} ?></td>
							<td>
								<?php //Si la OT solo esta programada
								if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){ ?>
									<a href="<?php echo $location.'&addProd=true' ?>" title="Agregar Productos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a>
								<?php } ?>
							</td>
						</tr>
						<?php foreach ($arrProductos as $prod) {
							if(isset($prod['Cantidad'])&&$prod['Cantidad']!=0){ ?>
								<tr class="item-row linea_punteada">
									<td class="item-name" colspan="4"><?php echo $prod['NombreProducto']; if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){echo ' - '.$prod['NombreBodega'];} ?></td>
									<td class="item-name"><?php echo $prod['Cantidad'].' '.$prod['UnidadMedida']; ?></td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php //Si la OT solo esta programada
											if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){ ?>
												<a href="<?php echo $location.'&edit_prod='.simpleEncode($prod['idMain'], fecha_actual()); ?>" title="Editar Productos" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<?php
												$ubicacion = $location.'&del_prod='.simpleEncode($prod['idMain'], fecha_actual());
												$dialogo   = '¿Realmente deseas eliminar el producto '.$prod['NombreProducto'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
											<?php } ?>
										</div>
									</td>
								</tr>
							<?php
							}
						} ?>
						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php /**********************************************************************************/?>
						<tr class="item-row fact_tittle">
							<td colspan="5">Trabajos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Ejecutados';} ?></td>
							<td>
								<?php //Si la OT solo esta programada
								if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){ ?>
									<a href="<?php echo $location.'&addtrabajo=true' ?>" title="Agregar Tareas" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Tarea</a>
								<?php } ?>
							</td>
						</tr>
						<?php foreach ($arrTrabajo as $trab) {  ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2"><?php echo $trab['NombreComponente']; ?></td>
								<td class="item-name" colspan="2"><?php echo $trab['NombreTrabajo']; ?></td>
								<td class="item-name">
								<?php
								//Se verifica el tipo de trabajo a realizar
								switch ($trab['idTrabajo']) {
									case 1: //Analisis
										if(isset($_GET['ter'])&&$_GET['ter']!=''){
											if(isset($trab['idAnalisis'])&&$trab['idAnalisis']==0){$bdat='style="color:red;"';}else{$bdat='';}
											echo '<span '.$bdat.'><strong>Analisis N°: </strong>'.n_doc($trab['idAnalisis'], 6).'</span>';
										}
										break;
									case 2: //Consumo de Productos
										//El tipo de maquina que es
										switch ($trab['idSubTipo']) {
											case 1: //Grasa
												if(isset($trab['Grasa_inicial'])&&$trab['Grasa_inicial']!=0){         echo Cantidades_decimales_justos($trab['Grasa_inicial']);}
												if(isset($trab['Grasa_relubricacion'])&&$trab['Grasa_relubricacion']!=0){echo Cantidades_decimales_justos($trab['Grasa_relubricacion']);}
												break;
											case 2: //Aceite
												echo Cantidades_decimales_justos($trab['Aceite']);
												break;
											case 3: //Normal
												echo Cantidades_decimales_justos($trab['Cantidad']);
												break;
											case 4: //Otro

												break;
										}
										echo ' '.$trab['NombreUnidad'].' de '.$trab['NombreProducto'];
										break;
									case 3: //Observacion
										if(isset($_GET['ter'])&&$_GET['ter']!=''){
											if(isset($trab['Observacion'])&&$trab['Observacion']=='Sin Observaciones'){$bdat='style="color:green;"';}else{$bdat='';}
											echo '<span '.$bdat.'><strong>Obs: </strong>'.cortar($trab['Observacion'], 15).'</span>';
										}
										break;
								} ?>
								</td>
								<td class="item-name">
									<div class="btn-group" style="width: 140px;" >
										<?php
										$ubicacion  = $location;
										$ubicacion .= '&idInterno='.$trab['idTrabajoOT'];
										$ubicacion .= '&id_tabla='.$trab['comp_tabla_id'];
										$ubicacion .= '&tabla='.$trab['comp_tabla'];

										$dialogo = 'Deseas borrar '.$trab['NombreTrabajo'];
										//Boton para cambiar itemizado para todos los items
										echo '<a href="'.$ubicacion.'&addItemizado_row='.$trab['item_m_tabla'].'&lvl='.$trab['item_m_tabla_id'].'" title="Editar Itemizado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-cogs" aria-hidden="true"></i></a>';
										//Se muestra el boton editar productos unicamente si el componente consume productos
										if(isset($trab['idTrabajo'])&&$trab['idTrabajo']!=''&&$trab['idTrabajo']==2){
											echo '<a href="'.$ubicacion.'&editproducto_row=true" title="Editar Producto" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
										}
										if(isset($_GET['ter'])&&$_GET['ter']!=''){
											//Analisis
											if(isset($trab['idTrabajo'])&&$trab['idTrabajo']!=''&&$trab['idTrabajo']==1){
												echo '<a href="'.$ubicacion.'&editanalisis_row=true" title="Editar Analisis" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
											}
											//Observacion
											if(isset($trab['idTrabajo'])&&$trab['idTrabajo']!=''&&$trab['idTrabajo']==3){
												echo '<a href="'.$ubicacion.'&editobservacion_row=true" title="Editar Observacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
											}
										}
										echo '<a onClick="dialogBox(\''.$ubicacion.'&del_tarea_row=true\', \''.$dialogo.'\')" title="Borrar Trabajo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';	
										?>
									</div>
								</td>
							</tr>
						<?php } ?>

						<?php /**********************************************************************************/?>
						<?php
						if (isset($_SESSION['ot_trabajos_temp'])){
							$n_trabajos=0;
							foreach ($_SESSION['ot_trabajos_temp'] as $key => $x_tabla){
								foreach ($x_tabla as $x_id_tabla) {
									foreach ($x_id_tabla as $x_idInterno) {
										$n_trabajos++;
									}
								}
							}

							if(isset($n_trabajos)&&$n_trabajos!=0){
								echo '
								<tr class="item-row fact_tittle">
									<td colspan="5">Trabajos Temporales</td>
									<td>';
									//Si la OT solo esta programada
									if(isset($rowData['idEstado'])&&$rowData['idEstado']!=''&&$rowData['idEstado']==1){
										echo '<a href="'.$location.'&aproTrab=true" class="btn btn-xs btn-success pull-right">Aprobar Trabajos Temp</a>';
									}
								echo '</td>

								</tr>';
								foreach ($_SESSION['ot_trabajos_temp'] as $key => $x_tabla){
									foreach ($x_tabla as $x_id_tabla) {
										foreach ($x_id_tabla as $x_idInterno) {
											$ubicacion  = $location;
											$ubicacion .= '&idInterno='.$x_idInterno['valor_id'];
											$ubicacion .= '&id_tabla='.$x_idInterno['id_tabla'];
											$ubicacion .= '&tabla='.$x_idInterno['tabla'];
											$dialogo   = '¿Realmente deseas eliminar este trabajo asignado?';

											echo '
											<tr class="item-row linea_punteada">
												<td class="item-name" colspan="2">'.$x_idInterno['Codigo'].' - '.$x_idInterno['Nombre'].'</td>';

											//Se muestra el trabajo
											if(isset($x_idInterno['Item_Nombre'])&&$x_idInterno['Item_Nombre']!=''){
												echo '<td colspan="2">'.$x_idInterno['Item_Trabajo'].': '.$x_idInterno['Item_Codigo'].' - '.$x_idInterno['Item_Nombre'].'</td>';
												//se muestra si tiene productos relacionados
												if(isset($x_idInterno['idTrabajo'])&&$x_idInterno['idTrabajo']!=''&&$x_idInterno['idTrabajo']==2){
													echo '<td>';
													//Se verifica valorlinea
													if(isset($x_idInterno['data_1'])&&$x_idInterno['data_1']!=''&&$x_idInterno['data_1']!=0){
														echo $x_idInterno['data_t'].':'.Cantidades_decimales_justos($x_idInterno['data_1']).' '.$x_idInterno['Unimed'].' de '.$x_idInterno['Producto'];
													}
													//se verifica existencia de ambos valores
													if(isset($x_idInterno['data_1'])&&$x_idInterno['data_1']!=''&&$x_idInterno['data_1']!=0&&isset($x_idInterno['data_2'])&&$x_idInterno['data_2']!=''&&$x_idInterno['data_2']!=0){
														echo '<br/>';
													}
													//Si es grasa se agrega la segunda linea de texto
													if(isset($x_idInterno['data_2'])&&$x_idInterno['data_2']!=''&&$x_idInterno['data_2']!=0){
														echo $x_idInterno['data_t'].':'.Cantidades_decimales_justos($x_idInterno['data_2']).' '.$x_idInterno['Unimed'].' de '.$x_idInterno['Producto'];
													}
													echo '</td>';
												}else{
													echo '<td></td>';
												}
											}else{
												echo '<td colspan="2"><span style="color:red;">Sin itemizado asignado</span></td><td></td>';
											}
											echo '
												<td>
													<div class="btn-group" style="width: 70px;" >';
														//Se muestra el de trabajo boton unicamente cuando no se tiene asignado uno
														if(isset($x_idInterno['Item_Nombre'])&&$x_idInterno['Item_Nombre']==''){
															echo '<a href="'.$ubicacion.'&addItemizado='.$x_idInterno['tabla_m'].'&lvl='.$x_idInterno['tabla_m_value'].'" title="Agregar Itemizado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-cogs" aria-hidden="true"></i></a>';
														}else{
															//Se muestra el boton editar productos unicamente si el componente consume productos
															if(isset($x_idInterno['idTrabajo'])&&$x_idInterno['idTrabajo']!=''&&$x_idInterno['idTrabajo']==2){
																echo '<a href="'.$ubicacion.'&editproducto=true" title="Editar Producto" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
															}
														}
														echo '<a onClick="dialogBox(\''.$ubicacion.'&del_tarea=true\', \''.$dialogo.'\')" title="Borrar Trabajo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>';
										}
									}
								}
							}
						}
						?>

						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php /**********************************************************************************/?>

					<tr>
						<td colspan="5" class="blank"><p><?php echo $rowData['Observaciones']?></p></td>
						<td class="blank">
							<div class="btn-group" style="width: 35px;" >
								<a href="<?php echo $location.'&edit_obs=true'; ?>" title="Editar Observacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
					<tr><td colspan="6" class="blank"><p>Observacion</p></td></tr>

				</tbody>
			</table>
			<div class="clearfix"></div>
		</div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
