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
$original = "rrhh_asistencia_predios.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){  $location .= "&idTrabajador=".$_GET['idTrabajador'];   $search .= "&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){         $location .= "&Fecha=".$_GET['Fecha'];                 $search .= "&Fecha=".$_GET['Fecha'];}
if(isset($_GET['Hora']) && $_GET['Hora']!=''){           $location .= "&Hora=".$_GET['Hora'];                   $search .= "&Hora=".$_GET['Hora'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){   $location .= "&idPredio=".$_GET['idPredio'];           $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){       $location .= "&idZona=".$_GET['idZona'];               $search .= "&idZona=".$_GET['idZona'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){   $location .= "&idEstado=".$_GET['idEstado'];           $search .= "&idEstado=".$_GET['idEstado'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_registro';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_asistencias_predios.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update_registro';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_asistencias_predios.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del_registro';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_asistencias_predios.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Registro Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Registro Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Registro Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
//Consulto
$SIS_query = '
trabajadores_asistencias_predios.idTrabajador, 
trabajadores_asistencias_predios.Fecha, 
trabajadores_asistencias_predios.Hora, 
cross_predios_listado_zonas.idPredio, 
trabajadores_asistencias_predios.idZona, 
trabajadores_asistencias_predios.idEstado';
$SIS_join  = 'LEFT JOIN cross_predios_listado_zonas ON cross_predios_listado_zonas.idZona = trabajadores_asistencias_predios.idZona';
$SIS_where = 'idAsistencia='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'trabajadores_asistencias_predios', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Verifico el tipo de usuario que esta ingresando
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificación Registro</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){  $x1 = $idTrabajador;  }else{$x1 = $rowData['idTrabajador'];}
				if(isset($Fecha)){         $x2 = $Fecha;         }else{$x2 = $rowData['Fecha'];}
				if(isset($Hora)){          $x3 = $Hora;          }else{$x3 = $rowData['Hora'];}
				if(isset($idPredio)){      $x4 = $idPredio;      }else{$x4 = $rowData['idPredio'];}
				if(isset($idZona)){        $x5 = $idZona;        }else{$x5 = $rowData['idZona'];}
				if(isset($idEstado)){      $x6 = $idEstado;      }else{$x6 = $rowData['idEstado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $y, '', $dbConn);
				$Form_Inputs->form_date('Fecha','Fecha', $x2, 2);
				$Form_Inputs->form_time('Hora','Hora', $x3, 2, 2);
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x4, 2, 'idPredio', 'Nombre', 'cross_predios_listado', $y, 0,
										 'Cuarteles','idZona', $x5, 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select('Estado','idEstado', $x6, 2, 'idEstado', 'Nombre', 'core_estado_asistencia_predio', 0, '', $dbConn);
										 
				
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idAsistencia', $_GET['id'], 2);	
				
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
//Verifico el tipo de usuario que esta ingresando
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1"; 

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Registro</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){  $x1 = $idTrabajador;  }else{$x1 = '';}
				if(isset($Fecha)){         $x2 = $Fecha;         }else{$x2 = '';}
				if(isset($Hora)){          $x3 = $Hora;          }else{$x3 = '';}
				if(isset($idPredio)){      $x4 = $idPredio;      }else{$x4 = '';}
				if(isset($idZona)){        $x5 = $idZona;        }else{$x5 = '';}
				if(isset($idEstado)){      $x6 = $idEstado;      }else{$x6 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $y, '', $dbConn);
				$Form_Inputs->form_date('Fecha','Fecha', $x2, 2);
				$Form_Inputs->form_time('Hora','Hora', $x3, 2, 2);
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x4, 2, 'idPredio', 'Nombre', 'cross_predios_listado', $y, 0,
										 'Cuarteles','idZona', $x5, 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select('Estado','idEstado', $x6, 2, 'idEstado', 'Nombre', 'core_estado_asistencia_predio', 0, '', $dbConn);
										 
				
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('IP_Client', '999.999.999.999', 2);
				$Form_Inputs->form_input_hidden('Latitud', 1, 2);
				$Form_Inputs->form_input_hidden('Longitud', 1, 2);

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
/**********************************************************/
//paginador de resultados
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//Orden
$bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Ingreso Descendente';
//filtro
$SIS_where = 'trabajadores_asistencias_predios.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){  $SIS_where .= " AND trabajadores_asistencias_predios.idTrabajador='".$_GET['idTrabajador']."'";}
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){         $SIS_where .= " AND trabajadores_asistencias_predios.Fecha='".$_GET['Fecha']."'";}
if(isset($_GET['Hora']) && $_GET['Hora']!=''){           $SIS_where .= " AND trabajadores_asistencias_predios.Hora='".$_GET['Hora']."'";}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){   $SIS_where .= " AND cross_predios_listado_zonas.idPredio='".$_GET['idPredio']."'";}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){       $SIS_where .= " AND trabajadores_asistencias_predios.idZona='".$_GET['idZona']."'";}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){   $SIS_where .= " AND trabajadores_asistencias_predios.idEstado='".$_GET['idEstado']."'";}
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idAsistencia', 'trabajadores_asistencias_predios', 'LEFT JOIN `cross_predios_listado_zonas` ON cross_predios_listado_zonas.idZona = trabajadores_asistencias_predios.idZona', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
//se traen lo datos del equipo
$SIS_query = '
trabajadores_asistencias_predios.idAsistencia,
trabajadores_asistencias_predios.idTrabajador,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Rut AS TrabajadorRut,
	
trabajadores_asistencias_predios.Fecha AS PredioFecha,
trabajadores_asistencias_predios.Hora AS PredioHora,
trabajadores_asistencias_predios.IP_Client AS PredioIP,
	
cross_predios_listado_zonas.Nombre AS PredioCuartel,
cross_predios_listado.Nombre AS PredioNombre,
core_estado_asistencia_predio.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `trabajadores_listado`           ON trabajadores_listado.idTrabajador            = trabajadores_asistencias_predios.idTrabajador
LEFT JOIN `cross_predios_listado_zonas`    ON cross_predios_listado_zonas.idZona           = trabajadores_asistencias_predios.idZona
LEFT JOIN `cross_predios_listado`          ON cross_predios_listado.idPredio               = cross_predios_listado_zonas.idPredio
LEFT JOIN `core_estado_asistencia_predio`  ON core_estado_asistencia_predio.idEstado       = trabajadores_asistencias_predios.idEstado';

$SIS_order  = 'trabajadores_asistencias_predios.Fecha DESC, trabajadores_asistencias_predios.Hora DESC, trabajadores_asistencias_predios.idTrabajador ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrAsistencias = array();
$arrAsistencias = db_select_array (false, $SIS_query, 'trabajadores_asistencias_predios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAsistencias');

//Verifico el tipo de usuario que esta ingresando
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1"; 

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Registro</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){  $x1 = $idTrabajador;  }else{$x1 = '';}
				if(isset($Fecha)){         $x2 = $Fecha;         }else{$x2 = '';}
				if(isset($Hora)){          $x3 = $Hora;          }else{$x3 = '';}
				if(isset($idPredio)){      $x4 = $idPredio;      }else{$x4 = '';}
				if(isset($idZona)){        $x5 = $idZona;        }else{$x5 = '';}
				if(isset($idEstado)){      $x6 = $idEstado;      }else{$x6 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $y, '', $dbConn);
				$Form_Inputs->form_date('Fecha','Fecha', $x2, 1);
				$Form_Inputs->form_time('Hora','Hora', $x3, 1, 2);
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x4, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $y, 0,
										 'Cuarteles','idZona', $x5, 1, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select('Estado','idEstado', $x6, 1, 'idEstado', 'Nombre', 'core_estado_asistencia_predio', 0, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ultimos Registros</h5>
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
						<th>Trabajador</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>IP</th>
						<th>Predio</th>
						<th>Cuartel</th>
						<th>Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrAsistencias as $con) { ?>
						<tr class="odd">
							<td><?php echo $con['TrabajadorNombre'].' '.$con['TrabajadorApellidoPat'].' '.$con['TrabajadorApellidoMat'].' ('.$con['TrabajadorRut'].')'; ?></td>
							<td><?php echo fecha_estandar($con['PredioFecha']); ?></td>
							<td><?php echo $con['PredioHora']; ?></td>
							<td><?php echo $con['PredioIP']; ?></td>
							<td><?php if(isset($con['PredioNombre'])&&$con['PredioNombre']!=''){  echo $con['PredioNombre'];  }else{echo 'Fuera del Predio';} ?></td>
							<td><?php if(isset($con['PredioCuartel'])&&$con['PredioCuartel']!=''){echo $con['PredioCuartel'];}else{echo 'Fuera del Cuartel';} ?></td>
							<td><?php echo $con['Estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_rrhh_asistencia_predio.php?view='.simpleEncode($con['idAsistencia'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$con['idAsistencia']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($con['idAsistencia'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar los datos del registro?'; ?>
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
