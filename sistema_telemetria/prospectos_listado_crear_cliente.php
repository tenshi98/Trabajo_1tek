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
$original = "prospectos_listado.php";
$location = $original;
$new_location = "prospectos_listado_datos.php";
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
	//Nueva ubicacion
	$location  = "clientes_listado.php";
	$location .= '?pagina=1';
	//Llamamos al formulario
	$form_trabajo= 'crear_cliente';
	require_once 'A1XRXS_sys/xrxs_form/prospectos_listado.php';
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
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idProspecto = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'prospectos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Prospecto', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'prospectos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'prospectos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'prospectos_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'prospectos_listado_datos_persona_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<li class=""><a href="<?php echo 'prospectos_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<li class=""><a href="<?php echo 'prospectos_listado_fidelizacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Estado Fidelizacion</a></li>
						<li class=""><a href="<?php echo 'prospectos_listado_etapas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Etapa Fidelizacion</a></li>
						<li class=""><a href="<?php echo 'prospectos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'prospectos_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class="active"><a href="<?php echo 'prospectos_listado_crear_cliente.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-user-plus" aria-hidden="true"></i> Crear Cliente</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Contrato_Nombre)){           $x1 = $Contrato_Nombre;           }else{$x1 = '';}
					if(isset($Contrato_Numero)){           $x2 = $Contrato_Numero;           }else{$x2 = '';}
					if(isset($Contrato_Fecha_Ini)){        $x3 = $Contrato_Fecha_Ini;        }else{$x3 = '';}
					if(isset($Contrato_Fecha_Term)){       $x4 = $Contrato_Fecha_Term;       }else{$x4 = '';}
					if(isset($Contrato_Valor_Mensual)){    $x5 = $Contrato_Valor_Mensual;    }else{$x5 = '';}
					if(isset($Contrato_Valor_Anual)){      $x6 = $Contrato_Valor_Anual;      }else{$x6 = '';}
					if(isset($Contrato_Obs)){              $x7 = $Contrato_Obs;              }else{$x7 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_post_data(1,1,1, 'Una vez ejecutado este informe, el prospecto pasa a estar inactivo y se crea un nuevo cliente.');
					$Form_Inputs->form_input_text('Nombre del Contrato', 'Contrato_Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Numero o Codigo del Contrato', 'Contrato_Numero', $x2, 1);
					$Form_Inputs->form_date('Fecha inicio Contrato','Contrato_Fecha_Ini', $x3, 2);
					$Form_Inputs->form_date('Fecha termino Contrato','Contrato_Fecha_Term', $x4, 2);
					$Form_Inputs->form_values('Valor Mensual', 'Contrato_Valor_Mensual', $x5, 2);
					$Form_Inputs->form_values('Valor Anual', 'Contrato_Valor_Anual', $x6, 1);
					$Form_Inputs->form_ckeditor('Observaciones','Contrato_Obs', $x7, 1, 2);

					$Form_Inputs->form_input_hidden('idProspecto', $_GET['id'], 2);

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
