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
$original = "seguridad_camaras_listado.php";
$location = $original;
$new_location = "seguridad_camaras_listado_datos.php";
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
	$form_trabajo= 'grupo_update';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_camaras_listado.php';
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
$SIS_query = 'Nombre,idSistema, idPais, idCiudad, idComuna, Direccion, N_Camaras, idSubconfiguracion, idTipoCamara, Config_usuario, Config_Password,
Config_IP, Config_Puerto, Config_Web';
$SIS_join  = '';
$SIS_where = 'idCamara = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'seguridad_camaras_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Grupo Camaras', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'seguridad_camaras_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'seguridad_camaras_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'seguridad_camaras_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class=""><a href="<?php echo 'seguridad_camaras_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Editar Camaras</a></li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;min-height:500px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){              $x1  = $Nombre;               }else{$x1  = $rowData['Nombre'];}
					if(isset($N_Camaras)){           $x2  = $N_Camaras;            }else{$x2  = $rowData['N_Camaras'];}
					if(isset($idPais)){              $x3  = $idPais;               }else{$x3  = $rowData['idPais'];}
					if(isset($idCiudad)){            $x4  = $idCiudad;             }else{$x4  = $rowData['idCiudad'];}
					if(isset($idComuna)){            $x5  = $idComuna;             }else{$x5  = $rowData['idComuna'];}
					if(isset($Direccion)){           $x6  = $Direccion;            }else{$x6  = $rowData['Direccion'];}
					if(isset($idSubconfiguracion)){  $x7  = $idSubconfiguracion;   }else{$x7  = $rowData['idSubconfiguracion'];}
					if(isset($idTipoCamara)){        $x8  = $idTipoCamara;         }else{$x8  = $rowData['idTipoCamara'];}
					if(isset($Config_usuario)){      $x9  = $Config_usuario;       }else{$x9  = $rowData['Config_usuario'];}
					if(isset($Config_Password)){     $x10 = $Config_Password;      }else{$x10 = $rowData['Config_Password'];}
					if(isset($Config_IP)){           $x11 = $Config_IP;            }else{$x11 = $rowData['Config_IP'];}
					if(isset($Config_Puerto)){       $x12 = $Config_Puerto;        }else{$x12 = $rowData['Config_Puerto'];}
					if(isset($Config_Web)){          $x13 = $Config_Web;           }else{$x13 = $rowData['Config_Web'];}
					//IP en caso de no existir
					if(!isset($x11) OR $x11=='') { $x11 = obtenerIpCliente();}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre del Grupo Camaras', 'Nombre', $x1, 1);
					$Form_Inputs->form_input_number_spinner('N° Camaras','N_Camaras', $x2, 0, 500, 1, 0, 1);
					$Form_Inputs->form_select_country('Pais','idPais', $x3, 1, $dbConn);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x4, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x5, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											 $dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x6, 1,'fa fa-map');
					$Form_Inputs->form_select('Subconfiguracion','idSubconfiguracion', $x7, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Camara','idTipoCamara', $x8, 1, 'idTipoCamara', 'Nombre', 'core_tipos_camara', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Usuario', 'Config_usuario', $x9, 1);
					$Form_Inputs->form_input_text('Password', 'Config_Password', $x10, 1);
					$Form_Inputs->form_input_text('Web o IP', 'Config_IP', $x11, 1);
					$Form_Inputs->form_input_number_spinner('N° Puerto','Config_Puerto', $x12, 0, 10000, 1, 0, 1);
					$Form_Inputs->form_input_text('Web configuracion', 'Config_Web', $x13, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idCamara', $_GET['id'], 2);

					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							//oculto los div
							document.getElementById('div_idTipoCamara').style.display = 'none';
							document.getElementById('div_Config_usuario').style.display = 'none';
							document.getElementById('div_Config_Password').style.display = 'none';
							document.getElementById('div_Config_IP').style.display = 'none';
							document.getElementById('div_Config_Puerto').style.display = 'none';
							document.getElementById('div_Config_Web').style.display = 'none';
							//se ejecuta al inicio
							LoadPais(0);
							LoadSubconfiguracion(0);
						});

						/**********************************************************************/
						document.getElementById("idPais").onchange = function() {LoadPais(1)};
						document.getElementById("idSubconfiguracion").onchange = function() {LoadSubconfiguracion(1)};

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
									document.querySelector('input[name="idCiudad"]').selectedIndex = 0;
									document.querySelector('input[name="idComuna"]').selectedIndex = 0;
								break;
							}
						}

						/**********************************************************************/
						function LoadSubconfiguracion(caseLoad){
							//obtengo los valores
							let idSubconfiguracion= $("#idSubconfiguracion").val();
							//selecciono
							switch(idSubconfiguracion) {
								//Si el pais es chile
								case '1':
									document.getElementById('div_idTipoCamara').style.display = 'none';
									document.getElementById('div_Config_usuario').style.display = 'none';
									document.getElementById('div_Config_Password').style.display = 'none';
									document.getElementById('div_Config_IP').style.display = 'none';
									document.getElementById('div_Config_Puerto').style.display = 'none';
									document.getElementById('div_Config_Web').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idTipoCamara"]').selectedIndex = 0;
										document.querySelector('input[name="Config_usuario"]').value = '';
										document.querySelector('input[name="Config_Password"]').value = '';
										document.querySelector('input[name="Config_IP"]').value = '';
										document.querySelector('input[name="Config_Puerto"]').value = '';
										document.querySelector('input[name="Config_Web"]').value = '';
									}
								break;
								//Si el pais es chile
								case '2':
									document.getElementById('div_idTipoCamara').style.display = 'block';
									document.getElementById('div_Config_usuario').style.display = 'block';
									document.getElementById('div_Config_Password').style.display = 'block';
									document.getElementById('div_Config_IP').style.display = 'block';
									document.getElementById('div_Config_Puerto').style.display = 'block';
									document.getElementById('div_Config_Web').style.display = 'block';
									//Reseteo los valores a 0
									if(caseLoad==1){

									}
								break;
								//Si el pais es distinto de chile
								default:
									document.getElementById('div_idTipoCamara').style.display = 'none';
									document.getElementById('div_Config_usuario').style.display = 'none';
									document.getElementById('div_Config_Password').style.display = 'none';
									document.getElementById('div_Config_IP').style.display = 'none';
									document.getElementById('div_Config_Puerto').style.display = 'none';
									document.getElementById('div_Config_Web').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idTipoCamara"]').selectedIndex = 0;
										document.querySelector('input[name="Config_usuario"]').value = '';
										document.querySelector('input[name="Config_Password"]').value = '';
										document.querySelector('input[name="Config_IP"]').value = '';
										document.querySelector('input[name="Config_Puerto"]').value = '';
										document.querySelector('input[name="Config_Web"]').value = '';
									}
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
