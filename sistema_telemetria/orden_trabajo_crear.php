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
$original = "orden_trabajo_crear.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idMaquina']) && $_GET['idMaquina']!=''){     $location .= "&idMaquina=".$_GET['idMaquina'];            $search .= "&idMaquina=".$_GET['idMaquina'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){ $location .= "&idPrioridad=".$_GET['idPrioridad'];        $search .= "&idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){           $location .= "&idTipo=".$_GET['idTipo'];                  $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){  $location .= "&f_programacion=".$_GET['f_programacion'];  $search .= "&f_programacion=".$_GET['f_programacion'];}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){      $location .= "&idTrabajador=".$_GET['idTrabajador'];      $search .= "&idTrabajador=".$_GET['idTrabajador'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se cera la orden
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'creacion';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se borra n los datos temporales
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se modifican los datos basicos
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'mod_base';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_trab'])){
	//Llamamos al formulario
	$form_trabajo= 'addTrab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se borra un trabajo
if (!empty($_GET['del_trab'])){
	//Llamamos al formulario
	$form_trabajo= 'del_trab';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un insumo
if (!empty($_POST['submit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'add_ins';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se elimina un insumo
if (!empty($_GET['del_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'del_ins';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un insumo
if (!empty($_POST['submit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'add_prod';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se elimina un insumo
if (!empty($_GET['del_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'del_prod';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un subcomponente
if (!empty($_POST['submit_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se elimina un subcomponente
if (!empty($_GET['del_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'del_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un componente
if (!empty($_POST['submit_itemizado'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_itemizado';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se agrega un componente
if (!empty($_POST['submit_producto'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_producto';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
/*************************************************************************/
//se crea la ot
if (!empty($_GET['crear_ot'])){
	//Llamamos al formulario
	$form_trabajo= 'crear_ot';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se borra la ot
if (!empty($_GET['del_ot'])){
	//Llamamos al formulario
	$form_trabajo= 'del_ot';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo.php';
}
//se clona una ot
if (!empty($_POST['submit_clone'])){
	//Llamamos al formulario
	$form_trabajo= 'clone';
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
if (isset($_GET['created'])){     $error['created']     = 'sucess/Orden de Trabajo Creada correctamente';}
if (isset($_GET['edited'])){      $error['edited']      = 'sucess/Orden de Trabajo Modificada correctamente';}
if (isset($_GET['deleted'])){     $error['deleted']     = 'sucess/Orden de Trabajo Borrada correctamente';}
if (isset($_GET['notslectjob'])){ $error['notslectjob'] = 'error/No ha seleccionado un trabajo a realizar';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Nueva Orden de Trabajo en base a otra existente</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($f_programacion)){    $x1  = $f_programacion;   }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Programada','f_programacion', $x1, 2);

				$Form_Inputs->form_input_hidden('idOT', $_GET['clone'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf24d; Clonar" name="submit_clone">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editProd'])){
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
				if(isset($idSubTipo)){            $x1 = $idSubTipo;              }else{$x1 = $_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['idSubTipo'];}
				if(isset($idProducto)){           $x2 = $idProducto;             }else{$x2 = $_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['idProducto'];}
				if(isset($Grasa_inicial)){        $x3 = $Grasa_inicial;          }else{$x3 = Cantidades_decimales_justos($_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Grasa_inicial']);}
				if(isset($Grasa_relubricacion)){  $x4 = $Grasa_relubricacion;    }else{$x4 = Cantidades_decimales_justos($_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Grasa_relubricacion']);}
				if(isset($Aceite)){               $x5 = $Aceite;                 }else{$x5 = Cantidades_decimales_justos($_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Aceite']);}
				if(isset($Cantidad)){             $x6 = $Cantidad;               }else{$x6 = Cantidades_decimales_justos($_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Cantidad']);}
				if(isset($idUml_fake)){           $x7 = $idUml_fake;             }else{$x7 = $_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['Unimed'];}

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
				$Form_Inputs->form_input_hidden('idUml', $_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]['idUml'], 2);

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
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addtarea'])){
//Verifico el tipo de usuario que esta ingresando
$z="idMaquina=".$_SESSION['ot_basicos']['idMaquina'];

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

				//Imprimo las variables
				$arrTipo = array();
				$query = "SELECT 
				productos_listado.idProducto,
				sistema_productos_uml.Nombre AS Unimed
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
						let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";
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
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_prod">
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

				//Imprimo las variables
				$arrTipo = array();
				$query = "SELECT 
				insumos_listado.idProducto,
				sistema_productos_uml.Nombre AS Unimed
				FROM `insumos_listado`
				LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml
				WHERE ".$zx2."
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
						let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";
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
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Agregar" name="submit_ins">
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
}elseif(!empty($_GET['modBase'])){
//Verifico el tipo de usuario que esta ingresando
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idConfig_1=1 AND idEstado=1";

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
				if(isset($idCliente)){        $x0 = $idCliente;        }else{$x0 = $_SESSION['ot_basicos']['idCliente'];}
				if(isset($idMaquina)){        $x1 = $idMaquina;        }else{$x1 = $_SESSION['ot_basicos']['idMaquina'];}
				if(isset($idPrioridad)){      $x2 = $idPrioridad;      }else{$x2 = $_SESSION['ot_basicos']['idPrioridad'];}
				if(isset($idTipo)){           $x3 = $idTipo;           }else{$x3 = $_SESSION['ot_basicos']['idTipo'];}
				if(isset($f_programacion)){   $x4 = $f_programacion;   }else{$x4 = $_SESSION['ot_basicos']['f_programacion'];}
				if(isset($Observaciones)){    $x5 = $Observaciones;    }else{$x5 = $_SESSION['ot_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//verifico el sistema
				if($_SESSION['usuario']['basic_data']['idSistema']==11){
					$Form_Inputs->form_select_depend1('Cliente','idCliente', $x0, 2, 'idCliente', 'Nombre', 'clientes_listado', $y, 0,
											 'Maquina','idMaquina', $x1, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $z, 0, 
										      $dbConn, 'form1');
				}else{
					$Form_Inputs->form_select_filter('Maquina','idMaquina', $x1, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $z, '', $dbConn);
				}
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x2, 2, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Trabajo','idTipo', $x3, 2, 'idTipo', 'Nombre', 'core_ot_tipos', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programada','f_programacion', $x4, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
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
		$dialogo   = '¿Realmente deseas eliminar todos los datos de la OT en curso?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>
										
		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&crear_ot=true';
		$dialogo   = '¿Desea crear ingresar el documento, tenga en cuenta que no podra realizar mas modificaciones una vez creada?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary"><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive" style="margin-bottom:30px">

	<div id="page-wrap">
		<div id="header"> ORDEN DE TRABAJO</div>
		<div id="customer">
			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<?php if(isset($_SESSION['ot_basicos']['NombreCliente'])&&$_SESSION['ot_basicos']['NombreCliente']!=''){ ?>
						<tr>
							<td class="meta-head">Cliente</td>
							<td><?php echo $_SESSION['ot_basicos']['NombreCliente']; ?></td>
						</tr>
					<?php } ?>
					<tr>
						<td class="meta-head">Maquina</td>
						<td><?php echo $_SESSION['ot_basicos']['NombreMaquina']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Prioridad</td>
						<td><?php echo $_SESSION['ot_basicos']['Prioridad']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Tipo de Trabajo</td>
						<td><?php echo $_SESSION['ot_basicos']['Tipo']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha programada</td>
						<td><?php echo Fecha_estandar($_SESSION['ot_basicos']['f_programacion']); ?></td>
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
					<td><a href="<?php echo $location.'&addTrab=true' ?>" title="Agregar Trabajadores" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Trabajadores</a></td>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				foreach ($_SESSION['ot_trabajador'] as $key => $trab){ ?>
					<tr class="item-row linea_punteada">
						<td class="item-name"><?php echo $trab['Rut']; ?></td>
						<td class="item-name" colspan="3"><?php echo $trab['Trabajador']; ?></td>
						<td class="item-name"><?php echo $trab['Cargo']; ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php
								$ubicacion = $location.'&del_trab='.$trab['idTrabajador'];
								$dialogo   = '¿Realmente deseas eliminar al trabajador '.$trab['Trabajador'].'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Trabajador" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
							</div>
						</td>
					</tr>
				 <?php } ?>
				<tr id="hiderow"><td colspan="6"></td></tr>
				<?php /**********************************************************************************/?>
				<tr class="item-row fact_tittle">
					<td colspan="5">Insumos a Utilizar</td>
					<td><a href="<?php echo $location.'&addIns=true' ?>" title="Agregar Insumos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumos</a></td>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				if(isset($_SESSION['ot_insumos'])&&$_SESSION['ot_insumos']!=''){
					foreach ($_SESSION['ot_insumos'] as $key => $insumos){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4"><?php echo $insumos['Nombre']; ?></td>
							<td class="item-name" ><?php echo $insumos['Cantidad'].' '.$insumos['Unimed']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php
									$ubicacion = $location.'&del_ins='.$insumos['idProducto'];
									$dialogo   = '¿Realmente deseas eliminar el insumo '.$insumos['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Insumo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
								</div>
							</td>
						</tr>
				<?php }
				}else{
					echo '<tr class="item-row linea_punteada"><td colspan="6">No hay insumos asignados</td></tr>';
				} ?>
				<tr id="hiderow"><td colspan="6"></td></tr>
				<?php /**********************************************************************************/?>
				<tr class="item-row fact_tittle">
					<td colspan="5">Productos a Utilizar</td>
					<td><a href="<?php echo $location.'&addProd=true' ?>" title="Agregar Productos" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a></td>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				if(isset($_SESSION['ot_productos'])&&$_SESSION['ot_productos']!=''){
					foreach ($_SESSION['ot_productos'] as $key => $productos){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4"><?php echo $productos['Nombre']; ?></td>
							<td class="item-name" ><?php echo $productos['Cantidad'].' '.$productos['Unimed']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php
									$ubicacion = $location.'&del_prod='.$productos['idProducto'];
									$dialogo   = '¿Realmente deseas eliminar el producto '.$productos['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
								</div>
							</td>
						</tr>
				<?php }
				}else{
					echo '<tr class="item-row linea_punteada"><td colspan="6">No hay productos asignados</td></tr>';
				} ?>
				<tr id="hiderow"><td colspan="6"></td></tr>
				<?php /**********************************************************************************/?>
				<tr class="item-row fact_tittle">
					<td colspan="5">Trabajos a Realizar</td>
					<td width="160"><a href="<?php echo $location.'&addtarea=true' ?>" title="Agregar Tarea" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Tarea</a></td>
				</tr>
				<?php
					if (isset($_SESSION['ot_trabajos'])){
						foreach ($_SESSION['ot_trabajos'] as $key => $x_tabla){
							foreach ($x_tabla as $x_id_tabla) {
								foreach ($x_id_tabla as $x_idInterno) {
									$ubicacion  = $location.'&view=true';
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
														echo '<a href="'.$ubicacion.'&editprod=true" title="Editar Producto" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
													}
												}
												echo '<a onClick="dialogBox(\''.$ubicacion.'&del_tarea=true\', \''.$dialogo.'\')" title="Borrar Trabajo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>';
								}
							}
						} 
					
					}else{
						echo '<tr class="item-row"><td colspan="6">No hay trabajos asignados</td></tr>';
					}
					?>

			</tbody>
		</table>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['ot_basicos']['Observaciones']; ?></p>
		</div>
	</div>

</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//se crea filtro
//Verifico el tipo de usuario que esta ingresando
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idConfig_1=1 AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Nueva Orden de Trabajo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idCliente)){        $x0  = $idCliente;        }else{$x0  = '';}
				if(isset($idMaquina)){        $x1  = $idMaquina;        }else{$x1  = '';}
				if(isset($idPrioridad)){      $x2  = $idPrioridad;      }else{$x2  = '';}
				if(isset($idTipo)){           $x3  = $idTipo;           }else{$x3  = '';}
				if(isset($f_programacion)){   $x4  = $f_programacion;   }else{$x4  = '';}
				if(isset($idTrabajador)){     $x5  = $idTrabajador;     }else{$x5  = '';}
				if(isset($Observaciones)){    $x6  = $Observaciones;    }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//verifico el sistema
				if($_SESSION['usuario']['basic_data']['idSistema']==11){
					$Form_Inputs->form_select_depend1('Cliente','idCliente', $x0, 2, 'idCliente', 'Nombre', 'clientes_listado', $y, 0,
											 'Maquina','idMaquina', $x1, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $z, 0, 
										      $dbConn, 'form1');
				}else{
					$Form_Inputs->form_select_filter('Maquina','idMaquina', $x1, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $z, '', $dbConn);
				}

				$Form_Inputs->form_select('Prioridad','idPrioridad', $x2, 2, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Trabajo','idTipo', $x3, 2, 'idTipo', 'Nombre', 'core_ot_tipos', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programada','f_programacion', $x4, 2);
				$Form_Inputs->form_select_filter('Trabajador responsable','idTrabajador', $x5, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
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
		case 'id_asc':             $order_by = 'orden_trabajo_listado.idOT ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> ID Ascendente'; break;
		case 'id_desc':            $order_by = 'orden_trabajo_listado.idOT DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> ID Descendente';break;
		case 'fprog_asc':          $order_by = 'orden_trabajo_listado.f_programacion ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Programacion Ascendente';break;
		case 'fprog_desc':         $order_by = 'orden_trabajo_listado.f_programacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Programacion Descendente';break;
		case 'maquina_asc':        $order_by = 'maquinas_listado.Nombre ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Maquina Ascendente'; break;
		case 'maquina_desc':       $order_by = 'maquinas_listado.Nombre DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Maquina Descendente';break;
		case 'prioridad_asc':      $order_by = 'core_ot_prioridad.Nombre ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prioridad Ascendente';break;
		case 'prioridad_desc':     $order_by = 'core_ot_prioridad.Nombre DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Prioridad Descendente';break;
		case 'tipotrab_asc':       $order_by = 'core_ot_tipos.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Trabajo Ascendente'; break;
		case 'tipotrab_desc':      $order_by = 'core_ot_tipos.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Trabajo Descendente';break;

		default: $order_by = 'orden_trabajo_listado.idOT DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> OT Descendente';
	}
}else{
	$order_by = 'orden_trabajo_listado.idOT DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> OT Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where  = "orden_trabajo_listado.idOT!=0";
$SIS_where .= " AND orden_trabajo_listado.idEstado = 1";
$SIS_where .= " AND orden_trabajo_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico el tipo de usuario que esta ingresando
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idConfig_1=1 AND idEstado=1";
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){    $SIS_where .= " AND orden_trabajo_listado.idCliente=".$_GET['idCliente'];}
if(isset($_GET['idMaquina']) && $_GET['idMaquina']!=''){    $SIS_where .= " AND orden_trabajo_listado.idMaquina=".$_GET['idMaquina'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){$SIS_where .= " AND orden_trabajo_listado.idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){          $SIS_where .= " AND orden_trabajo_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['f_programacion']) && $_GET['f_programacion']!=''){ $SIS_where .= " AND orden_trabajo_listado.f_programacion='".$_GET['f_programacion']."'";}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){     $SIS_where .= " AND orden_trabajo_listado.idTrabajador=".$_GET['idTrabajador'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idOT', 'orden_trabajo_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
orden_trabajo_listado.idOT,
orden_trabajo_listado.f_programacion,
orden_trabajo_listado.Observaciones,
maquinas_listado.Nombre AS NombreMaquina,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_tipos.Nombre AS NombreTipo,
clientes_listado.Nombre AS NombreCliente';
$SIS_join  = '
LEFT JOIN `maquinas_listado`     ON maquinas_listado.idMaquina      = orden_trabajo_listado.idMaquina
LEFT JOIN `core_ot_prioridad`    ON core_ot_prioridad.idPrioridad   = orden_trabajo_listado.idPrioridad
LEFT JOIN `core_ot_tipos`        ON core_ot_tipos.idTipo            = orden_trabajo_listado.idTipo
LEFT JOIN `clientes_listado`     ON clientes_listado.idCliente      = orden_trabajo_listado.idCliente';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){
	if (isset($_SESSION['ot_basicos']['idMaquina'])&&$_SESSION['ot_basicos']['idMaquina']!=''){ ?>

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

		<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-arrow-right" aria-hidden="true"></i> Continuar Orden Trabajo</a>
	<?php }else{ ?>
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Orden Trabajo</a>
	<?php }
	 } ?>
</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idCliente)){        $x0  = $idCliente;        }else{$x0  = '';}
				if(isset($idMaquina)){        $x1  = $idMaquina;        }else{$x1  = '';}
				if(isset($idPrioridad)){      $x2  = $idPrioridad;      }else{$x2  = '';}
				if(isset($idTipo)){           $x3  = $idTipo;           }else{$x3  = '';}
				if(isset($f_programacion)){   $x4  = $f_programacion;   }else{$x4  = '';}
				if(isset($idTrabajador)){     $x6  = $idTrabajador;     }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				if($_SESSION['usuario']['basic_data']['idSistema']==11){
					$Form_Inputs->form_select_depend1('Cliente','idCliente', $x0, 1, 'idCliente', 'Nombre', 'clientes_listado', $y, 0,
											 'Maquina','idMaquina', $x1, 1, 'idMaquina', 'Nombre', 'maquinas_listado', $w, 0, 
										      $dbConn, 'form1');
				}else{
					$Form_Inputs->form_select_filter('Maquina','idMaquina', $x1, 1, 'idMaquina', 'Nombre', 'maquinas_listado', $w, '', $dbConn);
				}
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x2, 1, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Trabajo','idTipo', $x3, 1, 'idTipo', 'Nombre', 'core_ot_tipos', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programada','f_programacion', $x4, 1);
				$Form_Inputs->form_select_filter('Trabajador responsable','idTrabajador', $x6, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $y, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ordenes de Trabajo</h5>
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
							<div class="pull-left">#</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=id_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=id_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">F Prog</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fprog_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fprog_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Maquina</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=maquina_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=maquina_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Prioridad</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=prioridad_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=prioridad_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo Trabajo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipotrab_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipotrab_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOTS as $ot) { ?>
					<tr class="odd">
						<td><?php echo n_doc($ot['idOT'], 8); ?></td>
						<td><?php echo Fecha_estandar($ot['f_programacion']); ?></td>
						<td><?php if(isset($ot['NombreCliente'])&&$ot['NombreCliente']!=''){echo $ot['NombreCliente'].' - '.$ot['NombreMaquina'];}else{echo $ot['NombreMaquina'];} ?></td>
						<td><?php echo $ot['NombrePrioridad']; ?></td>
						<td><?php echo $ot['NombreTipo']; ?></td>
						<td>
							<div class="btn-group" style="width: 140px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_orden_trabajo.php?view='.simpleEncode($ot['idOT'], fecha_actual()); ?>" title="Ver Orden de Trabajo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'orden_trabajo_editar.php?view='.$ot['idOT']; ?>" title="Editar Orden de Trabajo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location.'&clone='.$ot['idOT']; ?>" title="Duplicar Orden de Trabajo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del_ot='.simpleEncode($ot['idOT'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el registro de la OT  '.n_doc($ot['idOT'], 5).'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
