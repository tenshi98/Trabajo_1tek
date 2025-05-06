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
$original = "clientes_listado.php";
$location = $original;
$new_location = "clientes_listado_datos.php";
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
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/clientes_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Cliente Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Cliente Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Cliente Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*******************************************************/
// consulto los datos
$SIS_query = '
idTipo, Nombre,Contrato_Nombre,Contrato_Numero, Contrato_idPeriodo, Contrato_Fecha_Ini,
Contrato_Fecha_Term, Contrato_N_Meses, Contrato_Representante_Legal, Contrato_Representante_Rut, Contrato_Representante_Fono,
Contrato_Valor_Mensual, Contrato_Valor_Anual, Contrato_UF_Instalacion, Contrato_UF_Mensual, idTab_1,
idTab_2, idTab_3, idTab_4, idTab_5, idTab_6, idTab_7, idTab_8, idTab_9, idTab_10, idTab_11, idTab_12,
idTab_13, idTab_14, idTab_15, Contrato_Obs';
$SIS_join  = '';
$SIS_where = 'idCliente = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/*******************************************/
//Listado con los tabs
$arrHistorial = array();
$arrHistorial = db_select_array (false, 'clientes_listado_historial_contratos.Creacion_fecha, clientes_listado_historial_contratos.Observacion, usuarios_listado.Nombre AS NombreUsuario', 'clientes_listado_historial_contratos', 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = clientes_listado_historial_contratos.idUsuario', 'clientes_listado_historial_contratos.idCliente='.$_GET['id'], 'clientes_listado_historial_contratos.Creacion_fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrHistorial');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Cliente', $rowData['Nombre'], 'Editar Datos Contrato'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'clientes_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'clientes_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'clientes_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'clientes_listado_datos_persona_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<?php if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
							<li class=""><a href="<?php echo 'clientes_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'clientes_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class="active"><a href="<?php echo 'clientes_listado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Contrato</a></li>
						<li class=""><a href="<?php echo 'clientes_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class=""><a href="<?php echo 'clientes_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>
						<li class=""><a href="<?php echo 'clientes_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Contrato_Nombre)){               $x1   = $Contrato_Nombre;                 }else{$x1   = $rowData['Contrato_Nombre'];}
					if(isset($Contrato_Numero)){               $x2   = $Contrato_Numero;                 }else{$x2   = $rowData['Contrato_Numero'];}
					if(isset($Contrato_idPeriodo)){            $x3   = $Contrato_idPeriodo;              }else{$x3   = $rowData['Contrato_idPeriodo'];}
					if(isset($Contrato_Fecha_Ini)){            $x4   = $Contrato_Fecha_Ini;              }else{$x4   = $rowData['Contrato_Fecha_Ini'];}
					if(isset($Contrato_Fecha_Term)){           $x5   = $Contrato_Fecha_Term;             }else{$x5   = $rowData['Contrato_Fecha_Term'];}
					if(isset($Contrato_N_Meses)){              $x6   = $Contrato_N_Meses;                }else{$x6   = $rowData['Contrato_N_Meses'];}
					if(isset($Contrato_Representante_Legal)){  $x7   = $Contrato_Representante_Legal;    }else{$x7   = $rowData['Contrato_Representante_Legal'];}
					if(isset($Contrato_Representante_Rut)){    $x8   = $Contrato_Representante_Rut;      }else{$x8   = $rowData['Contrato_Representante_Rut'];}
					if(isset($Contrato_Representante_Fono)){   $x9   = $Contrato_Representante_Fono;     }else{$x9   = $rowData['Contrato_Representante_Fono'];}
					if(isset($Contrato_Valor_Mensual)){        $x10  = $Contrato_Valor_Mensual;          }else{$x10  = Cantidades_decimales_justos($rowData['Contrato_Valor_Mensual']);}
					if(isset($Contrato_Valor_Anual)){          $x11  = $Contrato_Valor_Anual;            }else{$x11  = Cantidades_decimales_justos($rowData['Contrato_Valor_Anual']);}
					if(isset($Contrato_UF_Instalacion)){       $x12  = $Contrato_UF_Instalacion;         }else{$x12  = Cantidades_decimales_justos($rowData['Contrato_UF_Instalacion']);}
					if(isset($Contrato_UF_Mensual)){           $x13  = $Contrato_UF_Mensual;             }else{$x13  = Cantidades_decimales_justos($rowData['Contrato_UF_Mensual']);}
					if(isset($idTab_1)){                       $x14  = $idTab_1;                         }else{$x14  = $rowData['idTab_1'];}
					if(isset($idTab_2)){                       $x14 .= ','.$idTab_2;                     }else{$x14 .= ','.$rowData['idTab_2'];}
					if(isset($idTab_3)){                       $x14 .= ','.$idTab_3;                     }else{$x14 .= ','.$rowData['idTab_3'];}
					if(isset($idTab_4)){                       $x14 .= ','.$idTab_4;                     }else{$x14 .= ','.$rowData['idTab_4'];}
					if(isset($idTab_5)){                       $x14 .= ','.$idTab_5;                     }else{$x14 .= ','.$rowData['idTab_5'];}
					if(isset($idTab_6)){                       $x14 .= ','.$idTab_6;                     }else{$x14 .= ','.$rowData['idTab_6'];}
					if(isset($idTab_7)){                       $x14 .= ','.$idTab_7;                     }else{$x14 .= ','.$rowData['idTab_7'];}
					if(isset($idTab_8)){                       $x14 .= ','.$idTab_8;                     }else{$x14 .= ','.$rowData['idTab_8'];}
					if(isset($idTab_9)){                       $x14 .= ','.$idTab_9;                     }else{$x14 .= ','.$rowData['idTab_9'];}
					if(isset($idTab_10)){                      $x14 .= ','.$idTab_10;                    }else{$x14 .= ','.$rowData['idTab_10'];}
					if(isset($idTab_11)){                      $x14 .= ','.$idTab_11;                    }else{$x14 .= ','.$rowData['idTab_11'];}
					if(isset($idTab_12)){                      $x14 .= ','.$idTab_12;                    }else{$x14 .= ','.$rowData['idTab_12'];}
					if(isset($idTab_13)){                      $x14 .= ','.$idTab_13;                    }else{$x14 .= ','.$rowData['idTab_13'];}
					if(isset($idTab_14)){                      $x14 .= ','.$idTab_14;                    }else{$x14 .= ','.$rowData['idTab_14'];}
					if(isset($idTab_15)){                      $x14 .= ','.$idTab_15;                    }else{$x14 .= ','.$rowData['idTab_15'];}

					if(isset($Contrato_Obs)){                  $x15  = $Contrato_Obs;                    }else{$x15  = $rowData['Contrato_Obs'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_input_text('Nombre del Contrato', 'Contrato_Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Numero o Codigo del Contrato', 'Contrato_Numero', $x2, 1);
					$Form_Inputs->form_select('Renovación/finalización','Contrato_idPeriodo', $x3, 1, 'idPeriodo', 'Nombre', 'core_cross_cliente', 0, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Duracion');
					$Form_Inputs->form_date('Fecha inicio Contrato','Contrato_Fecha_Ini', $x4, 1);
					$Form_Inputs->form_date('Fecha termino Contrato','Contrato_Fecha_Term', $x5, 1);
					$Form_Inputs->form_select_n_auto('Duracion Contrato(Meses)','Contrato_N_Meses', $x6, 1, 1, 72);

					$Form_Inputs->form_tittle(3, 'Representante Legal');
					$Form_Inputs->form_input_text('Nombre', 'Contrato_Representante_Legal', $x7, 1);
					$Form_Inputs->form_input_rut('Rut', 'Contrato_Representante_Rut', $x8, 1);
					$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
					$Form_Inputs->form_input_phone('Fono', 'Contrato_Representante_Fono', $x9, 1);

					$Form_Inputs->form_tittle(3, 'Valores');
					$Form_Inputs->form_values('Valor Mensual', 'Contrato_Valor_Mensual', $x10, 1);
					$Form_Inputs->form_values('Valor Anual', 'Contrato_Valor_Anual', $x11, 1);
					$Form_Inputs->form_input_number('Valor UF instalacion', 'Contrato_UF_Instalacion', $x12, 1);
					$Form_Inputs->form_input_number('Valor UF servicio mensual', 'Contrato_UF_Mensual', $x13, 1);

					//Solo para plataforma Intranet
					if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==7){
						$Form_Inputs->form_tittle(3, 'Servicios');
						$Form_Inputs->form_checkbox_active('Unidad de Negocio','idTab', $x14, 1, 2, 'idTab', 'Nombre', 'core_telemetria_tabs', 0, $dbConn);
					}

					$Form_Inputs->form_ckeditor('Observaciones','Contrato_Obs', $x15, 1, 2);

					$Form_Inputs->form_input_hidden('idCliente', $_GET['id'], 2);
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

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">

	<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="3">Historial</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th>Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['NombreUsuario']; ?></td>
						<td><?php echo $doc['Observacion']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>

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
