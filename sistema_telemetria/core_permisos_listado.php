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
//Verifico si es superusuario
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Type.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_permisos_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/**********************************************************************************************************************************/
/*                                               Ejecucion de los formularios                                                     */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/core_permisos_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/core_permisos_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/core_permisos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Permiso Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Permiso Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Permiso Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'id_pmcat, Direccionweb, Direccionbase, Nombre,visualizacion, Version, Descripcion, Level_Limit, Habilita, Principal';
	$SIS_join  = '';
	$SIS_where = 'idAdmpm = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación de Permiso</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($id_pmcat)){         $x1  = $id_pmcat;       }else{$x1  = $rowData['id_pmcat'];}
					if(isset($Nombre)){           $x2  = $Nombre;         }else{$x2  = $rowData['Nombre'];}
					if(isset($Direccionbase)){    $x3  = $Direccionbase;  }else{$x3  = $rowData['Direccionbase'];}
					if(isset($Direccionweb)){     $x4  = $Direccionweb;   }else{$x4  = $rowData['Direccionweb'];}
					if(isset($visualizacion)){    $x5  = $visualizacion;  }else{$x5  = $rowData['visualizacion'];}
					if(isset($Version)){          $x6  = $Version;        }else{$x6  = $rowData['Version'];}
					if(isset($Descripcion)){      $x7  = $Descripcion;    }else{$x7  = $rowData['Descripcion'];}
					if(isset($Habilita)){         $x8  = $Habilita;       }else{$x8  = $rowData['Habilita'];}
					if(isset($Principal)){        $x9  = $Principal;      }else{$x9  = $rowData['Principal'];}
					if(isset($Level_Limit)){      $x10 = $Level_Limit;    }else{$x10 = $rowData['Level_Limit'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Categorias','id_pmcat', $x1, 2, 'id_pmcat', 'Nombre', 'core_permisos_categorias', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);
					$Form_Inputs->form_input_icon('Dirección base', 'Direccionbase', $x3, 2,'fa fa-internet-explorer');
					$Form_Inputs->form_input_icon('Dirección web', 'Direccionweb', $x4, 2,'fa fa-internet-explorer');
					$Form_Inputs->form_visualizacion('Visualizacion','visualizacion', $x5, 2, 'idSistema', 'Nombre', 'core_sistemas',0, $dbConn);
					$Form_Inputs->form_input_number('Version del Archivo', 'Version', $x6, 2);
					$Form_Inputs->form_textarea('Descripcion','Descripcion', $x7, 2);
					$Form_Inputs->form_textarea('Habilitacion de tabs Usuario','Habilita', $x8, 1);
					$Form_Inputs->form_textarea('Habilitacion de tabs Principal','Principal', $x9, 1);
					$Form_Inputs->form_select_n_auto('Limite Nivel','Level_Limit', $x10, 2, 1, 4);

					$Form_Inputs->form_input_hidden('idAdmpm', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('fake_id_pmcat', $rowData['id_pmcat'], 2);
					$Form_Inputs->form_input_hidden('fake_Nombre', $rowData['Nombre'], 2);

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
}elseif(!empty($_GET['new'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Permiso</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($id_pmcat)){         $x1  = $id_pmcat;       }else{$x1  = '';}
					if(isset($Nombre)){           $x2  = $Nombre;         }else{$x2  = '';}
					if(isset($Direccionbase)){    $x3  = $Direccionbase;  }else{$x3  = '';}
					if(isset($Direccionweb)){     $x4  = $Direccionweb;   }else{$x4  = '';}
					if(isset($visualizacion)){    $x5  = $visualizacion;  }else{$x5  = '';}
					if(isset($Version)){          $x6  = $Version;        }else{$x6  = '';}
					if(isset($Descripcion)){      $x7  = $Descripcion;    }else{$x7  = '';}
					if(isset($Habilita)){         $x8  = $Habilita;       }else{$x8  = '';}
					if(isset($Principal)){        $x9  = $Principal;      }else{$x9  = '';}
					if(isset($Level_Limit)){      $x10 = $Level_Limit;    }else{$x10 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Categorias','id_pmcat', $x1, 2, 'id_pmcat', 'Nombre', 'core_permisos_categorias', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);
					$Form_Inputs->form_input_icon('Dirección base', 'Direccionbase', $x3, 2,'fa fa-internet-explorer');
					$Form_Inputs->form_input_icon('Dirección web', 'Direccionweb', $x4, 2,'fa fa-internet-explorer');
					$Form_Inputs->form_visualizacion('Visualizacion','visualizacion', $x5, 2, 'idSistema', 'Nombre', 'core_sistemas',0, $dbConn);
					$Form_Inputs->form_input_number('Version del Archivo', 'Version', $x6, 2);
					$Form_Inputs->form_textarea('Descripcion','Descripcion', $x7, 2);
					$Form_Inputs->form_textarea('Habilitacion de tabs','Habilita', $x8, 1);
					$Form_Inputs->form_textarea('Habilitacion de tabs Principal','Principal', $x9, 1);
					$Form_Inputs->form_select_n_auto('Limite Nivel','Level_Limit', $x10, 2, 1, 4);
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
	core_permisos_listado.idAdmpm,
	core_permisos_listado.Direccionweb,
	core_permisos_listado.Nombre,
	core_permisos_listado.Version,
	core_permisos_listado.visualizacion,
	core_permisos_listado.Level_Limit,
	core_sistemas.Nombre AS ver,
	core_permisos_categorias.Nombre AS Nombre_cat';
	$SIS_join  = '
	INNER JOIN `core_permisos_categorias`    ON core_permisos_categorias.id_pmcat     = core_permisos_listado.id_pmcat
	LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema               = core_permisos_listado.visualizacion';
	$SIS_where = '';
	$SIS_order = 'Nombre_cat ASC, core_permisos_listado.Nombre ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Permiso</a>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Permisos</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre</th>
							<th>Version</th>
							<th>Nivel</th>
							<th>Dirección Web</th>
							<th>Visualizacion</th>
							<th width="10">Acciones</th>
						</tr>
						<?php echo widget_sherlock(1, 6, 'TableFiltered'); ?>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
						<?php
						filtrar($arrPermisos, 'Nombre_cat');
						foreach($arrPermisos as $categoria=>$permisos){
							echo '<tr class="odd" ><td colspan="6"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
							foreach ($permisos as $subcategorias) { ?>
							<tr class="odd">
								<td><?php echo $subcategorias['Nombre']; ?></td>
								<td><?php echo $subcategorias['Version']; ?></td>
								<td><?php echo $subcategorias['Level_Limit']; ?></td>
								<td><?php echo $subcategorias['Direccionweb']; ?></td>
								<td>
									<?php
									if($subcategorias['visualizacion']==9999){
									echo 'Solo Superadministradores';
									}elseif($subcategorias['visualizacion']==9998){
									echo 'Todos';
									}else{
									echo $subcategorias['ver'];
									} ?>
								</td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo $location.'&id='.$subcategorias['idAdmpm']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php
											$ubicacion = $location.'&del='.simpleEncode($subcategorias['idAdmpm'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el permiso '.$subcategorias['Nombre'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>	
									</div>
								</td>
							</tr>
						<?php }
						} ?>
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
