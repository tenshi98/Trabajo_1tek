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
$original = "cross_solicitud_aplicacion_cerrar_cuartel.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$_GET['view'];
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se cierra un trabajo
if (!empty($_POST['submit_close_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_close_Cuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_add_detalle'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_adddetalle';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['not_closecuartel'])){ $error['not_closecuartel'] = 'sucess/Cuartel cerrado correctamente';}
if (isset($_GET['not_adddetalle'])){   $error['not_adddetalle']   = 'sucess/Detalle agregado correctamente';}

//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
if(isset($error1)&&$error1!=''){echo notifications_list($error1);};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['addDetalle'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Detalle</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Observacion)){      $x1  = $Observacion;        }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Observacion','Observacion', $x1, 1);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_add_detalle">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['lock_cuartel'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Cerrar Cuartel</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($f_cierre)){          $x1  = $f_cierre;         }else{$x1  = '';}
					if(isset($idEjecucion)){       $x2  = $idEjecucion;      }else{$x2  = '';}
					if(isset($GeoDistance)){       $x3  = $GeoDistance;      }elseif(isset($_GET['distancia'])&&$_GET['distancia']!=''){$x3  = Cantidades(($_GET['distancia']/1000), 0);}else{$x3  = '';}
					if(isset($VelPromedio)){       $x4  = $VelPromedio;      }else{$x4  = '';}
					if(isset($LitrosAplicados)){   $x5  = $LitrosAplicados;  }else{$x5  = '';}
					//if(isset($T_Aplicacion)){      $x6  = $T_Aplicacion;     }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha Cierre Cuartel','f_cierre', $x1, 2);
					$Form_Inputs->form_select('Ejecucion','idEjecucion', $x2, 2, 'idEjecucion', 'Nombre', 'core_estado_ejecucion', 0, '', $dbConn);
					$Form_Inputs->form_input_number_spinner('Distancia Recorrida Km','GeoDistance', $x3, 0, 500000, '0.1', 1, 1);
					$Form_Inputs->form_input_number_spinner('Vel. Promedio Tractor Km/hr','VelPromedio', $x4, 0, 50, '0.1', 1, 1);
					$Form_Inputs->form_input_number_spinner('Litros Aplicados','LitrosAplicados', $x5, 0, 50000, '0.1', 1, 1);
					//$Form_Inputs->form_time('Tiempo de Aplicacion','T_Aplicacion', $x6, 1, 1);

					$Form_Inputs->form_input_hidden('idCuarteles', $_GET['lock_cuartel'], 2);
					$Form_Inputs->form_input_hidden('f_ejecucion', $_GET['f_ejecucion'], 2);
					$Form_Inputs->form_input_hidden('f_ejecucion_fin', $_GET['f_ejecucion_fin'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<script>
						document.getElementById('div_GeoDistance').style.display = 'none';
						document.getElementById('div_VelPromedio').style.display = 'none';
						document.getElementById('div_LitrosAplicados').style.display = 'none';
						//document.getElementById('div_T_Aplicacion').style.display = 'none';

						$("#idEjecucion").on("change", function(){ //se ejecuta al cambiar valor del select
							let idEjecucion = $(this).val(); //Asignamos el valor seleccionado

							//No ejecutado
							if(idEjecucion == 1){
								document.getElementById('div_GeoDistance').style.display = '';
								document.getElementById('div_VelPromedio').style.display = '';
								document.getElementById('div_LitrosAplicados').style.display = '';

							//Para el resto
							} else {
								document.getElementById('div_GeoDistance').style.display = 'none';
								document.getElementById('div_VelPromedio').style.display = 'none';
								document.getElementById('div_LitrosAplicados').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="GeoDistance"]').value = '0';
								document.querySelector('input[name="VelPromedio"]').value = '0';
								document.querySelector('input[name="LitrosAplicados"]').value = '0';
							}
						});

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_close_cuartel">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************/
	// consulto los datos
	$SIS_query = 'idEstado, f_ejecucion, f_ejecucion_fin';
	$SIS_join  = '';
	$SIS_where = 'idSolicitud = '.$_GET['view'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************/
	//Cuarteles
	$SIS_query = '
	cross_solicitud_aplicacion_listado_cuarteles.idCuarteles,
	cross_solicitud_aplicacion_listado_cuarteles.Mojamiento,
	cross_solicitud_aplicacion_listado_cuarteles.VelTractor,
	cross_solicitud_aplicacion_listado_cuarteles.VelViento,
	cross_solicitud_aplicacion_listado_cuarteles.TempMin,
	cross_solicitud_aplicacion_listado_cuarteles.TempMax,
	cross_solicitud_aplicacion_listado_cuarteles.HumTempMax,
	cross_solicitud_aplicacion_listado_cuarteles.idEstado,
	cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
	cross_predios_listado_zonas.Nombre AS CuartelNombre,
	cross_predios_listado_zonas.Plantas AS CuartelNPlantas,
	cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
	sistema_variedades_categorias.Nombre AS CuartelEspecie,
	variedades_listado.Nombre AS CuartelVariedad';
	$SIS_join  = '
	LEFT JOIN `cross_predios_listado_zonas`    ON cross_predios_listado_zonas.idZona         = cross_solicitud_aplicacion_listado_cuarteles.idZona
	LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_solicitud_aplicacion_listado_cuarteles.idCategoria
	LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_solicitud_aplicacion_listado_cuarteles.idProducto';
	$SIS_where = 'cross_solicitud_aplicacion_listado_cuarteles.idSolicitud ='.$_GET['view'];
	$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
	$arrCuarteles = array();
	$arrCuarteles = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_cuarteles', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCuarteles');

	/*****************************************/
	// Se trae un listado con el historial
	$SIS_query = '
	cross_solicitud_aplicacion_listado_historial.Creacion_fecha,
	cross_solicitud_aplicacion_listado_historial.Observacion,
	usuarios_listado.Nombre AS Usuario,
	core_estado_solicitud.Nombre AS Estado';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario      = cross_solicitud_aplicacion_listado_historial.idUsuario
	LEFT JOIN `core_estado_solicitud`    ON core_estado_solicitud.idEstado  = cross_solicitud_aplicacion_listado_historial.idEstado';
	$SIS_where = 'cross_solicitud_aplicacion_listado_historial.idSolicitud ='.$_GET['view'];
	$SIS_order = 'cross_solicitud_aplicacion_listado_historial.idHistorial ASC';
	$arrHistorial = array();
	$arrHistorial = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrHistorial');

	?>

	<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive" style="margin-bottom:30px">

		<div id="page-wrap">
			<div id="header"> SOLICITUD DE APLICACIONES N° <?php echo n_doc($_GET['view'], 5); ?></div>

			<table id="items">
				<tbody>

					<tr>
						<th colspan="8">Detalle</th>
						<th width="160">Acciones</th>
					</tr>

					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td><strong>Cuarteles</strong></td>
						<td><strong>Variedad - Especie</strong></td>
						<td><strong>Mojamiento</strong></td>
						<td><strong>Vel. Tractor</strong></td>
						<td><strong>Vel. Viento</strong></td>
						<td><strong>Temp Min</strong></td>
						<td><strong>Temp Max</strong></td>
						<td><strong>Hum Temp Max</strong></td>
						<td></td>

					</tr>
					<?php
					//recorro el lsiatdo entregado por la base de datos
					if ($arrCuarteles!=false && !empty($arrCuarteles) && $arrCuarteles!='') {
						foreach ($arrCuarteles as $cuartel) { ?>

							<tr class="item-row linea_punteada" style="background: #eee;">
								<td class="item-name"><?php echo $cuartel['CuartelNombre'];if(isset($cuartel['idEstado'])&&$cuartel['idEstado']==2){ echo '(Cerrado el '.fecha_estandar($cuartel['f_cierre']).')';} ?></td>
								<td class="item-name"><?php echo $cuartel['CuartelEspecie'].' '.$cuartel['CuartelVariedad']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['Mojamiento']).' L/ha'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['VelTractor']).' Km/hr'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['VelViento']).' Km/hr'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['TempMin']).' °'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['TempMax']).' °'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['HumTempMax']).' %'; ?></td>
								<td>
									<div class="btn-group" style="width: 100px;" >
										<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']!=3&&isset($cuartel['idEstado'])&&$cuartel['idEstado']==1){ ?>
											<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==2){
												$distancia = $cuartel['CuartelDistanciaPlant']*$cuartel['CuartelNPlantas'];
												?>
												<a href="<?php echo $location.'&lock_cuartel='.$cuartel['idCuarteles'].'&f_ejecucion='.$rowData['f_ejecucion'].'&f_ejecucion_fin='.$rowData['f_ejecucion_fin'].'&distancia='.$distancia; ?>" title="Cerrar Cuartel" class="btn btn-danger btn-sm tooltip"><i class="fa fa-lock" aria-hidden="true"></i> Cerrar</a>
											<?php } ?>
										<?php } ?>
									</div>
								</td>
							</tr>
					<?php
						}
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="9">No hay cuarteles asignados</td></tr>';
					} ?>
				</tbody>
			</table>
			<div class="clearfix"></div>

		</div>

		<div id="page-wrap">
			<table id="items" style="margin-bottom: 20px;">
				<tbody>

					<tr class="invoice-total" bgcolor="#f1f1f1">
						<th colspan="8">Detalles</th>
						<th width="160"><a href="<?php echo $location.'&idEstado='.$rowData['idEstado'].'&addDetalle=true' ?>" title="Agregar Detalle" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Detalle</a></th>
					</tr>
					<tr>
						<th width="160">Fecha</th>
						<th width="160">Estado</th>
						<th width="260">Usuario</th>
						<th colspan="6">Observacion</th>
					</tr>

					<?php foreach ($arrHistorial as $doc){ ?>
						<tr class="item-row">
							<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
							<td><?php echo $doc['Estado']; ?></td>
							<td><?php echo $doc['Usuario']; ?></td>
							<td colspan="6"><?php echo $doc['Observacion']; ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>

	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
		<a href="cross_solicitud_aplicacion_ejecucion.php?pagina=1" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
