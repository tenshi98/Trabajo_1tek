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
$original = "personas_listado.php";
$location = $original;
$new_location = "personas_listado_datos.php";
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
	require_once 'A1XRXS_sys/xrxs_form/personas_listado.php';
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
// consulto los datos
$SIS_query = 'Rut, Nombre,ApellidoPaterno, ApellidoMaterno, fNacimiento, idSexo,
idCiudad, idComuna, Direccion, Sueldo, idAFP';
$SIS_join  = '';
$SIS_where = 'idPersona = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'personas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Personas', $rowData['Nombre'].' '.$rowData['ApellidoPaterno'].' '.$rowData['ApellidoMaterno'], 'Editar Datos Personales'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'personas_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'personas_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'personas_listado_email.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-envelope-o" aria-hidden="true"></i> Emails</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'personas_listado_fono.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-phone" aria-hidden="true"></i> Fonos</a></li>
						<li class=""><a href="<?php echo 'personas_listado_redes_sociales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-share-alt" aria-hidden="true"></i> Redes Sociales</a></li>
						<li class=""><a href="<?php echo 'personas_listado_relaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-user-plus" aria-hidden="true"></i> Relaciones</a></li>
						<li class=""><a href="<?php echo 'personas_listado_vehiculos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-car" aria-hidden="true"></i> Vehiculos</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Rut)){               $x1  = $Rut;               }else{$x1  = $rowData['Rut'];}
					if(isset($Nombre)){            $x2  = $Nombre;            }else{$x2  = $rowData['Nombre'];}
					if(isset($ApellidoPaterno)){   $x3  = $ApellidoPaterno;   }else{$x3  = $rowData['ApellidoPaterno'];}
					if(isset($ApellidoMaterno)){   $x4  = $ApellidoMaterno;   }else{$x4  = $rowData['ApellidoMaterno'];}
					if(isset($fNacimiento)){       $x5  = $fNacimiento;       }else{$x5  = $rowData['fNacimiento'];}
					if(isset($idSexo)){            $x6  = $idSexo;            }else{$x6  = $rowData['idSexo'];}
					if(isset($idCiudad)){          $x7  = $idCiudad;          }else{$x7  = $rowData['idCiudad'];}
					if(isset($idComuna)){          $x8  = $idComuna;          }else{$x8  = $rowData['idComuna'];}
					if(isset($Direccion)){         $x9  = $Direccion;         }else{$x9  = $rowData['Direccion'];}
					if(isset($Sueldo)){            $x10 = $Sueldo;            }else{$x10 = $rowData['Sueldo'];}
					if(isset($idAFP)){             $x11 = $idAFP;             }else{$x11 = $rowData['idAFP'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x1, 2);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);
					$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPaterno', $x3, 2);
					$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMaterno', $x4, 2);
					$Form_Inputs->form_date('Fecha Nacimiento','fNacimiento', $x5, 1);
					$Form_Inputs->form_select('Sexo','idSexo', $x6, 2, 'idSexo', 'Nombre', 'core_sexo', 0, '', $dbConn);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x7, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x8, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											 $dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x9, 1,'fa fa-map');
					$Form_Inputs->form_values('Sueldo','Sueldo', $x10, 1);
					$Form_Inputs->form_select('AFP','idAFP', $x11, 1, 'idAFP', 'Nombre', 'sistema_afp', 'idEstado=1', '', $dbConn);

					$Form_Inputs->form_input_hidden('idPersona', $_GET['id'], 2);
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
