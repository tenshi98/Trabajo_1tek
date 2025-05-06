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
$original = "vehiculos_ruta_alternativa.php";
$location = $original;
$new_location = "vehiculos_ruta_alternativa_datos.php";
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
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_ruta_alternativa.php';
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
$SIS_query = 'idRuta, idSistema, idTipo, Fecha, idDia, HoraInicio, HoraTermino, Nombre';
$SIS_join  = '';
$SIS_where = 'idRutaAlt = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'vehiculos_ruta_alternativa', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
/*******************************************************/
//sistema
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Ruta Alternativa', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'vehiculos_ruta_alternativa.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'vehiculos_ruta_alternativa_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'vehiculos_ruta_alternativa_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Editar Ruta</a></li>

			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idRuta)){          $x1  = $idRuta;           }else{$x1  = $rowData["idRuta"];}
					if(isset($idTipo)){          $x2  = $idTipo;           }else{$x2  = $rowData["idTipo"];}
					if(isset($Fecha)){           $x3  = $Fecha;            }else{$x3  = $rowData["Fecha"];}
					if(isset($idDia)){           $x4  = $idDia;            }else{$x4  = $rowData["idDia"];}
					if(isset($HoraInicio)){      $x5  = $HoraInicio;       }else{$x5  = $rowData["HoraInicio"];}
					if(isset($HoraTermino)){     $x6  = $HoraTermino;      }else{$x6  = $rowData["HoraTermino"];}
					if(isset($Nombre)){          $x7  = $Nombre;           }else{$x7  = $rowData["Nombre"];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_select('Ruta','idRuta', $x1, 2, 'idRuta', 'Nombre', 'vehiculos_rutas', $z, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Ruta','idTipo', $x2, 2, 'idTipo', 'Nombre', 'vehiculos_ruta_alternativa_tipos', 0, '', $dbConn);
					$Form_Inputs->form_date('Fecha','Fecha', $x3, 1);
					$Form_Inputs->form_select_filter('Dia','idDia', $x4, 1, 'idDia', 'Nombre', 'core_tiempo_dias', 0, 'idDia ASC', $dbConn);
					$Form_Inputs->form_time('Hora Inicio','HoraInicio', $x5, 1, 1);
					$Form_Inputs->form_time('Hora Termino','HoraTermino', $x6, 1, 1);
					$Form_Inputs->form_input_text('Nombre de la Ruta', 'Nombre', $x7, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idRutaAlt', $_GET['id'], 2);
					?>

					<script>
						document.getElementById('div_Fecha').style.display = 'none';
						document.getElementById('div_idDia').style.display = 'none';

						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

							let tipo_val= $("#idTipo").val();
							//si es SI
							if(tipo_val == 1){
								document.getElementById('div_Fecha').style.display = 'none';
								document.getElementById('div_idDia').style.display = '';

							//si es NO
							} else if(tipo_val == 2){
								document.getElementById('div_Fecha').style.display = '';
								document.getElementById('div_idDia').style.display = 'none';
							}
						});

						$("#idTipo").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected = $(this).val(); //Asignamos el valor seleccionado

							//si es SI
							if(modelSelected == 1){
								document.getElementById('div_Fecha').style.display = 'none';
								document.getElementById('div_idDia').style.display = '';

							//si es NO
							} else if(modelSelected == 2){
								document.getElementById('div_Fecha').style.display = '';
								document.getElementById('div_idDia').style.display = 'none';
							}
						});
					</script>

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
