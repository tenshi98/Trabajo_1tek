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
	$form_trabajo= 'updateCrossTech';
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
Nombre,CrossTech_HoraPrevRev, CrossTech_HoraPrevision, CrossTech_HoraPrevCuenta,
CrossTech_HeladaTemp, CrossTech_FechaUnidadFrio, CrossTech_TempMax, CrossTech_FechaTempMax, 
CrossTech_DiasTempMin, CrossTech_FechaDiasTempMin, CrossTech_TempMin, CrossTech_FechaTempMin,
CrossTech_HeladaMailHoraIni, CrossTech_HeladaMailHoraTerm';
$SIS_join  = '';
$SIS_where = 'idSistema ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
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
						<li class=""><a href="<?php echo 'core_sistemas_datos_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Datos Contrato</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_opciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-code" aria-hidden="true"></i> APIS</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_facturacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Facturacion</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_ot.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-cogs" aria-hidden="true"></i> OT</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Logo</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_oc.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Aprobador OC</a></li>
						<li class="active"><a href="<?php echo 'core_sistemas_crosstech.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >1Tek</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_crossenergy.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Power-Energy</a></li>
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
					if(isset($CrossTech_HoraPrevRev)){        $x1  = $CrossTech_HoraPrevRev;        }else{$x1  = $rowData['CrossTech_HoraPrevRev'];}
					if(isset($CrossTech_HoraPrevision)){      $x2  = $CrossTech_HoraPrevision;      }else{$x2  = $rowData['CrossTech_HoraPrevision'];}
					if(isset($CrossTech_HoraPrevCuenta)){     $x3  = $CrossTech_HoraPrevCuenta;     }else{$x3  = $rowData['CrossTech_HoraPrevCuenta'];}
					if(isset($CrossTech_HeladaTemp)){         $x4  = $CrossTech_HeladaTemp;         }else{$x4  = $rowData['CrossTech_HeladaTemp'];}
					if(isset($CrossTech_HeladaMailHoraIni)){  $x5  = $CrossTech_HeladaMailHoraIni;  }else{$x5  = $rowData['CrossTech_HeladaMailHoraIni'];}
					if(isset($CrossTech_HeladaMailHoraTerm)){ $x6  = $CrossTech_HeladaMailHoraTerm; }else{$x6  = $rowData['CrossTech_HeladaMailHoraTerm'];}
					if(isset($CrossTech_FechaUnidadFrio)){    $x7  = $CrossTech_FechaUnidadFrio;    }else{$x7  = $rowData['CrossTech_FechaUnidadFrio'];}
					if(isset($CrossTech_TempMin)){            $x8  = $CrossTech_TempMin;            }else{$x8  = $rowData['CrossTech_TempMin'];}
					if(isset($CrossTech_FechaTempMin)){       $x9  = $CrossTech_FechaTempMin;       }else{$x9  = $rowData['CrossTech_FechaTempMin'];}
					if(isset($CrossTech_TempMax)){            $x10 = $CrossTech_TempMax;            }else{$x10 = $rowData['CrossTech_TempMax'];}
					if(isset($CrossTech_FechaTempMax)){       $x11 = $CrossTech_FechaTempMax;       }else{$x11 = $rowData['CrossTech_FechaTempMax'];}
					if(isset($CrossTech_DiasTempMin)){        $x12 = $CrossTech_DiasTempMin;        }else{$x12 = $rowData['CrossTech_DiasTempMin'];}
					if(isset($CrossTech_FechaDiasTempMin)){   $x13 = $CrossTech_FechaDiasTempMin;   }else{$x13 = $rowData['CrossTech_FechaDiasTempMin'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Temperatura Proyectada');
					$Form_Inputs->form_time('Horas a Revisar (BD)','CrossTech_HoraPrevRev', $x1, 2, 1);
					$Form_Inputs->form_time('Horas Prevision','CrossTech_HoraPrevision', $x2, 2, 1);
					$Form_Inputs->form_input_number_spinner('Cuenta Hora Prevision','CrossTech_HoraPrevCuenta', $x3, 0, 100, '1', 0, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura Minima Envio Correo','CrossTech_HeladaTemp', $x4, 0, 100, '0.01', 2, 2);
					$Form_Inputs->form_time('Hora Inicio envio correo','CrossTech_HeladaMailHoraIni', $x5, 2, 1);
					$Form_Inputs->form_time('Hora Termino envio correo','CrossTech_HeladaMailHoraTerm', $x6, 2, 1);

					$Form_Inputs->form_tittle(3, 'Unidades de Frio');
					$Form_Inputs->form_date('Fecha a contar desde','CrossTech_FechaUnidadFrio', $x7, 2);

					$Form_Inputs->form_tittle(3, 'Horas bajo x Grados');
					$Form_Inputs->form_input_number_spinner('Horas Temp Min','CrossTech_TempMin', $x8, -100, 100, '0.01', 2, 2);
					$Form_Inputs->form_date('Fecha Horas Temp Min','CrossTech_FechaTempMin', $x9, 2);

					$Form_Inputs->form_tittle(3, 'Horas sobre x Grados');
					$Form_Inputs->form_input_number_spinner('Horas Temp Max','CrossTech_TempMax', $x10, -100, 100, '0.01', 2, 2);
					$Form_Inputs->form_date('Fecha a contar desde','CrossTech_FechaTempMax', $x11, 2);

					$Form_Inputs->form_tittle(3, 'Dias - Grados C°');
					$Form_Inputs->form_input_number_spinner('Temp Min','CrossTech_DiasTempMin', $x12, -100, 100, '0.01', 2, 2);
					$Form_Inputs->form_date('Fecha a contar desde','CrossTech_FechaDiasTempMin', $x13, 2);
	
	
	
					$Form_Inputs->form_input_hidden('idSistema', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('CrossTech_FechaDiasTempMinOld', $rowData['CrossTech_FechaDiasTempMin'], 2);
					$Form_Inputs->form_input_hidden('CrossTech_FechaTempMinOld', $rowData['CrossTech_FechaTempMin'], 2);
					$Form_Inputs->form_input_hidden('CrossTech_FechaTempMaxOld', $rowData['CrossTech_FechaTempMax'], 2);
					$Form_Inputs->form_input_hidden('CrossTech_FechaUnidadFrioOld', $rowData['CrossTech_FechaUnidadFrio'], 2);
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
