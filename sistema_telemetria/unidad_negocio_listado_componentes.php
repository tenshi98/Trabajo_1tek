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
$original = "unidad_negocio_listado.php";
$location = $original;
$new_location = "unidad_negocio_listado_componentes.php";
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
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_addTrabajo'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'add_trabajo';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se borra un dato
if (!empty($_GET['del_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se borra un dato
if (!empty($_GET['clone_compo'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'clone_component';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//formulario para editar
if (!empty($_POST['submit_edit_img'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'submit_img_comp';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['del_img'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_img_comp';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){    $error['created']    = 'sucess/Dato Creado correctamente';}
if (isset($_GET['edited'])){     $error['edited']     = 'sucess/Dato Modificado correctamente';}
if (isset($_GET['deleted'])){    $error['deleted']    = 'sucess/Dato Borrado correctamente';}
if (isset($_GET['clone_comp'])){ $error['clone_comp'] = 'sucess/Componente clonado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['addTrabajo'])){
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
}else{
	//filtro
	$z = "idLicitacion=0";
	//Se revisan los permisos a los contratos
	$arrPermisos = array();
	$query = "SELECT idLicitacion
	FROM `usuarios_contratos`
	WHERE idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
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
		$z .= " OR (idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idAprobado=2 AND idLicitacion=".$prod['idLicitacion'].")";
	}
}

//Se filtran solo las ramas de la licitacion, no las subramas con los datos
$w = 'idUtilizable=1';

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Trabajo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idLicitacion)){     $x0  = $idLicitacion;     }else{$x0  = '';}
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
				$Form_Inputs->form_select_depend25('Contrato','idLicitacion',$x0 ,1,'idLicitacion','Nombre','licitacion_listado',$z,0,
										  'Nivel 1','idLevel_1',$x1 ,1,'idLevel_1','Nombre','licitacion_listado_level_1',$w,0,
										  'Nivel 2','idLevel_2',$x2 ,1,'idLevel_2','Nombre','licitacion_listado_level_2',$w,0,
										  'Nivel 3','idLevel_3',$x3 ,1,'idLevel_3','Nombre','licitacion_listado_level_3',$w,0,
										  'Nivel 4','idLevel_4',$x4 ,1,'idLevel_4','Nombre','licitacion_listado_level_4',$w,0,
										  'Nivel 5','idLevel_5',$x5 ,1,'idLevel_5','Nombre','licitacion_listado_level_5',$w,0,
										  'Nivel 6','idLevel_6',$x6 ,1,'idLevel_6','Nombre','licitacion_listado_level_6',$w,0,
										  'Nivel 7','idLevel_7',$x7 ,1,'idLevel_7','Nombre','licitacion_listado_level_7',$w,0,
										  'Nivel 8','idLevel_8',$x8 ,1,'idLevel_8','Nombre','licitacion_listado_level_8',$w,0,
										  'Nivel 9','idLevel_9',$x9 ,1,'idLevel_9','Nombre','licitacion_listado_level_9',$w,0,
										  'Nivel 10','idLevel_10',$x10 ,1,'idLevel_10','Nombre','licitacion_listado_level_10',$w,0,
										  'Nivel 11','idLevel_11',$x11 ,1,'idLevel_11','Nombre','licitacion_listado_level_11',$w,0,
										  'Nivel 12','idLevel_12',$x12 ,1,'idLevel_12','Nombre','licitacion_listado_level_12',$w,0,
										  'Nivel 13','idLevel_13',$x13 ,1,'idLevel_13','Nombre','licitacion_listado_level_13',$w,0,
										  'Nivel 14','idLevel_14',$x14 ,1,'idLevel_14','Nombre','licitacion_listado_level_14',$w,0,
										  'Nivel 15','idLevel_15',$x15 ,1,'idLevel_15','Nombre','licitacion_listado_level_15',$w,0,
										  'Nivel 16','idLevel_16',$x16 ,1,'idLevel_16','Nombre','licitacion_listado_level_16',$w,0,
										  'Nivel 17','idLevel_17',$x17 ,1,'idLevel_17','Nombre','licitacion_listado_level_17',$w,0,
										  'Nivel 18','idLevel_18',$x18 ,1,'idLevel_18','Nombre','licitacion_listado_level_18',$w,0,
										  'Nivel 19','idLevel_19',$x19 ,1,'idLevel_19','Nombre','licitacion_listado_level_19',$w,0,
										  'Nivel 20','idLevel_20',$x20 ,1,'idLevel_20','Nombre','licitacion_listado_level_20',$w,0,
										  'Nivel 21','idLevel_21',$x21 ,1,'idLevel_21','Nombre','licitacion_listado_level_21',$w,0,
										  'Nivel 22','idLevel_22',$x22 ,1,'idLevel_22','Nombre','licitacion_listado_level_22',$w,0,
										  'Nivel 23','idLevel_23',$x23 ,1,'idLevel_23','Nombre','licitacion_listado_level_23',$w,0,
										  'Nivel 24','idLevel_24',$x24 ,1,'idLevel_24','Nombre','licitacion_listado_level_24',$w,0,
										  $dbConn, 'form1');

				$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);
				$Form_Inputs->form_input_hidden('addTrabajo', $_GET['addTrabajo'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_addTrabajo">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit'])){
// consulto los datos
$query = "SELECT 
maquinas_listado_level_".$_GET['lvl'].".Nombre,
maquinas_listado_level_".$_GET['lvl'].".Codigo,
maquinas_listado_level_".$_GET['lvl'].".Marca,
maquinas_listado_level_".$_GET['lvl'].".idUtilizable,
maquinas_listado_level_".$_GET['lvl'].".Modelo,
maquinas_listado_level_".$_GET['lvl'].".AnoFab,
maquinas_listado_level_".$_GET['lvl'].".Serie,
maquinas_listado_level_".$_GET['lvl'].".idSubTipo,
maquinas_listado_level_".$_GET['lvl'].".Saf,
maquinas_listado_level_".$_GET['lvl'].".Numero,
maquinas_listado_level_".$_GET['lvl'].".idProducto,
maquinas_listado_level_".$_GET['lvl'].".Grasa_inicial,
maquinas_listado_level_".$_GET['lvl'].".Grasa_relubricacion,
maquinas_listado_level_".$_GET['lvl'].".Aceite,
maquinas_listado_level_".$_GET['lvl'].".Cantidad,
maquinas_listado_level_".$_GET['lvl'].".idUml,
maquinas_listado_level_".$_GET['lvl'].".Frecuencia,
maquinas_listado_level_".$_GET['lvl'].".idFrecuencia,
sistema_productos_uml.Nombre AS UnidadMedida

FROM `maquinas_listado_level_".$_GET['lvl']."`
LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = maquinas_listado_level_".$_GET['lvl'].".idUml
WHERE maquinas_listado_level_".$_GET['lvl'].".idLevel_".$_GET['lvl']." = ".$_GET['edit'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	 

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
			<h5>Modificar Componente</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = $rowData['Nombre'];}
				if(isset($Codigo)){               $x2  = $Codigo;                 }else{$x2  = $rowData['Codigo'];}
				if(isset($Marca)){                $x3  = $Marca;                  }else{$x3  = $rowData['Marca'];}
				if(isset($idUtilizable)){         $x4  = $idUtilizable;           }else{$x4  = $rowData['idUtilizable'];}
				//Si es componente
				if(isset($Modelo)){               $x6  = $Modelo;                 }else{$x6  = $rowData['Modelo'];}
				if(isset($AnoFab)){               $x7  = $AnoFab;                 }else{$x7  = $rowData['AnoFab'];}
				if(isset($Serie)){                $x8  = $Serie;                  }else{$x8  = $rowData['Serie'];}
				//Si es subcomponente
				if(isset($Saf)){                  $x9  = $Saf;                    }else{$x9  = $rowData['Saf'];}
				if(isset($Numero)){               $x10 = $Numero;                 }else{$x10 = $rowData['Numero'];}
				if(isset($idSubTipo)){            $x11 = $idSubTipo;              }else{$x11 = $rowData['idSubTipo'];}
				if(isset($idProducto)){           $x12 = $idProducto;             }else{$x12 = $rowData['idProducto'];}
				if(isset($Grasa_inicial)){        $x13 = $Grasa_inicial;          }else{$x13 = Cantidades_decimales_justos($rowData['Grasa_inicial']);}
				if(isset($Grasa_relubricacion)){  $x14 = $Grasa_relubricacion;    }else{$x14 = Cantidades_decimales_justos($rowData['Grasa_relubricacion']);}
				if(isset($Aceite)){               $x15 = $Aceite;                 }else{$x15 = Cantidades_decimales_justos($rowData['Aceite']);}
				if(isset($Cantidad)){             $x16 = $Cantidad;               }else{$x16 = Cantidades_decimales_justos($rowData['Cantidad']);}
				if(isset($idUml_fake)){           $x17 = $idUml_fake;             }else{$x17 = $rowData['UnidadMedida'];}
				if(isset($idUml)){                $x18 = $idUml;                  }else{$x18 = $rowData['idUml'];}
				if(isset($Frecuencia)){           $x19 = $Frecuencia;             }else{$x19 = $rowData['Frecuencia'];}
				if(isset($idFrecuencia)){         $x20 = $idFrecuencia;           }else{$x20 = $rowData['idFrecuencia'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 2);
				$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 1);
				$Form_Inputs->form_select('Componente','idUtilizable', $x4, 2, 'idUtilizable', 'Nombre', 'core_maquinas_tipo_componente', 0, '', $dbConn);
				//si es componente
				$Form_Inputs->form_input_text('Modelo', 'Modelo', $x6, 1);
				$Form_Inputs->form_select_n_auto('Año de Fabricacion','AnoFab', $x7, 1, 1975, ano_actual());
				$Form_Inputs->form_input_text('Serie', 'Serie', $x8, 1);
				//Si es subcomponente
				$Form_Inputs->form_input_text('Saf', 'Saf', $x9, 1);
				$Form_Inputs->form_input_text('Numero', 'Numero', $x10, 1);
				$Form_Inputs->form_select_depend1('Tareas Relacionadas','idSubTipo', $x11, 1, 'idSubTipo', 'Nombre', 'core_maquinas_tipo', 0, 0,
										 'Producto utilizado','idProducto', $x12, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_number('Grasa inicial','Grasa_inicial', $x13, 1);
				$Form_Inputs->form_input_number('Grasa relubricacion','Grasa_relubricacion', $x14, 1);
				$Form_Inputs->form_input_number('Cantidad de Aceite','Aceite', $x15, 1);
				$Form_Inputs->form_input_number('Cantidad a consumir','Cantidad', $x16, 1);
				$Form_Inputs->form_input_disabled('Unidad de Medida','idUml_fake',  $x17);
				$Form_Inputs->form_input_text('Unidad de Medida','idUml', $x18, 1);
				$Form_Inputs->form_input_text('Frecuencia', 'Frecuencia', $x19, 1);
				$Form_Inputs->form_select('Medida Frecuencia','idFrecuencia', $x20, 1, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idMaquina', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

				//Imprimo las variables
				$arrTipo = array();
				$query = "SELECT 
				productos_listado.idProducto,
				sistema_productos_uml.Nombre AS Unimed,
				productos_listado.idUml
				FROM `productos_listado`
				LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml
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
						//Se ocultan todos los input
						document.getElementById('div_Modelo').style.display = 'none';
						document.getElementById('div_AnoFab').style.display = 'none';
						document.getElementById('div_Serie').style.display = 'none';
						document.getElementById('div_idSubTipo').style.display = 'none';
						document.getElementById('div_Saf').style.display = 'none';
						document.getElementById('div_Numero').style.display = 'none';
						document.getElementById('div_idProducto').style.display = 'none';
						document.getElementById('div_Grasa_inicial').style.display = 'none';
						document.getElementById('div_Grasa_relubricacion').style.display = 'none';
						document.getElementById('div_Aceite').style.display = 'none';
						document.getElementById('div_Cantidad').style.display = 'none';
						document.getElementById('div_idUml_fake').style.display = 'none';
						document.getElementById('div_idUml').style.display = 'none';
						document.getElementById('div_Frecuencia').style.display = 'none';
						document.getElementById('div_idFrecuencia').style.display = 'none';
						//cargo al inicio
						LoadProducto();
						LoadUtilizable(0);
						LoadSubTipo(0);
					});

					/**********************************************************************/
					document.getElementById("idProducto").onchange = function() {LoadProducto()};
					document.getElementById("idUtilizable").onchange = function() {LoadUtilizable(1)};
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
					function LoadUtilizable(caseLoad){
						//obtengo los valores
						let Sensores_val_1= $("#idUtilizable").val();
						//selecciono
						switch(Sensores_val_1) {
							//si es No Usable
							case '1':
								document.getElementById('div_Modelo').style.display = 'none';
								document.getElementById('div_AnoFab').style.display = 'none';
								document.getElementById('div_Serie').style.display = 'none';
								document.getElementById('div_idSubTipo').style.display = 'none';
								document.getElementById('div_Saf').style.display = 'none';
								document.getElementById('div_Numero').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = 'none';
								document.getElementById('div_idFrecuencia').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="idProducto"]').selectedIndex = 0;
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
									document.querySelector('input[name="idUml_fake"]').value = '0';
									document.querySelector('input[name="idUml"]').value = '0';
									document.querySelector('input[name="Frecuencia"]').value = '0';
									document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
								}
							break;
							//si es Componente
							case '2':
								document.getElementById('div_Modelo').style.display = '';
								document.getElementById('div_AnoFab').style.display = '';
								document.getElementById('div_Serie').style.display = '';
								document.getElementById('div_idSubTipo').style.display = 'none';
								document.getElementById('div_Saf').style.display = 'none';
								document.getElementById('div_Numero').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = 'none';
								document.getElementById('div_idFrecuencia').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="idProducto"]').selectedIndex = 0;
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
									document.querySelector('input[name="idUml_fake"]').value = '0';
									document.querySelector('input[name="idUml"]').value = '0';
									document.querySelector('input[name="Frecuencia"]').value = '0';
									document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
								}
							break;
							//si es Subcomponente
							case '3':
								document.getElementById('div_Modelo').style.display = 'none';
								document.getElementById('div_AnoFab').style.display = 'none';
								document.getElementById('div_Serie').style.display = 'none';
								document.getElementById('div_idSubTipo').style.display = '';
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = 'none';
								document.getElementById('div_idFrecuencia').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="idProducto"]').selectedIndex = 0;
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
									document.querySelector('input[name="idUml_fake"]').value = '0';
									document.querySelector('input[name="idUml"]').value = '0';
									document.querySelector('input[name="Frecuencia"]').value = '0';
									document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
								}
							break;
						}
					}

					/**********************************************************************/
					function LoadSubTipo(caseLoad){
						//obtengo los valores
						let Sensores_val_2= $("#idSubTipo").val();
						//selecciono
						switch(Sensores_val_2) {
							//Errores Conjuntos
							case '1':
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = '';
								document.getElementById('div_Grasa_inicial').style.display = '';
								document.getElementById('div_Grasa_relubricacion').style.display = '';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = '';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
								}
							break;
							//Errores Conjuntos
							case '2':
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = '';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = '';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = '';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
								}
							break;
							//Errores Conjuntos
							case '3':
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = '';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = '';
								document.getElementById('div_idUml_fake').style.display = '';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
								}
							break;
							//Errores Conjuntos
							case '4':
								document.getElementById('div_Saf').style.display = 'none';
								document.getElementById('div_Numero').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
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

					<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){$Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);} ?>
					<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){$Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);} ?>
					<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){$Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);} ?>
					<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){$Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);} ?>
					<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){$Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);} ?>
					<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){$Form_Inputs->form_input_hidden('idLevel_6', $_GET['lv_6'], 2);} ?>
					<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){$Form_Inputs->form_input_hidden('idLevel_7', $_GET['lv_7'], 2);} ?>
					<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){$Form_Inputs->form_input_hidden('idLevel_8', $_GET['lv_8'], 2);} ?>
					<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){$Form_Inputs->form_input_hidden('idLevel_9', $_GET['lv_9'], 2);} ?>
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
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editimg'])){
// consulto los datos
$query = "SELECT 
maquinas_listado_level_".$_GET['lvl'].".Nombre,
maquinas_listado_level_".$_GET['lvl'].".Direccion_img

FROM `maquinas_listado_level_".$_GET['lvl']."`
WHERE maquinas_listado_level_".$_GET['lvl'].".idLevel_".$_GET['lvl']." = ".$_GET['editimg'];
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
			<h5>Modificar imagen de <?php echo $rowData['Nombre']; ?></h5>
		</header>
		<div class="body">

			<?php if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){ ?>

				<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
					 <img src="upload/<?php echo $rowData['Direccion_img']; ?>" width="100%" >
				</div>

				<div class="form-group">
					<a href="<?php echo $new_location.'&id='.$_GET['id'].'&lvl='.$_GET['lvl'].'&del_img='.$_GET['editimg']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
				<div class="clearfix"></div>

			<?php }else{ ?>

				<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

					<?php
					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_multiple_upload('Seleccionar archivo','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');

					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

					?>

					<div class="form-group">

						<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){$Form_Inputs->form_input_hidden('idLevel_1', $_GET['lv_1'], 2);} ?>
						<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){$Form_Inputs->form_input_hidden('idLevel_2', $_GET['lv_2'], 2);} ?>
						<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){$Form_Inputs->form_input_hidden('idLevel_3', $_GET['lv_3'], 2);} ?>
						<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){$Form_Inputs->form_input_hidden('idLevel_4', $_GET['lv_4'], 2);} ?>
						<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){$Form_Inputs->form_input_hidden('idLevel_5', $_GET['lv_5'], 2);} ?>
						<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){$Form_Inputs->form_input_hidden('idLevel_6', $_GET['lv_6'], 2);} ?>
						<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){$Form_Inputs->form_input_hidden('idLevel_7', $_GET['lv_7'], 2);} ?>
						<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){$Form_Inputs->form_input_hidden('idLevel_8', $_GET['lv_8'], 2);} ?>
						<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){$Form_Inputs->form_input_hidden('idLevel_9', $_GET['lv_9'], 2);} ?>
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

						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_img">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			<?php } ?>

		</div>
	</div>
</div>  
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//se crea filtro
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
			<h5>Crear Componente</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = '';}
				if(isset($Codigo)){               $x2  = $Codigo;                 }else{$x2  = '';}
				if(isset($Marca)){                $x3  = $Marca;                  }else{$x3  = '';}
				if(isset($idUtilizable)){         $x4  = $idUtilizable;           }else{$x4  = '';}
				//Si es componente
				if(isset($Modelo)){               $x6  = $Modelo;                 }else{$x6  = '';}
				if(isset($AnoFab)){               $x7  = $AnoFab;                 }else{$x7  = '';}
				if(isset($Serie)){                $x8  = $Serie;                  }else{$x8  = '';}
				//Si es subcomponente
				if(isset($Saf)){                  $x9  = $Saf;                    }else{$x9  = '';}
				if(isset($Numero)){               $x10 = $Numero;                 }else{$x10 = '';}
				if(isset($idSubTipo)){            $x11 = $idSubTipo;              }else{$x11 = '';}
				if(isset($idProducto)){           $x12 = $idProducto;             }else{$x12 = '';}
				if(isset($Grasa_inicial)){        $x13 = $Grasa_inicial;          }else{$x13 = '';}
				if(isset($Grasa_relubricacion)){  $x14 = $Grasa_relubricacion;    }else{$x14 = '';}
				if(isset($Aceite)){               $x15 = $Aceite;                 }else{$x15 = '';}
				if(isset($Cantidad)){             $x16 = $Cantidad;               }else{$x16 = '';}
				if(isset($idUml_fake)){           $x17 = $idUml_fake;             }else{$x17 = '';}
				if(isset($idUml)){                $x18 = $idUml;                  }else{$x18 = '';}
				if(isset($Frecuencia)){           $x19 = $Frecuencia;             }else{$x19 = '';}
				if(isset($idFrecuencia)){         $x20 = $idFrecuencia;           }else{$x20 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 2);
				$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 1);
				$Form_Inputs->form_select('Componente','idUtilizable', $x4, 2, 'idUtilizable', 'Nombre', 'core_maquinas_tipo_componente', 0, '', $dbConn);
				//si es componente
				$Form_Inputs->form_input_text('Modelo', 'Modelo', $x6, 1);
				$Form_Inputs->form_select_n_auto('Año de Fabricacion','AnoFab', $x7, 1, 1975, ano_actual());
				$Form_Inputs->form_input_text('Serie', 'Serie', $x8, 1);
				//Si es subcomponente
				$Form_Inputs->form_input_text('Saf', 'Saf', $x9, 1);
				$Form_Inputs->form_input_text('Numero', 'Numero', $x10, 1);
				$Form_Inputs->form_select_depend1('Tareas Relacionadas','idSubTipo', $x11, 1, 'idSubTipo', 'Nombre', 'core_maquinas_tipo', 0, 0,
										 'Producto utilizado','idProducto', $x12, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_number('Grasa inicial','Grasa_inicial', $x13, 1);
				$Form_Inputs->form_input_number('Grasa relubricacion','Grasa_relubricacion', $x14, 1);
				$Form_Inputs->form_input_number('Cantidad de Aceite','Aceite', $x15, 1);
				$Form_Inputs->form_input_number('Cantidad a consumir','Cantidad', $x16, 1);
				$Form_Inputs->form_input_disabled('Unidad de Medida','idUml_fake',  $x17);
				$Form_Inputs->form_input_text('Unidad de Medida','idUml', $x18, 1);
				$Form_Inputs->form_input_text('Frecuencia', 'Frecuencia', $x19, 1);
				$Form_Inputs->form_select('Medida Frecuencia','idFrecuencia', $x20, 1, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idMaquina', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);
				
			
				
				//Imprimo las variables
				$arrTipo = array();
				$query = "SELECT 
				productos_listado.idProducto,
				sistema_productos_uml.Nombre AS Unimed,
				productos_listado.idUml
				FROM `productos_listado`
				LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml
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
						//Se ocultan todos los input
						document.getElementById('div_Modelo').style.display = 'none';
						document.getElementById('div_AnoFab').style.display = 'none';
						document.getElementById('div_Serie').style.display = 'none';
						document.getElementById('div_idSubTipo').style.display = 'none';
						document.getElementById('div_Saf').style.display = 'none';
						document.getElementById('div_Numero').style.display = 'none';
						document.getElementById('div_idProducto').style.display = 'none';
						document.getElementById('div_Grasa_inicial').style.display = 'none';
						document.getElementById('div_Grasa_relubricacion').style.display = 'none';
						document.getElementById('div_Aceite').style.display = 'none';
						document.getElementById('div_Cantidad').style.display = 'none';
						document.getElementById('div_idUml_fake').style.display = 'none';
						document.getElementById('div_idUml').style.display = 'none';
						document.getElementById('div_Frecuencia').style.display = 'none';
						document.getElementById('div_idFrecuencia').style.display = 'none';
						//cargo al inicio
						LoadProducto();
						LoadUtilizable(0);
						LoadSubTipo(0);
					});

					/**********************************************************************/
					document.getElementById("idProducto").onchange = function() {LoadProducto()};
					document.getElementById("idUtilizable").onchange = function() {LoadUtilizable(1)};
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
					function LoadUtilizable(caseLoad){
						//obtengo los valores
						let Sensores_val_1= $("#idUtilizable").val();
						//selecciono
						switch(Sensores_val_1) {
							//si es No Usable
							case '1':
								document.getElementById('div_Modelo').style.display = 'none';
								document.getElementById('div_AnoFab').style.display = 'none';
								document.getElementById('div_Serie').style.display = 'none';
								document.getElementById('div_idSubTipo').style.display = 'none';
								document.getElementById('div_Saf').style.display = 'none';
								document.getElementById('div_Numero').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = 'none';
								document.getElementById('div_idFrecuencia').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="idProducto"]').selectedIndex = 0;
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
									document.querySelector('input[name="idUml_fake"]').value = '0';
									document.querySelector('input[name="idUml"]').value = '0';
									document.querySelector('input[name="Frecuencia"]').value = '0';
									document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
								}
							break;
							//si es Componente
							case '2':
								document.getElementById('div_Modelo').style.display = '';
								document.getElementById('div_AnoFab').style.display = '';
								document.getElementById('div_Serie').style.display = '';
								document.getElementById('div_idSubTipo').style.display = 'none';
								document.getElementById('div_Saf').style.display = 'none';
								document.getElementById('div_Numero').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = 'none';
								document.getElementById('div_idFrecuencia').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="idProducto"]').selectedIndex = 0;
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
									document.querySelector('input[name="idUml_fake"]').value = '0';
									document.querySelector('input[name="idUml"]').value = '0';
									document.querySelector('input[name="Frecuencia"]').value = '0';
									document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
								}
							break;
							//si es Subcomponente
							case '3':
								document.getElementById('div_Modelo').style.display = 'none';
								document.getElementById('div_AnoFab').style.display = 'none';
								document.getElementById('div_Serie').style.display = 'none';
								document.getElementById('div_idSubTipo').style.display = '';
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = 'none';
								document.getElementById('div_idFrecuencia').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="idProducto"]').selectedIndex = 0;
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
									document.querySelector('input[name="idUml_fake"]').value = '0';
									document.querySelector('input[name="idUml"]').value = '0';
									document.querySelector('input[name="Frecuencia"]').value = '0';
									document.querySelector('input[name="idFrecuencia"]').selectedIndex = 0;
								}
							break;
						}
					}

					/**********************************************************************/
					function LoadSubTipo(caseLoad){
						//obtengo los valores
						let Sensores_val_2= $("#idSubTipo").val();
						//selecciono
						switch(Sensores_val_2) {
							//Errores Conjuntos
							case '1':
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = '';
								document.getElementById('div_Grasa_inicial').style.display = '';
								document.getElementById('div_Grasa_relubricacion').style.display = '';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = '';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Aceite"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
								}
							break;
							//Errores Conjuntos
							case '2':
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = '';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = '';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = '';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Cantidad"]').value = '0';
								}
							break;
							//Errores Conjuntos
							case '3':
								document.getElementById('div_Saf').style.display = '';
								document.getElementById('div_Numero').style.display = '';
								document.getElementById('div_idProducto').style.display = '';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = '';
								document.getElementById('div_idUml_fake').style.display = '';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="Grasa_inicial"]').value = '0';
									document.querySelector('input[name="Grasa_relubricacion"]').value = '0';
									document.querySelector('input[name="Aceite"]').value = '0';
								}
							break;
							//Errores Conjuntos
							case '4':
								document.getElementById('div_Saf').style.display = 'none';
								document.getElementById('div_Numero').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_Grasa_inicial').style.display = 'none';
								document.getElementById('div_Grasa_relubricacion').style.display = 'none';
								document.getElementById('div_Aceite').style.display = 'none';
								document.getElementById('div_Cantidad').style.display = 'none';
								document.getElementById('div_idUml_fake').style.display = 'none';
								document.getElementById('div_idUml').style.display = 'none';
								document.getElementById('div_Frecuencia').style.display = '';
								document.getElementById('div_idFrecuencia').style.display = '';
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
$query = "SELECT Nombre,idSistema, idConfig_1, idConfig_2
FROM `maquinas_listado`
WHERE idMaquina = ".$_GET['id'];
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
    $z .= ',maquinas_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
    $z .= ',maquinas_listado_level_'.$i.'.Codigo AS LVL_'.$i.'_Codigo';
    $z .= ',maquinas_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
    $z .= ',maquinas_listado_level_'.$i.'.idUtilizable AS LVL_'.$i.'_idUtilizable';
    $z .= ',maquinas_listado_level_'.$i.'.idLicitacion AS LVL_'.$i.'_idLicitacion';
    $z .= ',maquinas_listado_level_'.$i.'.tabla AS LVL_'.$i.'_table';
    $z .= ',maquinas_listado_level_'.$i.'.table_value AS LVL_'.$i.'_table_value';
    $z .= ',maquinas_listado_level_'.$i.'.Direccion_img AS LVL_'.$i.'_imagen ';
	//Joins
    $xx = $i + 1;
    if($xx<=$nmax){
		$leftjoin .= ' LEFT JOIN `maquinas_listado_level_'.$xx.'`   ON maquinas_listado_level_'.$xx.'.idLevel_'.$i.'    = maquinas_listado_level_'.$i.'.idLevel_'.$i;
    }
    //ORDER BY
    $orderby .= ', maquinas_listado_level_'.$i.'.Codigo ASC';
}

//se hace la consulta
$arrItemizado = array();
$query = "SELECT
maquinas_listado_level_1.idLevel_1 AS bla
".$z."
FROM `maquinas_listado_level_1`
".$leftjoin."
WHERE maquinas_listado_level_1.idMaquina=".$_GET['id']."
ORDER BY maquinas_listado_level_1.Codigo ASC ".$orderby."

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
array_push( $arrItemizado,$row );
}
/*********************************************************************/
// Se trae un listado con todos los tipos de componentes
$arrTipos = array();
$query = "SELECT idUtilizable, Nombre
FROM `core_maquinas_tipo_componente`
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
/*********************************************************************/
//Verifico el tipo de usuario que esta ingresando
$z="WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Se crea el arreglo
$Trabajo = array();
//Creo el arreglo para saber los datos de las licitaciones
for ($i = 1; $i <= $nmax; $i++) {
	// Se trae un listado con todos los datos
	$arrTrabajo = array();
	$query = "SELECT idLevel_".$i." AS lvl, idLicitacion, Nombre,Codigo
	FROM `licitacion_listado_level_".$i."` ".$z."
	ORDER BY Codigo ASC, Nombre ASC";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrTrabajo,$row );
	}
	//se guardan los datos
	foreach($arrTrabajo as $trab) {
		$Trabajo[$trab['idLicitacion']][$i][$trab['lvl']]['Nombre']  = $trab['Nombre'];
		$Trabajo[$trab['idLicitacion']][$i][$trab['lvl']]['Codigo']  = $trab['Codigo'];
	}

}


/*********************************************************************/
$array3d = array();
foreach($arrItemizado as $key) {

	//Creo Variables para la rejilla
	for ($i = 1; $i <= $nmax; $i++) {

		//creo la variable vacia
		$d[$i]  = '';
		$n[$i]  = '';
		$c[$i]  = '';
		$u[$i]  = '';
		$x[$i]  = '';
		$y[$i]  = '';
		$m[$i]  = '';
		$t[$i]  = '';

		//si el dato solicitado tiene valores sobreescribe la variable
		if(isset($key['LVL_'.$i.'_id'])&&$key['LVL_'.$i.'_id']!=''){              $d[$i]  = $key['LVL_'.$i.'_id'];}
		if(isset($key['LVL_'.$i.'_Nombre'])&&$key['LVL_'.$i.'_Nombre']!=''){      $n[$i]  = $key['LVL_'.$i.'_Nombre'];}
		if(isset($key['LVL_'.$i.'_Codigo'])&&$key['LVL_'.$i.'_Codigo']!=''){      $c[$i]  = $key['LVL_'.$i.'_Codigo'];}
		if(isset($key['LVL_'.$i.'_idUtilizable'])&&$key['LVL_'.$i.'_idUtilizable']!=''){ $u[$i]  = $key['LVL_'.$i.'_idUtilizable'];}
		if(isset($key['LVL_'.$i.'_idLicitacion'])&&$key['LVL_'.$i.'_idLicitacion']!=''){ $x[$i]  = $key['LVL_'.$i.'_idLicitacion'];}
		if(isset($key['LVL_'.$i.'_table'])&&$key['LVL_'.$i.'_table']!=''){        $y[$i]  = $key['LVL_'.$i.'_table'];}
		if(isset($key['LVL_'.$i.'_table_value'])&&$key['LVL_'.$i.'_table_value']!=''){   $m[$i]  = $key['LVL_'.$i.'_table_value'];}
		if(isset($key['LVL_'.$i.'_imagen'])&&$key['LVL_'.$i.'_imagen']!=''){      $t[$i]  = $key['LVL_'.$i.'_imagen'];}

	}

    if( $d['1']!=''){
		$array3d[$d['1']]['id']         = $d['1'];
		$array3d[$d['1']]['Nombre']     = $n['1'];
		$array3d[$d['1']]['Codigo']     = $c['1'];
		$array3d[$d['1']]['Tipo']       = $u['1'];
		$array3d[$d['1']]['Licitacion'] = $x['1'];
		$array3d[$d['1']]['Tabla']      = $y['1'];
		$array3d[$d['1']]['Valor']      = $m['1'];
		$array3d[$d['1']]['Imagen']     = $t['1'];
	}
	if( $d['2']!=''){
		$array3d[$d['1']][$d['2']]['id']         = $d['2'];
		$array3d[$d['1']][$d['2']]['Nombre']     = $n['2'];
		$array3d[$d['1']][$d['2']]['Codigo']     = $c['2'];
		$array3d[$d['1']][$d['2']]['Tipo']       = $u['2'];
		$array3d[$d['1']][$d['2']]['Licitacion'] = $x['2'];
		$array3d[$d['1']][$d['2']]['Tabla']      = $y['2'];
		$array3d[$d['1']][$d['2']]['Valor']      = $m['2'];
		$array3d[$d['1']][$d['2']]['Imagen']     = $t['2'];
	}
	if( $d['3']!=''){
		$array3d[$d['1']][$d['2']][$d['3']]['id']         = $d['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Nombre']     = $n['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Codigo']     = $c['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Tipo']       = $u['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Licitacion'] = $x['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Tabla']      = $y['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Valor']      = $m['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Imagen']     = $t['3'];
	}
	if( $d['4']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']         = $d['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre']     = $n['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Codigo']     = $c['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tipo']       = $u['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Licitacion'] = $x['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tabla']      = $y['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Valor']      = $m['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Imagen']     = $t['4'];
	}
	if( $d['5']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']         = $d['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre']     = $n['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Codigo']     = $c['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tipo']       = $u['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Licitacion'] = $x['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tabla']      = $y['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Valor']      = $m['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Imagen']     = $t['5'];
	}
	if( $d['6']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['id']         = $d['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Nombre']     = $n['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Codigo']     = $c['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tipo']       = $u['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Licitacion'] = $x['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tabla']      = $y['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Valor']      = $m['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Imagen']     = $t['6'];
	}
	if( $d['7']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['id']         = $d['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Nombre']     = $n['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Codigo']     = $c['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tipo']       = $u['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Licitacion'] = $x['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tabla']      = $y['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Valor']      = $m['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Imagen']     = $t['7'];
	}
	if( $d['8']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['id']         = $d['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Nombre']     = $n['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Codigo']     = $c['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tipo']       = $u['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Licitacion'] = $x['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tabla']      = $y['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Valor']      = $m['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Imagen']     = $t['8'];
	}
	if( $d['9']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['id']         = $d['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Nombre']     = $n['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Codigo']     = $c['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tipo']       = $u['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Licitacion'] = $x['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tabla']      = $y['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Valor']      = $m['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Imagen']     = $t['9'];
	}
	if( $d['10']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['id']         = $d['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Nombre']     = $n['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Codigo']     = $c['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tipo']       = $u['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Licitacion'] = $x['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tabla']      = $y['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Valor']      = $m['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Imagen']     = $t['10'];
	}
	if( $d['11']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['id']         = $d['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Nombre']     = $n['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Codigo']     = $c['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Tipo']       = $u['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Licitacion'] = $x['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Tabla']      = $y['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Valor']      = $m['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Imagen']     = $t['11'];
	}
	if( $d['12']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['id']         = $d['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Nombre']     = $n['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Codigo']     = $c['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Tipo']       = $u['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Licitacion'] = $x['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Tabla']      = $y['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Valor']      = $m['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Imagen']     = $t['12'];
	}
	if( $d['13']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['id']         = $d['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Nombre']     = $n['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Codigo']     = $c['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Tipo']       = $u['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Licitacion'] = $x['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Tabla']      = $y['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Valor']      = $m['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Imagen']     = $t['13'];
	}
	if( $d['14']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['id']         = $d['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Nombre']     = $n['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Codigo']     = $c['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Tipo']       = $u['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Licitacion'] = $x['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Tabla']      = $y['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Valor']      = $m['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Imagen']     = $t['14'];
	}
	if( $d['15']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['id']         = $d['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Nombre']     = $n['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Codigo']     = $c['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Tipo']       = $u['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Licitacion'] = $x['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Tabla']      = $y['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Valor']      = $m['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Imagen']     = $t['15'];
	}
	/*if( $d['16']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['id']         = $d['16'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Nombre']     = $n['16'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Codigo']     = $c['16'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Tipo']       = $u['16'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Licitacion'] = $x['16'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Tabla']      = $y['16'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Valor']      = $m['16'];
	}
	if( $d['17']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['id']         = $d['17'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Nombre']     = $n['17'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Codigo']     = $c['17'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Tipo']       = $u['17'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Licitacion'] = $x['17'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Tabla']      = $y['17'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Valor']      = $m['17'];
	}
	if( $d['18']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['id']         = $d['18'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Nombre']     = $n['18'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Codigo']     = $c['18'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Tipo']       = $u['18'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Licitacion'] = $x['18'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Tabla']      = $y['18'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Valor']      = $m['18'];
	}
	if( $d['19']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['id']         = $d['19'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Nombre']     = $n['19'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Codigo']     = $c['19'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Tipo']       = $u['19'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Licitacion'] = $x['19'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Tabla']      = $y['19'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Valor']      = $m['19'];
	}
	if( $d['20']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['id']         = $d['20'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Nombre']     = $n['20'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Codigo']     = $c['20'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Tipo']       = $u['20'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Licitacion'] = $x['20'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Tabla']      = $y['20'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Valor']      = $m['20'];
	}
	if( $d['21']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['id']         = $d['21'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Nombre']     = $n['21'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Codigo']     = $c['21'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Tipo']       = $u['21'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Licitacion'] = $x['21'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Tabla']      = $y['21'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Valor']      = $m['21'];
	}
	if( $d['22']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['id']         = $d['22'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Nombre']     = $n['22'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Codigo']     = $c['22'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Tipo']       = $u['22'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Licitacion'] = $x['22'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Tabla']      = $y['22'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Valor']      = $m['22'];
	}
	if( $d['23']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['id']         = $d['23'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Nombre']     = $n['23'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Codigo']     = $c['23'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Tipo']       = $u['23'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Licitacion'] = $x['23'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Tabla']      = $y['23'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Valor']      = $m['23'];
	}
	if( $d['24']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['id']         = $d['24'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Nombre']     = $n['24'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Codigo']     = $c['24'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Tipo']       = $u['24'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Licitacion'] = $x['24'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Tabla']      = $y['24'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Valor']      = $m['24'];
	}
	if( $d['25']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['id']         = $d['25'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Nombre']     = $n['25'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Codigo']     = $c['25'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Tipo']       = $u['25'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Licitacion'] = $x['25'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Tabla']      = $y['25'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Valor']      = $m['25'];
	}*/

}

function arrayToUL(array $array, array $TipoMaq, array $Trabajo, $lv, $rowlevel,$location, $nmax)
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
				echo '<div class="pull-left">';
					if(isset($value['Imagen'])&&$value['Imagen']!=''){echo '<div class="btn-group" style="width: 35px;" ><a href="#" title="Click Preview Imagen" class="btn btn-primary btn-sm tooltip pop" src="upload/'.$value['Imagen'].'"><i class="fa fa-picture-o" aria-hidden="true"></i></a></div>';}
					echo '<strong>'.$TipoMaq[$value['Tipo']]['Nombre'].':</strong> ';
					if(isset($value['Codigo'])&&$value['Codigo']!=''){echo ' '.$value['Codigo'].' - ';}
					echo $value['Nombre'];
					if ($value['Tipo']==2&&isset($Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Nombre'])){
						echo '<strong> (F. Trabajo: ';
						if(isset($Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Codigo'])&&$Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Codigo']!=''){
							echo $Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Codigo'].' - ';
						}
						echo $Trabajo[$value['Licitacion']][$value['Tabla']][$value['Valor']]['Nombre'];
						echo ')</strong>';
					}
				echo '</div>';

				echo '<div class="btn-group pull-right" >';
					//Boton para agregar familia tarea componente
					if ($rowlevel>=2&&$value['Tipo']==2){
						echo '<a href="'.$loc.'&addTrabajo='.$value['id'].'&lvl='.$lv.'" title="Agregar Familia Trabajo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-cogs" aria-hidden="true"></i></a>';
					}
					//Boton para editar
					if ($rowlevel>=2){
						echo '<a href="'.$loc.'&edit='.$value['id'].'&lvl='.$lv.'" title="Editar este Componente" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
					}
					//Boton para editar imagen
					if ($rowlevel>=2){
						echo '<a href="'.$loc.'&editimg='.$value['id'].'&lvl='.$lv.'" title="Editar imagen Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
					}
					//Boton para clonar
					if ($rowlevel>=2){
						echo '<a href="'.$loc.'&clone_compo='.$value['id'].'&lvl='.$lv.'" title="Clonar este Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a>';
					}
					//boton para eliminar
					if ($rowlevel>=3){
						$ubicacion = $loc.'&del_idLevel='.simpleEncode($value['id'], fecha_actual()).'&lvl='.$lv.'&nmax='.$nmax;
						$dialogo   = '¿Realmente deseas eliminar todos los datos relacionados a esta Rama?';
						echo '<a onClick="dialogBox(\''.$ubicacion.'\', \''.$dialogo.'\')" title="Borrar este Componente" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
					}
				echo '</div>';

				//Boton para crear nueva subrama condicionado solo a componentes
				if ($value['Tipo']==2){
					echo '<div class="btn-group pull-right" style="margin-right:5px;" >';
						if ($rowlevel>=1){
							$xc = $lv + 1;
							echo '<a href="'.$loc.'&new=true&lvl='.$xc.'" title="Crear Sub-Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-file-o" aria-hidden="true"></i></a>';
						}
					echo '</div>';
				}
				echo '<div class="clearfix"></div>';
			echo '</div>';
		}
        if (!empty($value) && is_array($value)){

            echo arrayToUL($value, $TipoMaq, $Trabajo, $lv, $rowlevel,$loc, $nmax);
        }
        echo '</li>';
    }
    echo '</ul>';
}



?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Unidades de Negocio', $rowData['Nombre'], 'Componentes'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'].'&new=true&lvl=1'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Componente</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'unidad_negocio_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'unidad_negocio_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'unidad_negocio_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'unidad_negocio_listado_ubicacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicación</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha Tecnica</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
						<?php
						//Uso de componentes
						if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){ ?>
							<li class="active"><a href="<?php echo 'unidad_negocio_listado_componentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Componentes</a></li>
						<?php } ?>
						<?php
						//uso de matriz de analisis
						if(isset($rowData['idConfig_2'])&&$rowData['idConfig_2']==1){ ?>
							<li class=""><a href="<?php echo 'unidad_negocio_listado_matriz_analisis.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-microchip" aria-hidden="true"></i> Matriz Analisis</a></li>
						<?php } ?>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">

			<?php //Se imprime el arbol
			echo arrayToUL($array3d, $TipoMaq, $Trabajo, 0, $rowlevel['level'],$new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'], $nmax);
			?>

			<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<img src="" class="imagepreview" style="width: 100%;padding: 15px;" >
						</div>
					</div>
				</div>
			</div>
			<script>
				$(function() {
					$('.pop').on('click', function() {
						$('.imagepreview').attr('src',$(this).attr('src'));
						$('#imagemodal').modal('show');
					});
				});
			</script>

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
