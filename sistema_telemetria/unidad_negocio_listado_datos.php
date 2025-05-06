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
$original = "unidad_negocio_listado.php";
$location = $original;
$new_location = "unidad_negocio_listado_datos.php";
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
	$form_trabajo= 'updateBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
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
$SIS_query = 'Codigo, Nombre,Modelo, Serie, Fabricante, fincorporacion, idSistema, idConfig_1, idConfig_2, idCliente';
$SIS_join  = '';
$SIS_where = 'idMaquina = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
/*******************************************************/
//verifico que sea un administrador
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Unidades de Negocio', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'unidad_negocio_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'unidad_negocio_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'unidad_negocio_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'unidad_negocio_listado_ubicacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicación</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha Tecnica</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'unidad_negocio_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
						<?php
						//Uso de componentes
						if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){ ?>
							<li class=""><a href="<?php echo 'unidad_negocio_listado_componentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Componentes</a></li>
						<?php } ?>
						<?php
						//uso de matriz de analisis
						if(isset($rowData['idConfig_2'])&&$rowData['idConfig_2']==1){ ?>
							<li class=""><a href="<?php echo 'unidad_negocio_listado_matriz_analisis.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-microchip" aria-hidden="true"></i> Matriz Analisis</a></li>
						<?php } ?>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idCliente)){        $x1  = $idCliente;       }else{$x1  = $rowData['idCliente'];}
					if(isset($Codigo)){           $x2  = $Codigo;          }else{$x2  = $rowData['Codigo'];}
					if(isset($Nombre)){           $x3  = $Nombre;          }else{$x3  = $rowData['Nombre'];}
					if(isset($Modelo)){           $x4  = $Modelo;          }else{$x4  = $rowData['Modelo'];}
					if(isset($Serie)){            $x5  = $Serie;           }else{$x5  = $rowData['Serie'];}
					if(isset($Fabricante)){       $x6  = $Fabricante;      }else{$x6  = $rowData['Fabricante'];}
					if(isset($fincorporacion)){   $x7  = $fincorporacion;  }else{$x7  = $rowData['fincorporacion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 2, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x3, 2);
					$Form_Inputs->form_input_text('Modelo', 'Modelo', $x4, 1);
					$Form_Inputs->form_input_text('Serie', 'Serie', $x5, 1);
					$Form_Inputs->form_input_text('Fabricante', 'Fabricante', $x6, 1);
					$Form_Inputs->form_date('Fecha de Incorporacion','fincorporacion', $x7, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('FakeidCliente', $rowData['idCliente'], 2);

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
