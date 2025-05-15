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
$original = "seguridad_accesos_nominas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){      $location .= "&idCliente=".$_GET['idCliente'];             $search .= "&idCliente=".$_GET['idCliente'];}
if(isset($_GET['N_Doc']) && $_GET['N_Doc']!=''){              $location .= "&N_Doc=".$_GET['N_Doc'];                     $search .= "&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){   $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];   $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
//formulario para editar
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_persona'])){
	//Llamamos al formulario
	$form_trabajo= 'new_persona_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_persona'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_persona_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
//se borra un dato
if (!empty($_GET['del_persona'])){
	//Llamamos al formulario
	$form_trabajo= 'del_persona_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
/**********************************************/
if (!empty($_GET['crear_nomina'])){
	//Llamamos al formulario
	$form_trabajo= 'crear_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
//se borra un dato
if (!empty($_GET['del_nomina'])){
	//Llamamos al formulario
	$form_trabajo= 'del_nomina';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_accesos_nominas.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Boleta de Honorarios Realizada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Boleta de Honorarios Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Boleta de Honorarios Borrada correctamente';}
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
}elseif(!empty($_GET['editPersona'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Persona</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){      $x1  = $Nombre;       }else{$x1  = $_SESSION['nomina_personas'][$_GET['editPersona']]['Nombre'];}
				if(isset($Rut)){         $x2  = $Rut;          }else{$x2  = $_SESSION['nomina_personas'][$_GET['editPersona']]['Rut'];}
				if(isset($NDocCedula)){  $x3  = $NDocCedula;   }else{$x3  = $_SESSION['nomina_personas'][$_GET['editPersona']]['NDocCedula'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x2, 2);
				$Form_Inputs->form_input_text('Numero Documento', 'NDocCedula', $x3, 1);

				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('old_idPersona', $_SESSION['nomina_personas'][$_GET['editPersona']]['idPersona'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_persona">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addPersona'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Persona</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){      $x1  = $Nombre;      }else{$x1  = '';}
				if(isset($Rut)){         $x2  = $Rut;         }else{$x2  = '';}
				if(isset($NDocCedula)){  $x3  = $NDocCedula;  }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x2, 2);
				$Form_Inputs->form_input_text('Numero Documento', 'NDocCedula', $x3, 1);

				$Form_Inputs->form_input_hidden('idEstado', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_persona">
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
			<h5>Modificar datos basicos del Ingreso</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($FechaProgramada)){        $x1  = $FechaProgramada;         }else{$x1  = $_SESSION['nomina_basicos']['FechaProgramada'];}
				if(isset($HoraInicioProgramada)){   $x2  = $HoraInicioProgramada;    }else{$x2  = $_SESSION['nomina_basicos']['HoraInicioProgramada'];}
				if(isset($HoraTerminoProgramada)){  $x3  = $HoraTerminoProgramada;   }else{$x3  = $_SESSION['nomina_basicos']['HoraTerminoProgramada'];}
				if(isset($idUbicacion)){            $x4  = $idUbicacion;             }else{$x4  = $_SESSION['nomina_basicos']['idUbicacion'];}
				if(isset($idUbicacion_lvl_1)){      $x5  = $idUbicacion_lvl_1;       }else{$x5  = $_SESSION['nomina_basicos']['idUbicacion_lvl_1'];}
				if(isset($idUbicacion_lvl_2)){      $x6  = $idUbicacion_lvl_2;       }else{$x6  = $_SESSION['nomina_basicos']['idUbicacion_lvl_2'];}
				if(isset($idUbicacion_lvl_3)){      $x7  = $idUbicacion_lvl_3;       }else{$x7  = $_SESSION['nomina_basicos']['idUbicacion_lvl_3'];}
				if(isset($idUbicacion_lvl_4)){      $x8  = $idUbicacion_lvl_4;       }else{$x8  = $_SESSION['nomina_basicos']['idUbicacion_lvl_4'];}
				if(isset($idUbicacion_lvl_5)){      $x9  = $idUbicacion_lvl_5;       }else{$x9  = $_SESSION['nomina_basicos']['idUbicacion_lvl_5'];}
				if(isset($PersonaReunion)){         $x10 = $PersonaReunion;          }else{$x10 = $_SESSION['nomina_basicos']['PersonaReunion'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha','FechaProgramada', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','HoraInicioProgramada', $x2, 2, 2);
				$Form_Inputs->form_time('Hora Termino','HoraTerminoProgramada', $x3, 2, 2);
				$Form_Inputs->form_select_depend5('Destino', 'idUbicacion',  $x4,  2,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
												  'Nivel 1', 'idUbicacion_lvl_1',  $x5,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
												  'Nivel 2', 'idUbicacion_lvl_2',  $x6,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												  'Nivel 3', 'idUbicacion_lvl_3',  $x7,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												  'Nivel 4', 'idUbicacion_lvl_4',  $x8,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												  'Nivel 5', 'idUbicacion_lvl_5',  $x9,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												  $dbConn, 'form1');
				$Form_Inputs->form_input_text('Persona Reunion', 'PersonaReunion', $x10, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
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
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger dialogBox"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&crear_nomina=true';
		$dialogo   = '¿Realmente desea ingresar el documento, una vez realizada no podra realizar cambios?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Nomina de Control de Accesos</div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Ubicación</td>
						<td><?php echo $_SESSION['nomina_basicos']['Ubicacion']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Persona Reunion</td>
						<td><?php echo $_SESSION['nomina_basicos']['PersonaReunion']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Programada</td>
						<td colspan="2"><?php echo Fecha_estandar($_SESSION['nomina_basicos']['FechaProgramada']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Hora Inicio</td>
						<td colspan="2"><?php echo $_SESSION['nomina_basicos']['HoraInicioProgramada']?></td>
					</tr>
					<tr>
						<td class="meta-head">Hora Termino</td>
						<td colspan="2"><?php echo $_SESSION['nomina_basicos']['HoraTerminoProgramada']?></td>
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

				<tr class="item-row fact_tittle">
					<td colspan="5">Personas a Ingresar</td>
					<td><a href="<?php echo $location.'&addPersona=true' ?>" title="Agregar Persona" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Persona</a></td>
				</tr>
				<?php
				//listado de servicios
				if (isset($_SESSION['nomina_personas'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['nomina_personas'] as $key => $persona){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="3"><?php echo $persona['Nombre']; ?></td>
							<td class="item-name" align="right"><?php echo $persona['Rut']; ?></td>
							<td class="item-name" align="right"><?php echo 'N Doc '.$persona['NDocCedula']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editPersona='.$persona['idPersona']; ?>" title="Editar Persona" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del_persona='.$persona['idPersona'];
									$dialogo   = '¿Realmente deseas eliminar a '.$persona['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Persona" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					 <?php 	
					}
				}
				?>
			</tbody>
		</table>
    </div>

    <table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td colspan="5">Archivos Adjuntos</td>
                <td width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
            </tr>

			<?php
			if (isset($_SESSION['nomina_archivos'])){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($_SESSION['nomina_archivos'] as $key => $producto){ ?>
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

<div class="clearfix"></div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Nomina</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($FechaProgramada)){        $x1  = $FechaProgramada;         }else{$x1  = '';}
				if(isset($HoraInicioProgramada)){   $x2  = $HoraInicioProgramada;    }else{$x2  = '';}
				if(isset($HoraTerminoProgramada)){  $x3  = $HoraTerminoProgramada;   }else{$x3  = '';}
				if(isset($idUbicacion)){            $x4  = $idUbicacion;             }else{$x4  = '';}
				if(isset($idUbicacion_lvl_1)){      $x5  = $idUbicacion_lvl_1;       }else{$x5  = '';}
				if(isset($idUbicacion_lvl_2)){      $x6  = $idUbicacion_lvl_2;       }else{$x6  = '';}
				if(isset($idUbicacion_lvl_3)){      $x7  = $idUbicacion_lvl_3;       }else{$x7  = '';}
				if(isset($idUbicacion_lvl_4)){      $x8  = $idUbicacion_lvl_4;       }else{$x8  = '';}
				if(isset($idUbicacion_lvl_5)){      $x9  = $idUbicacion_lvl_5;       }else{$x9  = '';}
				if(isset($PersonaReunion)){         $x10 = $PersonaReunion;          }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha','FechaProgramada', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','HoraInicioProgramada', $x2, 2, 2);
				$Form_Inputs->form_time('Hora Termino','HoraTerminoProgramada', $x3, 2, 2);
				$Form_Inputs->form_select_depend5('Destino', 'idUbicacion',  $x4,  2,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
												  'Nivel 1', 'idUbicacion_lvl_1',  $x5,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
												  'Nivel 2', 'idUbicacion_lvl_2',  $x6,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												  'Nivel 3', 'idUbicacion_lvl_3',  $x7,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												  'Nivel 4', 'idUbicacion_lvl_4',  $x8,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												  'Nivel 5', 'idUbicacion_lvl_5',  $x9,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												  $dbConn, 'form1');
				$Form_Inputs->form_input_text('Persona Reunion', 'PersonaReunion', $x10, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);

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
		case 'usuario_asc':           $order_by = 'usuarios_listado.Nombre ASC ';                                $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente'; break;
		case 'usuario_desc':          $order_by = 'usuarios_listado.Nombre DESC ';                               $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
		case 'fecha_asc':             $order_by = 'seguridad_accesos_nominas.FechaProgramada ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Programada Ascendente'; break;
		case 'fecha_desc':            $order_by = 'seguridad_accesos_nominas.FechaProgramada DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Programada Descendente';break;
		case 'hora_entrada_asc':      $order_by = 'seguridad_accesos_nominas.HoraInicioProgramada ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Inicio Programada Ascendente'; break;
		case 'hora_entrada_desc':     $order_by = 'seguridad_accesos_nominas.HoraInicioProgramada DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Inicio Programada Descendente';break;
		case 'hora_salida_asc':       $order_by = 'seguridad_accesos_nominas.HoraTerminoProgramada ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Termino Programada Ascendente'; break;
		case 'hora_salida_desc':      $order_by = 'seguridad_accesos_nominas.HoraTerminoProgramada DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Termino Programada Descendente';break;
		case 'destino_asc':           $order_by = 'ubicacion_listado.Nombre ASC ';                               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Destino Ascendente'; break;
		case 'destino_desc':          $order_by = 'ubicacion_listado.Nombre DESC ';                              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Destino Descendente';break;
		case 'persona_asc':           $order_by = 'seguridad_accesos_nominas.PersonaReunion ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Persona de Reunion Ascendente'; break;
		case 'persona_desc':          $order_by = 'seguridad_accesos_nominas.PersonaReunion DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Persona de Reunion Descendente';break;
		case 'estado_asc':            $order_by = 'core_estado_caja.Nombre ASC ';                                $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente'; break;
		case 'estado_desc':           $order_by = 'core_estado_caja.Nombre DESC ';                               $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

		default: $order_by = 'seguridad_accesos_nominas.FechaProgramada DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> FechaProgramada Descendente';
	}
}else{
	$order_by = 'seguridad_accesos_nominas.FechaProgramada DESC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> FechaProgramada Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "seguridad_accesos_nominas.idAcceso!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND seguridad_accesos_nominas.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idUsuario']) && $_GET['idUsuario'] != ''){     
	$SIS_where .= " AND seguridad_accesos_nominas.idUsuario = '".$_GET['idUsuario']."'";
}
if(isset($_GET['h_inicio'], $_GET['h_termino']) && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
	$SIS_where .= " AND seguridad_accesos_nominas.HoraInicioProgramada BETWEEN '".$_GET['h_inicio']."' AND '".$_GET['h_termino']."'";
}
if(isset($_GET['h_salida_inicio']) && $_GET['h_salida_inicio'] != ''&&isset($_GET['h_salida_termino']) && $_GET['h_salida_termino']!=''){
	$SIS_where .= " AND seguridad_accesos_nominas.HoraTerminoProgramada BETWEEN '".$_GET['h_salida_inicio']."' AND '".$_GET['h_salida_termino']."'";
}
if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
	$SIS_where .= " AND seguridad_accesos_nominas.FechaProgramada BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
}
if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){        $SIS_where .= " AND seguridad_accesos_nominas.idUbicacion='".$_GET['idUbicacion']."'";}
if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){   $SIS_where .= " AND seguridad_accesos_nominas.idUbicacion_lvl_1='".$_GET['idUbicacion_lvl_1']."'";}
if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){   $SIS_where .= " AND seguridad_accesos_nominas.idUbicacion_lvl_2='".$_GET['idUbicacion_lvl_2']."'";}
if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){   $SIS_where .= " AND seguridad_accesos_nominas.idUbicacion_lvl_3='".$_GET['idUbicacion_lvl_3']."'";}
if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){   $SIS_where .= " AND seguridad_accesos_nominas.idUbicacion_lvl_4='".$_GET['idUbicacion_lvl_4']."'";}
if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){   $SIS_where .= " AND seguridad_accesos_nominas.idUbicacion_lvl_5='".$_GET['idUbicacion_lvl_5']."'";}
if(isset($_GET['PersonaReunion']) && $_GET['PersonaReunion']!=''){  $SIS_where .= " AND seguridad_accesos_nominas.PersonaReunion LIKE '%".EstandarizarInput($_GET['PersonaReunion'])."%'";}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){              $SIS_where .= " AND seguridad_accesos_nominas.idEstado='".$_GET['idEstado']."'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idAcceso', 'seguridad_accesos_nominas', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
seguridad_accesos_nominas.idAcceso,
seguridad_accesos_nominas.FechaProgramada,
seguridad_accesos_nominas.HoraInicioProgramada,
seguridad_accesos_nominas.HoraTerminoProgramada,
core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,
seguridad_accesos_nominas.PersonaReunion,
core_estado_caja.Nombre AS Estado,
seguridad_accesos_nominas.idEstado';
$SIS_join  = '
LEFT JOIN `usuarios_listado`            ON usuarios_listado.idUsuario            = seguridad_accesos_nominas.idUsuario
LEFT JOIN `core_sistemas`               ON core_sistemas.idSistema               = seguridad_accesos_nominas.idSistema
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = seguridad_accesos_nominas.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = seguridad_accesos_nominas.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = seguridad_accesos_nominas.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = seguridad_accesos_nominas.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = seguridad_accesos_nominas.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = seguridad_accesos_nominas.idUbicacion_lvl_5
LEFT JOIN `core_estado_caja`            ON core_estado_caja.idEstado             = seguridad_accesos_nominas.idEstado';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'seguridad_accesos_nominas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Nomina</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idUsuario)){           $x1  = $idUsuario;           }else{$x1  = '';}
				if(isset($f_inicio)){            $x2  = $f_inicio;            }else{$x2  = '';}
				if(isset($f_termino)){           $x3  = $f_termino;           }else{$x3  = '';}
				if(isset($h_inicio)){            $x4  = $h_inicio;            }else{$x4  = '';}
				if(isset($h_termino)){           $x5  = $h_termino;           }else{$x5  = '';}
				if(isset($h_salida_inicio)){     $x6  = $h_salida_inicio;     }else{$x6  = '';}
				if(isset($h_salida_termino)){    $x7  = $h_salida_termino;    }else{$x7  = '';}
				if(isset($idUbicacion)){         $x8  = $idUbicacion;         }else{$x8  = '';}
				if(isset($idUbicacion_lvl_1)){   $x9  = $idUbicacion_lvl_1;   }else{$x9  = '';}
				if(isset($idUbicacion_lvl_2)){   $x10 = $idUbicacion_lvl_2;   }else{$x10 = '';}
				if(isset($idUbicacion_lvl_3)){   $x11 = $idUbicacion_lvl_3;   }else{$x11 = '';}
				if(isset($idUbicacion_lvl_4)){   $x12 = $idUbicacion_lvl_4;   }else{$x12 = '';}
				if(isset($idUbicacion_lvl_5)){   $x13 = $idUbicacion_lvl_5;   }else{$x13 = '';}
				if(isset($PersonaReunion)){      $x14 = $PersonaReunion;      }else{$x14 = '';}
				if(isset($idEstado)){            $x15 = $idEstado;            }else{$x15 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x1, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				$Form_Inputs->form_date('FechaProgramada Inicio','f_inicio', $x2, 1);
				$Form_Inputs->form_date('FechaProgramada Termino','f_termino', $x3, 1);
				$Form_Inputs->form_time('HoraInicioProgramada Entrada Inicio','h_inicio', $x4, 1, 1);
				$Form_Inputs->form_time('HoraInicioProgramada Entrada Termino','h_termino', $x5, 1, 1);
				$Form_Inputs->form_time('HoraInicioProgramada Salida Inicio','h_salida_inicio', $x6, 1, 1);
				$Form_Inputs->form_time('HoraInicioProgramada Salida Termino','h_salida_termino', $x7, 1, 1);
				$Form_Inputs->form_select_depend5('Destino', 'idUbicacion',  $x8,  1,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
												  'Nivel 1', 'idUbicacion_lvl_1',  $x9,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
												  'Nivel 2', 'idUbicacion_lvl_2',  $x10,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												  'Nivel 3', 'idUbicacion_lvl_3',  $x11,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												  'Nivel 4', 'idUbicacion_lvl_4',  $x12,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												  'Nivel 5', 'idUbicacion_lvl_5',  $x13,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												  $dbConn, 'form1');
				$Form_Inputs->form_input_text('Persona Reunion', 'PersonaReunion', $x14, 1);
				$Form_Inputs->form_select('Estado','idEstado', $x15, 1, 'idEstado', 'Nombre', 'core_estado_caja', 0, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Nominas Visitas</h5>
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
							<div class="pull-left">Fecha Programada</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Hora Inicio</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=hora_entrada_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=hora_entrada_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Hora Termino</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=hora_salida_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=hora_salida_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Destino</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=destino_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=destino_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Persona Reunion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=persona_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=persona_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
						<tr class="odd">
							<td><?php echo fecha_estandar($tipo['FechaProgramada']); ?></td>
							<td><?php echo $tipo['HoraInicioProgramada']; ?></td>
							<td><?php echo $tipo['HoraTerminoProgramada']; ?></td>
							<td>
								<?php echo $tipo['Ubicacion']; 
								if(isset($tipo['UbicacionLVL_1'])&&$tipo['UbicacionLVL_1']!=''){echo ' - '.$tipo['UbicacionLVL_1'];}
								if(isset($tipo['UbicacionLVL_2'])&&$tipo['UbicacionLVL_2']!=''){echo ' - '.$tipo['UbicacionLVL_2'];}
								if(isset($tipo['UbicacionLVL_3'])&&$tipo['UbicacionLVL_3']!=''){echo ' - '.$tipo['UbicacionLVL_3'];}
								if(isset($tipo['UbicacionLVL_4'])&&$tipo['UbicacionLVL_4']!=''){echo ' - '.$tipo['UbicacionLVL_4'];}
								if(isset($tipo['UbicacionLVL_5'])&&$tipo['UbicacionLVL_5']!=''){echo ' - '.$tipo['UbicacionLVL_5'];}
								?>
							</td>
							<td><?php echo $tipo['PersonaReunion']; ?></td>
							<td><label class="label <?php if(isset($tipo['idEstado'])&&$tipo['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $tipo['Estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_seguridad_accesos_nominas.php?view='.simpleEncode($tipo['idAcceso'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($tipo['FechaProgramada']==fecha_actual()){ ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo 'seguridad_accesos_nominas_editar.php?id='.$tipo['idAcceso']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del_nomina='.simpleEncode($tipo['idAcceso'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar la nomina de acceso '.$tipo['idAcceso'].'?'; ?>
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
