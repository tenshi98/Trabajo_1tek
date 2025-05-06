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
$original = "variedades_categorias.php";
$location = $original;
$new_location = "variedades_categorias_datos.php";
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
	//Nueva Ubicación
	$location .='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/sistema_variedades_categorias.php';
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
$SIS_query = 'Nombre,Temp_optima_min, Temp_optima_max, Temp_optima_margen_critico';
$SIS_join  = '';
$SIS_where = 'idCategoria = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'sistema_variedades_categorias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Especie', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'variedades_categorias.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'variedades_categorias_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'variedades_categorias_matriz_calidad.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Matriz Calidad</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'variedades_categorias_matriz_proceso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Matriz Proceso</a></li>
						<li class=""><a href="<?php echo 'variedades_categorias_tipo_embalaje.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Tipo Embalaje</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){                      $x1  = $Nombre;                      }else{$x1  = $rowData['Nombre'];}
					if(isset($Temp_optima_min)){             $x2  = $Temp_optima_min;             }else{$x2  = Cantidades_decimales_justos($rowData['Temp_optima_min']);}
					if(isset($Temp_optima_max)){             $x3  = $Temp_optima_max;             }else{$x3  = Cantidades_decimales_justos($rowData['Temp_optima_max']);}
					if(isset($Temp_optima_margen_critico)){  $x4  = $Temp_optima_margen_critico;  }else{$x4  = Cantidades_decimales_justos($rowData['Temp_optima_margen_critico']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_tittle(3, 'Temperaturas Optimas');
					$Form_Inputs->form_input_number('Temp. Optima Min', 'Temp_optima_min', $x2, 1);
					$Form_Inputs->form_input_number('Temp. Optima Max', 'Temp_optima_max', $x3, 1);
					$Form_Inputs->form_input_number('Temp. Margen Critico', 'Temp_optima_margen_critico', $x4, 1);

					$Form_Inputs->form_input_hidden('idCategoria', $_GET['id'], 2);
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
