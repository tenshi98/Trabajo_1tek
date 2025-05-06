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
$original = "cross_predios_listado.php";
$location = $original;
$new_location = "cross_predios_listado_datos.php";
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
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Ruta Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Ruta Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Ruta Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*******************************************************/
// consulto los datos
$SIS_query = 'Nombre,idSistema, idPais, idCiudad, idComuna, Direccion';
$SIS_join  = '';
$SIS_where = 'idPredio = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Predio', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'cross_predios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'cross_predios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'cross_predios_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class=""><a href="<?php echo 'cross_predios_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Editar Cuarteles</a></li>
			</ul>
		</header>
        <div class="table-responsive" >
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;min-height:500px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){       $x1  = $Nombre;        }else{$x1  = $rowData['Nombre'];}
					if(isset($idPais)){       $x2  = $idPais;        }else{$x2  = $rowData['idPais'];}
					if(isset($idCiudad)){     $x3  = $idCiudad;      }else{$x3  = $rowData['idCiudad'];}
					if(isset($idComuna)){     $x4  = $idComuna;      }else{$x4  = $rowData['idComuna'];}
					if(isset($Direccion)){    $x5  = $Direccion;     }else{$x5  = $rowData['Direccion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre del Predio', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_country('Pais','idPais', $x2, 1, $dbConn);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x3, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x4, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											 $dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x5, 1,'fa fa-map');

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idPredio', $_GET['id'], 2);
					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							//se ejecuta al inicio
							LoadPais(0);
						});

						/**********************************************************************/
						document.getElementById("idPais").onchange = function() {LoadPais(1)};

						/**********************************************************************/
						function LoadPais(caseLoad){
							//obtengo los valores
							let idPais = $("#idPais").val();
							//selecciono
							switch(idPais) {
								//Si el pais es chile
								case '1':
									document.getElementById("idCiudad").disabled = false;
									document.getElementById("idComuna").disabled = false;
								break;
								//Si el pais es distinto de chile
								default:
									document.getElementById("idCiudad").disabled = true;
									document.getElementById("idComuna").disabled = true;
									//Reseteo los valores a 0
									document.querySelector('input[name="idCiudad"]').selectedIndex = 0;
									document.querySelector('input[name="idComuna"]').selectedIndex = 0;
								break;
							}
						}

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
