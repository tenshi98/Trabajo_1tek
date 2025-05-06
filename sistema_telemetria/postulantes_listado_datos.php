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
$original = "postulantes_listado.php";
$location = $original;
$new_location = "postulantes_listado_datos.php";
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
	require_once 'A1XRXS_sys/xrxs_form/postulantes_listado.php';
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
Nombre,ApellidoPat,ApellidoMat,Fono1,Fono2,Rut,idCiudad,idComuna,Direccion,idSistema,idSexo,FNacimiento,idEstadoCivil,
idTipoLicencia, SueldoLiquido, email';
$SIS_join  = '';
$SIS_where = 'idPostulante = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'postulantes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Postulante', $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat'], 'Editar Datos Personales'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'postulantes_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'postulantes_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'postulantes_listado_estudios.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i>  Estudios</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'postulantes_listado_cursos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i>  Cursos</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_experiencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-industry" aria-hidden="true"></i>  Experiencia</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_curriculum.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i>  Curriculum</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_otros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-archive" aria-hidden="true"></i>  Otros</a></li>
						<li class=""><a href="<?php echo 'postulantes_listado_estado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-text-o" aria-hidden="true"></i>  Estado Contrato</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){              $x1  = $Nombre;               }else{$x1  = $rowData['Nombre'];}
					if(isset($ApellidoPat)){         $x2  = $ApellidoPat;          }else{$x2  = $rowData['ApellidoPat'];}
					if(isset($ApellidoMat)){         $x3  = $ApellidoMat;          }else{$x3  = $rowData['ApellidoMat'];}
					if(isset($Rut)){                 $x4  = $Rut;                  }else{$x4  = $rowData['Rut'];}
					if(isset($idSexo)){              $x5  = $idSexo;               }else{$x5  = $rowData['idSexo'];}
					if(isset($FNacimiento)){         $x6  = $FNacimiento;          }else{$x6  = $rowData['FNacimiento'];}
					if(isset($Fono1)){               $x7  = $Fono1;                }else{$x7  = $rowData['Fono1'];}
					if(isset($Fono2)){               $x8  = $Fono2;                }else{$x8  = $rowData['Fono2'];}
					if(isset($email)){               $x9  = $email;                }else{$x9  = $rowData['email'];}
					if(isset($idCiudad)){            $x10 = $idCiudad;             }else{$x10 = $rowData['idCiudad'];}
					if(isset($idComuna)){            $x11 = $idComuna;             }else{$x11 = $rowData['idComuna'];}
					if(isset($Direccion)){           $x12 = $Direccion;            }else{$x12 = $rowData['Direccion'];}
					if(isset($idEstadoCivil)){       $x13 = $idEstadoCivil;        }else{$x13 = $rowData['idEstadoCivil'];}
					if(isset($idTipoLicencia)){      $x14 = $idTipoLicencia;       }else{$x14 = $rowData['idTipoLicencia'];}
					if(isset($SueldoLiquido)){       $x15 = $SueldoLiquido;        }else{$x15 = $rowData['SueldoLiquido'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 2);
					$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 2);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x4, 2);
					$Form_Inputs->form_select('Sexo','idSexo', $x5, 2, 'idSexo', 'Nombre', 'core_sexo', 0, '', $dbConn);
					$Form_Inputs->form_date('Fecha Nacimiento','FNacimiento', $x6, 1);
					$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
					$Form_Inputs->form_input_phone('Fono1', 'Fono1', $x7, 1);
					$Form_Inputs->form_input_phone('Fono2', 'Fono2', $x8, 1);
					$Form_Inputs->form_input_icon('Email', 'email', $x9, 1,'fa fa-envelope-o');
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x10, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x11, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											 $dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x12, 1,'fa fa-map');
					$Form_Inputs->form_select('Estado Civil','idEstadoCivil', $x13, 1, 'idEstadoCivil', 'Nombre', 'core_estado_civil', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo Licencia','idTipoLicencia', $x14, 2, 'idTipoLicencia', 'Nombre', 'core_tipos_licencia_conducir', 0, '', $dbConn);
					$Form_Inputs->form_values('Pretenciones','SueldoLiquido', $x15, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idPostulante', $_GET['id'], 2);
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
