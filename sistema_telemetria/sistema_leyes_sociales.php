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
$original = "sistema_leyes_sociales.php";
$location = $original;
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
	require_once 'A1XRXS_sys/xrxs_form/sistema_leyes_sociales.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/sistema_leyes_sociales.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/sistema_leyes_sociales.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Mantenedor Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Mantenedor Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Mantenedor Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);

// consulto los datos
$query = "SELECT AFP_idCentroCosto,AFP_idLevel_1,
AFP_idLevel_2,AFP_idLevel_3,AFP_idLevel_4,AFP_idLevel_5,SALUD_idCentroCosto,
SALUD_idLevel_1,SALUD_idLevel_2,SALUD_idLevel_3,SALUD_idLevel_4,SALUD_idLevel_5,
SEGURIDAD_idCentroCosto,SEGURIDAD_idLevel_1,SEGURIDAD_idLevel_2,SEGURIDAD_idLevel_3,SEGURIDAD_idLevel_4,
SEGURIDAD_idLevel_5

FROM `sistema_leyes_sociales`
WHERE idMantenedor = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);
//sistema
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificación Mantenedor</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($AFP_idCentroCosto)){            $x2  = $AFP_idCentroCosto;            }else{$x2  = $rowData['AFP_idCentroCosto'];}
				if(isset($AFP_idLevel_1)){                $x3  = $AFP_idLevel_1;                }else{$x3  = $rowData['AFP_idLevel_1'];}
				if(isset($AFP_idLevel_2)){                $x4  = $AFP_idLevel_2;                }else{$x4  = $rowData['AFP_idLevel_2'];}
				if(isset($AFP_idLevel_3)){                $x5  = $AFP_idLevel_3;                }else{$x5  = $rowData['AFP_idLevel_3'];}
				if(isset($AFP_idLevel_4)){                $x6  = $AFP_idLevel_4;                }else{$x6  = $rowData['AFP_idLevel_4'];}
				if(isset($AFP_idLevel_5)){                $x7  = $AFP_idLevel_5;                }else{$x7  = $rowData['AFP_idLevel_5'];}
				if(isset($SALUD_idCentroCosto)){          $x8  = $SALUD_idCentroCosto;          }else{$x8  = $rowData['SALUD_idCentroCosto'];}
				if(isset($SALUD_idLevel_1)){              $x9  = $SALUD_idLevel_1;              }else{$x9  = $rowData['SALUD_idLevel_1'];}
				if(isset($SALUD_idLevel_2)){              $x10 = $SALUD_idLevel_2;              }else{$x10 = $rowData['SALUD_idLevel_2'];}
				if(isset($SALUD_idLevel_3)){              $x11 = $SALUD_idLevel_3;              }else{$x11 = $rowData['SALUD_idLevel_3'];}
				if(isset($SALUD_idLevel_4)){              $x12 = $SALUD_idLevel_4;              }else{$x12 = $rowData['SALUD_idLevel_4'];}
				if(isset($SALUD_idLevel_5)){              $x13 = $SALUD_idLevel_5;              }else{$x13 = $rowData['SALUD_idLevel_5'];}
				if(isset($SEGURIDAD_idCentroCosto)){      $x14 = $SEGURIDAD_idCentroCosto;      }else{$x14 = $rowData['SEGURIDAD_idCentroCosto'];}
				if(isset($SEGURIDAD_idLevel_1)){          $x15 = $SEGURIDAD_idLevel_1;          }else{$x15 = $rowData['SEGURIDAD_idLevel_1'];}
				if(isset($SEGURIDAD_idLevel_2)){          $x16 = $SEGURIDAD_idLevel_2;          }else{$x16 = $rowData['SEGURIDAD_idLevel_2'];}
				if(isset($SEGURIDAD_idLevel_3)){          $x17 = $SEGURIDAD_idLevel_3;          }else{$x17 = $rowData['SEGURIDAD_idLevel_3'];}
				if(isset($SEGURIDAD_idLevel_4)){          $x18 = $SEGURIDAD_idLevel_4;          }else{$x18 = $rowData['SEGURIDAD_idLevel_4'];}
				if(isset($SEGURIDAD_idLevel_5)){          $x19 = $SEGURIDAD_idLevel_5;          }else{$x19 = $rowData['SEGURIDAD_idLevel_5'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Pension');
				$Form_Inputs->form_select_depend5('Centro de Costo', 'AFP_idCentroCosto',  $x2,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
							             'Nivel 1', 'AFP_idLevel_1',  $x3,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
							             'Nivel 2', 'AFP_idLevel_2',  $x4,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
							             'Nivel 3', 'AFP_idLevel_3',  $x5,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
							             'Nivel 4', 'AFP_idLevel_4',  $x6,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
							             'Nivel 5', 'AFP_idLevel_5',  $x7,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
							             $dbConn, 'form1');

				$Form_Inputs->form_tittle(3, 'Salud');
				$Form_Inputs->form_select_depend5('Centro de Costo', 'SALUD_idCentroCosto',  $x8,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
							             'Nivel 1', 'SALUD_idLevel_1',  $x9,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
							             'Nivel 2', 'SALUD_idLevel_2',  $x10,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
							             'Nivel 3', 'SALUD_idLevel_3',  $x11,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
							             'Nivel 4', 'SALUD_idLevel_4',  $x12,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
							             'Nivel 5', 'SALUD_idLevel_5',  $x13,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
							             $dbConn, 'form1');

				$Form_Inputs->form_tittle(3, 'Seguridad');
				$Form_Inputs->form_select_depend5('Centro de Costo', 'SEGURIDAD_idCentroCosto',  $x14,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
							             'Nivel 1', 'SEGURIDAD_idLevel_1',  $x15,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
							             'Nivel 2', 'SEGURIDAD_idLevel_2',  $x16,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
							             'Nivel 3', 'SEGURIDAD_idLevel_3',  $x17,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
							             'Nivel 4', 'SEGURIDAD_idLevel_4',  $x18,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
							             'Nivel 5', 'SEGURIDAD_idLevel_5',  $x19,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
							             $dbConn, 'form1');

				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idMantenedor', $_GET['id'], 2);
				?>

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
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//sistema
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Mantenedor</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($AFP_idCentroCosto)){        $x2  = $AFP_idCentroCosto;          }else{$x2  = '';}
				if(isset($AFP_idLevel_1)){            $x3  = $AFP_idLevel_1;              }else{$x3  = '';}
				if(isset($AFP_idLevel_2)){            $x4  = $AFP_idLevel_2;              }else{$x4  = '';}
				if(isset($AFP_idLevel_3)){            $x5  = $AFP_idLevel_3;              }else{$x5  = '';}
				if(isset($AFP_idLevel_4)){            $x6  = $AFP_idLevel_4;              }else{$x6  = '';}
				if(isset($AFP_idLevel_5)){            $x7  = $AFP_idLevel_5;              }else{$x7  = '';}
				if(isset($SALUD_idCentroCosto)){      $x8  = $SALUD_idCentroCosto;        }else{$x8  = '';}
				if(isset($SALUD_idLevel_1)){          $x9  = $SALUD_idLevel_1;            }else{$x9  = '';}
				if(isset($SALUD_idLevel_2)){          $x10 = $SALUD_idLevel_2;            }else{$x10 = '';}
				if(isset($SALUD_idLevel_3)){          $x11 = $SALUD_idLevel_3;            }else{$x11 = '';}
				if(isset($SALUD_idLevel_4)){          $x12 = $SALUD_idLevel_4;            }else{$x12 = '';}
				if(isset($SALUD_idLevel_5)){          $x13 = $SALUD_idLevel_5;            }else{$x13 = '';}
				if(isset($SEGURIDAD_idCentroCosto)){  $x14 = $SEGURIDAD_idCentroCosto;    }else{$x14 = '';}
				if(isset($SEGURIDAD_idLevel_1)){      $x15 = $SEGURIDAD_idLevel_1;        }else{$x15 = '';}
				if(isset($SEGURIDAD_idLevel_2)){      $x16 = $SEGURIDAD_idLevel_2;        }else{$x16 = '';}
				if(isset($SEGURIDAD_idLevel_3)){      $x17 = $SEGURIDAD_idLevel_3;        }else{$x17 = '';}
				if(isset($SEGURIDAD_idLevel_4)){      $x18 = $SEGURIDAD_idLevel_4;        }else{$x18 = '';}
				if(isset($SEGURIDAD_idLevel_5)){      $x19 = $SEGURIDAD_idLevel_5;        }else{$x19 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Pension');
				$Form_Inputs->form_select_depend5('Centro de Costo', 'AFP_idCentroCosto',  $x2,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
							             'Nivel 1', 'AFP_idLevel_1',  $x3,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
							             'Nivel 2', 'AFP_idLevel_2',  $x4,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
							             'Nivel 3', 'AFP_idLevel_3',  $x5,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
							             'Nivel 4', 'AFP_idLevel_4',  $x6,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
							             'Nivel 5', 'AFP_idLevel_5',  $x7,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
							             $dbConn, 'form1');

				$Form_Inputs->form_tittle(3, 'Salud');
				$Form_Inputs->form_select_depend5('Centro de Costo', 'SALUD_idCentroCosto',  $x8,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
							             'Nivel 1', 'SALUD_idLevel_1',  $x9,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
							             'Nivel 2', 'SALUD_idLevel_2',  $x10,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
							             'Nivel 3', 'SALUD_idLevel_3',  $x11,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
							             'Nivel 4', 'SALUD_idLevel_4',  $x12,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
							             'Nivel 5', 'SALUD_idLevel_5',  $x13,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
							             $dbConn, 'form1');

				$Form_Inputs->form_tittle(3, 'Seguridad');
				$Form_Inputs->form_select_depend5('Centro de Costo', 'SEGURIDAD_idCentroCosto',  $x14,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
							             'Nivel 1', 'SEGURIDAD_idLevel_1',  $x15,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
							             'Nivel 2', 'SEGURIDAD_idLevel_2',  $x16,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
							             'Nivel 3', 'SEGURIDAD_idLevel_3',  $x17,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
							             'Nivel 4', 'SEGURIDAD_idLevel_4',  $x18,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
							             'Nivel 5', 'SEGURIDAD_idLevel_5',  $x19,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
							             $dbConn, 'form1');

				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
// Se trae un listado con todos los elementos
$arrImpuestos = array();
$query = "SELECT 
sistema_leyes_sociales.idMantenedor, 
AFP_Centro.Nombre AS AFP_CC_Nombre,
AFP_Centro_lv_1.Nombre AS AFP_CC_Level_1,
AFP_Centro_lv_2.Nombre AS AFP_CC_Level_2,
AFP_Centro_lv_3.Nombre AS AFP_CC_Level_3,
AFP_Centro_lv_4.Nombre AS AFP_CC_Level_4,
AFP_Centro_lv_5.Nombre AS AFP_CC_Level_5,
SALUD_Centro.Nombre AS SALUD_CC_Nombre,
SALUD_Centro_lv_1.Nombre AS SALUD_CC_Level_1,
SALUD_Centro_lv_2.Nombre AS SALUD_CC_Level_2,
SALUD_Centro_lv_3.Nombre AS SALUD_CC_Level_3,
SALUD_Centro_lv_4.Nombre AS SALUD_CC_Level_4,
SALUD_Centro_lv_5.Nombre AS SALUD_CC_Level_5,
SEGURIDAD_Centro.Nombre AS SEGURIDAD_CC_Nombre,
SEGURIDAD_Centro_lv_1.Nombre AS SEGURIDAD_CC_Level_1,
SEGURIDAD_Centro_lv_2.Nombre AS SEGURIDAD_CC_Level_2,
SEGURIDAD_Centro_lv_3.Nombre AS SEGURIDAD_CC_Level_3,
SEGURIDAD_Centro_lv_4.Nombre AS SEGURIDAD_CC_Level_4,
SEGURIDAD_Centro_lv_5.Nombre AS SEGURIDAD_CC_Level_5

FROM `sistema_leyes_sociales`
LEFT JOIN `centrocosto_listado`          AFP_Centro               ON AFP_Centro.idCentroCosto          = sistema_leyes_sociales.AFP_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  AFP_Centro_lv_1          ON AFP_Centro_lv_1.idLevel_1         = sistema_leyes_sociales.AFP_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  AFP_Centro_lv_2          ON AFP_Centro_lv_2.idLevel_2         = sistema_leyes_sociales.AFP_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  AFP_Centro_lv_3          ON AFP_Centro_lv_3.idLevel_3         = sistema_leyes_sociales.AFP_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  AFP_Centro_lv_4          ON AFP_Centro_lv_4.idLevel_4         = sistema_leyes_sociales.AFP_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  AFP_Centro_lv_5          ON AFP_Centro_lv_5.idLevel_5         = sistema_leyes_sociales.AFP_idLevel_5
LEFT JOIN `centrocosto_listado`          SALUD_Centro             ON SALUD_Centro.idCentroCosto        = sistema_leyes_sociales.SALUD_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  SALUD_Centro_lv_1        ON SALUD_Centro_lv_1.idLevel_1       = sistema_leyes_sociales.SALUD_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  SALUD_Centro_lv_2        ON SALUD_Centro_lv_2.idLevel_2       = sistema_leyes_sociales.SALUD_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  SALUD_Centro_lv_3        ON SALUD_Centro_lv_3.idLevel_3       = sistema_leyes_sociales.SALUD_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  SALUD_Centro_lv_4        ON SALUD_Centro_lv_4.idLevel_4       = sistema_leyes_sociales.SALUD_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  SALUD_Centro_lv_5        ON SALUD_Centro_lv_5.idLevel_5       = sistema_leyes_sociales.SALUD_idLevel_5
LEFT JOIN `centrocosto_listado`          SEGURIDAD_Centro         ON SEGURIDAD_Centro.idCentroCosto    = sistema_leyes_sociales.SEGURIDAD_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  SEGURIDAD_Centro_lv_1    ON SEGURIDAD_Centro_lv_1.idLevel_1   = sistema_leyes_sociales.SEGURIDAD_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  SEGURIDAD_Centro_lv_2    ON SEGURIDAD_Centro_lv_2.idLevel_2   = sistema_leyes_sociales.SEGURIDAD_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  SEGURIDAD_Centro_lv_3    ON SEGURIDAD_Centro_lv_3.idLevel_3   = sistema_leyes_sociales.SEGURIDAD_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  SEGURIDAD_Centro_lv_4    ON SEGURIDAD_Centro_lv_4.idLevel_4   = sistema_leyes_sociales.SEGURIDAD_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  SEGURIDAD_Centro_lv_5    ON SEGURIDAD_Centro_lv_5.idLevel_5   = sistema_leyes_sociales.SEGURIDAD_idLevel_5
				
WHERE sistema_leyes_sociales.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrImpuestos,$row );
}
//cuento la cantidad de items creados
$ndata_1 = db_select_nrows (false, 'idSistema', 'sistema_leyes_sociales', '', "idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['idSistema'], $original, 'ndata_1');
			
			
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">
	<?php if (isset($ndata_1)&&$ndata_1==0){ ?>
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>?new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Mantenedor</a><?php } ?>
	<?php } ?>
</div>
                    
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Mantenedor</h5>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Datos</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrImpuestos as $imp) { ?>
					<tr class="odd">
						<td>
							<?php
							if(isset($imp['AFP_CC_Nombre'])&&$imp['AFP_CC_Nombre']!=''){
								echo '<strong>Centro Costo IVA: </strong>'.$imp['AFP_CC_Nombre'];
								if(isset($imp['AFP_CC_Level_1'])&&$imp['AFP_CC_Level_1']!=''){echo ' - '.$imp['AFP_CC_Level_1'];}
								if(isset($imp['AFP_CC_Level_2'])&&$imp['AFP_CC_Level_2']!=''){echo ' - '.$imp['AFP_CC_Level_2'];}
								if(isset($imp['AFP_CC_Level_3'])&&$imp['AFP_CC_Level_3']!=''){echo ' - '.$imp['AFP_CC_Level_3'];}
								if(isset($imp['AFP_CC_Level_4'])&&$imp['AFP_CC_Level_4']!=''){echo ' - '.$imp['AFP_CC_Level_4'];}
								if(isset($imp['AFP_CC_Level_5'])&&$imp['AFP_CC_Level_5']!=''){echo ' - '.$imp['AFP_CC_Level_5'];}
								echo '<br/>';
							}
							if(isset($imp['SALUD_CC_Nombre'])&&$imp['SALUD_CC_Nombre']!=''){
								echo '<strong>Centro Costo PPM: </strong>'.$imp['SALUD_CC_Nombre'];
								if(isset($imp['SALUD_CC_Level_1'])&&$imp['SALUD_CC_Level_1']!=''){echo ' - '.$imp['SALUD_CC_Level_1'];}
								if(isset($imp['SALUD_CC_Level_2'])&&$imp['SALUD_CC_Level_2']!=''){echo ' - '.$imp['SALUD_CC_Level_2'];}
								if(isset($imp['SALUD_CC_Level_3'])&&$imp['SALUD_CC_Level_3']!=''){echo ' - '.$imp['SALUD_CC_Level_3'];}
								if(isset($imp['SALUD_CC_Level_4'])&&$imp['SALUD_CC_Level_4']!=''){echo ' - '.$imp['SALUD_CC_Level_4'];}
								if(isset($imp['SALUD_CC_Level_5'])&&$imp['SALUD_CC_Level_5']!=''){echo ' - '.$imp['SALUD_CC_Level_5'];}
								echo '<br/>';
							}
							if(isset($imp['SEGURIDAD_CC_Nombre'])&&$imp['SEGURIDAD_CC_Nombre']!=''){
								echo '<strong>Centro Costo Retenciones: </strong>'.$imp['SEGURIDAD_CC_Nombre'];
								if(isset($imp['SEGURIDAD_CC_Level_1'])&&$imp['SEGURIDAD_CC_Level_1']!=''){echo ' - '.$imp['SEGURIDAD_CC_Level_1'];}
								if(isset($imp['SEGURIDAD_CC_Level_2'])&&$imp['SEGURIDAD_CC_Level_2']!=''){echo ' - '.$imp['SEGURIDAD_CC_Level_2'];}
								if(isset($imp['SEGURIDAD_CC_Level_3'])&&$imp['SEGURIDAD_CC_Level_3']!=''){echo ' - '.$imp['SEGURIDAD_CC_Level_3'];}
								if(isset($imp['SEGURIDAD_CC_Level_4'])&&$imp['SEGURIDAD_CC_Level_4']!=''){echo ' - '.$imp['SEGURIDAD_CC_Level_4'];}
								if(isset($imp['SEGURIDAD_CC_Level_5'])&&$imp['SEGURIDAD_CC_Level_5']!=''){echo ' - '.$imp['SEGURIDAD_CC_Level_5'];}
								echo '<br/>';
							}
							?>
						</td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'?id='.$imp['idMantenedor']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'?del='.simpleEncode($imp['idMantenedor'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar los datos del mantenedor?'; ?>
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
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
