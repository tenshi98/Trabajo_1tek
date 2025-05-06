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
$original = "informe_rrhh_03.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = 'trabajadores_asistencias_predios.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .=" AND (trabajadores_asistencias_predios.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
	$search .= '&f_inicio='.$_GET['f_inicio'];
	$search .= '&f_termino='.$_GET['f_termino'];
	$search .= '&h_inicio='.$_GET['h_inicio'];
	$search .= '&h_termino='.$_GET['h_termino'];
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" AND (trabajadores_asistencias_predios.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
	$search .= '&f_inicio='.$_GET['f_inicio'];
	$search .= '&f_termino='.$_GET['f_termino'];
}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){
	$SIS_where .= " AND trabajadores_asistencias_predios.idEstado=".$_GET['idEstado'];
	$search .= '&idEstado='.$_GET['idEstado'];
}
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$SIS_where .= " AND trabajadores_asistencias_predios.idTrabajador=".$_GET['idTrabajador'];
	$search .= '&idTrabajador='.$_GET['idTrabajador'];
}
if(isset($_GET['idOpciones'])&&$_GET['idOpciones']!=''&&$_GET['idOpciones']==1){
	$SIS_where .= " AND trabajadores_asistencias_predios.idZona!=0";
	$search .= '&idOpciones='.$_GET['idOpciones'];
}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idAsistencia', 'trabajadores_asistencias_predios', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
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
	$SIS_order  = 'trabajadores_asistencias_predios.idTrabajador ASC, trabajadores_asistencias_predios.Fecha ASC, trabajadores_asistencias_predios.Hora ASC LIMIT 10000';
	$arrAsistencias = array();
	$arrAsistencias = db_select_array (false, $SIS_query, 'trabajadores_asistencias_predios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAsistencias');

	
?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
		<a target="new" href="<?php echo 'informe_rrhh_03_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Asistencia</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
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
					<?php
					filtrar($arrAsistencias, 'idTrabajador');
					foreach($arrAsistencias as $categoria=>$permisos){ ?>
						<tr class="odd">
							<td colspan="7"><?php echo $permisos[0]['TrabajadorNombre'].' '.$permisos[0]['TrabajadorApellidoPat'].' '.$permisos[0]['TrabajadorApellidoMat'].' ('.$permisos[0]['TrabajadorRut'].')'; ?></td>
						</tr>
						<?php foreach ($permisos as $con) { ?>
							<tr class="odd">
								<td><?php echo fecha_estandar($con['PredioFecha']); ?></td>
								<td><?php echo $con['PredioHora']; ?></td>
								<td><?php echo $con['PredioIP']; ?></td>
								<td><?php if(isset($con['PredioNombre'])&&$con['PredioNombre']!=''){  echo $con['PredioNombre'];  }else{echo 'Fuera del Predio';} ?></td>
								<td><?php if(isset($con['PredioCuartel'])&&$con['PredioCuartel']!=''){echo $con['PredioCuartel'];}else{echo 'Fuera del Cuartel';} ?></td>
								<td><?php echo $con['Estado']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_rrhh_asistencia_predio.php?view='.simpleEncode($con['idAsistencia'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1"; 
 ?>

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
				if(isset($f_inicio)){      $x1  = $f_inicio;        }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;        }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;       }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;       }else{$x4  = '';}
				if(isset($idEstado)){      $x5  = $idEstado;        }else{$x5  = '';}
				if(isset($idTrabajador)){  $x6  = $idTrabajador;    }else{$x6  = '';}
				if(isset($idOpciones)){    $x7  = $idOpciones;      }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				$Form_Inputs->form_select('Estado','idEstado', $x5, 1, 'idEstado', 'Nombre', 'core_estado_asistencia_predio', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x6, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $y, '', $dbConn);
				$Form_Inputs->form_select('Dentro de Predio','idOpciones', $x7, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

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
