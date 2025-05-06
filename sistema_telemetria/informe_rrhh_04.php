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
$original = "informe_rrhh_04.php";
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
$SIS_where = 'trabajadores_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search .= '&Fecha='.$_GET['Fecha'];
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$SIS_where .=" AND trabajadores_listado.idTrabajador='".$_GET['idTrabajador']."'";
	$search .= '&idTrabajador='.$_GET['idTrabajador'];
}

//se traen lo datos del equipo
$SIS_query = '
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Rut AS TrabajadorRut,
trabajadores_listado.idTrabajador AS ID,
(SELECT Hora FROM `trabajadores_asistencias_predios` WHERE idTrabajador=ID AND idEstado=1 AND Fecha= "'.$_GET['Fecha'].'" LIMIT 1) AS Ingreso,
(SELECT IP_Client FROM `trabajadores_asistencias_predios` WHERE idTrabajador=ID AND idEstado=1 AND Fecha= "'.$_GET['Fecha'].'" LIMIT 1) AS Ingreso_IP,
(SELECT Hora FROM `trabajadores_asistencias_predios` WHERE idTrabajador=ID AND idEstado=2 AND Fecha= "'.$_GET['Fecha'].'" LIMIT 1) AS Egreso,
(SELECT IP_Client FROM `trabajadores_asistencias_predios` WHERE idTrabajador=ID AND idEstado=2 AND Fecha= "'.$_GET['Fecha'].'" LIMIT 1) AS Egreso_IP,
(SELECT cross_predios_listado_zonas.Nombre 
FROM `trabajadores_asistencias_predios` 
LEFT JOIN `cross_predios_listado_zonas` ON cross_predios_listado_zonas.idZona = trabajadores_asistencias_predios.idZona

WHERE trabajadores_asistencias_predios.idTrabajador=ID AND trabajadores_asistencias_predios.idEstado=1 AND trabajadores_asistencias_predios.Fecha= "'.$_GET['Fecha'].'" LIMIT 1) AS PredioCuartel';
$SIS_join  = '';
$SIS_order  = 'ApellidoPat ASC, ApellidoMat ASC';
$arrAsistencias = array();
$arrAsistencias = db_select_array (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAsistencias');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_rrhh_04_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Revision Asistencia</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Trabajador</th>
						<th>Rut</th>
						<th>Cuartel</th>
						<th>Fecha</th>
						<th>Ingreso</th>
						<th>Egreso</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrAsistencias as $con) { ?>
						<tr class="odd">
							<td><?php echo $con['TrabajadorApellidoPat'].' '.$con['TrabajadorApellidoMat'].' '.$con['TrabajadorNombre']; ?></td>
							<td><?php echo $con['TrabajadorRut']; ?></td>
							<td><?php echo $con['PredioCuartel']; ?></td>
							<td><?php echo fecha_estandar($_GET['Fecha']); ?></td>
							<td><?php echo $con['Ingreso']; if($con['Ingreso_IP']=='999.999.999.999'){echo '<i class="fa fa-check" aria-hidden="true"></i>';} ?></td>
							<td><?php echo $con['Egreso']; if($con['Ingreso_IP']=='999.999.999.999'){echo '<i class="fa fa-check" aria-hidden="true"></i>';} ?></td>
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
				if(isset($Fecha)){        $x1  = $Fecha;         }else{$x1  = '';}
				if(isset($idTrabajador)){ $x2  = $idTrabajador;  }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha','Fecha', $x1, 2);
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x2, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $y, '', $dbConn);

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
