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
$original = "informe_rrhh_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){ $search .="&idCliente=".$_GET['idCliente'];}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){         $search .="&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$search .="&f_creacion_inicio=".$_GET['f_creacion_inicio'];
	$search .="&f_creacion_termino=".$_GET['f_creacion_termino'];
}
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
/**********************************************************/
//Variable de busqueda
$z1 = "rrhh_sueldos_facturacion_trabajadores.idEstado=1 AND TotalAPagar>MontoPagado";
//Verifico el tipo de usuario que esta ingresando
$z1.=" AND rrhh_sueldos_facturacion_trabajadores.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//filtrado por trabajador
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){  
	$z1.=" AND rrhh_sueldos_facturacion_trabajadores.idTrabajador=".$_GET['idTrabajador'];
}
//filtrado por fecha de facturacion
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$z1.=" AND rrhh_sueldos_facturacion_trabajadores.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
}
/*************************************************************************************/
// Se trae un listado con todos los trabajadores
$arrTrabajador = array();
$arrTrabajador = db_select_array (false, 'idFactTrab,TrabajadorNombre,TrabajadorRut,TotalHaberes,TotalDescuentos,TotalAPagar,MontoPagado', 'rrhh_sueldos_facturacion_trabajadores', '',$z1,0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTrabajador');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Liquidaciones con Pago Pendiente</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th width="120">Rut</th>
						<th width="120">Alcance Liquido</th>
						<th width="120">Total Deberes</th>
						<th width="120">Renta a Pagar</th>
						<th width="120">Pagado</th>
						<th width="120">Total a Pagar</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php
						if ($arrTrabajador!=false && !empty($arrTrabajador) && $arrTrabajador!='') {
							foreach ($arrTrabajador as $tipo){
								$TotalPagar = $tipo['TotalAPagar'] - $tipo['MontoPagado'];
								?>
								<tr class="odd">
									<td><?php echo $tipo['TrabajadorNombre']; ?></td>
									<td><?php echo $tipo['TrabajadorRut']; ?></td>
									<td align="right"><?php echo valores($tipo['TotalHaberes'], 0); ?></td>
									<td align="right"><?php echo valores($tipo['TotalDescuentos'], 0); ?></td>
									<td align="right"><?php echo valores($tipo['TotalAPagar'], 0); ?></td>
									<td align="right"><?php echo valores($tipo['MontoPagado'], 0); ?></td>
									<td align="right"><?php echo valores($TotalPagar, 0); ?></td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_rrhh_sueldos.php?view='.simpleEncode($tipo['idFactTrab'], fecha_actual()); ?>" title="Ver Información" class="btn btn-primary btn-sm iframe tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
				if(isset($idTrabajador)){         $x1  = $idTrabajador;        }else{$x1  = '';}
				if(isset($f_creacion_inicio)){    $x2  = $f_creacion_inicio;   }else{$x2  = '';}
				if(isset($f_creacion_termino)){   $x3  = $f_creacion_termino;  }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Trabajador','idTrabajador', $x1, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $y, '', $dbConn);
				$Form_Inputs->form_date('Fecha Creacion Desde','f_creacion_inicio', $x2, 1);
				$Form_Inputs->form_date('Fecha Creacion Hasta','f_creacion_termino', $x3, 1);

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
