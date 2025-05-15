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
$original = "sistema_leyes_fiscales.php";
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
	require_once 'A1XRXS_sys/xrxs_form/sistema_leyes_fiscales.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/sistema_leyes_fiscales.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/sistema_leyes_fiscales.php';
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
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Porcentaje_PPM,IVA_idCentroCosto,IVA_idLevel_1,IVA_idLevel_2,IVA_idLevel_3,IVA_idLevel_4,IVA_idLevel_5,PPM_idCentroCosto,PPM_idLevel_1,
	PPM_idLevel_2,PPM_idLevel_3,PPM_idLevel_4,PPM_idLevel_5,RET_idCentroCosto,RET_idLevel_1,RET_idLevel_2,RET_idLevel_3,RET_idLevel_4,RET_idLevel_5,
	IMPRENT_idCentroCosto,IMPRENT_idLevel_1,IMPRENT_idLevel_2,IMPRENT_idLevel_3,IMPRENT_idLevel_4,IMPRENT_idLevel_5,Porcentaje_Ret_Boletas';
	$SIS_join  = '';
	$SIS_where = 'idMantenedor ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'sistema_leyes_fiscales', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
					if(isset($Porcentaje_PPM)){           $x0  = $Porcentaje_PPM;           }else{$x0  = $rowData['Porcentaje_PPM'];}
					if(isset($Porcentaje_Ret_Boletas)){   $x1  = $Porcentaje_Ret_Boletas;   }else{$x1  = $rowData['Porcentaje_Ret_Boletas'];}
					if(isset($IVA_idCentroCosto)){        $x2  = $IVA_idCentroCosto;        }else{$x2  = $rowData['IVA_idCentroCosto'];}
					if(isset($IVA_idLevel_1)){            $x3  = $IVA_idLevel_1;            }else{$x3  = $rowData['IVA_idLevel_1'];}
					if(isset($IVA_idLevel_2)){            $x4  = $IVA_idLevel_2;            }else{$x4  = $rowData['IVA_idLevel_2'];}
					if(isset($IVA_idLevel_3)){            $x5  = $IVA_idLevel_3;            }else{$x5  = $rowData['IVA_idLevel_3'];}
					if(isset($IVA_idLevel_4)){            $x6  = $IVA_idLevel_4;            }else{$x6  = $rowData['IVA_idLevel_4'];}
					if(isset($IVA_idLevel_5)){            $x7  = $IVA_idLevel_5;            }else{$x7  = $rowData['IVA_idLevel_5'];}
					if(isset($PPM_idCentroCosto)){        $x8  = $PPM_idCentroCosto;        }else{$x8  = $rowData['PPM_idCentroCosto'];}
					if(isset($PPM_idLevel_1)){            $x9  = $PPM_idLevel_1;            }else{$x9  = $rowData['PPM_idLevel_1'];}
					if(isset($PPM_idLevel_2)){            $x10 = $PPM_idLevel_2;            }else{$x10 = $rowData['PPM_idLevel_2'];}
					if(isset($PPM_idLevel_3)){            $x11 = $PPM_idLevel_3;            }else{$x11 = $rowData['PPM_idLevel_3'];}
					if(isset($PPM_idLevel_4)){            $x12 = $PPM_idLevel_4;            }else{$x12 = $rowData['PPM_idLevel_4'];}
					if(isset($PPM_idLevel_5)){            $x13 = $PPM_idLevel_5;            }else{$x13 = $rowData['PPM_idLevel_5'];}
					if(isset($RET_idCentroCosto)){        $x14 = $RET_idCentroCosto;        }else{$x14 = $rowData['RET_idCentroCosto'];}
					if(isset($RET_idLevel_1)){            $x15 = $RET_idLevel_1;            }else{$x15 = $rowData['RET_idLevel_1'];}
					if(isset($RET_idLevel_2)){            $x16 = $RET_idLevel_2;            }else{$x16 = $rowData['RET_idLevel_2'];}
					if(isset($RET_idLevel_3)){            $x17 = $RET_idLevel_3;            }else{$x17 = $rowData['RET_idLevel_3'];}
					if(isset($RET_idLevel_4)){            $x18 = $RET_idLevel_4;            }else{$x18 = $rowData['RET_idLevel_4'];}
					if(isset($RET_idLevel_5)){            $x19 = $RET_idLevel_5;            }else{$x19 = $rowData['RET_idLevel_5'];}
					if(isset($IMPRENT_idCentroCosto)){    $x20 = $IMPRENT_idCentroCosto;    }else{$x20 = $rowData['IMPRENT_idCentroCosto'];}
					if(isset($IMPRENT_idLevel_1)){        $x21 = $IMPRENT_idLevel_1;        }else{$x21 = $rowData['IMPRENT_idLevel_1'];}
					if(isset($IMPRENT_idLevel_2)){        $x22 = $IMPRENT_idLevel_2;        }else{$x22 = $rowData['IMPRENT_idLevel_2'];}
					if(isset($IMPRENT_idLevel_3)){        $x23 = $IMPRENT_idLevel_3;        }else{$x23 = $rowData['IMPRENT_idLevel_3'];}
					if(isset($IMPRENT_idLevel_4)){        $x24 = $IMPRENT_idLevel_4;        }else{$x24 = $rowData['IMPRENT_idLevel_4'];}
					if(isset($IMPRENT_idLevel_5)){        $x25 = $IMPRENT_idLevel_5;        }else{$x25 = $rowData['IMPRENT_idLevel_5'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Porcentajes');
					$Form_Inputs->form_input_number('Porcentaje PPM', 'Porcentaje_PPM', $x0, 2);
					$Form_Inputs->form_input_number('Porcentaje Retencion Boletas', 'Porcentaje_Ret_Boletas', $x1, 2);

					$Form_Inputs->form_tittle(3, 'IVA');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'IVA_idCentroCosto',  $x2,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'IVA_idLevel_1',  $x3,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'IVA_idLevel_2',  $x4,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'IVA_idLevel_3',  $x5,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'IVA_idLevel_4',  $x6,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'IVA_idLevel_5',  $x7,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_tittle(3, 'PPM');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'PPM_idCentroCosto',  $x8,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'PPM_idLevel_1',  $x9,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'PPM_idLevel_2',  $x10,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'PPM_idLevel_3',  $x11,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'PPM_idLevel_4',  $x12,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'PPM_idLevel_5',  $x13,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_tittle(3, 'Retenciones');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'RET_idCentroCosto',  $x14,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'RET_idLevel_1',  $x15,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'RET_idLevel_2',  $x16,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'RET_idLevel_3',  $x17,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'RET_idLevel_4',  $x18,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'RET_idLevel_5',  $x19,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_tittle(3, 'Impuesto a la Renta');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'IMPRENT_idCentroCosto',  $x20,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'IMPRENT_idLevel_1',  $x21,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'IMPRENT_idLevel_2',  $x22,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'IMPRENT_idLevel_3',  $x23,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'IMPRENT_idLevel_4',  $x24,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'IMPRENT_idLevel_5',  $x25,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
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
					if(isset($Porcentaje_PPM)){         $x0  = $Porcentaje_PPM;         }else{$x0  = '';}
					if(isset($Porcentaje_Ret_Boletas)){ $x1  = $Porcentaje_Ret_Boletas; }else{$x1  = '';}
					if(isset($IVA_idCentroCosto)){      $x2  = $IVA_idCentroCosto;      }else{$x2  = '';}
					if(isset($IVA_idLevel_1)){          $x3  = $IVA_idLevel_1;          }else{$x3  = '';}
					if(isset($IVA_idLevel_2)){          $x4  = $IVA_idLevel_2;          }else{$x4  = '';}
					if(isset($IVA_idLevel_3)){          $x5  = $IVA_idLevel_3;          }else{$x5  = '';}
					if(isset($IVA_idLevel_4)){          $x6  = $IVA_idLevel_4;          }else{$x6  = '';}
					if(isset($IVA_idLevel_5)){          $x7  = $IVA_idLevel_5;          }else{$x7  = '';}
					if(isset($PPM_idCentroCosto)){      $x8  = $PPM_idCentroCosto;      }else{$x8  = '';}
					if(isset($PPM_idLevel_1)){          $x9  = $PPM_idLevel_1;          }else{$x9  = '';}
					if(isset($PPM_idLevel_2)){          $x10 = $PPM_idLevel_2;          }else{$x10 = '';}
					if(isset($PPM_idLevel_3)){          $x11 = $PPM_idLevel_3;          }else{$x11 = '';}
					if(isset($PPM_idLevel_4)){          $x12 = $PPM_idLevel_4;          }else{$x12 = '';}
					if(isset($PPM_idLevel_5)){          $x13 = $PPM_idLevel_5;          }else{$x13 = '';}
					if(isset($RET_idCentroCosto)){      $x14 = $RET_idCentroCosto;      }else{$x14 = '';}
					if(isset($RET_idLevel_1)){          $x15 = $RET_idLevel_1;          }else{$x15 = '';}
					if(isset($RET_idLevel_2)){          $x16 = $RET_idLevel_2;          }else{$x16 = '';}
					if(isset($RET_idLevel_3)){          $x17 = $RET_idLevel_3;          }else{$x17 = '';}
					if(isset($RET_idLevel_4)){          $x18 = $RET_idLevel_4;          }else{$x18 = '';}
					if(isset($RET_idLevel_5)){          $x19 = $RET_idLevel_5;          }else{$x19 = '';}
					if(isset($IMPRENT_idCentroCosto)){  $x20 = $IMPRENT_idCentroCosto;  }else{$x20 = '';}
					if(isset($IMPRENT_idLevel_1)){      $x21 = $IMPRENT_idLevel_1;      }else{$x21 = '';}
					if(isset($IMPRENT_idLevel_2)){      $x22 = $IMPRENT_idLevel_2;      }else{$x22 = '';}
					if(isset($IMPRENT_idLevel_3)){      $x23 = $IMPRENT_idLevel_3;      }else{$x23 = '';}
					if(isset($IMPRENT_idLevel_4)){      $x24 = $IMPRENT_idLevel_4;      }else{$x24 = '';}
					if(isset($IMPRENT_idLevel_5)){      $x25 = $IMPRENT_idLevel_5;      }else{$x25 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Porcentajes');
					$Form_Inputs->form_input_number('Porcentaje PPM', 'Porcentaje_PPM', $x0, 2);
					$Form_Inputs->form_input_number('Porcentaje Retencion Boletas', 'Porcentaje_Ret_Boletas', $x1, 2);

					$Form_Inputs->form_tittle(3, 'IVA');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'IVA_idCentroCosto',  $x2,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'IVA_idLevel_1',  $x3,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'IVA_idLevel_2',  $x4,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'IVA_idLevel_3',  $x5,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'IVA_idLevel_4',  $x6,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'IVA_idLevel_5',  $x7,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_tittle(3, 'PPM');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'PPM_idCentroCosto',  $x8,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'PPM_idLevel_1',  $x9,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'PPM_idLevel_2',  $x10,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'PPM_idLevel_3',  $x11,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'PPM_idLevel_4',  $x12,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'PPM_idLevel_5',  $x13,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_tittle(3, 'Retenciones');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'RET_idCentroCosto',  $x14,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'RET_idLevel_1',  $x15,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'RET_idLevel_2',  $x16,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'RET_idLevel_3',  $x17,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'RET_idLevel_4',  $x18,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'RET_idLevel_5',  $x19,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
											$dbConn, 'form1');

					$Form_Inputs->form_tittle(3, 'Impuesto a la Renta');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'IMPRENT_idCentroCosto',  $x20,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $z,   0,
											'Nivel 1', 'IMPRENT_idLevel_1',  $x21,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
											'Nivel 2', 'IMPRENT_idLevel_2',  $x22,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
											'Nivel 3', 'IMPRENT_idLevel_3',  $x23,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
											'Nivel 4', 'IMPRENT_idLevel_4',  $x24,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
											'Nivel 5', 'IMPRENT_idLevel_5',  $x25,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
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
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	sistema_leyes_fiscales.idMantenedor,
	sistema_leyes_fiscales.Porcentaje_PPM,
	sistema_leyes_fiscales.Porcentaje_Ret_Boletas,
	IVA_Centro.Nombre AS IVA_CC_Nombre,
	IVA_Centro_lv_1.Nombre AS IVA_CC_Level_1,
	IVA_Centro_lv_2.Nombre AS IVA_CC_Level_2,
	IVA_Centro_lv_3.Nombre AS IVA_CC_Level_3,
	IVA_Centro_lv_4.Nombre AS IVA_CC_Level_4,
	IVA_Centro_lv_5.Nombre AS IVA_CC_Level_5,
	PPM_Centro.Nombre AS PPM_CC_Nombre,
	PPM_Centro_lv_1.Nombre AS PPM_CC_Level_1,
	PPM_Centro_lv_2.Nombre AS PPM_CC_Level_2,
	PPM_Centro_lv_3.Nombre AS PPM_CC_Level_3,
	PPM_Centro_lv_4.Nombre AS PPM_CC_Level_4,
	PPM_Centro_lv_5.Nombre AS PPM_CC_Level_5,
	RET_Centro.Nombre AS RET_CC_Nombre,
	RET_Centro_lv_1.Nombre AS RET_CC_Level_1,
	RET_Centro_lv_2.Nombre AS RET_CC_Level_2,
	RET_Centro_lv_3.Nombre AS RET_CC_Level_3,
	RET_Centro_lv_4.Nombre AS RET_CC_Level_4,
	RET_Centro_lv_5.Nombre AS RET_CC_Level_5,
	IMPRENT_Centro.Nombre AS IMPRENT_CC_Nombre,
	IMPRENT_Centro_lv_1.Nombre AS IMPRENT_CC_Level_1,
	IMPRENT_Centro_lv_2.Nombre AS IMPRENT_CC_Level_2,
	IMPRENT_Centro_lv_3.Nombre AS IMPRENT_CC_Level_3,
	IMPRENT_Centro_lv_4.Nombre AS IMPRENT_CC_Level_4,
	IMPRENT_Centro_lv_5.Nombre AS IMPRENT_CC_Level_5';
	$SIS_join  = '
	LEFT JOIN `centrocosto_listado`          IVA_Centro             ON IVA_Centro.idCentroCosto        = sistema_leyes_fiscales.IVA_idCentroCosto
	LEFT JOIN `centrocosto_listado_level_1`  IVA_Centro_lv_1        ON IVA_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.IVA_idLevel_1
	LEFT JOIN `centrocosto_listado_level_2`  IVA_Centro_lv_2        ON IVA_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.IVA_idLevel_2
	LEFT JOIN `centrocosto_listado_level_3`  IVA_Centro_lv_3        ON IVA_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.IVA_idLevel_3
	LEFT JOIN `centrocosto_listado_level_4`  IVA_Centro_lv_4        ON IVA_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.IVA_idLevel_4
	LEFT JOIN `centrocosto_listado_level_5`  IVA_Centro_lv_5        ON IVA_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.IVA_idLevel_5
	LEFT JOIN `centrocosto_listado`          PPM_Centro             ON PPM_Centro.idCentroCosto        = sistema_leyes_fiscales.PPM_idCentroCosto
	LEFT JOIN `centrocosto_listado_level_1`  PPM_Centro_lv_1        ON PPM_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.PPM_idLevel_1
	LEFT JOIN `centrocosto_listado_level_2`  PPM_Centro_lv_2        ON PPM_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.PPM_idLevel_2
	LEFT JOIN `centrocosto_listado_level_3`  PPM_Centro_lv_3        ON PPM_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.PPM_idLevel_3
	LEFT JOIN `centrocosto_listado_level_4`  PPM_Centro_lv_4        ON PPM_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.PPM_idLevel_4
	LEFT JOIN `centrocosto_listado_level_5`  PPM_Centro_lv_5        ON PPM_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.PPM_idLevel_5
	LEFT JOIN `centrocosto_listado`          RET_Centro             ON RET_Centro.idCentroCosto        = sistema_leyes_fiscales.RET_idCentroCosto
	LEFT JOIN `centrocosto_listado_level_1`  RET_Centro_lv_1        ON RET_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.RET_idLevel_1
	LEFT JOIN `centrocosto_listado_level_2`  RET_Centro_lv_2        ON RET_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.RET_idLevel_2
	LEFT JOIN `centrocosto_listado_level_3`  RET_Centro_lv_3        ON RET_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.RET_idLevel_3
	LEFT JOIN `centrocosto_listado_level_4`  RET_Centro_lv_4        ON RET_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.RET_idLevel_4
	LEFT JOIN `centrocosto_listado_level_5`  RET_Centro_lv_5        ON RET_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.RET_idLevel_5
	LEFT JOIN `centrocosto_listado`          IMPRENT_Centro         ON IMPRENT_Centro.idCentroCosto    = sistema_leyes_fiscales.IMPRENT_idCentroCosto
	LEFT JOIN `centrocosto_listado_level_1`  IMPRENT_Centro_lv_1    ON IMPRENT_Centro_lv_1.idLevel_1   = sistema_leyes_fiscales.IMPRENT_idLevel_1
	LEFT JOIN `centrocosto_listado_level_2`  IMPRENT_Centro_lv_2    ON IMPRENT_Centro_lv_2.idLevel_2   = sistema_leyes_fiscales.IMPRENT_idLevel_2
	LEFT JOIN `centrocosto_listado_level_3`  IMPRENT_Centro_lv_3    ON IMPRENT_Centro_lv_3.idLevel_3   = sistema_leyes_fiscales.IMPRENT_idLevel_3
	LEFT JOIN `centrocosto_listado_level_4`  IMPRENT_Centro_lv_4    ON IMPRENT_Centro_lv_4.idLevel_4   = sistema_leyes_fiscales.IMPRENT_idLevel_4
	LEFT JOIN `centrocosto_listado_level_5`  IMPRENT_Centro_lv_5    ON IMPRENT_Centro_lv_5.idLevel_5   = sistema_leyes_fiscales.IMPRENT_idLevel_5';
	$SIS_where = 'sistema_leyes_fiscales.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrImpuestos = array();
	$arrImpuestos = db_select_array (false, $SIS_query, 'sistema_leyes_fiscales', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrImpuestos');
	/*******************************************************/
	//cuento la cantidad de items creados
	$ndata_1 = db_select_nrows (false, 'idSistema', 'sistema_leyes_fiscales', '', "idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['idSistema'], $original, 'ndata_1');

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
								echo '<strong>Porcentaje PPM: </strong>'.$imp['Porcentaje_PPM'].'%<br/>'; 
								echo '<strong>Porcentaje Retencion Boletas: </strong>'.$imp['Porcentaje_Ret_Boletas'].'%<br/>';
								if(isset($imp['IVA_CC_Nombre'])&&$imp['IVA_CC_Nombre']!=''){
									echo '<strong>Centro Costo IVA: </strong>'.$imp['IVA_CC_Nombre'];
									if(isset($imp['IVA_CC_Level_1'])&&$imp['IVA_CC_Level_1']!=''){echo ' - '.$imp['IVA_CC_Level_1'];}
									if(isset($imp['IVA_CC_Level_2'])&&$imp['IVA_CC_Level_2']!=''){echo ' - '.$imp['IVA_CC_Level_2'];}
									if(isset($imp['IVA_CC_Level_3'])&&$imp['IVA_CC_Level_3']!=''){echo ' - '.$imp['IVA_CC_Level_3'];}
									if(isset($imp['IVA_CC_Level_4'])&&$imp['IVA_CC_Level_4']!=''){echo ' - '.$imp['IVA_CC_Level_4'];}
									if(isset($imp['IVA_CC_Level_5'])&&$imp['IVA_CC_Level_5']!=''){echo ' - '.$imp['IVA_CC_Level_5'];}
									echo '<br/>';
								}
								if(isset($imp['PPM_CC_Nombre'])&&$imp['PPM_CC_Nombre']!=''){
									echo '<strong>Centro Costo PPM: </strong>'.$imp['PPM_CC_Nombre'];
									if(isset($imp['PPM_CC_Level_1'])&&$imp['PPM_CC_Level_1']!=''){echo ' - '.$imp['PPM_CC_Level_1'];}
									if(isset($imp['PPM_CC_Level_2'])&&$imp['PPM_CC_Level_2']!=''){echo ' - '.$imp['PPM_CC_Level_2'];}
									if(isset($imp['PPM_CC_Level_3'])&&$imp['PPM_CC_Level_3']!=''){echo ' - '.$imp['PPM_CC_Level_3'];}
									if(isset($imp['PPM_CC_Level_4'])&&$imp['PPM_CC_Level_4']!=''){echo ' - '.$imp['PPM_CC_Level_4'];}
									if(isset($imp['PPM_CC_Level_5'])&&$imp['PPM_CC_Level_5']!=''){echo ' - '.$imp['PPM_CC_Level_5'];}
									echo '<br/>';
								}
								if(isset($imp['RET_CC_Nombre'])&&$imp['RET_CC_Nombre']!=''){
									echo '<strong>Centro Costo Retenciones: </strong>'.$imp['RET_CC_Nombre'];
									if(isset($imp['RET_CC_Level_1'])&&$imp['RET_CC_Level_1']!=''){echo ' - '.$imp['RET_CC_Level_1'];}
									if(isset($imp['RET_CC_Level_2'])&&$imp['RET_CC_Level_2']!=''){echo ' - '.$imp['RET_CC_Level_2'];}
									if(isset($imp['RET_CC_Level_3'])&&$imp['RET_CC_Level_3']!=''){echo ' - '.$imp['RET_CC_Level_3'];}
									if(isset($imp['RET_CC_Level_4'])&&$imp['RET_CC_Level_4']!=''){echo ' - '.$imp['RET_CC_Level_4'];}
									if(isset($imp['RET_CC_Level_5'])&&$imp['RET_CC_Level_5']!=''){echo ' - '.$imp['RET_CC_Level_5'];}
									echo '<br/>';
								}
								if(isset($imp['IMPRENT_CC_Nombre'])&&$imp['IMPRENT_CC_Nombre']!=''){
									echo '<strong>Centro Costo Impuesto a la Renta: </strong>'.$imp['IMPRENT_CC_Nombre'];
									if(isset($imp['IMPRENT_CC_Level_1'])&&$imp['IMPRENT_CC_Level_1']!=''){echo ' - '.$imp['IMPRENT_CC_Level_1'];}
									if(isset($imp['IMPRENT_CC_Level_2'])&&$imp['IMPRENT_CC_Level_2']!=''){echo ' - '.$imp['IMPRENT_CC_Level_2'];}
									if(isset($imp['IMPRENT_CC_Level_3'])&&$imp['IMPRENT_CC_Level_3']!=''){echo ' - '.$imp['IMPRENT_CC_Level_3'];}
									if(isset($imp['IMPRENT_CC_Level_4'])&&$imp['IMPRENT_CC_Level_4']!=''){echo ' - '.$imp['IMPRENT_CC_Level_4'];}
									if(isset($imp['IMPRENT_CC_Level_5'])&&$imp['IMPRENT_CC_Level_5']!=''){echo ' - '.$imp['IMPRENT_CC_Level_5'];}
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
