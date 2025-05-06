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
$original = "orden_trabajo_eventos_listado.php";
$location = $original;
$new_location = "orden_trabajo_eventos_listado_datos.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$location.='&id='.$_GET['id'];
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/orden_trabajo_eventos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Proveedor Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Proveedor Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Proveedor Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Verifico el tipo de usuario que esta ingresando
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$m = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idConfig_1=1 AND idEstado=1";
/*******************************************************/
// consulto los datos
$SIS_query = '
orden_trabajo_eventos_listado.Fecha,
orden_trabajo_eventos_listado.Hora,
orden_trabajo_eventos_listado.Observacion,
orden_trabajo_eventos_listado.idTrabajador,
orden_trabajo_eventos_listado.idCliente,
orden_trabajo_eventos_listado.idMaquina';
$SIS_join  = 'orden_trabajo_eventos_listado.idEvento = '.$_GET['id'];
$SIS_where = '';
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_eventos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Evento', fecha_estandar($rowData['Fecha']).' - '.$rowData['Hora'].' hrs', 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'orden_trabajo_eventos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'orden_trabajo_eventos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'orden_trabajo_eventos_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos Adjuntos</a></li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTrabajador)){  $x1  = $idTrabajador; }else{$x1  = $rowData['idTrabajador'];}
					if(isset($idCliente)){     $x2  = $idCliente;    }else{$x2  = $rowData['idCliente'];}
					if(isset($idMaquina)){     $x3  = $idMaquina;    }else{$x3  = $rowData['idMaquina'];}
					if(isset($Fecha)){         $x4  = $Fecha;        }else{$x4  = $rowData['Fecha'];}
					if(isset($Hora)){          $x5  = $Hora;         }else{$x5  = $rowData['Hora'];}
					if(isset($Observacion)){   $x6  = $Observacion;  }else{$x6  = $rowData['Observacion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
					//verifico el sistema
					if($_SESSION['usuario']['basic_data']['idSistema']==11){
						$Form_Inputs->form_select_depend1('Cliente','idCliente', $x2, 2, 'idCliente', 'Nombre', 'clientes_listado', $y, 0,
												 'Maquina','idMaquina', $x3, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $m, 0, 
												  $dbConn, 'form1');
					}else{
						$Form_Inputs->form_select_filter('Maquina','idMaquina', $x3, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $m, '', $dbConn);
					}
					$Form_Inputs->form_date('Fecha','Fecha', $x4, 2);
					$Form_Inputs->form_time('Hora','Hora', $x5, 2, 2);
					$Form_Inputs->form_ckeditor('Observacion','Observacion', $x6, 2, 2);

					$Form_Inputs->form_input_hidden('idEvento', $_GET['id'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
