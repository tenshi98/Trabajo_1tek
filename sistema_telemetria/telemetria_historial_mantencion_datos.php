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
$original = "telemetria_historial_mantencion.php";
$location = $original;
$new_location = "telemetria_historial_mantencion_datos.php";
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
	//se agregan ubicaciones
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_historial_mantencion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*******************************************************/
// consulto los datos
$SIS_query = '
telemetria_historial_mantencion.idSistema,
telemetria_historial_mantencion.Fecha,
telemetria_historial_mantencion.Duracion,
telemetria_historial_mantencion.Resumen,
telemetria_historial_mantencion.Resolucion,
telemetria_historial_mantencion.Recepcion_Nombre,
telemetria_historial_mantencion.Recepcion_Rut,
telemetria_historial_mantencion.Recepcion_Email,
telemetria_historial_mantencion.idServicio,
telemetria_historial_mantencion.idOpciones_1,
telemetria_historial_mantencion.idOpciones_2,
telemetria_historial_mantencion.idOpciones_3,
telemetria_historial_mantencion.h_Inicio,
telemetria_historial_mantencion.h_Termino,
core_telemetria_servicio_tecnico.Nombre AS Servicio';
$SIS_join  = 'LEFT JOIN `core_telemetria_servicio_tecnico` ON core_telemetria_servicio_tecnico.idServicio  = telemetria_historial_mantencion.idServicio';
$SIS_where = 'telemetria_historial_mantencion.idMantencion = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'telemetria_historial_mantencion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Mantencion', $rowData['Servicio'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'telemetria_historial_mantencion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'telemetria_historial_mantencion_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'telemetria_historial_mantencion_equipos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Equipos</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'telemetria_historial_mantencion_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>          
						<li class=""><a href="<?php echo 'telemetria_historial_mantencion_firma.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Firma</a></li>          
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idSistema)){         $x0  = $idSistema;          }else{$x0  = $rowData['idSistema'];}
					if(isset($idServicio)){        $x1  = $idServicio;         }else{$x1  = $rowData['idServicio'];}
					if(isset($idOpciones_1)){      $x2  = $idOpciones_1;       }else{$x2  = $rowData['idOpciones_1'];}
					if(isset($idOpciones_2)){      $x2 .= ','.$idOpciones_2;   }else{$x2 .= ','.$rowData['idOpciones_2'];}
					if(isset($idOpciones_3)){      $x2 .= ','.$idOpciones_3;   }else{$x2 .= ','.$rowData['idOpciones_3'];}
					if(isset($Fecha)){             $x3  = $Fecha;              }else{$x3  = $rowData['Fecha'];}
					if(isset($h_Inicio)){          $x4  = $h_Inicio;           }else{$x4  = $rowData['h_Inicio'];}
					if(isset($h_Termino)){         $x5  = $h_Termino;          }else{$x5  = $rowData['h_Termino'];}
					if(isset($Resumen)){           $x7  = $Resumen;            }else{$x7  = $rowData['Resumen'];}
					if(isset($Resolucion)){        $x8  = $Resolucion;         }else{$x8  = $rowData['Resolucion'];}
					if(isset($Recepcion_Nombre)){  $x9  = $Recepcion_Nombre;   }else{$x9  = $rowData['Recepcion_Nombre'];}
					if(isset($Recepcion_Rut)){     $x10 = $Recepcion_Rut;      }else{$x10 = $rowData['Recepcion_Rut'];}
					if(isset($Recepcion_Email)){   $x11 = $Recepcion_Email;    }else{$x11 = $rowData['Recepcion_Email'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Sistema','idSistema', $x0, 2, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'core_telemetria_servicio_tecnico', 0, '', $dbConn);
					$Form_Inputs->form_checkbox_active('Selecciona una Opción','idOpciones', $x2, 2, 2, 'idOpciones', 'Nombre', 'core_telemetria_servicio_tecnico_opciones', 0, $dbConn);
					$Form_Inputs->form_date('Fecha Mantencion','Fecha', $x3, 2);
					$Form_Inputs->form_time('Hora Inicio','h_Inicio', $x4, 2, 2);
					$Form_Inputs->form_time('Hora Termino','h_Termino', $x5, 2, 2);
					$Form_Inputs->form_ckeditor('Diagnostico tecnico y acciones realizadas','Resumen', $x7, 2, 2);
					$Form_Inputs->form_ckeditor('Resumen de Visita','Resolucion', $x8, 1, 2);
					$Form_Inputs->form_input_text('Nombre persona recepcion', 'Recepcion_Nombre', $x9, 1);
					$Form_Inputs->form_input_rut('Rut persona recepcion', 'Recepcion_Rut', $x10, 1);
					$Form_Inputs->form_input_icon('Email persona recepcion', 'Recepcion_Email', $x11, 1,'fa fa-envelope-o');

					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('idMantencion', $_GET['id'], 2);
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
