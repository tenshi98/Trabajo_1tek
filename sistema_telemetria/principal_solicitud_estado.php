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
$original = "principal_solicitud_estado.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
/**********************************************************/
//Variable de busqueda
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado_cuarteles.idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_programacion BETWEEN '".$_GET['f_programacion_desde']."' AND '".$_GET['f_programacion_hasta']."'";
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_ejecucion BETWEEN '".$_GET['f_ejecucion_desde']."' AND '".$_GET['f_ejecucion_hasta']."'";
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_termino BETWEEN '".$_GET['f_termino_desde']."' AND '".$_GET['f_termino_hasta']."'";
}
			
/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
sistema_variedades_categorias.Nombre AS EspecieNombre,
variedades_listado.Nombre AS VariedadNombre,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_solicitud_aplicacion_listado_cuarteles.idEstado,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
cross_solicitud_aplicacion_listado.Mojamiento, 
cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
cross_solicitud_aplicacion_listado_cuarteles.idCuarteles AS ID_1,
(SELECT AVG(NULLIF(IF(GeoVelocidadProm!=0,GeoVelocidadProm,0),0)) FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS VelPromedio,
(SELECT SUM(Diferencia)                                           FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS LitrosAplicados';
$SIS_join  = '
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona';
$SIS_order = 'cross_solicitud_aplicacion_listado.idSolicitud ASC';
$arrSolicitudes = array();
$arrSolicitudes = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSolicitudes');

//Se trae un listado con los productos	
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
telemetria_listado.Nombre AS TelemetriaNombre,
vehiculos_listado.Nombre AS VehiculoNombre,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Diferencia';
$SIS_join  = '
LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                            = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                               = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles   = cross_solicitud_aplicacion_listado_tractores.idCuarteles';
$SIS_where.= ' AND cross_solicitud_aplicacion_listado_tractores.Diferencia!=0 GROUP BY cross_solicitud_aplicacion_listado.idSolicitud, cross_solicitud_aplicacion_listado_cuarteles.idZona, cross_solicitud_aplicacion_listado_tractores.idTelemetria, cross_solicitud_aplicacion_listado_tractores.idVehiculo';
$SIS_order = 'cross_solicitud_aplicacion_listado_cuarteles.idZona ASC, telemetria_listado.Nombre ASC';
$arrTracxCuartel = array();
$arrTracxCuartel = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTracxCuartel');
							
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen de Solicitudes de Aplicacion</h5>
		</header>

			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable" style="white-space: nowrap;">
					<thead>
						<tr role="row">
							<th>Especie - Variedad</th>
							<th>Numero de solicitud</th>
							<th>Cuarteles</th>
							<th>Veloc. Promedio</th>
							<th>Mojamiento solicitado</th>
							<th>lts. Aplicados</th>
							<th>Mojamiento Real</th>
							<th>% Mojamiento</th>
							<th>Vehiculos involucrados</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$VelPromedio      = 0;
						$Mojamiento       = 0;
						$MojamientoReal   = 0;
						$LitrosAplicados  = 0;
						$s_count          = 0;
						//recorro
						foreach ($arrSolicitudes as $temp) {
							//calculo de los litros por hectarea
							if(isset($temp['CuartelHectareas'])&&$temp['CuartelHectareas']!=''&&$temp['CuartelHectareas']!=0){
								$litrosxhectarea = $temp['LitrosAplicados'] / $temp['CuartelHectareas'];
							}else{
								$litrosxhectarea = 0;
							} 
							//Operaciones
							$VelPromedio      = $VelPromedio + $temp['VelPromedio'];
							$Mojamiento       = $Mojamiento + $temp['Mojamiento'];
							$MojamientoReal   = $MojamientoReal + $litrosxhectarea;
							$LitrosAplicados  = $LitrosAplicados + $temp['LitrosAplicados'];
							//cuento
							$s_count++;
							?>
											
							<tr class="odd">
								<td><?php echo $temp['EspecieNombre'].' - '.$temp['VariedadNombre']; ?></td>
								<td><?php echo $temp['NSolicitud']; ?></td>
								<td><?php echo $temp['CuartelNombre'];if(isset($temp['idEstado'])&&$temp['idEstado']==2){ echo ' (Cerrado el '.fecha_estandar($temp['f_cierre']).')';} ?></td>
								<td><?php echo Cantidades($temp['VelPromedio'],1); ?></td>
								<td><?php echo Cantidades($temp['Mojamiento'],0); ?></td>
								<td><?php echo Cantidades($temp['LitrosAplicados'],1); ?></td>
								<td><?php echo Cantidades($litrosxhectarea,1); ?></td>
								<td><?php if($litrosxhectarea!=0){echo porcentaje($litrosxhectarea/$temp['Mojamiento']);}else{ echo '0 %';} ?></td>
								<td>	
									<?php 
									if ($arrTracxCuartel!=false && !empty($arrTracxCuartel) && $arrTracxCuartel!='') {
										$zxc = 0;
										foreach ($arrTracxCuartel as $tract) {
											if($temp['idZona']==$tract['idZona']&&$temp['idSolicitud']==$tract['idSolicitud']){
												if($zxc!=0){echo ' - ';}
												echo $tract['TelemetriaNombre'];
												$zxc++;
											}
										}
									}
									?>	
								</td>

								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo 'view_solicitud_aplicacion_finalizada.php?view='.simpleEncode($temp['idSolicitud'], fecha_actual()).'&idZona='.simpleEncode($temp['idZona'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Cuartel Cerrado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($temp['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud Aplicacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php } ?>

						<tr class="odd">
							<td><strong>Totales</strong></td>
							<td></td>
							<td></td>
							<td><strong><?php if($s_count!=0){echo Cantidades($VelPromedio/$s_count,1);}else{echo '0';} ?></strong></td>
							<td><strong><?php if($s_count!=0){echo Cantidades($Mojamiento/$s_count,0);}else{echo '0';} ?></strong></td>
							<td><strong><?php echo Cantidades($LitrosAplicados,1); ?></strong></td>
							<td><strong><?php if($s_count!=0){echo Cantidades($MojamientoReal/$s_count,1);}else{echo '0';} ?></strong></td>
							<td><strong><?php if($MojamientoReal!=0){echo porcentaje($MojamientoReal/$Mojamiento);}else{ echo '0 %';} ?></td>
							<td></td>
							<td></td>
						</tr>         
					</tbody>
				</table>
			</div>

		
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}
$y = "idEstado=1";
$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
 	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idPredio)){              $x1  = $idPredio;               }else{$x1  = '';}
				if(isset($idZona)){                $x2  = $idZona;                 }else{$x2  = '';}
				if(isset($idTemporada)){           $x3  = $idTemporada;            }else{$x3  = '';}
				if(isset($idEstado)){              $x4  = $idEstado;               }else{$x4  = '';}
				if(isset($f_programacion_desde)){  $x5  = $f_programacion_desde;   }else{$x5  = '';}
				if(isset($f_programacion_hasta)){  $x6  = $f_programacion_hasta;   }else{$x6  = '';}
				if(isset($f_ejecucion_desde)){     $x7  = $f_ejecucion_desde;      }else{$x7  = '';}
				if(isset($f_ejecucion_hasta)){     $x8  = $f_ejecucion_hasta;      }else{$x8  = '';}
				if(isset($f_termino_desde)){       $x9  = $f_termino_desde;        }else{$x9  = '';}
				if(isset($f_termino_hasta)){       $x10 = $f_termino_hasta;        }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x1, 2, 'idPredio', 'Nombre', 'cross_predios_listado', $x, 0,
										 'Cuarteles','idZona', $x2, 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select_filter('Temporada','idTemporada', $x3, 2, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x4, 1, 'idEstado', 'Nombre', 'core_estado_solicitud', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programada Desde','f_programacion_desde', $x5, 1);
				$Form_Inputs->form_date('Fecha Programada Hasta','f_programacion_hasta', $x6, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Desde','f_ejecucion_desde', $x7, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Hasta','f_ejecucion_hasta', $x8, 1);
				$Form_Inputs->form_date('Fecha Terminada Desde','f_termino_desde', $x9, 1);
				$Form_Inputs->form_date('Fecha Terminada Hasta','f_termino_hasta', $x10, 1);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
