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
$original = "admin_trabajadores_listado.php";
$location = $original;
$new_location = "admin_trabajadores_listado_laboral.php";
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
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Trabajador Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Trabajador Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Trabajador Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = '
Nombre,ApellidoPat,ApellidoMat,idTipo,Cargo,FechaContrato, F_Inicio_Contrato,
F_Termino_Contrato,Observaciones,idTipoContrato,idTipoTrabajador,
SueldoLiquido,SueldoDia,SueldoHora,idTipoContratoTrab,horas_pactadas,Gratificacion,
idContratista,idCentroCosto,idLevel_1,idLevel_2,idLevel_3,idLevel_4,idLevel_5,
idTipoTrabajo, PorcentajeTrabajoPesado,idBanco, idTipoCuenta, N_Cuenta,UbicacionTrabajo';
$SIS_join  = '';
$SIS_where = 'idTrabajador ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');


$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Trabajador', $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat'], 'Editar Datos Laborales'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'admin_trabajadores_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'admin_trabajadores_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'admin_trabajadores_listado_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class="active"><a href="<?php echo 'admin_trabajadores_listado_laboral.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-university" aria-hidden="true"></i> Información Laboral</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_previsional.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Descuentos Previsionales</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_descuentos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Otros Descuentos Previsionales</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_bonos_fijos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Bonos Fijos Asignados</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_cargas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-user-plus" aria-hidden="true"></i> Cargas Familiares</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>

						<li class=""><a href="<?php echo 'admin_trabajadores_listado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Contrato</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_anexos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Anexos Contrato</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_licencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Licencia Conducir</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Foto</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_curriculum.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Curriculum</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_antecedentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Antecedentes</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_carnet.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Carnet</a></li>
						<li class=""><a href="<?php echo 'admin_trabajadores_listado_rhtm.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Permiso Trabajo Menor Edad</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTipo)){                   $x1  = $idTipo;                    }else{$x1  = $rowData['idTipo'];}
					if(isset($Cargo)){                    $x2  = $Cargo;                     }else{$x2  = $rowData['Cargo'];}

					if(isset($idContratista)){            $x3  = $idContratista;             }else{$x3  = $rowData['idContratista'];}
					if(isset($idTipoTrabajador)){         $x4  = $idTipoTrabajador;          }else{$x4  = $rowData['idTipoTrabajador'];}
					if(isset($idTipoContrato)){           $x5  = $idTipoContrato;            }else{$x5  = $rowData['idTipoContrato'];}
					if(isset($idTipoContratoTrab)){       $x6  = $idTipoContratoTrab;        }else{$x6  = $rowData['idTipoContratoTrab'];}
					if(isset($horas_pactadas)){           $x7  = $horas_pactadas;            }else{$x7  = $rowData['horas_pactadas'];}
					if(isset($FechaContrato)){            $x8  = $FechaContrato;             }else{$x8  = $rowData['FechaContrato'];}
					if(isset($F_Inicio_Contrato)){        $x9  = $F_Inicio_Contrato;         }else{$x9  = $rowData['F_Inicio_Contrato'];}
					if(isset($F_Termino_Contrato)){       $x10 = $F_Termino_Contrato;        }else{$x10 = $rowData['F_Termino_Contrato'];}
					if(isset($idTipoTrabajo)){            $x11 = $idTipoTrabajo;             }else{$x11 = $rowData['idTipoTrabajo'];}
					if(isset($PorcentajeTrabajoPesado)){  $x12 = $PorcentajeTrabajoPesado;   }else{$x12 = $rowData['PorcentajeTrabajoPesado'];}
					if(isset($UbicacionTrabajo)){         $x13 = $UbicacionTrabajo;          }else{$x13 = $rowData['UbicacionTrabajo'];}

					if(isset($SueldoLiquido)){            $x14 = $SueldoLiquido;             }else{$x14 = $rowData['SueldoLiquido'];}
					if(isset($SueldoDia)){                $x15 = $SueldoDia;                 }else{$x15 = $rowData['SueldoDia'];}
					if(isset($SueldoHora)){               $x16 = $SueldoHora;                }else{$x16 = $rowData['SueldoHora'];}
					if(isset($Gratificacion)){            $x17 = $Gratificacion;             }else{$x17 = $rowData['Gratificacion'];}

					if(isset($idBanco)){                  $x18 = $idBanco;                   }else{$x18 = $rowData['idBanco'];}
					if(isset($idTipoCuenta)){             $x19 = $idTipoCuenta;              }else{$x19 = $rowData['idTipoCuenta'];}
					if(isset($N_Cuenta)){                 $x20 = $N_Cuenta;                  }else{$x20 = $rowData['N_Cuenta'];}

					if(isset($idCentroCosto)){            $x21 = $idCentroCosto;             }else{$x21 = $rowData['idCentroCosto'];}
					if(isset($idLevel_1)){                $x22 = $idLevel_1;                 }else{$x22 = $rowData['idLevel_1'];}
					if(isset($idLevel_2)){                $x23 = $idLevel_2;                 }else{$x23 = $rowData['idLevel_2'];}
					if(isset($idLevel_3)){                $x24 = $idLevel_3;                 }else{$x24 = $rowData['idLevel_3'];}
					if(isset($idLevel_4)){                $x25 = $idLevel_4;                 }else{$x25 = $rowData['idLevel_4'];}
					if(isset($idLevel_5)){                $x26 = $idLevel_5;                 }else{$x26 = $rowData['idLevel_5'];}

					if(isset($Observaciones)){            $x27 = $Observaciones;             }else{$x27 = $rowData['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Trabajador');
					$Form_Inputs->form_select('Tipo Trabajador','idTipo', $x1, 2, 'idTipo', 'Nombre', 'trabajadores_listado_tipos', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Cargo', 'Cargo', $x2, 1);

					$Form_Inputs->form_tittle(3, 'Datos Contrato');
					$Form_Inputs->form_select_filter('Empresa Contratista','idContratista', $x3, 1, 'idContratista', 'Nombre', 'contratista_listado', $w, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Trabajador','idTipoTrabajador', $x4, 1, 'idTipoTrabajador', 'Nombre', 'core_tipos_trabajadores', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Contrato','idTipoContrato', $x5, 1, 'idTipoContrato', 'Nombre', 'core_tipos_contrato', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Sueldo','idTipoContratoTrab', $x6, 1, 'idTipoContratoTrab', 'Nombre', 'core_tipos_contrato_trabajador', 0, '', $dbConn);
					$Form_Inputs->form_select_n_auto('Horas Pactadas','horas_pactadas', $x7, 1, 1, 45);
					$Form_Inputs->form_date('Fecha Contrato','FechaContrato', $x8, 1);
					$Form_Inputs->form_date('F Inicio Contrato','F_Inicio_Contrato', $x9, 1);
					$Form_Inputs->form_date('F Termino Contrato','F_Termino_Contrato', $x10, 1);
					$Form_Inputs->form_select('Tipo de Trabajo','idTipoTrabajo', $x11, 1, 'idTipoTrabajo', 'Nombre', 'core_tipos_trabajo', 0, '', $dbConn);
					$Form_Inputs->form_input_number_spinner('Porcentaje Trabajo Pesado','PorcentajeTrabajoPesado', $x12, 0, 10, '0.1', 1, 2);
					$Form_Inputs->form_input_text('Ubicación Trabajo', 'UbicacionTrabajo', $x13, 1);

					$Form_Inputs->form_tittle(3, 'Remuneraciones');
					$Form_Inputs->form_values('Sueldo Liquido a Pago','SueldoLiquido', $x14, 1);
					$Form_Inputs->form_values('Sueldo Liquido a Pago por dia','SueldoDia', $x15, 1);
					$Form_Inputs->form_values('Sueldo Liquido a Pago por hora','SueldoHora', $x16, 1);
					$Form_Inputs->form_values('Gratificacion','Gratificacion', $x17, 1);

					$Form_Inputs->form_tittle(3, 'Forma de Pago');
					$Form_Inputs->form_select_filter('Banco','idBanco', $x18, 1, 'idBanco', 'Nombre', 'core_bancos', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo de cuenta deposito','idTipoCuenta', $x19, 1, 'idTipoCuenta', 'Nombre', 'core_tipo_cuenta', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nro. Cta. Deposito', 'N_Cuenta', $x20, 1);

					$Form_Inputs->form_tittle(3, 'Centro de Costo Asignado');
					$Form_Inputs->form_select_depend5('Centro de Costo', 'idCentroCosto',  $x21,  2,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  $w,   0,
													  'Nivel 1', 'idLevel_1',  $x22,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0,
													  'Nivel 2', 'idLevel_2',  $x23,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
													  'Nivel 3', 'idLevel_3',  $x24,  1,  'idLevel_3',  'Nombre',  'centrocosto_listado_level_3',  0,   0,
													  'Nivel 4', 'idLevel_4',  $x25,  1,  'idLevel_4',  'Nombre',  'centrocosto_listado_level_4',  0,   0,
													  'Nivel 5', 'idLevel_5',  $x26,  1,  'idLevel_5',  'Nombre',  'centrocosto_listado_level_5',  0,   0,
													  $dbConn, 'form1');

					$Form_Inputs->form_ckeditor('Observaciones','Observaciones', $x27, 1, 2);

					$Form_Inputs->form_input_hidden('idTrabajador', $_GET['id'], 2);
					?>
					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_SueldoLiquido').style.display = 'none';
							document.getElementById('div_SueldoDia').style.display = 'none';
							document.getElementById('div_SueldoHora').style.display = 'none';
							document.getElementById('div_PorcentajeTrabajoPesado').style.display = 'none';
							//se ejecuta al inicio
							LoadTipoContratoTrab(0);
							LoadTipoTrabajo(0);
						});

						/**********************************************************************/
						document.getElementById("idTipoContratoTrab").onchange = function() {LoadTipoContratoTrab(1)};
						document.getElementById("idTipoTrabajo").onchange = function() {LoadTipoTrabajo(1)};

						/**********************************************************************/
						function LoadTipoContratoTrab(caseLoad){
							//obtengo los valores
							let idTipoContratoTrab = $("#idTipoContratoTrab").val();
							//selecciono
							switch(idTipoContratoTrab) {
								//Trabajador con sueldo mensual
								case '1':
									document.getElementById('div_SueldoLiquido').style.display = 'block';
									document.getElementById('div_SueldoDia').style.display = 'none';
									document.getElementById('div_SueldoHora').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="SueldoDia"]').value = '0';
										document.querySelector('input[name="SueldoHora"]').value = '0';
									}
								break;
								//Trabajador con sueldo semanal
								case '2':
									document.getElementById('div_SueldoLiquido').style.display = 'block';
									document.getElementById('div_SueldoDia').style.display = 'none';
									document.getElementById('div_SueldoHora').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="SueldoDia"]').value = '0';
										document.querySelector('input[name="SueldoHora"]').value = '0';
									}
								break;
								//Trabajador con sueldo diario (jornada semanal de 5 días)
								case '3':
									document.getElementById('div_SueldoLiquido').style.display = 'none';
									document.getElementById('div_SueldoDia').style.display = 'block';
									document.getElementById('div_SueldoHora').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="SueldoLiquido"]').value = '0';
										document.querySelector('input[name="SueldoHora"]').value = '0';
									}
								break;
								//Trabajador con sueldo diario (jornada semanal de 6 días)
								case '4':
									document.getElementById('div_SueldoLiquido').style.display = 'none';
									document.getElementById('div_SueldoDia').style.display = 'block';
									document.getElementById('div_SueldoHora').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="SueldoLiquido"]').value = '0';
										document.querySelector('input[name="SueldoHora"]').value = '0';
									}
								break;
								//Trabajador con sueldo por hora
								case '5':
									document.getElementById('div_SueldoLiquido').style.display = 'none';
									document.getElementById('div_SueldoDia').style.display = 'none';
									document.getElementById('div_SueldoHora').style.display = 'block';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="SueldoLiquido"]').value = '0';
										document.querySelector('input[name="SueldoDia"]').value = '0';
									}
								break;
							}
						}

						/**********************************************************************/
						function LoadTipoTrabajo(caseLoad){
							//obtengo los valores
							let idTipoTrabajo = $("#idTipoTrabajo").val();
							//selecciono
							switch(idTipoTrabajo) {
								//Errores Conjuntos
								case '1':
									document.getElementById('div_PorcentajeTrabajoPesado').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="PorcentajeTrabajoPesado"]').value = '0';
									}
								break;
								//Errores Conjuntos
								case '2':
									document.getElementById('div_PorcentajeTrabajoPesado').style.display = 'block';
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
