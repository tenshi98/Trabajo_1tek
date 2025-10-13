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
//Verifico si es superusuario
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Type.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_sistemas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$location.='&id='.$_GET['id'];
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/core_sistemas.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Sistema Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Sistema Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Sistema Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = '
Nombre,Config_idTheme, Config_CorreoRespaldo, email_principal, idOpcionesTel,
idConfigRam, idConfigTime, idOpcionesGen_1, idOpcionesGen_2, idOpcionesGen_3, idOpcionesGen_4,
idOpcionesGen_5, idOpcionesGen_6, idOpcionesGen_7, idOpcionesGen_8, idOpcionesGen_9,idOpcionesGen_10,
Config_Gmail_Usuario, Config_Gmail_Password';
$SIS_join  = '';
$SIS_where = 'idSistema ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Editar Configuracion'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'core_sistemas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'core_sistemas_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'core_sistemas_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class="active"><a href="<?php echo 'core_sistemas_datos_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_opciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-code" aria-hidden="true"></i> APIS</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Logo</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crosstech.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >1Tek</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crossenergy.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Power-Energy</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_social.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Social</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Config_idTheme)){            $x1  = $Config_idTheme;             }else{$x1  = $rowData['Config_idTheme'];}
					if(isset($idOpcionesGen_7)){           $x2  = $idOpcionesGen_7;            }else{$x2  = $rowData['idOpcionesGen_7'];}
					if(isset($idOpcionesTel)){             $x3  = $idOpcionesTel;              }else{$x3  = $rowData['idOpcionesTel'];}
					if(isset($idOpcionesGen_4)){           $x4  = $idOpcionesGen_4;            }else{$x4  = $rowData['idOpcionesGen_4'];}
					if(isset($idOpcionesGen_6)){           $x5  = $idOpcionesGen_6;            }else{$x5  = $rowData['idOpcionesGen_6'];}
					if(isset($idOpcionesGen_1)){           $x6  = $idOpcionesGen_1;            }else{$x6  = $rowData['idOpcionesGen_1'];}
					if(isset($idOpcionesGen_2)){           $x7  = $idOpcionesGen_2;            }else{$x7  = $rowData['idOpcionesGen_2'];}
					if(isset($idOpcionesGen_3)){           $x8  = $idOpcionesGen_3;            }else{$x8  = $rowData['idOpcionesGen_3'];}
					if(isset($idOpcionesGen_10)){          $x9  = $idOpcionesGen_10;           }else{$x9  = $rowData['idOpcionesGen_10'];}
					if(isset($idConfigRam)){               $x10 = $idConfigRam;                }else{$x10 = $rowData['idConfigRam'];}
					if(isset($idConfigTime)){              $x11 = $idConfigTime;               }else{$x11 = $rowData['idConfigTime'];}
					if(isset($idOpcionesGen_5)){           $x12 = $idOpcionesGen_5;            }else{$x12 = $rowData['idOpcionesGen_5'];}
					if(isset($Config_CorreoRespaldo)){     $x13 = $Config_CorreoRespaldo;      }else{$x13 = $rowData['Config_CorreoRespaldo'];}
					if(isset($email_principal)){           $x14 = $email_principal;            }else{$x14 = $rowData['email_principal'];}
					if(isset($Config_Gmail_Usuario)){      $x15 = $Config_Gmail_Usuario;       }else{$x15 = $rowData['Config_Gmail_Usuario'];}
					if(isset($Config_Gmail_Password)){     $x16 = $Config_Gmail_Password;      }else{$x16 = $rowData['Config_Gmail_Password'];}


					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Visualizacion General');
					$Form_Inputs->form_select('Tema','Config_idTheme', $x1, 2, 'idTheme', 'Nombre', 'core_theme_colors', 0, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Visualizacion Pagina Inicio');
					$Form_Inputs->form_select('Interfaz','idOpcionesGen_7', $x2, 2, 'idInterfaz', 'Nombre', 'core_interfaces', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo Resumen Telemetria','idOpcionesTel', $x3, 1, 'idOpcionesTel', 'Nombre', 'core_sistemas_opciones_telemetria', 0, '', $dbConn);
					$Form_Inputs->form_select('Refresh Pagina Principal','idOpcionesGen_4', $x4, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_input_number('Segundos para Refrescar','idOpcionesGen_6', $x5, 1);
					$Form_Inputs->form_select('Widget Comunes','idOpcionesGen_1', $x6, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Widget de acceso directo','idOpcionesGen_2', $x7, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Valores promedios de las mediciones','idOpcionesGen_3', $x8, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Nuevo Widget 1tek C','idOpcionesGen_10', $x9, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Configuracion Sistema');
					$Form_Inputs->form_select('Ram Maxima (Mega Bytes)','idConfigRam', $x10, 2, 'idConfigRam', 'Nombre', 'core_config_ram', 0, '', $dbConn);
					$Form_Inputs->form_select('Tiempo Maximo (Minutos)','idConfigTime', $x11, 2, 'idConfigTime', 'Nombre', 'core_config_time', 0, '', $dbConn);
					$Form_Inputs->form_select('Motor PDF','idOpcionesGen_5', $x12, 2, 'idPDF', 'Nombre', 'core_pdf_motores', 0, '', $dbConn);
					//$Form_Inputs->form_input_icon('Correo Respaldo Datos', 'Config_CorreoRespaldo', $x13, 1,'fa fa-envelope-o');
					$Form_Inputs->form_input_icon('Correo Envio Notificaciones', 'email_principal', $x14, 1,'fa fa-envelope-o');
					//$Form_Inputs->form_input_icon('Usuario Gmail Envio Notificaciones', 'Config_Gmail_Usuario', $x15, 1,'fa fa-envelope-o');
					//$Form_Inputs->form_input_icon('Password Usuario Gmail', 'Config_Gmail_Password', $x16, 1,'fa fa-key');

					$Form_Inputs->form_input_hidden('idSistema', $_GET['id'], 2);
					?>

					<script>
						//Oculto los div
						document.getElementById('div_idOpcionesTel').style.display    = 'none';//Tipo Resumen Telemetria
						document.getElementById('div_idOpcionesGen_6').style.display  = 'none';//Segundos para Refrescar
						document.getElementById('div_idOpcionesGen_1').style.display  = 'none';//Widget Comunes
						document.getElementById('div_idOpcionesGen_2').style.display  = 'none';//Widget de acceso directo
						document.getElementById('div_idOpcionesGen_10').style.display = 'none';//Nuevo Widget 1Tek C

						//se ejecuta al cargar la página (OBLIGATORIO)
						$(document).ready(function(){

							let Interfaz               = $("#idOpcionesGen_7").val();
							let RefreshPaginaPrincipal = $("#idOpcionesGen_4").val();

							/*******************************************/
							//seleccion de interfaces
							//Interfaz Nueva v1
							if(Interfaz == 1){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = '';
								document.getElementById('div_idOpcionesGen_2').style.display = '';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz Antigua
							} else if(Interfaz == 2){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = '';
								document.getElementById('div_idOpcionesGen_2').style.display = '';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz Nueva v2
							} else if(Interfaz == 3){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = '';
								document.getElementById('div_idOpcionesGen_2').style.display = '';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz Solo telemetria
							} else if(Interfaz == 4){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = 'none';
								document.getElementById('div_idOpcionesGen_2').style.display = 'none';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_1"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_2"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz 1tek
							} else if(Interfaz == 6){
								document.getElementById('div_idOpcionesTel').style.display = 'none';
								document.getElementById('div_idOpcionesGen_1').style.display = 'none';
								document.getElementById('div_idOpcionesGen_2').style.display = 'none';
								document.getElementById('div_idOpcionesGen_10').style.display = '';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesTel"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_1"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_2"]').selectedIndex = 1;
							} else {
								document.getElementById('div_idOpcionesTel').style.display = 'none';
								document.getElementById('div_idOpcionesGen_1').style.display = 'none';
								document.getElementById('div_idOpcionesGen_2').style.display = 'none';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores
								//document.querySelector('input[name="idOpcionesTel"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_1"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_2"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							}

							/*******************************************/
							//Si la Pagina Principal necesita refrescarse, se indica el tiempo
							//Si
							if(RefreshPaginaPrincipal == 1){
								document.getElementById('div_idOpcionesGen_6').style.display = '';
							//No
							} else if(RefreshPaginaPrincipal == 2){
								document.getElementById('div_idOpcionesGen_6').style.display = 'none';
							}
						});

						/*******************************************/
						//se ejecuta al cambiar valor del select
						$("#idOpcionesGen_7").on("change", function(){
							//Asignamos el valor seleccionado
							let OpcionesGen_7 = $(this).val();
							//seleccion de interfaces
							//Interfaz Nueva v1
							if(OpcionesGen_7 == 1){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = '';
								document.getElementById('div_idOpcionesGen_2').style.display = '';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz Antigua
							} else if(OpcionesGen_7 == 2){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = '';
								document.getElementById('div_idOpcionesGen_2').style.display = '';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz Nueva v2
							} else if(OpcionesGen_7 == 3){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = '';
								document.getElementById('div_idOpcionesGen_2').style.display = '';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz Solo telemetria
							} else if(OpcionesGen_7 == 4){
								document.getElementById('div_idOpcionesTel').style.display = '';
								document.getElementById('div_idOpcionesGen_1').style.display = 'none';
								document.getElementById('div_idOpcionesGen_2').style.display = 'none';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_1"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_2"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							//Interfaz 1tek
							} else if(OpcionesGen_7 == 6){
								document.getElementById('div_idOpcionesTel').style.display = 'none';
								document.getElementById('div_idOpcionesGen_1').style.display = 'none';
								document.getElementById('div_idOpcionesGen_2').style.display = 'none';
								document.getElementById('div_idOpcionesGen_10').style.display = '';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesTel"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_1"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_2"]').selectedIndex = 1;
							} else {
								document.getElementById('div_idOpcionesTel').style.display = 'none';
								document.getElementById('div_idOpcionesGen_1').style.display = 'none';
								document.getElementById('div_idOpcionesGen_2').style.display = 'none';
								document.getElementById('div_idOpcionesGen_10').style.display = 'none';
								//Reseteo los valores
								//document.querySelector('input[name="idOpcionesTel"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_1"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_2"]').selectedIndex = 1;
								//document.querySelector('input[name="idOpcionesGen_10"]').selectedIndex = 1;
							}
						});

						/*******************************************/
						//se ejecuta al cambiar valor del select
						$("#idOpcionesGen_4").on("change", function(){
							//Asignamos el valor seleccionado
							let OpcionesGen_4 = $(this).val();
							//Si la Pagina Principal necesita refrescarse, se indica el tiempo
							//Si
							if(OpcionesGen_4 == 1){
								document.getElementById('div_idOpcionesGen_6').style.display = '';
							//No
							} else if(OpcionesGen_4 == 2){
								document.getElementById('div_idOpcionesGen_6').style.display = 'none';
								//Reseteo los valores a 0
								//document.querySelector('input[name="idOpcionesGen_6"]').value = '0';
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
