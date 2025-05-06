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
$original = "licitacion_listado.php";
$location = $original;
$new_location = "licitacion_listado_datos.php";
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
	$form_trabajo= 'updateBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Contrato Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Contrato Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Contrato Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//verifico que sea un administrador
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/*******************************************************/
// consulto los datos
$SIS_query = '
Codigo, Nombre,FechaInicio, FechaTermino, Presupuesto, idBodegaProd, idBodegaIns,
idSistema, idAprobado, idCliente, idTipoLicitacion, ValorMensual, idOpcionItem';
$SIS_join  = '';
$SIS_where = 'idLicitacion = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'licitacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Contrato', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'licitacion_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'licitacion_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'licitacion_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if(isset($rowData['idOpcionItem'])&&$rowData['idOpcionItem']==1){ ?>
							<li class=""><a href="<?php echo 'licitacion_listado_itemizado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sitemap" aria-hidden="true"></i> Itemizado</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'licitacion_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class=""><a href="<?php echo 'licitacion_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>
					</ul>
				</li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idCliente)){             $x1  = $idCliente;           }else{$x1  = $rowData['idCliente'];}
					if(isset($Codigo)){                $x2  = $Codigo;              }else{$x2  = $rowData['Codigo'];}
					if(isset($Nombre)){                $x3  = $Nombre;              }else{$x3  = $rowData['Nombre'];}
					if(isset($FechaInicio)){           $x4  = $FechaInicio;         }else{$x4  = $rowData['FechaInicio'];}
					if(isset($FechaTermino)){          $x5  = $FechaTermino;        }else{$x5  = $rowData['FechaTermino'];}
					if(isset($idTipoLicitacion)){      $x6  = $idTipoLicitacion;    }else{$x6  = $rowData['idTipoLicitacion'];}
					if(isset($ValorMensual)){          $x7  = $ValorMensual;        }else{$x7  = $rowData['ValorMensual'];}
					if(isset($Presupuesto)){           $x8  = $Presupuesto;         }else{$x8  = $rowData['Presupuesto'];}
					if(isset($idBodegaProd)){          $x9  = $idBodegaProd;        }else{$x9  = $rowData['idBodegaProd'];}
					if(isset($idBodegaIns)){           $x10 = $idBodegaIns;         }else{$x10 = $rowData['idBodegaIns'];}
					if(isset($idOpcionItem)){          $x11 = $idOpcionItem;        }else{$x11 = $rowData['idOpcionItem'];}
					if(isset($idAprobado)){            $x12 = $idAprobado;          }else{$x12 = $rowData['idAprobado'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 2, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x3, 2);
					$Form_Inputs->form_date('Fecha de Inicio Contrato','FechaInicio', $x4, 1);
					$Form_Inputs->form_date('Fecha de Termino Contrato','FechaTermino', $x5, 1);
					$Form_Inputs->form_select('Tipo Contrato','idTipoLicitacion', $x6, 2, 'idTipoLicitacion', 'Nombre', 'core_licitacion_tipos', 0, '', $dbConn);
					$Form_Inputs->form_values('Valor Fijo Mensual', 'ValorMensual', $x7, 1);
					$Form_Inputs->form_values('Presupuesto', 'Presupuesto', $x8, 1);
					$Form_Inputs->form_select('Bodega Productos','idBodegaProd', $x9, 2, 'idBodega', 'Nombre', 'bodegas_productos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Bodega Insumos','idBodegaIns', $x10, 2, 'idBodega', 'Nombre', 'bodegas_insumos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Utilizar Itemizado','idOpcionItem', $x11, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Estado Aprobacion','idAprobado', $x12, 2, 'idEstado', 'Nombre', 'core_estado_aprobacion', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idLicitacion', $_GET['id'], 2);

					?>
					<script>
						document.getElementById('div_ValorMensual').style.display = 'none';
						document.getElementById('div_Presupuesto').style.display = 'none';

						$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)

							let TipoLicitacion_val= $("#idTipoLicitacion").val();

							//si es A suma Alzada
							if(TipoLicitacion_val == 1){
								document.getElementById('div_ValorMensual').style.display = '';
								document.getElementById('div_Presupuesto').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="Presupuesto"]').value = '0';

							//si es Por Itemizado
							} else if(TipoLicitacion_val == 2){
								document.getElementById('div_ValorMensual').style.display = 'none';
								document.getElementById('div_Presupuesto').style.display = '';
								//Reseteo los valores a 0
								document.querySelector('input[name="ValorMensual"]').value = '0';

							}

						});

						$("#idTipoLicitacion").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected1 = $(this).val(); //Asignamos el valor seleccionado

							//si es A suma Alzada
							if(modelSelected1 == 1){
								document.getElementById('div_ValorMensual').style.display = '';
								document.getElementById('div_Presupuesto').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="Presupuesto"]').value = '0';

							//si es Por Itemizado
							} else if(modelSelected1 == 2){
								document.getElementById('div_ValorMensual').style.display = 'none';
								document.getElementById('div_Presupuesto').style.display = '';
								//Reseteo los valores a 0
								document.querySelector('input[name="ValorMensual"]').value = '0';

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
