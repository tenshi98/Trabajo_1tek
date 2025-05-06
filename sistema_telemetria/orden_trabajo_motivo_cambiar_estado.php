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
$original = "orden_trabajo_motivo_cambiar_estado.php";
$location = $original;
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
$location .= '?bla=bla';
if(isset($_GET['idOT']) && $_GET['idOT']!=''){                               $location .= "&idOT=".$_GET['idOT'];                                      $search .= "&idOT=".$_GET['idOT'];}
if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){                 $location .= "&idUbicacion=".$_GET['idUbicacion'];                        $search .= "&idUbicacion=".$_GET['idUbicacion'];}
if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){     $location .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];            $search .= "&idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];}
if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){     $location .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];            $search .= "&idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];}
if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){     $location .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];            $search .= "&idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];}
if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){     $location .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];            $search .= "&idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];}
if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){     $location .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];            $search .= "&idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){                 $location .= "&idPrioridad=".$_GET['idPrioridad'];                        $search .= "&idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                           $location .= "&idTipo=".$_GET['idTipo'];                                  $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                       $location .= "&idEstado=".$_GET['idEstado'];                              $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_programacion_inicio']) && $_GET['f_programacion_inicio']!=''){    $location .= "&f_programacion_inicio=".$_GET['f_programacion_inicio'];    $search .= "&f_programacion_inicio=".$_GET['f_programacion_inicio'];}
if(isset($_GET['f_programacion_termino']) && $_GET['f_programacion_termino']!=''){  $location .= "&f_programacion_termino=".$_GET['f_programacion_termino'];  $search .= "&f_programacion_termino=".$_GET['f_programacion_termino'];}
if(isset($_GET['f_termino_inicio']) && $_GET['f_termino_inicio']!=''){       $location .= "&f_termino_inicio=".$_GET['f_termino_inicio'];              $search .= "&f_termino_inicio=".$_GET['f_termino_inicio'];}
if(isset($_GET['f_termino_termino']) && $_GET['f_termino_termino']!=''){     $location .= "&f_termino_termino=".$_GET['f_programacion_termino'];       $search .= "&f_programacion_termino=".$_GET['f_programacion_termino'];}

/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se modifican los datos basicos
if (!empty($_POST['submit_cambiar'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_ot_list';
	require_once 'A1XRXS_sys/xrxs_form/z_orden_trabajo_motivo.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['edited'])){ $error['edited'] = 'sucess/Estado cambiado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['cambioEstado'])){
//Se traen los datos de la ot
$query = "SELECT idEstado, Observaciones
FROM `orden_trabajo_tareas_listado`
WHERE idOT = ".$_GET['cambioEstado'];
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
			<h5>Cambiar Estado de la OT <?php echo n_doc($_GET['cambioEstado'], 8); ?></h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEstado)){         $x1  = $idEstado;         }else{$x1  = $rowData['idEstado'];}
				if(isset($Observaciones)){    $x2  = $Observaciones;    }else{$x2  = $rowData['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Estado','idEstado', $x1, 2, 'idEstado', 'Nombre', 'core_estado_ot_motivos', 0, '', $dbConn);
				$Form_Inputs->form_textarea('Observacion Cierre','Observaciones', $x2, 2);

				$Form_Inputs->form_input_hidden('idOT', $_GET['cambioEstado'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_cambiar">
					<a href="<?php echo $location.'&submit_filter=Filtrar'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['submit_filter'])){
//Verifico el tipo de usuario que esta ingresando
$z  = "WHERE orden_trabajo_tareas_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico si la variable de busqueda existe
if(isset($_GET['idOT']) && $_GET['idOT']!=''){                     $z .= " AND orden_trabajo_tareas_listado.idOT=".$_GET['idOT'];}
if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){       $z .= " AND orden_trabajo_tareas_listado.idUbicacion=".$_GET['idUbicacion'];}
if(isset($_GET['idUbicacion_lvl_1']) && $_GET['idUbicacion_lvl_1']!=''){  $z .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_1=".$_GET['idUbicacion_lvl_1'];}
if(isset($_GET['idUbicacion_lvl_2']) && $_GET['idUbicacion_lvl_2']!=''){  $z .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_2=".$_GET['idUbicacion_lvl_2'];}
if(isset($_GET['idUbicacion_lvl_3']) && $_GET['idUbicacion_lvl_3']!=''){  $z .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_3=".$_GET['idUbicacion_lvl_3'];}
if(isset($_GET['idUbicacion_lvl_4']) && $_GET['idUbicacion_lvl_4']!=''){  $z .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_4=".$_GET['idUbicacion_lvl_4'];}
if(isset($_GET['idUbicacion_lvl_5']) && $_GET['idUbicacion_lvl_5']!=''){  $z .= " AND orden_trabajo_tareas_listado.idUbicacion_lvl_5=".$_GET['idUbicacion_lvl_5'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){       $z .= " AND orden_trabajo_tareas_listado.idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                 $z .= " AND orden_trabajo_tareas_listado.idTipo=".$_GET['Nombre'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){             $z .= " AND orden_trabajo_tareas_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_programacion_inicio'])&&$_GET['f_programacion_inicio']!=''&&isset($_GET['f_programacion_termino'])&&$_GET['f_programacion_termino']!=''){
	$z.=" AND orden_trabajo_tareas_listado.f_programacion BETWEEN '".$_GET['f_programacion_inicio']."' AND '".$_GET['f_programacion_termino']."'";
}	
if(isset($_GET['f_termino_inicio'])&&$_GET['f_termino_inicio']!=''&&isset($_GET['f_termino_termino'])&&$_GET['f_termino_termino']!=''){
	$z.=" AND orden_trabajo_tareas_listado.f_programacion BETWEEN '".$_GET['f_termino_inicio']."' AND '".$_GET['f_termino_termino']."'";
}

// Se trae un listado con todos los elementos
$arrOTS = array();
$query = "SELECT 
orden_trabajo_tareas_listado.idOT,
orden_trabajo_tareas_listado.f_programacion,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_motivos_tipos.Nombre AS NombreTipo,
core_estado_ot_motivos.Nombre AS NombreEstado

FROM `orden_trabajo_tareas_listado`
LEFT JOIN `core_ot_prioridad`           ON core_ot_prioridad.idPrioridad         = orden_trabajo_tareas_listado.idPrioridad
LEFT JOIN `core_ot_motivos_tipos`       ON core_ot_motivos_tipos.idTipo          = orden_trabajo_tareas_listado.idTipo
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = orden_trabajo_tareas_listado.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = orden_trabajo_tareas_listado.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = orden_trabajo_tareas_listado.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = orden_trabajo_tareas_listado.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = orden_trabajo_tareas_listado.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = orden_trabajo_tareas_listado.idUbicacion_lvl_5
LEFT JOIN `core_estado_ot_motivos`      ON core_estado_ot_motivos.idEstado       = orden_trabajo_tareas_listado.idEstado

".$z."
ORDER BY orden_trabajo_tareas_listado.idOT DESC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrOTS,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ordenes de Trabajo</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>#</th>
						<th>F Prog</th>
						<th>Ubicación</th>
						<th>Prioridad</th>
						<th>Tipo Trabajo</th>
						<th>Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOTS as $ot) { ?>
					<tr class="odd">
						<td><?php echo n_doc($ot['idOT'], 8); ?></td>
						<td><?php echo Fecha_estandar($ot['f_programacion']); ?></td>
						<td>
							<?php echo $ot['Ubicacion'];
							if(isset($ot['UbicacionLVL_1'])&&$ot['UbicacionLVL_1']!=''){echo ' - '.$ot['UbicacionLVL_1'];}
							if(isset($ot['UbicacionLVL_2'])&&$ot['UbicacionLVL_2']!=''){echo ' - '.$ot['UbicacionLVL_2'];}
							if(isset($ot['UbicacionLVL_3'])&&$ot['UbicacionLVL_3']!=''){echo ' - '.$ot['UbicacionLVL_3'];}
							if(isset($ot['UbicacionLVL_4'])&&$ot['UbicacionLVL_4']!=''){echo ' - '.$ot['UbicacionLVL_4'];}
							if(isset($ot['UbicacionLVL_5'])&&$ot['UbicacionLVL_5']!=''){echo ' - '.$ot['UbicacionLVL_5'];}
							?>
						</td>
						<td><?php echo $ot['NombrePrioridad']; ?></td>
						<td><?php echo $ot['NombreTipo']; ?></td>
						<td><?php echo $ot['NombreEstado']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_orden_trabajo.php?view='.simpleEncode($ot['idOT'], fecha_actual()); ?>" title="Ver Orden de Trabajo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location.'&cambioEstado='.$ot['idOT']; ?>" title="Cambiar Estado Orden de Trabajo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-exchange" aria-hidden="true"></i></a><?php } ?>
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
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idOT)){                     $x0  = $idOT;                     }else{$x0  = '';}
				if(isset($idUbicacion)){              $x1  = $idUbicacion;              }else{$x1  = '';}
				if(isset($idUbicacion_lvl_1)){        $x2  = $idUbicacion_lvl_1;        }else{$x2  = '';}
				if(isset($idUbicacion_lvl_2)){        $x3  = $idUbicacion_lvl_2;        }else{$x3  = '';}
				if(isset($idUbicacion_lvl_3)){        $x4  = $idUbicacion_lvl_3;        }else{$x4  = '';}
				if(isset($idUbicacion_lvl_4)){        $x5  = $idUbicacion_lvl_4;        }else{$x5  = '';}
				if(isset($idUbicacion_lvl_5)){        $x6  = $idUbicacion_lvl_5;        }else{$x6  = '';}
				if(isset($idPrioridad)){              $x7  = $idPrioridad;              }else{$x7  = '';}
				if(isset($idTipo)){                   $x8  = $idTipo;                   }else{$x8  = '';}
				if(isset($idEstado)){                 $x9  = $idEstado;                 }else{$x9  = '';}
				if(isset($f_programacion_inicio)){    $x10 = $f_programacion_inicio;    }else{$x10 = '';}
				if(isset($f_programacion_termino)){   $x11 = $f_programacion_termino;   }else{$x11 = '';}
				if(isset($f_termino_inicio)){         $x12 = $f_termino_inicio;         }else{$x12 = '';}
				if(isset($f_termino_termino)){        $x13 = $f_termino_termino;        }else{$x13 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('OT','idOT', $x0, 1);
				$Form_Inputs->form_select_depend5('Ubicación', 'idUbicacion',  $x1,  1,  'idUbicacion',  'Nombre',  'ubicacion_listado',  'idEstado=1 AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'],   0,
												  'Nivel 1', 'idUbicacion_lvl_1',  $x2,  1,  'idLevel_1',  'Nombre',  'ubicacion_listado_level_1',  0,   0, 
												  'Nivel 2', 'idUbicacion_lvl_2',  $x3,  1,  'idLevel_2',  'Nombre',  'ubicacion_listado_level_2',  0,   0,
												  'Nivel 3', 'idUbicacion_lvl_3',  $x4,  1,  'idLevel_3',  'Nombre',  'ubicacion_listado_level_3',  0,   0,
												  'Nivel 4', 'idUbicacion_lvl_4',  $x5,  1,  'idLevel_4',  'Nombre',  'ubicacion_listado_level_4',  0,   0,
												  'Nivel 5', 'idUbicacion_lvl_5',  $x6,  1,  'idLevel_5',  'Nombre',  'ubicacion_listado_level_5',  0,   0,
												  $dbConn, 'form1');
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x7, 1, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Trabajo','idTipo', $x8, 1, 'idTipo', 'Nombre', 'core_ot_motivos_tipos', 0, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x9, 1, 'idEstado', 'Nombre', 'core_estado_ot_motivos', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programacion Desde','f_programacion_inicio', $x10, 1);
				$Form_Inputs->form_date('Fecha Programacion Hasta','f_programacion_termino', $x11, 1);
				$Form_Inputs->form_date('Fecha Cierre Desde','f_termino_inicio', $x12, 1);
				$Form_Inputs->form_date('Fecha Cierre Hasta','f_termino_termino', $x13, 1);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>

			</form>
            <?php widget_validator(); ?>
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
